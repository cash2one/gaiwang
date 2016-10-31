<?php

/**
 *  酒店网站配置模型类
 *
 */
class SiteConfigForm extends CFormModel
{

    public $name;
    public $domain;
    public $phone;
    public $service_time;
    public $copyright;
    public $icp;


    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return array(
            array('name, domain, phone, service_time, copyright', 'required'),
           // array('', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 100),
            array('icp', 'length', 'max'=>128),
        );
    }


    public function attributeLabels()
    {
        return array(
            'name' => '网站名',
            'domain' => '网站域名',
            'phone' => '客服电话',
            'service_time' => '客服时间',
            'copyright' => '版权信息',
            'icp' => '网站ICP备案',
        );
    }

}
