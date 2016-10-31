<?php

/**
 * 一些常用常量的定义
 * @author wanyun.liu <wanyun_liu@163.com>
 */
/*
 * 普通常量定义
 * ***************************************************************************************************************
 */
define('IS_DEVELOPMENT', true); // 当前是否为开发环境（生产时改为false）
define('YII_DEBUG', false); // debug常量（生产时改为false）
define('YII_TRACE_LEVEL', 3);
// define('UPLOAD_REMOTE', '/');
define('UPLOAD_REMOTE_GT', false); // 盖网通远程图片服务器的图片根目录
define('UPLOAD_REMOTE', false); // 远程图片服务器的图片根目录
define('GAI_NUMBER_LENGTH', 8); // 盖网会员编号 GW + 数字的长度
define('HISTORY_NUM', 5); // 商品浏览历史记录个数
define('ACCOUNT', 'account'); // 帐目库名
define('IS_STARTGXT',true);//当前是否启用盖讯通同步接口（因盖讯通还未上线，生产时改为false）
define('GAME', 'game'); //游戏库名
/*
 * 域名常量定义
 * ***************************************************************************************************************
 */
define('DOMAIN', 'http://www.gaiwang.com');//http://www.gaiwang.com
define('SHORT_DOMAIN', substr(DOMAIN, 11));
define('SUFFIX', substr(SHORT_DOMAIN, strrpos(SHORT_DOMAIN, '.') + 1)); // 域名后缀
define('IMG_DOMAIN', 'http://img.' . (UPLOAD_REMOTE ? 'gwimg.com' : SHORT_DOMAIN)); // 图片域名
define('ATTR_DOMAIN', 'http://att.' . (UPLOAD_REMOTE ? 'gwimg.com' : SHORT_DOMAIN)); // 附件域名
define('GT_DOMAIN', 'http://gt.' . SHORT_DOMAIN); // 盖网通的域名
define('GT_IMG_DOMAIN', 'http://gtimg.' . SHORT_DOMAIN); // 盖网通的图片域名
define('SC_DOMAIN', '.' . SHORT_DOMAIN); // session cookie 作用域
define('MANAGE_DOMAIN', 'http://manage.' . SHORT_DOMAIN); // 为了那个编辑器而加的.编辑器默认的url是
                                                          // MANAGE_DOMAIN
define('AGENT_DOMAIN', 'http://agent.' . SHORT_DOMAIN); // 代理管理域名

define('ORDER_API_URL', 'http://order.orderapi.com');	//订单接口地址
define('SIGN_KEY', 'db7a4fa02786f50cf53891ea8166b24415434021');//订单支付SIGN_KEY常量
define('M_DOMAIN', 'http://m.' . SHORT_DOMAIN); // 微商城的域名


define('SKU_API_URL', 'http://api.gaiwangsku.com');	//SKU项目API地址
define('SKU_API_PROJECT_ID', '101');	//SKU项目API地址
define('SKU_API_SIGN_KEY', 'i2uew@fjnc#sld!asldiu^sdoif*dd');//SKU项目API SIGN_KEY常量


define('AMOUNT_SIGN_KEY', 'db4dfs4dfs34dfs4df2786f50cf53891dfs15434021');//余额表密钥

/*
 * 外部接口相关常量定义
 * *********************************************************************************************************
 */
if (IS_DEVELOPMENT)
    include (dirname(__FILE__) . '/constantPaySandbox.php'); // 沙箱环境用
else
    include (dirname(__FILE__) . '/constantPay.php'); // 生产环境用