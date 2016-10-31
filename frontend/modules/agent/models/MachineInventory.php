<?php

/**
 * This is the model class for table "{{machine_inventory}}".
 *
 * The followings are the available columns in table '{{machine_inventory}}':
 * @property string $id
 * @property string $machine_id
 * @property string $member_id
 * @property integer $questionnaire_id
 * @property string $answer
 * @property string $imgs
 * @property string $record
 * @property string $remark
 * @property integer $create_time
 */
class MachineInventory extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_inventory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('machine_id, member_id, questionnaire_id, answer, imgs, create_time', 'required'),
			array('questionnaire_id, create_time', 'numerical', 'integerOnly'=>true),
			array('machine_id, member_id', 'length', 'max'=>11),
			array('remark,record', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, machine_id, member_id, questionnaire_id, answer, imgs, remark, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'machine_name' => Yii::t('MachineInventory','盖机名'),
			'machine_code' => Yii::t('MachineInventory','盖机编码'),
			'username' => Yii::t('MachineInventory','盘点人'),
			'gai_number' => Yii::t('MachineInventory','盘点人GW号'),
			'machine_id' => 'Machine',
			'member_id' => 'User',
			'questionnaire_id' => 'Questionnaire',
			'answer' => 'Answer',
			'record' => '修改备案',
			'imgs' => 'Imgs',
			'remark' => Yii::t('MachineInventory','备注'),
			'create_time' => Yii::t('MachineInventory','盘点时间'),
			'begin_time'=>'开始时间',
			'end_time'=>'结束时间'
		);
	}


	public static function createButtons($id,$begin,$end) {
		$where = '';
		$where .= $begin ? " and create_time >= ".strtotime($begin) : '';
		$where .= $end ? " and create_time <= ".strtotime($end) : '';
		$result = Yii::app()->gt->createCommand()
						->select('id')
						->from(MachineInventory::model()->tableName())
						->where('machine_id='.$id.$where)
						->queryAll();
		if(count($result) == 0){
			return "未盘点";
		} elseif(count($result)  == 1){
			return "已盘点";
		}else{
			return "已盘点".count($result)."次";
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineInventory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
