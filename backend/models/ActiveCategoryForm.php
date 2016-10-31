<?php

class ActiveCategoryForm extends CFormModel
{
    public $name;
    public $category;

    public function rules(){
        return array(
            array('name,category','string'),
            array('name,category','safe'),
        );
    }

    public function attributeLabels(){
        return array(
            'name' => '配置名称',
            'category' => '配置值'
        );
    }

    /**
     * 获取配置(若数据库没有记录则读取默认配置数组)
     * @return array|mixed
     */
    public static function getConfigCategory(){

        $data   = array();
        $result = Yii::app()->db->createCommand()->select('name,value')->from('{{web_config}}')->where('name=:name', array(':name'=>ActivityData::CATEGORY_NAME))->queryRow();
        if( empty($result) ){
            $data = ActivityData::getDefaultActiveCategory();
        }else{
            $data = unserialize($result['value']);
        }

        return $data;
    }

    /**
     * 获取商品的一级分类
     * @return mixed
     */
    public static function getProductCategory(){
        $data = Yii::app()->db->createCommand()
            ->select('id,name')
            ->from('{{category}}')
            ->where('parent_id=:pid AND status=:status', array(':pid'=>Category::PARENT_ID, ':status'=>Category::STATUS_ENABLE))
            ->queryAll();
        return $data;
    }

    /**
     * 更新活动商品的类别配置
     * @param array $post
     */
    public function updateCategory($post = array()){

        if( !empty($post) ){
            //获取数据库配置内容,有则更新,无则插入
            $category = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('{{category}}')
                        ->where(array('in','id',$post))
                        ->queryAll();

            $value = array();
            foreach($category as $v){
                $value[] = array('id'=>$v['id'], 'name'=>$v['name']);
            }

            $result = Yii::app()->db->createCommand()->select('name')->from('{{web_config}}')->where('name=:name', array(':name'=>ActivityData::CATEGORY_NAME))->queryScalar();

            if($result){
                Yii::app()->db->createCommand()->update('{{web_config}}', array('value'=>serialize($value)), 'name=:name', array(':name' =>ActivityData::CATEGORY_NAME));
            }else{
                Yii::app()->db->createCommand()->insert('{{web_config}}', array('name'=>ActivityData::CATEGORY_NAME, 'value'=>serialize($value)) );
            }

            //更新缓存
            Tool::cache(ActivityData::CACHE_ACTIVITY_PRODUCT_CATEGORY)->set(ActivityData::CACHE_ACTIVITY_PRODUCT_CATEGORY, serialize($value), ActivityData::EXPIRE_TIME_ORDER_CACHE);

            return true;
        }
    }
}