<?php


namespace Alipay\Request;


abstract class GlobalAbstractRequest extends AbstractRequest
{
    private static $params = [
        'service' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The interface name',
            'defaultValue' => '',//alipay.commerce.qrcode.create
        ],
        'partner' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'The Alipay account generated when signing with Alipay; its length is 16, and it begins with 2088',
            'length'       => '16',
            'defaultValue' => self::DEFAULT_VALUE_CONFIG_PARTNER
        ],
    ];

    protected $__serviceMethod;

    public function getServiceAppId()
    {
        return $this->partner;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param $value
     */
    public function setService($value)
    {
        $this->service = $value;
    }

    /**
     * @return mixed
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param $value
     */
    public function setPartner($value)
    {
        $this->partner = $value;
    }

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }

    protected function initializeValues()
    {
        parent::initializeValues();
        $this->setService($this->__serviceMethod);
    }


}