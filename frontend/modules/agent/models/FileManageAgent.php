<?php

/**
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 * This is the model class for table "{{file_manage}}".
 *
 * The followings are the available columns in table '{{file_manage}}':
 * @property string $id
 * @property string $name
 * @property string $filename
 * @property string $suffix
 * @property smallint $width
 * @property smallint $height
 * @property string $path
 * @property string $url
 * @property integer $classify
 * @property integer $user_id
 * @property string $create_time
 */
class FileManageAgent extends CActiveRecord
{
	const FILETYPE_ALL = "all";					//盖网机所有图片
	const FILETYPE_AD = 0;						//盖网机广告图片
	const FILETYPE_PD = 1;						//盖网机商品图片
	const FILETYPE_VEDIO = 10;					//盖网机视频
	
	const NAMERANDMIN = 1000;					//名称随机尾数最小值		使用
	const NAEMRANDMAX = 9999;					//名称随机尾数最大值		使用
	
	const FILELIMITSIZE = "2";					//上传文件最大size
	
	const FILE_UPLOAD_NAME = "Filedata";		//文件上传名称			使用
	const FILE_NAME = "cache_imgpaths";			//缓存文件名称			使用
	const VALUE_NAME = "imgfile_paths";			//缓存文件地址名称		
	
	const FILE_SEARCH_TONOW = "tonow";			//按上传时间早到晚（升序）
	const FILE_SEARCH_TOLATER = "tolater";		//按上传时间晚到早（降序）
	const File_SEARCH_MONTH = "month";			//最近一个月
	
	const FILE_BASE_PATH = "uploads";			//图片基本文件夹
	const FILE_TMP_PATH = "tmp";				//图片临时文件夹			使用
	
//	const IMGUPLOAD_HOST = "http://gt.gatewang.net";
//	const IMGUPLOAD_HOST = "http://gt.gatewang.com";						//文件上传域

//	const IMGUPLOAD_API = "http://gt.gatewang.net/api/filemanage/upload";
//	const IMGUPLOAD_API = "http://gt.gatewang.com/api/filemanage/upload";	//上传文件接口
	
	const FILE_UE_PATH = "UEditor";				//UEditor编辑器图片 
	
	/**
	 * 获取盖网机时间查询条件
	 */
	public static function getFileQueryDate(){
		return array(
			self::FILE_SEARCH_TOLATER=>Yii::t("FileManage", "按上传时间晚到早"),
			self::FILE_SEARCH_TONOW=>Yii::t("FileManage", "按上传时间早到晚"),
			self::File_SEARCH_MONTH=>Yii::t("FileManage", "最近一个月"),
		);
	}
	
	//文件错误提示
	public static function getUploadError($key){
		$uploadErrors = array(
	        0=>"没有错误,文件上传有成效",
	        1=>"上传的文件的upload_max_filesize指令在你只有超过",
	        2=>"上传的文件的超过MAX_FILE_SIZE指示那个没有被指定在HTML表单",
	        3=>"未竟的上传的文件上传",
	        4=>"没有文件被上传",
	        6=>"错过一个临时文件夹"
		);
		return $uploadErrors[$key];
	}
	
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->gt;
	}
	
	//文件类型
	public static function getFileType(){
		return array("jpg","jpeg","gif","png",'swf');
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{file_manage}}';
	}

	public function rules(){
		return array(
			array('name,filename,suffix,path,classify,create_time,height,width','safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'filename' => Yii::t('FileManage', '文件实际名称'),
			'suffix' => Yii::t('FileManage', '文件后缀名'),
			'path' => Yii::t('FileManage', '文件相对路径'),
			'classify' => Yii::t('FileManage', '文件所属分类'),
			'user_id' => Yii::t('FileManage', '上传人编号'),
			'create_time' => Yii::t('FileManage', '上传时间'),
		);
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
		
		$criteria->addCondition('classify = '.$this->classify);
		
		if($this->height!='0'&&$this->width!=0){
			$criteria->addCondition("(height = ".$this->height." and width = ".$this->width.") or (height*".$this->width." = width*".$this->height." and height<>0 and width<>0)");
		}else{
			if($this->height!='0'){
				$criteria->addCondition("height = ".$this->height);
			}
			
			if($this->width!='0'){
				$criteria->addCondition("width = ".$this->width);
			}
		}
		
		switch($this->create_time){
			case self::File_SEARCH_MONTH:
				$criteria->compare('create_time','>'.(time()-2592000),true);
				break;
			case self::FILE_SEARCH_TOLATER:		//到早期  降序
				$criteria->order = 'create_time desc';
				break;
			default:							//到现在 升序
				$criteria->order = 'create_time asc';	
		}
		
		$criteria->compare('filename',$this->filename,true);
		//$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
	}
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FileManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 保存之前的事件
	 */
	public function beforeSave(){
		if(parent::beforeSave()){
			$this->create_time = time();					//上传时间
			$this->user_id = $this->user_id==''?Yii::app()->User->id:$this->user_id;			//上传人编号
			return true;
		}
		else
			return false;
	}
}
