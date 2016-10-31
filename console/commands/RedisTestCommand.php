<?php

/**
 * 测试redis操作
 * @author wanyun-liu
 */
class RedisTestCommand extends CConsoleCommand {
    /**
     * 执行盖网通发短信(消费提示类的短信)
     * @author LC
     */
    public function actionSendSmsGT()
    {
        GWRedisListTest::daemonSmsGT();
    }
    
    /**
     * 执行盖网通发短信(验证码)
     * @author LC
     */
    public function actionSendSmsGTCode()
    {
    	GWRedisListTest::daemonSmsGTCode();
    }
      /**
     * 执行盖网通发送邮件
     * @author zsj
     */
    public function  actionSendEmail(){
        GWRedisListTest::daemonEmailGT();
    }
}
