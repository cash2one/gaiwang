<?php
/**
 * 在线客服及工作时间 显示
 * @author zhenjun_xu <412530435@qq.com>
 */

class ServiceWidget extends CWidget
{

    public $store;
    public $design;

    public function run()
    {
        $this->render('service', array('design' => $this->design));
    }

} 