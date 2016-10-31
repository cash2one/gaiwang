<?php
/**
 * @author luochen
 */

Yii::import('zii.widgets.CListView');

class ListView extends CListView
{
	public $template = "{items}<div style='width:100%;display:inline-table;text-align:center;margin-top:20px;'>{pager}{summary}</div>";
	public $pager = array('class' => 'application.modules.agent.widgets.LinkPager');
	public $summaryText = '共 {count} 条 / {pages} 页';
	public $pagerCssClass = 'gt-pager';
    public $summaryCssClass = 'gt-summary';
    public function init(){
        parent::init();
        $this->summaryText=Yii::t('Public','共')." {count} ".Yii::t('Public','条')." / {pages} ".Yii::t('Public','页');
    }
}
