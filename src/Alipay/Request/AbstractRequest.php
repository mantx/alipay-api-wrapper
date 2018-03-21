<?php

namespace Alipay\Request;

abstract class AbstractRequest
{
    protected $values = [];

    private static $params = [
        'sign'           => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength'    => '10',
            'defaultValue' => ''
        ],
        'sign_type'      => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        'service'        => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        'partner'        => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '',
            'length'       => '16',
            //            'maxLength' => '10',
            'defaultValue' => 'RSA'
        ],
        '_input_charset' => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '',
            //            'maxLength' => '10',
            'defaultValue' => 'GBK'
        ],
    ];

    public function __construct()
    {
        $this->initializeValues();
        $args = func_get_args();
        if (isset($args[0]) && is_array($args[0])) {
            foreach ($args[0] as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Magic isset function
     *
     * @param string $key Key to check
     *
     * @return bolean True if it exsits, false otherwise
     */
    final public function __isset($key)
    {
        return array_key_exists($key, $this->values);
    }

    /**
     * Magic getter function
     *
     * @param string $key Key to get
     *
     * @return mixed Value of the property
     * @throws \InvalidArgumentException Throws exceptin if key is not valid
     */
    final public function __get($key)
    {
        //$key = lcfirst($key);
        if (!array_key_exists($key, $this->values)) {
            throw new \InvalidArgumentException('Field : ' . $key . ' is not defined for ' . get_class($this));
        }

        return $this->values[$key];
    }

    /**
     * Magic setter function
     *
     * @param string $key   Key to set
     * @param mixed  $value Value to set
     *
     * @return void
     * @throws \InvalidArgumentException Throws exception if key is not valid
     */
    final public function __set($key, $value)
    {
        //$key = lcfirst($key);
        if (!array_key_exists($key, $this->values)) {
            throw new \InvalidArgumentException('Field : ' . $key . ' is not defined for ' . get_class($this));
        }

        $this->validateParameterType($key, $value);
        $this->validateParameterValue($key, $value);
        $this->values[$key] = $value;
    }


    protected function initializeValues()
    {
        $params = $this->getRequestParams();
        foreach ($params as $name => $infos) {
            if (isset($infos['multivalues']) && $infos['multivalues']) {
                $this->values[$name] = array();
            } elseif (isset($infos['defaultValue']) && $infos['defaultValue']) {
                $this->values[$name] = $infos['defaultValue'];
            } else {
                $this->values[$name] = null;
            }
        }
    }

    public function getRequestParams()
    {
        return self::$params;
    }


    /**
     * Validate all parameters
     *
     * @return boolean True upon success
     * @throws \InvalidArgumentException Throws exception if type not valid or if value are missing
     */
    protected function validateParams()
    {
        $params = $this->getRequestParams();
        foreach ($params as $name => $infos) {
            if ($this->values[$name]) {
                $this->validateParameterType($name, $this->values[$name]);
                $this->validateParameterValue($name, $this->values[$name]);
            } elseif ($infos['required']) {
                throw new \InvalidArgumentException(sprintf('Field %s cannot be null', $name));
            }
        }

        return true;
    }

    /**
     * Validate the type of a parameter
     *
     * @param string $key   Key to check
     * @param mixed  $value Value to check
     *
     * @return boolean True upon success
     * @throws \InvalidArgumentException Throws exception if type is not valid
     */
    protected function validateParameterType($key, $value)
    {
        $params = $this->getRequestParams();
        if (null === $value) {
            return true;
        }

        switch ($params[$key]['type']) {
            case 'string':
                if (is_array($value) && isset($params[$key]['multivalues']) &&
                    true === $params[$key]['multivalues']
                ) {
                    foreach ($value as $subvalue) {
                        if (null !== $subvalue && $subvalue !== (string)$subvalue) {
                            throw new \InvalidArgumentException('Invalid type for ' . $key . '. It should be of type : '
                                                                . $params[$key]['type'] .
                                                                ' but it has a value of : ' . $subvalue);
                        }
                    }
                } elseif ($value !== (string)$value) {
                    throw new \InvalidArgumentException('Invalid type for ' . $key . '. It should be of type : '
                                                        . $params[$key]['type'] . ' but it has a value of : ' .
                                                        $value);
                }
                break;

            case 'datetime':
            case 'date-iso8601':
                $timestamp = strtotime($value);
                $date      = date(DATE_ISO8601, $timestamp);
                if (strtotime($date) !== strtotime($value)) {
                    throw new \InvalidArgumentException('Invalid type for ' . $key . '. It should be of type : '
                                                        . $params[$key]['type'] . ' but it has a value of : ' .
                                                        $value);
                }
                break;

            case 'positiveInteger':
            case 'negativeInteger':
            case 'integer':
                if (false === filter_var((int)$value, FILTER_VALIDATE_INT) && ((int)$value != $value)) {
                    throw new \InvalidArgumentException('Invalid type for ' . $key . '. It should be of type : '
                                                        . $params[$key]['type'] . ' but it has a value of : ' .
                                                        $value);
                }
                break;

            default:
                break;
        }

        return true;
    }

    /**
     * Validate the value of a parameter
     *
     * @param string $key   Key to check
     * @param mixed  $value Value to check
     *
     * @return boolean True upon success
     * @throws \InvalidArgumentException Throws exception if value is not valid
     */
    protected function validateParameterValue($key, $value)
    {
        $params = $this->getRequestParams();

        foreach ($params[$key] as $type => $typeValue) {
            switch ($type) {
                case 'enumeration':
                    $acceptedValues = explode(',', $typeValue);
                    if (!in_array($value, $acceptedValues)) {
                        throw new \InvalidArgumentException('Field ' . $key . ' cannot be set to value : ' . $value .
                                                            '. Accepted values are : ' . $typeValue);
                    }
                    break;

                case 'length':
                    if (strlen($value) != $typeValue) {
                        throw new \InvalidArgumentException('Field ' . $key . ' has a size of ' . strlen($value) .
                                                            ' and it should be that size : ' . $typeValue);
                    }
                    break;

                case 'maxLength':
                    if (strlen($value) > $typeValue) {
                        throw new \InvalidArgumentException('Field ' . $key . ' has a size of ' . strlen($value) .
                                                            ' and it cannot exceed this size : ' . $typeValue);
                    }
                    break;

                case 'minLength':
                    if (strlen($value) < $typeValue) {
                        throw new \InvalidArgumentException('Field ' . $key . ' has a size of ' . strlen($value) .
                                                            ' and it cannot be less than this size : ' . $typeValue);
                    }
                    break;

                case 'minInclusive':
                    if ($value < $typeValue) {
                        throw new \InvalidArgumentException('Field ' . $key . ' cannot be smaller than ' . $typeValue);
                    }
                    break;

                case 'maxInclusive':
                    if ($value > $typeValue) {
                        throw new \InvalidArgumentException('Field ' . $key . ' cannot be higher than ' . $typeValue);
                    }
                    break;

                case 'pattern':
                    $matches   = array();
                    $typeValue = "/" . $typeValue . "/";
                    if (1 !== preg_match($typeValue, $value, $matches) || (strlen($value) > 0 && !$matches[0])) {
                        throw new \InvalidArgumentException('Field ' . $key . ' should match regex pattern : ' .
                                                            $typeValue . ' and it has a value of ' . $value);
                    }
                    break;
            }
        }

        return true;
    }
}