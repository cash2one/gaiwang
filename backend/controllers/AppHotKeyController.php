<?php

/**
 * 热卖活动标题设置
 * @author zhaoxiang.liu 
 */
class AppHotKeyController extends Controller {
	
	public function actionIndex(){
		$name = "AppHotKey";
		$viewFileName = strtolower($name);
		$model = new AppHotKeyForm();
		$model->setAttributes($this->getConfig($viewFileName));
		//var_dump(11111);die();
		if (isset($_POST['AppHotKeyForm'])) {
			$model->attributes = $_POST['AppHotKeyForm'];
			$string = serialize($model->attributes);
			$value = WebConfig::model()->findByAttributes(array('name' => $viewFileName));

			if ($value) {
				$webConfig = WebConfig::model();
				$webConfig->id = $value->id;
			} else {
				$webConfig = new WebConfig();
			}
			
		      $webConfig->name = $viewFileName;
              $webConfig->value = $string;
                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $string);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $string);
                    }
                   // $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
                
                $this->render('index',array(
                		'model'=>$model,
                		'type'=>1
                ));
		}
		$this->render('index',array(
				'model'=>$model,
				'type'=>0
		));
	}
	
}

