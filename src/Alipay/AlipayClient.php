<?php

namespace Alipay;

use Alipay\Request\AbstractRequest;
use Alipay\Request\DomesticAbstractRequest;
use Alipay\Request\GlobalAbstractRequest;
use Alipay\Response\AbstractResponse;
use Alipay\Utils\Config;
use Alipay\Utils\Sign;
use Alipay\Utils\Utility;

class AlipayClient
{
    //网关
    protected $gatewayUrl4Global = [
        'sandbox'    => 'https://openapi.alipaydev.com/gateway.do?',
        'production' => 'https://intlmapi.alipay.com/gateway.do?'
    ];
    protected $gatewayUrl4Domestic = [
        'sandbox'    => 'https://openapi.alipaydev.com/gateway.do?',
        'production' => 'https://openapi.alipay.com/gateway.do?'
    ];

    const SIGN_NODE_NAME = "sign";
    const SIGN_TYPE_NODE_NAME = "sign_type";
    const STATUS_NODE_NAME = 'is_success';
    const ERROR_NODE_NAME = 'error';
    const REQUEST_NODE_NAME = "request";

    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function execute($request)
    {
        $apiParams = $request->getRequestParamsWithSign();

        $resp = Utility::curl($this->getAccessPointUrl($request), $apiParams, Config::getCharset());

        $headers = $this->parseResponseHeaders($resp['header']);
        if (stristr($headers['Content-Type'], 'text/json')) {
            $respObject = json_decode($resp['body'], true);
        } elseif (stristr($headers['Content-Type'], 'text/xml')) {
            $respObject = json_decode(json_encode(@ simplexml_load_string($resp['body'])), true);
        } else {
            if (($request instanceof DomesticAbstractRequest) &&
                (strtolower($request->getFormat()) == 'json')
            ) {
                $respObject = json_decode($resp['body'], true);
            } else {
                return $resp['body'];
            }
        }

        $request->checkResponse($respObject);

        /** @var AbstractResponse $returnResponse */
        $className      = get_class($request);
        $className      = str_replace('Request', 'Response', $className);
        $returnResponse = new $className($resp['body'], $respObject);

        // 验签
        $this->checkResponseSign($returnResponse->getSignContent(),
            Utility::safeGetValue($respObject, self::SIGN_NODE_NAME),
            Utility::safeGetValue($respObject, self::SIGN_TYPE_NODE_NAME, Config::getSignType()));

        return $returnResponse;
    }


    /**
     * @param $request
     *
     * @return array|string
     */
    public function getAccessPointUrl($request)
    {
        $accessPointUrl = $request instanceof GlobalAbstractRequest ?
            $this->gatewayUrl4Global :
            $this->gatewayUrl4Domestic;

        $accessPointUrl = Config::getSandbox() ?
            $accessPointUrl['sandbox'] :
            $accessPointUrl['production'];

        $accessPointUrl .= $request instanceof GlobalAbstractRequest ?
            '_input_charset=' . Config::getCharset() :
            'charset=' . Config::getCharset();

        return $accessPointUrl;
    }

    /**
     * @param $headerString
     *
     * @return array
     */
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


}