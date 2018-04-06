<?php
/* *
 * 配置文件
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	
 * 提示：如何获取安全校验码和合作身份者id
 * 1.用您的签约支付宝账号登录支付宝网站(www.alipay.com)
 * 2.点击“商家服务”(https://b.alipay.com/order/myorder.htm)
 * 3.点击“查询合作者身份(pid)”、“查询安全校验码(key)”
	
 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字
$alipay_config['partner']		= '2088021966388155';

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCJwbFWLQ4y6V5tSjxA8PDwbEMpHMz09iv6JW94UcCyn8hxDaMybGBApngyEzecE5AErlgnDznF1MvmU9yOccFACSTvH4MibpFjhC1nCbvMwEPJibDo3PK9Hi2b8TF7efgKMnaqn1EfeOBy7hC5x3d/4z92KcVSXBI08r/0TwrgsHdyibzTlZVPXp3wU8hcgcfcZEote4Xbmjn/UEIL+8KWcz8Hkdih37Q7/XGwjvNW5ZPOFMxGsBS7uD76u1Ep9pLLBPTeJxX72J8z/San16SQmvL2u7a2dZo6NqhAXAcLU+nzXldm6q2OwVAYCi1IxubhVsdK+bvUGd2C6Q/vBLntAgMBAAECggEAEFA4wPzK7qqGPSkKY6Jk1gPsHCVF/EhewtvGDJiZ2k1jvkegKOt+polQOJXgAwKqDnPbCp0Z+VyO3PLXbqL4AK5UimDP9bbkTsWrXsVfUQr/vBErOxhXQqAdRJdWhcnW3tZFCUWepLx60AFzR5zggOuXa1XdATjYCx8oLjViE2OF9zaCDoxxB/zAkSjzat0z8O+Zb4HH6GJt6V4TQCPNSf9eDqMMuQqWr2qFbKgFJantALSMJhoxBiSrNuhEodnUOdvo1czDPb53sB6Fiv0xR2sNKEaJT4arggQL+nmW0O0BGEkPSLmAhDuwz6cVtejZfGs8SYGzq7RVvD4CILWuAQKBgQC8vrjKT0YybZlmac9RX7U144044d1erlbMzWt5IstWDYo2Lc7R8nY8wteaxnhfP8sO41uXvvwS8awg7VsSDOH9vRDvwSXI6aivmOnPZjixV/tehycJeVtzX4kXMwIms0l8fGmVW9Y5ar50qUNylUM5GsPt/JGtPza7Cj0Ve09ZbQKBgQC619IXydwmJD5BUzU/acM1cXunFCmAuhEuEUWCvmfCZwuq3/4XVwAvqe0tACQLA2A6ex2VrwsmfbI4Y3wq20rOyhCP/djcC9Smp9WBGRcsVPJrls+A3wc//94FvMgriKJbnCiXoZEIH0Eh2GYrP2uNrAePoBQrTGsFKUjHZlsSgQKBgEQuOR6LyHXK9ZDzQ/rHMfSHgKo9nPPo0l4lDl+x2/X36idsILvidCe60puMekseBkIYiyujx/cn6d/zHeTFVpWMSKPzB60uCstz13IeIPifKaSZ+dYISqrApgsFWA+W0ELxxko35IjVMHt/8Wdg1+m263P6urz0itbB+hLaem15AoGAe/K4ePd8iAD7G7LrXAn5afbCpPAHKFJHG1xx1G4jvx9E6jJ2CV25zeTYZkX1oyi2KZWK5sWcjAhOtoGo2XVohw4dNqibuD5Q783fISlX6hzgROdi+Ib79ET1MLEvyVF3A3bwpsaTw+OX/a/k90O3QeChk3IKbz7esCnXEhCg0gECgYEAiwcjRLS+FqdCdFOEV3KyN3sjIGz8QmO+YxXuptgoJgT5qknN0VJC6U9jaI9EaoTpxM5sBiiAwL/pv/A0AGgCuYr31p1F3IO5f+u3yetbz8gNoTsaQJ/aEYPakoNIJcl2Va+Q1A3xKE/iPXHXzMHmTgB3cJ6XmBiYtGI4+4GpXZc=';

//支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm 
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';

$alipay_config['md5_key'] = '9zuyogtrxxi3iux2hz4lbwpiiy0uc0ha';


//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
//$alipay_config['cacert']    = getcwd().'/cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
//$alipay_config['transport']    = 'http';
?>