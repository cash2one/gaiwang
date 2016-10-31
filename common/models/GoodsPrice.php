<?php

/**
 *  商品历史价格表 模型
 *
 * The followings are the available columns in table '{{goods_price}}':
 * @property string $id
 * @property string $goods_id
 * @property string $price
 * @property integer $create_time
 */
class GoodsPrice extends CActiveRecord
{
    /**
     * 历史价格的最大记录数
     */
    const MAX_NUM = 30;

	public function tableName()
	{
		return '{{goods_price}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id', 'required'),
			array('create_time', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('goods_id', 'length', 'max'=>10),
			array('price', 'length', 'max'=>11),
			array('id, goods_id, price, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('goodsPrice','ID'),
			'goods_id' => Yii::t('goodsPrice','商品id'),
			'price' => Yii::t('goodsPrice','价格'),
			'create_time' => Yii::t('goodsPrice','时间'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('goods_id',$this->goods_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     *
     *  插入历史价格，当修改的价格小于历史最大价格，则返回原来的商品状态
     *  否则返回 审核中 状态
     * @param int $goods_id 商品id
     * @param float $price 商品当前价格
     * @param float $oldPrice 商品修改前的价格
     * @param int $status 商品当前状态
     * @return int
     */
    public static function getGoodsStatus($goods_id,$price,$oldPrice,$status){
        $sql = 'select id,price from gw_goods_price where goods_id=:gid';
        $db = Yii::app()->db;
        $data = $db->createCommand($sql)->bindValue(':gid',$goods_id)->queryAll();
        //修改重要信息时商城和产品得出的一致修改结果: 如果价格不比历史价格高则直接将当前价格写入历史价格,如果比历史价格高则在审核通过那一步再将当前价格写入历史价格 2015-08-20 李文豪
		//$db->createCommand()->insert('gw_goods_price',array('goods_id'=>$goods_id,'price'=>$oldPrice,'create_time'=>time()));
        
		//如果为空
        if(empty($data)){
            if($status==Goods::STATUS_PASS && $price>$oldPrice){
                return Goods::STATUS_AUDIT;
            }else{
				//通过审核的时候会增加记录,这里不需要再增加了
				//$db->createCommand()->insert('gw_goods_price',array('goods_id'=>$goods_id,'price'=>$price,'create_time'=>time()));
                return $status;
            }
        }else{
			//如果有十条了，删掉第一条
			if(count($data)>=self::MAX_NUM){
				$db->createCommand()->delete('gw_goods_price','id='.$data[0]['id']);
			}
			
			if($status==Goods::STATUS_AUDIT ){//原本就是审核中的,不再做历史价格的记录
				return $status;
			}
			
			//由于以前写进的是历史价格,所以会导致涨过一次价后下次修改只要价格比前一次高,状态就会变成审核中了,现增加一个条件避免这个问题 2015-08-20 李文豪
			if($status==Goods::STATUS_PASS && $price==$oldPrice){//已审核状态,新价等于原价的时候不用记录该价格
			    //为了兼顾以前的内容(2015-08-20之前都没有记录当前价格而是记录历史价格,所以会出现保存后状态变成审核中的bug),拿数据库最新的一条记录出来做对比,如果不相同就写入记录,如果相同就不写入了
				$rs = Yii::app()->db->createCommand()->select('price')->from('{{goods_price}}')
                      ->where('goods_id=:goods_id', array(':goods_id'=>$goods_id))
					  ->order('create_time DESC')
					  ->limit('1')
                      ->queryScalar();
				if($rs != $price){//价格不相等又是审核通过的,说明是没有记录当前价格,则要增加历史记录
				    $db->createCommand()->insert('gw_goods_price',array('goods_id'=>$goods_id,'price'=>$price,'create_time'=>time()));
				}
				return $status;
			}else{//新价大于原价,则跟历史的十条价格做对比
				//价格倒序排列
				usort($data,function($a,$b){
					return $a['price'] > $b['price'] ? 0 : 1;
				});
				//如果价格大于历史最大的价格，则返回 审核中
				if($status==Goods::STATUS_PASS && $price>$data[0]['price']){
					return Goods::STATUS_AUDIT;
				}else{
					if($status == Goods::STATUS_PASS){//审核通过的,才会记录当前价格
						$db->createCommand()->insert('gw_goods_price',array('goods_id'=>$goods_id,'price'=>$price,'create_time'=>time()));
					}
					
					$gsql = "select id,seckill_seting_id from {{goods}} where id=:gid";
					$goodsData = $db->createCommand($gsql)->bindValue(':gid',$goods_id)->queryRow();
					if($goodsData['seckill_seting_id'] > 0){    //清缓存
						ActivityData:: cleanCache($goodsData['seckill_seting_id'], $goods_id);
					}
					return $status;
				}
			}
        }
    }
}
