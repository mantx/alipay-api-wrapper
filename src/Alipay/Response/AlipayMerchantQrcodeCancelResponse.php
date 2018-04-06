<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeCancelResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'       => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'out_trade_no'      => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'Unique order No. in Alipay’s merchant’s website',
            'maxLength' => 64
        ],
        'trade_no'          => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The trade serial number of the trade in Alipay system.' .
                           '16 bits at least and 64 bits at most.' .
                           'If out_trade_no and  trade_no are transmitted at the same time, trade_no shall govern.',
            'maxLength' => 64
        ],
        'retry_flag'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
            'length'   => 1
        ],
        'action'            => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The action of cancel.' .
                           'close: only closed the transaction, but no refund.' .
                           'refund: had a refund.',
            'maxLength' => 10
        ],
        'detail_error_code' => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'Give cause description to the response code returned.' .
                           'Please refer to “8.1 Business Error Code”.' .
                           'If the response code of result_code is SUCCESS, this parameter shall not be returned.',
            'maxLength' => 48
        ],
        'detail_error_des'  => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'Give literal statement as to the detailed error code.' .
                           'If the response code of result_code is SUCCESS, this parameter shall not be returned.',
            'maxLength' => 64
        ]
    ];

    protected $__entityNode = 'response.alipay';


    public function getAllParams()
    {
        $baseParams = parent::getAllParams();

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
     * @param $value
     */
    public function setTradeNo($value)
    {
        $this->trade_no = $value;
    }

    /**
     * @return mixed
     */
    public function getTradeNo()
    {
        return $this->trade_no;
    }

    /**
     * @param $value
     */
    public function setRetryFlag($value)
    {
        $this->retry_flag = $value;
    }

    /**
     * @return mixed
     */
    public function getRetryFlag()
    {
        return $this->retry_flag;
    }

    /**
     * @param $value
     */
    public function setAction($value)
    {
        $this->action = $value;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
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