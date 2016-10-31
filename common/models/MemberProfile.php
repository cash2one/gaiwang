<?php

/**
 *  会员爱好记录表 模型
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * @property string $id
 * @property string $member_id
 * @property string $interest_category_id
 * @property string $interest_id
 * @property string $update_time
 * @property integer $show
 */
class MemberProfile extends CActiveRecord
{
    const SHOW_YES = 0;
    const SHOW_NO = 1;
    /**
     * 显示权限
     * @param null $k
     * @return array|null
     */
    public static function show($k = null)
    {
        $arr = array(
            self::SHOW_YES => Yii::t('memberProfile','所有人可见'),
            self::SHOW_NO => Yii::t('memberProfile','仅自己可见'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

	public function tableName()
	{
		return '{{member_profile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('member_id, interest_category_id, interest_id, update_time, show', 'required'),
			array('show', 'numerical', 'integerOnly'=>true),
			array('member_id, interest_category_id, interest_id, update_time', 'length', 'max'=>11),
			array('id, member_id, interest_category_id, interest_id, update_time, show', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('memberProfile','主键'),
			'member_id' => Yii::t('memberProfile','所属会员'),
			'interest_category_id' => Yii::t('memberProfile','所属爱好分类'),
			'interest_id' => Yii::t('memberProfile','爱好'),
			'update_time' => Yii::t('memberProfile','更新时间'),
			'show' => Yii::t('memberProfile','可见（0全部可见，1自己可见）'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('interest_category_id',$this->interest_category_id,true);
		$criteria->compare('interest_id',$this->interest_id,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('show',$this->show);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
