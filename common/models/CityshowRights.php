<?php

/**
 *  {{cityshow_rights}} 模型
 *
 * The followings are the available columns in table '{{cityshow_rights}}':
 * @property string $id
 * @property string $member_id
 * @property string $create_time
 * @property string $gw
 * @property string $store_name
 */
class CityshowRights extends CActiveRecord
{
    public function tableName()
    {
        return '{{cityshow_rights}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('gw', 'required'),
            array('gw', 'comext.validators.isGaiNumber'),
            array('member_id, create_time', 'length', 'max' => 10),
            array('gw', 'length', 'max' => 20),
            array('store_name', 'length', 'max' => 128),
            array('id, member_id, create_time, gw, store_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('cityshowRights', 'ID'),
            'member_id' => Yii::t('cityshowRights', '会员id'),
            'create_time' => Yii::t('cityshowRights', '添加时间'),
            'gw' => Yii::t('cityshowRights', 'gw号'),
            'store_name' => Yii::t('cityshowRights', '店铺名称'),
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('member_id', $this->member_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('gw', $this->gw, true);
        $criteria->compare('store_name', $this->store_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array('defaultOrder'=>'id DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取memberId,店铺名称，用检查商家
     * @param $gw
     * @return mixed
     */
    public static function checkGW($gw)
    {
        return Yii::app()->db->createCommand('
                    SELECT
                    m.id,
                    s.`name`
                FROM
                    gw_member AS m
                LEFT JOIN gw_store AS s ON m.id = s.member_id
                WHERE
                    s. STATUS =:s
                AND m.gai_number =:gw
                ')->bindValues(array(":s" => Store::STATUS_PASS, ':gw' => $gw))->queryRow();
    }
}
