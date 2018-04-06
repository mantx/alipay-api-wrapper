<?php

namespace Alipay\Utils;


class Sign
{
    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function rsaSign($data, $signType = 'RSA')
    {
        if (Utility::checkEmpty(Config::getPrivateKey())) {
            throw new \Exception('RSA private key is empty');
        }

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
               wordwrap(Config::getPrivateKey(), 64, "\n", true) .
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
        if (Utility::checkEmpty(Config::getAlipayPublicKey())) {
            throw new \Exception('RSA public key is empty');
        }

        $res    = "-----BEGIN PUBLIC KEY-----\n" .
                  wordwrap(Config::getAlipayPublicKey(), 64, "\n", true) .
                  "\n-----END PUBLIC KEY-----";

        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }

        return $result;
    }

    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function md5Sign($data)
    {
        if (Utility::checkEmpty(Config::getMd5Key())) {
            throw new \Exception('md5 key is empty');
        }

        return md5($data . Config::getMd5Key());
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function md5Verify($data, $sign)
    {
        if (Utility::checkEmpty(Config::getMd5Key())) {
            throw new \Exception('md5 key is empty');
        }

        return md5($data . Config::getMd5Key()) === $sign;
    }


    /**
     * @param $data
     * @param $private_key
     *
     * @return string
     */
    public static function sign($data, $signType)
    {
        if (in_array(strtoupper($signType), ['RSA', 'RSA2'])) {
            return self::rsaSign($data, strtoupper($signType));
        } elseif (strtoupper($signType) == 'MD5') {
            return self::md5Sign($data);
        } else {
            throw new \Exception('Unsupported Sign: ' . $signType);
        }
    }

    /**
     * @param $data
     * @param $alipay_public_key
     * @param $sign
     *
     * @return bool
     */
    public static function verify($data, $sign, $signType)
    {
        if (in_array(strtoupper($signType), ['RSA', 'RSA2'])) {
            return self::rsaVerify($data, $sign, strtoupper($signType));
        } elseif (strtoupper($signType) == 'MD5') {
            return self::md5Verify($data, $sign);
        } else {
            throw new \Exception('Unsupported Sign: ' . $signType);
        }
    }

}