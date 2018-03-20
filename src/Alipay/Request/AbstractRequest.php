<?php

namespace Alipay\Request;

class AbstractRequest
{
    private static $params = [
        'sign'           => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength'    => '10',
            'defaultValue' => ''
        ],
        'sign_type'      => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        'service'        => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        'partner'        => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            'length'       => '16',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        '_input_charset' => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'GBK'
        ],
    ];

    public function getRequestParams()
    {
        return self::$params;
    }

    public function validateParams()
    {
        return true;
    }
}