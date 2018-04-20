<?php


namespace Alipay\Response;


class AlipayTradeFastpayRefundQueryResponse extends AlipayTradeResponse
{
    private static $params = [
        //Business Parameter
        'out_trade_no'                    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '商户订单号',
            'maxLength' => 64
        ],
        'trade_no'                        => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ],
        'out_request_no'                  => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '本笔退款对应的退款请求号',
            'maxLength' => 64
        ],
        'refund_reason'                   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '发起退款时，传入的退款原因',
            'maxLength' => 256
        ],
        'refund_amount'                   => [
            'type'     => 'float',
            'required' => false,
            'comment'  => '本次退款请求，对应的退款金额',
        ],
        'total_amount'                    => [
            'type'     => 'float',
            'required' => false,
            'comment'  => '该笔退款所对应的交易的订单金额',
        ],
        'refund_status'                   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '只在使用异步退款接口情况下才返回该字段。REFUND_PROCESSING 退款处理中；REFUND_SUCCESS 退款处理成功；REFUND_FAIL 退款失败;	',
            'maxLength' => 32
        ],
        'error_code	'                  => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => '退款失败错误码。只在使用异步退款接口情况下才会返回该字段',
            'maxLength' => 32
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

    protected $__entityNode = 'alipay_trade_fastpay_refund_query_response';


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }

}