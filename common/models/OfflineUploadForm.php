<?php

/**
 * 电子化签约 上传图片、pdf文件预览
 * Class OfflineUploadForm
 */
class OfflineUploadForm extends CFormModel {
    
    public $fileName;       //文件名

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('fileName', 'required'),
            //上传图片
            array(
                'fileName', 'file', 'types' => 'jpg,jpeg,gif,bmp', 'maxSize' => 1024 * 1024 * 3, 'on' => 'picture','allowEmpty' => true,
                'tooLarge' => '图片 最大不超过3MB，请重新上传!'
            ),
            //上传合同
            array(
                'fileName', 'file', 'types' => 'pdf', 'maxSize' => 1024 * 1024 * 3, 'on' => 'pdf','allowEmpty' => true,
                'tooLarge' => 'pdf文件 最大不超过3MB，请重新上传!'
            ),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'fileName' => '文件名',
        );
    }
}
