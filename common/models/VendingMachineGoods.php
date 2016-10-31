<?php

/**
 * This is the model class for table "{{vending_machine_goods}}".
 *
 * The followings are the available columns in table '{{vending_machine_goods}}':
 * @property integer $id
 * @property string $name
 * @property integer $machine_id
 * @property integer $goods_id
 * @property string $unit
 * @property integer $sold
 * @property integer $stock
 * @property integer $frezn_stock
 * @property string $size
 * @property integer $status
 * @property integer $create_time
 */
class VendingMachineGoods extends CActiveRecord
{
	public $g_price;
	public $gs_price;
	public $g_name;
	public $spec_name;
	public $spec_value;
	public $stock_num;			//入\出库数量
	public $update_mall;			//是否更新商城库存
	
	public $isExport;   //是否导出excel
	public $exportPageName = 'page'; //导出excel起始
	public $exportLimit = 5000; //导出excel长度
	
	
	const MAX_ENABLE_GOODS_NUMBER_PER_MACHINE = 36;		//每台机器最大上架商品数量
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vending_machine_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('machine_id, goods_id,spec_id,sold, stock, frezn_stock, status, create_time', 'numerical', 'integerOnly'=>true),
			array('unit, size,thumb', 'length', 'max'=>256),
			array('name', 'length', 'max'=>128),
			array('name', 'required'),
// 			array('name', 'checkName'),
			array('goods_id,machine_id,thumb,status', 'required','on'=>'insert,create,update'),
			array('machine_id,thumb,price,status', 'required','on'=>'insertV2,createV2,updateV2'),
			array('price', 'numerical'),
			array('price', 'match', 'pattern'=>'/^\d+(\.\d{1,2}){0,1}$/u',  
               'message'=>'只能保留两位小数！'),  
			array('price', 'compare', 'compareValue' => '0', 'operator' => '>', 'message' => '必须大于0'),
			array('price', 'length', 'max' => 14), //要考虑小数点，不能限制到11位
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, machine_id, goods_id,spec_id, unit, sold, stock, frezn_stock, size, status, create_time,thumb,spec_name,spec_value,gs_price,price', 'safe', 'on'=>'search'),
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
	
	protected function checkName($attribute, $params) {
        $rs = Yii::app()->db->createCommand()
            ->select('name,id')
            ->from(self::tableName())
            ->where('name=:name AND machine_id=:machine_id', array(':name' => $this->name,':machine_id' => $this->machine_id))
            ->queryRow();
        if (($this->isNewRecord && !empty($rs)) || (!$this->isNewRecord && !empty($rs) && $rs->id != $this->id)) {
            $this->addError($attribute, Yii::t('member', '商品名已存在'));
        }
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '商品名称',
			'machine_id' => '售货机id',
			'price' => '售价',
			'goods_id' => '商城商品id',
			'spec_id' => '商城商品规格id',
			'unit' => '单位',
			'sold' => '已售',
			'stock' => '库存',
			'thumb' => '封面图片',
			'frezn_stock' => '冻结库存',
			'size' => '体积、大小',
			'status' => '状态',
			'create_time' => '创建时间',
			'g_name' => '商品名称',
			'g_price' => '售价',
		);
	}

	
	//状态
	const STATUS_APPLY = 0;   //申请
	const STATUS_ENABLE = 1;  //上架
	const STATUS_DISABLE = 2; //下架
	public static function getStatus($key = null)
	{
		$data = array(
// 				self::STATUS_APPLY => Yii::t('VendingMachineGoods', '申请'),
				self::STATUS_ENABLE => Yii::t('VendingMachineGoods', '上架'),
				self::STATUS_DISABLE => Yii::t('VendingMachineGoods', '下架'),
		);
		return $key === null ? $data : $data[$key];
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('machine_id',$this->machine_id);
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('sold',$this->sold);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('frezn_stock',$this->frezn_stock);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('status',$this->status);
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
	 * @return VendingMachineGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
	/**
	 * 查询详细数据
	 * @return CActiveDataProvider
	 */
	public static function findDetailById($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('t.id',$id);
		$criteria->select = 't.*,g.name as g_name,g.price as g_price';
		$criteria->join = ' LEFT JOIN  '.Goods::model()->tableName().' as g ON t.goods_id=g.id';
		
		return self::model()->find($criteria);
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
	public function searchDetails()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.machine_id',$this->machine_id);
		$criteria->compare('t.goods_id',$this->goods_id);
		$criteria->compare('t.unit',$this->unit,true);
		$criteria->compare('t.sold',$this->sold);
		$criteria->compare('t.stock',$this->stock);
		$criteria->compare('t.frezn_stock',$this->frezn_stock);
		$criteria->compare('t.size',$this->size,true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.create_time',$this->create_time);
		
		$criteria->select = 't.*,g.name as g_name,g.price as g_price,gs.price as gs_price,gs.spec_name,gs.spec_value';
		$criteria->join = ' LEFT JOIN  '.Goods::model()->tableName().' as g ON t.goods_id=g.id';
		$criteria->join .= ' LEFT JOIN  '.GoodsSpec::model()->tableName().' as gs ON t.spec_id=gs.id';
		$criteria->order = 't.create_time DESC';
		
		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}
	
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
	public function searchDetailsV2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.machine_id',$this->machine_id);
		$criteria->compare('t.goods_id',$this->goods_id);
		$criteria->compare('t.unit',$this->unit,true);
		$criteria->compare('t.sold',$this->sold);
		$criteria->compare('t.stock',$this->stock);
		$criteria->compare('t.frezn_stock',$this->frezn_stock);
		$criteria->compare('t.size',$this->size,true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.create_time',$this->create_time);
	
// 		$criteria->select = 't.*';
		$criteria->order = 't.create_time DESC';
	
		$pagination = array();
		if (!empty($this->isExport)) {
			$pagination['pageVar'] = $this->exportPageName;
			$pagination['pageSize'] = $this->exportLimit;
		}
	
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
	 * 商品入库
	 * @param int $stock_num
	 * @return boolean
	 */
	public function stockIn($stock_num,$actor_id=0)
	{
		$trans = Yii::app()->db->beginTransaction();
		try{
			//更新库存
			$stock_num = $stock_num*1;
			$sql = "UPDATE ".$this->tableName().' SET stock=stock+'.$stock_num.' WHERE id='.$this->id;
			$id = Yii::app()->db->createCommand($sql)->execute();
	
			//更新流水
			VendingMachineStockBalance::createSellerInRecord($this, $stock_num, $actor_id);

			$trans->commit();
		}catch (Exception $e){
                $trans->rollback();
        }
		
		return $id;
	}
	
	/**
	 * 商品出库
	 * @param int $stock_num
	 * @return boolean
	 */
	public function stockOut($stock_num,$actor_id=0)
	{
		$trans = Yii::app()->db->beginTransaction();
		try{
			//更新库存
			$stock_num = 0-$stock_num*1;
			$sql = "UPDATE ".$this->tableName().' SET stock=stock+'.$stock_num.' WHERE id='.$this->id;
			$id = Yii::app()->db->createCommand($sql)->execute();
	
			//更新流水
			VendingMachineStockBalance::createSellerOutRecord($this, $stock_num, $actor_id);
	
			$trans->commit();
		}catch (Exception $e){
			$trans->rollback();
		}
	
		return $id;
	}
	
	/**
	 * 检查某机器是否有某商品
	 * @param unknown $mid
	 * @param unknown $gid
	 */
	public static function checkGoods($mid,$gid){
		if( !VendingMachineGoods::model()->count(" machine_id={$mid} AND goods_id={$gid}")) return false;
		return true;
	}
	
	/*
	 * 保存记录
	 * 
	 * 
	 */
	public function mySave($actor_id=0)
	{
		$trans = Yii::app()->db->beginTransaction();
		$id = false;
		try{
			//更新流水
			$id = $this->save();
			$stock = $this->stock;
			$this->stock = 0;
			$trs = VendingMachineStockBalance::createSellerAddGoodsRecord($this, $stock, $actor_id);
	
			$trans->commit();
		}catch (Exception $e){
			$trans->rollback();
		}
	
		return $id;
	}
	
	/**
	 * 商品销售的一系列操作
	 * @param int $stock_num
	 * @return boolean
	 */
	public static function sellGoods($goods,$stock_num,$actor_id=0)
	{
	    try {
	        $stock_num = $stock_num*1;
	        $db = Yii::app()->db;
	        $sql = "UPDATE ".self::tableName().' SET stock=stock - '.$stock_num.' , sold =sold + '.$stock_num.'  WHERE id='.$goods['id'];
	        //更新流水
	        if(Yii::app()->db->createCommand($sql)->execute())
	        {
	            $data = array(
	                    'goods_id'=>$goods['id'],
	                    'machine_id'=>$goods['machine_id'],
	                    'num'=>-$stock_num,
	                    'node'=>VendingMachineStockBalance::NODE_SELLER_STOCK_OUT,
	                    'node_type'=>VendingMachineStockBalance::NODE_TYPE_OUT,
	                    'actor_id'=>$actor_id,
	                    'balance'=>$goods['stock'] - $stock_num,
	                    'cur_balance'=>abs($stock_num),
	                    'create_time'=>time(),
	            );
	            $db->createCommand()->insert(VendingMachineStockBalance::tableName(), $data);
	            $recordId = $db->getLastInsertID();
	            return $recordId;
	        }
	    }catch(Exception $e){
	        throw new Exception($e->getMessage());
	        return false;
	    }
	}
	
}
