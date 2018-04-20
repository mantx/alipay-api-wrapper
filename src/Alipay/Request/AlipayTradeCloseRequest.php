<?php


namespace Alipay\Request;


class AlipayTradeCloseRequest extends AlipayTradeRequest
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
        'out_trade_no' => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单支付时传入的商户订单号,不能和 trade_no同时为空。',
            'maxLength' => 64
        ],
        'trade_no'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'operator_id'  => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '卖家端自定义的的操作员 ID',
            'maxLength' => 28
        ]
    ];

    protected $__serviceMethod = 'alipay.trade.close';

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
    public function getOperatorId()
    {
        return $this->operator_id;
    }

    /**
     * @param $value
     */
    public function setOperatorId($value)
    {
        $this->operator_id = $value;
    }
}