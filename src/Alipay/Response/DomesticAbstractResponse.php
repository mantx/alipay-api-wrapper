<?php


namespace Alipay\Response;


use Alipay\AlipayClient;

abstract class DomesticAbstractResponse extends AbstractResponse
{
    private static $params = [
        //Business Parameter
        'code'     => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '网关返回码,详见文档',
            'maxLength' => 32
        ],
        'msg'      => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '网关返回码描述,详见文档',
        ],
        'sub_code' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '业务返回码，参见具体的API接口文档',
        ],
        'sub_msg'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '业务返回码描述，参见具体的API接口文档',
        ]
    ];


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }

    public function getSignContent()
    {
        return $this->parserJSONSignSource($this->getDataEntityNodeInResponse(),
            $this->rawBody);
    }


    function parserJSONSignSource($rootNodeName, $responseContent)
    {
        $rootIndex = strpos($responseContent, $rootNodeName);

        if ($rootIndex > 0) {
            return $this->parserJSONSource($responseContent, $rootNodeName, $rootIndex);
        } else {
            return null;
        }
    }

    function parserJSONSource($responseContent, $nodeName, $nodeIndex)
    {
        $signDataStartIndex = $nodeIndex + strlen($nodeName) + 2;
        $signIndex          = strpos($responseContent, "\"" . AlipayClient::SIGN_NODE_NAME . "\"");
        // 签名前-逗号
        $signDataEndIndex = $signIndex - 1;
        $indexLen         = $signDataEndIndex - $signDataStartIndex;
        if ($indexLen < 0) {
            return null;
        }

        return substr($responseContent, $signDataStartIndex, $indexLen);
    }
}