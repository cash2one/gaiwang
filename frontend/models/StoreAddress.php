<?php

/**
 * 商家地址库模型
 * @author wencong.lin <183482670@qq.com>
 *
 * @property string $id
 * @property string $store_id
 * @property string $link_man
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $zip_code
 * @property string $mobile
 * @property string $remark
 * @property string $store_name
 * @property integer $default
 * @property string $create_time
 * @property string $update_time
 */
class StoreAddress extends CActiveRecord {

    const DEFAULT_NO = 0;
    const DEFAULT_YES = 1;

    public function tableName() {
        return '{{store_address}}';
    }

    public function rules() {
        return array(
            array('link_man, province_id, street, zip_code, mobile', 'required'),
            array('link_man', 'match', 'pattern' => '/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u',
                'message' => Yii::t('storeAddress', '联系人  只能由中文、英文、数字及下划线组成')),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('member', '请输入正确的手机号码')),
            array('default', 'numerical', 'integerOnly' => true),
            array('store_id, province_id, city_id, district_id, create_time, update_time', 'length', 'max' => 11),
            array('link_man, street, store_name', 'length', 'max' => 128),
            array('zip_code, mobile', 'length', 'max' => 16),
            array('zip_code','match','pattern'=>'/^[0-9]\d{5}$/','message'=> Yii::t('storeAddress', '请输入6位邮政编码!')),
            array('create_time', 'default', 'value' => time()),
            array('remark', 'safe'),
            array('id, store_id, link_man, province_id, city_id, district_id, street, zip_code,
             mobile, store_name, default, create_time, update_time', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'FreightTemplate' => array(self::HAS_MANY, 'FreightTemplate', 'store_address_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_id' => 'Store',
            'link_man' => Yii::t('storeAddress', '联系人'),
            'province_id' => Yii::t('storeAddress', '所在地区'),
            'city_id' => 'City',
            'district_id' => 'District',
            'street' => Yii::t('storeAddress', '街道地址'),
            'zip_code' => Yii::t('storeAddress', '邮政编码'),
            'mobile' => Yii::t('storeAddress', '手机号码'),
            'remark' => Yii::t('storeAddress', '备注'),
            'store_name' => Yii::t('storeAddress', '公司名称'),
            'default' => Yii::t('storeAddress', '发货地址'),
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('store_id', $this->store_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 删除商品缓存
     * @param $store_id
     */
    public function deleteGoodsCache($store_id){
        $goodsIds = Yii::app()->db->createCommand()
            ->select('id')->from('{{goods}}')
            ->where('store_id=:sid',array(':sid'=>$store_id))
            ->queryColumn();
        if(!empty($goodsIds))foreach($goodsIds as $goods_id){
            ActivityData::delGoodsCache($goods_id);//删除商品缓存
        }
    }

    public function beforeSave() {
        $this->deleteGoodsCache($this->store_id);
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->create_time = $this->update_time = time();
            else
                $this->update_time = time();
            return true;
        } else
            return false;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function setDefault($model) {
        if ($model->default == self::DEFAULT_YES)
            return Yii::t('storeAddress','默认');
        else
            return CHtml::link(Yii::t('storeAddress',"设为默认"), array('/seller/storeAddress/set', 'id' => $model->id));
    }

    /**
     * 获取店铺地址列表数据，用于下拉列表
     * @return array
     */
    public static function getAddressList(){
        $address = StoreAddress::model()->findAllByAttributes(array(
            'store_id'=>Yii::app()->user->getState('storeId')),array('order'=>'t.default DESC'));
        $arr = array();
        foreach($address as $v){
            $arr[$v->id] = Region::getName($v->province_id,$v->city_id,$v->district_id);
        }
        return $arr;
    }

}
