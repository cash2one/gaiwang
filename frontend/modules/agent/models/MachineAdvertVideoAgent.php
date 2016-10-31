<?php

/**
 * This is the model class for table "{{machine_advert_video}}".
 *
 * The followings are the available columns in table '{{machine_advert_video}}':
 * @property integer $advert_id
 * @property string $resolution
 * @property string $duration
 * @property string $snapshot_id
 * @property integer $video_status
 */
class MachineAdvertVideoAgent extends CActiveRecord
{        public $video_name;

        const STATUS_WAITCONFIRM = 0;  //待审核
        const STATUS_CONFIRMPASS = 1;  //已通过
        const STATUS_CONFIRMFAIL = 2;  //未通过

        public static function getStatus($key = NULL) {
            $status = array(
                self::STATUS_WAITCONFIRM => Yii::t('MachineAdvertVideo', '待审核'),
                self::STATUS_CONFIRMPASS => Yii::t('MachineAdvertVideo', '已通过'),
                self::STATUS_CONFIRMFAIL => Yii::t('MachineAdvertVideo', '未通过'),
            );
            return $status[$key];
        }    
    
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_advert_video}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('advert_id, resolution, duration, snapshot_id, video_status', 'required'),
                        array('advert_id, video_status', 'numerical', 'integerOnly' => true),
                        array('resolution', 'length', 'max' => 50),
                        array('duration, snapshot_id', 'length', 'max' => 10),
                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('advert_id, resolution, duration, snapshot_id, video_status,video_name', 'safe', 'on' => 'search'),
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
                    'imgpath' => array(self::BELONGS_TO, 'FileManageAgent', 'snapshot_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			 'video_name' => '视频名称',
                    'resolution' => 'Resolution',
                    'duration' => 'Duration',
                    'snapshot_id' => 'Snapshot',
                    'video_status' => '状态',
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

		$criteria = new CDbCriteria;

                $criteria->select = 't.advert_id,t.resolution,t.duration,t.video_status,m.title as video_name';
                $criteria->join = 'left join {{machine_advert}} m on m.id=t.advert_id';
                $criteria->compare('m.title', $this->video_name,true);
                $criteria->with = 'imgpath';
                //$criteria->compare('resolution',$this->resolution,true);
                //$criteria->compare('duration',$this->duration,true);
                //$criteria->compare('snapshot_id',$this->snapshot_id,true);
                $criteria->compare('video_status', $this->video_status);
                $criteria->compare('advert_type', MachineAdvertAgent::ADVERT_TYPE_VEDIO);
                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 15,
                    ),
                ));
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
	 * @return MachineAdvertVideoAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
