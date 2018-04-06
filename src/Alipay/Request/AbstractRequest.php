<?php

namespace Alipay\Request;

use Alipay\Datatype\Base;
use Alipay\Utils\Sign;
use Alipay\Utils\Utility;

abstract class AbstractRequest extends Base
{
    private static $params = [
        'sign'           => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => 'See the “Digital Signature”',
            'defaultValue' => ''
        ],
        'sign_type'      => [
            'type'         => 'string',
            'required'     => true,
            'enumeration'  => 'DSA, RSA, RSA2, MD5',
            'comment'      => 'Four values, namely, DSA, RSA, RSA2 and MD5 can be chosen; and must be capitalized',
            'defaultValue' => self::DEFAULT_VALUE_CONFIG_SIGN_TYPE
        ],
    ];

    protected $signSkippedParams = ['sign', 'sign_type'];

    abstract public function getServiceAppId();

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param $value
     */
    public function setSign($value)
    {
        $this->sign = $value;
    }

    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->sign_type;
    }

    /**
     * @param $value
     */
    public function setSignType($value)
    {
        $this->sign_type = $value;
    }
    /**
     * basic params
     *
     * @return array
     */
    public function getBasicParams()
    {
        $baseParams = parent::getAllParams();

        return array_merge($baseParams, self::$params);
    }

    /**
     * business params
     *
     * @return array
     */
    abstract protected function getBusinessParams();

    /**
     * extend params
     *
     * @return array
     */
    abstract protected function getExtendParams();

    /**
     * all params, including basic/business/extend params altogether
     *
     * @return array
     */
    public function getAllParams()
    {
        return array_merge($this->getBasicParams(),
            $this->getBusinessParams(),
            $this->getExtendParams());
    }

    public function getRequestParamsAsUrl()
    {
        $finalParams      = [];
        $allRequestParams = $this->getRequestParamsWithSign();

        //validate all values
        $this->validateParams();

        foreach ($allRequestParams as $key => $value) {
            if ($key && $value) {
                $finalParams[$key] = $key . '=' . urlencode($value);
            }
        }
        ksort($finalParams);

        $arg = implode('&', $finalParams);

//        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
    }


    protected function getRequestParams()
    {
        return $this->values;
    }

    public function getRequestParamsWithSign()
    {
        $this->sign = Sign::sign($this->getSignContent(), $this->sign_type);

        return $this->getRequestParams();
    }

    protected function getSignContent()
    {
        $signParams = $this->getRequestParams();
        return Utility::concatSignParams($signParams, $this->signSkippedParams);
    }
}