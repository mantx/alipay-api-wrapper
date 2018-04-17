<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>支付宝alipay.trade.page.pay接口</title>
</head>

<?php

require_once("alipay.domestic.config.php");
require_once("load.php");

//require(dirname(__DIR__) . '/vendor/autoload.php');
\Alipay\Utils\Config::initConfig($alipay_config);


//建立请求
$request = new \Alipay\Request\AlipayTradePagePayRequest([
    "notify_url"   => 'http://localhost/alipay-api-wrapper/example/tradePagePayCallback.php',
    "return_url"   => 'http://localhost/alipay-api-wrapper/example/tradePagePayCallback.php',

    //business params
    'body'         => 'Shawn test pay body',
    'subject'      => 'shawn test pay subject',
    'total_amount' => mt_rand(1, 1000) / 100,
    'out_trade_no' => md5(mt_rand(10000, 99999) . uniqid() . microtime()),
]);

//method 2
//$request = new \Alipay\Request\AlipayMerchantQrcodeCreateRequest();
//$request->setNotifyUrl('http://birdsystem/callback');
//$request->setSecondaryMerchantIndustry('5812');
//$request->setSecondaryMerchantId('123');tradePagePay.php
//$request->setSecondaryMerchantName('shawn store');
//$request->setStoreId('A001');
//$request->setStoreName('李老板的东馆');
//$request->setTransCurrency('GBP');
//$request->setCurrency('GBP');
//$request->setNotifyMobile('13612345678');

$client = new \Alipay\AlipayClient();

try {
    $url = $client->getAccessPointUrl($request) . $request->getRequestParamsAsUrl();
    header('Location: ' . $url);
//    $response = $client->execute($request);
//    var_dump($response->toArray());
} catch (Exception $e) {
    print($e->getMessage());
    var_dump($e->getTraceAsString());
}
die();


//$html_text = $alipaySubmit->buildRequestHttp($parameter);
//
//echo $html_text;
//解析XML
//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
//$doc = new DOMDocument();
//$doc->loadXML($html_text);

//请在这里加上商户的业务逻辑程序代码

//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

//解析XML
//if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
//	$alipay = $doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
//	echo $alipay;
//}

//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

?>
</body>
</html>