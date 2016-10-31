<?php

/**
 * 文章配置
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class ArticleConfigForm extends CFormModel{
    public $cat_0;
    public $artname_0_0;
    public $arturl_0_0;
    public $artname_0_1;
    public $arturl_0_1;
    public $artname_0_2;
    public $arturl_0_2;
    public $artname_0_3;
    public $arturl_0_3;
    public $artname_0_4;
    public $arturl_0_4;
    
    public $cat_1;
    public $artname_1_0;
    public $arturl_1_0;
    public $artname_1_1;
    public $arturl_1_1;
    public $artname_1_2;
    public $arturl_1_2;
    public $artname_1_3;
    public $arturl_1_3;
    public $artname_1_4;
    public $arturl_1_4;
    
    public $cat_2;
    public $artname_2_0;
    public $arturl_2_0;
    public $artname_2_1;
    public $arturl_2_1;
    public $artname_2_2;
    public $arturl_2_2;
    public $artname_2_3;
    public $arturl_2_3;
    public $artname_2_4;
    public $arturl_2_4;
    
    public $cat_3;
    public $artname_3_0;
    public $arturl_3_0;
    public $artname_3_1;
    public $arturl_3_1;
    public $artname_3_2;
    public $arturl_3_2;
    public $artname_3_3;
    public $arturl_3_3;
    public $artname_3_4;
    public $arturl_3_4;
    
    public $cat_4;
    public $artname_4_0;
    public $arturl_4_0;
    public $artname_4_1;
    public $arturl_4_1;
    public $artname_4_2;
    public $arturl_4_2;
    public $artname_4_3;
    public $arturl_4_3;
    public $artname_4_4;
    public $arturl_4_4;
    
    public $cat_5;
    public $artname_5_0;
    public $arturl_5_0;
    public $artname_5_1;
    public $arturl_5_1;
    public $artname_5_2;
    public $arturl_5_2;
    public $artname_5_3;
    public $arturl_5_3;
    public $artname_5_4;
    public $arturl_5_4;
    public $artname_5_5;
    public $arturl_5_5;
    
    public function rules(){
        return array(
            array(
            'cat_0, artname_0_0, arturl_0_0, artname_0_1, arturl_0_1, artname_0_2, arturl_0_2, artname_0_3, arturl_0_3, artname_0_4, arturl_0_4,  
             cat_1, artname_1_0, arturl_1_0, artname_1_1, arturl_1_1, artname_1_2, arturl_1_2, artname_1_3, arturl_1_3, artname_1_4, arturl_1_4,  
             cat_2, artname_2_0, arturl_2_0, artname_2_1, arturl_2_1, artname_2_2, arturl_2_2, artname_2_3, arturl_2_3, artname_2_4, arturl_2_4,  
             cat_3, artname_3_0, arturl_3_0, artname_3_1, arturl_3_1, artname_3_2, arturl_3_2, artname_3_3, arturl_3_3, artname_3_4, arturl_3_4,  
             cat_4, artname_4_0, arturl_4_0, artname_4_1, arturl_4_1, artname_4_2, arturl_4_2, artname_4_3, arturl_4_3, artname_4_4, arturl_4_4,  
             cat_5, artname_5_0, arturl_5_0, artname_5_1, arturl_5_1, artname_5_2, arturl_5_2, artname_5_3, arturl_5_3, artname_5_4, arturl_5_4, artname_5_5, arturl_5_5','safe'
             ),
        );
    }
    
    public function attributeLabels() {
        return array(
            'artname' => Yii::t('home','文章名称'),
            'arturl' => Yii::t('home','文章链接'),
        );
    }
}
?>
