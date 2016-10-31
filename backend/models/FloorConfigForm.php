<?php

/**
 * 首页楼层配置
 * @author zhenjun.xu
 */
class FloorConfigForm extends CFormModel{
    /**
     * 每个楼层对应的顶级类目id
     */
    public $floor_1;
    public $floor_2;
    public $floor_3;
    public $floor_4;
    public $floor_5;
    public $floor_6;
    public $floor_7;
    public $floor_8;

    
    public function rules(){
        return array(
            array('floor_1,floor_2,floor_3,floor_4,floor_5,floor_6,floor_7,floor_8','numerical'),
            array('floor_1,floor_2,floor_3,floor_4,floor_5,floor_6,floor_7,floor_8','safe'),
        );
    }
    
    public function attributeLabels(){
        return array(
            'floor_1' => Yii::t('home','1楼'),
            'floor_2' => Yii::t('home','2楼'),
            'floor_3' => Yii::t('home','3楼'),
            'floor_4' => Yii::t('home','4楼'),
            'floor_5' => Yii::t('home','5楼'),
            'floor_6' => Yii::t('home','6楼'),
            'floor_7' => Yii::t('home','7楼'),
            'floor_8' => Yii::t('home','8楼'),
        );
    }
}
