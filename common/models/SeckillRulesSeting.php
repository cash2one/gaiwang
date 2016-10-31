<?php
/**
 * 活动规则相关设置信息
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/4/30
 * Time: 17:02
 *
 */

class SeckillRulesSeting extends CActiveRecord{

    const NO_OPEN = 1;  // 未开启
    const NO_BIGING = 2;    //未开始
    const BEGINING = 3;     //  进行着
    const TIME_OVER = 4;     // 活动结束
    
    public $exportLimit = 500;
    public $isExport;

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "{{seckill_rules_seting}}";
    }

    /**获取秒杀活动日期相关的时间
     * @param $rules_id
     * @return array
     */
    public static function getSetingTimes($rules_id,$cate_id){
        $CateId = SeckillCategory::getTopParentId($cate_id);
        $sql = "select seting.limit_num, seting.id,seting.start_time,seting.end_time,main.singup_start_time,main.singup_end_time from {{seckill_rules_seting}} as seting
              left join {{seckill_rules_main}} as main on main.id=seting.rules_id
               where seting.rules_id in ({$rules_id}) and FIND_IN_SET({$CateId}, seting.product_category_id) and concat(main.date_end,' ',seting.end_time) > NOW() and seting.allow_singup=1 and seting.status !=".self::TIME_OVER;
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $new_result = self::setNewList($result);
        return $new_result;
    }

    /**获取一条数据的规则id类型id
     * @param $id
     * @return mixed
     */
    public static function getOneData($id){
        $result = Yii::app()->db->createCommand()->select("CONCAT(main.date_end,' ',seting.end_time) as endtimes,seting.*,main.category_id,main.name,main.date_start,main.date_end,main.singup_start_time,singup_end_time,count(rs.id) as counts,category.name as category_name")
            ->from("{{seckill_rules_seting}} as seting")->leftJoin("{{seckill_rules_main}} as main","main.id=seting.rules_id")
            ->leftJoin("{{seckill_product_relation}} as rs","rs.rules_seting_id=seting.id")
            ->leftJoin("{{seckill_category}} as category","category.id=rs.category_id")
            ->where('seting.id=:id and rs.status=:status',array(':id'=>$id,':status'=>1))->queryRow();
        return $result;
    }

    /**
     * 返回该数组下的活动商品还没满的活动
     * @param $result
     * @return array
     */
    public static function setNewList($result,$fields ='id'){
        $new_result = array();
		$time = time();
        foreach($result as $key => $value){
            $numsql = "select count(id) as num from {{seckill_product_relation}} where rules_seting_id={$value[$fields]} and status=1";
            $num = Yii::app()->db->createCommand($numsql)->queryRow();
            if($value['limit_num'] > $num['num'] && $time>=strtotime($value['singup_start_time']) && $time<=strtotime($value['singup_end_time'])){
                $new_result[] = $value;
            }
        }
        return $new_result;
    }

    //---------------------------下面是李文豪写的----------------------------------------
    public $rulesId;
    public $rules_id;
    public $categoryId;
    public $category_id;
    public $name;
    public $gift;
    public $id;
    public $discount;
    public $product_name;
    public $product_id;
    public $seller_name;
    public $rules_seting_id;
    public $rulesSetingId;
    public $banner1;
    public $banner2;
    public $banner3;
    public $banner4;
    public $singup_start_time;
    public $singup_end_time;
    public $allow_singup;

    //秒杀活动的类型 1红包 2应节 3秒杀 4拍卖
    const SECKILL_CATEGORY_ONE = 1;
    const SECKILL_CATEGORY_TWO = 2;
    const SECKILL_CATEGORY_THREE = 3;
    const SECKILL_CATEGORY_FOUR = 4;

    //活动状态 1未开启 2未开始 3正在进行 4已结束
    const ACTIVITY_NOT_OPEN = 1;
    const ACTIVITY_NOT_START = 2;
    const ACTIVITY_IS_RUNNING = 3;
    const ACTIVITY_IS_OVER = 4;

    //商品参加活动的审核状态 0审核中 1通过 2未通过
    const RELATION_NO = 0;
    const RELATION_IS_PASS = 1;
    const RELATION_NOT_PASS = 2;

    //是否强制结束 0 否 1 是
    const IS_FORCE_NO = 0;
    const IS_FORCE_YES = 1;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rules_id, status, remark, limit_num, buy_limit, creat_time, edit_time, description,end_time, name, gift,picture,seller', 'required', 'on'=>'rulesCreate,rulesUpdate'),
            array('rules_id, status, sort, limit_num, buy_limit,seller', 'numerical', 'integerOnly'=>true),
            array('name,status,remark,start_time,end_time,sort,description', 'required', 'on'=>'auctionCreate'),
            array('name,remark,end_time,sort,description', 'required', 'on'=>'auctionUpdate'),
           // array('start_time', 'required','on'=>'auctionUpdate'),
            //array('picture', 'length', 'max'=>150),
            array('remark', 'length', 'max'=>6),
            array('product_category_id', 'length', 'max'=>255),
            array('start_time', 'required', 'on'=>'rulesCreate,rulesSeckill'),
            array('singup_start_time,singup_end_time', 'required', 'on'=>'rulesCreate,rulesUpdate'),
            //array('discount_rate', 'length', 'max'=>5),
            //array('discount_price', 'length', 'max'=>10),
            // The following rule is used by search().
            array('picture', 'file',
                'allowEmpty' => false,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => '上传失败！请上传小于1M的文件！',
                'on'=>'rulesCreate'
            ),
            array('picture', 'file',
                'allowEmpty' => true,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => '上传失败！请上传小于1M的文件！',
                'on'=>'rulesUpdate'
            ),
            array('picture', 'file',
                'allowEmpty' => false,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => '上传失败！请上传小于1M的文件！',
                'on'=>'auctionCreate'
            ),
            array('picture', 'file',
                'allowEmpty' => true,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => '上传失败！请上传小于1M的文件！',
                'on'=>'auctionUpdate'
            ),
            array('banner1,banner2,banner3,banner4', 'file',
                'allowEmpty' => true,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 3,
                'tooLarge' => '上传失败！请上传小于3M的文件！',
                'on'=>'rulesCreate,rulesUpdate'
            ),
            array('picture', 'file',
                'allowEmpty' => true,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 1,
                'tooLarge' => '上传失败！请上传小于1M的文件！',
                'on'=>'auctionUpdate'
            ),
            array('picture', 'file',
                'allowEmpty' => true,
                'types'=> 'jpg,gif,png',
                'maxSize' => 1024 * 1024 * 3,
                'tooLarge' => '上传失败！请上传小于3M的文件！',
                'on'=>'auctionUpdate'
            ),
            // @todo Please remove those attributes that should not be searched.
            array('id, rules_id, status, picture, remark, product_category_id, discount_rate, discount_price, sort, limit_num, buy_limit, creat_time, edit_time, description, start_time, end_time, link', 'safe', 'on'=>'search'),

            array('singup_start_time,singup_end_time,start_time, end_time', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd HH:mm:ss', 'on'=>'rulesCreate,rulesUpdate'),
            array('start_time, end_time', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd HH:mm:ss', 'on'=>'auctionCreate,auctionUpdate'),
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
            'id' => '编号',
            'category_id' => '活动类型',
            'name' => '活动名称',
            'status' => '活动状态',
            'picture' => '活动图片',
            'remark' => '活动备注',
            'date_period' => '时间范围',
            'product_category_id' => '参加商品类别',
            'discount_rate' => '商品打折',
            'discount_price' => '限定价格',
            'gift' => '红包消费支持比例',
            'sort' => '活动排序',
            'limit_num' => '活动商品限制参与数',
            'buy_limit' => 'ID限制购买数量',
            'creat_time' => '创建时间',
            'edit_time' => '修改时间',
            'description' => '活动说明与协议',
            'creat_user' => '创建者',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'date' => '活动日期',
            'time' => '活动时间',
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
            'start_activity' => '开启活动',
            'stop_activity' => '强制结束',
            'singup_start_time' => '报名开始时间',
            'singup_end_time' => '报名截止时间',
            'allow_singup' => '允许报名',
            'seller'=>'单店商品限报数'
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
        $criteria->compare('rules_id',$this->rules_id);
        $criteria->compare('status',$this->status);
        $criteria->compare('picture',$this->picture,true);
        $criteria->compare('remark',$this->remark,true);
        $criteria->compare('product_category_id',$this->product_category_id,true);
        $criteria->compare('discount_rate',$this->discount_rate,true);
        $criteria->compare('discount_price',$this->discount_price,true);
        $criteria->compare('sort',$this->sort);
        $criteria->compare('limit_num',$this->limit_num);
        $criteria->compare('buy_limit',$this->buy_limit);
        $criteria->compare('creat_time',$this->creat_time,true);
        $criteria->compare('edit_time',$this->edit_time,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('start_time',$this->start_time,true);
        $criteria->compare('end_time',$this->end_time,true);
        $criteria->compare('link',$this->link,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
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
     *  添加拍卖活动内容
     * @param $postArray 活动的相关内容
     *
     */
    public function createAuctionRules($postArray=array()){
        if(empty($postArray)) return false;

        $postArray = self::filterString($postArray);
        $dateStart = substr($postArray['start_time'], 0, 10);
        $dateEnd   = substr($postArray['end_time'], 0, 10);
        $startTime = substr($postArray['start_time'], 11);
        $endTime   = substr($postArray['end_time'], 11);
        $creatUser = Yii::app()->user->name;
        $creatTime = date('Y-m-d H:i:s');
        $editTime  = $creatTime;

            if($postArray['sort']<=0) $postArray['sort'] = 99999;
            $main = array(
                'category_id' => $postArray['category_id'],
                'name' => $postArray['name'],
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'creat_user' => $creatUser,
            );
            Yii::app()->db->createCommand()->insert('{{seckill_rules_main}}', $main);

            $id  = Yii::app()->db->getLastInsertID();
            $setting = array(
                'picture' => $postArray['picture'],
                'rules_id' => $id,
                'status' => $postArray['status'],
                'remark' => $postArray['remark'],
                'sort' => $postArray['sort'],
                'creat_time' => $creatTime,
                'edit_time' => $editTime,
                'description' => $postArray['description'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'allow_singup' => $postArray['allow_singup']
            );
            Yii::app()->db->createCommand()->insert('{{seckill_rules_seting}}', $setting);
            $settingId  = Yii::app()->db->getLastInsertID();
            //name status remark start_time end_time description

        return $settingId ? $settingId : false;
    }
    /**
     *  添加活动内容
     * @param $postArray 活动的相关内容
     *
     */
    public function createRules($postArray=array()){
        if(empty($postArray)) return false;

        $postArray = self::filterString($postArray);
        $dateStart = substr($postArray['start_time'], 0, 10);
        $dateEnd   = substr($postArray['end_time'], 0, 10);
        $startTime = substr($postArray['start_time'], 11);
        $endTime   = substr($postArray['end_time'], 11);
        $creatUser = Yii::app()->user->name;
        $pcId      = implode(',',array_filter($postArray['product_category_id']));
        //$rate      = isset($postArray['discount_rate']) ? number_format($postArray['discount_rate'],1,'.','') : number_format($postArray['gift'],2,'.','');
        $rate      = isset($postArray['discount_rate']) ? sprintf('%0.1f',$postArray['discount_rate']) : sprintf('%0.2f',$postArray['gift']);
        $price     = isset($postArray['discount_price']) ? sprintf('%0.2f',$postArray['discount_price']) : 0;
        $creatTime = date('Y-m-d H:i:s');
        $editTime  = $creatTime;

        $rate      = $postArray['category_id']==1 ? $rate : $rate*10;
        if($postArray['category_id'] == self::SECKILL_CATEGORY_THREE){//秒杀活动没有排序,只入gw_seckill_rules_seting表
            $startTime = $postArray['start_time'];
            $endTime   = $postArray['end_time'];

            $setting = array(
                'rules_id' => $postArray['rules_id'],
                'status' => $postArray['status'],
                'picture' => $postArray['picture'],
                'remark' => '',
                'product_category_id' => $pcId,
                'discount_rate' => $rate,
                'discount_price' => $price,
                'sort' => 0,
                'limit_num' => $postArray['limit_num'],
                'buy_limit' => $postArray['buy_limit'],
                'seller' => $postArray['seller'],
                'creat_time' => $creatTime,
                'edit_time' => $editTime,
                'description' => $postArray['description'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'link' => $postArray['link'],
                'allow_singup' => $postArray['allow_singup']
            );
            Yii::app()->db->createCommand()->insert('{{seckill_rules_seting}}', $setting);

            $main = array('category_id' => $postArray['category_id']);
            if($postArray['banner1']){ $main['banner1'] = $postArray['banner1']; }
            if($postArray['banner2']){ $main['banner2'] = $postArray['banner2']; }
            if($postArray['banner3']){ $main['banner3'] = $postArray['banner3']; }
            if($postArray['banner4']){ $main['banner4'] = $postArray['banner4']; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_main}}', $main, 'id=:id', array(':id' =>$postArray['rules_id']));

        }else{//红包活动和应节性活动
            if($postArray['sort']<=0) $postArray['sort'] = 99999;
            //$rate  = number_format($rate,1);
            //$price = number_format($price, 1, '.', '');

            $main = array(
                'category_id' => $postArray['category_id'],
                'name' => $postArray['name'],
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'creat_user' => $creatUser,
                'banner1' => $postArray['banner1'],
                'banner2' => $postArray['banner2'],
                'banner3' => $postArray['banner3'],
                'banner4' => $postArray['banner4'],
                'singup_start_time' => $postArray['singup_start_time'],
                'singup_end_time' => $postArray['singup_end_time']
            );
            Yii::app()->db->createCommand()->insert('{{seckill_rules_main}}', $main);

            $id  = Yii::app()->db->getLastInsertID();
            $setting = array(
                'rules_id' => $id,
                'status' => $postArray['status'],
                'picture' => $postArray['picture'],
                'remark' => $postArray['remark'],
                'product_category_id' => $pcId,
                'discount_rate' => $rate,
                'discount_price' => $price,
                'sort' => $postArray['sort'],
                'limit_num' => $postArray['limit_num'],
                'buy_limit' => $postArray['buy_limit'],
                'seller' => $postArray['seller'],
                'creat_time' => $creatTime,
                'edit_time' => $editTime,
                'description' => $postArray['description'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'link' => $postArray['link'],
                'allow_singup' => $postArray['allow_singup']
            );
            Yii::app()->db->createCommand()->insert('{{seckill_rules_seting}}', $setting);
        }
        return true;
    }

    /**
     *  修改活动内容
     * @param $postArray 活动的相关内容
     *
     */
    public function updateAuctionRules($postArray=array()){
        if(empty($postArray)) return false;

        $postArray = self::filterString($postArray);
        $creatUser = Yii::app()->user->name;
        $editTime  = date('Y-m-d H:i:s');
        $dateStart = $dateEnd = $startTime = $endTime = '';
        /*$data = Yii::app()->db->createCommand()
            ->select('goods_id,auction_end_time')
            ->from('{{seckill_auction_price}}')
            ->where('rules_setting_id=:rules_setting_id', array(':rules_setting_id' => $postArray['rules_seting_id']))
            ->queryAll();

        $intEndTime=strtotime($postArray['end_time']);
        for($i=0;$i<count($data);$i++){
            if($intEndTime>$data[$i]['auction_end_time']){
                $count=Yii::app()->db->createCommand()->update('{{seckill_auction_price}}',array('auction_end_time'=>$intEndTime), "rules_setting_id=:rules_setting_id and goods_id =:goods_id", array(':rules_setting_id'=>$postArray['rules_seting_id'],':goods_id' => $data[$i]['goods_id']));
            }
        }*/
        $intEndTime=strtotime($postArray['end_time']);
        Yii::app()->db->createCommand()->update('{{seckill_auction_price}}',array('auction_end_time'=>$intEndTime), "rules_setting_id=:rules_setting_id", array(':rules_setting_id'=>$postArray['rules_seting_id']));

        if(isset($postArray['start_time'])){
            $dateStart = substr($postArray['start_time'], 0, 10);
            $startTime = substr($postArray['start_time'], 11);
        }

        if(isset($postArray['end_time'])){
            $dateEnd   = substr($postArray['end_time'], 0, 10);
            $endTime   = substr($postArray['end_time'], 11);
        }

            if($postArray['sort']<=0) $postArray['sort'] = 99999;

            $main = array('name' => $postArray['name'],
            );



            if($dateStart){ $main['date_start'] = $dateStart; }
            if($dateEnd){ $main['date_end'] = $dateEnd; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_main}}', $main, 'id=:id', array(':id' =>$postArray['rules_id']));
            $update = array('remark' => $postArray['remark'],
                'sort' => $postArray['sort'],
                'edit_time' => $editTime,
                'description' => $postArray['description'],
            );
            if($startTime){ $update['start_time'] = $startTime; }
            if($endTime){ $update['end_time'] = $endTime; }
            if($postArray['picture']){ $update['picture'] = $postArray['picture']; }
            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', $update, 'id=:id', array(':id' =>$postArray['rules_seting_id']));


        return true;
    }









    /**
     *  修改活动内容
     * @param $postArray 活动的相关内容
     *
     */
    public function updateRules($postArray=array()){
        if(empty($postArray)) return false;

        $postArray = self::filterString($postArray);
        $creatUser = Yii::app()->user->name;
        //$rate      = isset($postArray['discount_rate']) ? number_format($postArray['discount_rate'],1,'.','') : number_format($postArray['gift'],2,'.','');
        //$price     = isset($postArray['discount_price']) ? $postArray['discount_price'] : 0;
        $editTime  = date('Y-m-d H:i:s');

        //$rate  = $postArray['category_id']==1 ? $rate : $rate*10;
        //$rate  = number_format($rate,1);
        //$price = number_format($price,1,'.','');

        $dateStart = $dateEnd = $startTime = $endTime = '';
        if(isset($postArray['start_time'])){
            $dateStart = substr($postArray['start_time'], 0, 10);
            $startTime = substr($postArray['start_time'], 11);
        }

        if(isset($postArray['end_time'])){
            $dateEnd   = substr($postArray['end_time'], 0, 10);
            $endTime   = substr($postArray['end_time'], 11);
        }

        if($postArray['category_id'] == self::SECKILL_CATEGORY_THREE){//秒杀活动没有排序,只更新gw_seckill_rules_seting表
            $startTime = isset($postArray['start_time']) ? $postArray['start_time'] : '';
            $endTime   = isset($postArray['end_time']) ? $postArray['end_time'] : '';

            $update = array('limit_num' => $postArray['limit_num'],
                'buy_limit' => $postArray['buy_limit'],
                'edit_time' => $editTime,
                'seller' => $postArray['seller'],
                'description' => $postArray['description'],
                'link' => $postArray['link'],
                'allow_singup' => $postArray['allow_singup'],
            );

            if($postArray['picture']){ $update['picture'] = $postArray['picture']; }
            if($startTime){ $update['start_time'] = $startTime; }
            if($endTime){ $update['end_time'] = $endTime; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', $update, 'id=:id', array(':id' =>$postArray['rules_seting_id']));

            $main = array('category_id' => $postArray['category_id']);
            if($postArray['banner1']){ $main['banner1'] = $postArray['banner1']; }
            if($postArray['banner2']){ $main['banner2'] = $postArray['banner2']; }
            if($postArray['banner3']){ $main['banner3'] = $postArray['banner3']; }
            if($postArray['banner4']){ $main['banner4'] = $postArray['banner4']; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_main}}', $main, 'id=:id', array(':id' =>$postArray['rules_id']));

        }else{//红包活动和应节性活动
            if($postArray['sort']<=0) $postArray['sort'] = 99999;

            $main = array('name' => $postArray['name'],
                'singup_start_time' => $postArray['singup_start_time'],
                'singup_end_time' => $postArray['singup_end_time']
            );

            if($dateStart){ $main['date_start'] = $dateStart; }
            if($dateEnd){ $main['date_end'] = $dateEnd; }
            if($postArray['banner1']){ $main['banner1'] = $postArray['banner1']; }
            if($postArray['banner2']){ $main['banner2'] = $postArray['banner2']; }
            if($postArray['banner3']){ $main['banner3'] = $postArray['banner3']; }
            if($postArray['banner4']){ $main['banner4'] = $postArray['banner4']; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_main}}', $main, 'id=:id', array(':id' =>$postArray['rules_id']));

            //红包也取消更新比例
            /*if($postArray['category_id']==1){
                $rate = number_format($postArray['gift'], 1);
                $isup = ",`discount_rate`='$rate'";
            }else{
                $isup = '';
            }*/

            $update = array('remark' => $postArray['remark'],
                'sort' => $postArray['sort'],
                'limit_num' => $postArray['limit_num'],
                'buy_limit' => $postArray['buy_limit'],
                'seller' => $postArray['seller'],
                'edit_time' => $editTime,
                'description' => $postArray['description'],
                'link' => $postArray['link'],
                'allow_singup' => $postArray['allow_singup'],
            );

            if($postArray['picture']){ $update['picture'] = $postArray['picture']; }
            if($startTime){ $update['start_time'] = $startTime; }
            if($endTime){ $update['end_time'] = $endTime; }

            Yii::app()->db->createCommand()->update('{{seckill_rules_seting}}', $update, 'id=:id', array(':id' =>$postArray['rules_seting_id']));
        }

        return true;
    }

    /**
     * 获取具体活动
     * @param integer $rulesSetingId 活动的规则表的ID
     * @return array 返回查询结果
     */
    public static function getRulesById($rulesSetingId = 0){
        $return = array();

        if($rulesSetingId>0){
            $sql = "SELECT rm.category_id,rm.name,rm.date_start,rm.date_end,rm.banner1,rm.banner2,rm.banner3,rm.banner4,rm.singup_start_time,rm.singup_end_time,rs.* "
                . "FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs "
                . "WHERE rm.id=rs.rules_id AND rs.id='$rulesSetingId'";

            $command = Yii::app()->db->createCommand($sql);
            $return  = $command->queryRow();
        }
        return $return;
    }

    /**
     * 获取活动原来的图片,用作删除
     * @param integer $rulesSetingId 活动规则表的id
     * @return array 返回内容数组
     */
    public function getActivityPicture($rulesSetingId){
        $sql = "SELECT rm.banner1,rm.banner2,rm.banner3,rm.banner4,rs.picture FROM {{seckill_rules_main}} rm, {{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";

        return Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId));
    }

    public function getActivityPicture2($rulesSetingId){
        $sql = "SELECT picture FROM {{seckill_rules_seting}}  WHERE id=:id";

        return Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId));
    }

    /**
     * 创建秒杀活动日期
     * @param array $array 待处理数组
     * @return json 返回处理结果
     */
    public function createDate($array = array()){
        $data = array('success'=>false, 'message'=>'数据不完整');
        if(empty($array)) return json_encode ($data);

        //判断名称是否重复
        $sql     = "SELECT id FROM {{seckill_rules_main}} WHERE name=:name AND category_id=:category_id";
        $command = Yii::app()->db->createCommand($sql);
        $result  = $command->queryRow(true,array(':name'=>$array['name'], ':category_id'=>$array['category_id']));
        if($result){
            $data['message'] = '已存在相同的活动名称,请重新输入.';
            echo json_encode ($data);
            exit;
        }

        //判断时间是否重复
        $sql = "SELECT id FROM {{seckill_rules_main}} WHERE category_id=:category_id AND ( `date_start` <= :date_end AND  `date_end` >= :date_start)";
        $command = Yii::app()->db->createCommand($sql);
        $result  = $command->queryRow(true,array(':category_id'=>$array['category_id'], ':date_start'=>$array['date_start'], ':date_end'=>$array['date_end']));
        if($result){
            $data['message'] = '时间已被占用，请重新选择.';
            echo json_encode ($data);
            exit;
        }

        $array['creat_user'] = Yii::app()->user->name;
        Yii::app()->db->createCommand()->insert("{{seckill_rules_main}}",$array);


        $data['success'] = true;
        $data['message'] = '新建活动日期成功.';
        echo json_encode($data);
        exit;
    }

    public static function getAuctionRulesRecord($categoryId=1, $status=0, $rulesId=0){
        $return = NULL;
        $where  = '1';

        $where .= " AND rm.category_id='$categoryId'";

        $where .= $status ? " AND rs.status='$status'" : '';
        $sql    = "SELECT rm.id, rm.name, rm.date_start, rm.date_end,rs.status, rs.start_time, rs.end_time, rs.sort, rs.id AS rules_seting_id "
            . "FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs "
            . "WHERE $where AND  rm.id=rs.rules_id "
            . "ORDER BY rs.sort ASC,rm.date_start DESC";

        $criteria = new CDbCriteria();
        $result   = Yii::app()->db->createCommand($sql)->query();
        $pages    = new CPagination($result->rowCount);
        $pages->pageSize = 20;
        $pages->params   = array('category_id'=>$categoryId, 'status'=>$status, 'rules_id'=>$rulesId);
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);

        $return = array('data'=>$result->query(), 'pages'=>$pages);

        return $return;
    }
    /**
     * 获取活动的内容 只含应节性和红包活动 限时秒杀由于有多个时间段,需要另外处理
     * @param integer $categoryId 活动类型id
     * @param integer $status 活动的状态
     * @param integer $rulesId 活动规则主表的id(秒杀活动专用)
     * @return array 返回内容数组
     */
    public static function getRulesRecord($categoryId=1, $status=0, $rulesId=0){
        $return = NULL;
        $where  = '1';

        $where .= " AND rm.category_id='$categoryId'";
        if($categoryId == self::SECKILL_CATEGORY_THREE){
            if($rulesId){
                $where .= $status ? " AND rs.status='$status'" : '';
                $sql  = "SELECT rm.id,rm.category_id,rm.name,rm.date_start,rm.date_end, rs.discount_rate, rs.discount_price, rs.buy_limit,rs.start_time,rs.end_time,rs.id AS rules_seting_id,rs.status,rs.limit_num "
                    . "FROM {{seckill_rules_main}} rm,  {{seckill_rules_seting}} rs "
                    . "WHERE $where AND  rm.id=rs.rules_id AND rs.rules_id='$rulesId'"
                    . "ORDER BY rs.start_time DESC ";
            }else{
                $sql  = "SELECT rm.* "
                    . "FROM {{seckill_rules_main}} rm "
                    . "WHERE $where "
                    . "ORDER BY rm.date_start DESC ";
            }
        }elseif($categoryId == self::SECKILL_CATEGORY_FOUR){
            $where .= $status ? " AND rs.status='$status'" : '';
            $sql    = "SELECT rm.id, rm.name, rm.date_start, rm.date_end,rs.status, rs.start_time, rs.end_time, rs.sort, rs.id AS rules_seting_id "
                . "FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs "
                . "WHERE $where AND  rm.id=rs.rules_id "
                . "ORDER BY rs.sort ASC,rm.date_start DESC";
        }else{
            $where .= $status ? " AND rs.status='$status'" : '';
            $sql    = "SELECT rm.id, rm.name, rm.date_start, rm.date_end, rs.discount_rate, rs.discount_price, rs.limit_num, rs.status, rs.start_time, rs.end_time, rs.sort, rs.id AS rules_seting_id "
                . "FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs "
                . "WHERE $where AND  rm.id=rs.rules_id "
                . "ORDER BY rs.sort ASC,rm.date_start DESC";
        }

        $criteria = new CDbCriteria();
        $result   = Yii::app()->db->createCommand($sql)->query();
        $pages    = new CPagination($result->rowCount);
        $pages->pageSize = 30;
        $pages->params   = array('category_id'=>$categoryId, 'status'=>$status, 'rules_id'=>$rulesId);
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);

        $return = array('data'=>$result->query(), 'pages'=>$pages);

        return $return;
    }

    /**
     * 获取活动对应的商品
     * @param integer $categoryId 活动类别id
     * @param integer $rulesId 活动主表的id
     * @param integer $rulesSetingId 活动规则表id
     * @param integer $productId 商品的id
     * @param string $productName 商品的名称
     * @param string $sellerName 商家的名称
     * @return array 返回数组内容
     */
    public function getRulesProduct($categoryId=1, $rulesId=0, $rulesSetingId=0, $productId=0, $productName='', $sellerName=''){
        $return = array('date'=>'', 'pages'=>'');
        if (!$rulesSetingId) return $return;

        $criteria = new CDbCriteria();
        $where  = "WHERE status=1 AND rules_seting_id=:rules_seting_id";
        $param  = array(':rules_seting_id'=>$rulesSetingId);

        if($productId>0){
            $where .=  " AND product_id=:product_id";
            $param[':product_id'] = $productId;
        }

        if($productName){
            $where .= " AND product_name LIKE '%".self::filterString($productName)."%'";
        }

        if($sellerName){
            $where .=  " AND seller_name LIKE '%".self::filterString($sellerName)."%'";
        }

        $sql    = "SELECT * FROM {{seckill_product_relation}} $where";
        $result   = Yii::app()->db->createCommand($sql)->query($param);

        $pages    = new CPagination($result->rowCount);
        $pages->pageSize = 30; //30;
        $pages->params   = array('category_id'=>$categoryId, 'rules_id'=>$rulesId, 'rules_seting_id'=>$rulesSetingId, 'product_id'=>$productId, 'product_name'=>$productName, 'seller_name'=>$sellerName);
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $result->bindValues($param);

        $return = array('data'=>$result->query(), 'pages'=>$pages);

        return $return;
    }

    /**
     * 获取活动状态
     * @return array 返回状态数组
     */
    public static function getStatusArray($key=''){
        //1未开启 商家可以看到,但前台不展示(用户看不到)
        //2未开始 商家和用户都能看到
        //3正在进行 未开始的活动,到时间后自动转换成正在进行 用户可以购买商品
        //已结束 商家不能再参加该活动 用户也不能享受活动的优惠
        $array = array(1=>'未开启',2=>'未开始',3=>'正在进行',4=>'已结束');

        if($key){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /**
     * 获取具体活动已参加的商品数量
     * @param integer $rulesSetingId 活动的具体ID
     * @return integer 返回查询数量
     */
    public static function getRulesProductNumber($rulesSetingId = 0){

        $sql = "SELECT COUNT(*) AS num FROM {{seckill_product_relation}} WHERE rules_seting_id=:rsid AND status=:status";

        $return  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':rsid'=>$rulesSetingId, ':status'=>self::RELATION_IS_PASS));

        return intval($return['num']);
    }

    /**
     * 获取活动的时间(限时秒杀活动时用到)
     * @param integer $id  活动的id
     * @param integer $type 要处理的类型0为日期1为时间
     * @return string 返回整合后的日期格式
     */
    public static function getRulesTime($id=0, $type=0){
        $return  = '';

        if($type == 1){
            $result = Yii::app()->db->createCommand()
                ->select('start_time,end_time')
                ->from('{{seckill_rules_seting}}')
                ->where('rules_id=:id', array(':id'=>$id))
                ->queryAll();
        }else{
            $result = Yii::app()->db->createCommand()
                ->select('date_start,date_end')
                ->from('{{seckill_rules_main}}')
                ->where('id=:id', array(':id'=>$id))
                ->queryAll();
        }

        $time_array = array();
        if(!empty($result)){
            uasort ( $result ,  'self::compare' );
            $count = count($result)-1;

            if($type){
                foreach($result as $v){
                    $time_array[] = $v['start_time'].'-'.$v['end_time'];
                }
                $arr = array_unique($time_array);
                $return = join('<br/>', $arr);

            }else{
                $return = $result[0]['date_start'].' —— '.$result[$count]['date_end'];
            }

        }

        return $return;
    }

    /**
     * 获取活动的个数
     * @param integer $categoryId 活动类型的id
     * @param integer $rulesId 活动主表的id(秒杀活动)
     * @return integer 返回活动的个数
     */
    public function getActivityNumber($categoryId=1, $rulesId=0){
        if($categoryId==self::SECKILL_CATEGORY_THREE && $rulesId){
            $sql = "SELECT COUNT(id) AS num  FROM {{seckill_rules_seting}} WHERE rules_id=:id AND status=:status";
            $return  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesId, ':status'=>self::ACTIVITY_IS_RUNNING));
        }else{
            $sql = "SELECT COUNT(rm.id) AS num  FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND category_id=:id AND rs.status=:status";
            $return  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$categoryId, ':status'=>self::ACTIVITY_IS_RUNNING));
        }

        return intval($return['num']);
    }

    /**
     * 获取活动名称 活动商品数 活动商家数
     * @param integer $rulesSetingId 活动规则表的id
     * @param integer $productId 商品的编号id
     * @return array 返回数组
     */
    public function getTitleNumber($rulesSetingId=0){
        $return = array();

        if($rulesSetingId){
            //活动的相关信息
            $sql     = "SELECT rm.name,rm.category_id,rs.start_time,rs.end_time FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs WHERE rm.id=rs.rules_id AND rs.id=:id";
            $result1 = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId));

            //计算商家个数
            $sql     = "SELECT COUNT(DISTINCT(seller_id)) AS seller FROM {{seckill_product_relation}} WHERE rules_seting_id=:id AND status=:status";
            $result2 = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId, ':status'=>self::RELATION_IS_PASS));

            //计算商品个数
            $sql     = "SELECT COUNT(product_id) AS product FROM {{seckill_product_relation}} WHERE rules_seting_id=:id AND status=:status";
            $result3 = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId, ':status'=>self::RELATION_IS_PASS));

            $return  = array_merge($result1, $result2, $result3);
        }
        return $return;
    }

    /**
     * 获取商品的库存和价格
     * @param integer $rulesSetingId 活动规则表id
     * @param integer $productId 商品的编号id
     * @return array 返回数组
     *
     */
    public function getPriceStock($rulesSetingId=0, $productId=0){
        $return = array();

        if($rulesSetingId>0 && $productId>0){
            $sql = "SELECT rm.category_id,rm.name,rm.date_start,rm.date_end,rs.start_time,rs.end_time,rs.discount_rate,rs.discount_price,rs.status "
                . "FROM {{seckill_rules_main}} rm,{{seckill_rules_seting}} rs "
                . "WHERE rm.id=rs.rules_id AND rs.id=:id";
            $seting  = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$rulesSetingId));

            $sql = "SELECT price,stock FROM {{goods}} WHERE id=:id";
            $product = Yii::app()->db->createCommand($sql)->queryRow(true, array(':id'=>$productId));

            //判断是否在活动期内,如果是则返回活动期价格,如果不是则返回原价
            if($seting['status'] != 4){
                $time      = time();
                $startTime = strtotime($seting['date_start'].' '.$seting['start_time']);
                $endTime   =  strtotime($seting['date_end'].' '.$seting['end_time']);

                if($time>$endTime){//活动已结束
                    $return = $product;
                }else{//未开始或正在进行
                    if($seting['discount_rate']>0){
                        if($seting['category_id']==1){
                            //echo $product['price'];
                            $price = bcmul(bcdiv((100-$seting['discount_rate']),100,2),$product['price'],2);//number_format( ((100-$seting['discount_rate'])/100)*$product['price'], 1 );
                        }else{
                            $price = bcmul(bcdiv($seting['discount_rate'],100,2),$product['price'],2);
                        }

                    }else{
                        $price = $seting['discount_price'];
                    }
                    $return = array('price'=>$price, 'stock'=>$product['stock']);
                }

            }else{//活动已结束
                $return = $product;
            }
        }
        return $return;
    }

    /**
     * 获取活动的主表信息
     * @param integer $id 活动主表的id
     * @return array 返回活动主表信息
     */
    public function getRulesMain($id=0){
        if(!$id) return array();

        $return = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{seckill_rules_main}}')
                ->where('id=:id', array(':id'=>$id))
                ->queryRow();

        return $return;
    }

    /**
     * 删除相关的活动和时间
     * @param integer $id 活动规则的id
     */
    public function deleteRules($id){
        $id = intval($id);
        //目前不允许删除
        exit();
    }

    /**
     * 更新前台缓存
     * @return bool
     *  @param type $id  活动的规则设置表id
*/
    public function updateCache($id=0){
        if($id>0){
            Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_BANNER)->delete(ActivityData::CACHE_FESTIVE_DETAIL_BANNER.$id);
            Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS)->delete(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS.$id);
            Yii::app()->db->createCommand("DELETE FROM {{seckill_order_cache}} WHERE setting_id='$id'")->execute();
            ActivityData::cleanCache($id);
        }else{
            Tool::cache(ActivityData::CACHE_FESTIVE_ACTIVITY_NOBEGIN)->delete(ActivityData::CACHE_FESTIVE_ACTIVITY_NOBEGIN);
            Tool::cache(ActivityData::CACHE_FESTIVE_ACTIVITY_GOING)->delete(ActivityData::CACHE_FESTIVE_ACTIVITY_GOING);

            Tool::cache(ActivityData::CACHE_FESTIVE_ACTIVITY_OVER_ALL)->delete(ActivityData::CACHE_FESTIVE_ACTIVITY_OVER_ALL);
            Tool::cache(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL)->delete(ActivityData::CACHE_ACTIVITY_PRODUCT_ALL);
            Tool::cache(ActivityData::CACHE_ACTIVITY_CONFIG)->delete(ActivityData::CACHE_ACTIVITY_CONFIG);

            Tool::cache(ActivityData::CACHE_ACTIVITY_EXPIRE_CONFIG)->delete(ActivityData::CACHE_ACTIVITY_EXPIRE_CONFIG);
            Tool::cache(ActivityData::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL)->delete(ActivityData::CACHE_ACTIVITY_SECKILL_PRODUCT_ALL);
            Tool::cache(ActivityData::CACHE_ACTIVITY_GOODS)->delete(ActivityData::CACHE_ACTIVITY_GOODS);
        }
    }

    /**
     * 数组对比排序函数
     * @param type $a
     * @param type $b
     * @return int
     *
     */
    public static function  compare ( $a ,  $b ) {
        if ( $a  ==  $b ) {
            return  0 ;
        }
        return ( $a  <  $b ) ? -1 : 1 ;
    }

    /**
     * 过滤SQL注入和script
     * @param string $string 传入处理数组/字符串
     * @return array 返回处理后的数组/字符串
     */
    public static function filterString($string = ''){

        if(is_array($string)){
            $return = array();
            foreach($string as $k=>$v){
                if(is_array($v)){
                    $return[$k] = $v;
                }else{
                    $return[$k] = addslashes(htmlspecialchars($v,  ENT_QUOTES));
                }
            }
        }else{
            $return = addslashes(htmlspecialchars($string,  ENT_QUOTES));
        }

        return $return;
    }

    /**
     * 字符串截取函数
     * @param string $string 要截取的字符串
     * @param integer $length 要截取的长度
     * @return string
     */
    public static function  cutstr($string, $length, $dot = '...', $charset='utf-8') {
        if(strlen($string) <= $length) {
            return $string;
        }

        $pre    = chr(1);
        $end    = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

        $strcut = '';
        if(strtolower($charset) == 'utf-8') {

            $n = $tn = $noc = 0;
            while($n < strlen($string)) {

                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }

                if($noc >= $length) {
                    break;
                }

            }
            if($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr($string, 0, $n);

        } else {
            $_length = $length - 1;
            for($i = 0; $i < $length; $i++) {
                if(ord($string[$i]) <= 127) {
                    $strcut .= $string[$i];
                } else if($i < $_length) {
                    $strcut .= $string[$i].$string[++$i];
                }
            }
        }

        $strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

        $pos = strrpos($strcut, chr(1));
        if($pos !== false) {
            $strcut = substr($strcut,0,$pos);
        }
        return $strcut.$dot;
    }
    
    /**
     * 导表搜索 。。
     * @param type $id
     */
    public function ExportSearch($id){
        if(is_numeric($id)){
            $criteria = new CDbCriteria();
            $criteria->select = 't.discount_rate,t.discount_price,t.id,r.product_name,r.product_id,r.category_id';
            $criteria->join = 'LEFT JOIN {{seckill_product_relation}} r ON r.rules_seting_id = t.id ';
            $criteria->compare('t.id',$id);
            $criteria->compare('r.product_name', $this->product_name, true);
            $criteria->compare('r.seller_name', $this->seller_name, true);
            $criteria->compare('r.product_id', $this->product_id);
            $page = array();
            if($this->isExport){
                $page['pageSize'] = $this->exportLimit;
            }

            return new CActiveDataProvider($this,array(
                'criteria'=>$criteria,
                'pagination'=>$page,
            ));
        }
        return false;
    }

    /**
     *根据rules_setting_id获取活动结束时间
     *@param type $id
     */




}