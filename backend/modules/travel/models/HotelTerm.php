<?php

/**
 * This is the model class for table "{{hotel_term}}".
 *
 * The followings are the available columns in table '{{hotel_term}}':
 * @property string $id
 * @property integer $rateplan_id
 * @property string $time
 * @property string $term_content
 * @property string $room_num
 * @property string $bind_start_date
 * @property string $bind_end_date
 * @property string $term_type
 * @property string $term_name
 * @property string $days
 * @property string $book_start_date
 * @property string $book_end_date
 * @property string $need_assure
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class HotelTerm extends CActiveRecord
{
    //入住条款
    const TERM_LIAN_XU_RU_ZHU = 11; //表示连住多少天
    const TERM_BI_ZHU = 12; //表示必住多少天
    const TERM_XIAN_ZHU = 13; //表示限住多少天
    //预定条款
    const TERM_TI_QIAN_YU_DING = 21; //提前多少天预定
    //取消条款
    const TERM_CANCEL_NO = 31; //表示已经确认不可取消
    const TERM_CANCEL_YES = 32; //表示提前几天取消
    //间数条款
    const TERM_ORDER_NUM = 4; //预定多少间以上

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{hotel_term}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rateplan_id, time, term_content, room_num, term_type, term_name, days, need_assure, created_at', 'required'),
            array('rateplan_id, room_num,days', 'numerical', 'integerOnly' => true),
            array('time, room_num, term_type, days, need_assure, creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('bind_start_date, bind_end_date, term_name, book_start_date, book_end_date', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, rateplan_id, time, term_content, room_num, bind_start_date, bind_end_date, term_type, term_name, days, book_start_date, book_end_date, need_assure, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'rateplan_id' => '介格计划ID',
            'time' => '时间',
            'term_content' => '条款内容',
            'room_num' => '房间数量',
            'bind_start_date' => '条款开始日期',
            'bind_end_date' => '条款结束日期',
            'term_type' => '条款类型',
            'term_name' => '条款名称',
            'days' => '天数',
            'book_start_date' => '预定开始日期',
            'book_end_date' => '预定结束日期',
            'need_assure' => '是否担保',
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
        $criteria->compare('rateplan_id', $this->rateplan_id);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('term_content', $this->term_content, true);
        $criteria->compare('room_num', $this->room_num, true);
        $criteria->compare('bind_start_date', $this->bind_start_date, true);
        $criteria->compare('bind_end_date', $this->bind_end_date, true);
        $criteria->compare('term_type', $this->term_type, true);
        $criteria->compare('term_name', $this->term_name, true);
        $criteria->compare('days', $this->days, true);
        $criteria->compare('book_start_date', $this->book_start_date, true);
        $criteria->compare('book_end_date', $this->book_end_date, true);
        $criteria->compare('need_assure', $this->need_assure, true);
        $criteria->compare('creater', $this->creater, true);
        $criteria->compare('updater', $this->updater, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

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
     * @return HotelTerm the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * 获取条款类型
     * @param null $key
     * @return array|string
     */
    public static function getType($key = null)
    {
        $arr = array(
            self::TERM_LIAN_XU_RU_ZHU => '连住多少天',
            self:: TERM_BI_ZHU => '必住多少天',
            self::TERM_XIAN_ZHU => '限住多少天',
            //预定条款
            self:: TERM_TI_QIAN_YU_DING => '提前多少天预定',
            //取消条款
            self::TERM_CANCEL_NO => '已经确认不可取消',
            self::TERM_CANCEL_YES => '提前几天取消',
            //间数条款
            self::TERM_ORDER_NUM => '预定多少间数',
        );
        return $key ? (isset($arr[$key]) ? $arr[$key] : '') : $arr;
    }
}
