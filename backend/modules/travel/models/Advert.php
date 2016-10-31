<?php

/**
 * This is the model class for table "{{advert}}".
 *
 * The followings are the available columns in table '{{advert}}':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $content
 * @property integer $type
 * @property integer $status
 * @property integer $width
 * @property integer $height
 * @property string $creater
 * @property string $updater
 * @property integer $created_at
 * @property integer $updated_at
 */
class Advert extends CActiveRecord
{
    // 类型常量
    const TYPE_IMAGE = 1;
    const TYPE_SLIDE = 2;

    const STATUS_ENABLE = 1; //开启
    const STATUS_DISABLED = 0; //禁用

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{advert}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code, content, type, width, height', 'required'),
            array('creater, created_at', 'required', 'on' => 'insert'),
            array('updater, updated_at', 'required', 'on' => 'update'),
            array('type, status, created_at, updated_at, width, height', 'numerical', 'integerOnly' => true),
            array('name,code','unique'),
            array('name, code', 'length', 'max' => 128),
            array('creater, updater', 'length', 'max' => 32),
            array('content', 'length', 'max' => 256),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, content, type, status, width, height', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'name' => '名称',
            'code' => '编码',
            'content' => '说明',
            'type' => '类型',
            'status' => '状态',
            'width' => '宽度',
            'height' => '高度',
            'creater' => '创建人',
            'updater' => '更新人',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('width', $this->width);
        $criteria->compare('height', $this->height);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->tr;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Advert the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * 获取广告类型
     * @param int $key
     * @return array
     */
    public static function getAdvertType($key = null)
    {
        $type = array(
            self::TYPE_IMAGE => Yii::t('advert', '单个图片'),
            self::TYPE_SLIDE => Yii::t('advert', '多个图片'),
        );
        return $key ? (isset($type[$key]) ? $type[$key] : '') : $type;
    }


    /**
     * 获取状态
     * @param int $key
     * @return array|string
     */
    public static function getAdvertStatus($key = null)
    {
        $status = array(
            self::STATUS_ENABLE => Yii::t('advert', '启用'),
            self::STATUS_DISABLED => Yii::t('advert', '禁用')
        );
        return $key ? (isset($status[$key]) ? $status[$key] : '') : $status;
    }

    /**
     * 获取广告数量
     * @param $id
     * @return mixed
     */
    public static function getCountPicture($id)
    {
        $count = Yii::app()->tr->createCommand()
            ->select('count(id) as count')
            ->from('{{advert_picture}}')
            ->where('advert_id=:advert_id', array(':advert_id' => $id))
            ->queryScalar();
        return $count;
    }
}
