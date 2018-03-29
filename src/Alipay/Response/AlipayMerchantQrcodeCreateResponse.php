<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeCreateResponse extends GlobalAbstractResponse
{
    private static $params = [
        //Business Parameter
        'qrcode'  => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'QR Code',
        ],
        'qrcode_img_url' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The URL of the QR Code.',
        ],
    ];

    protected $__entityNode = 'response.qrcodeinfo';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }


}