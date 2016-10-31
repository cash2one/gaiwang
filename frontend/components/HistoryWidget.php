<?php
/**
 * 侧栏 浏览历史
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * @example

 * <?php $this->widget('application.components.HistoryWidget'); ?>
 *
 */
class HistoryWidget extends CWidget{
    public function run(){
        $this->render('history');
    }
} 