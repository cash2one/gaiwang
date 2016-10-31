<?php

/**
 * This is the model class for table "{{app_topic_car_comment}}".
 *
 * The followings are the available columns in table '{{app_topic_car_comment}}':
 * @property string $id
 * @property string $topic_id
 * @property string $parent_id
 * @property string $member_id
 * @property string $name
 * @property string $content
 * @property string $likes
 * @property integer $status
 * @property string $create_time
 * @property string $passed_time
 * @property string $admin_id
 */
class AppTopicCarComment extends CActiveRecord
{



    public $end_create_time;

    const AUDIT_NO =0;  //未审核
    const AUDIT_YES =1; //已审核
    const BLOCK_YES =2; //已屏蔽

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_topic_car_comment}}';
	}

    /**
     * 评论状态
     */

    public static function getStatus($key = null){
        $data = array(
            self::AUDIT_NO => Yii::t('AppTopicCarComment','未审核'),
            self::AUDIT_YES => Yii::t('AppTopicCarComment','已审核'),
            self::BLOCK_YES => Yii::t('AppTopicCarComment','已屏蔽'),
        );
        return $key === null ? $data : $data[$key];


    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, name, content, create_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('topic_id, parent_id, member_id, create_time, passed_time, admin_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>50),
			//array('content', 'length', 'max'=>255),
			array('likes', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, topic_id, parent_id, member_id, name, content, likes, status, create_time, end_create_time, passed_time, admin_id', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'topic_id' => '专题id',
			'parent_id' => '上级id',
			'member_id' => '会员id',
			'name' => '昵称',
			'content' => '评论内容',
			'likes' => '点赞',
			'status' => '状态',
			'create_time' => '评论时间',
			'passed_time' => '审核时间',
			'admin_id' => '管理人',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('topic_id',$this->topic_id,false);
        $criteria->compare('parent_id',$this->parent_id,false);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('likes',$this->likes,false);
		$criteria->compare('status',$this->status,false);
		$criteria->compare('passed_time',$this->passed_time,true);
		$criteria->compare('admin_id',$this->admin_id,true);
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
					'defaultOrder'=>'create_time DESC', //设置默认排序
				),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppTopicCarComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function filteredProblem($problem){
	    //敏感词过滤
	    $actionId="filterWorldConfig";
	    $modelForm = ucfirst($actionId) . 'Form';
	    $name = substr($actionId, 0, -6);
	    $viewFileName = strtolower($name);
	    $model_f = new $modelForm;
	    $model_f->setAttributes(Tool::getConfig($viewFileName));
	    $data=explode(',',$model_f['filterWorld']);
	    $badword1 = array_combine($data,array_fill(0,count($data),'***/'));
	    $problem = strtr($problem, $badword1);
	    return $problem;
	}
}
