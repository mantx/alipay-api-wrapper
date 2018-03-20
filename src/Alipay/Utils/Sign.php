<?php

namespace Alipay\Utils;


class Sign
{
    protected static $alipayPublicKey;
    protected static $privateKey;

    /**
     * @return mixed
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * @param $privateKey
     */
    public static function setPrivateKey($privateKey)
    {
        self::$privateKey = $privateKey;
    }

    /**
     * @return mixed
     */
    public static function getPaymaxPublicKey()
    {
        return self::$alipayPublicKey;
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setPaymaxPublicKey($alipayPublicKey)
    {
        self::$alipayPublicKey = $alipayPublicKey;
    }

    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function rsaSign($data)
    {
        $private_key =
            '-----BEGIN RSA PRIVATE KEY-----' .
            PHP_EOL . self::$privateKey . PHP_EOL .
            '-----END RSA PRIVATE KEY-----';
        $res         = openssl_get_privatekey($private_key);
        if ($res) {
            openssl_sign($data, $sign, $res);
        } else {
            throw new \Exception('The format of your private_key is incorrect!');
        }
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function rsaVerify($data, $sign)
    {
        $alipay_public_key =
            '-----BEGIN PUBLIC KEY-----' .
            PHP_EOL . self::$alipayPublicKey . PHP_EOL .
            '-----END PUBLIC KEY-----';
        $res               = openssl_get_publickey($alipay_public_key);
        if ($res) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        } else {
            throw new \Exception('The format of your alipay_public_key is incorrect!');
        }
        openssl_free_key($res);

        return $result;
    }

}