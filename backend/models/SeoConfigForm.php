<?php

/**
 * SEO设置模型类
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class SeoConfigForm extends CFormModel{
    public $author;
    public $title;
    public $keyword;
    public $description;
    public $catTitle;
    public $catKeyword;
    public $catDescription;
    public $jfTitle;
    public $jfKeyword;
    public $jfDescription;
    public $jmsTitle;
    public $jmsKeyword;
    public $jmsDescription;
    public $hotelTitle;
    public $hotelKeyword;
    public $hotelDescription;
    public $ztTitle;
    public $ztKeyword;
    public $ztDescription;
    public $activeTitle;
    public $activeKeyword;
    public $activeDescription;
    
    public function rules(){
        return array(
            array('author,title,keyword,description,
                catTitle,catKeyword,catDescription,
                jfTitle,jfKeyword,jfDescription,
                jmsTitle,jmsKeyword,jmsDescription,
                ztTitle,ztKeyword,ztDescription,
                hotelTitle,hotelKeyword,hotelDescription
                activeTitle,activeKeyword,activeDescription'
                ,'required'),
        );
    }
    
    public function attributeLabels(){
        return array(
            'author' => Yii::t('home','SEO作者'),
            'title' => Yii::t('home','SEO标题'),
            'keyword' => Yii::t('home','SEO关键字'),
            'description' => Yii::t('home','SEO描述'),
            'catTitle' => Yii::t('home','SEO标题'),
            'catKeyword' => Yii::t('home','SEO关键字'),
            'catDescription' => Yii::t('home','SEO描述'),
            'jfTitle' => Yii::t('home','SEO标题'),
            'jfKeyword' => Yii::t('home','SEO关键字'),
            'jfDescription' => Yii::t('home','SEO描述'),
            'jmsTitle' => Yii::t('home','SEO标题'),
            'jmsKeyword' => Yii::t('home','SEO关键字'),
            'jmsDescription' => Yii::t('home','SEO描述'),
            'hotelTitle' => Yii::t('home','SEO标题'),
            'hotelKeyword' => Yii::t('home','SEO关键字'),
            'hotelDescription' => Yii::t('home','SEO描述'),
            'ztTitle' => Yii::t('home','SEO标题'),
            'ztKeyword' => Yii::t('home','SEO关键字'),
            'ztDescription' => Yii::t('home','SEO描述'),
            'activeTitle' => Yii::t('home','SEO标题'),
            'activeKeyword' => Yii::t('home','SEO关键字'),
            'activeDescription' => Yii::t('home','SEO描述'),
            'index' => Yii::t('home','盖网通首页'),
            'cat' => Yii::t('home','盖网通全部分类首页'),
            'jf' => Yii::t('home','积分兑换首页'),
            'jms' => Yii::t('home','线下加盟商首页'),
            'hotel' => Yii::t('home','酒店预订首页'),
            'zt' => Yii::t('home','专题首页'),
            'active'=>Yii::t('home','优品汇'),
        );
    }
}
?>
