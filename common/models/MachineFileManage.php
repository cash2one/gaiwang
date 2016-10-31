<?php

/**
 * 盖网通图片管理表
 * @author LC
 * This is the model class for table "{{file_manage}}".
 *
 * The followings are the available columns in table '{{file_manage}}':
 * @property string $id
 * @property string $filename
 * @property string $suffix
 * @property integer $width
 * @property integer $height
 * @property string $path
 * @property integer $classify
 * @property integer $user_id
 * @property string $create_time
 */
class MachineFileManage extends CActiveRecord
{
	const GT_IMG_DOMAIN = "http://gtimg.gatewang.net";						//图片域名显示
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gatetong.gt_file_manage';
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
	 * @return MachineFileManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

	/**
	 * 通过id得到图片的url,返回缩略图
	 */
	public static function getUrlById($id)
	{
		$tn = self::model()->tableName();
		$sql = "select path from $tn where id=$id";
		$path = Yii::app()->gt->createCommand($sql)->queryScalar();
		$path = str_replace("/uploads", "", $path);
		return self::GT_IMG_DOMAIN.'/100x100'.$path;
	}
	
	/**
	 * 对path进行处理，返回url
	 */
	public static function getUrlByPath($path)
	{
		$path = str_replace("/uploads", "", $path);
		return self::GT_IMG_DOMAIN.'/100x100'.$path;
	}
}
