<?php

/**
 * This is the model class for table "{{franchisee_contract}}".
 *
 * The followings are the available columns in table '{{franchisee_contract}}':
 * @property string $id
 * @property string $member_id
 * @property string $contract_id
 * @property string $number
 * @property string $a_name
 * @property string $a_address
 * @property string $b_name
 * @property string $b_address
 * @property string $original_contract_time
 * @property integer $status
 * @property string $confirm_time
 * @property string $create_time
 * @property string $update_time
 */
class FranchiseeContract extends CActiveRecord
{

	const FRANCHISEE_CONTRACT_STATUS_NO_CONFIRM		=	0;  //协议商户未确认
	const FRANCHISEE_CONTRACT_STATUS_CONFIRM		=	1;  //协议商户已经确认
	const FRANCHISEE_CONTRACT_STATUS_DELETE			=	2;  //协议删除

	// public $franchisee_mobile;	   //手机号码
	// public $franchisee_name;       //商户名称
	public $member_name;		   //用户名
	public $contract_type;		   //合同类型
	public $contract_version;	   //合同版本
	public $gai_number;  		   //GW号
	
    public $exportPageName = 'page'; //导出excel时的分页参数名
    public $exportLimit = 5000;      //导出excel长度
    public $isExport;                //是否导出excel

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_contract}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('number, a_name, b_name, b_address, original_contract_time, status,protocol_no', 'required','message'=>'{attribute}不能为空'),
			array('contract_id','required','message'=>'合同版本不能为空'),
			array('member_id','required','message'=>'盖网编号不存在，请重新输入'),
			array('member_id','isEnterriseMember'),
			array('number,protocol_no','unique','message'=>'{attribute}重复'),
			array('member_id','memberIdUnique'),
			
			array('confirm_time', 'default', 'value' => 0),
			array('a_address', 'aAddressRequired'),
			array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'on' => 'insert'),
			array('update_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'on' => 'insert,update'),
			array('status', 'numerical', 'integerOnly'=>true,'message'=>'{attribute}必须为数字'),
			array('member_id, contract_id', 'length', 'max'=>11),
			array('number,protocol_no', 'length', 'max'=>128),
			array('a_name, b_name', 'length', 'max'=>100,'message'=>'{attribute}不能大于100字节'),
			array('a_address, b_address', 'length', 'max'=>255,'message'=>'{attribute}不能大于255字节'),
			array('original_contract_time', 'length', 'max'=>10),

			array('id, member_id,protocol_no, contract_id, number, a_name, a_address, b_name, b_address, original_contract_time, status, confirm_time, create_time, update_time', 'safe', 'on'=>'search'),
			array('gai_number,contract_type,contract_version,member_name', 'safe'),
		);
	}

	/**
	 * 检验是否为空
	 */
	public function aAddressRequired($attribute,$params)
	{	
		if($this->contract_type==Contract::CONTRACT_TYPE_REGULAR_CHAIN){
			if($this->a_address===null || $this->a_address===array() || $this->a_address==='' || 
				(is_scalar($this->a_address) && trim($this->a_address)==='') )
				$this->addError('a_address',"甲方地址不能为空");
		}
	}

	/**
	 * 检验franchisee_id是否唯一
	 */
	public function memberIdUnique($attribute,$params)
	{	
		$conditions  = $this->isNewRecord ? ' 1=1 ' : ' id !='.$this->id;
		$conditions .= ' AND member_id=:member_id AND status=:status';
		$paramArr  = array(
					':member_id' => $this->member_id,
					':status' => self::FRANCHISEE_CONTRACT_STATUS_NO_CONFIRM,
				);

		$res = self::model()->count($conditions,$paramArr);
		if($res>0)
			$this->addError('member_id',"盖网编号已添加过，请不要重复添加重复");
	}

	/**
	 * 检测是否是企业会员
	 */
	public function isEnterriseMember($attribute,$params){
    	$member = Member::model()->exists(
    				"id = :id AND enterprise_id > 0 ",
    				array(":id"=>$this->member_id)
    			  );
    	if(!$member) 
    		$this->addError('member_id',"该编号为普通会员编号，请输入企业会员编号");
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'contract'   => array(self::HAS_ONE,'Contract', array('id' => 'contract_id')),
			'member' => array(self::HAS_ONE,'Member',array('id' => 'member_id')),
			// 'franchisee' => array(self::HAS_ONE,'Franchisee',array('id' => 'franchisee_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			
			'id'            =>  Yii::t('franchiseecontract','ID'),
			'member_id' 	=>  Yii::t('franchiseecontract','会员id'),
			'contract_id'   =>  Yii::t('franchiseecontract','合同id'),
			'number'        =>  Yii::t('franchiseecontract','原合同编号'),
			'protocol_no'   =>  Yii::t('franchiseecontract','协议编号'),
			'a_name'        =>  Yii::t('franchiseecontract','甲方名称'),
			'a_address'     =>  Yii::t('franchiseecontract','甲方地址'),

			'b_name'        =>  Yii::t('franchiseecontract','乙方名称'),
			'b_address'     =>  Yii::t('franchiseecontract','乙方地址'),
			
			'status'        =>  Yii::t('franchiseecontract','协议状态'),
			'gai_number'    =>  Yii::t('franchiseecontract','盖网编号'),
			'confirm_time'  =>  Yii::t('franchiseecontract','协议确认时间'),
			'create_time'   =>  Yii::t('franchiseecontract','创建时间'),
			'update_time'   =>  Yii::t('franchiseecontract','更新时间'),

			'contract_type'          =>	 Yii::t('franchiseecontract','合同类型'),
			'member_name'        	 =>  Yii::t('franchiseecontract','用户名'),
			'contract_version'       =>	 Yii::t('franchiseecontract','合同版本'),
			// 'franchisee_mobile'      =>  Yii::t('franchiseecontract','手机号码'),
			'original_contract_time' =>  Yii::t('franchiseecontract','原合同日期'),
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
	public function search(){

		$criteria=new CDbCriteria;
		$criteria->compare('t.id',$this->id,true);
		$criteria->with = array(
			'contract'   => array('select'=>'version,type'),
			'member'	 => array('select'=>'id,username,gai_number'),
			// 'franchisee' => array('select'=>'name,mobile,member_id',
			// 					'with' => array(
			// 						'member' => array('select'=>'gai_number'),
			// 					), 
			// 				),
		);


		$criteria->compare('t.member_id',$this->member_id,true);
		$criteria->compare('t.number',$this->number,true);
		$criteria->compare('t.protocol_no',$this->protocol_no,true);
		if(isset($this->status) && $this->status!==''){
			$criteria->compare('t.status',$this->status);
		}else{
			$criteria->compare('t.status','<>'.self::FRANCHISEE_CONTRACT_STATUS_DELETE);
		}
	
		$criteria->select = 't.*';
		$criteria->order = ' t.update_time desc,t.create_time desc ';
		$this->appendFilter($criteria);
		$pagination = array(
			'pageSize' => 20,
		);

		if(!empty($this->isExport)){
			$pagination['pageVar']  = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}
		// echo "<pre>";var_dump($criteria);die;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => $pagination,
		));
	}

	/**
	 * 追加过滤条件
	 */
	private function appendFilter(&$criteria){

		$filters = array(
				'contract_type' => array('contract.type',false),
				'member_name'   => array('member.username',true),
				'gai_number'    => array('member.gai_number',true),
			);
		foreach((array)$filters as $key => $value){
			if(isset($this->$key) && !empty($this->$key)){
				$criteria->compare($value[0],$this->$key,$value[1]);
			}			
		}
	}

	/**
	 * before validate todo...
	 */
	public function beforeValidate(){
        
        parent::beforeValidate();
        if($this->isNewRecord){
        	$this->status = self::FRANCHISEE_CONTRACT_STATUS_NO_CONFIRM;
        }
        $this->original_contract_time = strtotime($this->original_contract_time);
        return true;
    }

    public function afterFind(){
    	parent::afterFind();
    	$this->original_contract_time = date('Y-m-d',$this->original_contract_time);
    	return true;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeContract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 获取确认状态
	 */
	public static function getConfirmStatu($key = NULL){
		$confirmStatuArr = array(
			self::FRANCHISEE_CONTRACT_STATUS_CONFIRM	=>  Yii::t('franchiseecontract','商户已确认'),
			self::FRANCHISEE_CONTRACT_STATUS_NO_CONFIRM	=>  Yii::t('franchiseecontract','商户未确认'),
			// self::FRANCHISEE_CONTRACT_STATUS_DELETE		=>  '已删除',
		);
		return $key == NULL ? $confirmStatuArr : $confirmStatuArr[$key];
	}
    
    /**
     * 验证是否有 预览访问权限
     */
	public static function createPrevoisvUrl($franchiseeId){
	    $safeCode = '12abc34adeadaeaf2232a';
	    return DOMAIN.'/confirm/index/id/'.$franchiseeId.'/code/'.$safeCode;
	}
    
    /**
     * 验证是否有 更新访问权限
     */
	public static function checkAccessUpdate($status){
	    $mark = Yii::app()->user->checkAccess("FranchiseeContract.Update");
	    return ($status!=1 && $mark) ? true : false;
	}
    
    /**
     * 验证是否有 查看访问权限
     */
	public static function checkAccessView($status){
	    $mark = Yii::app()->user->checkAccess("FranchiseeContract.view");
	    return ($status==1 && $mark) ? true : false;
	}
    
    /**
     * 验证是否有 删除访问权限
     */
	public static function checkAccessDelete($status){
	    $mark = Yii::app()->user->checkAccess("FranchiseeContract.Delete");
	    return ($status!=1 && $mark) ? true : false;
	}

	/**
	 * 根据member_id获取 一条记录
	 * 
	 * @param  int     $id 
	 * @param  boolean $isFranchisee 是否franchisee id  默认false（memeber id ）
	 * @return array
	 */
	public function findByMemberId($id,$isFranchisee=false){

		$andWhere  = '';
		if(!is_numeric($id)) return false;
		if($isFranchisee==false){
			$andWhere .= " `member_id` = '{$id}' AND `status`=".self::FRANCHISEE_CONTRACT_STATUS_NO_CONFIRM;
		}else{
			$andWhere .= ' id = '.$id;	
		}
	
		$res = self::model()->find($andWhere);
		return $res ? $res : false;
	}

	/**
	 * 根据member_id获取 用户最近一次确认过的补充协议
	 * 
	 * @param  int     $id
	 * @return array
	 */
	public function getComfirmedContract($id){

		$andWhere  = '';
		if(!is_numeric($id)) return false;
		$andWhere .= " `member_id` = '{$id}'  AND `status`=".self::FRANCHISEE_CONTRACT_STATUS_CONFIRM;
		$res = self::model()->find(array(
			'condition' => $andWhere,
			'order' => 'confirm_time desc',
		));
		return $res ? $res : false;
	}

	/**
	 * 确认补充协议
	 * 
	 * @param  int $id
	 * @return boolean
	 */
	public function confirm($id){

		if(!is_numeric($id)) return false;
		$res = self::model()->find('id = '.$id);
		if($res){
			$res->confirm_time = time();
			$res->status = self::FRANCHISEE_CONTRACT_STATUS_CONFIRM;
			if($res->save()) return true;
		}
		return false;
	}	

	 /**
     * 删除商户签订的协议，状态为 FRANCHISEE_CONTRACT_STATUS_DELETE
     *
     * @param   number  $id
     * @return  boolean
     */
    public  function del($id){
    	
    	if(empty($id)) return false;
    	if(is_numeric($id)) $idWhere = ' id = '.$id.' ';

    	$sql = "update ".self::model()->tableName()." set `number`=concat('del_".$id."_',number), `protocol_no`=concat('del_".$id.
    				"_',protocol_no),`status` = ".self::FRANCHISEE_CONTRACT_STATUS_DELETE." where ".$idWhere;
    	$res = Yii::app()->db->createCommand($sql)->execute();
    	return $res===false ? false : true;
    }
}
