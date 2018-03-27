<?php

require(dirname(__DIR__) . '/src/Alipay/Request/AbstractRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/GlobalAbstractRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeCreateRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeModifyRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeModifyStatusRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeCancelRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeRefundRequest.php');
require(dirname(__DIR__) . '/src/Alipay/Request/AlipayMerchantQrcodeQueryRequest.php');



require(dirname(__DIR__) . '/src/Alipay/Utils/Sign.php');
require(dirname(__DIR__) . '/src/Alipay/Utils/Utility.php');
