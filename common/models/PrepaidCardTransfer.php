<?php

/**
 * This is the model class for table "{{prepaid_card_transfer}}".
 *
 * The followings are the available columns in table '{{prepaid_card_transfer}}':
 * @property string $id
 * @property string $card_id
 * @property string $card_number
 * @property string $value
 * @property string $money
 * @property string $transfer_member_id
 * @property string $receiver_member_id
 * @property integer $status
 * @property string $remark
 * @property string $author_ip
 * @property string $author_id
 * @property string $author_name
 * @property string $auditor_ip
 * @property string $auditor_id
 * @property string $auditor_name
 * @property string $create_time
 * @property string $audit_time
 */
class PrepaidCardTransfer extends CActiveRecord
{
    const STATUS_APPLY = 0; //申请中
    const STATUS_YES = 1;//审核通过
    const STATUS_NO = 2;//审核不通过

    public $transfer_gw = null;
    public $receiver_gw = null;
    public $history_money = null;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{prepaid_card_transfer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('receiver_gw,', 'required'),
            array('card_number','required','on'=>'insert'),
            array('transfer_gw,value','required','on'=>'createTransfer'),
            array('value','compare','operator'=>'>','compareValue'=>'0','message'=>Yii::t('PrepaidCardTransfer', '积分必须大于0'),'on'=>'createTransfer'),
            array('value','match','pattern'=>'/^[0-9]+$|^[0-9]+\.[0-9]{1}$|^[0-9]+\.[0-9]{2}$/','message'=>'请输入正确的积分，最多两位小数！','on'=>'createTransfer'),
            array('status,card_number', 'numerical', 'integerOnly'=>true),
			array('card_id, author_name, auditor_name', 'length', 'max'=>128),
            array('card_number','checkCard'),
            array('remark','length','max'=>256),
            array('transfer_gw, receiver_gw','match','pattern'=>'/^GW[0-9]{8}$/','message'=>'请输入正确的GW号！'),
            array('transfer_gw','checkTransferGW'),
            array('receiver_gw','checkReceiverGw'),
			array('value', 'length', 'max'=>12,'on'=>'createTransfer'),
			array('money, transfer_member_id, receiver_member_id, author_ip, author_id, auditor_ip, auditor_id, create_time, audit_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, card_id, card_number, value, money, transfer_member_id, receiver_member_id, transfer_gw, receiver_gw, status, remark, author_ip, author_id, author_name, auditor_ip, auditor_id, auditor_name, create_time, audit_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'transfer' => array(self::BELONGS_TO, 'Member', 'transfer_member_id'),
            'receiver' => array(self::BELONGS_TO, 'Member', 'receiver_member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'card_id' => '充值卡号id',
			'card_number' => '充值卡号',
			'value' => '积分',
			'money' => '金额',
			'transfer_member_id' => '转账人的ID',
			'receiver_member_id' => '接收人的ID',
			'status' => '状态',
			'remark' => '备注',
			'author_ip' => '创建者IP',
			'author_id' => '创建者',
			'author_name' => '创建者名称',
			'auditor_ip' => '审核者IP',
			'auditor_id' => '审核者',
			'auditor_name' => '审核者名称',
			'create_time' => '创建时间',
			'audit_time' => '审核时间',
            'transfer_gw' => '转账人GW号',
            'receiver_gw' => '接收人GW号',
		);
	}

    /**
     * 检查充值卡
     * @param $attribute
     * @param $params
     */
    public function checkCard($attribute, $params){
        if ($this->card_number) {
            $model = PrepaidCard::model()->find('number=:number and status=:status and type=:type', array(':number' => $this->card_number, ':status' => PrepaidCard::STATUS_USED, ':type' => PrepaidCard::TYPE_SPECIAL));
            if ($model){
                $model_transfer =PrepaidCardTransfer::model()->find('card_number=:card_number and status=:status',array(':card_number'=>$this->card_number,':status'=>PrepaidCardTransfer::STATUS_APPLY));
                if($model_transfer){
                    $this->addError($attribute, Yii::t('PrepaidCardTransfer', '此充值卡已申请，请先审核后再申请！'));
                }else {
                    $this->card_id = $model->id;
                    $this->value = $model->value;
                    $this->money = $model->money;
                    $this->transfer_member_id = $model->member_id;
                }
            }
            else
                $this->addError($attribute, Yii::t('PrepaidCardTransfer', '不存在或不是有效的充值卡'));
        }
    }
    /**
     * 检查transfer_gw
     * @param $attribute
     * @param $params
     */
    public function checkTransferGW($attribute, $params){
        if ($this->transfer_gw) {
            $rs = Yii::app()->db->createCommand()->select('id,gai_number')->from('{{member}}')
                ->where('(status=:status_no or status=:status_yes ) and gai_number=:gai_number',array(':status_no'=>Member::STATUS_NO_ACTIVE,':status_yes'=>Member::STATUS_NORMAL,':gai_number'=>$this->transfer_gw))
                ->queryRow();
            if ($rs){
                $model_transfer =PrepaidCardTransfer::model()->find('transfer_member_id=:transfer_member_id and status=:status',array(':transfer_member_id'=>$rs['id'],':status'=>PrepaidCardTransfer::STATUS_APPLY));
                if($model_transfer)
                    $this->addError($attribute, Yii::t('PrepaidCardTransfer', '此转账人有未审核的转账，请先审核后再申请！'));
                $this->transfer_gw = $rs['gai_number'];
                $this->transfer_member_id = $rs['id'];
            }else
                $this->addError($attribute, Yii::t('PrepaidCardTransfer', 'GW号不存在或删除、除名'));
        }
    }

    /**
     * 检查接人GW号
     * @param $attribute
     * @param $params
     */
    public function checkReceiverGw($attribute, $params){
        if ($this->receiver_gw) {
            $id= Yii::app()->db->createCommand()->select('id')->from('{{member}}')
                ->where('(status=:status_no or status=:status_yes ) and gai_number=:gai_number',array(':status_no'=>Member::STATUS_NO_ACTIVE,':status_yes'=>Member::STATUS_NORMAL,':gai_number'=>$this->receiver_gw))
                ->queryScalar();
            if ($id)
                $this->receiver_member_id = $id;
            else
                $this->addError($attribute, Yii::t('PrepaidCardTransfer', 'GW号不存在或删除、除名'));
        }
    }


    /**
     * 获取状态
     * @param null $k
     * @return array|null
     */
    public static function getStatus($k = null)
    {
        $arr = array(
            self::STATUS_APPLY =>  Yii::t('PrepaidCardTransfer', '申请中'),
            self::STATUS_YES => Yii::t('PrepaidCardTransfer', '审核通过'),
            self::STATUS_NO => Yii::t('PrepaidCardTransfer', '审核不通过'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

	public function search()
	{
		$criteria=new CDbCriteria;

        $criteria->select = 't.*,transfer.gai_number as transfer_gw,receiver.gai_number as receiver_gw';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('card_number',$this->card_number);
		$criteria->compare('value',$this->value);
		$criteria->compare('money',$this->money);
		$criteria->compare('transfer_member_id',$this->transfer_member_id);
		$criteria->compare('receiver_member_id',$this->receiver_member_id);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('author_ip',$this->author_ip);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('author_name',$this->author_name,true);
		$criteria->compare('auditor_ip',$this->auditor_ip);
		$criteria->compare('auditor_id',$this->auditor_id);
		$criteria->compare('auditor_name',$this->auditor_name,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('audit_time',$this->audit_time);
        $criteria->with = array('transfer','receiver');
        $criteria->order = 't.id desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrepaidCardTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 格式化remark输出
     * @param $str
     * @return string
     */
    public  function formatRemark($str){
        return "<span title='$str'>".Tool::truncateUtf8String($str,8)."</span>";
    }
}
