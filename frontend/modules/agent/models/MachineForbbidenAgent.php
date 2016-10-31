<?php

/**
 * This is the model class for table "{{machine_forbbiden}}".
 *
 * The followings are the available columns in table '{{machine_forbbiden}}':
 * @property integer $machine_id
 * @property string $action_type
 */
class MachineForbbidenAgent extends ActiveRecord
{
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_forbbiden}}';
	}

/**
	 * 获取所有的API接口
	 */
	public static function getApi($key = null){
		$arr = array(
			//广告接口
//			'advert/getCouponType' => Yii::t('MachineForbbidenAgent', '优惠券/商品分类'),
//			'advert/getCouponList' => Yii::t('MachineForbbidenAgent', '优惠券/商品列表'),
//			'advert/sendCheckCode' => Yii::t('MachineForbbidenAgent', '发送验证码'),
//			'advert/sendCouponCode' => Yii::t('MachineForbbidenAgent', '发送优惠卷'),
//			'advert/getMainAd' => Yii::t('MachineForbbidenAgent', '首页轮播'),
//			'advert/addClickCnt' => Yii::t('MachineForbbidenAgent', '优惠劵点击+1'),
		
			//文件接口
//			'file/getImage' => Yii::t('MachineForbbidenAgent', '下载图片'),
		
			//盖机接口
//			'machine/regi' => Yii::t('MachineForbbidenAgent', '初次安装'),
//			'machine/setPwd' => Yii::t('MachineForbbidenAgent', '修改密码'),
//			'machine/getLonLat' => Yii::t('MachineForbbidenAgent', '城市通'),
//			'machine/update' => Yii::t('MachineForbbidenAgent', '在线升级'),
//			'machine/keepconn' => Yii::t('MachineForbbidenAgent', '心跳'),

			//会员接口
			'member/regi' => Yii::t('MachineForbbidenAgent', '用户注册'),
			'member/signin' => Yii::t('MachineForbbidenAgent', '签到'),

			//积分接口
//			'point/consume' => Yii::t('MachineForbbidenAgent', '积分消费'),
			'point/add' => Yii::t('MachineForbbidenAgent', '积分增值'),
			'point/search' => Yii::t('MachineForbbidenAgent', '积分查询'),
		
			//产品接口
//			'product/info' => Yii::t('MachineForbbidenAgent', '商品详细'),
//			'product/buy' => Yii::t('MachineForbbidenAgent', '购买商品'),
		
			//区域接口
//			'region/getProvince' => Yii::t('MachineForbbidenAgent', '省列表'),
//			'region/getCity' => Yii::t('MachineForbbidenAgent', '市列表'),
//			'region/getDistrict' => Yii::t('MachineForbbidenAgent', '区（县）列表'),
		
			//视频接口
//			'video/getVideoUrl' => Yii::t('MachineForbbidenAgent', '视频广告'),
//			'video/getUrl' => Yii::t('MachineForbbidenAgent', '视频下载'),
//			'video/localID' => Yii::t('MachineForbbidenAgent', '本地视频管理'),
		
			//投票接口
//			'vote/search' => Yii::t('MachineForbbidenAgent', '投票查询'),
//			'vote/detail' => Yii::t('MachineForbbidenAgent', '投票详细'),
//			'vote/byID' => Yii::t('MachineForbbidenAgent', '投票'),
		);
		return $key === null ? $arr : $arr[$key];
	}
	
	/**
	 * 获取所有API接口值
	 */
	public static function getApiVal(){
		$arr = self::getApi();
	 	$apival_arr = array();
        foreach ($arr as $key=>$val){
        	$apival_arr[] = $key; 
        }
        return $apival_arr; 
	}
	
	/**
	 * 返回需要禁用的API接口值
	 * @param $choose_api 选中的接口值
	 */
	public static function getForbbidenApi($choose_api){
		$base_api_arr = self::getApiVal();
 		if (!empty($choose_api)){
			$forbbiden_api = array_diff($base_api_arr,$choose_api);
		}else{
			$forbbiden_api = $base_api_arr;
		}
		return $forbbiden_api;
	}
	
	/**
	 * 返回没有禁用的API接口值
	 * @param $machine_id 盖机编号
	 */
	public static function getNoForbbidenApi($machine_id){
		$forbbidenApi = self::getMachineApi($machine_id);
		$base_api_arr = self::getApiVal();
		$choose_api = array_diff($base_api_arr,$forbbidenApi);
		return $choose_api;
	}
	
	/**
	 * 获取盖机所禁用的API
	 * @param $machine_id 盖机编号
	 */
	public static function getMachineApi($machine_id){
		$models = self::model()->findAll("machine_id = $machine_id");
		$Api = array();
		foreach ($models as $row){
			$Api[] = $row->action_type;
		}
		return $Api;
	}
	
	/**
	 * 获取禁用提示
	 */
	public static function getForbbidenNotice($key){
		$arr = array(
			//广告接口
//			'advert/getCouponType' => Yii::t('MachineForbbidenAgent', '优惠券/商品分类'),
//			'advert/getCouponList' => Yii::t('MachineForbbidenAgent', '优惠券/商品列表'),
			'advert/sendCheckCode' => Yii::t('MachineForbbidenAgent', '发送验证码功能已被禁用，无法成功发送'),
			'advert/sendCouponCode' => Yii::t('MachineForbbidenAgent', '发送优惠卷功能已被禁用，无法成功发送'),
//			'advert/getMainAd' => Yii::t('MachineForbbidenAgent', '首页轮播'),
//			'advert/addClickCnt' => Yii::t('MachineForbbidenAgent', '优惠劵点击+1'),
		
			//文件接口
//			'file/getImage' => Yii::t('MachineForbbidenAgent', '下载图片'),
		
			//盖机接口
//			'machine/regi' => Yii::t('MachineForbbidenAgent', '初次安装'),
//			'machine/setPwd' => Yii::t('MachineForbbidenAgent', '修改密码'),
//			'machine/getLonLat' => Yii::t('MachineForbbidenAgent', '城市通'),
//			'machine/update' => Yii::t('MachineForbbidenAgent', '在线升级'),
//			'machine/keepconn' => Yii::t('MachineForbbidenAgent', '心跳'),

			//会员接口
			'member/regi' => Yii::t('MachineForbbidenAgent', '注册功能已被禁用，无法成功注册'),
			'member/login' => Yii::t('MachineForbbidenAgent', '签到功能已被禁用，无法成功签到'),

			//积分接口
			'point/consume' => Yii::t('MachineForbbidenAgent', '消费功能已被禁用，无法成功消费'),
			'point/add' => Yii::t('MachineForbbidenAgent', '积分增值功能已被禁用，无法成功充值'),
			'point/search' => Yii::t('MachineForbbidenAgent', '积分查询功能已被禁用，无法成功查询'),
		
			//产品接口
//			'product/info' => Yii::t('MachineForbbidenAgent', '商品详细'),
//			'product/buy' => Yii::t('MachineForbbidenAgent', '购买商品'),
		
			//区域接口
//			'region/getProvince' => Yii::t('MachineForbbidenAgent', '省列表'),
//			'region/getCity' => Yii::t('MachineForbbidenAgent', '市列表'),
//			'region/getDistrict' => Yii::t('MachineForbbidenAgent', '区（县）列表'),
		
			//视频接口
//			'video/getVideoUrl' => Yii::t('MachineForbbidenAgent', '视频广告'),
//			'video/getUrl' => Yii::t('MachineForbbidenAgent', '视频下载'),
//			'video/localID' => Yii::t('MachineForbbidenAgent', '本地视频管理'),
		
			//投票接口
//			'vote/search' => Yii::t('MachineForbbidenAgent', '投票查询'),
//			'vote/detail' => Yii::t('MachineForbbidenAgent', '投票详细'),
//			'vote/byID' => Yii::t('MachineForbbidenAgent', '投票'),
		);
		return $arr[$key];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineForbbidenAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
