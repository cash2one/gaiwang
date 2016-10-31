<?php

class WebConfigController extends TController
{
    public function actionSite()
    {
        $this->breadcrumbs = array(Yii::t('home', '网站配置管理'), Yii::t('home', '网站配置'));
        $this->_settingConfig($this->action->id);
    }

    private function _settingConfig($actionId)
    {
        $modelForm = ucfirst($actionId) . 'ConfigForm';
        $configName = strtolower('travel-' . $actionId . '-config');
        $model = new $modelForm;
        $model->setAttributes($this->getConfig($configName));

        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST[$modelForm])) {
            $model->attributes = $_POST[$modelForm];

            if ($model->validate()) {
                $string = serialize($model->attributes);
                $value = WebConfig::model()->findByAttributes(array('name' => $configName));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }

                $webConfig->name = $configName;
                $webConfig->value = $string;

                if ($webConfig->save()) {
                    if (Tool::cache($configName)->get($configName)) {
                        Tool::cache($configName)->set($configName, $string);
                    } else {
                        Tool::cache($configName)->add($configName, $string);
                    }

                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @SystemLog::record(Yii::app()->user->name . "修改酒店配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            }
        }
        //CActiveForm widget 参数
        $formConfig = array(
            'id' => $this->id . '-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        );
        $this->render(strtolower($actionId), array('model' => $model, 'formConfig' => $formConfig));
    }
}