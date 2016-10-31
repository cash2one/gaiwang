<?php
Yii::import ( 'zii.widgets.CBreadcrumbs' );
class AgentBreadcrumbs extends CBreadcrumbs {
	public function run() {
		if (empty ( $this->links ))
			return;
		
		echo CHtml::openTag ( $this->tagName, $this->htmlOptions ) . "\n";
		$links = array ();
		if ($this->homeLink === null)
			$links [] = CHtml::link ( Yii::t ( 'zii', 'Home' ), Yii::app ()->homeUrl );
		else if ($this->homeLink !== false)
			$links [] = $this->homeLink;
		$i = 0;
		foreach ( $this->links as $label => $url ) {
			if(is_string($label) || is_array($url))
				if($i === 0)
				{
					$links [] = '<a class="navBar_first" href="'.CHtml::normalizeUrl($url).'">' . ($this->encodeLabel ? CHtml::encode ( $label ) : $label) . '</a>';
				}
				else 
				{
					$links [] = '<a href="'.CHtml::normalizeUrl($url).'">' . ($this->encodeLabel ? CHtml::encode ( $label ) : $label) . '</a>';
				}
			else
			{
				if($i === 0)
				{
					$links [] = '<a class="navBar_first" href="javascript:void(0);">' . ($this->encodeLabel ? CHtml::encode ( $url ) : $url) . '</a>';
				}
				else 
				{
					$links [] = '<a href="javascript:void(0);">' . ($this->encodeLabel ? CHtml::encode ( $url ) : $url) . '</a>';
				}
			}
			$i++;	
		}
		echo '<span><img src="'.Yii::app()->controller->module->assetsUrl.'/images/title_icon.gif" width="6" height="10" alt="icon">'.Yii::t('Public','当前位置').'：</span>';
		echo implode ( $this->separator, $links );
		echo CHtml::closeTag ( $this->tagName );
	}
}
