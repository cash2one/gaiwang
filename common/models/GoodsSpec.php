<?php

/**
 *  商品规格模型
 * @author binbin.liao <277250538@qq.com>
 * The followings are the available columns in table '{{goods_spec}}':
 * @property string $id
 * @property string $goods_id
 * @property string $spec_name
 * @property string $price
 * @property string $stock
 * @property string $sale_num
 * @property string $code
 * @property string $spec_value
 */
class GoodsSpec extends CActiveRecord
{

	public $g_name;			//商品名称
	public $g_price;			//商品价格
	public $g_thumbnail;
	
	
    public function tableName()
    {
        return '{{goods_spec}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('goods_id, spec_name, price, stock, sale_num, code, spec_value', 'required'),
            array('goods_id, price, stock, sale_num', 'length', 'max' => 11),
            array('spec_name, code,g_name', 'length', 'max' => 128),
            array('id, goods_id, spec_name, price, stock, sale_num, code, spec_value,g_name,g_price,g_thumbnail', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('goodsSpec', '主键'),
            'goods_id' => Yii::t('goodsSpec', '所属商品'),
            'spec_name' => Yii::t('goodsSpec', '规格组合名'),
            'price' => Yii::t('goodsSpec', '价钱'),
            'stock' => Yii::t('goodsSpec', '库存'),
            'sale_num' => Yii::t('goodsSpec', '销量'),
            'code' => Yii::t('goodsSpec', '编号'),
            'spec_value' => Yii::t('goodsSpec', '规格组合值'),
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('goods_id', $this->goods_id, true);
        $criteria->compare('spec_name', $this->spec_name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('stock', $this->stock, true);
        $criteria->compare('sale_num', $this->sale_num, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('spec_value', $this->spec_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 根据商品与规格的索引表
     * 再去查询对应规格id的规格值,组合成新的二维数组
     * 生成数组格式  规格值名称=> 跟规格下的值
     *
     * 这是给视图里选择规格用的
     * @param array $spec_name 商品对应的哪几种规格
     * @param int $goods_id 商品id
     * @param array $spec_picture 颜色数组图片
     * @return array
     */
    public static function getSpecVal($spec_name, $goods_id, $spec_picture)
    {
        $spec = array(); //规格名称
        $typeSpec = Yii::app()->db->createCommand('select * from {{goods_spec_index}} where goods_id=:goods_id')
            ->bindParam(':goods_id', $goods_id)->queryAll();
        foreach ($spec_name as $k => $v) {
            $spec[$k]['name'] = $v;
            foreach ($typeSpec as $v2) {
                if (isset($spec_picture[$v2['spec_value_id']])) $v2['pic'] = $spec_picture[$v2['spec_value_id']];
                if ($k == $v2['spec_id']) $spec[$k]['spec_value'][] = $v2;
            }
        }
        sort($spec);
//        $spec = array(); //规格名称
//        $spVal = array(); //规格值
//        $i = 0;
//        foreach ($spec_name as $k => $v) {
//            $spec[$i]['name'] = $v;
//            $typeSpec = Yii::app()->db->createCommand()
//                            ->select()
//                            ->from('{{goods_spec_index}}')
//                            ->where('spec_id=' . $k . ' AND goods_id=' . $goods_id)->queryAll();
//            $j = 0;
//            foreach ($typeSpec as $k => $spv) {
//                $spVal[$j]['goods_id'] = $spv['goods_id'];
//                $spVal[$j]['category_id'] = $spv['category_id'];
//                $spVal[$j]['type_id'] = $spv['type_id'];
//                $spVal[$j]['spec_id'] = $spv['spec_id'];
//                $spVal[$j]['spec_value_id'] = $spv['spec_value_id'];
//                $spVal[$j]['spec_value_name'] = $spv['spec_value_name'];
//                $spec[$i]['spec_value'] = $spVal;
//                $j++;
//            }
//            $i++;
//        }

        return $spec;
    }

    /**
     * 查找指定的规格值数据,组合新的二维数组
     * @param int $id 商品id
     * @deprecated
     */
    public static function specValue($id)
    {
        $goodsSpec = Yii::app()->db->createCommand()->from('{{goods_spec}}')->where('goods_id=:id', array(':id' => $id))->queryAll();
        $i = 0;
        $goodsSpecData = array();
        foreach ($goodsSpec as $v) {
            $goodsSpecData[$i]['price'] = $v['price'];
            $goodsSpecData[$i]['stock'] = $v['stock'];
            $goodsSpecData[$i]['sale_num'] = $v['sale_num'];
            $goodsSpecData[$i]['code'] = $v['code'];
            $goodsSpecData[$i]['id'] = $v['id'];
            if ($v['spec_value']) {
                $goodsSpecData[$i]['spec_value'] = array_keys(unserialize($v['spec_value']));
                $goodsSpecData[$i]['sp_val'] = implode('', array_keys(unserialize($v['spec_value'])));
            } else {
                $goodsSpecData[$i]['spec_value'] = '';
                $goodsSpecData[$i]['sp_val'] = '';
            }

            $i++;
        }
        return $goodsSpecData;
    }

    /**
     * 查询指定规格id对应的 库存,数量 .目前只给购物车用
     * @param int $spec_id 规格id
     * @param array $fileld 要查询的字段
     */
    public static function getSpecData($spec_id, $field = array())
    {
        $field = implode(',', $field);
        $data = Yii::app()->db->createCommand()->select($field)->from('{{goods_spec}}')
            ->where('id=:spec_id', array(':spec_id' => $spec_id))->queryRow();
        return $data;
    }

    /**
     * 查询指定的规格名称和规格值,并组合成 key=>value形式
     * @param type $goodsId 商品id
     */
    public static function buildSpec($goodsId)
    {
        $model = self::model()->findByAttributes(array('goods_id' => $goodsId));
        $arr = array(); //组合后的新数组
        $specName = empty($model->spec_name) ? '' : $model->spec_name;
        $specValue = empty($model->spec_value) ? '' : $model->spec_value;
        $specName = unserialize($specName);
        $specValue = unserialize($specValue);
        if ($specValue && $specValue) {
            $arr = array_combine($specName, $specValue);
            return serialize($arr);
        } else {
            return '';
        }
    }

    /**
     * 批量添加商品规格
     * @param array $spec
     * @param string $spec_name
     * @param $price
     * @param $goodsId
     * @return bool
     * @throws exception
     * @author zhenjun_xu <412530435@qq.com>
     */
    public static function addArray(Array $spec, $spec_name, $price, $goodsId)
    {
        if (empty($spec)) return false;
        foreach ($spec as $v) {
            if (!isset($v['sp_value']) || !isset($v['stock'])) {
                throw new Exception('spec_value error');
            }
            Yii::app()->db->createCommand()->insert('{{goods_spec}}', array(
                'goods_id' => $goodsId,
                'spec_name' => $spec_name,
                'price' => empty($v['price']) || $v['price']<=0 ? $price : $v['price'], //如果规格对应的价格为空，则使用默认的商品价格
                'stock' => $v['stock'],
                'code' => $v['sku'],
                'spec_value' => serialize($v['sp_value']),
            ));
        }
        return true;
    }

    /**
     * 对字段的数据反序列化
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function afterFind()
    {
        parent::afterFind();
        if ($this->spec_name) $this->spec_name = unserialize($this->spec_name);
        if ($this->spec_value) $this->spec_value = unserialize($this->spec_value);
    }

    /**
     * 获取商品属性相关数据，并反序列化相关字段
     * @param $goodsId
     * @return array
     */
    public static function getGoodsSpec($goodsId)
    {
        $spec = WebGoodsData::getSpecData($goodsId);
        if(empty($spec)) return array();
        $spec['spec_value_array'] = array(); //保存 spec_value的值
        foreach ($spec as $k => &$v) {
            if(is_numeric($k) && !empty($v['spec_name']))
                $v['spec_name'] = unserialize($v['spec_name']);
            if (is_numeric($k) && !empty($v['spec_value'])) {
                $v['spec_value'] = unserialize($v['spec_value']);
                foreach ($v['spec_value'] as $k2 => $v2)
                    $spec['spec_value_array'][$k2] = $v2;
            }
        }
        return $spec;
    }
    
    
    /**
     * 卖家平台的商品列表
     * @param $storeId
     * @return CActiveDataProvider
     */
    public function sellerSearch($storeId) {
    	$criteria = new CDbCriteria;
    	$criteria->addCondition('g.store_id=' . $storeId . ' and g.life=' . Goods::LIFE_NO);
    	
    	$criteria->compare('g.name', $this->g_name, true);
    	
    	//零售价区间
    	$price_start = intval(Yii::app()->request->getParam('price_start'));
    	$price_end = intval(Yii::app()->request->getParam('price_end'));
    	if ($price_end > $price_start) {
    		$criteria->addBetweenCondition('t.price', $price_start, $price_end);
    	}
    	//库存区间
    	$stock_start = intval(Yii::app()->request->getParam('stock_start'));
    	$stock_end = intval(Yii::app()->request->getParam('stock_end'));
    	if ($stock_end > $stock_start) {
    		$criteria->addBetweenCondition('t.stock', $stock_start, $stock_end);
    	}
    
    	$criteria->select = 't.id,t.goods_id,g.name as g_name,g.price as g_price,t.spec_name,t.spec_value,t.price,g.thumbnail as g_thumbnail';
    	$criteria->join = ' LEFT JOIN  '.Goods::model()->tableName().' AS g ON  g.id=t.goods_id' ;
    
    	$criteria->group = ' t.id ';
    	
    	return new CActiveDataProvider($this, array(
    			'criteria' => $criteria,
    			'pagination' => array(
    					'pageSize' => 20, //分页
    			),
    			'sort' => array(
    					'defaultOrder' => 'g.id DESC ', //设置默认排序
    			),
    	));
    }
    
    /**
     * 查询指定的规格名称和规格值,并组合成 key=>value形式  
     * 输出为文本
     * @param type $goodsId 商品id
     */
    public static function buildSpecOutputStr($specName,$specValue)
    {
    	if ($specValue && $specValue) {
    		$arr = array_combine($specName, $specValue);
    		
    		$output_str = '';
    		foreach($arr as $k=>$v){
    			$output_str .= "{$k}:{$v}|";
    		}
    		
    		$output_str = substr($output_str, 0,strlen($output_str)-1);
    		
    		return $output_str;
    	} else {
    		return '';
    	}
    }

}
