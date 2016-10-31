<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class AppTopicHouse extends CActiveRecord
{
    public $enTer;
    public $enTerTit;
    public $goods;
    public $goodsTit;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{app_topic_house}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('title,remark,description','required'),
            array('comHeadUrl,pictureUrl','required','on'=>'create'),
            array('comHeadUrl,pictureUrl', 'file', 'allowEmpty' =>  true, 'types' => 'jpg,jpeg,gif,png','maxSize' => 1024 * 500 , 'tooLarge' =>  '上传图片最大不能超过500K,请重新上传','on'=>'create,update'),
            array('link','url'),
            array('id, title, description,comHeadUrl,picture,commodity_num,link', 'safe', 'on'=>'search'),
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
            'id' => '主键id',
            'title' => '馆名称',
            'commodity_num' => '馆内商品',
            'description'=>'馆备注',
            'pictureUrl'=>'馆内专题图',
            'comHeadUrl'=>'馆头像',
            'remark'=>'馆描述',
            'enTerName' => '商家查询',
            'goods' => '商品查询',
            'link'=>'仕品分享链接',
        );
    }
    const ENTER_ID = 1;
    const ENTER_GW = 2;
    public static function getEnterType($key = null){
        $data = array(
            self::ENTER_ID => '商家ID',
            self::ENTER_GW => '商家GW号',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    const GOODS_ID = 1;
    const GOODS_NAME = 2;
    public static function getGoodsType($key = null){
        $data = array(
            self::GOODS_ID => '商品ID',
            self::GOODS_NAME => '商品名称',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
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
        $criteria->compare('title',$this->title,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /*
     * 盖网app佳品搜索
     * */
    public function searchAppTopic()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('category_id', $this->category_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }
    const HOUSE_SUM = 3;
    public static function getHouseSum(){
        $houseSum = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from(AppTopicHouse::model()->tableName())
            ->queryScalar();
        return !empty($houseSum)?$houseSum:0;
    }
    /**
     * 输出图片，点击图片显示真是图片
     * @param string $path	图片路径(可能是略缩图)
     * @param int $maxwidth	宽度
     * @param int $maxheight	高度
     * ,'onmouseover'=>'showDelImg()','onmouseout'=>'hideDelImg()'
     */
    public static function showRealImg($path, $code_id,$maxwidth = 0, $maxheight = 0){
        $html='';
        $html .= "<a href='".IMG_DOMAIN .DS. $path."' onclick='return _showBigPic(this)'>";
        if($maxwidth == 0 && $maxheight == 0){
            $html.= "<img style='height:50px;width:50px' src='".IMG_DOMAIN .DS. $path."' />";
        }else{
            $html.= "<img style='height:50px;width:50px' src='".IMG_DOMAIN .DS. $path."' />";
        }
        $html.="</a>";
        echo $html;
    }
    /*
     * 添加商品数量
     * */
    public static function UdateGoodsNum($id){
        $goods_num = Yii::app()->db->createCommand()
            ->select('count(id)')
            ->from(AppTopicHouseGoods::model()->tableName())
            ->where('house_id = :house_id', array(':house_id' => $id))
            ->queryScalar();
        if(!empty($goods_num)){
            AppTopicHouse::model()->updateByPk($id, array('commodity_num' => $goods_num));
        }
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegionManage the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}