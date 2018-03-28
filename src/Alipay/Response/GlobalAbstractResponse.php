<?php


namespace Alipay\Request;


abstract class GlobalAbstractResponse extends AbstractResponse
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
            'defaultValue' => ''
        ],
    ];

    protected $__serviceMethod;

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