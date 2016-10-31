<?php

/**
 * 商城分类处理程序
 * @author csj
 */
class CatCommand extends CConsoleCommand {
	
	
	
	public function actionRun(){
		set_time_limit(0);
   		@ini_set('memory_limit','1280M');
   		
   		echo 'Start update Tree | ';
   		$this->updateTree();
   		echo ' UpdateTree finish | Updateing Depth | ';
   		$this->updateDepth();
   		echo ' UpdateDepth finish | ';
   		
   		echo ' Start update Tree Again | ';
   		$this->updateTree();
   		
   		echo ' all finish! ';
	}

   private function updateTree(){
//   		$site_depth = $this->getConfig('site','category_depth')-1;
//   		$cri = new CDbCriteria();
//   		$cri->addCondition('depth<'.$site_depth);
   		$all_cats = Category::model()->findAll();
   		
   		foreach($all_cats as $cats){
   			Category::updateCatTreeData($cats->id);
   		}
   
   }
   
   
   private function updateDepth(){
   	
   		$criteria = new CDbCriteria();
//   		$criteria->addCondition('depth<2');
   		$criteria->order = 'id asc';
   		$all_cats = Category::model()->findAll();
   		
   		foreach($all_cats as $cats){
   			Category::updateCatDepth($cats->id);
   		}
   }

}
