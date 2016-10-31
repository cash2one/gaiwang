<?php

/**
 *  积分分配配置模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class AllocationConfigForm extends CFormModel {

    public $onConsume;
    public $onRef;
    public $onAgent;
    public $onGai;
    public $onFlexible;
    public $onWeightAverage;
    public $onWeightAverage1;
    public $onWeightAverage2;
    public $middle_agent;
    public $middle_agent2;
    public $hotelOnConsume;
    public $hotelOnRef;
    public $hotelOnBusinessTravel;
    public $gaiIncome;
    public $offConsume;
    public $offRef;
    public $offAgent;
    public $offGai;
    public $offFlexible;
    public $offWeightAverage;
    public $offRefMachine;
    public $offMachineIncome;
    public $hotelOnGaiIncome;
    public $hotelService;//酒店服务费率
    public $hotelOnBusinessTravelMemberId; //绑定商旅收益账户的会员ID
    public $hotelOnBusinessTravelAccount;//商旅收益账户
    public $drugStoreService;//大药房服务费率
    public $drugStoreOnBusinessTravelMemberId; //绑定大药房收益账户的会员ID
    public $drugStoreOnBusinessTravelAccount;//大药房收益账户
    //盖网折扣收益分配(new)
    public $offConsumeNew;
    public $offRefNew;
    public $offRegion;
    public $offProvince;
    public $offCity;
    public $offDistrict;
    public $offMachineLine;
    public $offMachineOperation;
    public $gateMachineRef;
    public $offManeuver;

    // public $eptokService;//便民服务--服务费率
    public $eptokOnBusinessTravelMemberId; //绑定便民服务收益账户的会员ID
    public $eptokOnBusinessTravelAccount;//便民服务收益账户

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('onConsume, onRef, onAgent, onGai, onFlexible, onWeightAverage, middle_agent,middle_agent2
                hotelOnConsume, hotelOnRef, hotelOnBusinessTravel,
                gaiIncome, offConsumeNew, offRefNew,offConsume,offRef, offAgent, offGai, offFlexible,
                offWeightAverage,onWeightAverage1,onWeightAverage2,offRefMachine, offMachineIncome, hotelOnGaiIncome, 
                hotelService,hotelOnBusinessTravelAccount,drugStoreService,drugStoreOnBusinessTravelAccount,
                eptokOnBusinessTravelAccount,
            	offRegion, offProvince, offCity, offDistrict, offMachineLine, 
            	offMachineOperation, gateMachineRef, offManeuver', 'required'),
            array('onConsume, onRef, onAgent, onGai, onFlexible,
                hotelOnConsume, hotelOnRef, hotelOnBusinessTravel,
                gaiIncome, offConsumeNew,offRefNew,offConsume, offRef, offAgent, offGai, offFlexible,
                offWeightAverage, offRefMachine, offMachineIncome, hotelOnGaiIncome, hotelService
            	,offRegion, offProvince, offCity, offDistrict, offMachineLine, 
            	offMachineOperation, gateMachineRef, offManeuver', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 100),
            array('hotelOnGaiIncome', 'hotelCheck'),
            array('onConsume, onRef, onAgent, onGai, onFlexible,onWeightAverage', 'checkon'),
            array('onWeightAverage, onWeightAverage1,onWeightAverage2,middle_agent,middle_agent2', 'numerical', 'integerOnly'=>true,'min'=>0,'max'=>30),
            array('offRefMachine', 'checkoff'),
            array('hotelOnBusinessTravelMemberId', 'checkHotelBusinessTravelAccount',
                'diffAttribute'=>'hotelOnBusinessTravelAccount','message'=>'绑定商旅收益账户ID不一致，绑定失败！'),
            array('drugStoreOnBusinessTravelMemberId', 'checkHotelBusinessTravelAccount',
                'diffAttribute'=>'drugStoreOnBusinessTravelAccount','message'=>'绑定大药房收益账户ID不一致，绑定失败！'),
            array('eptokOnBusinessTravelMemberId', 'checkHotelBusinessTravelAccount',
                'diffAttribute'=>'eptokOnBusinessTravelAccount','message'=>'绑定便民服务收益账户ID不一致，绑定失败！'),
        
        	//盖网折扣收益分配(new)
        	array('offRegion', 'checkoffnew'),
        );
    }

    /**
     * 检查 线上分配 的总和
     * @param type $attribute
     * @param type $params
     */
    public function checkon($attribute, $params) {
        $total = $this->onConsume + $this->onRef + $this->onAgent + $this->onGai + $this->onFlexible + $this->onWeightAverage;
        if ($total != 100) {
            $this->addError($attribute, Yii::t('home', '线上商城分配和不等于100%，修改失败！'));
        }
    }

    /**
     * 检查 酒店分配 的总和
     * @param type $attribute
     * @param type $params
     */
    public function hotelCheck($attribute, $params) {
        $total = $this->hotelOnConsume + $this->hotelOnRef + $this->hotelOnBusinessTravel+$this->hotelOnGaiIncome;
        if ($total != 100) {
            $this->addError($attribute, Yii::t('home', '线上酒店分配和不等于100%，修改失败！'));
        }
    }

    /**
     * 检查 线上分配 的总和
     * @param type $attribute
     * @param type $params
     */
    public function checkoff($attribute, $params) {
        $total = $this->offConsume + $this->offRef + $this->offAgent + $this->offGai + $this->offFlexible + $this->offWeightAverage + $this->offRefMachine;
        if ($total != 100) {
            $this->addError($attribute, Yii::t('home', '线下分配和不等于100%，修改失败！'));
        }
    }
    
    /**
     * 检查 线下NEW分配 的总和
     * @param type $attribute
     * @param type $params
     */
    public function checkoffnew($attribute, $params) {
    	$total = $this->offConsumeNew + $this->offRefNew + $this->offRegion + $this->offProvince + $this->offCity + 
    	$this->offDistrict + $this->offMachineLine + $this->offMachineOperation + $this->gateMachineRef + $this->offManeuver;
    	if ($total != 100) {
    		$this->addError($attribute, Yii::t('home', '线下分配和不等于100%，修改失败！'));
    	}
    }
    /**
     * 更新酒店所有room预估返还积分    
     */
    public function updateRoomCredits(){
    	$type = MemberType::fileCache();
    	$parms = array(
    		':hotelOnConsume' => $this->hotelOnConsume/100,
    		':type' => $type['official'],
    	);
    	$sql = "update {{hotel_room}} set estimate_back_credits = TRUNCATE((((unit_price-estimate_price)-((unit_price-estimate_price)* TRUNCATE(gai_income/100,2))) * :hotelOnConsume) / :type,2 );";
    	Yii::app()->db->createCommand($sql)->execute($parms);
    }

    /**
     * 检查商旅|便民服务 收益账户与ID是否一致
     * @param string $attribute
     * @param array $params
     */
    public function checkHotelBusinessTravelAccount($attribute, $params) {
        
        $data = Yii::app()->db->createCommand()
            ->select('m.id as member_id')
            ->from('{{enterprise}} e')
            ->leftJoin('{{member}} m', 'e.id = m.enterprise_id')
            ->where('e.name = :name', array(':name' => $this->$params['diffAttribute']))
            ->queryRow();

        if ($data['member_id'] !== $this->$attribute) {
            $this->addError($attribute, Yii::t('home', $params['message']));
        }
    }

    public function attributeLabels() {
        return array(
            //线上分配
            'onConsume' => Yii::t('home', '消费者'),
            'onRef' => Yii::t('home', '推荐者'),
            'onAgent' => Yii::t('home', '商城公共'),
            'onGai' => Yii::t('home', '盖网通'),
            'onFlexible' => Yii::t('home', '机动'),
            'onWeightAverage' => Yii::t('home', '三级推荐商家会员'),
            'onWeightAverage2' => Yii::t('home', '二级推荐商家会员'),
            'onWeightAverage1' => Yii::t('home', '一级推荐商家会员'),
            'middle_agent' => Yii::t('home', '跨一级居间商推荐'),
            'middle_agent2' => Yii::t('home', '跨两级居间商推荐'),
            // 酒店分配
            'hotelOnConsume' => Yii::t('home', '消费者'),
            'hotelOnRef' => Yii::t('home', '推荐者'),
            'hotelOnBusinessTravel' => Yii::t('home', '商旅收益'),
            'hotelOnGaiIncome' => Yii::t('home', '酒店盖网通收益'),
            //新版酒店服务费率
            'hotelService' => Yii::t('home', '服务费率'),
            'hotelOnBusinessTravelAccount' => Yii::t('hotelParams', '商旅收益账户'),
            //大药房服务费率
            'drugStoreService' => Yii::t('home', '服务费率'),
            'drugStoreOnBusinessTravelAccount' => Yii::t('hotelParams', '大药房收益账户'),
            //线下盖网通收益 
            'gaiIncome' => Yii::t('home', '盖网通收益'),
            //线下分配(除去盖网收益)
            'offConsume' => Yii::t('home', '消费者'),
            'offRef' => Yii::t('home', '推荐者'),
        	'offConsumeNew' => Yii::t('home', '消费者'),
        	'offRefNew' => Yii::t('home', '推荐者'),
            'offAgent' => Yii::t('home', '代理'),
            'offGai' => Yii::t('home', '盖网通'),
            'offFlexible' => Yii::t('home', '机动'),
            'offWeightAverage' => Yii::t('home', '盖机推荐者'),
            'offRefMachine' => Yii::t('home', '最近一次消费的加盟商'),
            'offMachineIncome' => Yii::t('home', '盖机收益（盖网通商城）'),

            //便民服务费率
            // 'eptokService' => Yii::t('home', '服务费率'),
            'eptokOnBusinessTravelAccount' => Yii::t('home', '便民服务收益账户'),
        		
        	//盖网折扣收益分配(new)
        	'offRegion' => Yii::t('home', '大区'),
        	'offProvince' => Yii::t('home', '省级'),
        	'offCity' => Yii::t('home', '市级'),
        	'offDistrict' => Yii::t('home', '区/县级'),
        	'offMachineLine' => Yii::t('home', '推荐者(代理商)'),
        	'offMachineOperation' => Yii::t('home', '运维方'),
        	'gateMachineRef' => Yii::t('home', '推荐者(会员)'),
        	'offManeuver' => Yii::t('home', '机动'),
        );
    }

}
