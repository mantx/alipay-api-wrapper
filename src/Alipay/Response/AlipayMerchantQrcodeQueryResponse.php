<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeQueryResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'             => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'error'                   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'To describe the reason of the result_code when it is failed/unknown,' .
                           'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
        'alipay_trans_status'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'WAIT_BUYER_PAY,' .
                           'TRADE_SUCCESS,' .
                           'TRADE_CLOSED',
            'maxLength' => 32
        ],
        'alipay_buyer_login_id'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The buyer’s Alipay login Id, the id might be an email or mobile number.' .
                           'The id is partially masked for privacy.',
            'maxLength' => 20
        ],
        'alipay_buyer_user_id'    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'This ID stands for each Alipay account number,' .
                           'unique in Alipay system start with “2088”',
            'maxLength' => 16
        ],
        'out_trade_no'            => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '',
            'maxLength' => 64
        ],
        'partner_trans_id'        => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The trade serial number of the trade in Alipay system.' .
                           '16 bits at least and 64 bits at most.' .
                           'If out_trade_no and trade_no are transmitted at the same time, trade_no shall govern.',
            'maxLength' => 64
        ],
        'alipay_trans_id'         => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'On the partner’s payment request, the alipay system creates a transaction id to handle it.' .
                           'The alipay_trans_id has one-one association with partner + partner_trans_id.',
            'maxLength' => 64
        ],
        'alipay_pay_time'         => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The time of the transaction has been paid.' .
                           'Format：YYYYMMDDHHMMSS',
            'maxLength' => 16
        ],
        'currency'                => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The currency used for labeling the price of the transaction;',
            'maxLength' => 8
        ],
        'trans_amount'            => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'he transaction amount in the currency given above;' .
                          'Range: 0.01-100000000.00. Two digits after decimal point.',
        ],
        'exchange_rate'           => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'The rate of conversion the currency given in the request to CNY.' .
                          'The conversion happens at the time when Alipay’s trade order is created.',
        ],
        'refund_amount_cny'       => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'Refund amount in CNY.' .
                          'It is the exact amount that the Alipay has refunded.',
        ],
        'm_discount_forex_amount' => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'If coupons/vouchers are used in the transaction,' .
                          'the discount amount redeened in the settlement currency will be returned.' .
                          'Otherwise, no return.',
        ],
        'detail_error_code'       => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'To describe the reason of the result_code when it is failed/unknown,' .
                           'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
        'detail_error_des'        => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'To describe the reason of the result_code when it is failed/unknown,' .
                           'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
    ];

    protected $__entityNode = 'response.alipay';


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }


    /**
     * @param $value
     */
    public function setResultCode($value)
    {
        $this->result_code = $value;
    }

    /**
     * @return mixed
     */
    public function getResultCode()
    {
        return $this->result_code;
    }

    /**
     * @param $value
     */
    public function setError($value)
    {
        $this->error = $value;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @param $value
     */
    public function setAlipayTransStatus($value)
    {
        $this->alipay_trans_status = $value;
    }

    /**
     * @return mixed
     */
    public function getAlipayTransStatus()
    {
        return $this->alipay_trans_status;
    }

    /**
     * @param $value
     */
    public function setAlipayBuyerLoginId($value)
    {
        $this->alipay_buyer_login_id = $value;
    }

    /**
     * @return mixed
     */
    public function getAlipayBuyerLoginId()
    {
        return $this->alipay_buyer_login_id;
    }

    /**
     * @param $value
     */
    public function setAlipayBuyerUserId($value)
    {
        $this->alipay_buyer_user_id = $value;
    }

    /**
     * @return mixed
     */
    public function getAlipayBuyerUserId()
    {
        return $this->alipay_buyer_user_id;
    }

    /**
     * @param $value
     */
    public function setOutTradeNo($value)
    {
        $this->out_trade_no = $value;
    }

    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->out_trade_no;
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
    public function getAlipayPayTime()
    {
        return $this->alipay_pay_time;
    }

    /**
     * @param $value
     */
    public function setAlipayPayTime($value)
    {
        $this->alipay_pay_time = $value;
    }

    /**
     * @return mixed
     */
    public function getTransAmount()
    {
        return $this->trans_amount;
    }

    /**
     * @param $value
     */
    public function setTransAmount($value)
    {
        $this->trans_amount = $value;
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
    public function getRefundAmountCny()
    {
        return $this->refund_amount_cny;
    }

    /**
     * @param $value
     */
    public function setRefundAmountCny($value)
    {
        $this->refund_amount_cny = $value;
    }

    /**
     * @return mixed
     */
    public function getExchangeRate()
    {
        return $this->exchange_rate;
    }

    /**
     * @param $value
     */
    public function setExchangeRate($value)
    {
        $this->exchange_rate = $value;
    }

    /**
     * @return mixed
     */
    public function getMDiscountForexAmount()
    {
        return $this->m_discount_forex_amount;
    }

    /**
     * @param $value
     */
    public function setMDiscountForexAmount($value)
    {
        $this->m_discount_forex_amount = $value;
    }

    /**
     * @param $value
     */
    public function setDetailErrorCode($value)
    {
        $this->detail_error_code = $value;
    }

    /**
     * @return mixed
     */
    public function getDetailErrorCode()
    {
        return $this->detail_error_code;
    }

    /**
     * @param $value
     */
    public function setDetailErrorDes($value)
    {
        $this->detail_error_des = $value;
    }

    /**
     * @return mixed
     */
    public function getDetailErrorDes()
    {
        return $this->detail_error_des;
    }
}