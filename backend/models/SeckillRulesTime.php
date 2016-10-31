<?php

/**
 * This is the model class for table "{{seckill_rules_time}}".
 *
 * The followings are the available columns in table '{{seckill_rules_time}}':
 * @property integer $id
 * @property integer $rules_id
 * @property integer $start_time
 * @property integer $end_time
 */
class SeckillRulesTime extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seckill_rules_time}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rules_id, start_time, end_time', 'required'),
			array('rules_id, start_time, end_time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rules_id, start_time, end_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		    'SeckillRules'=>array(self::BELONGS_TO, 'SeckillRules', 'id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rules_id' => '活动规则表ID',
			'start_time' => '开始时间',
			'end_time' => '结束时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('rules_id',$this->rules_id);
		$criteria->compare('start_time',$this->start_time);
		$criteria->compare('end_time',$this->end_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeckillRulesTime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**获取相关时间，根据逻辑整理时间集合排序
     * @author jiawei liao <569114018@qq.com>
     * @param $list
     * @return mixed
     */
    public static function getTimes($list){
        $times = Yii::app()->db->createCommand()->select("*")
                    ->from("{{seckill_rules_time}}")->where("rules_id in (:rules_id)",array('rules_id'=>$list['rules_id']))->queryAll();

        $list['first_date'] = date('Y-m-d',$times[0]['start_time']);
        $list['end_date'] = date('Y-m-d',$times[count($times)-1]['end_time']);
        foreach($times as $key=>$value){
            $list['times'][date('H',$value['start_time'])] = date('H:i:s',$value['start_time']).'-'.date('H:i:s',$value['end_time']);
        }
        $list['times'] = array_unique($list['times']);
        ksort($list['times']);
        $list['times'] = implode('&nbsp;&nbsp;&nbsp;',$list['times']);
        return $list;
    }


}
