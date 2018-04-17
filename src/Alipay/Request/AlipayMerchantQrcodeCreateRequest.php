<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeCreateRequest extends AlipayMerchantQrcodeRequest
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
            'type'     => 'string',
            'required' => false,
            'length'   => 2,
            'comment'  => 'Refer to ISO 3166-1 Uor details. The country code consists of two letters (alpha-2 code).',
            //            'defaultValue' => 'CN'
        ],
        'address'                     => [
            'type'     => 'string',
            'required' => false,
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

    protected $__serviceMethod = 'alipay.commerce.qrcode.create';

    /**
     * @return mixed
     */
    public function getTimeStamp()
    {
        return $this->timestamp;
    }

    /**
     * @param $value
     */
    public function setTimeStamp($value)
    {
        $this->timestamp = $value;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param $value
     */
    public function setNotifyUrl($value)
    {
        $this->notify_url = $value;
    }


    /**
     * @return mixed
     */
    public function getBizType()
    {
        return $this->biz_type;
    }

    /**
     * @param $value
     */
    public function setBizType($value)
    {
        $this->biz_type = $value;
    }

    /**
     * @return mixed
     */
    public function getBizData()
    {
        return $this->biz_data;
    }

    /**
     * @param $value
     */
    public function setBizData($value)
    {
        $this->biz_data = $value;
    }

    /**
     * @return mixed
     */
    public function getSecondaryMerchantIndustry()
    {
        return $this->secondary_merchant_industry;
    }

    /**
     * @param $value
     */
    public function setSecondaryMerchantIndustry($value)
    {
        $this->secondary_merchant_industry = $value;
    }


    /**
     * @return mixed
     */
    public function getSecondaryMerchantId()
    {
        return $this->secondary_merchant_id;
    }

    /**
     * @param $value
     */
    public function setSecondaryMerchantId($value)
    {
        $this->secondary_merchant_id = $value;
    }

    /**
     * @return mixed
     */
    public function getSecondaryMerchantName()
    {
        return $this->secondary_merchant_name;
    }

    /**
     * @param $value
     */
    public function setSecondaryMerchantName($value)
    {
        $this->secondary_merchant_name = $value;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param $value
     */
    public function setStoreId($value)
    {
        $this->store_id = $value;
    }

    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->store_name;
    }

    /**
     * @param $value
     */
    public function setStoreName($value)
    {
        $this->store_name = $value;
    }

    /**
     * @return mixed
     */
    public function getTaxiOperationId()
    {
        return $this->taxi_operation_id;
    }

    /**
     * @param $value
     */
    public function setTaxiOperationId($value)
    {
        $this->taxi_operation_id = $value;
    }

    /**
     * @return mixed
     */
    public function getTaxiNumber()
    {
        return $this->taxi_number;
    }

    /**
     * @param $value
     */
    public function setTaxiNumber($value)
    {
        $this->taxi_number = $value;
    }

    /**
     * @return mixed
     */
    public function getTaxiDriverName()
    {
        return $this->taxi_driver_name;
    }

    /**
     * @param $value
     */
    public function setTaxiDriverName($value)
    {
        $this->taxi_driver_name = $value;
    }

    /**
     * @return mixed
     */
    public function getTaxiDriverMobile()
    {
        return $this->taxi_driver_mobile;
    }

    /**
     * @param $value
     */
    public function setTaxiDriverMobile($value)
    {
        $this->taxi_driver_mobile = $value;
    }


    /**
     * @return mixed
     */
    public function getTransCurrency()
    {
        return $this->trans_currency;
    }

    /**
     * @param $value
     */
    public function setTransCurrency($value)
    {
        $this->trans_currency = $value;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $value
     */
    public function setCurrency($value)
    {
        $this->currency = $value;
    }


    /**
     * @return mixed
     */
    public function getSysServiceProviderId()
    {
        return $this->sys_service_provider_id;
    }

    /**
     * @param $value
     */
    public function setSysServiceProviderId($value)
    {
        $this->sys_service_provider_id = $value;
    }


    /**
     * @return mixed
     */
    public function getChannelFee()
    {
        return $this->channel_fee;
    }

    /**
     * @param $value
     */
    public function setChannelFee($value)
    {
        $this->channel_fee = $value;
    }


    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * @param $value
     */
    public function setCountryCode($value)
    {
        $this->country_code = $value;
    }


    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $value
     */
    public function setAddress($value)
    {
        $this->address = $value;
    }


    /**
     * @return mixed
     */
    public function getPassbackParameters()
    {
        return $this->passback_parameters;
    }

    /**
     * @param $value
     */
    public function setPassbackParameters($value)
    {
        $this->passback_parameters = $value;
    }


    /**
     * @return mixed
     */
    public function getNotifyMobile()
    {
        return $this->notify_mobile;
    }

    /**
     * @param $value
     */
    public function setNotifyMobile($value)
    {
        $this->notify_mobile = $value;
    }


    /**
     * @return mixed
     */
    public function getNotifyWangwang()
    {
        return $this->notify_wangwang;
    }

    /**
     * @param $value
     */
    public function setNotifyWangwang($value)
    {
        $this->notify_wangwang = $value;
    }


    /**
     * @return mixed
     */
    public function getNotifyAlipayAccount()
    {
        return $this->notify_alipay_account;
    }

    /**
     * @param $value
     */
    public function setNotifyAlipayAccount($value)
    {
        $this->notify_alipay_account = $value;
    }

    public function getStaticBasicParams()
    {
        return array_merge(parent::getStaticBasicParams(), self::$params);
    }

    protected function getStaticBusinessParams()
    {
        return array_merge(parent::getStaticBusinessParams(), self::$bizDataParams);
    }

    protected function getRequestParams()
    {
        foreach ($this->getStaticBasicParams() as $key => $info) {
            $values[$key] = $this->{$key};
        }

        $bizValues = [];
        foreach ($this->getStaticBusinessParams() as $key => $info) {
            if ($this->{$key}) {
                $bizValues[$key] = $this->{$key};
            }
        }
        $this->biz_data = $values['biz_data'] = json_encode($bizValues, true);

        return $values;
    }


}