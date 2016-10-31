<?php

/**
 * 发送邮件设置 模型
 *
 * @author zhenjun_xu<412530435@qq.com>
 */
class HongbaoConfigForm extends CFormModel {
    
    public $money1;
    public $money2;
    public $money3;
    public $money4;
    public $money5;
    public $money6;
    public $ratio1;
    public $ratio2;
    public $ratio3;
    public $ratio4;
    public $ratio5;
    public $ratio6;
    public $rules;

    public function rules() {
        return array(
            array('money1,money2,money3,money4,money5,money6,ratio1,ratio2,ratio3,ratio4,ratio5,ratio6,rules', 'required'),
            array('money1,money2,money3,money4,money5,money6,ratio1,ratio2,ratio3,ratio4,ratio5,ratio6','numerical','integerOnly'=>true),
            array('money1,money2,money3,money4,money5,money6','length','min'=>1,'max'=>8),
            array('ratio1,ratio2,ratio3,ratio4,ratio5,ratio6','length','min'=>1,'max'=>3),
            array('rules','length','max'=>200),
            array('money1,money2,money3,money4,money5,money6,ratio1,ratio2,ratio3,ratio4,ratio5,ratio6','check'),
        );
    }
    
    /**
     * 红包金额验证
     */
    public function check(){
        $checkRatio = true;
        $total = 0;
        for ($i=1;$i<=6;$i++){
            $money = "money".$i;
            $ratio = "ratio".$i;
            if($this->$money < 0){
                $this->addError($money, Yii::t('home', '红包金额必须大于或等于0'));
            }
            if($this->$ratio < 0){
                $this->addError($ratio, Yii::t('home', '百分比必须大于或等于0'));
            }
            if($checkRatio){
                $total += $this->$ratio;
                if($total > 100){
                    $this->addError($ratio, Yii::t('home', '百分比和必须等于100'));
                    $checkRatio = false;
                }
            }
        }
        if($total < 100){
            $this->addError('ratio6', Yii::t('home', '百分比和必须等于100'));
        }
        
    }

    public function attributeLabels() {
        return array(
            'money1'=>  Yii::t('home','红包金额'),
            'money2'=>  Yii::t('home','红包金额'),
            'money3'=>  Yii::t('home','红包金额'),
            'money4'=>  Yii::t('home','红包金额'),
            'money5'=>  Yii::t('home','红包金额'),
            'money6'=>  Yii::t('home','红包金额'),
            'ratio1'=>  Yii::t('home','百分比'),
            'ratio2'=>  Yii::t('home','百分比'),
            'ratio3'=>  Yii::t('home','百分比'),
            'ratio4'=>  Yii::t('home','百分比'),
            'ratio5'=>  Yii::t('home','百分比'),
            'ratio6'=>  Yii::t('home','百分比'),
            'rules' => Yii::t('hone','规则'),
        );
    }

}
