<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class AppTopicProblem extends CActiveRecord
{
    public $life_id;
    public $nickname;
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
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, status, create_time,passed_time,admin_id,problem,content,name,member_id,life_topic_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键id',
            'name' => '专题',
            'nickname' => '昵称',
            'create_time'=>'提问时间',
            'status'=>'状态',
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
    public function searchLife()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->select = 't.id';
        //$criteria->compare('t.admin_id',Yii::app()->user->id);
        $criteria->compare('t.create_time',$this->create_time);
        $criteria->compare('t.life_topic_id',$this->life_id);
        $criteria->compare('name',$this->name,true);
        return $criteria;
    }
    const REPLY_NO = 0;  //未回复
    const REPLY_YES = 1; //已回复
    const TYPE_TOPIC = 1; //话题
    const TYPE_REPLY = 2; //回复
    const TYPE_COMMENT = 3;//评论
    public static function getReplystatus($key = null){
        $data = array(
            self::REPLY_NO => '未回复',
            self::REPLY_YES => '已回复',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    public static function getProblemType($key = null){
        $data = array(
            self::TYPE_TOPIC => '话题',
            self::TYPE_REPLY => '回复',
            self::TYPE_COMMENT => '评论',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    /*
     * 搜索出所有父话题
     * */
    public static function getLifeData($life_id,$create_time_max = '',$create_time_min = '',$nickname = '',$status='')
    {
        $where = '';
        if(!empty($create_time_max) && empty($nickname)){
            $where = "t.life_topic_id = $life_id and t.parent_id = 0 and t.create_time <= $create_time_max and t.create_time > $create_time_min";
        }elseif(!empty($create_time) && !empty($nickname)){
            $where = "t.life_topic_id = $life_id and t.parent_id = 0 and t.create_time <= $create_time_max and t.create_time > $create_time_min and m.nickname like '%".$nickname."%'";
        }elseif(empty($create_time) && !empty($nickname)){
            $where = "t.life_topic_id = $life_id and t.parent_id = 0  and m.nickname like '%".$nickname."%'";
        }elseif($status!=''){
            $where = "t.life_topic_id = $life_id and t.parent_id = 0  and t.status =$status";
        }else{
            $where = "t.life_topic_id = $life_id and t.parent_id = 0";
        }
        $lifeDate = Yii::app()->db->createCommand()
            ->select('t.*,l.title as title,m.head_portrait,m.gai_number,m.nickname')
            ->from('{{app_topic_problem}} t')
            ->leftJoin('{{app_topic_life}} l', 't.life_topic_id=l.id')
            ->leftJoin('{{member}} m', 't.member_id=m.id')
            ->where($where)
            ->order("t.create_time DESC")
            ->queryAll();
        
        return $lifeDate;
    }
    /*
  * 搜索出子话题
  * */
    public static function getLifeChildListData($life_id,$parent_id)
    {
        $user_id = Yii::app()->user->id;
        $lifeDate = Yii::app()->db->createCommand()
            ->select('m.gai_number,m.nickname,t.problem')
            ->from('{{app_topic_problem}} t')
            ->leftJoin('{{app_topic_life}} l', 't.life_topic_id=l.id')
            ->leftJoin('{{member}} m', 't.member_id=m.id')
            ->where('life_topic_id = :life_topic_id and parent_id = :parent_id and t.admin_id <> :user_id' , array(':life_topic_id' => $life_id,':parent_id'=>$parent_id,':user_id'=>$user_id))
            ->order("t.create_time DESC")
        ->queryAll();
        return $lifeDate;
    }
    /*
 * 搜索出代理商回复话题
 * */
    public static function getLifeAgen($life_id,$parent_id)
    {
        $user_id = Yii::app()->user->id;
        $lifeDate = Yii::app()->db->createCommand()
            ->select('problem')
            ->from('{{app_topic_problem}} t')
            ->leftJoin('{{app_topic_life}} l', 't.life_topic_id=l.id')
            ->leftJoin('{{member}} m', 't.member_id=m.id')
            ->where('life_topic_id = :life_topic_id and parent_id = :parent_id and t.admin_id = :user_id' , array(':life_topic_id' => $life_id,':parent_id'=>$parent_id,':user_id'=>$user_id))
            ->queryScalar();
        return $lifeDate;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegionManage the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}