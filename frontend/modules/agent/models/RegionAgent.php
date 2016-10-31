<?php

/**
 *  省份，城市，区县 模型类
 *  @author wanyun.liu <wanyun_liu@163.com>
 */
class RegionAgent extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{region}}';
    }

    
    
    /**
     * 获取代理拥有的省数据
     * @param array
     * @return array 
     */
    public static function getRegionByParentId($agent_ss) {
        if (empty($agent_ss))
            return array();
        
		$province_id = "";
		
     	foreach ($agent_ss as $key=>$val){
     		$arr = explode('|', $val['tree']);
     		if (isset($arr[1])){
	     		$province_id.= $province_id == ""?$arr[1]:",".$arr[1];
     		}
        }
       
        if ($province_id == ""){
        	$models = self::model()->findAll('parent_id = :parent_id',array(':parent_id' => Region::PROVINCE_PARENT_ID));
        }else{
        	$models = self::model()->findAll("id in ($province_id)");
        }
        
        $cityArr = array();
        foreach ($models as $v) {
            $cityArr[$v->id] = Yii::t('region', $v->name);
        }
        return $cityArr;
    }
    
    /**
     * 地区翻译
     */
    public static function getRegionProvince(){
        $models = self::model()->findAll("parent_id=:pid", array(':pid' => 1));
        $cityArr = array();
        foreach ($models as $v) {
            $cityArr[$v->id] = Yii::t('region', $v->name);
        }
        return $cityArr;
    }
}
