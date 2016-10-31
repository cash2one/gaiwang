<?php

/**
 * {{lodger_info}} 模型
 * @author jianlin.lin <hayeslam@163.com>
 *
 * The followings are the available columns in table '{{lodger_info}}':
 * @property string $id
 * @property string $name
 * @property string $more
 * @property string $member_id
 * @property string $token
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class LodgerInfo extends CActiveRecord
{
    public $nationality; // 国籍

	public function tableName()
	{
		return '{{lodger_info}}';
	}

	/**
	 * @return array 数组模型属性的验证规则
	 */
	public function rules()
	{
		return array(
			array('name, member_id, nationality', 'required'),
			array('name', 'length', 'max'=>128),
            array('name','checkName'),
			array('member_id', 'length', 'max'=>11),
       //     array('name', 'match', 'pattern' => "/^[\x{4e00}-\x{9fa5}A-Za-z]+$/u", 'message' => Yii::t('lodgerInfo', '姓名请输入中文或者英文')),
			array('id, name, more, member_id', 'safe', 'on'=>'search'),
		);
	}

    //检查英文名
    public function checkName($attribute, $params){
        if (preg_match("/^[A-Za-z]+/",$this->name) ){
            if(!preg_match("#^[A-Za-z]+/[A-Za-z]+$#",$this->name))
                $this->addError('name', Yii::t('lodgerInfo', '请按填写规则填写英文名！'));
        }elseif(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$this->name))
            $this->addError('name', Yii::t('lodgerInfo', '请按填写规则填写中文名！'));
    }

	/**
	 * @return array 关系规则
	 */
	public function relations()
	{
		return array(
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array 自定义属性标签(名称=>标签)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('lodgerInfo','主键'),
			'name' => Yii::t('lodgerInfo','姓名'),
			'more' => Yii::t('lodgerInfo','更多信息'),
			'member_id' => Yii::t('lodgerInfo','所属会员'),
			'token' => Yii::t('lodgerInfo','MD5标记'),
            // 附加属性
            'nationality' => Yii::t('lodgerInfo','国籍'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('more',$this->more,true);
		$criteria->compare('member_id',$this->member_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, // 分页
            ),
            'sort'=>array(
//                'defaultOrder'=>' DESC', // 设置默认排序
            ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 在 AR 保存实例之前的操作
     * @return bool
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->token = $this->getTokenStr();
            $this->more = json_encode($this->dataCompound());
            return true;
        }
        return false;
    }

    /**
     * 查询之后的处理
     * @author jianlin.lin
     */
    public function afterFind() {
        $this->more = json_decode($this->more);
        $this->_dataBuild();
        parent::afterFind();
    }

    /**
     * 构建自定义数据
     * @author jianlin.lin
     */
    private function _dataBuild() {
        $this->nationality = $this->more->nationality;
    }

    /**
     * 入住信息数据合成
     * @return array
     * @author jianlin.lin
     */
    public function dataCompound() {
        return array(
            'name' => $this->name,
            'nationality' => $this->nationality,
        );
    }

    /**
     * 获取Token值
     * @return string
     * @author jianlin.lin
     */
    public function getTokenStr() {
        return md5(json_encode(array_merge(array('member_id' => $this->member_id), $this->dataCompound())));
    }

    /**
     * 获取键名
     * @param $key
     * @return mixed 键值
     * @author jianlin.lin
     */
    public static function getKeyName($key) {
        $arr = array(
            'name' => Yii::t('lodgerInfo','姓名'),
            'nationality' => Yii::t('lodgerInfo','国籍'),
        );
        return isset($arr[$key]) ? $arr[$key] : $key;
    }

}
