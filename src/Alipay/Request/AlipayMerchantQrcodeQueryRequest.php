<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeQueryRequest extends AlipayMerchantQrcodeRequest
{
    private static $params = [
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'partner_trans_id' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The original partner transaction id given in the payment request',
        ],
        'alipay_trans_id'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The Alipay transaction ID.',
        ]
    ];

    protected $__serviceMethod = 'alipay.acquire.overseas.query';


    /**
     * @return mixed
     */
    public function getPartnerTransId()
    {
        return $this->partner_trans_id;
    }

    /**
     * @param $value
     */
    public function setPartnerTransId($value)
    {
        $this->partner_trans_id = $value;
    }

    /**
     * @return mixed
     */
    public function getAlipayTransId()
    {
        return $this->alipay_trans_id;
    }

    /**
     * @param $value
     */
    public function setAlipayTransId($value)
    {
        $this->alipay_trans_id = $value;
    }

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }

}