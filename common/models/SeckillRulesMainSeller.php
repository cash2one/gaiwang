<?php
/**
 * 活动规则主表模型
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/4/29
 * Time: 14:34
 */

class SeckillRulesMainSeller extends CActiveRecord{
	public $allow_singup;

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "{{seckill_rules_main}}";
    }

    /**获取相关的所有规则
     * @param $category_id
     * @param $cate_id
     * @return array
     */
    public static function getAllRules($category_id,$cate_id){
        $new_result = array();
        $CateId = SeckillCategory::getTopParentId($cate_id);
        $sql = "select main.*,seting.product_category_id,seting.id as seting_id,seting.limit_num
                from {{seckill_rules_main}} as main
                LEFT JOIN {{seckill_rules_seting}} as seting on seting.rules_id=main.id
                where main.category_id in ({$category_id}) and FIND_IN_SET({$CateId}, seting.product_category_id) and seting.status!=4 and concat(main.date_end,' ',seting.end_time) > NOW() and seting.allow_singup=1 GROUP BY main.id";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if( $category_id == 3 ){
            $result1 = array();
            foreach($result as $key => $value){
                $child = SeckillRulesSeting::getSetingTimes($value['id'],$cate_id);
                if(!empty($child)){
                    $new_result[] = $value;
                }
            }
        }else{
            $new_result = SeckillRulesSeting::setNewList($result,'seting_id');
        }

        return $new_result;
    }

    /**获取指定的一条活动的信息
     * @param $id
     * @return array
     */
    public static function getOne($id){
        $sql = "select seting.*,main.name,main.date_start,main.date_end,main.category_id  from {{seckill_rules_main}} as main left join {{seckill_rules_seting}} as seting on seting.rules_id=main.id where main.id = {$id} limit 0,1";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result;
    }

    /**获取指定的一条活动的信息后台商品审核用
     * @author jiawei liao <569114018@qq.com>
     * @param $id
     * @return array
     */
    public static function getOneForSeckill($id=0, $product_id = 0){
        $str = '';
        if($product_id != 0) $str = "AND relation.product_id ={$product_id}";
        $sql = "select relation.status as statuss, seting.*,main.name,main.date_start,main.date_end,main.singup_start_time,main.singup_end_time from {{seckill_rules_seting}} as seting left join {{seckill_rules_main}} as main on seting.rules_id=main.id LEFT JOIN {{seckill_product_relation}} as relation ON relation.rules_seting_id = seting.id where seting.id = {$id} AND seting.status !=4 {$str} AND concat(main.date_end,' ',seting.end_time) > NOW()  limit 0,1";
        $result = Yii::app()->db->createCommand($sql)->queryRow();

        return $result;
    }
}