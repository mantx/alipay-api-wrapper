<?php


namespace Alipay\Request;


abstract class DomesticAbstractRequest extends AbstractRequest
{
    private static $params = [
        'app_id'      => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '支付宝分配给开发者的应用ID',
            'maxLength'    => 32,
            'defaultValue' => self::DEFAULT_VALUE_CONFIG_APP_ID
        ],
        'method'      => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '接口名称',
            'maxLength'    => 128,
            'defaultValue' => '',//alipay.trade.page.pay
        ],
        'format'      => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '仅支持JSON',
            'maxLength'    => 40,
            'defaultValue' => 'JSON',
        ],
        'return_url'  => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '同步返回地址，HTTP/HTTPS开头字符串',
            'maxLength'    => 256,
            'defaultValue' => '',
        ],
        'timestamp'   => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '发送请求的时间，格式"yyyy-MM-dd HH:mm:ss"',
            'maxLength'    => 19,
            'defaultValue' => self::DEFAULT_VALUE_CURRENT_TIME,
        ],
        'version'     => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '调用的接口版本，固定为：1.0',
            'maxLength'    => 3,
            'defaultValue' => '1.0',
        ],
        'notify_url'  => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => '支付宝服务器主动通知商户服务器里指定的页面http/https路径。',
            'maxLength'    => 256,
            'defaultValue' => '',
        ],
        'biz_content' => [
            'type'         => 'string',
            'required'     => true,
            'comment'      => '业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递，具体参照各产品快速接入文档',
            'defaultValue' => '',
        ],
        'charset'     => [
            'type'         => 'string',
            'required'     => false,
            'comment'      => 'The encoding format in merchant website such as utf-8, gbk and gb2312',
            'maxLength'    => 10,
            'defaultValue' => self::DEFAULT_VALUE_CONFIG_INPUT_CHARSET
        ],
    ];

    private static $bizContentParams = [];
    private static $bizExtendParams = [];

    protected $__serviceMethod;

    protected $signSkippedParams = ['sign'];

    public function getServiceAppId()
    {
        return $this->app_id;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @param $value
     */
    public function setAppId($value)
    {
        $this->app_id = $value;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $value
     */
    public function setMethod($value)
    {
        $this->method = $value;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param $value
     */
    public function setFormat($value)
    {
        $this->format = $value;
    }


    /**
     * @param $value
     */
    public function setVersion($value)
    {
        $this->version = $value;
    }


    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param $value
     */
    public function setReturnUrl($value)
    {
        $this->return_url = $value;
    }

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
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param $value
     */
    public function setCharset($value)
    {
        $this->charset = $value;
    }


    /**
     * @return mixed
     */
    public function getBizContent()
    {
        return $this->biz_content;
    }

    /**
     * @param $value
     */
    public function setBizContent($value)
    {
        $this->biz_content = $value;
    }

    protected function initializeValues()
    {
        parent::initializeValues();
        $this->setMethod($this->__serviceMethod);
    }

    /**
     * basic params
     *
     * @return array
     */
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
        return self::$bizContentParams;
    }

    /**
     * extend params
     *
     * @return array
     */
    protected function getStaticExtendParams()
    {
        return self::$bizExtendParams;
    }

    protected function buildExtendParamsValue()
    {
        $extendValues = [];
        foreach ($this->getStaticExtendParams() as $key => $info) {
            if ($this->{$key}) {
                $extendValues[$key] = $this->{$key};
            }
        }
        if ($extendValues &&
            array_key_exists('extend_params', $this->getStaticBusinessParams())
        ) {
            $this->extend_params = json_encode($extendValues, true);
        }
    }

    protected function getRequestParams()
    {
        $values      = [];
        foreach ($this->getStaticBasicParams() as $key => $info) {
            $values[$key] = $this->{$key};
        }

        $this->buildExtendParamsValue();

        $bizValues = [];
        foreach ($this->getStaticBusinessParams() as $key => $info) {
            if ($this->{$key}) {
                $bizValues[$key] = $this->{$key};
            }
        }
        $this->biz_content = $values['biz_content'] = json_encode($bizValues, true);

        return $values;
    }

    public function checkResponse($response)
    {
//        if (!in_array($this->getService(), $request['param'])) {
//            throw new \Exception('The service in response does not match the one in request');
//        }
//
//        if (!in_array($this->getSign(), $request['param'])) {
//            throw new \Exception('The sign in response does not match the one in request');
//        }
    }


}