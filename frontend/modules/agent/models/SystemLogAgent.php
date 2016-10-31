<?php
/**
 * @author huabin_hong
 */
class SystemLogAgent extends ActiveRecord{
	const LINE_BREAK = '|%*!!*%|';		//换行符
		
	const Login_Success = 1;			//用户登录成功
	const Login_Fauled = 2;				//用户登录失败
	const AdminUser = 3;				//管理员管理
	const Advert = 4;					//广告管理
	const Machine = 5;					//盖机管理
	const Statics = 6;					//统计分析
//	const MemberICCard = 7;				//会员卡管理
//	const MachineAdvertVideo = 8;		//视频排期
	const MachineProduct = 9;			//产品管理
	const MachineProductCls = 10;		//产品分类管理
	const MachineFunction = 11;			//自定义功能管理
	const ApkManage = 12;				//盖网通程序更新
	const VoteManage = 13;				//商家投票

	/**
	 * 获取日志的分类
	 * $key int
	 */
	public static function getLogCate($key = NULL){
		$data = array(
			self::Login_Success => Yii::t('SystemLog', '用户登录成功'),
			self::Login_Fauled => Yii::t('SystemLog', '用户登录失败'),
			self::AdminUser => Yii::t('SystemLog', '管理员管理'),
			self::Advert => Yii::t('SystemLog', '广告管理'),
			self::Machine => Yii::t('SystemLog', '盖机管理 '),
			self::Statics => Yii::t('SystemLog', '统计分析 '),
//			self::MemberICCard => Yii::t('SystemLog', '会员卡管理 '),
//			self::MachineAdvertVideo => Yii::t('SystemLog', '视频排期 '),
			self::MachineProduct => Yii::t('SystemLog', '产品管理 '),
			self::MachineProductCls => Yii::t('SystemLog', '产品分类管理 '),
			self::MachineFunction => Yii::t('SystemLog', '自定义功能管理 '),
			self::ApkManage => Yii::t('SystemLog', '盖网通程序更新 '),
		);
		return $key === NULL ? $data : $data[$key] ;
	}
	
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
		return '{{system_log}}';
	}
	
	const DO_NONE = 0;					//默认
	const DO_INSERT = 1;				//新增
	const DO_UPDATE = 2;				//编辑
	const DO_DELETE = 3;				//删除
	
	public static function getLogTypeText($key){
		$data = array(
			self::DO_INSERT => '添加了',
			self::DO_UPDATE => '修改了',
			self::DO_DELETE => '删除了',
		);
		return ($key==0)?'':$data[$key];
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, log_cate, log_title, log_type, create_time, source, source_id, user_id, user_name, user_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 插入日志
	 * $log_title的常用格式customer_machine修改了表Machine中的数据，操作数据ID为：67
	 * 当该字段传入格式为：{username}{type}{table}{key}时，则会自动处理
	 */
	public static function saveSystemLog($log_cate, $log_title, $log_type = null, $operateModels = null)
	{
		$model = new SystemLogAgent();
		$model->log_cate = $log_cate;
		$model->log_title = "(代理)".$log_title;
		
		if($operateModels !== null)
		{
			if(is_array($operateModels))
			{
				$model->source = $operateModels[0]->tableName();
				$source_ids = array();
				foreach($operateModels as $operateModel)
				{
					$source_ids[] = isset($operateModel->primaryKey)?$operateModel->primaryKey:$operateModel->log_source_id;
				}
				$model->source_id = implode(',', $source_ids);
				$model->log_title = str_replace(array('{username}','{type}','{table}','{key}'),array(Yii::app()->user->name,self::getLogTypeText($log_type),'表'.$model->source.'中的数据','操作数据ID为：'.$model->source_id),$model->log_title);
			}
			else
			{
				$model->source = $operateModels->tableName();
				$model->source_id = isset($operateModels->primaryKey)?$operateModels->primaryKey:$operateModels->log_source_id;
				$model->log_title = str_replace(array('{username}','{type}','{table}','{key}'),array(Yii::app()->user->name,self::getLogTypeText($log_type),'表'.$model->source.'中的数据','操作数据ID为：'.$model->source_id),$model->log_title);
			}
		}
		if($log_type !== null)$model->log_type = $log_type;
		$model->create_time = time();
		$model->user_id = Yii::app()->user->id;
		$model->user_name = Yii::app()->user->name;
		$model->user_ip = Tool::getIP();
		$model->save();
	}
	
	/**
	 * 插入日志，记录详细信息
	 * @author:LC
	 */
	public static function saveSystemLogInfo($log_cate, $log_title, $log_type, $newModel, $old_attributes = null)
	{
		$model = new SystemLogAgent();
		$model->log_cate = $log_cate;
		$model->log_title = "(代理)".$log_title."。";
		$model->source = $newModel->tableName();
		$model->source_id = isset($newModel->primaryKey)?$newModel->primaryKey:$newModel->log_source_id;
		$model->log_title = str_replace(array('{username}','{type}','{table}','{key}'),array(Yii::app()->user->name,self::getLogTypeText($log_type),'表'.$model->source.'中的数据','操作数据ID为：'.$model->source_id),$model->log_title);
		if($old_attributes !== null)
		{
			$add_log_title = '';
			foreach($old_attributes as $attribute=>$oldVal)
			{
				if(isset($newModel->$attribute))
				{
					$add_log_title .= $newModel->getAttributeLabel($attribute).':'.$oldVal."->".$newModel->$attribute.';';
				}
			}
			$model->log_title .= self::LINE_BREAK.'修改的数据为：['.$add_log_title.']。';
		}
		if($log_type !== null)$model->log_type = $log_type;
		$model->create_time = time();
		$model->user_id = Yii::app()->user->id;
		$model->user_name = Yii::app()->user->name;
		$model->user_ip = Tool::getIP();
		$model->save();
	}
}
