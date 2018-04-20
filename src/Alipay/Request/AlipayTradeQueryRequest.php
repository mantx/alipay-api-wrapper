<?php


namespace Alipay\Request;


class AlipayTradeRefundRequest extends AlipayTradeRequest
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
        'out_trade_no'    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单支付时传入的商户订单号,不能和 trade_no同时为空。',
            'maxLength' => 64
        ],
        'trade_no'        => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'refund_amount'   => [
            'type'      => 'float',
            'required'  => true,
            'comment'   => 'Less than or equal to the original transaction amount and the left transaction amount if ever refunded.',
            'maxLength' => 9,
        ],
        'refund_currency' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '订单退款币种信息，非外币交易，不能传入退款币种信息',
            'maxLength' => 8,
        ],
        'refund_reason'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'The reason of refund',
            'maxLength' => 256
        ],
        'out_request_no'  => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。',
            'maxLength' => 64
        ],
        'operator_id'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户操作员编号',
            'maxLength' => 30
        ],
        'store_id'        => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户门店编号	',
            'maxLength' => 32
        ],
        'terminal_id'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户机具终端编号',
            'maxLength' => 32
        ],
        'goods_detail'    => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '订单包含的商品列表信息，json格式，其它说明详见商品明细说明',
        ]
    ];

    protected $__serviceMethod = 'alipay.trade.refund';

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
    public function getRefundCurrency()
    {
        return $this->refund_currency;
    }

    /**
     * @param $value
     */
    public function setRefundCurrency($value)
    {
        $this->refund_currency = $value;
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

    /**
     * @return mixed
     */
    public function getGoodsDetail()
    {
        return $this->goods_detail;
    }

    /**
     * @param $value
     */
    public function setGoodsDetail($value)
    {
        $this->goods_detail = $value;
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

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param $value
     */
    public function setStoreId($value)
    {
        $this->store_id = $value;
    }

    /**
     * @return mixed
     */
    public function getTerminalId()
    {
        return $this->terminal_id;
    }

    /**
     * @param $value
     */
    public function setTerminalId($value)
    {
        $this->terminal_id = $value;
    }


}