<?php

/**
 * This is the model class for table "{{creditor}}".
 *
 * The followings are the available columns in table '{{creditor}}':
 * @property integer $id
 * @property string $cont
 * @property string $creditor_tran
 */
class Creditor extends CActiveRecord
{
    
    public $tranYuan;      //转让方积分
//    
    public $create_time; //创建时间
    public $update_time;//更新时间
    public $gai_number;//盖网会员编号


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{creditor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('creditor_tran,tranYuan', 'required'),
                        array('creditor_tran','length', 'max' => 30, 'min' => 2),
//                        array('tranYuan','numerical', 'integerOnly'=>true,'min'=>0.00,'message'=>Yii::t('home','{attribute} 需要是正数')),
                        array('tranYuan','numerical','min'=>0.00,'message'=>Yii::t('home','{attribute} 需要是正数')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cont, creditor_tran', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'cont' => 'Cont',
			'creditor_tran' => '公司名称',
                        'creditorTranAgent' => '代理人',
                       'creditor'=>'债权人',
                       'creditorAgent'=>'代理人',
                       'OriginalObligor'=>'原债务人',
                       'OriginalAgent'=>'代理人',
                       'tranYuan'=>'积分',
                       'creditorYuan'=>'积分',
                       'OriginalYuan'=>'积分'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('cont',$this->cont,true);
		$criteria->compare('creditor_tran',$this->creditor_tran,true);
                $criteria->order = 'update_time desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Creditor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSave() {
            if (parent::beforeSave()) {
                if ($this->isNewRecord) {
                    $this->create_time = time();
                    $this->update_time = time();
                    if(isset(Yii::app()->User->gw)){
                        $this->gai_number = Yii::app()->User->gw;
                    }
                } else {
                    $this->update_time = time();
                }
                return true;
            } else
                return false;
        }
}
