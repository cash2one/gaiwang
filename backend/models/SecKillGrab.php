<?php

/**
 * 今日必抢管理模型
 * @author_id shengjie.zhang
 *
 */
class SecKillGrab extends CActiveRecord {

    public static $menu2 = array();

    public function tableName() {
        return '{{seckill_grab}}';
    }

    public function rules() {
        return array(
            );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sort' => Yii::t('article', '编号'),
            'product_id' => '商品ID',
            'product_name' => Yii::t('article', '商品名称'),
            'seller_name' => Yii::t('article', '商家名称'),
            'product_stock' => Yii::t('article', '商品的库存'),
            'product_price' => Yii::t('article', '商品售价'),
            'market_price' => Yii::t('article', '市场售价'),
            'thumbnail' => Yii::t('thumbnail', '商品的缩略图'),
            'rules_id`' => Yii::t('article', '所属活动规则ID'),
            'rules_name' => Yii::t('article', '所属活动'),
            );
    }

    //获取今日必抢商品总数
    private function getProductNum() {
        $sql = "SELECT count(*) FROM {{seckill_grab}}";
        $num = SecKillGrab::model()->countBySql($sql);
        return $num;
    }

    /**
     * 删除必抢商品操作（同时重新排序并更新轮播表）
     * @param type $id  必抢商品的主键id
     * @return boolean
     */
    public function del($id) {
        $model = $this->findByPk($id);
        $sort = $model->sort;
        $num = self::getProductNum();
        $totalNum = $num - 1;
        $res = $model->delete();
        if ($res) {
            for ($i = $sort + 1; $i <= $num; $i++) {
                $k = $i - 1;
                $sql = " UPDATE {{seckill_grab}} SET sort = {$k} WHERE sort ={$i}";
                Yii::app()->db->createCommand($sql)->execute();
            }
            $sql = " UPDATE {{seckill_playing}} SET total_number = {$totalNum},now_number=1,dateline = now()";
            Yii::app()->db->createCommand($sql)->execute();
            return TRUE;
        }
    }
/**
 * 更新必抢商品信息（防止商品添加到必抢后商品信息更新或商品下架情况出现）
 * @param type $id  今日必抢商品主键
 * @param type $pid 商品id
 */
public function updateProduct($id, $pid) {
    $sql = "SELECT g.name product_name,
    s.name seller_name,
    g.id product_id,
    g.is_publish,
    g.status,
    g.stock product_stock,
    g.price product_price,
    g.market_price,
    g.thumbnail,
    g.seckill_seting_id rules_id 
    FROM {{goods}} g 
    LEFT JOIN {{store}} s 
    ON g.store_id=s.id 
    WHERE g.id ={$pid}";
    $return = Yii::app()->db->createCommand($sql)->queryRow();
//       当商品下架或未通过审核时，自动删除该商品
    if ($return['is_publish'] != Goods::PUBLISH_YES || $return['status'] != Goods::STATUS_PASS) {
        $this->del($id);
            // var_dump(Goods::STATUS_PASS);exit;
    }
    $msg = array();
    $msg['seller_name'] = $return['seller_name'];
    $msg['product_id'] = $return['product_id'];
    $msg['product_stock'] = $return['product_stock'];
    $msg['product_price'] = $return['product_price'];
    $msg['product_name'] = $return['product_name'];
    $msg['market_price'] = $return['market_price'];
    $msg['thumbnail'] = $return['thumbnail'];
    $msg['rules_id'] = $return['rules_id'];
    if ($return['rules_id']) {
        $ruleId = $return['rules_id'];
        $sql = "SELECT m.name name,concat(m.date_end,' ',srs.end_time) end_time,concat(m.date_start,' ',srs.start_time) start_time  
        FROM {{seckill_rules_main}} m 
        LEFT JOIN {{seckill_rules_seting}} srs ON srs.rules_id = m.id 
        WHERE srs.id={$ruleId}";
        $ruleName = Yii::app()->db->createCommand($sql)->queryRow();
        $msg['rules_name'] = isset($ruleName['name']) && strtotime($ruleName['end_time'])>time()?$ruleName['name']:'';
    }

    $result = SecKillGrab::model()->updateByPk($id, $msg);
}

public function search() {
    $criteria = new CDbCriteria;
    $criteria->compare('id', $this->id, true);
    $criteria->compare('sort', $this->sort);
    $criteria->compare('product_id', $this->product_id, true);
    $criteria->compare('product_name', $this->product_name);
    $criteria->compare('seller_name', $this->seller_name, true);
    $criteria->compare('product_stock', $this->product_stock);
    $criteria->compare('product_price', $this->product_price, true);
    $criteria->compare('market_price', $this->market_price, true);
    $criteria->compare('rules_id', $this->rules_id);
    $criteria->compare('rules_name', $this->rules_name);
    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array(
            'pageSize' => 30,
            ),
        'sort' => array(
            'defaultOrder' => 'sort ASC',
            ),
        ));
}

	/**
	* 更新前台缓存
	* 
	* @return bool
	*/
	public function updateGrabCache(){
		$date = date('Y-m-d H:i:s');
		
		//获取必抢商品内容
		$sql     = "SELECT g.*,r.status FROM {{seckill_grab}} g LEFT JOIN {{seckill_product_relation}} r ON r.product_id=g.product_id WHERE 1";
		$command = Yii::app()->db->createCommand($sql);  
		$grab    = $command->queryAll(); 
		
		//先更新轮播表
		$count = count($grab);
		$sql   = "UPDATE {{seckill_playing}} SET total_number='$count',now_number=1,dateline='$date' WHERE 1";
		Yii::app()->db->createCommand($sql)->execute();
		
		//获取轮播内容
		$sql  = "SELECT * FROM {{seckill_playing}} WHERE 1";
		$play = Yii::app()->db->createCommand($sql)->queryRow(); 
		
		$result = array(0=>array('totalNumber'=>$play['total_number'], 'nowNumber'=>$play['now_number'], 'dateline'=>$play['dateline']));
		if($grab){
          foreach($grab as $v){
            $result[$v['sort']] = array('product_id'=>$v['product_id'], 'product_name'=>$v['product_name'], 'seller_name'=>$v['seller_name'], 'product_stock'=>$v['product_stock'], 'product_price'=>$v['product_price'], 'market_price'=>$v['market_price'],'thumbnail'=>$v['thumbnail'], 'rules_id'=>$v['rules_id'], 'rules_name'=>$v['rules_name'],'status'=>$v['status']);
        }
    }
    
    Tool::cache(ActivityData::CACHE_ACTIVITY_GRAB)->set(ActivityData::CACHE_ACTIVITY_GRAB, serialize($result), 86400);
    
    return true;
}

public static function model($className = __CLASS__) {
    return parent::model($className);
}
}
