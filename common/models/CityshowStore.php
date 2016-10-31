<?php

use Monolog\Handler\NullHandler;

/**
 * This is the model class for table "{{cityshow_store}}".
 *
 * The followings are the available columns in table '{{cityshow_store}}':
 * @property string $id
 * @property integer $cityshow_id
 * @property integer $store_id
 * @property integer $status
 * @property integer $sort
 * @property string $create_time
 */
class CityshowStore extends CActiveRecord
{

    public $name; //商家名称
    public $title;//城市馆标题
    public $gw;//商家GW号
    public $end_time;//搜索结束时间

    const TYPE_GW = 1;//GW号
    const TYPE_NAME = 2;//查询用商家gw号

    const STATUS_YES = 1; //启用
    const STATUS_DEL = 0; //已停用

    public static function status($k = null)
    {
        $arr = array(
            self::STATUS_YES => Yii::t('goods', '启用'),
            self::STATUS_DEL => Yii::t('goods', '停用'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cityshow_store}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cityshow_id, store_id, status, sort, create_time', 'required'),
            array('cityshow_id, store_id, status, sort', 'numerical', 'integerOnly' => true),
            array('create_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cityshow_id, store_id, status, sort, create_time,gw,name,end_time', 'safe', 'on' => 'search'),
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
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'cityshow_id' => '城市馆id',
            'store_id' => '入驻商家id',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '创建时间',
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

        $criteria = new CDbCriteria;
        $criteria->select = 't.*,s.name,m.gai_number as gw';
        $criteria->join = 'LEFT JOIN {{store}} AS s ON t.store_id=s.id LEFT JOIN {{member}} AS m ON s.member_id=m.id';
        $criteria->compare('s.name', $this->name);
        $criteria->compare('m.gai_number', $this->gw);
        $criteria->compare('t.cityshow_id', $this->cityshow_id);
        $criteria->compare('t.store_id', $this->store_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.sort', $this->sort);
        $dateTime = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', '>=' . $dateTime['start']);
        $criteria->compare('t.create_time', '<' . $dateTime['end']);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    /**
     * @param int $sid 城市馆ID
     * @return CActiveDataProvider
     */
    public function getCityShowStoreList($cid = NULL)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*,s.name,m.gai_number as gw';
        $criteria->join = 'LEFT JOIN {{store}} AS s ON t.store_id=s.id LEFT JOIN {{member}} AS m ON s.member_id=m.id';
        if ($cid !== null) {
            $criteria->compare('t.cityshow_id', $cid);
        }
        if ($this->create_time) {
            $this->end_time = $_GET['CityshowStore']['end_time'];
            $searchDate = Tool::searchDateFormat($this->create_time, $this->end_time);
            $criteria->compare('t.create_time', ">=" . $searchDate['start']);
            $criteria->compare('t.create_time', "<" . $searchDate['end']);

        }
        if (isset($_GET['name']) && isset($_GET['type'])) {
            $name = $_GET['name'];
            $type = $_GET['type'];
            if ($type == self::TYPE_GW) {
                $criteria->compare('m.gai_number', $name, true);
            }
            if ($type == self::TYPE_NAME) {
                $criteria->compare('s.name', $name, true);
            }
        }
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CityshowStore the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *根据 会员gw号得到商家主键
     * @param string $gw 商家GW号
     * @param int $csid 城市馆主键ID
     * @param string $fields 要查询的字段
     * @return array
     */
    public static function getStoreInfoBygw($gw, $csid = NULL, $fields = 't.id,t.status,m.gai_number')
    {
        $commond = Yii::app()->db->createCommand();
        //$commond->where('t.status=:s', array(':s' => Store::STATUS_PASS));
        if (is_array($gw)) {
            $commond->andWhere(array('IN', 'm.gai_number', $gw));
        } else {
            $commond->andWhere('m.gai_number = :gw', array(':gw' => $gw));
        }
        if ($csid !== NULL) {
            $IdArr = self::getStoreIdByCsid($csid, NULL);
            $storeIdArr = isset($IdArr['store_id']) ? $IdArr['store_id'] : 0;
            if (!empty($storeIdArr)) {
                $commond->andWhere(array('NOT IN', 't.id', $storeIdArr));
            }
        }
        $res = $commond->select($fields)
            ->from('{{store}} t')
            ->leftJoin('{{member}} m', 't.member_id=m.id')
            ->order('t.id DESC')
            ->queryAll();
        return $res;
    }

    /**
     * 根据城市馆ID得到其所属的所有商家
     * @param int $csid 城市馆ID
     * @param int $status 商家状态
     * @return array
     */
    public static function getStoreIdByCsid($csid, $status = self::STATUS_YES)
    {
        $commond = Yii::app()->db->createCommand();
        if ($status !== null) {
            $commond->andWhere('status = :s', array(':s' => $status));
        }
        if (is_array($csid)) {
            $commond->Where(array('IN', 'cityshow_id', $csid));
        } else {
            $commond->Where('cityshow_id = :sid', array(':sid' => $csid));
        }
        $res = $commond->select('id,store_id')->from('{{cityshow_store}}')->queryAll();
        $retArr = array();
        foreach ($res as $v) {
            $retArr['store_id'][] = isset($v['store_id']) ? $v['store_id'] : 0;//商家ID
            $retArr['sid'][] = isset($v['id']) ? $v['id'] : 0;//城市馆商家主键
        }
        return $retArr;
    }

    /**
     * 根据商家ID得到城市馆商家的主键
     * @param int $sid 商家id
     * @return mixed
     */
    public static function getCityShowStoreId($sid)
    {
        $res = Yii::app()->db->createCommand()
            ->select('t.id')
            ->from('{{cityshow_store}} t')
            ->where('t.store_id = :sid', array(':sid' => $sid))
            ->queryScalar();
        return $res;
    }

    /**
     * 根据城市馆商家得到{{store}}表商家名称
     * @param int $sid 城市馆商家主键ID
     * @return mixed
     */
    public static function getStoreNameBySid($sid)
    {
        $res = Yii::app()->db->createCommand()
            ->select('s.name')
            ->from('{{cityshow_store}} t')
            ->leftJoin("{{store}} AS s", "t.store_id=s.id")
            ->where('t.id = :sid', array(':sid' => $sid))
            ->queryScalar();
        return $res;
    }

    /**
     * 统计城市馆的入驻商家
     * @param int $cid
     * @return mixed
     */
    public static function countStore($cid)
    {
        return Yii::app()->db->createCommand('SELECT count(*) FROM gw_cityshow_store WHERE cityshow_id=:cid')
            ->bindValue(':cid', $cid)->queryScalar();
    }

    /**
     * 删除入驻商家后，顺便删除该商家的入驻商品
     */
    public function afterDelete()
    {
        CityshowGoods::model()->deleteAllByAttributes(array('store_id' => $this->id));
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }

//    public function afterSave()
//    {
//        //如果停用商家，删除对应的商品
//        if($this->status==self::STATUS_DEL){
//            CityshowGoods::model()->deleteAllByAttributes(array('store_id' => $this->id));
//        }
//        parent::afterSave(); // TODO: Change the autogenerated stub
//    }
}
