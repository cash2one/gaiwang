<?php

/**
 * This is the model class for table "{{member_sign_account}}".
 *
 * The followings are the available columns in table '{{member_sign_account}}':
 * @property string $id
 * @property string $member_id
 * @property string $account_name
 * @property string $street
 * @property string $bank_name
 * @property string $account
 * @property string $identity_card
 * @property string $identity_image
 * @property string $identity_image2
 * @property integer $is_approved
 * @property integer $source
 */
class MemberSignAccount extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    
    const TYPE_SKU = 0;
    const TYPE_GAI = 1;

    public function tableName()
    {
        return '{{member_sign_account}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_id, account_name, street, bank_name, account, identity_card, identity_image, identity_image2, source', 'required'),
            array('is_approved, source', 'numerical', 'integerOnly'=>true),
            array('member_id', 'length', 'max'=>11),
            array('account_name, street, bank_name, account, identity_card, identity_image, identity_image2', 'length', 'max'=>128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, member_id, account_name, street, bank_name, account, identity_card, identity_image, identity_image2, is_approved, source', 'safe', 'on'=>'search'),
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
            'id' => '主键',
            'member_id' => '所属会员',
            'account_name' => '账户名',
            'street' => '详细地址',
            'bank_name' => '开户银行',
            'account' => '账号',
            'identity_card' => '身份证号码',
            'identity_image' => '身份证正面照片',
            'identity_image2' => '身份证反面照片',
            'is_approved' => '是否通过审核',
            'source' => '来源（0、SKU   1、盖象）',
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
        $criteria->compare('member_id',$this->member_id,true);
        $criteria->compare('account_name',$this->account_name,true);
        $criteria->compare('street',$this->street,true);
        $criteria->compare('bank_name',$this->bank_name,true);
        $criteria->compare('account',$this->account,true);
        $criteria->compare('identity_card',$this->identity_card,true);
        $criteria->compare('identity_image',$this->identity_image,true);
        $criteria->compare('identity_image2',$this->identity_image2,true);
        $criteria->compare('is_approved',$this->is_approved);
        $criteria->compare('source',$this->source);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MemberSignAccount the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}