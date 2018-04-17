<?php

require_once("alipay.domestic.config.php");
require_once("load.php");

//require(dirname(__DIR__) . '/vendor/autoload.php');
\Alipay\Utils\Config::initConfig($alipay_config);

if (!\Alipay\Utils\Sign::verify(
    \Alipay\Utils\Utility::concatSignParams($_GET),
    $_GET['sign'],
    $_GET['sign_type'])
) {
    var_dump('sign failed');
}

var_dump($_GET);