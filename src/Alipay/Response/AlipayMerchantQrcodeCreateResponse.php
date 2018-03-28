<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeCreateResponse extends GlobalAbstractResponse
{
    private static $params = [
        //basic parameters
        'timestamp'  => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The time ( Beijing Time) of calling the interface, ' .
                              'and the call will expire in a certime time (default 30 minutes). ' .
                              'The time format is ：yyyy-MM-dd HH:mm:ss',
            'defaultValue' => self::DEFAULT_VALUE_CURRENT_TIME
        ],
        'notify_url' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Alipay will asynchronously notify the result in the HTTP Post method.',
        ],
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'biz_type'   => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'Business type that is defined by Alipay',
            'defaultValue' => 'OVERSEASHOPQRCODE'
        ],
        'biz_data'   => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'Business data。' .
                          'Format：JSON',
        ]
    ];

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params, self::$bizDataParams);
    }


}