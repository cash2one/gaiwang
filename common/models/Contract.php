<?php

/**
 * This is the model class for table "{{contract}}".
 *
 * The followings are the available columns in table '{{contract}}':
 * @property string $id
 * @property integer $type
 * @property string $content
 * @property integer $version
 * @property integer $is_current
 * @property integer $status
 * @property integer $create_time
 */
class Contract extends CActiveRecord
{

	const CONTRACT_TYPE_AGENCY         =  1;  //代理版本
	const CONTRACT_TYPE_REGULAR_CHAIN  =  2;  //直营版本
	const CONTRACT_IS_CURRENT 		   =  1;  //使用当前模板
	const CONTRACT_NO_CURRENT 		   =  0;  //不是要当前模板
	const CONTRACT_STATUS_OK 		   =  1;  //状态正常
	const CONTRACT_STATUS_NOT_OK 	   =  2;  //状态 删除

    public static  $versionInfos;  //所有状态正常的类型及版本

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, content, is_current', 'required'),
			array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'on' => 'insert'),
			array('type, version, is_current, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, content, version, is_current, status, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' 	   => Yii::t('contract', 'ID'),
			'type' 	   => Yii::t('contract', '合同类型'),
			'content'  => Yii::t('contract', '内容'),
			'version'  => Yii::t('contract', '版本'),
			'status'   => Yii::t('contract', '状态'),

			'is_current'  => Yii::t('contract', '是否使用当前版本'),
			'create_time' => Yii::t('contract', '创建时间'),
		);
	}


	/**
	 * before validate todo...
	 */
	public function beforeValidate(){
        
        if($this->isNewRecord){
        	// $this->create_time = time();
        	$this->status = self::CONTRACT_STATUS_OK;
        } 
        return true;
    }

    public function beforeSave(){
    	$this->content = serialize($this->content);
    	return true;
    }

    public function afterFind(){
    	$this->content = stripslashes(unserialize($this->content));
    	return true;	
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('version',$this->version);
		$criteria->compare('is_current',$this->is_current);
		$criteria->compare('status',self::CONTRACT_STATUS_OK);
		$criteria->compare('create_time',$this->create_time);
		$criteria->order = 'create_time desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//获取是否使用当前模板
    public static function getCurrent($key = NULL) {
        $arrayCurrent = array(
            self::CONTRACT_IS_CURRENT => Yii::t('contract', '是'),
            self::CONTRACT_NO_CURRENT => Yii::t('contract', '否'),
        );
        return isset($key) ? $arrayCurrent[$key] : $arrayCurrent;
    }

    /**
     * 展示类型
     *
     * @param string $key 
     * @return mix array|string
     */
    public static function showType($key = NULL){
    	$arrayType = array(
            self::CONTRACT_TYPE_AGENCY => Yii::t('contract', '代理版'),
            self::CONTRACT_TYPE_REGULAR_CHAIN => Yii::t('contract', '直营版'),
        );
        return isset($key) ? $arrayType[$key] : $arrayType;
    }

    /**
     * 获取当前类型下最大版本号
     *
     * @param   string $type 类型
     * @return  number 
     */
    public static function getMaxVersionByType($type){
    	$sql = "select max(version) from ".Contract::model()->tableName()." where type = '".$type."'";
    	$res = Yii::app()->db->createCommand($sql)->queryColumn();
    	return $res[0] ? $res[0]+1 : 1;
    }

    /**
     * 设置当前类型下所有模板为 未使用状态
     *
     * @param   string $type 类型
     * @return  boolean
     */
    public static function setCurrentByType($type,$idArr=array()){
    	
    	if(empty($idArr)) return false;
    	if(is_array($idArr) && !empty($idArr)) $idWhere = ' id not in ('. implode(',', array_unique($idArr)).') ';
    	if(is_numeric($idArr)) $idWhere = ' id != '.$idArr.' ';
    	$sql = "update ".Contract::model()->tableName()." set is_current = ".self::CONTRACT_NO_CURRENT.
    			" where type = ".$type." AND ".$idWhere ;
    	$res = Yii::app()->db->createCommand($sql)->execute();
    	return $res===false ? false : true;
    }

    /**
     * 获取当前类型下状态为使用的 模板
     *
     * @param   string $type 类型
     * @return  int    $id   gw_contract.id
     */
    public static function getCurrentByType($type){
    	
    	if(empty($type)) return false;
    	$sql = "select id from  ".Contract::model()->tableName()." where type = ".$type." AND status =  ".self::CONTRACT_STATUS_OK.
    			" AND is_current = ".self::CONTRACT_IS_CURRENT." limit 1";
    	$res = Yii::app()->db->createCommand($sql)->queryRow();
    	return $res ? $res['id'] : false;
    }

    public static function showVersion($version,$type){
        
        if(!self::$versionInfos) self::$versionInfos = Contract::model()->getVersionsByStatusOk();
        if(isset(self::$versionInfos[$type.'_'.$version])) return $version;
        return '已删除';
    }

    /**
     * 获取当前状态未删除的 模板
     *
     * @return  array
     */
    public function getVersionsByStatusOk(){
        
        $sql = "select version,concat(type,'_',version) as typeVersion from  ".Contract::model()->tableName()." where  status =  ".self::CONTRACT_STATUS_OK;
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        return $res ? ArrayHelper::array_column_Ex($res,'typeVersion','version') : array();
    }

    /**
     * 删除模板，设置模板状态为 CONTRACT_STATUS_NOT_OK
     *
     * @param   number|array  $id
     * @return  boolean
     */
    public  function del($idArr=array()){
    	
    	if(empty($idArr)) return false;
    	if(is_array($idArr) && !empty($idArr)) $idWhere = ' id  in ('. implode(',', array_unique($idArr)).') ';
    	if(is_numeric($idArr)) $idWhere = ' id = '.$idArr.' ';
    	$sql = "update ".Contract::model()->tableName()." set `status` = ".self::CONTRACT_STATUS_NOT_OK." where ".$idWhere;
    	$res = Yii::app()->db->createCommand($sql)->execute();
    	return $res===false ? false : true;
    }

    /**
     * 获取协议模板Id，根据协议类型及版本号
     *
     * @param   int   $type
     * @param   int   $version
     * @return  int|boolean
     */
    public  function findPkByTypeAndVersion($type,$version){
    	
    	if(empty($type) || empty($version)) return false;
    	$res = self::model()->find('type=:type AND version=:version',array(':type'=>$type,':version'=>$version));
    	return $res ? $res->id : false;
    }

}
