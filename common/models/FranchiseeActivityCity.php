<?php

/**
 * 加盟商活动城市模型
 * @author jianlin_lin <hayeslam@163.com>
 * 
 * @property string $id
 * @property string $province_id
 * @property string $city_id
 * @property integer $default
 * @property string $create_time
 */
class FranchiseeActivityCity extends CActiveRecord {

    const DEFAULT_NO = 0;
    const DEFAULT_YES = 1;

    public static function getDefaultOptions() {
        return array(
            self::DEFAULT_NO => Yii::t('franchiseeActivityCity', '否'),
            self::DEFAULT_YES => Yii::t('franchiseeActivityCity', '是')
        );
    }

    public static function getDefaultText($id) {
        $arr = self::getDefaultOptions();
        return isset($arr[$id]) ? $arr[$id] : Yii::t('franchiseeActivityCity', '未知');
    }

    public function tableName() {
        return '{{franchisee_activity_city}}';
    }

    public function rules() {
        return array(
            array('province_id, city_id', 'required'),
            array('city_id', 'unique', 'on' => 'insert,update','message'=>"选择的城市已存在！"),
            array('default', 'numerical', 'integerOnly' => true),
            array('province_id, city_id, create_time', 'length', 'max' => 11),
            array('default', 'in', 'range' => array(0, 1)),
            array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'setOnEmpty' => false, 'on' => 'insert'),
            array('id, province_id, city_id, default, create_time', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'province_id' => Yii::t('franchiseeActivityCity', '省份'),
            'city_id' => Yii::t('franchiseeActivityCity', '城市'),
            'default' => Yii::t('franchiseeActivityCity', '是否默认'),
            'create_time' => Yii::t('franchiseeActivityCity', '创建时间'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('default', $this->default);
        $criteria->compare('create_time', $this->create_time, true);
        if (!empty($this->city_id)) {
            $region = new Region;
            $data = $region->searchCityName($this->city_id, 'id');
            foreach ($data as $k => $v)
                $data[$k] = $v['id'];
            $criteria->addInCondition('city_id', $data);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 缓存线下活动城市数据
     * 前台调用，减少查询数据库
     * @param boolean $flag
     * @param return array
     */
    public static function fileCache($flag = true) {
        if ($flag) {
            $activityCities = Tool::cache('common')->get('activityCity');
            return !$activityCities ? self::fileCache(false) : $activityCities;
        }
        $activityCities = Yii::app()->db->createCommand()
        ->select('city_id, default, r.name')
        ->from('{{franchisee_activity_city}}')
        ->join('{{region}} as r', 'city_id = r.id')
        ->order('default DESC, create_time DESC')
        ->queryAll();
        Tool::cache('common')->set('activityCity', $activityCities);
        return $activityCities;
    }

    /**
     * 首页获取线下活动默认城市名称
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getOnlineDefaultCity() {
        $data = Yii::app()->db->createCommand()
        ->select('f.city_id,r.name')
        ->from('{{franchisee_activity_city}} as f')
        ->leftJoin('{{region}} as r', 'f.city_id=r.id')
        ->where('f.`default`=:default', array(':default' => FranchiseeActivityCity::DEFAULT_YES))
        ->queryRow();
        if (empty($data))
            $data = array(
                'city_id' => '237',
                'name' => '广州市',
            );
        return $data;
    }

    /**
     * 首页获取线下活动所有城市
     * @return array $data
     * @author wencong.lin <183482670@qq.com>
     */
    public static function getOnlineAllCity() {
        $data = Yii::app()->db->createCommand()
        ->select('f.city_id,r.name')
        ->from('{{franchisee_activity_city}} as f')
        ->leftJoin('{{region}} as r', 'f.city_id=r.id')
        ->order('default DESC')
        ->queryAll();
        if (empty($data))
            $data = array();
        return $data;
    }

    public function afterSave() {
        parent::afterSave();
        Tool::cache('common')->set('activityCity', '');
        return true;
    }

}
