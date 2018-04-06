<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeModifyResponse extends AlipayMerchantQrcodeResponse
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


    public function getAllParams()
    {
        $baseParams = parent::getAllParams();

        return array_merge($baseParams, self::$params);
    }

    /**
     * @param $value
     */
    public function setQrcode($value)
    {
        $this->qrcode = $value;
    }

    /**
     * @return mixed
     */
    public function getQrcode()
    {
        return $this->qrcode;
    }
}