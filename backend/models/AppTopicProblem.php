<?php

/**
 * This is the model class for table "{{app_topic_problem}}".
 *
 * The followings are the available columns in table '{{app_topic_problem}}':
 * @property string $id
 * @property string $parent_id
 * @property string $life_topic_id
 * @property string $member_id
 * @property string $name
 * @property integer $status
 * @property string $create_time
 * @property string $passed_time
 * @property string $admin_id
 * @property string $problem
 */

class AppTopicProblem extends CActiveRecord
{

    public $end_create_time;




	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_topic_problem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, create_time, problem', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('parent_id, life_topic_id, member_id, create_time, passed_time, admin_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, life_topic_id, member_id, name, status, create_time, end_create_time, passed_time, admin_id, problem', 'safe', 'on'=>'search'),
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
            'parent_id' => '上级id',
			'life_topic_id' => '主题ID',
			'member_id' => '会员ID',
			'name' => '昵称',
			'status' => '状态',
			'create_time' => '评论时间',
			'passed_time' => '审核时间',
			'admin_id' => '管理人',
			'problem' => '评论内容',
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
		$criteria->compare('life_topic_id',$this->life_topic_id,false);
        $criteria->compare('parent_id',$this->parent_id,false);
        if($this->member_id != "")$criteria->addInCondition('member_id', explode(",", $this->member_id));
	//	$criteria->compare('member_id',$this->member_id,true);
	//	$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,false);
		//$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('passed_time',$this->passed_time,true);
		$criteria->compare('admin_id',$this->admin_id,true);
		$criteria->compare('problem',$this->problem,true);
      //  $searchDate = Tool::searchDateFormat($this->create_time, $this->end_create_time);
       // var_dump($searchDate);die();
       if($this->create_time != null && $this->end_create_time != null)
       	$criteria->addBetweenCondition('create_time',$this->create_time,$this->end_create_time);
        if($this->create_time == null && $this->end_create_time != null)
       	$criteria->compare('create_time',"<".$this->end_create_time);
        if($this->create_time != null && $this->end_create_time == null)
        	$criteria->compare('create_time',">=".$this->end_create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppTopicProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getMemberName($memberId){
		$userName = "";
		$userNameData = Member::getInfoById($memberId,"username,gai_number");
		$userName = $userNameData['username'] == "" ? $userNameData['gai_number'] :  $userNameData['username'];
		return $userName;
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
