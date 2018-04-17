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
        '_input_charset' => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => 'The encoding format in merchant website such as utf-8, gbk and gb2312',
            'defaultValue' => self::DEFAULT_VALUE_CONFIG_INPUT_CHARSET
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

    /**
     * @return mixed
     */
    public function getInputCharset()
    {
        return $this->_input_charset;
    }

    /**
     * @param $value
     */
    public function setInputCharset($value)
    {
        $this->_input_charset = $value;
    }

    public function getStaticBasicParams()
    {
        return array_merge(parent::getStaticBasicParams(), self::$params);
    }

    /**
     * business params
     *
     * @return array
     */
    protected function getStaticBusinessParams()
    {
        return [];
    }

    /**
     * extend params
     *
     * @return array
     */
    protected function getStaticExtendParams()
    {
        return [];
    }

    protected function initializeValues()
    {
        parent::initializeValues();
        $this->setService($this->__serviceMethod);
    }

    public function checkResponse($request)
    {
        if (!in_array($this->getService(), $request['param'])) {
            throw new \Exception('The service in response does not match the one in request');
        }

        if (!in_array($this->getSign(), $request['param'])) {
            throw new \Exception('The sign in response does not match the one in request');
        }
    }


}