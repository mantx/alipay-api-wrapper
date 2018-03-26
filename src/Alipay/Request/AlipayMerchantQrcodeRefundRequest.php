<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeRefundRequest extends AlipayMerchantQrcodeRequest
{
    private static $params = [
        //basic parameters
        'notify_url'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Alipay will asynchronously notify the result in the HTTP Post method.',
        ],
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'partner_trans_id'  => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The original partner transaction id given in the payment request',
        ],
        'alipay_trans_id'   => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The Alipay transaction ID.',
        ],
        'partner_refund_id' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The refund order id on partner system.' .
                          'partner_refund_id cannot be same as partner_transaction_id' .
                          'partner_refund_id together with partner identify a refund transaction' .
                          'Less than or equal to the original transaction amount and the left ',
        ],
        'refund_amount'     => [
            'type'     => 'float',
            'required' => true,
            'comment'  => 'Less than or equal to the original transaction amount and the left transaction amount if ever refunded.',
        ],
        'currency'          => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'refund currency',
        ],
        'refund_reason'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The reason of refund',
            'maxLength' => 128
        ],
        'is_sync'           => [
            'type'         => 'string',
            'required'     => false,
            'enumeration'  => 'Y, N',
            'comment'      => 'The refund request is processed synchronously or asynchronously.' .
                              'Value: Y or N. Default value is N, which is processed asynchronously.' .
                              'If the value is set as Y, notify_url will become meaningless',
            'length'       => 1,
            'defaultValue' => 'Y'
        ]
    ];

    protected $__serviceMethod = 'alipay.acquire.overseas.spot.refund';

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param $value
     */
    public function setNotifyUrl($value)
    {
        $this->notify_url = $value;
    }

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


    /**
     * @return mixed
     */
    public function getPartnerRefundId()
    {
        return $this->partner_refund_id;
    }

    /**
     * @param $value
     */
    public function setPartnerRefundId($value)
    {
        $this->partner_refund_id = $value;
    }

    /**
     * @return mixed
     */
    public function getRefundAmount()
    {
        return $this->refund_amount;
    }

    /**
     * @param $value
     */
    public function setRefundAmount($value)
    {
        $this->refund_amount = $value;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $value
     */
    public function setCurrency($value)
    {
        $this->currency = $value;
    }

    /**
     * @return mixed
     */
    public function getRefundReason()
    {
        return $this->refund_reason;
    }

    /**
     * @param $value
     */
    public function setRefundReason($value)
    {
        $this->refund_reason = $value;
    }


    /**
     * @return mixed
     */
    public function getIsSync()
    {
        return $this->is_sync;
    }

    /**
     * @param $value
     */
    public function setIsSync($value)
    {
        $this->is_sync = $value;
    }

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }

}