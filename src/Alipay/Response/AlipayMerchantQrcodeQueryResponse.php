<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeQueryResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'           => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'alipay_trans_id'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Unique order No. in Alipay’s merchant’s website',
        ],
        'partner_trans_id'      => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The trade serial number of the trade in Alipay system.' .
                          '16 bits at least and 64 bits at most.' .
                          'If out_trade_no and  trade_no are transmitted at the same time, trade_no shall govern.',
        ],
        'alipay_buyer_login_id' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
            //            'length'   => 1
        ],
        'alipay_pay_time'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'exchange_rate'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'trans_amount'          => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'trans_amount_CNY'      => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'alipay_trans_status'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'detail_error_code'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'detail_error_des'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
        'out_trade_no'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
        ],
    ];

    protected $__entityNode = 'response.alipay';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}