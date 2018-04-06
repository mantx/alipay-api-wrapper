<?php


namespace Alipay\Request;


class AlipayMerchantQrcodeModifyStatusRequest extends AlipayMerchantQrcodeRequest
{
    const STATUS_STOP = 'STOP';
    const STATUS_DELETE = 'DELETE';
    const STATUS_RESTART = 'RESTART';


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
        'qrcode'     => [
            'type'     => 'string',
            'required' => true,
            'comment'  => 'The returned QR code value after the code is generated successfully.',
        ],
        'status'     => [
            'type'        => 'string',
            'required'    => true,
            'comment'     => 'Three types of status are supported' .
                             'STOP： Stop the QR code. If the user scans the stopped QR code,' .
                             'he will be notified that the QR code is invalid.' .
                             'RESTART： The QR code can be used after the restart.' .
                             'DELETE：Delete the QR code. If the user scans the deleted QR code,' .
                             'he will be notified hat the QR code is invalid.' .
                             'The code can’t be restarted after being deleted.',
            'enumeration' => 'STOP, RESTART, DELETE',
        ]
    ];

    protected $__serviceMethod = 'alipay.commerce.qrcode.modifyStatus';

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
    public function getQrcode()
    {
        return $this->qrcode;
    }

    /**
     * @param $value
     */
    public function setQrcode($value)
    {
        $this->qrcode = $value;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $value
     */
    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getBasicParams()
    {
        return array_merge(parent::getBasicParams(), self::$params);
    }

}