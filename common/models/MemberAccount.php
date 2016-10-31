<?php

/**
 * This is the model class for table "{{member_account}}".
 *
 * The followings are the available columns in table '{{member_account}}':
 * @property string $id
 * @property string $money
 * @property string $valid_end
 * @property string $member_id
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class MemberAccount extends CActiveRecord
{
    const VALID_TIME = 2592000 ;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member_account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('money, valid_end, member_id', 'required'),
//			array('money', 'length', 'max'=>15), //取消长度验证
			array('valid_end, member_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, money, valid_end, member_id', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'money' => 'Money',
			'valid_end' => 'Valid End',
			'member_id' => 'Member',
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
		$criteria->compare('money',$this->money,true);
		$criteria->compare('valid_end',$this->valid_end,true);
		$criteria->compare('member_id',$this->member_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 往会员红包金额帐户 加金额
     * @param $money
     * @param $member_id
     * @return bool
     * @throws Exception
     */

    public  static function  addHongBaoMoney($money,$member_id){
        $model = self::model()->findByAttributes(array(),'member_id=:member_id',array(':member_id'=>$member_id));
        if($model){
            $model -> money += $money;
        }else{
            $model = new MemberAccount();
            $model -> member_id = $member_id;
            $model -> money = $money;
        }
//        $model -> valid_end = strtotime(date('Y-m-d')) + self::VALID_TIME;
		$model -> valid_end = time() + self::VALID_TIME;
        if($model ->save()){
            return true;
        }else{
            throw new Exception(Yii::t("MemberAccount", '从帐户金额管理 加 金额失败'));
            return false;
        }
    }

    /**
     * 从会员红包金额帐户 减金额
     * @param $money
     * @param $member_id
     * @return bool
     * @throws CDbException
     * @throws Exception
     */
    public  static function  subtractMoney($money,$member_id){
        $model = MemberAccount::model()->find(array('select'=>'id,money,valid_end','condition'=>'member_id=:member_id','params'=>array(':member_id' => $member_id)));
        if($model){
            if($model->money > 0 && $model->valid_end <= strtotime(date('Y-m-d'))){
                $model->money = 0; //过期清零
                $model->save(true,array('money'));
            }
            //判断是否够扣
            if($model->money >= $money){
                $model->money -= $money;
                if(!$model->save(true,array('money'))) {
                    throw new Exception(Yii::t('orderFlow', '减红包使用金额失败'));
                    return false;
                }
                return true;
            }else{
                throw new Exception(Yii::t('orderFlow', '减红包使用金额失败'));
                return false;
            }
        }else {
            throw new Exception(Yii::t('orderFlow', '减红包使用金额失败'));
            return false;
        }
    }

}
