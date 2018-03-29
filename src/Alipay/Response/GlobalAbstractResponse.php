<?php


namespace Alipay\Response;


abstract class GlobalAbstractResponse extends AbstractResponse
{
    private static $params = [
        'service' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The interface name',
            'defaultValue' => '',//alipay.commerce.qrcode.create
        ],
        'partner' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The Alipay account generated when signing with Alipay; its length is 16, and it begins with 2088',
            'length'       => '16',
            'defaultValue' => ''
        ],
    ];



}