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
        'out_trade_no'        => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '商户订单号，64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复',
            'maxLength' => 64
        ],
        'scene'               => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '支付场景' .
                              '条码支付，取值：bar_code' .
                              '声波支付，取值：wave_code',
            'maxLength'    => 32,
            'defaultValue' => 'bar_code'
        ],
        'auth_code'           => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '支付授权码，25~30开头的长度为16~24位的数字，实际字符串长度以开发者获取的付款码长度为准',
            'maxLength'    => 32,
            'defaultValue' => ''
        ],
        'product_code'        => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '销售产品码	',
            'maxLength'    => 64,
            'defaultValue' => ''
        ],
        'subject'             => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '订单标题',
            'maxLength' => 256
        ],
        'buyer_id'            => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '买家的支付宝用户id，如果为空，会从传入了码值信息中获取买家ID',
            'maxLength' => 28
        ],
        'seller_id'           => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '如果该值为空，则默认为商户签约账号对应的支付宝用户ID	',
            'maxLength' => 28
        ],
        'total_amount'        => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]' .
                           '如果同时传入【可打折金额】和【不可打折金额】，该参数可以不用传入；' .
                           '如果同时传入了【可打折金额】，【不可打折金额】，【订单总金额】三者，' .
                           '则必须满足如下条件：【订单总金额】=【可打折金额】+【不可打折金额】',
            'maxLength' => 11
        ],
        'trans_currency'      => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '标价币种, total_amount 对应的币种单位。支持英镑：GBP、港币：HKD、美元：USD、新加坡元：SGD、' .
                           '日元：JPY、加拿大元：CAD、澳元：AUD、欧元：EUR、新西兰元：NZD、韩元：KRW、泰铢：THB、' .
                           '瑞士法郎：CHF、瑞典克朗：SEK、丹麦克朗：DKK、挪威克朗：NOK、马来西亚林吉特：MYR、印尼卢比：IDR、' .
                           '菲律宾比索：PHP、毛里求斯卢比：MUR、以色列新谢克尔：ILS、斯里兰卡卢比：LKR、俄罗斯卢布：RUB、' .
                           '阿联酋迪拉姆：AED、捷克克朗：CZK、南非兰特：ZAR、人民币：CNY',
            'maxLength' => 8
        ],
        'settle_currency'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '标价币种, total_amount 对应的币种单位。支持英镑：GBP、港币：HKD、美元：USD、新加坡元：SGD、' .
                           '日元：JPY、加拿大元：CAD、澳元：AUD、欧元：EUR、新西兰元：NZD、韩元：KRW、泰铢：THB、' .
                           '瑞士法郎：CHF、瑞典克朗：SEK、丹麦克朗：DKK、挪威克朗：NOK、马来西亚林吉特：MYR、印尼卢比：IDR、' .
                           '菲律宾比索：PHP、毛里求斯卢比：MUR、以色列新谢克尔：ILS、斯里兰卡卢比：LKR、俄罗斯卢布：RUB、' .
                           '阿联酋迪拉姆：AED、捷克克朗：CZK、南非兰特：ZAR、人民币：CNY',
            'maxLength' => 8
        ],
        'discountable_amount' => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '参与优惠计算的金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]。' .
                           '如果该值未传入，但传入了【订单总金额】和【不可打折金额】，则该值默认为【订单总金额】-【不可打折金额】',
            'maxLength' => 11
        ],
        'body'                => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单描述',
            'maxLength' => 128
        ],
        'goods_detail'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '订单包含的商品列表信息，json格式，其它说明详见商品明细说明',
        ],
        'operator_id'         => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户操作员编号',
            'maxLength' => 28
        ],
        'store_id'            => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户门店编号	',
            'maxLength' => 32
        ],
        'terminal_id'         => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户机具终端编号',
            'maxLength' => 32
        ],
        'extend_params'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '业务扩展参数，详见业务扩展参数说明',
        ],
        'timeout_express'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '该笔订单允许的最晚付款时间，逾期将关闭交易。' .
                           '取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。' .
                           '该参数数值不接受小数点， 如 1.5h，可转换为 90m。' .
                           '该参数在请求到支付宝时开始计时。',
            'maxLength' => 6
        ],
        'auth_confirm_mode'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '预授权确认模式，授权转交易请求中传入，适用于预授权转交易业务使用，目前只支持PRE_AUTH(预授权产品码)' .
                           'COMPLETE：转交易支付完成结束预授权，解冻剩余金额; NOT_COMPLETE：转交易支付完成不结束预授权，不解冻剩余金额',
            'maxLength' => 32
        ],
        'terminal_params'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。支付宝只会在异步通知时将该参数原样返回。' .
                           '本参数必须进行UrlEncode之后才可以发送给支付宝',
            'maxLength' => 2048
        ]
    ];

    private static $bizExtendParams = [
        'sys_service_provider_id' => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '系统商编号，该参数作为系统商返佣数据提取的依据，请填写系统商签约协议的PID',
            'maxLength' => 64
        ],
        'industry_reflux_info'    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '行业数据回流信息, 详见：地铁支付接口参数补充说明',
            'maxLength' => 512
        ],
        'card_type	'           => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '卡类型	',
            'maxLength' => 32
        ]
    ];

    protected $__serviceMethod = 'alipay.trade.pay';

    protected function getStaticBusinessParams()
    {
        return array_merge(parent::getStaticBusinessParams(), self::$bizContentParams);
    }

    protected function getStaticExtendParams()
    {
        return array_merge(parent::getStaticExtendParams(), self::$bizExtendParams);
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
    public function getAuthCode()
    {
        return $this->auth_code;
    }

    /**
     * @param $value
     */
    public function setAuthCode($value)
    {
        $this->auth_code = $value;
    }

    /**
     * @return mixed
     */
    public function getProductCode()
    {
        return $this->product_code;
    }

    /**
     * @param $value
     */
    public function setProductCode($value)
    {
        $this->product_code = $value;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param $value
     */
    public function setSubject($value)
    {
        $this->subject = $value;
    }

    /**
     * @return mixed
     */
    public function getBuyerId()
    {
        return $this->buyer_id;
    }

    /**
     * @param $value
     */
    public function setBuyerId($value)
    {
        $this->buyer_id = $value;
    }

    /**
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * @param $value
     */
    public function setSellerId($value)
    {
        $this->seller_id = $value;
    }

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * @param $value
     */
    public function setTotalAmount($value)
    {
        $this->total_amount = $value;
    }

    /**
     * @return mixed
     */
    public function getTransCurrency()
    {
        return $this->trans_currency;
    }

    /**
     * @param $value
     */
    public function setTransCurrency($value)
    {
        $this->trans_currency = $value;
    }

    /**
     * @return mixed
     */
    public function getSettleCurrency()
    {
        return $this->settle_currency;
    }

    /**
     * @param $value
     */
    public function setSettleCurrency($value)
    {
        $this->settle_currency = $value;
    }

    /**
     * @return mixed
     */
    public function getDiscountableAmount()
    {
        return $this->discountable_amount;
    }

    /**
     * @param $value
     */
    public function setDiscountableAmount($value)
    {
        $this->discountable_amount = $value;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $value
     */
    public function setBody($value)
    {
        $this->body = $value;
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

    /**
     * @return mixed
     */
    public function getExtendParams()
    {
        return $this->extend_params;
    }

    /**
     * @param $value
     */
    public function setExtendParams($value)
    {
        $this->extend_params = $value;
    }

    /**
     * @return mixed
     */
    public function getTimeoutExpress()
    {
        return $this->timeout_express;
    }

    /**
     * @param $value
     */
    public function setTimeoutExpress($value)
    {
        $this->timeout_express = $value;
    }


    /**
     * @return mixed
     */
    public function getAuthConfirmMode()
    {
        return $this->auth_confirm_mode;
    }

    /**
     * @param $value
     */
    public function setAuthConfirmMode($value)
    {
        $this->auth_confirm_mode = $value;
    }

    /**
     * @return mixed
     */
    public function getTerminalParams()
    {
        return $this->terminal_params;
    }

    /**
     * @param $value
     */
    public function setTerminalParams($value)
    {
        $this->terminal_params = $value;
    }

    /**
     * @return mixed
     */
    public function getSysServiceProviderId()
    {
        return $this->sys_service_provider_id;
    }

    /**
     * @param $value
     */
    public function setSysServiceProviderId($value)
    {
        $this->sys_service_provider_id = $value;
    }

    /**
     * @return mixed
     */
    public function getIndustryRefluxInfo()
    {
        return $this->industry_reflux_info;
    }

    /**
     * @param $value
     */
    public function setIndustryRefluxInfo($value)
    {
        $this->industry_reflux_info = $value;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @param $value
     */
    public function setCardType($value)
    {
        $this->card_type = $value;
    }


}