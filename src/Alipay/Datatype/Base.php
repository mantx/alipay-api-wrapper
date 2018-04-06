<?php

namespace Alipay\Datatype;

use Alipay\Utils\Config;
use Alipay\Utils\Utility;

/**
 * Class Base
 *
 * @package Alipay\Datatype
 */
abstract class Base
{
    const DEFAULT_VALUE_CURRENT_TIME = 'CALL FUNCTION:DEFAULT_VALUE_CURRENT_TIME';
    const DEFAULT_VALUE_RAMDEOM_NUMBER = 'CALL FUNCTION:DEFAULT_VALUE_RAMDEOM_NUMBER';
    const DEFAULT_VALUE_CONFIG_PARTNER = 'CONFIG GET:getPartner';
    const DEFAULT_VALUE_CONFIG_INPUT_CHARSET = 'CONFIG GET:getInputCharset';
    const DEFAULT_VALUE_CONFIG_SIGN_TYPE = 'CONFIG GET:getSignType';
    const DEFAULT_VALUE_CONFIG_APP_ID = 'CONFIG GET:getAppId';

    protected $values = [];

    private static $params = [];

    /**
     * Parent node name of the object
     *
     * @var string
     */
    protected $_xmlNodeName = null;


    /**
     * AbstractRequest constructor.
     */
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

    /**
     * Setter for multivalues field
     *
     * @param string $key   Key to set
     * @param mixed  $value Value to set
     *
     * @return void
     * @throws \InvalidArgumentException Throws exception if key is not valid
     */
    public function __call(
        $name,
        $arguments
    ) {
        $key = str_replace('add', '', $name);

        if (isset($params[$key . 's'])
            && $params[$key . 's']['type'] != 'string'
            && isset($params[$key . 's']['multivalues'])
            && true === $params[$key . 's']['multivalues']
        ) {
            $key .= 's';
        }

        $key = lcfirst($key);

        if (!array_key_exists($key, $this->values)) {
            throw new \InvalidArgumentException('Field : ' . $key . ' is not defined for ' . get_class($this));
        }

        if (empty($arguments) && count($arguments) > 1) {
            throw new \InvalidArgumentException($name . ' method takes only 1 argument');
        }

        $this->validateParameterType($key, $arguments[0]);
        $this->validateParameterValue($key, $arguments[0]);

        if (isset($params[$key]['multivalues']) && $params[$key]['multivalues']) {
            $this->values[$key][] = $arguments[0];
        } else {
            throw new \InvalidArgumentException('This is not a multivalues field : ' . $key . ' called via method ' .
                                                $name);
        }
    }


    /**
     * Check if current object is empty or not
     *
     * @return boolean True if it is, false otherwise
     */
    public function isEmpty()
    {
        foreach ($this->values as $k => $v) {
            if (is_object($v)) {
                if (!$v->isEmpty()) {
                    return false;
                }
            } elseif (!empty($v) && $v !== null) {
                return false;
            }
        }

        return true;
    }


    public function getAllParams()
    {
        return self::$params;
    }

    /**
     * Generates the XML to be sent to DHL
     *
     * @param \XMLWriter $xmlWriter XMl Writer instance
     *
     * @return void
     */
    public function toXML(\XMLWriter $xmlWriter = null, $parentXmlNodeName = null)
    {
        $displayedParentNode = false;
        $this->validateParams();

        if (null !== $parentXmlNodeName) {
            $parentNode = $parentXmlNodeName;
        } elseif (null !== $this->_xmlNodeName) {
            $parentNode = $this->_xmlNodeName;
        } else {
            $parts      = explode('\\', get_class($this));
            $parentNode = lcfirst(array_pop($parts));
        }

        $xmlWriter->startElement($parentNode);
        $params = $this->getAllParams();
        foreach ($params as $name => $infos) {
            if ($infos['required'] || $this->$name) {
                $xmlNodeName = isset($infos['xmlNodeName']) ? $infos['xmlNodeName'] : null;
                if (is_object($this->$name)) {
                    $this->$name->toXML($xmlWriter, $xmlNodeName);
                } elseif (is_array($this->$name)) {
                    if ('subobject' === $infos['type']) {
                        if (!isset($params[$name]['disableParentNode']) ||
                            false == $params[$name]['disableParentNode']
                        ) {
                            $xmlWriter->startElement($name);
                        }

                        foreach ($this->$name as $subelement) {
                            $subelement->toXML($xmlWriter, $xmlNodeName);
                        }

                        if (!isset($params[$name]['disableParentNode']) ||
                            false == $params[$name]['disableParentNode']
                        ) {
                            $xmlWriter->endElement();
                        }
                    } else {
                        foreach ($this->$name as $subelement) {
                            $this->writeContent($xmlWriter, $name, $subelement);
                        }
                    }

                } else {
                    $this->writeContent($xmlWriter, $name, $this->$name);
                }
            }
        }

        $xmlWriter->endElement(); // End of parent node
    }

    /**
     * @param \XMLWriter $xmlWriter
     * @param            $name
     * @param            $content
     */
    public function writeContent(
        \XMLWriter $xmlWriter,
        $name,
        $content
    ) {
        $params = $this->getAllParams();
        $infos  = $params[$name];
        switch ($infos['type']) {
            case 'boolean' :
                $content = $content ? 'true' : 'false';
                break;
            default:
                $content = $content;
        }
        if (isset($infos['attribute']) && $infos['attribute']) {
            $xmlWriter->writeAttribute($name, $content);
        } else {
            $xmlWriter->writeElement($name, $content);
        }
    }

    /**
     * Initialize object from an XML string
     *
     * @param string $xml XML String
     *
     * @return void
     */
    public function initFromXML($xml)
    {
        $params = $this->getAllParams();

        $xml       = simplexml_load_string(str_replace('req:', '', $xml));
        $parts     = explode('\\', get_class($this));
        $className = array_pop($parts);
        foreach ($xml->children() as $child) {
            $childName = $child->getName();

            if (isset($this->$childName) && is_object($this->$childName)) {
                $this->$childName->initFromXml($child->asXML());
            } elseif (isset($params[$childName]['multivalues']) && $params[$childName]['multivalues']) {
                foreach ($child->children() as $subchild) {
                    $subchildName   = $subchild->getName();
                    $childClassname = implode('\\', $parts) . '\\' . $params[$subchildName]['type'];
                    $childClassname = str_replace('Entity', 'Datatype', $childClassname);
                    if ('string' == $params[$subchildName]['type']) {
                        $childObj = trim((string)$subchild);
                    } else {
                        $childObj = new $childClassname();
                        $childObj->initFromXml($subchild->asXML());
                    }
                    $addMethodName = 'add' . ucfirst($subchildName);
                    $this->$addMethodName($childObj);
                }
            } elseif (isset($this->$childName) && ((string)$child)) {
                $this->$childName = trim((string)$child);
            }
        }
    }


    protected function initializeValues()
    {
        $params = $this->getAllParams();
        foreach ($params as $name => $infos) {
            if (isset($infos['multivalues']) && $infos['multivalues']) {
                $this->values[$name] = array();
            } elseif (isset($infos['subobject']) && $infos['subobject']) {
                $tmp   = get_class($this);
                $parts = explode('\\', $tmp);
                array_pop($parts);
                $className           = implode('\\', $parts) . '\\' . $infos['type'];
                $this->values[$name] = new $className();
            } elseif (isset($infos['defaultValue']) && $infos['defaultValue']) {
                if ($infos['defaultValue'] === self::DEFAULT_VALUE_CURRENT_TIME) {
                    $this->values[$name] = Utility::currentTime();
                } elseif ($infos['defaultValue'] === self::DEFAULT_VALUE_RAMDEOM_NUMBER) {
                    $this->values[$name] = Utility::randomNumber();
                } elseif ($infos['defaultValue'] === self::DEFAULT_VALUE_CONFIG_SIGN_TYPE) {
                    $this->values[$name] = Config::getSignType();
                } elseif ($infos['defaultValue'] === self::DEFAULT_VALUE_CONFIG_INPUT_CHARSET) {
                    $this->values[$name] = Config::getCharset();
                } elseif ($infos['defaultValue'] === self::DEFAULT_VALUE_CONFIG_PARTNER) {
                    $this->values[$name] = Config::getPartner();
                } elseif ($infos['defaultValue'] === self::DEFAULT_VALUE_CONFIG_APP_ID) {
                    $this->values[$name] = Config::getAppId();
                } else {
                    $this->values[$name] = $infos['defaultValue'];
                }
            } else {
                $this->values[$name] = null;
            }
        }
    }

    /**
     * Validate all parameters
     *
     * @return boolean True upon success
     * @throws \InvalidArgumentException Throws exception if type not valid or if value are missing
     */
    protected function validateParams()
    {
        $params = $this->getAllParams();
        foreach ($params as $name => $infos) {
            if ($this->values[$name]) {
                if (is_array($this->values[$name]) && isset($infos['subobject']) && true === $infos['subobject']) {
                    foreach ($this->values[$name] as $subelement) {
                        $subelement->validateParams();
                    }
                } else {
                    $this->validateParameterType($name, $this->values[$name]);
                    $this->validateParameterValue($name, $this->values[$name]);
                }
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
        $params = $this->getAllParams();
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
                } elseif ($value != (string)$value) {
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

            case 'float':
                if (false === filter_var((int)$value, FILTER_VALIDATE_FLOAT) && ((int)$value != $value)) {
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
        $params = $this->getAllParams();

        foreach ($params[$key] as $type => $typeValue) {
            switch ($type) {
                case 'enumeration':
                    $acceptedValues = explode(',', str_replace(' ', '', $typeValue));
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

    public function toArray()
    {
        return $this->values;
    }

}
