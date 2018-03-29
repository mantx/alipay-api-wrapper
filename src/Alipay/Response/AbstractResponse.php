<?php

namespace Alipay\Response;

use Alipay\Datatype\Base;
use Alipay\Utils\Utility;

abstract class AbstractResponse extends Base
{
    private static $params = [
    ];

    protected $__entityNode;

    public function getDataEntityNodeInResponse()
    {
        return $this->__entityNode;
    }

    public function getParams()
    {
        $baseParams = parent::getParams();

        return array_merge($baseParams, self::$params);
    }

    public function initFromResponse($object)
    {
        $accessNodes = $this->getDataEntityNodeInResponse();
        $accessNodes = explode('.', $accessNodes);
        foreach ($accessNodes as $node) {
            if (isset($object[$node])) {
                $object = $object[$node];
            }
        }

        if (isset($object) && is_array($object)) {
            foreach ($object as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function getSignContent()
    {
        return Utility::concatSignParams($this->values);
    }
}