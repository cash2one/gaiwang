<?php

/**
 * This is the model class for table "{{advert_picture}}".
 *
 * The followings are the available columns in table '{{advert_picture}}':
 * @property string $id
 * @property string $advert_id
 * @property string $title
 * @property string $start_time
 * @property string $end_time
 * @property integer $sort
 * @property integer $status
 * @property string $link
 * @property string $picture
 * @property string $target
 * @property string $background
 * @property string $creater
 * @property string $updater
 * @property integer $created_at
 * @property integer $updated_at
 */
class AdvertPicture extends CActiveRecord
{
    const STATUS_ENABLE = 1;    // 状态开启
    const STATUS_DISABLED = 0;  // 状态禁用

    const TARGET_BLANK = '_blank';
    const TARGET_SELF = '_self';

    public $advertType; // 广告类型


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{advert_picture}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('advert_id, title, start_time, link', 'required'),
            array('picture, creater, created_at', 'required' , 'on' => 'insert'),
            array('updater, updated_at', 'required', 'on' => 'update'),
            array('sort, status', 'numerical', 'integerOnly' => true),
            array('advert_id, start_time, end_time, created_at, updated_at', 'length', 'max' => 11),
            array('title, link, picture', 'length', 'max' => 128),
            array('start_time', 'validateStartTime'),
            array('target', 'length', 'max' => 16),
            array('background', 'length', 'max' => 56),
            array('creater, updater', 'length', 'max' => 32),
            array('picture', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('advertPicture', Yii::t('advertPicture', '图片 最大不超过1MB，请重新上传!'))),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, advert_id, title, start_time, end_time, sort, status, link, picture, target, background', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 验证开始时间
     * @param $attribute
     * @param $params
     */
    public function validateStartTime($attribute, $params) {
        if ($this->start_time <= time()) {
            $this->addError($attribute, "开始时间必须大于现在时间");
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'advert' => array(self::BELONGS_TO, 'Advert', 'advert_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'advert_id' => '所属广告位',
            'title' => '标题',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'sort' => '排序',
            'status' => '状态',
            'link' => '链接',
            'picture' => '图片',
            'target' => '打开方式',
            'background' => '背景颜色',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('advert_id', $this->advert_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('end_time', $this->end_time, true);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('status', $this->status);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('picture', $this->picture, true);
        $criteria->compare('target', $this->target, true);
        $criteria->compare('background', $this->background, true);

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
     * @return AdvertPicture the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * 获取状态
     * @param int $key
     * @return array|string
     */
    public static function getStatus($key = null)
    {
        $status = array(
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLED => '禁用',
        );
        return $key ? (isset($status[$key]) ? $status[$key] : '') : $status;
    }

    /**
     * 获取_target 类型
     * @param  int $key
     * @return mixed
     */
    public static function getTarget($key = null)
    {
        $target = array(
            self::TARGET_BLANK => '新窗口',
            self::TARGET_SELF => '本窗口',
        );
        return $key ? (isset($target[$key]) ? $target[$key] : '') : $target;
    }
}
