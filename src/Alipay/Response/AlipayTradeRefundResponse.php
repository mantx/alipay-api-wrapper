<?php


namespace Alipay\Response;


class AlipayTradeRefundResponse extends AlipayTradeResponse
{
    private static $params = [
        //Business Parameter
        'out_trade_no'                    => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '商户订单号',
            'maxLength' => 64
        ],
        'trade_no'                        => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'buyer_logon_id'                  => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '用户的登录id',
            'maxLength' => 100,
        ],
        'fund_change'                     => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '本次退款是否发生了资金变化',
            'maxLength' => 1
        ],
        'refund_fee'                      => [
            'type'      => 'float',
            'required'  => true,
            'comment'   => '退款总金额',
            'maxLength' => 11
        ],
        'send_back_fee'                   => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '退款总金额',
            'maxLength' => 11
        ],
        'refund_currency'                 => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '退款币种信息	',
            'maxLength' => 8,
        ],
        'gmt_refund_pay'                  => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '退款支付时间	',
            'maxLength' => 32
        ],
        'refund_detail_item_list'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '退款使用的资金渠道	',
            //            'maxLength' => 32
        ],
        'store_name'                      => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '交易在支付时候的门店名称',
            'maxLength' => 512
        ],
        'buyer_user_id'                   => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '买家在支付宝的用户id',
            'maxLength' => 28
        ],
        'present_refund_buyer_amount'     => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '本次退款金额中买家退款金额',
            'maxLength' => 11
        ],
        'present_refund_discount_amount'  => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '本次退款金额中平台优惠退款金额	',
            'maxLength' => 11
        ],
        'present_refund_mdiscount_amount' => [
            'type'      => 'float',
            'required'  => false,
            'comment'   => '本次退款金额中商家优惠退款金额',
            'maxLength' => 11
        ]
    ];

    protected $__entityNode = 'alipay_trade_refund_response';


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }

}