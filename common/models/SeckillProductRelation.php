<?php
/**
 * 参与活动的货物关联表
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/5/4
 * Time: 16:11
 */

class SeckillProductRelation extends CActiveRecord{
  const STATUS_AUDIT = 0;//活动审核中
  const STATUS_PASS = 1;//活动审核通过
  const STATUS_NOPASS = 2;//活动审核不通过
  
  public $content;//不通过的原因
  public $exportLimit=500;
  public $isExport;
  
  public static function model($className = __CLASS__){
    return parent::model($className);
}

public function tableName(){
    return "{{seckill_product_relation}}";
}
    
    public function rules()
    {
        return array(
            array('status,product_name,product_id,seller_name,g_category_id,price,end_price,name,category_id,date_start,date_end,true_category_id','safe','on'=>'search'),
        );
    }
    
//    public function attributeNames()
//    {
//        $colunm = parent::attributeNames();
//        var_dump($colunm);
//        return array_merge($colunm,array('date_start'));
//    }
    
    public function attributeLabels()
    {
        return array(
            'product_id' => Yii::t('seckillProductRelation', '商品ID'),
            'product_name' => Yii::t('seckillProductRelation', '商品名称'),
            'seller_name' => Yii::t('seckillProductRelation', '所属商家'),
            'g_category_id' => Yii::t('seckillProductRelation', '商家分类'),
            'price' => Yii::t('seckillProductRelation', '零售价'),
            'name' => Yii::t('seckillProductRelation', '活动名称'),
            'category_id' => Yii::t('seckillProductRelation', '活动类型'),
            'date_start' => Yii::t('seckillProductRelation', '活动开始日期'),
            'status' => Yii::t('seckillProductRelation', '活动审核'),
        );
    }

public static function getCount($seting_id){
    $result = Yii::app()->db->createCommand()->select("count(id) as counts")
    ->where('rules_seting_id=:rules_seting_id and status=1',array('rules_seting_id'=>$seting_id))
    ->from("{{seckill_product_relation}}")->queryRow();
    return $result['counts'];
}


    /**
     * 参加和修改参加活动
     * @param $obj
     * @return int
     */
    public static function saveData($obj){
        $one = self::getOne($obj['product_id']);
        $data['status'] = 0;
        $data['category_id'] = $obj['category_id'];
        $data['rules_seting_id'] = $obj['rules_seting_id'];
        $data['seller_id'] = $obj['seller_id'];
        $data['product_name'] = $obj['product_name'];
        $data['product_category'] = $obj['product_category'];
        if(empty($one)){    //  判断为数据为空，插入数据
            $store = Yii::app()->db->createCommand("select name from {{store}} where id={$obj['store_id']}")->limit("0,1")->queryRow();
            $data['seller_name'] = $store['name'];
            $data['product_id'] = $obj['product_id'];
            return Yii::app()->db->createCommand()->insert("{{seckill_product_relation}}",$data);
        }else{
            return Yii::app()->db->createCommand()->update("{{seckill_product_relation}}",$data,'product_id=:product_id',array(':product_id'=>$obj['product_id']));
        }
         //ActivityData::cleanCache($data['rules_seting_id'],$obj['product_id']);
    }

    /**
     * 删除关联表数据，表示不参加活动
     * @param $product_id
     * @param $rules_seting_id
     * @return bool|int
     */
    public static function deleteData($product_id,$seting_id){
        $find = self::getOne($product_id);
        $result = false;
        if($find){
            $result = Yii::app()->db->createCommand("delete from {{seckill_product_relation}} where product_id={$product_id}")->query();
            self::delCache($product_id,$seting_id);
        }
        return $result;
    }

    /**
     * 查询一条商品活动关联表数据
     * @param $product_id
     * @param $rules_seting_id
     * @return mixed
     */
    public static function getOne($product_id){
        $sql = "select * from {{seckill_product_relation}} where product_id={$product_id} limit 0,1";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result;
    }
    /**
      * [显示商品活动审核状态]
      * @param  [int] $status [description] 活动审核状态
      * @return [type]         [description]
    */
    public static function getStatus($id,$status,$date_end,$end_time){
        $times = $date_end.' '.$end_time;
         if(time() > strtotime($times) || $id == 0){
            return '未参加活动';
        }
         if($status == self::STATUS_AUDIT){
             $string = '审核中';
          }elseif($status == self::STATUS_PASS){
              $string = '审核通过';
          }elseif ($status == self::STATUS_NOPASS) {
              $string = '审核不通过';
          }else{
              $string = '未参加活动';
          }
      return $string;
    }
public static function showStatus(){
    return  array(
        self::STATUS_AUDIT =>'审核中' ,
        self::STATUS_PASS =>'审核通过' ,
        self::STATUS_NOPASS =>'审核不通过' ,
        );
}
    /**
     * 后台修改活动参与状态
     * @param $status
     * @param $seting_id
     * @param $total
     * @param $goods_id
     * @return bool|int
     */
    public static function upStatus($status,$seting_id,$total,$goods_id){
        $succ = 0;
        if($status == 1){
            $count = self::getCount($seting_id);
            if($count < $total){
                $data = array('status'=>$status,'examine_time'=>date('Y-m-d H:i:s'));
                self::delCache($goods_id,$seting_id);

                Yii::app()->db->createCommand()->update("{{seckill_product_relation}}",$data,"product_id=:product_id",array('product_id'=>$goods_id));
                $succ = 1;
            }else{
                $succ = 2;
            }
        }else{
            $data = array('status'=>$status,'examine_time'=>date('Y-m-d H:i:s'));

            self::delCache($goods_id,$seting_id);
             Yii::app()->db->createCommand()->update("{{seckill_product_relation}}",$data,"product_id=:product_id",array('product_id'=>$goods_id));
            $succ = 2;
        }
        $seting_ids = ($succ == 1) ? $seting_id : 0;
        return  Yii::app()->db->createCommand()->update("{{seckill_grab}}",array('rules_id'=>$seting_ids),'product_id=:product_id',array(':product_id'=>$goods_id));
;
    }

    /** 清缓存
     * @param $goods_id     商品ID
     * @param $seting_id    对应活动的ID
     */
    public static function delCache($goods_id,$seting_id){
        ActivityData:: cleanCache($seting_id, $goods_id);
    }
    /**
     * 红色后台 商品列表页(活动)
     * 搜索类型
     */
    public $date_start,$date_end,$sid;
    public $gai_sell_price,$stock,$g_category_id,$g_status,$reviewer,$audit_time,$price,$end_price,$true_category_id,$sales_volume;
    public $name;
    public $up,$sort; //排序 examine_time date_end sales_volume price
    public function search(){
        $this->up = Yii::app()->request->getParam('up');
        $this->sort = Yii::app()->request->getParam('sort');
        $criteria = new CDbCriteria();
        $criteria->select = 't.id,t.seller_name,t.status,t.product_id,t.category_id,s.id as sid,t.rules_seting_id,examine_time,
                m.date_start as date_start,m.date_end as date_end,m.name,
                g.gai_sell_price,g.stock,g.reviewer,g.audit_time, g.category_id as g_category_id,g.status as g_status,g.sales_volume,g.price,g.name as product_name';
        $criteria->compare('g.seckill_seting_id', '>0');
        $criteria->compare('s.id', '>0'); //剔除已经删除的活动
        $criteria->compare('m.date_start', '>='.$this->date_start);
        $criteria->compare('m.date_end', '<='.$this->date_end);
        $criteria->compare('t.seller_name', $this->seller_name,true);
        $criteria->compare('g.price', '>=' .$this->price);
        $criteria->compare('g.price','<='.$this->end_price);
        //$criteria->compare('g.category_id', $this->g_category_id); // 搜索规则有变
        if($this->category_id)
            $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('m.name', $this->name,true);
        $criteria->compare('t.product_name', $this->product_name,true);
        $criteria->compare('t.product_id', $this->product_id);
        //Product::showNewStatus();
        //self::showAuditStatus(6934,0);
        $criteria->join = '
                            LEFT JOIN {{seckill_rules_seting}} AS s ON t.rules_seting_id = s.id
                            LEFT JOIN {{seckill_rules_main}} m ON m.id=s.rules_id
                            LEFT JOIN {{goods}} g ON g.id=t.product_id AND g.seckill_seting_id = t.rules_seting_id';
        if(!empty($this->sort) || !empty($this->up)){
            $criteria->order = "{$this->sort}  {$this->up}";
        }
        if(empty($this->g_category_id)) $this->true_category_id='';
        ///////分类搜索///////
        if($this->true_category_id){
            $categoryIds = array($this->true_category_id);
            $category = Category::findChildCategoryElement($this->true_category_id);
            if (isset($category[$this->true_category_id]['childClass'])) {
                foreach ($category[$this->true_category_id]['childClass'] as $c) {
                    array_push($categoryIds, $c['id']);
                    if (isset($c['childClass'])) {
                        foreach ($c['childClass'] as $child) {
                            array_push($categoryIds, $child['id']);
                        }
                    }
                }
            }
            $criteria->addInCondition('g.category_id', $categoryIds);
        }
        
        $pagination = array();

        if (!empty($this->isExport)) {
            //$pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        return new CActiveDataProvider($this,array(
            'criteria' => $criteria,
            'pagination'=>$pagination,
        ));
        
    }
    
    public static function showActiveAudit($product_id,$rules_seting_id){
        if(is_numeric($product_id)){
            $str = '';
            
            //查看产品是审核中
            $relation = SeckillProductRelation::model()->find(array(
                'select'=>'status,examine_time',
                'condition'=>'product_id=:pid AND rules_seting_id=:sid',
                'params'=> array(':pid'=>$product_id,':sid'=>$rules_seting_id)
            ));
//            echo $relation->status;
            if($relation){
                $active_name = Yii::app()->db->createCommand()
                        ->select('content,from_unixtime(created) as created,user_id,status')
                        ->from('{{seckill_product_audit}}')
                        ->where('goods_id=:id AND relation_id=:relation_id AND status=:status',array(':id'=>$product_id,':relation_id'=>$rules_seting_id,':status'=>$relation->status))
                        ->order('created desc')
                        ->queryRow();
               // var_dump($active_name);
                if($active_name){
                     $adminname =  User::model()->findByPk($active_name['user_id'])->username;
                     if($active_name['status'] == self::STATUS_NOPASS){
                         $str .= CHtml::tag('span',array('class'=>'red'),'不通过')."({$adminname})";
                         $str .= "<br/>(".$relation->examine_time.")";
                     } else if($active_name['status'] == self::STATUS_PASS) {
                         $str .= CHtml::tag('span',array('style'=>'color: Green'),'通过')."({$adminname})";
                         $str .= "<br/>(".$relation->examine_time.")";
                     } else {
                         $str = '审核中';
                     }
                    return $str;
                }else {
                    $str = '审核中';
                }
            }
            return $str;
        }
        return null;
    }
    
}