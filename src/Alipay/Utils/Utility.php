<?php


namespace Alipay\Utils;


class Utility
{
    public static function currentTime($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function randomNumber($length = 10)
    {
        $start = 1;
        $end   = 9;
        for ($i = 0; $i < $length; $i++) {
            $start *= 10;
            $end = $end * 10 + $end;
        }

        return mt_rand($start, $end);
    }


    public static function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if ($value === null) {
            return true;
        }
        if (trim($value) === "") {
            return true;
        }

        return false;
    }

    public static function curl($url, $postFields = null, $charset = 'UTF-8')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $postBodyString = "";
        $encodeArray    = Array();
        $postMultipart  = false;

        if (is_array($postFields) && 0 < count($postFields)) {
            foreach ($postFields as $key => $value) {
                if ("@" != substr($value, 0, 1)) //判断是不是文件上传
                {
                    $postBodyString .= "$key=" . urlencode($value) . "&";
                    $encodeArray[$key] = $value;
                } else //文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart     = true;
                    $encodeArray[$key] = new \CURLFile(substr($value, 1));
                }
            }
            unset ($key, $value);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeArray);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }

        if ($postMultipart) {
            $headers = [
                'content-type: multipart/form-data;charset=' . $charset . ';boundary=' . Utility::getMillisecond()
            ];
        } else {
            $headers = [
                'content-type: application/x-www-form-urlencoded;charset=' . $charset
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new \Exception($response, $httpStatusCode);
            }
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header      = substr($response, 0, $header_size);
        $body        = substr($response, $header_size);

        curl_close($ch);

        return [
            'header' => $header,
            'body'   => $body
        ];
    }

    public static function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());

        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    /**
     * 转换字符集编码
     *
     * @param $data
     * @param $targetCharset
     *
     * @return string
     */
    public static function charsetConvert($text, $from, $target)
    {
        if (!empty($text)) {
            if (strcasecmp($from, $target) != 0) {
                $text = mb_convert_encoding($text, $target, $from);
                //				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }

        return $text;
    }

    public static function concatSignParams($signParams, $signSkippedParams = ['sign', 'sign_type'])
    {
        $signData   = [];
        foreach ($signParams as $key => $value) {
            if (!in_array($key, $signSkippedParams) &&
                (false === Utility::checkEmpty($value)) &&
                ("@" != substr($value, 0, 1))
            ) {
                $signData[$key] = $key . '=' . rawurldecode($value);
            }
        }
        ksort($signData);

        return implode('&', $signData);
    }


}