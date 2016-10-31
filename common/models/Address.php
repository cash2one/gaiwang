<?php

/**
 * 会员收货地址模型
 * @author wencong.lin <183482670@qq.com>
 *
 * @property string $id
 * @property string $member_id
 * @property string $real_name
 * @property string $mobile
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $zip_code
 * @property integer $default
 */
class Address extends CActiveRecord {

    const DEFAULT_NO = 0;
    const DEFAULT_YES = 1;

    public function tableName() {
        return '{{address}}';
    }

    public function rules() {
        return array(
            array('real_name, mobile, street, province_id, city_id, district_id', 'required'),
            array('default,zip_code', 'numerical', 'integerOnly' => true),
            array('zip_code', 'length', 'max' => 6),
            array('real_name', 'length', 'max' => 56),
            array('street', 'length', 'max' => 128),
            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('address', '请输入正确的手机号码')),
            array('real_name, mobile, street, zip_code, telephone', 'safe'),
            array('real_name,street', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('telephone','match','pattern'=>'/^0\d{2,3}\-\d{7,8}$/','message'=>  Yii::t('address','请填入正确的固话号码'))
        );
    }

    public function relations() {
        return array(
            'province' => array(self::BELONGS_TO, 'Region', 'province_id'),
            'city' => array(self::BELONGS_TO, 'Region', 'city_id'),
            'district' => array(self::BELONGS_TO, 'Region', 'district_id')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'member_id' => 'Member',
            'real_name' => Yii::t('address', '收货人姓名'),
            'mobile' => Yii::t('address', '手机号码'),
            'province_id' => Yii::t('address', '所在地区'),
            'city_id' => Yii::t('address', '城市'),
            'district_id' => Yii::t('address', '区/县'),
            'street' => Yii::t('address', '街道地址'),
            'zip_code' => Yii::t('address', '邮政编码'),
            'default' => Yii::t('address', '设为默认'),
            'telephone'=>Yii::t('address','固定电话'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->member_id = Yii::app()->user->id;
            return true;
        } else
            return false;
    }

    /**
     * 获取会员的收货地址数量
     * @return int
     */
    public function numCount() {
        return $this->count('member_id = ' . Yii::app()->user->id);
    }

    /**
     * 获取会员收货地址
     * @param $member_id
     * @return array  $Add 收货地址(组合成完整的收货地址)
     */
    public static function getMemberAddress($member_id) {
//        $user_id = Yii::app()->user->id;
//        $memberAdd = self::model()->findAll('member_id=' . $user_id);
//        $Add = array();
//        foreach ($memberAdd as $k => $v) {
//            $Add[$k]['address'] = Region::getName($v->province_id, $v->city_id, $v->district_id) . $v->street . '&nbsp;(' . $v->real_name . ')&nbsp;' . $v->mobile;
//            $Add[$k]['id'] = $v->id;
//            $Add[$k]['default'] = $v->default;
//            $Add[$k]['consignee'] = $v->real_name . '&nbsp' . $v->mobile;
//        }
//        return $Add;
        $sql = "SELECT
                    a.id,
                    a.real_name,
                    a.mobile,
                    a.city_id,
                    a.street,
                    a.zip_code,
                    a.`default`,
                    a.telephone,
                    r.`name` as province_name,
                    r2.`name` as city_name,
                    r3.`name` as district_name
                FROM
                    gw_address AS a
                LEFT JOIN gw_region as r on a.province_id=r.id
                LEFT JOIN gw_region as r2 on a.city_id=r2.id
                LEFT JOIN gw_region as r3 on a.district_id=r3.id
                WHERE
                    a.member_id = :mid
                ORDER BY a.`default` DESC";
        return Yii::app()->db->createCommand($sql)->bindParam(':mid', $member_id)->queryAll();
    }

    /**
     * 根据id,查找地址详情
     * @param $id
     * @return array
     */
    public static function getAddressById($id) {
        $sql = "SELECT
                    a.id,
                    a.real_name,
                    a.mobile,
                    a.city_id,
                    a.street,
                    a.zip_code,
                    a.`default`,
                    a.telephone,
                    r.`name` as province_name,
                    r2.`name` as city_name,
                    r3.`name` as district_name
                FROM
                    gw_address AS a
                LEFT JOIN gw_region as r on a.province_id=r.id
                LEFT JOIN gw_region as r2 on a.city_id=r2.id
                LEFT JOIN gw_region as r3 on a.district_id=r3.id
                WHERE
                    a.id = :id
                ORDER BY a.`default` DESC";
        return Yii::app()->db->createCommand($sql)->bindParam(':id', $id)->queryRow();
    }

    /**
     * 查询已选择收货地址的详细信息
     * @param type $id
     * @param type $field
     * @return type
     */
    public static function getEnterprise($id, $field) {
        $data = self::model()->findByPk($id);
        return $data->$field;
    }

    /**
     * 获取会员默认收货地址
     * @return array|null
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public static function getDefault($memberId) {
        $sql = "SELECT a.id, a.real_name, a.mobile, a.street, a.zip_code,a.city_id,
                r1.`name` AS province_name, r2.`name` AS city_name,
                r3.`name` AS district_name FROM {{address}} AS a
                LEFT JOIN {{region}} AS r1 ON a.province_id = r1.id
                LEFT JOIN {{region}} AS r2 ON a.city_id = r2.id
                LEFT JOIN {{region}} AS r3 ON a.district_id = r3.id
                WHERE a.member_id = :memberId ORDER BY a.`default` DESC";
        return Yii::app()->db->createCommand($sql)->bindParam(':memberId', $memberId)->queryRow();
    }

}
