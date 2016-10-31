<?php

/**
 * 省份，城市，区县控制器类
 * 操作（实现省市区三级联动数据调用）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class RegionController extends Controller {

	public function actionUpdateProvince() {
		if ($this->isPost()) {
			$area_id = isset($_POST['area_id']) ? (int) $_POST['area_id'] : "9999999";
			if ($area_id) {
				$data = Region::getProvinceByAreaId($area_id);
			}
			$dropDownProvinces = "<option value=''>" . Yii::t('region', '选择省份') . "</option>";
			if (isset($data)) {
				foreach ($data as $value => $name)
					$dropDownProvinces .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
			}
//			var_dump($dropDownProvinces);die;
			$dropDownCitys = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
			$dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
			echo CJSON::encode(array(
				'dropDownProvinces' => $dropDownProvinces,
				'dropDowncitys' => $dropDownCitys,
				'dropDownCounties' => $dropDownCounties
			));
		}
	}

    public function actionUpdateCity() {
        if ($this->isPost()) {
            $province_id = isset($_POST['province_id']) ? (int) $_POST['province_id'] : "9999999";
            if ($province_id) {
                $data = Region::model()->findAll('parent_id=:pid', array(':pid' => $province_id));
                $data = CHtml::listData($data, 'id', 'name');
            }
            $dropDownCities = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
            if (isset($data)) {
                foreach ($data as $value => $name)
                    $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            echo CJSON::encode(array(
                'dropDownCities' => $dropDownCities,
                'dropDownCounties' => $dropDownCounties
            ));
        }
    }

    public function actionUpdateArea() {
        if ($this->isPost()) {
            $city_id = isset($_POST['city_id']) ? (int) $_POST['city_id'] : "9999999";
            if ($city_id) {
                $data = Region::model()->findAll('parent_id=:pid', array(':pid' => $city_id));
                $data = CHtml::listData($data, 'id', 'name');
            }
            echo "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
            if ($city_id) {
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
            }
        }
    }

    /**
     * 选中拥有权限的省、市、区
     */
    public function actionGetRegionByParentId(){
    	if ($this->isPost()) {
	        $pid = isset($_POST['pid']) ? (int) $_POST['pid'] : "9999999";
	        $type = isset($_POST['type']) ?  $_POST['type'] : "province";
	        
	    	$agent_region = $this->getPowerAear(false);
	    	
   			$province_id = $agent_region['provinceId'] == ""?"":$agent_region['provinceId'];
   			$city_id = $agent_region['cityId'] == ""?"":$agent_region['cityId'];
   			$district_id = $agent_region['districtId'] == ""?"":$agent_region['districtId'];
	    		
   			//一开始就根据session将所有的有权限的省(无论是有省下面市或者区的权限，还是有省全部的权限)都拿出来。 所以省就不用担心了
	   		switch ($type){
	   			case 'province'://获取市
	   				if ($pid != ""){
		   				//1.如果选择的这个省本来就是在分配的省权限里面，那么不用管，直接获取省下面所有的市
	   					$provinceArr = explode(",", $province_id);
	   					if (in_array($pid, $provinceArr)){		
	   						//如果有选择的这个省的所有权限，直接获取下一级全部
	   						$data = Region::model()->findAll('parent_id=:pid', array(':pid' => $pid));
	   						$data = CHtml::listData($data, 'id', 'name');
	   					}else{									
	   						//没有这个省的全部权限，那么就需要知道，这个省下面的所有的市是不是在有权限的市里面
	   						//a.获取拥有的区对应的所有的市，然后将之与原来拥有的市的权限进行合并，这样就获取到了所有的市的权限
		   					if ($district_id != ""){
		   						$sql = "select distinct parent_id from ".Region::model()->tableName()." where id in ($district_id)";
			   					$res = Yii::app()->db->createCommand($sql)->queryAll();
			   					foreach ($res as $key=>$val){
			   						$city_id.= $city_id == ""?$val['parent_id']:",".$val['parent_id'];
			   					}
			   				}
			   				
			   				//b.获取选中的父节点下面有权限的市
		   					if ($city_id != ""){
			   					if ($pid != ""){			//这个是为了防止下拉框中选择空
				   					$data = Region::model()->findAll("parent_id=$pid and id in ($city_id)");
					                $data = CHtml::listData($data, 'id', 'name');
			   					}
			   				}
	   					}
	   				}
	   				
		            $dropDownCities = "<option value=''>" . Yii::t('region', '选择城市') . "</option>";
		            if (isset($data)) {
		                foreach ($data as $value => $name)
		                    $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
		            }
		            $dropDownCounties = "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
		            echo CJSON::encode(array(
		                'dropDownCities' => $dropDownCities,
		                'dropDownCounties' => $dropDownCounties
		            ));
		            
	   				break;
	   			case 'city'://获取区
	   				if ($pid != ""){
		   				//1.判断是不是有这个市的所有权限,如果有就直接显示下面所有的区
	   					$cityArr = explode(",", $city_id);
	   					if (in_array($pid, $cityArr)){
	   						$data = Region::model()->findAll('parent_id=:pid', array(':pid' => $pid));
			                $data = CHtml::listData($data, 'id', 'name');
	   					}else{
	   						//如有没有
	   						$provinceArr = explode(",", $province_id);
	   						//a.先判断这个市的父级是否是拥有全部权限,如果有，同上
	   						$model = Region::model()->findByPk($pid);
	   						if (in_array($model->parent_id, $provinceArr)){
		   						$data = Region::model()->findAll('parent_id=:pid', array(':pid' => $pid));
				                $data = CHtml::listData($data, 'id', 'name');
	   						}else{
	   							//如果没有，那么就只能说明，这个市实际上是拥有的某个区的上级，必须显示而已
	   							$data = Region::model()->findAll("parent_id=$pid and id in ($district_id)");
			                	$data = CHtml::listData($data, 'id', 'name');
	   						}
	   					}
	   				}
	   				
	   		 		echo "<option value=''>" . Yii::t('region', '选择区/县') . "</option>";
	   		 		if(isset($data)){
		                foreach ($data as $value => $name)
		                    echo CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
	   		 		}
	   				break;
	   		}
    	}else{
    		echo array();
    	}
    	
    }
}
