<?php

/**
 * This is the model class for table "{{vote}}".
 *
 * The followings are the available columns in table '{{vote}}':
 * @property string $member_id
 * @property string $candidate_id
 * @property string $type
 * @property string $created
 */
class Vote extends CActiveRecord
{
    const TYPE_SIGN = 2; //签到
    const TYPE_LUCK = 3; //抽奖
    const TYPE_ZXPK_VOTE = 4; //中西大厨PK投票
    const TYPE_FZ_VOTE = 5; //2016双十一活动15款服装投票
    
    const VOTE_CANDIDATE_CH=201608301;//中方
    const VOTE_CANDIDATE_EN=201608302;//西方
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vote}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, candidate_id, created', 'required'),
			array('member_id, candidate_id, type, created', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, candidate_id, type, created', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'candidate_id' => 'Candidate',
			'type' => 'Type',
			'created' => 'Created',
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

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('candidate_id',$this->candidate_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //军旅专题投票统计
    public static function voteCount($candidateId){
        $count = self::model()->countByAttributes(array('candidate_id' => $candidateId));
        return $count ? $count : 0;
    }

    /**
     * 军旅专题投票红包奖励
     * 修改：
     * 中西大厨PK投票
     * @date 20160830-20160915
     * @author wyee<yanjie.wang@g-emall>
     */
    public static function voteReward($memberId){
        $member = self::model()->countByAttributes(array('member_id' => $memberId,'type'=>self::TYPE_ZXPK_VOTE));
        if($member == 1){
            $rs = Member::model()->findByPk($memberId);
            if($rs){
                try{
                    $rs = RedEnvelopeTool::createRedisActivity($memberId, Coupon::SOURCE_GAIWANG, Activity::TYPE_VOTE, Coupon::COMPENSATE_YES);
                }catch (Exception $e){
					exit("派发红包失败:".$e->getMessage());
                }
            }
        }
    }
    
    /**
     * 用户当天是否签到
     * @time string 当前时间
     * @userId 用户ID
     * @author qiuye.xu qiuye.xu@g-emall.com
     * @return 
     */
    public static function isSignIn($time,$userId)
    {
        return self::model()->find(array(
            'select' => 'created',
            'condition' => 'created >= :begintime AND created <= :endtime AND member_id = :id AND type=:type',
            'params' => array(':begintime' => strtotime(date('Ymd', $time)), ':endtime' => strtotime(date('Ymd', $time)) + 86400, ':id' => $userId, ':type' => Vote::TYPE_SIGN)
        ));
    }
    
    /**
     * 每日签到送红包
     * @param int $memberId  用户ID
     */
    public static function signReword($memberId)
    {
        $rs = Member::model()->findByPk($memberId);
        if($rs){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sms_content = '';
                $rs = RedEnvelopeTool::createRedisActivity($memberId, Coupon::SOURCE_GAIWANG, Activity::TPYE_SIGNIN, Coupon::COMPENSATE_YES, $sms_content);
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollback();
                    exit("派发红包失败:".$e->getMessage());
            }
        }
    }
    /**
     * 抽奖 配置项 概率和为100 否则不合理 抽奖专题修改这里的配置就可以了
     * 中奖项 格式
     * array(
     *  array('奖项ID','中奖概率','中奖金额','中奖类型')
     * )
     * @var array
     */
    protected static $lotteryOption = array(
        array('id' => 1, 'angle' => 50, 'price' => 38,'type'=>6),
        array('id' => 2, 'angle' => 20, 'price' => 68,'type'=>12),
        array('id' => 3, 'angle' => 15, 'price' => 88,'type'=>7),
        array('id' => 4, 'angle' => 10, 'price' => 188,'type'=>8),
        array('id' => 5, 'angle' => 5, 'price' => 520,'type'=>10)
    );
    protected static $randNumber = 10000; // 随机精度数
    /**
     * 抽奖概率算法
     */
    public static function luckDraw()
    {
        $range = array();//中奖范围
        //根据精度数和概率,算出每个中奖项的数值范围
        foreach (self::$lotteryOption as $k=>$v){
            $range[$k] = $v['angle'];
        }

        //返回中奖数据
        $winning = self::getRand($range);
        return self::$lotteryOption[$winning];
    }

    /**
     * 返回中奖数据
     */
    public static function getRand($proArr){
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach($proArr as $key => $proCur){
            $randNum = mt_rand(1,$proSum);
            if($randNum <= $proCur){
                $result = $key;
                break;
            }else{
                $proSum -= $proCur;
            }
        }
        unset($proArr);

        return $result;
    }

    /**
     * 派送红包 
     */
    public static function elevenReward($memberId,$type){

        $rs = Member::model()->findByPk($memberId);
        if($rs){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sms_content = '';
                $rs = RedEnvelopeTool::createRedisActivity($memberId, Coupon::SOURCE_GAIWANG, $type, Coupon::COMPENSATE_YES, $sms_content);
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollback();
//                exit("派发红包失败:".$e->getMessage());
                return true;
            }
        }
    }
    
    /**
     * 得到总数
     * @param int $type 类别
     */
    public static function getVoteAll($type){
    	$data = Yii::app()->db->createCommand()
    	->select('candidate_id,count(*) as sum_vote')
    	->from('{{vote}}')
    	->where('type=:type', array(':type' => $type))
    	->group('candidate_id')
    	->queryAll();
    	$dataArr=array();
    	$goodsId=array();
    	$dataStr='';
    	for($i=1;$i<16;$i++){
    		$goodsId[]=$i;
    	  }
        if(!empty($data)){
       	$typeArr=array();
       	  foreach ($data as $k=>$v){
       	 	$typeArr[]=$v['candidate_id'];
       	  }
       	  foreach ($goodsId as $k => $v){
       	  	if(!in_array($v, $typeArr)){
       	  		$data[$k+15]['candidate_id']=$v;
       	  		$data[$k+15]['sum_vote']=0;
       	  	}
       	  }
       	  array_values($data);
       	  foreach ($data as $k=>$v){
       	  	$tArr[]=$v['candidate_id'];
       	  }
       	  array_multisort($data,SORT_ASC, $tArr);
       	foreach ($data as $k => $v){
       		$dataArr[]=$v['sum_vote'];
       	 }
       	 $dataStr=implode(',', $dataArr);
       }  
        return $dataStr;
    }
    
}
