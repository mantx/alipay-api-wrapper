<?php


namespace Alipay\Response;


use Alipay\Utils\Utility;

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
}