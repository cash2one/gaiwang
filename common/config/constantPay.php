<?php
/**
 * 银联在线支付 v36接口
 */
//支付接口URL
define('UNION_PAY_URL', 'https://www.gnete.com/bin/scripts/OpenVendor/gnete/V36/GetOvOrder.asp');
//订单查询接口
define('UNION_PAY_RESULT_URL', 'https://www.gnete.com/bin/scripts/OpenVendor/gnete/V34/GetPayResult.asp');
//商户ID member_id
define('UNION_MEMBER_ID', '0HP');
//商户证书
define('UNION_MER_KEY', '4f46ccc43fc6d56b4ce52e9f7d486d1c');
//对账用户
define('UNION_CHECK_UID','T11255');
//对账用户密码
define('UNION_CHECK_PWD','67030508');


/**
 * 银联支付 wap
 */
define('SDK_FRONT_TRANS_URL','https://gateway.95516.com/gateway/api/frontTransReq.do');
define('SDK_APP_TRANS_URL','https://gateway.95516.com/gateway/api/appTransReq.do');//APP控件
define('UNION_WAPPAY_MID','898440148160317');


/**
 * 环迅支付
 */
//商户号
define('IPS_MER_CODE','027012');
//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
define('IPS_MER_KEY','57215965246382955472079551489800068319130057825812553117766457533532453524292163557734795064377241339245893881550380089973749824');
//支付接口url
define('IPS_PAY_URL','https://pay.ips.com.cn/ipayment.aspx');
//订单查询接口
define('IPS_PAY_RESULT','http://webservice.ips.com.cn/Sinopay/Standard/IpsCheckTrade.asmx');
/**
 * 翼支付
 */
define('BEST_MER_CODE','02440103040117000'); //商户号   02440103040117000     30401170
define('BEST_KEY','0AB734562193CD01C67791B95A7C0D71CBEB9AC3E99784F4'); //数据Key，数据加密用，交易key:448841​
define('BEST_PAY_URL','https://webpaywg.bestpay.com.cn/payWeb.do'); //web支付接口
define('BEST_WAPPAY_URL','https://wappaywg.bestpay.com.cn/payWap.do'); //微商城wap支付接口
define('BEST_PAY_RESULT','https://webpaynotice.bestpay.com.cn/commorderQuery.do'); //订单查询接口
/** 代扣相关 */
define('BEST_MER_ID', '8614110501390861'); //MERID
define('BEST_SERVICE_URL', 'https://enterprise.bestpay.com.cn/bppf_inf/services/DealProcessor?wsdl'); //代扣地址
define('BEST_TMNNUM', '440106016411'); //终端受理号
define('BEST_TRANSCONTRACTID', '51441098000031464'); //签约ID
define('BEST_BANKACCT', '6222023602047811456'); //银行账号
define('BEST_RSA_FILE', 'b_server'); //证书、密钥文件名

/**
 * 电信合约机
 */
define('HEYUE_SERVICE_URL', 'http://zn.mini189.cn:8070/services');   //电信合约机正式API接口地址
define('HEYUE_USERNAME','gatewang'); //电信合约机正式API用户名
define('HEYUE_PASSWORD','24783cb6c3f5fdca6d0f06d9f2ca8e53');//电信合约机正式API密码
/**
 * 汇卡支付
 */
define('HI_PAY_URL', 'http://113.108.195.242:8881/NEWTRADECARDlqy/merch/gateway.do?operate=reqGateway');//支付地址
define('HI_MEMBER_ID','0000000013'); //测试机构号：0000000013
define('HI_MERCHANT_ID','000000000000001'); //测试商户号：000000000000001
define('HI_SETTLE_NO','000000000000005'); //清算商户号
define('HI_PWD','123456'); //密码
define('HI_RSA_IP','127.0.0.1');//java RSA 服务地址
define('HI_RSA_PORT','5678');// 端口

/**
 * 联动优势
 */
define('UM_PAY_URL','http://pay.soopay.net/spay/pay/payservice.do');
define('UM_MEMBER_ID','9690');
define('UM_HTMLPAY_URL','https://m.soopay.net/m/html5/index.do');//手机html5支付
define('UM_YIHTMLPAY_URL','https://m.soopay.net/q/html5/index.do');//U支付一键支付--首次支付
define('UM_BINDCARD_URL','https://m.soopay.net/q/html5/protIndex.do');//签约绑定银行卡

/**
 * 通联支付
 */
define('TLZF_WEBPAY_URL','https://service.allinpay.com/gateway/index.do');//互联网正式环境
define('TLZF_PAY_URL','https://service.allinpay.com/mobilepayment/mobile/SaveMchtOrderServlet.action');//互联网正式环境
define('TLZF_MERCHANT_ID','109020201507003');//商户号
define('TLZF_MERCHANT_WAPID','109020201507004');//WAP商户号
define('TLZF_MD5KEY','gaiwang2015');//正式KEY
define('TLZFKJ_MERCHANT_ID','109020201510007');//商户号
define('TLZFKJ_MD5KEY','gaiwang2015');//正式KEY

/**
 * 高汇通支付
 */
define('GHT_WEBPAY_URL','https://epay.gaohuitong.com:8443/entry.do');//正式环境
define('GHT_MERCHANT_ID','102100000014');//商户号
define('GHT_MD5KEY','a9b0185711cc70f934753547f71d17bd');//测试KEY
define('GHT_TERMINAL_ID','20000011');//测试终端号
define('GHTKJ_MERCHANT_ID','102100000013');//积分支付限制商户号
define('GHTKJ_MD5KEY','911d4ffcd5d6fde7c00f4008a0eabeb4');//积分支付限制密钥
define('GHTKJ_TERMINAL_ID','20000010');//积分支付正式终端号

/**
 * 高汇通快捷支付
 */
define('GHT_QUICK_PAY_URL','http://epay.gaohuitong.com:8081/quickInter/channel/commonInter.do');//异步结果
define('GHT_QUICKNOTIFY_PAY_URL','http://epay.gaohuitong.com:8081/quickInter/channel/commonSyncInter.do');//同步结果
//define('GHT_QUICK_PAY_MERCHANTID','102100000013');
//define('GHT_TERMINALID','20000010');
define('GHT_QUICK_PAY_MERCHANTID','102100000125');
define('GHT_TERMINALID','20000147');

/** 高汇通代扣相关 */
define('GHT_MER_ID', '890980900809898'); //MERID
define('GHT_SERVICE_URL', 'http://120.31.132.118:8080/d/merchant/'); //代扣地址
define('GHT_USER_NAME', 'merchant01'); //终端受理号
define('GHT_TRANSCONTRACTID', '51441098000031464'); //签约ID
define('GHT_BANKACCT', '6222023602047811456'); //银行账号

/**
 * EBC钱包支付
 */
define('EBC_WEBPAY_URL','http://cashier.ebcpay.com/bankpay/openBnakPay.html');//正式环境
define('EBC_MERCHANT_ID','611100000310945');//商户号
define('EBC_MERCHANT_NAME','珠海横琴新区盖网科技发展有限公司');//商户名称
define('EBC_USER_ID','2c5bf64953ac467e8b5f7fb8c9682040');//用户ID
define('EBC_MONEY_ID','0100980024874655');//钱包ID
define('EBC_CARDNO','9001990026527823');//钱包电子账户
define('EBC_CARD_KEY','b0c70d48');//钱包电子账户
define('EBC_CARD_AID','2c28949650a220a301518ebe921c162f');//对账用


/*
 * 盖讯通
 */
define('IP_BIT', 'http://www.gaixuntong.com:8080');//盖讯通地址
define('GXT_PASSWORD_KEY','6dfb5272d9fc482660ef756a3cb3');//盖讯通校验码