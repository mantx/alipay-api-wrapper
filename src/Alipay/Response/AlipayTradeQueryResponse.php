<?php


namespace Alipay\Response;


class AlipayTradeQueryResponse extends AlipayTradeResponse
{
    private static $params = [
        //Business Parameter
        'out_trade_no'        => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '商户订单号',
            'maxLength' => 64
        ],
        'trade_no'            => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'buyer_logon_id'      => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '买家支付宝账号',
            'maxLength' => 100,
        ],
        'trade_status'        => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '交易状态：WAIT_BUYER_PAY（交易创建，等待买家付款）、' .
                           'TRADE_CLOSED（未付款交易超时关闭，或支付完成后全额退款）、' .
                           'TRADE_SUCCESS（交易支付成功）、TRADE_FINISHED（交易结束，不可退款）',
            'maxLength' => 32,
        ],
        'total_amount'        => [
            'type'      => 'float',
            'required'  => true,
            'comment'   => '交易的订单金额，单位为元，两位小数。该参数的值为支付时传入的total_amount',
            'maxLength' => 11,
        ],
        'trans_currency'      => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '标价币种，该参数的值为支付时传入的trans_currency，支持英镑：GBP、港币：HKD、美元：USD、' .
                           '新加坡元：SGD、日元：JPY、加拿大元：CAD、澳元：AUD、欧元：EUR、新西兰元：NZD、韩元：KRW、' .
                           '泰铢：THB、瑞士法郎：CHF、瑞典克朗：SEK、丹麦克朗：DKK、挪威克朗：NOK、马来西亚林吉特：MYR、' .
                           '印尼卢比：IDR、菲律宾比索：PHP、毛里求斯卢比：MUR、以色列新谢克尔：ILS、斯里兰卡卢比：LKR、' .
                           '俄罗斯卢布：RUB、阿联酋迪拉姆：AED、捷克克朗：CZK、南非兰特：ZAR、人民币：CNY、新台币：TWD。' .
                           '当trans_currency 和settle_currency 不一致时，trans_currency支持人民币：CNY、新台币：TWD',
            'maxLength' => 8,
        ],
        'settle_currency'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单结算币种，对应支付接口传入的settle_currency，支持英镑：GBP、港币：HKD、美元：USD、' .
                           '新加坡元：SGD、日元：JPY、加拿大元：CAD、澳元：AUD、欧元：EUR、新西兰元：NZD、韩元：KRW、' .
                           '泰铢：THB、瑞士法郎：CHF、瑞典克朗：SEK、丹麦克朗：DKK、挪威克朗：NOK、马来西亚林吉特：MYR、' .
                           '印尼卢比：IDR、菲律宾比索：PHP、毛里求斯卢比：MUR、以色列新谢克尔：ILS、斯里兰卡卢比：LKR、' .
                           '俄罗斯卢布：RUB、阿联酋迪拉姆：AED、捷克克朗：CZK、南非兰特：ZAR',
            'maxLength' => 8,
        ],
        'settle_amount'       => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '结算币种订单金额',
            'maxLength' => 11,
        ],
        'pay_currency	'    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '订单支付币种',
            'maxLength' => 8,
        ],
        'pay_amount'          => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '支付币种订单金额',
            'maxLength' => 11,
        ],
        'settle_trans_rate'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '结算币种兑换标价币种汇率',
            'maxLength' => 11,
        ],
        'trans_pay_rate'      => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '标价币种兑换支付币种汇率',
            'maxLength' => 11,
        ],
        'buyer_pay_amount'    => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '买家实付金额，单位为元，两位小数。该金额代表该笔交易买家实际支付的金额，不包含商户折扣等金额',
            'maxLength' => 11,
        ],
        'point_amount'        => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '积分支付的金额，单位为元，两位小数。该金额代表该笔交易中用户使用积分支付的金额，' .
                           '比如集分宝或者支付宝实时优惠等',
            'maxLength' => 11,
        ],
        'invoice_amount'      => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '交易中用户支付的可开具发票的金额，单位为元，两位小数。该金额代表该笔交易中可以给用户开具发票的金额',
            'maxLength' => 11,
        ],
        'send_pay_date'       => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '本次交易打款给卖家的时间',
            'maxLength' => 32,
        ],
        'receipt_amount'      => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '实收金额，单位为元，两位小数。该金额为本笔交易，商户账户能够实际收到的金额',
            'maxLength' => 11,
        ],
        'store_id'            => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户门店编号',
            'maxLength' => 32,
        ],
        'terminal_id'         => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户机具终端编号',
            'maxLength' => 32,
        ],
        'fund_bill_list'      => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '交易支付使用的资金渠道',
            //            'maxLength' => 100,
        ],
        'store_name'          => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '请求交易支付中的商户店铺的名称',
            'maxLength' => 512,
        ],
        'buyer_user_id'       => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '买家在支付宝的用户id',
            'maxLength' => 16,
        ],
        'auth_trade_pay_mode' => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '预授权支付模式，该参数仅在信用预授权支付场景下返回。信用预授权支付：',
            'maxLength' => 64,
        ],
        'buyer_user_type'     => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '买家用户类型。CORPORATE:企业用户；PRIVATE:个人用户',
            'maxLength' => 18,
        ],
        'mdiscount_amount'    => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '商家优惠金额',
            'maxLength' => 11,
        ],
        'discount_amount'     => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '平台优惠金额',
            'maxLength' => 11,
        ]
    ];

    protected $__entityNode = 'alipay_trade_query_response';


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }

}