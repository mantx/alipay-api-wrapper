<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeQueryResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'             => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'error'                   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'To describe the reason of the result_code when it is failed/unknown,' .
                           'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
        'alipay_trans_status'     => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'WAIT_BUYER_PAY,' .
                          'TRADE_SUCCESS,' .
                          'TRADE_CLOSED',
            'maxLength' => 32
        ],
        'alipay_buyer_login_id'   => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The buyer’s Alipay login Id, the id might be an email or mobile number.' .
                          'The id is partially masked for privacy.',
            'maxLength' => 20
        ],
        'alipay_buyer_user_id'    => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'This ID stands for each Alipay account number,' .
                          'unique in Alipay system start with “2088”',
            'maxLength' => 16
        ],
        'out_trade_no'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
            'maxLength' => 64
        ],
        'partner_trans_id'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The trade serial number of the trade in Alipay system.' .
                          '16 bits at least and 64 bits at most.' .
                          'If out_trade_no and trade_no are transmitted at the same time, trade_no shall govern.',
            'maxLength' => 64
        ],
        'alipay_trans_id'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'On the partner’s payment request, the alipay system creates a transaction id to handle it.' .
                          'The alipay_trans_id has one-one association with partner + partner_trans_id.',
            'maxLength' => 64
        ],
        'alipay_pay_time'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The time of the transaction has been paid.' .
                          'Format：YYYYMMDDHHMMSS',
            'maxLength' => 16
        ],
        'currency'                => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The currency used for labeling the price of the transaction;',
            'maxLength' => 8
        ],
        'trans_amount'            => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'he transaction amount in the currency given above;' .
                          'Range: 0.01-100000000.00. Two digits after decimal point.',
        ],
        'exchange_rate'           => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'The rate of conversion the currency given in the request to CNY.' .
                          'The conversion happens at the time when Alipay’s trade order is created.',
        ],
        'refund _amount_cny'      => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'Refund amount in CNY.' .
                          'It is the exact amount that the Alipay has refunded.',
        ],
        'm_discount_forex_amount' => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'If coupons/vouchers are used in the transaction,' .
                          'the discount amount redeened in the settlement currency will be returned.' .
                          'Otherwise, no return.',
        ],
        'detail_error_code'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'To describe the reason of the result_code when it is failed/unknown,'.
                          'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
        'detail_error_des'        => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'To describe the reason of the result_code when it is failed/unknown,'.
                          'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
    ];

    protected $__entityNode = 'response.alipay';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}