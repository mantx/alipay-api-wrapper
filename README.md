# alipay-api-wrapper

这里封装Alipay API接口的packagist包

1. 安装
composer require mantx/alipay-api-wrapper

2. 示例
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
try {
    $client = new \Alipay\AlipayClient();
    $response = $client->execute($request);
    var_dump($response->toArray());
} catch (Exception $e) {
    print($e->getMessage());
    var_dump($e->getTraceAsString());
}

