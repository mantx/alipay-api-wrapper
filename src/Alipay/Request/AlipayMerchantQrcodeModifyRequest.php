<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeModifyRequest extends AlipayMerchantQrcodeCreateRequest
{
    private static $params = [
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'qrcode' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The returned QR code value after the code is generated successfully.',
        ]
    ];

    protected $__serviceMethod = 'alipay.commerce.qrcode.modify';

    /**
     * @return mixed
     */
    public function getQrcode()
    {
        return $this->qrcode;
    }

    /**
     * @param $value
     */
    public function setQrcode($value)
    {
        $this->qrcode = $value;
    }

    public function getStaticBasicParams()
    {
        return array_merge(parent::getStaticBasicParams(), self::$params);
    }
}