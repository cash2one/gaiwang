<?php

/**
 * This is the model class for table "{{seckill_auction_record}}".
 *
 * The followings are the available columns in table '{{seckill_auction_record}}':
 * @property integer $id
 * @property integer $rules_setting_id
 * @property integer $goods_id
 * @property integer $member_id
 * @property string $member_gw
 * @property integer $status
 * @property integer $auction_time
 * @property integer $is_return
 * @property string $balance_history
 * @property string $balance
 */
class SeckillAuctionRecord extends CActiveRecord
{
	const STATUS_ONE = 1;//领先
	const STATUS_TWO = 2;//出局

	const IS_RETURN_NO = 0;//积分未返还
	const IS_RETURN_YES = 1;//积分已返还

	//是否创建定单 0未创建 1已创建
	const CREATE_ORDER_NO = 0;
	const CREATE_ORDER_YES = 1;

	//流水记录表状态 1冻结 2解冻
	const FLOW_FREEZE = 1;
	const FLOW_UNFREEZE = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seckill_auction_record}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rules_setting_id, goods_id, member_id, status, auction_time, is_return', 'numerical', 'integerOnly'=>true),
			array('member_gw', 'length', 'max'=>30),
			array('balance_history, balance', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rules_setting_id, goods_id, member_id, member_gw, status, auction_time, is_return, balance_history, balance', 'safe', 'on'=>'search'),
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
			'id' => '主键',
			'rules_setting_id' => '活动规则表id',
			'goods_id' => '产品id',
			'member_id' => '会员id',
			'member_gw' => '会员GW号',
			'status' => '拍卖状态',
			'auction_time' => '拍卖时间',
			'is_return' => '积分是否返还',
			'balance_history' => '历史表中的积分',
			'balance' => '新表中的积分',
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
		$criteria->compare('rules_setting_id',$this->rules_setting_id);
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('member_gw',$this->member_gw,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('auction_time',$this->auction_time);
		$criteria->compare('is_return',$this->is_return);
		$criteria->compare('balance_history',$this->balance_history,true);
		$criteria->compare('balance',$this->balance,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeckillAuctionRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 获取积分返还状态
	 * @return array 返回状态数组
	 */
	public static function getStatusArray($key = null)
	{
		$arr = array(
			self::IS_RETURN_NO => '冻结',
			self::IS_RETURN_YES => '解冻',
		);
		return $key !== null ? (isset($arr[$key]) ? $arr[$key] : '未知状态') : $arr;
	}

	/**
	 * 获取状态
	 * @return array 返回状态数组
	 */
	/*public static function getStatus($key = null)
	{
		$arr = array(
			self::STATUS_ONE => '冻结',
			self::STATUS_TWO => '解冻',
		);
		return $key !== null ? (isset($arr[$key]) ? $arr[$key] : '未知状态') : $arr;
	}
    */
	
	/**
	 * 获取状态
	 * @return array 返回状态数组
	 */
	public static function getCreateOrderStatus($key = null)
	{
		$arr = array(
			self::CREATE_ORDER_NO => '未生成订单',
			self::CREATE_ORDER_YES => '已生成订单',
		);
		return $key !== null ? (isset($arr[$key]) ? $arr[$key] : '未知状态') : $arr;
	}

	/**
	 * 返还拍卖活动出局者的积分(未返还的)
	 * @param int $rulesSettingId 活动ID
	 * @param int $goodsId 商品ID
	 * @return bool 返回值
	 */
	public static function returnAuctionBalance($rulesSettingId = 0, $goodsId = 0, $transCommit = true)
	{
        $rows = Yii::app()->db->createCommand()
			->select('id,member_id,member_gw,balance_history,balance,flow_id,flow_code')
			->from('{{seckill_auction_record}}')
			->where('rules_setting_id=:rsid AND goods_id=:gid AND is_return=:return AND status=:status',
				array(':rsid'=>$rulesSettingId, ':gid'=>$goodsId, ':return'=>self::IS_RETURN_NO, ':status'=>self::STATUS_TWO))
			->queryAll();

		if ( !empty($rows) ){
			$flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
			$flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名

			foreach ( $rows as $v ){

				//事务开始
				if ($transCommit == true) $trans = Yii::app()->db->beginTransaction(); // 事务执行
				try {
					if ( $v['balance_history'] > 0 ){//返还历史表积分
						//组合数组
						$array = array('account_id' => $v['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v['member_gw'], 'money'=>$v['balance_history'],'flow_id'=>$v['flow_id'],'flow_code'=>$v['flow_code']);

						self::returnBalanceHistory($array, $flowHistoryTableName);
					}

					if ( $v['balance'] > 0 ){//返还新表积分
						//组合数组
						$array = array('account_id' => $v['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v['member_gw'], 'money'=>$v['balance'],'flow_id'=>$v['flow_id'],'flow_code'=>$v['flow_code']);

						self::returnBalance($array, $flowTableName);
					}

					//更新seckill_auction_flow表的状态
					$sqlRecord = "UPDATE {{seckill_auction_flow}} SET operate_type=:type WHERE id=:id";
					Yii::app()->db->createCommand($sqlRecord)->execute(array(':type'=>AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE, ':id'=>$v['flow_id']));

					//更新返还状态
					$sql = "UPDATE {{seckill_auction_record}} SET is_return=:return WHERE id=:id";
					Yii::app()->db->createCommand($sql)->execute(array(':return'=>self::IS_RETURN_YES, ':id'=>$v['id']));

					if ($transCommit == true) $trans->commit();//事务结束
				}catch (Exception $e){//抛出异常处理
					if ($transCommit == true) $trans->rollback();

					return false;
				}
			}
		}

		return true;
	}

	/**
	 * 更新消费/冻结帐户信息(旧)
	 * @param array $array 内容: 会员ID/消费类型/GW号/冻结金额
	 * @return bool
	 */
	public static function updateBalanceHistory($array = array())
	{
        if ( !empty($array) && $array['account_id'] > 0 && $array['money'] > 0 ){

			//转账人消费账户信息(旧)
			$array['type'] = AccountBalance::TYPE_CONSUME;
			$consumeInfo = AccountBalanceHistory::findRecord( $array );

			//转账人冻结账户信息(旧)
			$array['type'] = AccountBalance::TYPE_FREEZE;
			$freezeInfo = AccountBalanceHistory::findRecord( $array );

			// 借方(消费帐户)
			$debit = array(
				'account_id' => $consumeInfo['account_id'],
				'gai_number' => $consumeInfo['gai_number'],
				'card_no' => $consumeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_CONSUME,
				'debit_amount' => $array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_FREEZE,
				'remark' => '拍卖商品积分冻结，金额为：￥' . $array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_FREEZE,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			// 贷方(冻结帐户)
			$credit = array(
				'account_id' => $freezeInfo['account_id'],
				'gai_number' => $freezeInfo['gai_number'],
				'card_no' => $freezeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_FREEZE,
				'credit_amount' => $array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_FREEZE,
				'remark' => '拍卖商品积分冻结转入，金额为：￥'.$array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_FREEZE_INTO,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);
			//减转账人消费账户金额(旧)
			if (!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$array['money']),$consumeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '减消费账户金额失败！');
			//加转账人冻结账户金额(旧)
			if (!AccountBalanceHistory::calculate(array('today_amount'=>$array['money']),$freezeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '加冻结账户金额失败！');

			// 当月的流水表（旧）
			$monthTable = AccountFlowHistory::monthTable();
			// 记录月流水表（旧）
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
		}

		return true;
	}

	/**
	 * 更新消费/冻结帐户信息(新)
	 * @param array $array 内容: 会员ID/消费类型/GW号/冻结金额
	 * @return bool
	 */
	public static function updateBalance($array = array())
	{
		if ( !empty($array) && $array['account_id'] > 0 && $array['money'] > 0 ){

			//转账人消费账户信息(新)
			$array['type'] = AccountBalance::TYPE_CONSUME;
			$consumeInfo = AccountBalance::findRecord( $array );

			//转账人冻结账户信息(新)
			$array['type'] = AccountBalance::TYPE_FREEZE;
			$freezeInfo = AccountBalance::findRecord( $array );

			// 借方(消费帐户)
			$debit = array(
				'account_id' => $consumeInfo['account_id'],
				'gai_number' => $consumeInfo['gai_number'],
				'card_no' => $consumeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_CONSUME,
				'debit_amount' => $array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_FREEZE,
				'remark' => '拍卖商品积分冻结，金额为：￥' . $array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_FREEZE,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			// 贷方(冻结帐户)
			$credit = array(
				'account_id' => $freezeInfo['account_id'],
				'gai_number' => $freezeInfo['gai_number'],
				'card_no' => $freezeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_FREEZE,
				'credit_amount' => $array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_FREEZE,
				'remark' => '拍卖商品积分冻结转入，金额为：￥'.$array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_FREEZE_INTO,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);
			//减转账人消费账户金额(新)
			if (!AccountBalance::calculate(array('today_amount'=>'-'.$array['money']),$consumeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '减消费账户金额失败！');
			//加转账人冻结账户金额(新)
			if (!AccountBalance::calculate(array('today_amount'=>$array['money']),$freezeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '加冻结账户金额失败！');

			// 当月的流水表（新）
			$monthTable = AccountFlow::monthTable();
			// 记录月流水表（新）
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
		}

		return true;
	}

	/**
	 * 返还消费帐户积分(旧)
	 * @param array $array 内容: 会员ID/消费类型/GW号/冻结金额
	 * @return bool
	 */
	public static function returnBalanceHistory($array = array(),$monthTable)
	{
        if ( !empty($array) && $array['account_id'] > 0 && $array['money'] > 0 ){

			//转账人冻结账户信息(旧)
			$array['type'] = AccountBalance::TYPE_FREEZE;
			$freezeInfo = AccountBalanceHistory::findRecord( $array );

			//转账人消费账户信息(旧)
			$array['type'] = AccountBalance::TYPE_CONSUME;
			$consumeInfo = AccountBalanceHistory::findRecord( $array );

			// 借方(消费帐户)
			$credit = array(
				'account_id' => $consumeInfo['account_id'],
				'gai_number' => $consumeInfo['gai_number'],
				'card_no' => $consumeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_CONSUME,
				'debit_amount' => '-'.$array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
				'remark' => '拍卖商品积分解冻，金额为：￥' . $array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			// 贷方(冻结帐户)
			$debit = array(
				'account_id' => $freezeInfo['account_id'],
				'gai_number' => $freezeInfo['gai_number'],
				'card_no' => $freezeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_FREEZE,
				'credit_amount' => '-'.$array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
				'remark' => '拍卖商品积分解冻转入，金额为：￥'.$array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE_INTO,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			//减转账人冻结账户金额(旧)
			if (!AccountBalanceHistory::calculate(array('today_amount' => '-'.$array['money']), $freezeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！');

			//加转账人消费账户金额(旧)
			if (!AccountBalanceHistory::calculate(array('today_amount' => $array['money']), $consumeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '加消费账户金额失败！');

			// 当月的流水表（旧）
			//$monthTable = AccountFlowHistory::monthTable();
			// 记录月流水表（旧）
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));

		}
		return true;
	}

	/**
	 * 返还消费帐户积分(新)
	 * @param array $array 内容: 会员ID/消费类型/GW号/冻结金额
	 * @return bool
	 */
	public static function returnBalance($array = array(),$monthTable)
	{
		if ( !empty($array) && $array['account_id'] > 0 && $array['money'] > 0 ){
			//转账人冻结账户信息(旧)
			$array['type'] = AccountBalance::TYPE_FREEZE;
			$freezeInfo = AccountBalance::findRecord( $array );

			//转账人消费账户信息(旧)
			$array['type'] = AccountBalance::TYPE_CONSUME;
			$consumeInfo = AccountBalance::findRecord( $array );

			// 借方(消费帐户)
			$credit = array(
				'account_id' => $consumeInfo['account_id'],
				'gai_number' => $consumeInfo['gai_number'],
				'card_no' => $consumeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_CONSUME,
				'debit_amount' => '-'.$array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
				'remark' => '拍卖商品积分解冻，金额为：￥' . $array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			// 贷方(冻结帐户)
			$debit = array(
				'account_id' => $freezeInfo['account_id'],
				'gai_number' => $freezeInfo['gai_number'],
				'card_no' => $freezeInfo['card_no'],
				'order_id' => $array['flow_id'],
				'order_code' => $array['flow_code'],
				'type' => AccountFlow::TYPE_FREEZE,
				'credit_amount' => '-'.$array['money'],
				'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
				'remark' => '拍卖商品积分解冻转入，金额为：￥'.$array['money'],
				'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE_INTO,
				'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
			);

			//减转账人冻结账户金额(旧)
			if (!AccountBalance::calculate(array('today_amount' =>'-'.$array['money']), $freezeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！');

			//加转账人消费账户金额(旧)
			if (!AccountBalance::calculate(array('today_amount' =>  $array['money']), $consumeInfo['id']))
				return Yii::t('PrepaidCardTransfer', '加消费账户金额失败！');

			// 当月的流水表（旧）
			//$monthTable = AccountFlow::monthTable();
			// 记录月流水表（旧）
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
			Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
		}
		return true;
	}
}
