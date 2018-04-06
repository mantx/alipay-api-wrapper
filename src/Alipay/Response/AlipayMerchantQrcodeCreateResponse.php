<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeCreateResponse extends AlipayMerchantQrcodeResponse
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

    /**
     * @param $value
     */
    public function setQrcodeImgUrl($value)
    {
        $this->qrcode_img_url = $value;
    }

    /**
     * @return mixed
     */
    public function getQrcodeImgUrl()
    {
        return $this->qrcode_img_url;
    }


}