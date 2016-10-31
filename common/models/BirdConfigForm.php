<?php

/**
 * OrderConfigForm设置模型类
 * @author csj
 */
class BirdConfigForm extends CFormModel{
    public $success; //成功概率
    public $fail; //失败概率
    
    public function rules(){
        return array(
            array('success,fail','required'),
            array('success,fail','numerical','integerOnly'=>true),
            array('success,fail','compare','compareValue'=>'1','operator'=>'>=','message'=>Yii::t('birdConfigForm','不能小于1')),
            array('success,fail','compare','compareValue'=>'100','operator'=>'<=','message'=>Yii::t('birdConfigForm','不能大于100')),
            array('success,fail','safe'),
        );
    }
    
    public function attributeLabels(){
        return array(
            'success' => Yii::t('birdConfigForm','抢水果成功触发概率'),
            'fail' => Yii::t('birdConfigForm','抢水果失败触发概率'),
        );
    }
}
?>
