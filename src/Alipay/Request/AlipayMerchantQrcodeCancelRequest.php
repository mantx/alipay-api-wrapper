<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeCancelRequest extends AlipayMerchantQrcodeRequest
{
    private static $params = [
        //basic parameters
        'timestamp'          => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'Time stamp of the merchant server sending request, accurate to the millisecond.',
        ],
        'terminal_timestamp' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Time stamp of the terminal sending request, accurate to the millisecond.',
        ],
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'out_trade_no'      => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'Unique order No. in Alipay’s merchant’s website',
        ],
        'trade_no'           => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The trade serial number of the trade in Alipay system.' .
                          '16 bits at least and 64 bits at most.' .
                          'If out_trade_no and  trade_no are transmitted at the same time, trade_no shall govern.',
        ]
    ];

    protected $__serviceMethod = 'alipay.acquire.cancel';

    /**
     * @return mixed
     */
    public function getTimeStamp()
    {
        return $this->timestamp;
    }

    /**
     * @param $value
     */
    public function setTimeStamp($value)
    {
        $this->timestamp = $value;
    }

    /**
     * @return mixed
     */
    public function getTerminalTimeStamp()
    {
        return $this->terminal_timestamp;
    }

    /**
     * @param $value
     */
    public function setTerminalTimeStamp($value)
    {
        $this->terminal_timestamp = $value;
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
    public function setOutTradeNo($value)
    {
        $this->out_trade_no = $value;
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
    public function setTradeNo($value)
    {
        $this->trade_no = $value;
    }

    public function getBasicParams()
    {
        return array_merge(parent::getBasicParams(), self::$params);
    }

}