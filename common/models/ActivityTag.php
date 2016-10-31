<?php

/**
 * This is the model class for table "{{activity_tag}}".
 *
 * The followings are the available columns in table '{{activity_tag}}':
 * @property string $id
 * @property integer $ratio
 * @property integer $status
 * @property string $create_time
 * @property string $name
 */
class ActivityTag extends CActiveRecord
{
    const STATUS_OFF = 0; //活动暂停
    const STATUS_ON = 1;//活动开启
    
    const CACHE_ACTIVITY_TAG_GOODS = 'ActivityTagOldRedBagGoods';		//旧的红包商品缓存--临时，如果新的活动上线此部分可以不用

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{activity_tag}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ratio, create_time, name', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('ratio','numerical'),
            array('ratio','match','pattern'=>'/^100$|^100\.[0]{1,2}$|^\d{1,2}$|^\d{1,2}\.\d{1,2}$/','message'=>'请输入正确的比例(0.01-100.00)，最多只可以有两位小数！'),
            array('ratio', 'compare', 'compareValue'=>'0', 'operator'=>'>', 'message'=>Yii::t('activityTag', '必须大于0')),
            array('name','unique'),
            array('create_time', 'length', 'max' => 11),
            array('name', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ratio, status, create_time, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键',
            'ratio' => '消费支持比率',
            'status' => '状态',
            'create_time' => '创建时间',
            'name' => '名称',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('ratio', $this->ratio);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ActivityTag the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getTagName()
    {
        $data = self::model()->findAll(array(
            'select' => 'name,id',
            'condition' => 'status=:status',
            'params' => array(':status' => self::STATUS_ON),
        ));
        $arr=array();
        foreach($data as $v){
            $arr[$v['id']]=$v['name'];
        }
        ksort($arr);
        return $arr;
    }


    /**
     * 活动状态
     * @param null $k
     * @return array|null
     */
    public static function getStatus($k = null)
    {
        $arr = array(
            self::STATUS_ON => Yii::t('activity', '活动开启'),
            self::STATUS_OFF => Yii::t('activity', '活动停止'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }


    /**
     * 获取 红包消费起始比例
     * @return intval
     */
    public static function getRatio($id)
    {
        $ratio = Yii::app()->db->createCommand()
            ->select('ratio')
            ->from('{{activity_tag}}')
            ->where('id = :id' ,array(':id'=>$id))
            ->queryScalar();
        return $ratio ? $ratio : 0;
    }

    public static function getName($id){
        $name = Yii::app()->db->createCommand()
            ->select('name')
            ->from('{{activity_tag}}')
            ->where('id = :id' ,array(':id'=>$id))
            ->queryScalar();
        return $name ? $name : ' ';
    }

    /**
     * 获取是否是红包商品
     * @author LC
     */
	public static function getIsRedBagGoods($goodsId=0, $setingId=0)
	{
		$cache   = Tool::cache(self::CACHE_ACTIVITY_TAG_GOODS);
		$data    = $cache->get($goodsId);
		$nowTime = time();
		
		$active  = $setingId>0 ? ActivityData::getActivityRulesSeting($setingId) : array();//取活动缓存
		$status  = $setingId>0 ? ActivityData::getActivityProductRelation($goodsId) : 0;//是否通过审核
		if(empty($data))
		{
			//判断商品是否有参加活动  2015-06-11修改(李文豪)
            /*$data = Yii::app()->db->createCommand()->select('g.id')->from('{{goods}} g')->join('{{activity_tag}} atg', 'atg.id=g.activity_tag_id')
			->join('{{goods_spec}} gs', 'gs.goods_id=g.id')
			->andWhere('g.id = :goodsId', array(':goodsId'=>$goodsId))
			->andWhere('gs.id = :specId', array(':specId' =>$specId))
			->andWhere('g.join_activity = '.Goods::JOIN_ACTIVITY_YES)
			->andWhere('atg.status = '.ActivityTag::STATUS_ON)->queryScalar();*/
            $data = Yii::app()->db->createCommand()->select('g.id')->from('{{goods}} g')
			->andWhere('g.id = :goodsId', array(':goodsId'=>$goodsId))
			->andWhere('g.seckill_seting_id > 0 ')
            ->queryScalar();
			
			
			if(!empty($data) && !empty($active) && strtotime($active['end_dateline'])>=$nowTime && !empty($status) &&$active['category_id']==1){//红包活动才返回true
				//seckill_seting_id有值,并且活动还没过期, 并且商品通过审核
				$data = true;
			}else{
				//当不存在时，说明该商品不是红包商品
				$data = false;
			}
			
			//设置过期时间为活动结束时间
			$diff = !empty($active) ? strtotime($active['end_dateline']) - $nowTime : 300;

			$cache->set($goodsId, $data, $diff>0 ? $diff : 300);	//缓存一天 86400
		}
		
		//如果缓存没及时清掉,则被充判断
		if(!empty($active) && strtotime($active['end_dateline'])<$nowTime){
			$data = false;
		}
		
		return $data;
	}
	
	public static function deleteIsRedBagGoods($goodsId)
	{
		$cache = Tool::cache(self::CACHE_ACTIVITY_TAG_GOODS);
		$cache->delete($goodsId);
	}
	
	public static function deleteCreateRedOrder($memberId, $goodsId)
	{
		$cache = Tool::cache(self::CACHE_ACTIVITY_TAG_GOODS);
		$key = 'checkCreateRedOrder_'.$memberId.'_'.$goodsId;
		$cache->delete($key);
	}
	
	/**
	 * 检测会员手机号码和当天已经购买的个数(在添加购物车和检测订单时调用)
	 * @param unknown $memberId
	 * @param int $goodsId 商品id
	 * @param int $setingId 活动规则id
	 * @author LC
	 */
	public static function checkCreateRedOrder($memberId, $goodsId, $setingId)
	{
		$key = 'checkCreateRedOrder_'.$memberId.'_'.$goodsId;
		$cache = Tool::cache(self::CACHE_ACTIVITY_TAG_GOODS);
		$rs = $cache->get($key); 
		if(empty($rs))
		{
			$rs = array(
					'status' => 1,
					'quantity' => 0,
					'msg' => '',
					'url' => ''
			);
			//判断商品是否是红包商品，只有满足条件才进行相关验证
			if(self::getIsRedBagGoods($goodsId, $setingId)){
				
				if(intval($memberId)<1){//没登录的时候要提示登录
					$rs = array(
							'status' => 3,
							'quantity' => 0,
							'url' => Yii::app()->createAbsoluteUrl('/member/home/login'),
							'msg' => Yii::t('orderFlow', "您还没登录，请登录")."！"//"！\n".Yii::app()->createAbsoluteUrl('/member/home/login')
					);
				}else{//登录后的判断
				
					//先判断会员是否有手机号码
					$member = Member::getMemberCacheById($memberId);
					if(empty($member->mobile))
					{
						$rs['status'] = 2;
						$rs['url'] = Yii::app()->createAbsoluteUrl('/member/member/update');
						$rs['msg'] = Yii::t('orderFlow', '要参加活动，需要到会员中心绑定手机号码')."！";//"！\n".Yii::app()->createAbsoluteUrl('/member/member/update');
					}else{
						
						//存在，说明该商品是红包商品,再判断这个会员之前是否有购买过
						$quantity = Yii::app()->db->createCommand()->select('SUM(og.quantity) AS quantity')->from('{{order}} o')->join('{{order_goods}} og','og.order_id=o.id')
						->andWhere('og.goods_id = :goodsId', array(':goodsId'=>$goodsId))
						->andWhere('o.member_id = :memberId', array(':memberId' => $memberId))
						->andWhere('og.rules_setting_id = :setingId', array(':setingId'=>$setingId))
						->andWhere('o.status != '.Order::STATUS_CLOSE)
						->queryScalar();
						
						if(!empty($quantity))
						{
							$rs['status'] = 0;
							$rs['url'] = '';
							$rs['quantity'] = $quantity;
							$rs['msg'] = Yii::t('orderFlow', '亲，您已经参加了此活动，谢谢参与').'！';
						}
					}
				}
			}
			if($rs['status'] !== 2)
			{
				$cache = Tool::cache(self::CACHE_ACTIVITY_TAG_GOODS);	//需要重新获取，否则会取到错误的缓存
				$cache->set($key, $rs, 300); //数据缓存五分钟
			}
		}
		return $rs;
	}
        
        /**
         * 判断应节性活动是否达到购买数量限制
         * @param integer $memberId
	 * @param integer $goodsId 商品id
	 * @param integer $setingId 活动规则id
	 * @author liwenhao
         */
        public static function checkFestiveActivity($memberId, $goodsId, $setingId){
            
            $memberId = intval($memberId);
            $goodsId  = intval($goodsId);
            $setingId = intval($setingId);
            
            $rs = array(
			'status' => 1,
                        'quantity' => 0,
			'msg' => '',
			'url' => ''
			);
            
            if($memberId < 1){
                $rs = array(
			'status' => 3,
                        'quantity' => 0,
			'msg' => Yii::t('orderFlow', "您还没登录，请登录")."！",
			'url' => Yii::app()->createAbsoluteUrl('/member/home/login')
			);
            }else{
                if( $goodsId>0 && $setingId>0){
                    $quantity = Yii::app()->db->createCommand()->select('SUM(og.quantity) AS quantity')->from('{{order}} o')->join('{{order_goods}} og', 'og.order_id=o.id')
                        ->andWhere('og.goods_id = :goodsId', array(':goodsId' => $goodsId))
                        ->andWhere('o.member_id = :memberId', array(':memberId' => $memberId))
                        ->andWhere('og.rules_setting_id = :setingId', array(':setingId' => $setingId))
                        ->andWhere('o.status != ' . Order::STATUS_CLOSE)
                        ->queryScalar();

                    if (!empty($quantity)) {//之前购买过应节活动商品
                        $rs['quantity'] = $quantity;
                        $rs['status'] = 2;
                        $rs['url'] = '';
                        $rs['msg'] = '';
                    } 
                }
            } 
            return $rs;
        }
}
