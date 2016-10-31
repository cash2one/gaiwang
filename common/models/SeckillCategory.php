<?php
/**
 * 活动类型模型
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/4/29
 * Time: 13:47
 */

class SeckillCategory extends CActiveRecord{

    //秒杀活动的类型 1红包 2应节 3秒杀
    const SECKILL_CATEGORY_ONE = 1;
    const SECKILL_CATEGORY_TWO = 2;
    const SECKILL_CATEGORY_THREE = 3;
    const SECKILL_CATEGORY_FOUR = 4;
    
    const STATUS_ABLE = 1;
    const STATUS_UNABLE = 0;

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "{{seckill_category}}";
    }

    /**
     * 获取活动类型
     * @param nit $cate_id
     * @return array
     */
    public static function getAllCategory($cate_id){
        $cateId = self::getTopParentId($cate_id);

        $sql = "SELECT c.id,c.name,rs.product_category_id
                FROM gw_seckill_rules_main rm
                LEFT JOIN gw_seckill_category c ON c.id=rm.category_id
                RIGHT JOIN gw_seckill_rules_seting rs on rm.id=rs.rules_id
                WHERE rs.status!=4 and FIND_IN_SET({$cateId}, rs.product_category_id) and now() < concat(rm.date_end,' ', rs.end_time) group by c.id";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $newResult = array();
        foreach($result as $key=>$value){
            $result_a = SeckillRulesMainSeller::getAllRules($value['id'],$cate_id);
            if(!empty($result_a)){
                $newResult[] = $value;
            }
        }
        return $newResult;
    }

    /**
     * 获取顶级分类ID
     */
    public static function getTopParentId($cate_id){
        $Data = self::getOneCate($cate_id);

        if($Data['parent_id'] != 0){
            return self::getTopParentId($Data['parent_id']);
        }else{
            return $Data['id'];
        }
    }

    /**
     * @param $id获取单个分类数据
     */
    public static function getOneCate($id){
        $result = Yii::app()->db->createCommand()->select('id,parent_id')->from("{{category}}")
            ->where("id=:id",array('id'=>$id))->queryRow();

        return $result;
    }
    /**
     * 类型
     */
    public static function getCategory(){
        $result = self::model()->findAll(
                    array(
                        'select'=>'id,name',
                        'condition'=>'status=:s',
                        'params' => array(':s'=>  self::STATUS_ABLE),
                        'limit'=> 3
                    )
                  );
        $tree = array();
        if(!empty($result)){
            foreach ($result as $r){
                $tree[$r->id] = $r->name;
            }
        }
        return $tree;
    }
}

