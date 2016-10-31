<?php

/**
 * 测试redis操作
 * @author wanyun-liu
 */
class RedisCommand extends CConsoleCommand {
    /**
     * 执行盖网通发短信(消费提示类的短信)
     * @author LC
     */
    public function actionSendSmsGT()
    {
    	GWRedisList::daemonSmsGT();
    }
    
    /**
     * 执行盖网通发短信(验证码)
     * @author LC
     */
    public function actionSendSmsGTCode()
    {
    	GWRedisList::daemonSmsGTCode();
    }
      /**
     * 执行盖网通发送邮件
     * @author zsj
     */
    public function  actionSendEmail(){
        GWRedisList::daemonEmailGT();
    }
}
