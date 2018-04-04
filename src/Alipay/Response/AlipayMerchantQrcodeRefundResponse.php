<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeRefundResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'        => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'error'              => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'To describe the reason of the result_code when it is failed/unknown,' .
                           'leave it blank when result_code is success.',
            'maxLength' => 48
        ],
        'partner_trans_id'   => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'Equal to the partner_trans_id given in the request',
            'maxLength' => 64
        ],
        'alipay_trans_id'    => [
            'type'      => 'string',
            'required'  => false,
            'comment'   => 'On the partner’s payment request, the alipay system creates a transaction id to handle it.' .
                           'The alipay_trans_id has one-one association with partner + partner_trans_id.',
            'maxLength' => 64
        ],
        'partner_refund_id'  => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The refund order id on partner system.' .
                          'partner_refund_id cannot be same as partner_transaction_id' .
                          'partner_refund_id together with partner identify a refund transaction' .
                          'Less than or equal to the original transaction amount and the left ',
            'maxLength' => 64
        ],
        'refund_amount'      => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'Less than or equal to the original transaction amount and the left transaction amount if ever refunded.',
        ],
        'currency'           => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'refund currency',
        ],
        'exchange_rate'      => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'The rate of conversion the currency given in the request to CNY.' .
                          'The conversion happens at the time when Alipay’s trade order is created.',
        ],
        'refund _amount_cny' => [
            'type'     => 'float',
            'required' => false,
            'comment'  => 'Refund amount in CNY.' .
                          'It is the exact amount that the Alipay has refunded.',
        ]
    ];

    protected $__entityNode = 'response.alipay';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}