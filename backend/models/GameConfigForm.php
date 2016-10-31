<?php

/**
 * GameConfigForm   手机令牌开关设置模型类
 * @author ozj
 */
class GameConfigForm extends CFormModel{
   
    public $gameSwitch;
   
    
    public function rules(){
        return array(
            array('gameSwitch','numerical'),
            array('gameSwitch','safe'),
        );
    }
    
    public function attributeLabels(){
        return array(
            'gameSwitch' => Yii::t('home','手机令牌游戏开关'),          
        );
    }
}
?>
