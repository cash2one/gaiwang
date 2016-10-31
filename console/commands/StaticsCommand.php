<?php

/*
 * 后台统计任务脚本
 */

class StaticsCommand extends CConsoleCommand{
    public function actionIndex(){
         
    }
    
    //每天运行一次
    public function actionEveryDay(){
        Order::staticOrders();//统计昨天的订单
        Goods::staticGoods();//统计昨天商品
        Store::staticStore();//商家 店铺
        Member::staticMember();//会员
        Store::staticStoreSort();//商铺排行
        AgentDay::runDayTaskStaticsInfo();	//代理
    }
}



?>
