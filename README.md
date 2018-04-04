# alipay-api-wrapper

这里封装Alipay API接口的packagist包

1. 安装
composer require mantx/alipay-api-wrapper

2. 示例

//设置全局配置信息
\Alipay\Utils\Config::initConfig($alipay_config);


//建立请求
$request = new \Alipay\Request\AlipayMerchantQrcodeCreateRequest([
    "notify_url"                  => 'http://birdsystem/callback',
    //business params
    'secondary_merchant_industry' => '5812',
    'secondary_merchant_id'       => '123',
    'secondary_merchant_name'     => 'shawn store',
    'store_id'                    => 'A001',
    'store_name'                  => '李老板的东馆',
    'trans_currency'              => 'GBP',
    'currency'                    => 'GBP',
    //    'country_code'                => 'GB',
    //    'address'                     => 'Hangzhou Delixi building',
    'notify_mobile'               => '13612345678'
]);

//或者如下设置请求数据
//$request = new \Alipay\Request\AlipayMerchantQrcodeCreateRequest();
//$request->setNotifyUrl('http://birdsystem/callback');
//$request->setSecondaryMerchantIndustry('5812');
//$request->setSecondaryMerchantId('123');
//$request->setSecondaryMerchantName('shawn store');
//$request->setStoreId('A001');
//$request->setStoreName('李老板的东馆');
//$request->setTransCurrency('GBP');
//$request->setCurrency('GBP');
//$request->setNotifyMobile('13612345678');


try {
    $client = new \Alipay\AlipayClient();
    $response = $client->execute($request);
    //var_dump($response->toArray());
    var_dump($response->getQrcode());
    var_dump($response->getQrcodeImgUrl());
} catch (Exception $e) {
    print($e->getMessage());
    var_dump($e->getTraceAsString());
}

