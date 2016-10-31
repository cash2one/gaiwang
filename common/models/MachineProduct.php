<?php

/**
 * 盖网通商城---商品表
 * @author LC
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $category_id
 * @property string $name
 * @property string $number
 * @property string $market_price
 * @property string $price
 * @property integer $back_rate
 * @property integer $gt_rate
 * @property integer $gw_rate
 * @property string $return_score
 * @property string $stock
 * @property string $sales_volume
 * @property string $activity_start_time
 * @property string $activity_end_time
 * @property string $content
 * @property integer $biz_info_id
 * @property string $biz_name
 * @property integer $thumbnail_id
 * @property string $image_list_id
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $status
 * @property integer $use_status
 * @property integer $sort
 * @property integer $user_id
 * @property integer $user_ip
 * @property string $create_time
 */
class MachineProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}


	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
