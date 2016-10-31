<?php

/**
 * This is the model class for table "{{app_topic_life}}".
 *
 * The followings are the available columns in table '{{app_topic_life}}':
 * @property string $id
 * @property string $title
 * @property integer $rele_status
 * @property integer $audit_status
 * @property integer $sequence
 * @property string $comHeadUrl
 * @property string $profess_proof
 * @property string $author
 * @property string $topic_img
 * @property string $goods_list
 * @property string $error_field
 * @property integer $create_time
 * @property integer $rele_time
 */
class AppTopicLife extends CActiveRecord
{


    //审核状态
    const AUDIT_STATUS_NO = 0;     //不通过
    const AUDIT_STATUS_PASS = 1;   //通过
    const AUDIT_STATUS = 2;        //审核中
    //发布状态
    const RELE_STATUS_YES = 1 ;  //已发布
    const RELE_STATUS_NO = 2;    //未发布
    //使用状态
    const DISABLE_YES = 1 ;  //启用
    const DISABLE_NO = 0;    //停用
    const SUBMIT = 1; //保存不发布
    const RELE_STATUS = 2;//保存和发布



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_topic_life}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, comHeadUrl, profess_proof, author, topic_img, goods_list, error_field, create_time, rele_time', 'required'),
			array('rele_status, audit_status, sequence, create_time, rele_time', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('comHeadUrl, topic_img', 'length', 'max'=>255),
			array('author', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, rele_status, audit_status, sequence, comHeadUrl, profess_proof, author, topic_img, goods_list, error_field, create_time, rele_time', 'safe', 'on'=>'search'),
		);
	}


    /*
     * 获取审核状态
     * */
    public static function getAuditStatus($key = null){
        $data = array(
            self::AUDIT_STATUS_NO => '不通过',
            self::AUDIT_STATUS_PASS => '已通过',
            self::AUDIT_STATUS => '审核中',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }

    /*
     * 获取发布状态
     * */
    public static function getReleStatus($key = null){
        $data = array(
            self::RELE_STATUS_YES => '已发布',
            self::RELE_STATUS_NO => '未发布',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
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
            'id' => '主键id',
            'title' => '主题名称',
            'sequence' => '排序',
            'topic_img'=>'专题图片',
            'comHeadUrl'=>'头像',
            'author'=>'作者',
            'profess_proof' => '专业证明',
            'rele_status'=> '状态',
            'rele_time'=> '发布时间',
            'audit_status'=> '审核状态',
            'online_time' => '设置专题生效上架时间',
            'disable' => '使用状态',
            'create_time'=>'创建时间',
            'error_field'=>'不通过原因',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('rele_status',$this->rele_status);
		$criteria->compare('audit_status',$this->audit_status);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('comHeadUrl',$this->comHeadUrl,true);
		$criteria->compare('profess_proof',$this->profess_proof,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('topic_img',$this->topic_img,true);
		$criteria->compare('goods_list',$this->goods_list,true);
		$criteria->compare('error_field',$this->error_field,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('rele_time',$this->rele_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppTopicLife the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
