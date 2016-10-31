<?php

/**
 * This is the model class for table "{{franchisee_groupbuy}}".
 *
 * The followings are the available columns in table '{{franchisee_groupbuy}}':
 * @property string $id
 * @property string $name
 * @property string $franchisee_groupbuy_category_id
 * @property string $thumbnail
 * @property string $sales_volume
 * @property integer $status
 * @property string $original_price
 * @property string $seller_price
 * @property string $summary
 * @property string $notice
 * @property string $content
 * @property integer $anytime_back
 * @property integer $overdue_back
 * @property integer $no_book
 * @property string $dead_time
 * @property string $create_time
 * @property string $update_time
 * @property string $total_score
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property FranchiseeGroupbuyCategory $franchiseeGroupbuyCategory
 * @property Member $member
 * @property FranchiseeGroupbuyComment[] $franchiseeGroupbuyComments
 * @property FranchiseeGroupbuyOrder[] $franchiseeGroupbuyOrders
 * @property FranchiseeGroupbuyPicture[] $franchiseeGroupbuyPictures
 * @property FranchiseeGroupbuyToFranchisee[] $franchiseeGroupbuyToFranchisees
 */
class FranchiseeGroupbuy extends CActiveRecord
{
    
        public $service;
        public $FranchiseeBrandName;
        public $FranchiseeGroupbuyCategoryName;
        public $path;//图片路径

        const STATUS_OUTLINE = 0;
        const STATUS_START = 1;
        const STATUS_END = 2;
        
        /**
        * 获取发布状态
        * @return array
        */
       public static function status() {
           return array(
               self::STATUS_OUTLINE => Yii::t('franchiseeGroupbuy', '草稿'),
               self::STATUS_START => Yii::t('franchiseeGroupbuy', '上线'),
               self::STATUS_END => Yii::t('franchiseeGroupbuy', '结束')
           );
       }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_groupbuy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('name, original_price, seller_price,stock,summary, notice, content,franchisee_groupbuy_category_id,franchisee_brand_id,status','required'),
                    array('anytime_back, overdue_back, no_book','required','message'=>'特色服务不可为空白'),
//                    array('status, anytime_back, overdue_back, no_book', 'numerical', 'integerOnly'=>true),
                    array('name,thumbnail', 'length', 'max'=>128),
                    array('summary', 'length', 'max' => 256),
                    array('seller_price','checkPrice'),
                    array('thumbnail', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => '上传图片最大不能超过1Mb,请重新上传'),
                    array('thumbnail, summary, notice, content','safe'),
                    array('franchisee_groupbuy_category_id, sales_volume, dead_time, create_time, update_time, total_score, comments, franchisee_brand_id,stock', 'length', 'max'=>11),
                    array('id, name, franchisee_groupbuy_category_id, thumbnail, sales_volume, status, original_price,  summary, notice, content, anytime_back, overdue_back, no_book, dead_time, create_time, update_time, total_score, comments,  franchisee_brand_id, stock', 'safe', 'on'=>'search'),
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
                'franchiseeGroupbuyCategory' => array(self::BELONGS_TO, 'FranchiseeGroupbuyCategory', 'franchisee_groupbuy_category_id'),
                'franchiseeBrand' => array(self::BELONGS_TO, 'FranchiseeBrand', 'franchisee_brand_id'),
                'franchiseeGroupbuyComments' => array(self::HAS_MANY, 'FranchiseeGroupbuyComment', 'franchisee_groupbuy_id'),
                'franchiseeGroupbuyOrders' => array(self::HAS_MANY, 'FranchiseeGroupbuyOrder', 'franchisee_groupbuy_id'),
                'franchiseeGroupbuyPictures' => array(self::HAS_MANY, 'FranchiseeGroupbuyPicture', 'franchisee_groupbuy_id'),
                'franchiseeGroupbuyToFranchisees' => array(self::HAS_MANY, 'FranchiseeGroupbuyToFranchisee', 'franchisee_groupbuy_id'),
            );
	}
        
        public function checkPrice($attribute, $params)
        {
            if($this->original_price < $this->seller_price)
                $this->addError($attribute, Yii::t('franchiseeGroupbuy', '售价不能超过原价'));
        }

        /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id' => 'ID',
                    'name' => Yii::t('franchiseeGroupbuy', '团购名称'),
                    'franchisee_groupbuy_category_id' => Yii::t('franchiseeGroupbuy', '所属分类'),
                    'thumbnail' => Yii::t('franchiseeGroupbuy', '代表图片'),
                    'sales_volume' => Yii::t('franchiseeGroupbuy', '销售数'),
                    'status' => Yii::t('franchiseeGroupbuy', '状态'),
                    'original_price' => Yii::t('franchiseeGroupbuy', '原价'),
                    'seller_price' => Yii::t('franchiseeGroupbuy', '售价'),
                    'summary' => Yii::t('franchiseeGroupbuy', '简介'),
                    'notice' => Yii::t('franchiseeGroupbuy', '团购须知'),
                    'content' => Yii::t('franchiseeGroupbuy', '详情'),
                    'anytime_back' => Yii::t('franchiseeGroupbuy', '随时退'),
                    'overdue_back' => Yii::t('franchiseeGroupbuy', '过期退'),
                    'no_book' => Yii::t('franchiseeGroupbuy', '免预约'),
                    'dead_time' => Yii::t('franchiseeGroupbuy', '到期时间'),
                    'create_time' => Yii::t('franchiseeGroupbuy', '创建时间'),
                    'update_time' => Yii::t('franchiseeGroupbuy', '更新时间'),
                    'total_score' => Yii::t('franchiseeGroupbuy', '总评分'),
                    'comments' => Yii::t('franchiseeGroupbuy', '评论数'),
                    'service' => Yii::t('franchiseeGroupbuy', '特色服务'),
                    'franchisee_brand_id' => Yii::t('franchiseeGroupbuy', '所属团购品牌'),
                    'stock' => Yii::t('franchiseeGroupbuy', '库存'),
                    'path'=>Yii::t('franchiseeGroupbuy','图片列表'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('franchisee_groupbuy_category_id',$this->franchisee_groupbuy_category_id,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);
		$criteria->compare('sales_volume',$this->sales_volume,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('original_price',$this->original_price,true);
		$criteria->compare('seller_price',$this->seller_price,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('notice',$this->notice,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('anytime_back',$this->anytime_back);
		$criteria->compare('overdue_back',$this->overdue_back);
		$criteria->compare('no_book',$this->no_book);
		$criteria->compare('dead_time',$this->dead_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('total_score',$this->total_score,true);
		$criteria->compare('comments',$this->comments,true);
                $criteria->compare('franchisee_brand_id',$this->franchisee_brand_id,true);
		$criteria->compare('stock',$this->stock,true);                

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 'id DESC',
                    ),
		));
	}
        
        /**
        * 删除后的操作
        * 删除当前广告位下的的广告图片
        */
       protected function afterDelete() {
           parent::afterDelete();
           if (isset($this->thumbnail))
               UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $this->thumbnail);
       }
      
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGroupbuy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function showStatus($status) {
            switch ($status) {
                case self::STATUS_OUTLINE:
                    $status = Yii::t('franchiseeGroupbuy', '草稿');

                    break;
                case self::STATUS_START:
                    $status = Yii::t('franchiseeGroupbuy', '上线');
                    break;
                default:
                    $status = Yii::t('franchiseeGroupbuy', '结束');
                    break;
            }
            return $status;
        }
        
        //设置时间戳
        public function behaviors()  
        {  
            return array(  
                'CTimestampBehavior'=>array(  
                    'class' => 'zii.behaviors.CTimestampBehavior',                        
                    'createAttribute' => 'create_time',
                    'updateAttribute' => 'update_time',
                )  
            );  
        }  
}
