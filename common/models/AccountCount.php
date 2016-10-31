<?php

/**
 * This is the model class for table "{{account_count}}".
 *
 * The followings are the available columns in table '{{account_count}}':
 * @property string $id
 * @property string $date
 * @property string $create_time
 * @property string $debit_sum
 * @property string $credit_sum
 * @property string $prepaid_sum
 * @property string $consume_sum
 * @property string $distribute_sum
 * @property string $remark
 * @property string $year_week
 * @property integer $week_day
 * @property string $year_month
 */
class AccountCount extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{account_count}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, date, create_time, debit_sum, credit_sum, prepaid_sum, consume_sum, distribute_sum, year_week, week_day, year_month', 'required'),
            array('week_day', 'numerical', 'integerOnly' => true),
            array('id, create_time, year_week, year_month', 'length', 'max' => 11),
            array('debit_sum, credit_sum, prepaid_sum, consume_sum, distribute_sum', 'length', 'max' => 18),
            array('remark', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date, create_time, debit_sum, credit_sum, prepaid_sum, consume_sum, distribute_sum, remark, year_week, week_day, year_month', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '主键',
            'date' => '日期',
            'create_time' => '创建时间',
            'debit_sum' => '借方总额',
            'credit_sum' => '贷方总额',
            'prepaid_sum' => '充值总额',
            'consume_sum' => '消费总额',
            'distribute_sum' => '分配总额',
            'remark' => '备注',
            'year_week' => '第几周',
            'week_day' => '星期几',
            'year_month' => '年月',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('debit_sum', $this->debit_sum, true);
        $criteria->compare('credit_sum', $this->credit_sum, true);
        $criteria->compare('prepaid_sum', $this->prepaid_sum, true);
        $criteria->compare('consume_sum', $this->consume_sum, true);
        $criteria->compare('distribute_sum', $this->distribute_sum, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('year_week', $this->year_week, true);
        $criteria->compare('week_day', $this->week_day);
        $criteria->compare('year_month', $this->year_month, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->ac;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AccountCount the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
