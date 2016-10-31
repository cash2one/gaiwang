<?php
/**
 * 地图
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class MapAgentController extends Controller{
	/**
	 * 显示地图
	 */
	public function actionShow(){
		$lng = $_GET['lng'];
		$lat = $_GET['lat'];
		$api = $_GET['api'];
		$level = $_GET['level'];
		$cityname = $_GET['cityname'];
		$this->renderPartial('showmap',array('lng'=>$lng,'lat'=>$lat,'api'=>$api,'cityname'=>$cityname,'level'=>$level));
	}
	
	/**
	 * 使用地图
	 */
	public function actionUse(){
		$lng = $_GET['lng'];
		$lat = $_GET['lat'];
		$api = $_GET['api'];
		$cityname = $_GET['cityname'];
		$this->renderPartial('usemap',array('lng'=>$lng,'lat'=>$lat,'api'=>$api,'cityname'=>$cityname));
	}
}