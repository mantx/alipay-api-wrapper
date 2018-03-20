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
    public static function getAlipayPublicKey()
    {
        return self::$alipayPublicKey;
    }

    /**
     * @param mixed $alipayPublicKey
     */
    public static function setAlipayPublicKey($alipayPublicKey)
    {
        self::$alipayPublicKey = $alipayPublicKey;
    }

    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function rsaSign($data, $signType = 'RSA')
    {
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
               wordwrap(self::$privateKey, 64, "\n", true) .
               "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

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
    public static function rsaVerify($data, $sign, $signType = 'RSA')
    {
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
               wordwrap(self::$alipayPublicKey, 64, "\n", true) .
               "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }

        return $result;
    }

}