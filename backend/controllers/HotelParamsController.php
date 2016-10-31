<?php

/**
 * 酒店参数配置总控制器
 * 包括(酒店价格区间配置,酒店参数配置)
 * @author binbin.liao <277250538@qq.com>
 */
class HotelParamsController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 修改配置文件
     * 文件名规则：控制器+Config 后缀，模型+ConfigForm后缀
     * @param string $actionId   $this->action->id  控制器名称
     */
    private function _settingConfig($actionId) {
        $modelForm = ucfirst($actionId) . 'Form';
        $name = substr($actionId, 0, -6);
        $viewFileName = strtolower($name);
        $model = new $modelForm;
        //Ajax 验证,如果视图开启Ajax验证.这个是必须存在的
        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $model->setAttributes($this->getConfig($viewFileName));
        if (isset($_POST[$modelForm])) {
            $model->attributes = $_POST[$modelForm];
            if ($model->validate()) {
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
                if ($webConfig->save()) {
                    if (Tool::cache($viewFileName . 'config')->get($viewFileName)) {
                        Tool::cache($viewFileName . 'config')->set($viewFileName, $string);
                    } else {
                        Tool::cache($viewFileName . 'config')->add($viewFileName, $string);
                    }
                    Yii::app()->user->setFlash('success', Yii::t('hotel', '数据保存成功'));
                }
//                $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . $viewFileName . '.config.inc';
//                @file_put_contents($file, $string);             //向得到的文件路劲指定的文件里面插入数据
            }
        }
        $this->render(strtolower($actionId), array('model' => $model));
    }

    /**
     * 酒店参数配置
     */
    public function actionHotelParamsConfig() {
        $this->breadcrumbs = array(Yii::t('hotel', '酒店配置管理'), Yii::t('hotel', '酒店参数配置'));
        $this->_settingConfig($this->action->id);
        @SystemLog::record(Yii::app()->user->name . "修改酒店参数配置");
    }

}

?>
