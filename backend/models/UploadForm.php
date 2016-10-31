<?php

/**
 * 单个文件上传表单，用excel 导入会员
 * @author zhenjun_xu <412530435@qq.com>
 */
class UploadForm extends CFormModel
{

    public $file;
    public $apply_time;

    public function rules()
    {
        return array(
            array('file', 'required', 'on' => 'excel,batch'),
            array('apply_time','required','on' => 'batch'),
            array('file', 'file', 'types' => array('xls','xlsx'), 'on' => 'excel,batch', 'allowEmpty' => true,'wrongType'=>'文件格式不正确，文件 "{file}" 无法被上传',),
        );
    }

    public function attributeLabels()
    {
        return array(
            'file' => 'excel',
            'apply_time' => '申请日期'
        );
    }
} 