<?php

namespace Alipay;

use Alipay\Request\AbstractRequest;
use Alipay\Utils\Sign;
use Alipay\Utils\Utility;

class AlipayClient
{
    //网关
    protected $gatewayUrl = "https://openapi.alipay.com/gateway.do";

    protected $SIGN_NODE_NAME = "sign";


    /**
     * @param AbstractRequest $request
     * @param null            $authToken
     * @param null            $appInfoAuthtoken
     *
     * @return bool|mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public function execute(AbstractRequest $request)
    {
        $apiParams = $request->getRequestParamsWithSign();

        $resp = Utility::curl('https://intlmapi.alipay.com/gateway.do', $apiParams, $request->getInputCharset());

        $headers = $this->parseResponseHeaders($resp['header']);
        if (stristr($headers['Content-Type'], 'text/json')) {
            $respObject = json_decode($resp['body']);
        } elseif (stristr($headers['Content-Type'], 'text/xml')) {
            $respObject = json_decode(json_encode(@ simplexml_load_string($resp['body'])), true);
        } else {
            $respObject = $resp['body'];
        }

        // 验签
//        $this->checkResponseSign($request, $signData, $resp, $respObject);

        return $respObject;
    }

    protected function parseResponseHeaders($headerString)
    {
        $result  = [];
        $headers = preg_split("/[\r\n]+/", $headerString);
        foreach ($headers as $header) {
            $header = explode(':', $header);
            if ($header) {
                if (count($header) < 1) {
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
    public function checkResponseSign($request, $signData, $resp, $respObject)
    {
        if ($signData == null || $this->checkEmpty($signData->sign) || $this->checkEmpty($signData->signSourceData)) {

            throw new \Exception(" check sign Fail! The reason : signData is Empty");
        }


        // 获取结果sub_code
        $responseSubCode = $this->parserResponseSubCode($request, $resp, $respObject, $this->format);


        if (!$this->checkEmpty($responseSubCode) ||
            ($this->checkEmpty($responseSubCode) && !$this->checkEmpty($signData->sign))
        ) {

            $checkResult = Sign::verify($signData->signSourceData, $signData->sign, $this->signType);


            if (!$checkResult) {

                if (strpos($signData->signSourceData, "\\/") > 0) {

                    $signData->signSourceData = str_replace("\\/", "/", $signData->signSourceData);

                    $checkResult = Sign::rsaVerify($signData->signSourceData, $signData->sign, $this->signType);

                    if (!$checkResult) {
                        throw new \Exception("check sign Fail! [sign=" . $signData->sign . ", signSourceData=" .
                                             $signData->signSourceData . "]");
                    }

                } else {

                    throw new \Exception("check sign Fail! [sign=" . $signData->sign . ", signSourceData=" .
                                         $signData->signSourceData . "]");
                }

            }
        }
    }


}