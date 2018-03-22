<?php


namespace Alipay\Request;


use Alipay\Utils\Utility;

class AlipayMerchantQrcodeCreateRequest extends GlobalAbstractRequest
{
    private static $params = [
        //basic parameters
        'timestamp'  => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            'defaultValue' => self::DEFAULT_VALUE_CURRENT_TIME
        ],
        'notify_url' => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        //business parameters
        'biz_type'   => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
            'defaultValue' => 'OVERSEASHOPQRCODE'
        ],
        'biz_data'   => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ]
    ];

    private static $bizDataParams = [
        //biz_data Specification
        'secondary_merchant_industry' => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',

        ],
        'secondary_merchant_id'       => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'secondary_merchant_name'     => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'store_id'                    => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'store_name'                  => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'taxi_operation_id'           => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'taxi_number'                 => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'taxi_driver_name'            => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'taxi_driver_mobile'          => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'trans_currency'              => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'currency'                    => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'sys_service_provider_id'     => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'channel_fee'                 => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'country_code'                => [
            'type'     => 'string',
            'required' => true,
            'length'   => 2,
            'comment'  => '',
        ],
        'address'                     => [
            'type'     => 'string',
            'required' => true,
            'comment'  => '',
        ],
        'passback_parameters'         => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'notify_mobile'               => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'notify_wangwang'             => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
        ],
        'notify_alipay_account'       => [
            'type'     => 'string',
            'required' => false,
            'comment'  => '',
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
        $values = [];
        $baseParams = parent::getParams();
        foreach($baseParams as $key => $info) {
            $values[$key] = $this->{$key};
        }

        $bizValues = [];
        foreach(self::$bizDataParams as $key => $info) {
            $bizValues[$key] = $this->{$key};
        }
        $values['biz_data'] = json_encode($bizValues, true);
        return $values;
    }


}