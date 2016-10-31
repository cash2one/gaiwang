<?php

/**
 * 盖付通主菜单配置  模型
 * 
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-08T14:11:57+0800
 */
class GftMenuConfigForm extends CFormModel
{

    const  OPEN_ON = 1;   //开
    const  OPEN_OFF =0;   //关

    //是否从后台动态获取盖付通主菜单配置
    public $is_open;

    public static function isOpen()
    {
        return array(
           self::OPEN_ON => '开',
           self::OPEN_OFF => '关',
        );
    }

    public function rules() 
    {
        return array(
            array('is_open','required'),
        );
    }

    public function attributeLabels() 
    {
        return array(
            'is_open' => '是否打开',
        );
    }
}