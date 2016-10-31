<?php

/**
 * 文件上传配置
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class UploadConfigForm extends CFormModel{
    public $uploadPath;
    public $fileTypes;
    public $imageTypes;
    public $imageFilesize;
    public $flashFilesize;
    public $flashSize;
    public $uploadTotal;
    
    public function rules(){
        return array(
            array('uploadPath, fileTypes, imageTypes, imageFilesize, flashFilesize, flashSize,uploadTotal','required'),
            array('imageFilesize, flashFilesize','match','pattern'=>'/^[0-9]*[1-9][0-9]*$/'),
            array('flashSize','match','pattern'=>'/[1-9]\d{1,10}x[1-9]\d{1,10}/'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'uploadPath' => Yii::t('home','文件上传路径'),
            'fileTypes' => Yii::t('home','文件上传格式'),
            'imageTypes' => Yii::t('home','图片上传格式'),
            'imageFilesize' => Yii::t('home','可上传最大限制'),
            'flashFilesize' => Yii::t('home','投票系统flash上传最大限制'),
            'flashSize' => Yii::t('home','首页flash广告尺寸'),
            'uploadTotal'=>  Yii::t('home','当天上传总数(数据导入)')
        );
    }
}
?>
