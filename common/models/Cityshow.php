<?php

/**
 * This is the model class for table "{{cityshow}}".
 *
 * The followings are the available columns in table '{{cityshow}}':
 * @property string $id
 * @property string $title
 * @property string $subtitle
 * @property string $encode
 * @property string $region
 * @property string $province
 * @property string $city
 * @property string $background_img
 * @property string $top_banner
 * @property integer $status
 * @property string $reason
 * @property integer $is_show
 * @property integer $sort
 * @property string $create_time
 * @property string $update_time
 *
 * relations
 * @property array $store;
 * @property CityshowRegion $cityshowRegion
 */
class Cityshow extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cityshow}}';
    }

    const STATUS_AUDIT = 0; //审核中
    const STATUS_PASS = 1; //审核通过
    const STATUS_NOPASS = 2;//审核未通过

    const SHOW_NO = 0; //不发布
    const SHOW_YES = 1; //发布
    
    const SOURCE_TYPE_ALL=0;
    const SOURCE_TYPE_PC=1;
    const SOURCE_TYPE_APP=2;


    public static function getStatus($status = null)
    {
        $arr = array(
            self::STATUS_AUDIT => Yii::t('goods', '审核中'),
            self::STATUS_PASS => Yii::t('goods', '审核通过'),
            self::STATUS_NOPASS => Yii::t('goods', '审核未通过'),
        );
        if (is_numeric($status)) {
            return isset($arr[$status]) ? $arr[$status] : null;
        } else {
            return $arr;
        }
    }

    public static function getShow($k = null)
    {
        $arr = array(
            self::SHOW_NO => Yii::t('goods', '停用'),
            self::SHOW_YES => Yii::t('goods', '启用'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    public static function getSourceType($k = null)
    {
        $arr = array(
                self::SOURCE_TYPE_ALL => Yii::t('goods', '全部平台'),
                self::SOURCE_TYPE_PC => Yii::t('goods', 'PC端'),
        		self::SOURCE_TYPE_APP => Yii::t('goods', '盖象优选APP端'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, subtitle, encode, region, province, city, background_img', 'required'),
            array('title, encode ', 'unique'),
            array('city', 'unique','message' => Yii::t('member', '该城市已存在城市馆')),
            array('status, is_show, source_type, sort', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' =>10),
            array('subtitle, reason', 'length', 'max' => 70),
            array('encode', 'length', 'max' => 64),
            array('region, province, city, create_time, update_time', 'length', 'max' => 11),
            array('background_img', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, subtitle, encode, region, source_type, province, city, background_img, top_banner, status, reason, is_show, sort, create_time, update_time,end_time', 'safe', 'on' => 'search'),
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
            'province' => array(self::BELONGS_TO, 'Region', 'province'),
            'city' => array(self::BELONGS_TO, 'Region', 'city'),
            'cityshowRegion' => array(self::BELONGS_TO, 'CityshowRegion', 'region'),
            'themes' => array(self::HAS_MANY, 'CityshowTheme', 'cityshow_id'), //主题
            'store' => array(self::HAS_MANY, 'CityshowStore', 'cityshow_id'), //入驻商家
            'manageStore' => array(self::BELONGS_TO, 'Store', 'sid'), //管理者商家
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'title' => '城市馆标题',
            'subtitle' => '副标题',
            'encode' => '页面编码',
            'region' => '所在大区',
            'province' => '所在省份',
            'city' => '所在城市',
            'background_img' => '背景图片',
            'top_banner' => '焦点图',
            'status' => '审核状态',
            'reason' => '不通过原因',
            'is_show' => '是否显示',
            'sort' => '排序',
            'create_time' => '创建时间',
            'update_time' => '审核时间',
        	'source_type' => '适用平台',
        );
    }

    /**
     * @var int 结束时间，搜索用
     */
    public $end_time;

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('source_type', $this->source_type);
        $dateTime = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('create_time', '>=' . $dateTime['start']);
        $criteria->compare('create_time', '<' . $dateTime['end']);
        $criteria->compare('region', $this->region);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id desc'
            ),
        ));
    }


    /**
     *
     * @param int $sid 城市馆代理商ID
     * @return CActiveDataProvider
     */
    public function getCityShowList($sid, $title = NULL)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->compare('t.sid', $sid);
        $criteria->compare('title', $this->title, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 't.sort DESC'
            ),
        ));
    }

    /**
     * @param int $sid 代理商ID
     * 计算城市馆商家和主题的数量
     */
    public function getCityShowStoreNum($sid)
    {
        $sql = 'SELECT
                t.id,    
                (
                    SELECT  count(*) FROM  gw_cityshow_store AS s WHERE s.cityshow_id = t.id
                ) AS store_count,
                (
                    SELECT  count(*)  FROM  gw_cityshow_theme AS ct WHERE ct.cityshow_id = t.id
                ) AS theme_count
            FROM
                `gw_cityshow` `t`
            WHERE
                 t.sid=' . $sid . ' 
            ORDER BY
                t.`sort` DESC';
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        return $res;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cityshow the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 根据城市编码获取数据
     * @param $encode
     * @return mixed
     */
    public static function getCityByEncode($encode)
    {
        return Yii::app()->db->createCommand(
            'SELECT * FROM gw_cityshow WHERE encode=:encode AND is_show=' . self::SHOW_YES . ' AND status=' . self::STATUS_PASS
        )->bindValue(':encode', $encode)->queryRow();
    }


    /**
     * 根据id获取相关字段信息
     * @param int $id 主键
     * @param string $field 要查询的字段
     */
    public static function getInfoById($id, $field = 'title,is_show,status')
    {
        $res = self::model()->findByPk($id, array('select' => $field));
        return $res;
    }


    /**
     * 获取全部城市馆数据，按照大区分组
     * @return array
     */
    public static function getAllCity()
    {
        $sql = 'SELECT
                    c.id,c.title,c.encode,c.region,c.province,city
                FROM
                    gw_cityshow as c 
                    LEFT JOIN gw_store as s on s.id=c.sid
                    LEFT JOIN  gw_cityshow_rights as r on r.member_id=s.member_id
                WHERE
                    is_show =:show
                AND c.`status` =:status
                AND r.member_id > 0
                ORDER BY
                    c.sort ASC';
        $data = Yii::app()->db->createCommand($sql)
            ->bindValues(array(':show' => self::SHOW_YES, ':status' => self::STATUS_PASS))->queryAll();
        if (!empty($data)) {
            $result = array();
            foreach ($data as $k => $v) {
                $v['province'] = str_replace('省', '', Region::getRegionName($v['province']));
                $v['city'] = str_replace('市', '', Region::getRegionName($v['city']));
                $result[$v['region']][] = $v;
            }
            return $result;
        }
        return $data;
    }

    public function afterDelete()
    {
        //删除入驻商家
        CityshowStore::model()->deleteAllByAttributes(array('cityshow_id' => $this->id));
        //删除主题、商品
        $themes = CityshowTheme::model()->findAllByAttributes(array('cityshow_id' => $this->id));
        if (!empty($themes)) {
            foreach ($themes as $v) {
                CityshowGoods::model()->deleteAllByAttributes(array('theme_id' => $v->id));
            }
            CityshowTheme::model()->deleteAllByAttributes(array('cityshow_id' => $this->id));
        }
        parent::afterDelete(); // TODO: Change the autogenerated stub

    }

    /**
     * 获取条数
     * @return mixed
     */
    public static function countNum()
    {
        return Yii::app()->db->createCommand('SELECT count(*) FROM gw_cityshow')->queryScalar();
    }

    /**
     * 根据代理商ID取出该代理商所有的城市馆
     * @param int $sid 代理商ID
     * @param string $field 要查的字段
     * @return array;
     */
    public static function getcityShowBySid($sid, $field = 'id')
    {
        $res = Yii::app()->db->createCommand()
            ->select($field)
            ->from('{{cityshow}}')
            ->where('sid = :sid', array(':sid' => $sid))
            ->queryAll();
        return $res;
    }
    
     /**
      *查找是否已存在一个城市的城市馆 
      * @param int $cityId 城市ID
      * @return bool
      */
    public static function cityShowIsExist($cityId){    
        $city=Cityshow::model()->exists(array(
                'condition'=>'city=:c',
                'params'=>array(':c'=>$cityId)
        ));
        return $city;
    }
    

}
