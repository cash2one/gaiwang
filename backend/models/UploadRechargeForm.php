<?php

/**
 * 单个文件上传，用txt导入
 * @author cong.zeng <zengcong220@qq.com>
 */
class UploadRechargeForm extends CFormModel
{

    public $file;

    public function rules()
    {
        return array(
            array('file', 'required', 'on' => 'txt'),
            array('file', 'file', 'types' => 'txt', 'allowEmpty' => true, 'wrongType'=>'文件格式不正确，文件 "{file}" 无法被上传', 'on' => 'txt'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'file' => 'txt文件'
        );
    }
} 
