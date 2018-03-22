<?php


namespace Alipay\Request;


class GlobalAbstractRequest extends AbstractRequest
{
    private static $params = [
        'service' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            'defaultValue' => 'RSA'
        ],
        'partner' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            'length'       => '16',
            'defaultValue' => 'RSA'
        ],
    ];

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }




}