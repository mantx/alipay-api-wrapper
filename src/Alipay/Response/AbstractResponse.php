<?php

namespace Alipay\Request;

use Alipay\Datatype\Base;
use Alipay\Utils\Sign;
use Alipay\Utils\Utility;

abstract class AbstractResponse extends Base
{
    private static $params = [
        'sign'           => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'See the “Digital Signature”',
            'defaultValue' => ''
        ],
        'sign_type'      => [
            'type'         => 'string',
            'required'     => true,
            'enumeration'  => 'DSA, RSA, RSA2, MD5',
            'comment'      => 'Four values, namely, DSA, RSA, RSA2 and MD5 can be chosen; and must be capitalized',
            'defaultValue' => 'RSA'
        ],
        '_input_charset' => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => 'The encoding format in merchant website such as utf-8, gbk and gb2312',
            'defaultValue' => 'UTF-8'
        ],
    ];


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}