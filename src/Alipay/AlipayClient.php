<?php

namespace Alipay;

use Alipay\Request\AbstractRequest;
use Alipay\Response\AbstractResponse;
use Alipay\Utils\Sign;
use Alipay\Utils\Utility;

class AlipayClient
{
    //网关
    protected $gatewayUrl = "https://openapi.alipay.com/gateway.do";

    const SIGN_NODE_NAME = "sign";
    const SIGN_TYPE_NODE_NAME = "sign_type";
    const STATUS_NODE_NAME = 'is_success';
    const ERROR_NODE_NAME = 'error';

    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function execute($request)
    {
        $apiParams = $request->getRequestParamsWithSign();

        $resp = Utility::curl('https://intlmapi.alipay.com/gateway.do?', $apiParams, $request->getInputCharset());

        $headers = $this->parseResponseHeaders($resp['header']);
        if (stristr($headers['Content-Type'], 'text/json')) {
            $respObject = json_decode($resp['body']);
        } elseif (stristr($headers['Content-Type'], 'text/xml')) {
            $respObject = json_decode(json_encode(@ simplexml_load_string($resp['body'])), true);
        } else {
            return $resp['body'];
        }

        $this->checkReturnStatus($respObject);

        /** @var AbstractResponse $returnResponse */
        $className      = get_class($request);
        $className      = str_replace('Request', 'Response', $className);
        $returnResponse = new $className();
        $returnResponse->initFromResponse($respObject);

        // 验签
        $this->checkResponseSign($returnResponse->getSignContent(),
            $respObject[self::SIGN_NODE_NAME],
            $respObject[self::SIGN_TYPE_NODE_NAME]);

        return $returnResponse;
    }

    protected function parseResponseHeaders($headerString)
    {
        $result  = [];
        $headers = preg_split("/[\r\n]+/", $headerString);
        foreach ($headers as $header) {
            $header = explode(':', $header);
            if ($header) {
                if (count($header) < 2) {
                    if (trim($header[0])) {
                        $result[trim($header[0])] = '';
                    }
                } elseif (trim($header[0])) {
                    $result[trim($header[0])] = trim($header[1]);
                }
            }
        }

        return $result;
    }


    /**
     * 验签
     *
     * @param $request
     * @param $signData
     * @param $resp
     * @param $respObject
     *
     * @throws Exception
     */
    protected function checkResponseSign($signData, $sign, $signType)
    {
        $checkResult = Sign::verify($signData, $sign, $signType);

        if (!$checkResult) {
            throw new \Exception(sprintf('check sign Fail! [type=%s sign=%s signSourceData=%s',
                $signType, $sign, $signData));
        }
    }

    protected function checkReturnStatus($response)
    {
        if ($response[self::STATUS_NODE_NAME] != 'T') {
            throw new \Exception($response[self::ERROR_NODE_NAME]);
        }
    }


}