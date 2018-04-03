<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeRefundResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'qrcode'  => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'QR Code',
        ],
    ];

    protected $__entityNode = 'response.qrcodeinfo';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}