<?php

namespace Alipay;

use Alipay\Request\AbstractRequest;
use Alipay\Utils\Encrypt;
use Alipay\Utils\EncryptParseItem;
use Alipay\Utils\Sign;
use Alipay\Utils\SignData;

class AlipayClient
{

    public $appId;

    private $fileCharset = "UTF-8";
    //网关
    public $gatewayUrl = "https://openapi.alipay.com/gateway.do";
    //返回数据格式
    public $format = "xml";
    //api版本
    public $apiVersion = "1.0";

    // 表单提交字符集编码
    public $postCharset = "UTF-8";

    //签名类型
    public $signType = "MD5";

    public $encryptKey;

    public $encryptType = "AES";

    private $RESPONSE_SUFFIX = "_response";

    private $ERROR_RESPONSE = "error_response";

    private $SIGN_NODE_NAME = "sign";

    //加密XML节点名称
    private $ENCRYPT_XML_NODE_NAME = "response_encrypted";


    protected function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if ($value === null) {
            return true;
        }
        if (trim($value) === "") {
            return true;
        }

        return false;
    }

    private function setupCharsets($request)
    {
        if ($this->checkEmpty($this->postCharset)) {
            $this->postCharset = 'UTF-8';
        }
        $str               = preg_match('/[\x80-\xff]/', $this->appId) ? $this->appId : print_r($request, true);
        $this->fileCharset = mb_detect_encoding($str, "UTF-8, GBK") == 'UTF-8' ? 'UTF-8' : 'GBK';
    }

    public function generateSign($params, $signType = "RSA")
    {
        return Sign::rsaSign($this->getSignContent($params), $signType);
    }

    public function rsaSign($params, $signType = "RSA")
    {
        return Sign::rsaSign($this->getSignContent($params), $signType);
    }

    public function getSignContent($params)
    {
        $signData = [];
        foreach ($params as $key => $value) {
            if (false === $this->checkEmpty($value) && "@" != substr($value, 0, 1)) {
                // 转换成目标字符集
                $value          = $this->characet($value, $this->postCharset);
                $signData[$key] = $key . '=' . rawurldecode($value);
            }
        }
        ksort($signData);

        return implode('&', $signData);
    }

    /**
     * 转换字符集编码
     *
     * @param $data
     * @param $targetCharset
     *
     * @return string
     */
    function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->fileCharset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }

        return $data;
    }


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
        $this->setupCharsets($request);

        //		//  如果两者编码不一致，会出现签名验签或者乱码
        if (strcasecmp($this->fileCharset, $this->postCharset)) {
            // writeLog("本地文件字符集编码与表单提交编码不一致，请务必设置成一样，属性名分别为postCharset!");
            throw new \Exception("文件编码：[" . $this->fileCharset . "] 与表单提交编码：[" . $this->postCharset . "]两者不一致!");
        }

        $iv = $this->apiVersion;

        $apiParams = $request->getRequestParamsWithSign();

        //发起HTTP请求
        try {
            $resp = $this->curl('https://intlmapi.alipay.com/gateway.do', $apiParams);
        } catch (\Exception $e) {

//            $this->logCommunicationError($sysParams["method"], $requestUrl, "HTTP_ERROR_" . $e->getCode(),
//                $e->getMessage());

            return false;
        }

        //解析AOP返回结果
        $respWellFormed = false;

        // 将返回结果转换本地文件编码
        $r = iconv($this->postCharset, $this->fileCharset . "//IGNORE", $resp);

        $signData = null;

        if ("json" == $this->format) {

            $respObject = json_decode($r);
            if (null !== $respObject) {
                $respWellFormed = true;
                $signData       = $this->parserJSONSignData($request, $resp, $respObject);
            }
        } else {
            if ("xml" == $this->format) {

                $respObject = json_decode(json_encode(@ simplexml_load_string($resp)), true);
                if (false !== $respObject) {
                    $respWellFormed = true;

                    $signData = $this->parserXMLSignData($respObject);
                }
            }
        }

        //返回的HTTP文本不是标准JSON或者XML，记下错误日志
        if (false === $respWellFormed) {
//            $this->logCommunicationError($sysParams["method"], $requestUrl, "HTTP_RESPONSE_NOT_WELL_FORMED", $resp);

            return false;
        }

        // 验签
        $this->checkResponseSign($request, $signData, $resp, $respObject);

        // 解密
        if (method_exists($request, "getNeedEncrypt") && $request->getNeedEncrypt()) {

            if ("json" == $this->format) {


                $resp = $this->encryptJSONSignSource($request, $resp);

                // 将返回结果转换本地文件编码
                $r          = iconv($this->postCharset, $this->fileCharset . "//IGNORE", $resp);
                $respObject = json_decode($r);
            } else {

                $resp = $this->encryptXMLSignSource($request, $resp);

                $r          = iconv($this->postCharset, $this->fileCharset . "//IGNORE", $resp);
                $respObject = @ simplexml_load_string($r);

            }
        }

        return $respObject;
    }

    // 获取加密内容

    private function encryptXMLSignSource($request, $responseContent)
    {

        $parsetItem = $this->parserEncryptXMLSignSource($request, $responseContent);

        $bodyIndexContent = substr($responseContent, 0, $parsetItem->startIndex);
        $bodyEndContent   =
            substr($responseContent, $parsetItem->endIndex, strlen($responseContent) + 1 - $parsetItem->endIndex);
        $bizContent       = Encrypt::decrypt($parsetItem->encryptContent, $this->encryptKey);

        return $bodyIndexContent . $bizContent . $bodyEndContent;

    }

    private function parserEncryptXMLSignSource($request, $responseContent)
    {
        $apiName      = $request->getApiMethodName();
        $rootNodeName = str_replace(".", "_", $apiName) . $this->RESPONSE_SUFFIX;


        $rootIndex  = strpos($responseContent, $rootNodeName);
        $errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);
        //		$this->echoDebug("<br/>rootNodeName:" . $rootNodeName);
        //		$this->echoDebug("<br/> responseContent:<xmp>" . $responseContent . "</xmp>");


        if ($rootIndex > 0) {

            return $this->parserEncryptXMLItem($responseContent, $rootNodeName, $rootIndex);
        } else {
            if ($errorIndex > 0) {

                return $this->parserEncryptXMLItem($responseContent, $this->ERROR_RESPONSE, $errorIndex);
            } else {

                return null;
            }
        }
    }


    private function parserEncryptXMLItem($responseContent, $nodeName, $nodeIndex)
    {

        $signDataStartIndex = $nodeIndex + strlen($nodeName) + 1;

        $xmlStartNode = "<" . $this->ENCRYPT_XML_NODE_NAME . ">";
        $xmlEndNode   = "</" . $this->ENCRYPT_XML_NODE_NAME . ">";

        $indexOfXmlNode = strpos($responseContent, $xmlEndNode);
        if ($indexOfXmlNode < 0) {

            $item                 = new EncryptParseItem();
            $item->encryptContent = null;
            $item->startIndex     = 0;
            $item->endIndex       = 0;

            return $item;
        }

        $startIndex    = $signDataStartIndex + strlen($xmlStartNode);
        $bizContentLen = $indexOfXmlNode - $startIndex;
        $bizContent    = substr($responseContent, $startIndex, $bizContentLen);

        $encryptParseItem                 = new EncryptParseItem();
        $encryptParseItem->encryptContent = $bizContent;
        $encryptParseItem->startIndex     = $signDataStartIndex;
        $encryptParseItem->endIndex       = $indexOfXmlNode + strlen($xmlEndNode);

        return $encryptParseItem;

    }


    function parserJSONSignData($request, $responseContent, $responseJSON)
    {

        $signData = new SignData();

        $signData->sign           = $this->parserJSONSign($responseJSON);
        $signData->signSourceData = $this->parserJSONSignSource($request, $responseContent);


        return $signData;

    }

    function parserJSONSignSource($request, $responseContent)
    {

        $apiName      = $request->getApiMethodName();
        $rootNodeName = str_replace(".", "_", $apiName) . $this->RESPONSE_SUFFIX;

        $rootIndex  = strpos($responseContent, $rootNodeName);
        $errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);


        if ($rootIndex > 0) {

            return $this->parserJSONSource($responseContent, $rootNodeName, $rootIndex);
        } else {
            if ($errorIndex > 0) {

                return $this->parserJSONSource($responseContent, $this->ERROR_RESPONSE, $errorIndex);
            } else {

                return null;
            }
        }
    }

    function parserJSONSource($responseContent, $nodeName, $nodeIndex)
    {
        $signDataStartIndex = $nodeIndex + strlen($nodeName) + 2;
        $signIndex          = strpos($responseContent, "\"" . $this->SIGN_NODE_NAME . "\"");
        // 签名前-逗号
        $signDataEndIndex = $signIndex - 1;
        $indexLen         = $signDataEndIndex - $signDataStartIndex;
        if ($indexLen < 0) {

            return null;
        }

        return substr($responseContent, $signDataStartIndex, $indexLen);
    }

    function parserJSONSign($responseJSon)
    {

        return $responseJSon->sign;
    }

    function parserXMLSignData($response)
    {
        $signData = new SignData();

        $signData->sign           = $response['sign'];
        $signData->signSourceData = $this->getSignContent($response['response']['qrcodeinfo']);

        return $signData;
    }

    function parserResponseSubCode($request, $responseContent, $respObject, $format)
    {

        if ("json" == $format) {

            $apiName       = $request->getApiMethodName();
            $rootNodeName  = str_replace(".", "_", $apiName) . $this->RESPONSE_SUFFIX;
            $errorNodeName = $this->ERROR_RESPONSE;

            $rootIndex  = strpos($responseContent, $rootNodeName);
            $errorIndex = strpos($responseContent, $errorNodeName);

            if ($rootIndex > 0) {
                // 内部节点对象
                $rInnerObject = $respObject->$rootNodeName;
            } elseif ($errorIndex > 0) {

                $rInnerObject = $respObject->$errorNodeName;
            } else {
                return null;
            }

            // 存在属性则返回对应值
            if (isset($rInnerObject->sub_code)) {

                return $rInnerObject->sub_code;
            } else {

                return null;
            }


        } elseif ("xml" == $format) {

            // xml格式sub_code在同一层级
            return $respObject->sub_code;

        }
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


    function parserXMLSignSource($request, $responseContent)
    {


        $apiName      = '';//$request->getApiMethodName();
        $rootNodeName = 'response';//str_replace(".", "_", $apiName) . $this->RESPONSE_SUFFIX;


        $rootIndex  = strpos($responseContent, $rootNodeName);
        $errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);
        //		$this->echoDebug("<br/>rootNodeName:" . $rootNodeName);
        //		$this->echoDebug("<br/> responseContent:<xmp>" . $responseContent . "</xmp>");


        if ($rootIndex > 0) {

            return $this->parserXMLSource($responseContent, $rootNodeName, $rootIndex);
        } else {
            if ($errorIndex > 0) {

                return $this->parserXMLSource($responseContent, $this->ERROR_RESPONSE, $errorIndex);
            } else {

                return null;
            }
        }
    }

    function parserXMLSource($responseContent, $nodeName, $nodeIndex)
    {
        $signDataStartIndex = $nodeIndex;
        $signIndex          = strpos($responseContent, "<" . $this->SIGN_NODE_NAME . ">");
        // 签名前-逗号
        $signDataEndIndex = $signIndex - 1;
        $indexLen         = $signDataEndIndex - $signDataStartIndex + 1;

        if ($indexLen < 0) {
            return null;
        }


        return substr($responseContent, $signDataStartIndex, $indexLen);
    }

    function parserXMLSign($responseContent)
    {
        $signNodeName    = "<" . $this->SIGN_NODE_NAME . ">";
        $signEndNodeName = "</" . $this->SIGN_NODE_NAME . ">";

        $indexOfSignNode    = strpos($responseContent, $signNodeName);
        $indexOfSignEndNode = strpos($responseContent, $signEndNodeName);


        if ($indexOfSignNode < 0 || $indexOfSignEndNode < 0) {
            return null;
        }

        $nodeIndex = ($indexOfSignNode + strlen($signNodeName));

        $indexLen = $indexOfSignEndNode - $nodeIndex;

        if ($indexLen < 0) {
            return null;
        }

        // 签名
        return substr($responseContent, $nodeIndex, $indexLen);
    }


    // 获取加密内容

    private function encryptJSONSignSource($request, $responseContent)
    {

        $parsetItem = $this->parserEncryptJSONSignSource($request, $responseContent);

        $bodyIndexContent = substr($responseContent, 0, $parsetItem->startIndex);
        $bodyEndContent   =
            substr($responseContent, $parsetItem->endIndex, strlen($responseContent) + 1 - $parsetItem->endIndex);

        $bizContent = Encrypt::decrypt($parsetItem->encryptContent, $this->encryptKey);

        return $bodyIndexContent . $bizContent . $bodyEndContent;
    }


    private function parserEncryptJSONSignSource($request, $responseContent)
    {

        $apiName      = $request->getApiMethodName();
        $rootNodeName = str_replace(".", "_", $apiName) . $this->RESPONSE_SUFFIX;

        $rootIndex  = strpos($responseContent, $rootNodeName);
        $errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);


        if ($rootIndex > 0) {

            return $this->parserEncryptJSONItem($responseContent, $rootNodeName, $rootIndex);
        } else {
            if ($errorIndex > 0) {

                return $this->parserEncryptJSONItem($responseContent, $this->ERROR_RESPONSE, $errorIndex);
            } else {

                return null;
            }
        }
    }


    private function parserEncryptJSONItem($responseContent, $nodeName, $nodeIndex)
    {
        $signDataStartIndex = $nodeIndex + strlen($nodeName) + 2;
        $signIndex          = strpos($responseContent, "\"" . $this->SIGN_NODE_NAME . "\"");
        // 签名前-逗号
        $signDataEndIndex = $signIndex - 1;

        if ($signDataEndIndex < 0) {

            $signDataEndIndex = strlen($responseContent) - 1;
        }

        $indexLen = $signDataEndIndex - $signDataStartIndex;

        $encContent = substr($responseContent, $signDataStartIndex + 1, $indexLen - 2);


        $encryptParseItem = new EncryptParseItem();

        $encryptParseItem->encryptContent = $encContent;
        $encryptParseItem->startIndex     = $signDataStartIndex;
        $encryptParseItem->endIndex       = $signDataEndIndex;

        return $encryptParseItem;
    }

    protected function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $postBodyString = "";
        $encodeArray    = Array();
        $postMultipart  = false;


        if (is_array($postFields) && 0 < count($postFields)) {

            foreach ($postFields as $key => $value) {
                if ("@" != substr($value, 0, 1)) //判断是不是文件上传
                {

                    $postBodyString .= "$key=" . urlencode($this->characet($value, $this->postCharset)) . "&";
                    $encodeArray[$key] = $this->characet($value, $this->postCharset);
                } else //文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart     = true;
                    $encodeArray[$key] = new \CURLFile(substr($value, 1));
                }

            }
            unset ($key, $value);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeArray);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }

        if ($postMultipart) {

            $headers = array(
                'content-type: multipart/form-data;charset=' . $this->postCharset . ';boundary=' .
                $this->getMillisecond()
            );
        } else {

            $headers = array('content-type: application/x-www-form-urlencoded;charset=' . $this->postCharset);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $reponse = curl_exec($ch);

        if (curl_errno($ch)) {

            throw new \Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new \Exception($reponse, $httpStatusCode);
            }
        }

        curl_close($ch);

        return $reponse;
    }

    protected function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());

        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

}