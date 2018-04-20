<?php


namespace Alipay\Response;


class AlipayTradeCloseResponse extends AlipayTradeResponse
{
    private static $params = [
        //Business Parameter
        'out_trade_no' => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '商户订单号',
            'maxLength' => 64
        ],
        'trade_no'     => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => '支付宝交易号，和商户订单号不能同时为空',
            'maxLength' => 64
        ]
    ];

    protected $__entityNode = 'alipay_trade_close_response';


    public function getStaticBasicParams()
    {
        $baseParams = parent::getStaticBasicParams();

        return array_merge($baseParams, self::$params);
    }

}