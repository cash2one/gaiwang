<?php

/**
 * This is the model class for table "{{seckill_rules}}".
 *
 * The followings are the available columns in table '{{seckill_rules}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $status
 * @property string $picture
 * @property string $remark
 * @property string $product_category_id
 * @property integer $discount_rate
 * @property integer $discount_price
 * @property integer $sort
 * @property integer $limit_num
 * @property integer $buy_limit
 * @property string $creat_time
 * @property string $edit_time
 * @property string $description
 * @property string $creat_user
 * @property string $start_time
 * @property string $end_time
 */
class SeckillRules extends CActiveRecord
{
    
    public $start_time;
    public $end_time;
    public $gift;
    const STATUS_ON = 1;    //  开启状态
    const STATUS_ONT_OPEN = 2;  //未开启状态
    const STATUS_STOP = 3;      //停止状态
    const STATUS_OVER = 4;      //结束状态
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return '{{seckill_rules}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('category_id, name, status, picture, remark, product_category_id, discount_rate, discount_price, sort, limit_num, buy_limit, creat_time, edit_time, description, creat_user,gift', 'required'),
                    array('category_id, status, discount_rate, discount_price, sort, limit_num, buy_limit,gift', 'numerical', 'integerOnly'=>true),
                    array('name', 'length', 'max'=>10),
                    array('picture', 'length', 'max'=>150),
                    array('remark', 'length', 'max'=>6),
                    array('product_category_id', 'length', 'max'=>255),
                    array('creat_user', 'length', 'max'=>50),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, category_id, name, status, picture, remark, discount_rate, discount_price, sort, limit_num, buy_limit, creat_time, edit_time, description, creat_user', 'safe', 'on'=>'search'),
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
                'SeckillRulesTime'=>array(self::HAS_MANY, 'SeckillRulesTime', 'rules_id'), 
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => '编号',
                    'category_id' => '活动类型',
                    'name' => '活动名称',
                    'status' => '活动状态',
                    'picture' => '活动图片',
                    'remark' => '活动备注',
                    'date_period' => '时间范围',
                    'product_category_id' => '参加商品类别',
                    'discount_rate' => '消费比例',
                    'discount_price' => '限定价格',
                    'gift' => '红包消费支持比例',
                    'sort' => '活动排序',
                    'limit_num' => '活动商品限制参与数',
                    'buy_limit' => 'ID限制购买数量',
                    'creat_time' => 'Creat Time',
                    'edit_time' => 'Edit Time',
                    'description' => '活动说明与协议',
                    'creat_user' => 'Creat User',
                    'start_time' => '开始时间',
                    'end_time' => '结束时间',
                    'date' => '日期',
                    'time' => '时间',
                    'product_name' => '商品名称',
                    'product_id' => '商品ID',
                    'seller_name' => '商家名称',
                    'price' => '售价',
                    'stock' => '库存',
                    'rule_id' => '所属活动',
                    'operation' => '操作',
                    'link' => '链接',
                    'mp' => '商品优惠幅度',
                    'product_number'=>'活动商品',
                    'start_activity' => '开始活动',
                    'stop_activity' => '强制结束',
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
            $criteria->compare('category_id',$this->category_id);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('status',$this->status);
            $criteria->compare('picture',$this->picture,true);
            $criteria->compare('remark',$this->remark,true);
            $criteria->compare('product_category_id',$this->product_category_id,true);
            $criteria->compare('discount_rate',$this->discount_rate);
            $criteria->compare('discount_price',$this->discount_price);
            $criteria->compare('sort',$this->sort);
            $criteria->compare('limit_num',$this->limit_num);
            $criteria->compare('buy_limit',$this->buy_limit);
            $criteria->compare('creat_time',$this->creat_time,true);
            $criteria->compare('edit_time',$this->edit_time,true);
            $criteria->compare('description',$this->description,true);
            $criteria->compare('creat_user',$this->creat_user,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));

    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeckillRules the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
    /**
    * 获取活动类型
    * @var id 类型的id
    * @return array 返回数组
    */
    public static function getCategoryId($id = 0) {
        $return = array();
            $where  = $id ? "id='$id'" : '1';

            $return = Yii::app()->db->createCommand()
            ->select('id, name')
            ->from('{{seckill_category}}')
            ->where($where)
            ->order('id ASC')
            ->queryAll();

            return $return;
    }

    /**
     *  保存活动内容
     * @param $postArray 活动的相关内容
     * 
     */
    public function saveRules($postArray=array()){
        if(empty($postArray)) return false;


    }


    /**
    * 获取活动的内容 只含应节性和红包活动 限时秒杀由于有多个时间段,需要另外处理
    * @var category_id 活动类型id
    * @return array 返回内容数组
    */
    public static function getRulesRecord($category_id=1, $status=0){
            $return = NULL;
            $where  = '1';

            $where .= " AND r.category_id='$category_id'";
            $where .= $status ? " AND r.status='$status'" : '';
            if($category_id == 3){
                $sql    = "SELECT r.id, r.name, r.sort, r.discount_rate, r.discount_price, r.status "
                        . "FROM {{seckill_rules}} r "
                        . "WHERE $where "
                        . "ORDER BY r.sort=0,sort ASC ";
            }else{
                $sql    = "SELECT r.id, r.name, r.sort, r.discount_rate, r.discount_price, r.limit_num, r.status, t.start_time, t.end_time "
                        . "FROM {{seckill_rules}} r,{{seckill_rules_time}} t "
                        . "WHERE $where AND  r.id=t.rules_id "
                        . "ORDER BY r.sort=0,sort ASC,t.start_time DESC";
            }

            $criteria = new CDbCriteria();
            $result   = Yii::app()->db->createCommand($sql)->query();
            $pages    = new CPagination($result->rowCount);
            $pages->pageSize = 20; 
            $pages->params   = array('category_id'=>$category_id, 'status'=>$status);
            $pages->applyLimit($criteria); 
            $result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
            $result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
            $result->bindValue(':limit', $pages->pageSize); 

            $return = array('data'=>$result->query(), 'pages'=>$pages); 

            /*$criteria = new CDbCriteria();
            $criteria->select = 't.id, t.name, t.sort, t.discount_rate, t.discount_price, t.status, t1.start_time, t1.end_time';
            $criteria->join   = 'LEFT JOIN {{seckill_rules_time}} t1 ON t.id=t1.rules_id';
            $criteria->order  = 't.sort,t1.start_time DESC'; 
            //$criteria->limit  = 0; 
            $criteria->condition  = "t.category_id = '$category_id'";
            $criteria->condition .= $status ? " AND t.status='$status'" : '';

            return new CActiveDataProvider('SeckillRules', array(
                                    'criteria'=>$criteria,
                            ));
            */ 

            return $return;
    }
        
    /**
     * 获取商品的类别
     * @return array 返回商品的类别
     */
    public function getProductCategory(){
        $return = array();

        $sql = "SELECT id,name FROM {{category}} WHERE status=1 AND parent_id=0"; 
        $command = Yii::app()->db->createCommand($sql);  
        $return  = $command->queryAll(); 

        return $return;
    }

    /**
    * 获取活动状态
    * @return array 返回状态数组
    */
    public static function getStatusArray($key=''){
        $array = array(1=>'正在进行',2=>'未开始',3=>'已暂停',4=>'已结束');

        if($key){
            return $array[$key];
        }else{
            return $array;
        }
    }
        
    /**
     * 获取具体活动已参加的商品数量
     * @param integer rules_id 活动的具体ID
     * @return integer 返回查询数量
     */
    public static function getRulesProductNumber($rules_id = 0){

        $sql = "SELECT COUNT(*) AS num FROM {{seckill_product_relation}} WHERE rules_id='$rules_id'";

        $command = Yii::app()->db->createCommand($sql);  
        $return  = $command->queryRow(); 

        return intval($return['num']);
    }
        
        /**
     * 获取活动的时间(限时秒杀活动时用到)
     * @param integer $id  活动的id
     * @return array 时间数组
     */
    public static function getRulesTime($id=0){
        $return  = array();
        
        $sql     = "SELECT * FROM {{seckill_rules_time}} WHERE rules_id='$id'";
        $command = Yii::app()->db->createCommand($sql); 
        $return  = $command->queryAll();
        print_r($return);
        return $return;
    }

    /**获取关联的相关参加活动信息
     * @param $product_id
     * @return mixed
     * @author jiawei liao <569114018@qq.com>
     */
    public static function getActive($product_id){
        $active_sql = "select rules.name,rules.discount_rate,rules.discount_price,rules.limit_num, product.status,product.rules_id
                    from {{seckill_product_relation}} as product left join {{seckill_rules}} as rules on rules.id = product.rules_id
                    where product.product_id = {$product_id}";
        $active = Yii::app()->db->createCommand($active_sql)->queryRow();

        $newActive = SeckillRulesTime::getTimes($active);
        return $newActive;
    }

    /**根据ID主键获取规则信息
     * @param $id
     * @return mixed
     */
    public static function getOneRules($id){
        $result = Yii::app()->db->createCommand()->select('id, name, status, limit_num, description, discount_rate, discount_price')
            ->from('{{seckill_rules}}')
            ->where("status in (".self::STATUS_ON.','.self::STATUS_ONT_OPEN.") and id = {$id}")->queryRow();
        return $result;
    }
}
