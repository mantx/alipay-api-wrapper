<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeCreateRequest extends GlobalAbstractRequest
{
    private static $params = [
        //basic parameters
        'timestamp'  => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The time ( Beijing Time) of calling the interface, ' .
                              'and the call will expire in a certime time (default 30 minutes). ' .
                              'The time format is ：yyyy-MM-dd HH:mm:ss',
            'defaultValue' => self::DEFAULT_VALUE_CURRENT_TIME
        ],
        'notify_url' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Alipay will asynchronously notify the result in the HTTP Post method.',
        ],
        ///////////////////////////
        //business parameters
        ///////////////////////////
        'biz_type'   => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'Business type that is defined by Alipay',
            'defaultValue' => 'OVERSEASHOPQRCODE'
        ],
        'biz_data'   => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'Business data。' .
                          'Format：JSON',
        ]
    ];

    private static $bizDataParams = [
        //biz_data Specification
        'secondary_merchant_industry' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'Business sector, it is distribued by Alipay for distinguish the sectors.' .
                          '1. Food Sector（5812）' .
                          '2. Shopping Sector（5311）' .
                          '3. Hotel sector（7011）' .
                          '4. Taxi sector（4121）',
        ],
        'secondary_merchant_id'       => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'This secondary merchant ID is used to identify a merchant.' .
                          'The ID can only contain letters, numbers, dashes, and underscores. ',
        ],
        'secondary_merchant_name'     => [
            'type'      => 'string',
            'required'  => true,
            'comment'   => 'secondary_merchant_name: sub-merchant name which will be recorded in user’s statement. '
                           . 'The max length is 32.',
            'maxLength' => 32
        ],
        'store_id'                    => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The store ID is used to identify a store under a merchant. ' .
                          'The ID can only contain letters, numbers, dashes, and underscores.' .
                          'Optional for the taxi business. (MCC=4121)',
        ],
        'store_name'                  => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The store name' .
                          'Optional for the taxi business. (MCC=4121)',
        ],
        'taxi_operation_id'           => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'It is compulsory for the taxi business.（MCC=4121）',
        ],
        'taxi_number'                 => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'It is compulsory for the taxi business.（MCC=4121）',
        ],
        'taxi_driver_name'            => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'It is compulsory for the taxi business.（MCC=4121)' .
                          'This will be shown in Alipay wallet app\'s transaction history.',
        ],
        'taxi_driver_mobile'          => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'It is compulsory for the taxi business.（MCC=4121）',
        ],
        'trans_currency'              => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The pricing currency',
        ],
        'currency'                    => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The currency to settle with the merchant.' .
                          'The default value is CNY. If the pricing currency is not CNY,' .
                          'then the settlement currency must be either CNY or the pricing currency.',
        ],
        'sys_service_provider_id'     => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'System service provider ID. Can’t be modified.',
        ],
        'channel_fee'                 => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Format: JSON string If the channel_fee exists when the QR code is created,' .
                          'then it can’t be deleted when the QR code is modified.',
        ],
        'country_code'                => [
            'type'         => 'string',
            'required'     => true,
            'length'       => 2,
            'comment'      => 'Refer to ISO 3166-1 Uor details. The country code consists of two letters (alpha-2 code).',
            'defaultValue' => 'CN'
        ],
        'address'                     => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The address of the store where the code is created.',
        ],
        'passback_parameters'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'The response parameters returned to the merchant after the payment succeeds.' .
                          'Merchants can define the parameters, but the format must be JSON. Nested JSON is not supported.',
        ],
        'notify_mobile'               => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Legal phone number. Must be numbers only.',
            'pattern'  => '^\d+$'
        ],
        'notify_wangwang'             => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Legal Wangwang name',
        ],
        'notify_alipay_account'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => 'Legal Alipay account',
        ]
    ];

    protected $service = 'alipay.commerce.qrcode.create';


    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params, self::$bizDataParams);
    }

    protected function getRequestParams()
    {
        $values     = [];
        $baseParams = parent::getParams();
        foreach ($baseParams as $key => $info) {
            $values[$key] = $this->{$key};
        }

        $bizValues = [];
        foreach (self::$bizDataParams as $key => $info) {
            if ($this->{$key}) {
                $bizValues[$key] = $this->{$key};
            }
        }
        $this->biz_data = $values['biz_data'] = json_encode($bizValues, true);

        return $values;
    }


}