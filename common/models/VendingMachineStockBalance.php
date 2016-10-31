<?php

/**
 * This is the model class for table "{{vending_machine_stock_balance}}".
 *
 * The followings are the available columns in table '{{vending_machine_stock_balance}}':
 * @property integer $id
 * @property integer $goods_id
 * @property integer $machine_id
 * @property double $num
 * @property integer $node
 * @property integer $node_type
 * @property integer $actor_id
 * @property integer $balance
 * @property integer $cur_balance
 * @property integer $create_time
 */
class VendingMachineStockBalance extends CActiveRecord
{
	public $name;
	public $g_price;
	public $g_name;
	public $status;

	public $isExport;   //是否导出excel
	public $exportPageName = 'page'; //导出excel起始
	public $exportLimit = 5000; //导出excel长度
	
	//业务节点
	const NODE_SELLER_STOCK_IN = 1;							//商家入库
	const NODE_SELLER_STOCK_OUT = 2;						//商家出库
	const NODE_SYS_STOCK_IN = 3;							//系统入库
	const NODE_SYS_STOCK_OUT = 4;						//系统出库
	const NODE_CONSUME_OUT= 5;								//消费出库
	const NODE_SELLER_CREATE= 6;								//商家新建商品
	
	const NODE_TYPE_IN= 1;										//节点类型 入库
	const NODE_TYPE_OUT= 2;										//节点类型 出库
	
	public static function getNodeType($key = null)
	{
		$data = array(
				self::NODE_TYPE_IN => Yii::t('VendingMachineGoods', '入库'),
				self::NODE_TYPE_OUT => Yii::t('VendingMachineGoods', '出库'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	public static function getNode($key = null)
	{
		$data = array(
				self::NODE_SELLER_STOCK_IN => Yii::t('VendingMachineGoods', '商家入库'),
				self::NODE_SELLER_STOCK_OUT => Yii::t('VendingMachineGoods', '商家出库'),
				self::NODE_SYS_STOCK_IN => Yii::t('VendingMachineGoods', '系统入库'),
				self::NODE_SYS_STOCK_OUT => Yii::t('VendingMachineGoods', '系统出库'),
				self::NODE_CONSUME_OUT => Yii::t('VendingMachineGoods', '消费出库'),
				self::NODE_SELLER_CREATE => Yii::t('VendingMachineGoods', '商家添加商品初始库存'),
		);
		return $key === null ? $data : $data[$key];
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vending_machine_stock_balance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('machine_id', 'required'),
			array('goods_id, machine_id, node, actor_id, balance, cur_balance, create_time', 'numerical', 'integerOnly'=>true),
			array('num', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, goods_id, machine_id, num, node, actor_id, balance, cur_balance, create_time, g_name', 'safe', 'on'=>'search'),
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
			'goods_id' => 'Goods',
			'machine_id' => 'Machine',
			'num' => '数量',
			'node' => '节点',
			'actor_id' => '消费者id',
			'balance' => '最新库存',
			'cur_balance' => '当前操作量',
			'create_time' => '日期',
			'g_name' => '商品名称',
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
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('machine_id',$this->machine_id);
		$criteria->compare('num',$this->num);
		$criteria->compare('node',$this->node);
		$criteria->compare('actor_id',$this->actor_id);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('cur_balance',$this->cur_balance);
		$criteria->compare('create_time',$this->create_time);

		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => $pagination,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VendingMachineStockBalance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 生成流水记录
	 * 
	 * @param $goods_obj 售货机商品对象
	 * 
	 */
	public static function createRecord($node,$node_type,$goods_obj,$num,$actor_id){
		$bal = new VendingMachineStockBalance();
		$bal->goods_id = $goods_obj->id;
		$bal->machine_id = $goods_obj->machine_id;
		$bal->num = $num;
		$bal->node_type = $node_type;
		$bal->node = $node;
		$bal->actor_id = $actor_id;
		$bal->balance = $goods_obj->stock+$num;
		$bal->cur_balance = abs($num);
		$bal->create_time = time();
		
		return $bal->save();
	}
	
	/**
	 * 生成流水记录  商家平台入库
	 */
	public static function createSellerInRecord($goods_obj,$num,$actor_id){
		return self::createRecord(self::NODE_SELLER_STOCK_IN,self::NODE_TYPE_IN,$goods_obj,$num,$actor_id);
	}
	
	
	/**
	 * 生成流水记录  商家平台入库
	 */
	public static function createSellerOutRecord($goods_obj,$num,$actor_id){
		return self::createRecord(self::NODE_SELLER_STOCK_OUT,self::NODE_TYPE_OUT,$goods_obj,$num,$actor_id);
	}
	
	
	/**
	 * 生成流水记录  商家平台添加商品入库
	 */
	public static function createSellerAddGoodsRecord($goods_obj,$num,$actor_id){
		return self::createRecord(self::NODE_SELLER_CREATE,self::NODE_TYPE_IN,$goods_obj,$num,$actor_id);
	}
	
	
	
	public function searchBalance()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.goods_id',$this->goods_id);
		$criteria->compare('t.machine_id',$this->machine_id);

        if (!empty($this->g_name))
            $criteria->compare('vg.name', $this->g_name, true);

		$criteria->select = 't.*,vg.name as name, g.name as g_name,g.price as g_price';
		$criteria->join = ' LEFT JOIN  '.VendingMachineGoods::model()->tableName().' as vg ON t.goods_id=vg.id ';
		$criteria->join .= ' LEFT JOIN  '.Goods::model()->tableName().' as g ON vg.goods_id=g.id ';
		$criteria->order = 't.create_time DESC';
		$criteria->group = 't.id';
	
		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => $pagination,
		));
	}
	
	
}
