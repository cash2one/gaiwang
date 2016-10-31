<?php

/**
 * This is the model class for table "{{region_manage}}".
 *
 * The followings are the available columns in table '{{region_manage}}':
 * @property integer $id
 * @property string $name
 * @property string $member_id
 */
class AppTopicLife extends CActiveRecord
{
    //public $apply_type;
    public $step;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{app_topic_life}}';
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
            array('title,sequence,author,rele_status','required'),
            array('comHeadUrl,topic_img','required','on'=>'create'),
            array('comHeadUrl,topic_img', 'file', 'allowEmpty' =>  false, 'types' => 'jpg,jpeg,gif,png',
                'maxSize' => 1024 * 500 , 'tooLarge' => Yii::t('hotelBrand', '上传图片最大不能超过500K,请重新上传'),'on'=>'create'),
            array('id, title, author,comHeadUrl,topic_img,sequence,goods_list,error_field,profess_proof,audit_status,rele_status', 'safe', 'on'=>'search'),
        );
    }
    const AUDIT_STATUS = 0;     //未审核
    const AUDIT_STATUS_PASS = 1;   //通过
    const AUDIT_STATUS_NOW = 2;        //审核中
    const AUDIT_STATUS_NO = 3;        //未通过
    const RELE_STATUS_YES = 1 ;  //已发布
    const RELE_STATUS_NO = 2;    //未发布
    const DISABLE_YES = 1 ;  //启用
    const DISABLE_NO = 0;    //停用
    const SUBMIT = 1; //保存不发布
    const RELE_STATUS = 2;//保存和发布


    /*
    * 获取使用状态
    * */
    public static function getDisable($key = null){
        $data = array(
            self::DISABLE_YES => '启用',
            self::DISABLE_NO => '停用',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }

    /*
     * 获取审核状态
     * */
    public static function getAuditStatus($key = null){
        $data = array(
            self::AUDIT_STATUS_NO => '不通过',
            self::AUDIT_STATUS_PASS => '已通过',
            self::AUDIT_STATUS => '未审核',
            self::AUDIT_STATUS_NOW => '审核中',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    /*
     * 获取发布状态
     * */
    public static function getReleStatus($key = null){
        $data = array(
            self::RELE_STATUS_NO => '未发布',
            self::RELE_STATUS_YES => '已发布',
        );

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    /*
     * 获取发布时间
     * */
    public static function getReleTime($time = null){
        if($time != 0){
            return date("Y-m-d H:i:s",$time);
        }else{
            return '';
        }

        if($key==null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    /*
     * 创建查看话题按钮
     *
     * */
    public static function getLookProblem($Status,$life_id){
        if($Status == self::AUDIT_STATUS_PASS) {
            $string = "<a class='btn-sign' href='" . Yii::app()->controller->createUrl("appTopicLife/lookProblem", array("id" => $life_id)) . "' id='" . $life_id . "'>查看话题</a>";
        }else{
            $string = "<button class='btn-sign' style='background:#ccc !important;border:0'>查看话题</button>";
        }
        return $string;
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
            'title' => '标题',
            'sequence' => '排序',
            'topic_img'=>'专题图片',
            'comHeadUrl'=>'头像',
            'author'=>'作者',
            'profess_proof' => '专业证明',
            'rele_status'=> '发布状态',
            'rele_time'=> '发布时间',
            'audit_status'=> '审核状态',
            'online_time' => '设置专题生效上架时间',
            'disable' => '使用状态',
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

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('rele_status',$this->rele_status);
        $criteria->compare('admin_id',Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /*
     * 盖网app仕品搜索
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
        $html .= "<a href='".ATTR_DOMAIN .DS. $path."' onclick='return _showBigPic(this)'>";
        if($maxwidth == 0 && $maxheight == 0){
            $html.= "<img src='".ATTR_DOMAIN .DS. $path."' />";
        }else{
            $html.= "<img src='".ATTR_DOMAIN .DS. $path."' />";
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
    /*
     * 代理商后台按钮
     * */
    public static function createButtons($id){
        $lifeData = Yii::app()->db->createCommand()
            ->select()
            ->from(self::model()->tableName())
            ->where('id = :id', array(':id' => $id))
            ->queryRow();
        if(!empty($lifeData)){
            $string = "";
            if($lifeData['disable'] == 1) {
                $string .= "<a class='btn-sign' href=\"javascript:useStatus({$id})\">停用</a>";
            }else{
                $string .= "<a class='btn-sign' href=\"javascript:useStatus({$id})\">启用</a>";
            }
            if(AppTopicLife::AUDIT_STATUS_NO == $lifeData['audit_status']){
                $string .= "<a class='btn-sign' href=\"javascript:canNotPass({$id})\">不通过原因</a>";
            }
            if($lifeData['audit_status'] != AppTopicLife::AUDIT_STATUS_NOW)
            $string .= "<a class='btn-sign' href='".Yii::app()->controller->createUrl("update", array("id"=>$id))."'>编辑</a>";
            $string .= "<a class='btn-sign' href=\"javascript:deleteLife({$id})\">删除</a>";
            return $string;
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