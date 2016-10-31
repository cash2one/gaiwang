<?php
Yii::import('zii.widgets.grid.CGridView');
class GridView extends CGridView
{
	public $template = "{items}{pager}{summary}";
    public $pager = array('class' => 'application.modules.agent.widgets.LinkPager');
    public $summaryText = '共 {count} 条 / {pages} 页';
    public $pagerCssClass = 'gt-pager';
    public $summaryCssClass = 'gt-summary';
    public function init(){
        parent::init();
        $this->summaryText=Yii::t('Public','共')." {count} ".Yii::t('Public','条')." / {pages} ".Yii::t('Public','页');
    }
}