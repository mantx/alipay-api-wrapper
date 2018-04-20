<?php


namespace Alipay\Request;


class AlipayTradeFastpayRefundQueryRequest extends AlipayTradeRequest
{
    private static $params = [
        'app_auth_token' => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '获取用户授权信息，可实现如免登功能。获取方法请查阅：用户信息授权',
            'maxLength' => 40
        ]
    ];

    private static $bizContentParams = [
        //biz_content Specification
        'out_trade_no'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单支付时传入的商户订单号,不能和 trade_no同时为空。',
            'maxLength' => 64
        ],
        'trade_no'       => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'out_request_no' => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号',
            'maxLength' => 64
        ]
    ];

    protected $__serviceMethod = 'alipay.trade.fastpay.refund.query';

    protected function getStaticBusinessParams()
    {
        return array_merge(parent::getStaticBusinessParams(), self::$bizContentParams);
    }


    /**
     * @return mixed
     */
    public function getAppAuthToken()
    {
        return $this->app_auth_token;
    }

    /**
     * @param $value
     */
    public function setAppAuthToken($value)
    {
        $this->app_auth_token = $value;
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

    /**
     * @return mixed
     */
    public function getOutRequestNo()
    {
        return $this->out_request_no;
    }

    /**
     * @param $value
     */
    public function setOutRequestNo($value)
    {
        $this->out_request_no = $value;
    }

}