<?php

/**
 * XSS安全模式类
 * User: binbin.liao
 * Date: 2014/11/7
 * Time: 11:56
 * 在模型类中如下使用
 * public function behaviors(){
        return array(
        'CSafeContentBehavor' => array(
            'class' => 'application.behaviors.CSafeContentBehavior',//安全模式类路径
            'attributes' => array('title', 'body'),//要过滤的字段
            ),
        );
    }
 */
class CSafeContentBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    protected $purifier;

    function __construct()
    {
        $this->purifier = new CHtmlPurifier;
    }

    public function beforeSave($event)
    {
        foreach ($this->attributes as $attribute) {
            $this->getOwner()->{$attribute} = $this->purifier->purify($this->getOwner()->{$attribute});
        }
    }
} 