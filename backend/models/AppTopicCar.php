<?php

/**
 * This is the model class for table "{{app_topic_car}}".
 *
 * The followings are the available columns in table '{{app_topic_car}}':
 * @property string $id
 * @property string $title
 * @property string $subtitle
 * @property string $image
 * @property string $subimage
 * @property string $content
 * @property string $subcontent
 * @property string $author
 * @property string $photographer
 * @property string $create_time
 * @property string $online_time
 * @property string $comment_counts
 * @property integer $status
 * @property string $admin_create
 * @property string $admin_update
 * @property string $update_time
 */
class AppTopicCar extends CActiveRecord
{

    //public  $main_img;
    const IS_PUBLISH_TRUE = 1;                                 //已发布
    const IS_PUBLISH_FALSE = 0;                                 //未发布


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_topic_car}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
 			array('title,online_time,subtitle,content,author,photographer,status,topic_goods_name', 'required'),
		    array('title','unique'),
			array('image','required','on'=>'create'),
 			array('status', 'numerical', 'integerOnly'=>true),
 			array('title, subtitle', 'length', 'max'=>100),
			array('topic_goods_name', 'length', 'max'=>4),
 			array('image, subimage', 'length', 'max'=>255),
			array('link', 'length', 'max'=>128),
			array('link', 'url'),
			array('status', 'CheckStatus'),
			//array('online_time', 'CheckTime'),
// 			array('author, photographer', 'length', 'max'=>50),
// 			array('create_time, online_time, admin_create, admin_update, update_time', 'length', 'max'=>11),
// 			array('comment_counts', 'length', 'max'=>5),
			//array('content,image, subcontent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('image', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024*1024*0.5, 'tooLarge' => Yii::t('partner', '文件大于500K，上传失败！请上传小于500K的文件！'), 'allowEmpty' => true, 'safe' => true),
			array('id, title, subtitle, image, subimage, content, subcontent,topic_goods_name, author, photographer, create_time, online_time, comment_counts, status, admin_create, admin_update, update_time', 'safe'),
		);
	}

    /**
     * 是否发布
     * @param null $key
     * @return array
     */
    public static function getPublish($key = null){
        $data = array(
            self::IS_PUBLISH_FALSE => Yii::t('AppTopicCar','未发布'),
            self::IS_PUBLISH_TRUE => Yii::t('AppTopicCar','发布'),
        );
        return $key === null ? $data : $data[$key];
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => '标题',
			'subtitle' => '副标题',
			'image' => '主图',
			'subimage' => '子图',
			'content' => '内容',
			'subcontent' => '附加内容',
			'link' => '链接',
			'author' => '作者',
			'photographer' => '摄影者',
			'create_time' => '创建时间',
			'online_time' => '上线时间',
            'comment' =>'查看评论',
			'comment_counts' => '评论数',
			'status' => '状态',
			'admin_create' => '创建人',
			'admin_update' => '最后编辑人',
			'update_time' => '编辑时间',
			'topic_goods_name'=>'专题商品查看名称',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('subtitle',$this->subtitle,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('subimage',$this->subimage,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('subcontent',$this->subcontent,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('photographer',$this->photographer,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('online_time',$this->online_time,true);
		$criteria->compare('comment_counts',$this->comment_counts,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('admin_create',$this->admin_create,true);
		$criteria->compare('admin_update',$this->admin_update,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('topic_goods_name',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppTopicCar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 获取专题发布数
	 */
	public  function CheckStatus($attribute,$params){
		if($this->status == AppTopicCar::IS_PUBLISH_TRUE){
			if($this->id === null){
				$count = Yii::app()->db1->createCommand()
				->select('count(id)')
				->from(AppTopicCar::model()->tableName())
				->where("status = '".AppTopicCar::IS_PUBLISH_TRUE."'")
				->queryScalar();
				if($count >= 10)$this->addError('status',"发布的专题数不可超过10个");
			}else{
				$count = Yii::app()->db1->createCommand()
				->select('count(id)')
				->from(AppTopicCar::model()->tableName())
				->where("status = '".AppTopicCar::IS_PUBLISH_TRUE."' and id <> {$this->id}")
				->queryScalar();
				if($count >= 10)$this->addError('status',"发布的专题数不可超过10个");
			}
			
		}
	} 
}
