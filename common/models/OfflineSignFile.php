<?php

/**
 * This is the model class for table "{{offline_sign_file}}".
 *
 * The followings are the available columns in table '{{offline_sign_file}}':
 * @property string $id
 * @property string $old_file_name
 * @property string $new_file_name
 * @property string $suffix
 * @property string $path
 * @property integer $classify
 * @property integer $is_manage
 * @property integer $user_id
 * @property string $create_time
 */
class OfflineSignFile extends CActiveRecord
{

	protected static $codeArr = array(
		'1121'	=> '代理商上传网签企业信息营业执照电子版',
		'1122'	=> '代理商上传网签企业信息税务登记证电子版',
		'1123'	=> '代理商上传网签企业信息法人身份证电子版',
		'1124'	=> '代理商上传网签企业信息开户许可证电子版',
		'1125'	=> '代理商上传网签企业信息银行卡复印件电子版',
		'1126'	=> '代理商上传网签企业信息委托收款授权书电子版',
		'1127'	=> '代理商上传网签企业信息收款人身份证电子版',
		'1131'	=> '代理商上传网签店铺信息带招牌的店铺门面照片',
		'1132'	=> '代理商上传网签店铺信息店铺内部照片',
		'1133'	=> '代理商上传网签店铺信息盖机推荐者绑定申请',
		'1141'	=> '代理商上传网签信息纸质合同',
		'1142'	=> '代理商上传网签信息盖网通铺设场所及优惠约定',
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{offline_sign_file}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('old_file_name, new_file_name, suffix, path, classify, user_id, create_time', 'required'),
			array('classify, is_manage, user_id', 'numerical', 'integerOnly'=>true),
			array('old_file_name, new_file_name', 'length', 'max'=>100),
			array('suffix', 'length', 'max'=>20),
			array('path', 'length', 'max'=>200),
			array('create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, old_file_name, new_file_name, suffix, path, classify, is_manage, user_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * 返回对应表中对应字段的值
	 * @param String $deleteModel		表模型
	 * @param String $field				表字段
	 * @param int $modelId				表id
	 * @return mixed
	 * @throws CHttpException
	 */
	public static function returnFileId($deleteModel,$field,$modelId){
		$object = '$model=' . $deleteModel . '::model()->findByPk((int)' . $modelId . ');';
		eval($object);
		if ($model === null)
			throw new CHttpException(404, '异常错误');
		return $model->$field;
	}

	/**
	 * 删除文件
	 * @param String $path 要删除的文件路径
	 */
	public static function deleteFile($path){
//		UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $path);
		$filePath = Yii::getPathOfAlias('att').DS;
		if (UPLOAD_REMOTE) {
			$ftp = Yii::app()->ftp;
			$file = str_replace("\\","/",$filePath.$path);
			@$ftp->delete($file);
		} else {
			//删除文件
			@unlink($filePath.$path);
		}
	}

	/**
	 * 检验前方法 设置一些值
	 * @return bool
	 */
	protected function beforeValidate(){
		if(!parent::beforeValidate())
			return false;
		$this->create_time = time();
		$this->user_id = Yii::app()->user->id;
		preg_match('/offline\d{14}\.\S+/',$this->path,$arr);
		$this->new_file_name = isset($arr[0]) ? $arr[0] : '';
		return true;
	}

    /**
     * 根据id获取图片路径
     * @param int $id
     * @return mixed|string
     */
    public static function getPathById($id){
        if($id){
            $model = OfflineSignFile::model()->findByPk($id);
            if($model){
                $path = $model->path;
                return $path;
            }
        }
        return '';
    }

	/**
	 * 根据文件id，返回原文件名
	 * @param int $id	文件id
	 * @return CActiveRecord|mixed
	 */
	public static function getOldName($id){
		if($id){
			$model = OfflineSignFile::model()->findByPk($id);
            if($model){
                $oldName = $model->old_file_name;
                return $oldName;
            }
		}
		return '';
	}

	/**
	 * 根据文件id，返回文件url
	 * @param int $id
	 * @return string
	 */
	public static function getfileUrl($id){
		if($id){
			$model = OfflineSignFile::model()->findByPk($id);
            if($model){
                $url = ATTR_DOMAIN . '/' .$model->path;
                return $url;
            }
		}
		return '';
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
			'id' => 'ID',
			'old_file_name' => 'Old File Name',
			'new_file_name' => 'New File Name',
			'suffix' => 'Suffix',
			'path' => 'Path',
			'classify' => 'Classify',
			'is_manage' => 'Is Manage',
			'user_id' => 'User',
			'create_time' => 'Create Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('old_file_name',$this->old_file_name,true);
		$criteria->compare('new_file_name',$this->new_file_name,true);
		$criteria->compare('suffix',$this->suffix,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('classify',$this->classify);
		$criteria->compare('is_manage',$this->is_manage);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfflineSignFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
