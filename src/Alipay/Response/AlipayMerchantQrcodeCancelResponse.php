<?php


namespace Alipay\Response;


class AlipayMerchantQrcodeCancelResponse extends AlipayMerchantQrcodeResponse
{
    private static $params = [
        //Business Parameter
        'result_code'  => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'Response code of cancel processing result.' .
                           'SUCCESS: successful refund' .
                           'FAIL: unsuccessful refund' .
                           'UNKNOWN: unknown result',
            'maxLength' => 32
        ],
        'out_trade_no' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Unique order No. in Alipay’s merchant’s website',
        ],
        'trade_no'     => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The trade serial number of the trade in Alipay system.' .
                          '16 bits at least and 64 bits at most.' .
                          'If out_trade_no and  trade_no are transmitted at the same time, trade_no shall govern.',
        ],
        'retry_flag'    => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Y: The cancel failed due to retriable error' .
                          'N: The cancel failed due to non-retriable error',
            'length'   => 1
        ],
    ];

    protected $__entityNode = 'response.alipay';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }
}