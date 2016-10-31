<?php 
$config = array(
    '网站配置' => array(
        '编辑' => 'Home.SiteConfig'
    ),
    '首页楼层配置' => array(
        '编辑' => 'Home.FloorConfig'
    ),
    '游戏开关配置' => array(
        '编辑' => 'Home.GameConfig'
    ),
     '手机令牌开关配置' => array(
        '编辑' => 'Home.GameConfig'
    ),
    'SEO配置' => array(
        '编辑' => 'Home.SeoConfig'
    ),
    '短信接口配置' => array(
        '编辑' => 'Home.SmsApiConfig'
    ),
    '短信模板配置' => array(
        '编辑' => 'Home.SmsModelConfig'
    ),
    '文件上传配置' => array(
        '编辑' => 'Home.UploadConfig'
    ),
    '系统信息' => array(
        '编辑' => 'Home.Main'
    ),
    '敏感词设置' => array(
        '编辑' => 'Home.FilterWorldConfig'
    ),
    '地址配置' => array(
        '列表' => 'Region.Admin',
        '添加' => 'Region.Create',
        '删除' => 'Region.Delete',
        '编辑' => 'Region.Update'
    ),
    '会员升级配置' => array(
        '编辑' => 'Home.ScheduleConfig'
    ),
    '系统任务管理' => array(
        '编辑' => 'Home.TaskConfig'
    ),
    '运费修改客服配置' => array(
        '编辑' => 'Home.FreightLinkConfig'
    ),
    '全局搜索热门词配置' => array(
        '编辑' => 'Home.GlobalKeyWordConfig'
    ),
    '短信发送记录' => array(
        '编辑' => 'SmsLog.Admin'
    ),
    '发送邮件设置' => array(
        '编辑' => 'Home.EmailConfig'
    ),
    '邮件模板配置' => array(
        '编辑' => 'Home.EmaiModellConfig'
    ),
    '邮件发送记录' => array(
        '编辑' => 'EmailLog.Admin'
    ),
    '汇率配置' => array(
        '编辑' => 'Home.RateConfig'
    ),
    '订单配置' => array(
        '编辑' => 'Home.OrderConfig'
    ),
    '合约机配置' => array(
        '编辑' => 'Home.HeYueJiConfig'
    ),
    '盖付通免密支付额度设置' => array(
        '查看' => 'GftNopwdPayLimitSetting.Admin',
        '添加' => 'GftNopwdPayLimitSetting.Create',
        // '编辑' => 'GftNopwdPayLimitSetting.Update',
        '删除' => 'GftNopwdPayLimitSetting.Delete',
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>