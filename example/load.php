<?php
require(dirname(__DIR__) . '/src/Alipay/AlipayClient.php');

require(dirname(__DIR__) . '/src/Alipay/Datatype/Base.php');

require(dirname(__DIR__) . '/src/Alipay/Request/AbstractRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/GlobalAbstractRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/DomesticAbstractRequest.php');

require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeCreateRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeModifyRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeModifyStatusRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeCancelRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeRefundRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeQueryRequest.php');

require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradeRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradePagePayRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradePayRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradeRefundRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradeQueryRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradeFastpayRefundQueryRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayTradeCloseRequest.php');


require(dirname(__DIR__) . '/src/Alipay/Response/AbstractResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/GlobalAbstractResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/DomesticAbstractResponse.php');

require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeCreateResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeModifyResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeModifyStatusResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeCancelResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeRefundResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayMerchantQrcodeQueryResponse.php');

require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradeResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradePayResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradeRefundResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradeQueryResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradeFastpayRefundQueryResponse.php');
require(dirname(__DIR__) . '/src/Alipay/Response/AlipayTradeCloseResponse.php');


require(dirname(__DIR__) . '/src/Alipay/Utils/Sign.php');
require(dirname(__DIR__) . '/src/Alipay/Utils/Utility.php');
require(dirname(__DIR__) . '/src/Alipay/Utils/Config.php');
