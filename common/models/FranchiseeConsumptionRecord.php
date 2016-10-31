<?php

/**
 * This is the model class for table "{{franchisee_consumption_record}}".
 *
 * The followings are the available columns in table '{{franchisee_consumption_record}}':
 * @property string $id
 * @property string $franchisee_id
 * @property string $member_id
 * @property integer $record_type
 * @property integer $status
 * @property integer $is_distributed
 * @property string $spend_money
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $distribute_money
 * @property string $create_time
 * @property string $remark
 * @property integer $machine_id
 * @property string $symbol
 * @property string $base_price
 */
class FranchiseeConsumptionRecord extends CActiveRecord {

    public $franchisee_name, $franchisee_code, $start_time, $end_time, $franchisee_mobile, $franchisee_province_id, $franchisee_city_id, $franchisee_district_id,$goods_name,$advertTitle,$advertId;
    public $gai_number, $mobile;
    public $data_style;  //查看类型（0=>全部，1=>重复）
    public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel起始
    public $exportLimit = 5000; //导出excel长度

    const IS_DISTRIBUTED_NO = 0;//未分配
    const IS_DISTRIBUTED_YES = 1;//已分配

    const IS_CHECKED_NO = 0;//未运行对账程序
    const IS_CHECKED_YES = 1;//已运行对账程序

    const STATUS_NOTCHECK = 0;  //未对账
    const STATUS_CHECKED = 1;  //已对账
    const STATUS_REBACK = 2;  //已撤销

    const HANDLE_CHECK = 0;   //手动对账
    const AUTO_CHECK = 1;   //自动对账
    
    const RECORD_TYPE_OTHER = 1;   //其他
    const RECORD_TYPE_POINT = 2;   //盖网通消费
    const RECORD_TYPE_PHONE = 3;	//掌柜消费
    const RECORD_TYPE_VENDING = 4;	//售货机消费
    const RECORD_TYPE_POS = 5; //收银机消费
    const PAY_TYPE_INTEGRAL = 1; //消费类型 普通余额消费
    const PAY_TYPE_UM = 2;       //UM联动支付
    const PAY_TYPE_TL = 3;       //通联支付

    /**
     * 设置数据库，如果场景是 DbCommand::DB 则使用从库
     * @return mixed
     */
    public function getDbConnection() {
        if($this->getScenario()==DbCommand::DB){
            return Yii::app()->db1;
        }else{
            return Yii::app()->db;
        }
    }
    
    public static function getAutoStatus($key = null) {
        $data = array(
            self::HANDLE_CHECK => Yii::t('franchiseeConsumptionRecord', '手动对账'),
            self::AUTO_CHECK => Yii::t('franchiseeConsumptionRecord', '自动对账'),
        );
        return $key === null ? $data : $data[$key];
    }

    //查看类型

    const DATA_STYLE_ALL = 0;    //全部
    const DATA_STYLE_REPEAT = 1;  //重复

    public static function getCheckStatus($key = null) {
        $data = array(
            '' => Yii::t('franchiseeConsumptionRecord', '全部'),
            self::STATUS_CHECKED => Yii::t('franchiseeConsumptionRecord', '已对账'),
            self::STATUS_NOTCHECK => Yii::t('franchiseeConsumptionRecord', '未对账'),
            self::STATUS_REBACK => Yii::t('franchiseeConsumptionRecord', '已撤销'),
        );
        return $key === null ? $data : $data[$key];
    }

    public static function getRecordType($key = null) {
        $data = array(
            '' => Yii::t('franchiseeConsumptionRecord', '全部'),
            self::RECORD_TYPE_OTHER => Yii::t('franchiseeConsumptionRecord', '其他'),
            self::RECORD_TYPE_POINT => Yii::t('franchiseeConsumptionRecord', '盖网通消费'),
            self::RECORD_TYPE_PHONE => Yii::t('franchiseeConsumptionRecord', '掌柜消费'),
            self::RECORD_TYPE_VENDING => Yii::t('franchiseeConsumptionRecord', '售货机消费'),
            self::RECORD_TYPE_POS => Yii::t('franchiseeConsumptionRecord', '收银机消费'),
        );
        return $key === null ? $data : $data[$key];
    }

    //获取查看类型
    public static function getLookStyle($key = NULL) {
        $data = array(
            self::DATA_STYLE_ALL => Yii::t('franchiseeConsumptionRecord', '全部'),
            self::DATA_STYLE_REPEAT => Yii::t('franchiseeConsumptionRecord', '重复'),
        );
        return $key === NULL ? $data : $data[$key];
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{franchisee_consumption_record}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('franchisee_id, member_id, status, is_distributed, spend_money, gai_discount, member_discount, distribute_money, create_time, remark, machine_id, base_price', 'required'),
            array('record_type, status, is_distributed, gai_discount, member_discount, machine_id', 'numerical', 'integerOnly' => true),
            array('franchisee_id, member_id, create_time', 'length', 'max' => 11),
            array('spend_money, distribute_money, base_price', 'length', 'max' => 10),
            array('remark,start_time,end_time', 'length', 'max' => 255),
            array('symbol,gai_number', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('franchisee_name,franchisee_code,start_time,end_time,mobile,franchisee_mobile,franchisee_province_id,franchisee_city_id,franchisee_district_id,status,gai_number', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '主键id',
            'status' => '对账状态',
        	'record_type'=>'消费类型',
            'spend_money' => '消费金额',
            'gai_discount' => '盖网折扣',
            'gai_number' => '会员编号',
            'member_discount' => '会员折扣',
            'distribute_money' => '分配金额',
            'member_id' => '消费会员',
            'franchisee_name' => '加盟商名称',
            'franchisee_code' => '加盟商编号',
            'start_time' => '账单时间',
            'franchisee_mobile' => '加盟商电话',
            'franchisee_province_id' => '加盟商所在地区',
            'create_time' => '账单时间',
            'data_style' => '查看类型',
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
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id,t.status,t.gai_discount,t.member_discount,t.create_time,t.spend_money,t.distribute_money,t.remark,t.is_auto,t.symbol,t.entered_money';
        $criteria->select .= ",franchisee.name as franchisee_name,franchisee.code as franchisee_code";
        $criteria->select .= ",member.gai_number,member.mobile";
        $criteria->join .= " inner join {{franchisee}} as franchisee on franchisee.id=t.franchisee_id";
        $criteria->join .= " inner join {{member}} as member on member.id=t.member_id";

        $reback_ids = IntegralOfflineNew::getRebackData("", array(FranchiseeConsumptionRecordRepeal::STATUS_APPLY,FranchiseeConsumptionRecordRepeal::STATUS_AUDITI), FALSE);
        $Consumption_ids = IntegralOfflineNew::getConsumptionData("", array(FranchiseeConsumptionRecordConfirm::STATUS_APPLY,FranchiseeConsumptionRecordConfirm::STATUS_AUDITI), FALSE);
        $rids = empty($reback_ids) ? "" : $reback_ids;
        $cids = empty($Consumption_ids) ? "" : $Consumption_ids;
        if (!empty($rids)) {
            $criteria->addCondition("t.id not in (" . $rids . ")");
        }
        if (!empty($cids)) {
            $criteria->addCondition("t.id not in (" . $cids . ")");
        }

        $criteria->compare('member.gai_number', $this->gai_number, true);
        $criteria->compare('franchisee.name', $this->franchisee_name, true);
        $criteria->compare('franchisee.code', $this->franchisee_code);
        $criteria->compare('franchisee.mobile', $this->franchisee_mobile);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.record_type', $this->record_type);
        $criteria->compare('franchisee.province_id', $this->franchisee_province_id);
        $criteria->compare('franchisee.city_id', $this->franchisee_city_id);
        $criteria->compare('franchisee.district_id', $this->franchisee_district_id);
        if ($this->start_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($this->start_time));
        }
        if ($this->end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($this->end_time)));
        }
//        $criteria->addCondition("t.spend_money <> 0");
        $criteria->order = 't.id desc';

        /*if ($this->data_style) {  //如果要查询重复数据
            $sql = "select GROUP_CONCAT(id) as ids from " . self::tableName() . " group by member_id,machine_id,spend_money having count(*) > 1";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $ids = "";
            foreach ($result as $key => $val) {
                $ids.= $val['ids'] . ",";
            }
            $ids = substr($ids, 0, -1);
            if (!empty($ids)) {
                $criteria->addCondition("t.id in ($ids)");
                $criteria->order = 't.member_id desc,t.machine_id desc,t.spend_money desc';
            }
        }*/

        $pagination = array(
            'pageSize' => 50
        );

        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
        ));
    }

    public function searchList() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.status,gai_discount,member_discount,create_time,spend_money,distribute_money,remark,symbol';
        $criteria->with = array(
            'member' => array('select' => 'gai_number,mobile')
        );

        $criteria->compare('t.machine_id', $this->machine_id);
        $criteria->compare('t.franchisee_id', $this->franchisee_id);
        $criteria->compare('member.gai_number', $this->gai_number, true);

        if ($this->start_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($this->start_time));
        }
        if ($this->end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($this->end_time) + 86400));
        }
        $criteria->order = 't.create_time desc';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            ),
        ));
    }

    /**
     * 会员中心--企业管理--线下交易详情
     * @author lc
     */
    public function searchListOffline() {
        $franChiseeTb = Franchisee::model()->tableName();
        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.franchisee_id', $this->franchisee_id);
//        $id =array(0=>1,1=>1299);
//        $criteria->addInCondition('t.franchisee_id',$id);
        $criteria->join = "LEFT JOIN " . $franChiseeTb . " f ON f.id = t.franchisee_id";
        $criteria->compare('t.status', $this->status);
        if ($this->start_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($this->start_time));
        }
        if ($this->end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($this->end_time) + 86400));
        }
        $criteria->compare('f.name', $this->remark, true);
        $criteria->order = 't.create_time desc';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeConsumptionRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 加盟商批量对账,获取对账列表
     * @param string $ids   传入加盟商消费记录表的id，如1,2,3,4
     */
    public static function batchReconciliation($ids) {
        $tn = self::model()->tableName(); //加盟商消费记录表
        $criteria = new CDbCriteria;
        $criteria->select = 'franchisee_id,gai_discount,member_discount,create_time,spend_money,distribute_money';
        $criteria->with = array(
            'franchisee' => array('select' => 'name,code,mobile', 'with' => array(
                    'province' => array('select' => 'name'),
                    'city' => array('select' => 'name'),
                    'district' => array('select' => 'name'),
                )),
            'member' => array('select' => 'gai_number')
        );
        $criteria->addCondition('t.status=' . self::STATUS_NOTCHECK);
        $criteria->addInCondition('t.id', $ids);
        $criteria->order = 't.create_time,t.id';
        $models = self::model()->findAll($criteria);
        $records = array();
        foreach ($models as $model) {
            if (!isset($records[$model->franchisee_id])) {
                $records[$model->franchisee_id] = array(
                    'franchisee_name' => $model->franchisee->name,
                    'franchisee_code' => $model->franchisee->code,
                    'franchisee_mobile' => $model->franchisee->mobile,
                    'franchisee_province_name' => $model->franchisee->province->name,
                    'franchisee_city_name' => $model->franchisee->city->name,
                    'franchisee_district_name' => $model->franchisee->district->name,
                );
            }
            $records[$model->franchisee_id]['children'][] = array(
                'id' => $model->id,
                'gai_number' => !empty($model->member->gai_number) ? $model->member->gai_number : '',
                'gai_discount' => $model->gai_discount,
                'member_discount' => $model->member_discount,
                'create_time' => $model->create_time,
                'spend_money' => $model->spend_money,
                'distribute_money' => $model->distribute_money,
            );
        }
        return $records;
    }

    /**
     * 线下消费自动对账
     * 计算总的消费金额时不计算当前这条记录
     */
    public static function autoRecon($id) {
        $config = Tool::getConfig('check', null);
        $mim_money = isset($config['minMoney']) ? $config['minMoney'] : 1000;
        $total_count = isset($config['totalCount']) ? $config['totalCount'] : 50;
        $days = isset($config['days']) ? $config['days'] : 30;
        $max_money = isset($config['maxMoney']) ? $config['maxMoney'] : 5000;
        $max_ratio = isset($config['maxRatio']) ? $config['maxRatio'] : 5; //这里先写死，待配置文件做好后进行替换

        $model = FranchiseeConsumptionRecord::model()->findByPk($id);
        if($model->record_type!=FranchiseeConsumptionRecord::RECORD_TYPE_PHONE)
        {
            self::saveAutoReconFailMemo($model, '该类型对账暂时不支持');
            return false;
        }
        $end_time = $model->create_time;
        $start_time = strtotime("-$days days", $end_time);
        /**
         * 先判断是否是重复消费(同一个消费者在同一台盖机消费同一个金额)
         */
        if($model->record_type != FranchiseeConsumptionRecord::RECORD_TYPE_VENDING)
        {
            $repeat_end_time = $model->create_time;
            $repeat_time = 600;
            $repeat_start_time = $repeat_end_time - $repeat_time;
            $isRepeat = Yii::app()->db->createCommand("select id from {{franchisee_consumption_record}} where id!=" . $model->id . " and member_id=" . $model->member_id . " and machine_id=" . $model->machine_id . " and spend_money=" . $model->spend_money . " and create_time between $repeat_start_time and $repeat_end_time")
                    ->queryScalar();
    
            $auto_config_info = "(最小金额:" . $mim_money . ",消费次数:" . $total_count . ",天数:" . $days . ",最大金额:" . $max_money . ",最大比例:" . $max_ratio . ",重复时间:" . $repeat_time . ")";
    
            if ($isRepeat) {
                $auto_check_fail = "重复消费,没有进行自动对账!" . $auto_config_info;
                self::saveAutoReconFailMemo($model, $auto_check_fail);
                return false;
            }
        }
        //验证该盖机总共的消费次数（没有区分消费是否对账）
        $sqlCount = "select count(*) from " . FranchiseeConsumptionRecord::model()->tableName() . " where machine_id = " . $model->machine_id;
        $count = Yii::app()->db->createCommand($sqlCount)->queryScalar();
        if ($count <= $total_count) {  //如果没有超过设定的消费次数，就进行消费金额最小值比较
            //验证本次单笔消费金额是否小于最小金额
            if ($model->spend_money < $mim_money) {
                $rs = IntegralOfflineNew::consumeRecons($id, self::AUTO_CHECK);
                if ($rs !== true) {
//					$reason = self::checkFailAutoRecon($id);
                    $reason = "";
                    $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费金额" . $model->spend_money . ",符合自动对账需求,进行自动对账,但对账失败before!" . $auto_config_info . "。" . $reason;
                    self::saveAutoReconFailMemo($model, $auto_check_fail);
                    return false;
                }
                $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费金额" . $model->spend_money . ",符合自动对账需求,进行自动对账,对账成功before!" . $auto_config_info;
                self::saveAutoReconFailMemo($model, $auto_check_fail);
                return true;
            }
        }

        if ($model->spend_money > $max_money) {
            $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费,本次消费金额大于最大金额" . $max_money . ",没有进行自动对账!" . $auto_config_info;
            self::saveAutoReconFailMemo($model, $auto_check_fail);
            return false;
        }
        $member_id = $model->member_id;

        $franchisee_member_id = $model->franchisee->member_id;

        $total_amount = 0;  //商家的总金额

        $store_member_id = $model->franchisee->member->id;
        $order_table = Order::model()->tableName();
        $store_ids = array();
        if ($store_member_id) {
            $stores = Store::model()->findAllByAttributes(array('member_id' => $store_member_id));
            if ($stores) {
                //计算该商家订单总额
                foreach ($stores as $store) {
                    $online_amount = Yii::app()->db->createCommand()->select('sum(original_price) as sum_price')->from($order_table)->where('store_id=' . $store->id . ' and status=' . Order::STATUS_COMPLETE . ' and create_time between ' . $start_time . ' and ' . $end_time)->queryScalar();
                    $total_amount += $online_amount;
                    $store_ids[] = $store->id;
                }
            }
        }


        //计算线下商家的总金额
        $franchisee_models = Franchisee::model()->findAll('member_id=:member_id', array('member_id' => $franchisee_member_id));
        $franchisee_ids = array();
        foreach ($franchisee_models as $franchisee_model) {
            $franchisee_ids[] = $franchisee_model->id;
        }
        $tn = FranchiseeConsumptionRecord::model()->tableName();
        $franchisee_id = implode(',', $franchisee_ids);
        $offline_amount = Yii::app()->db->createCommand()->select('sum(spend_money) as sum_price')->from($tn)->where('franchisee_id in (' . $franchisee_id . ') and create_time between ' . $start_time . ' and ' . $end_time . ' and id != ' . $id)->queryScalar();
        $total_amount += $offline_amount;

        $consume_amount = 0;  //消费者的总消费额
        if (!empty($store_ids)) {
            $store_ids = implode(',', $store_ids);
            $online_consume_amount = Yii::app()->db->createCommand()->select('sum(original_price) as sum_price')->from($order_table)->where('member_id=' . $member_id . ' and store_id in ( ' . $store_ids . ') and status=' . Order::STATUS_COMPLETE . ' and create_time between ' . $start_time . ' and ' . $end_time)->queryScalar();
            $consume_amount += $online_consume_amount;
        }
        $offline_consume_amount = Yii::app()->db->createCommand()->select('sum(spend_money) as sum_price')->from($tn)->where('member_id=' . $member_id . ' and franchisee_id in (' . $franchisee_id . ') and create_time between ' . $start_time . ' and ' . $end_time . ' and id != ' . $id)->queryScalar();
        $consume_amount += $offline_consume_amount;

        if ($total_amount != 0 && $consume_amount / $total_amount > $max_ratio) {
            $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费,会员在" . $days . "天内在商家消费比例大于最大比例" . $max_ratio . ",没有进行自动对账!" . $auto_config_info;
            self::saveAutoReconFailMemo($model, $auto_check_fail);
            return false;
        }
        $rs = IntegralOfflineNew::consumeRecons($id, self::AUTO_CHECK);
        if ($rs !== true) {
//			$reason = self::checkFailAutoRecon($id);
            $reason = "";
            $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费金额" . $model->spend_money . ",符合自动对账需求,进行自动对账,但对账失败end!" . $auto_config_info . "。" . $reason;
            self::saveAutoReconFailMemo($model, $auto_check_fail);
            return false;
        }
        $auto_check_fail = "本次是第" . $count . "次在盖机{" . $model->machine_id . "}消费金额" . $model->spend_money . ",符合自动对账需求,进行自动对账,对账成功end!" . $auto_config_info;
        self::saveAutoReconFailMemo($model, $auto_check_fail);
        return true;
    }

    //保存自动对账失败原因
    public static function saveAutoReconFailMemo($model, $fail_reson) {
        FranchiseeConsumptionRecord::model()->updateByPk($model->id, array('auto_check_fail' => $fail_reson));
    }

    //检测自动对账失败原因
    public static function checkFailAutoRecon($record_id) {
        $datas = IntegralOfflineNew::getDataById($record_id);   //获取数据集

        $region_table = Region::model()->tableName();
        $reason = '';

        if (empty($datas)) {
            if (!empty($datas['errors'])) {
                $reason.= implode("<br/>", $datas['errors']) . "。";
            } else {
                $reason.= "数据不存在或者经过过滤后不存在。";
            }
        } else {
            $data = $datas['data'];
            $i = 0;
            if ($data['is_distributed'] == 1) {
                $i++;
                $reason.= "$i：数据已对账。";
            }
            if ($data['franchisee_member_id'] == '') {
                $i++;
                $reason.= "$i：加盟商所属会员不存在。";
            }
            if ($data['enterprise_id'] == '') {
                $i++;
                $reason.= "$i：加盟商对应的企业会员不存在。";
            }

            $area = Yii::app()->db->createCommand()->select('area')->from($region_table)->where('id = ' . $data['province_id'])->queryScalar();
            if ($area == 0) {
                $i++;
                $reason.= "$i：加盟商所属区域没有指定南北盖网通。";
            }

            $member_04 = Yii::app()->db->createCommand("select 1 from {{member}} where pid=" . $data['member_id'] . " and role=4")->queryScalar();
            if (!$member_04) {
                $i++;
                $reason.= "$i：消费会员没有04帐号。";
            }

            $remember_04 = Yii::app()->db->createCommand("select 1 from {{member}} where pid=" . $data['referrals_id'] . " and role=4")->queryRow();
            if (empty($remember_04)) {
                $member_referral = Yii::app()->db->createCommand("select id,gai_number,pid from {{member}} where id=" . $data['referrals_id'])->queryRow();
                $remember_04 = Yii::app()->db->createCommand("select 1 from {{member}} where pid=" . $member_referral['pid'] . " and role=4")->queryScalar();

                if (!$remember_04) {
                    $i++;
                    $reason.= "$i：消费会员推荐人没有04帐号。";
                }
            }

            $machine_member_04 = Yii::app()->db->createCommand("select 1 from {{member}} where pid=" . $data['intro_member_id'] . " and role=4")->queryScalar();
            if (!$machine_member_04) {
                $i++;
                $reason.= "$i：盖机推荐者没有04帐号。";
            }

            $sql = "select t.id,pm.id as member_id,pm.username,pm.gai_number,pm.type_id 
		    	from {{franchisee_consumption_record}} t 
		    	left join {{franchisee}} f on f.id = t.franchisee_id
		    	left join {{member}} m on m.id = f.member_id
		    	left join {{member}} pm on pm.id = m.pid
		    	where t.member_id = " . $data['member_id'] . "
		    	and t.id <> $record_id
		    	order by t.id desc limit 1";
            $lastFranchisee_data = Yii::app()->db->createCommand($sql)->queryRow();

            if ($lastFranchisee_data['member_id']) {
                $last_member_04 = Yii::app()->db->createCommand("select 1 from {{member}} where pid=" . $lastFranchisee_data['member_id'] . " and role=4")->queryScalar();

                if (!$last_member_04) {
                    $i++;
                    $reason.= "$i：最后一次消费加盟商没有04帐号。";
                }
            }
        }

        return $reason == '' ? '其它原因' : $reason;
    }

    public static function autoReconPost($rid) {
        $url = Yii::app()->createAbsoluteUrl('sync/autoRecon', array('rid' => $rid));
        $info = parse_url($url);
        $fp = fsockopen($info['host'], 80, $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $get_string = $info['path'] . '?' . $info['query'];
            $out = "GET $get_string HTTP/1.1\r\n";
            $out .= "Host: " . $info['host'] . "\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
//		    while (!feof($fp)) {
//		        echo fgets($fp, 128);
//		    }
            fclose($fp);
        }
    }

    /*     * ***扎帐脚本运行begin**** */

    /**
     * 扎帐脚本运行
     * @author lc
     */
    public static $config;   //新积分规则的配置文件
    public static $configOld;  //旧的积分规则
    public static $member_type_rate;  //会员转积分的比例
    public static $agentConfig;  //代理分配的配置文件
    public static $agentConfigOld;  //代理分配的配置文件
    public static $logfile = 'runtime/offline.log';

    const CHANGET_TIME = 1395235613;

    /**
     * 返回备注
     */
    public static function getContent($content, $data) {
        foreach ($data as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }

    /**
     * 获取积分分配的配置文件
     */
    public static function getConfig($time, $key = null) {
        if ($time >= self::CHANGET_TIME) {
            if (self::$config !== null) {
                return $key === null ? self::$config : self::$config[$key];
            }
            self::$config = Tool::getConfig($name = 'allocation');
//            $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'allocation.config.inc';
//            self::$config = unserialize(base64_decode(file_get_contents($file)));
        } else {
            if (self::$configOld !== null) {
                return $key === null ? self::$configOld : self::$configOld[$key];
            }
            self::$configOld = array(
                'gaiIncome' => '50',
                'offConsume' => '50',
                'offRef' => '15',
                'offAgent' => '20',
                'offGai' => '4',
                'offFlexible' => '4',
                'offWeightAverage' => '5',
                'offRefMachine' => '2',
                'offMachineIncome' => '30',
            );
        }

        self::$member_type_rate = MemberType::fileCache();
        ;

        if ($time >= self::CHANGET_TIME) {
            return $key === null ? self::$config : self::$config[$key];
        } else {
            return $key === null ? self::$configOld : self::$configOld[$key];
        }
    }

    /**
     * 获取代理分配值
     */
    public static function getAgentConfig($time, $key = null) {
        if ($time >= self::CHANGET_TIME) {
            if (self::$agentConfig !== null) {
                return $key === null ? self::$agentConfig : self::$agentConfig[$key];
            }
             self::$agentConfig = Tool::getConfig($name = 'agentdist');
//            $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'agentdist.config.inc';
//            self::$agentConfig = unserialize(base64_decode(file_get_contents($file)));
            return $key === null ? self::$agentConfig : self::$agentConfig[$key];
        } else {
            if (self::$agentConfigOld !== null) {
                return $key === null ? self::$agentConfigOld : self::$agentConfigOld[$key];
            }
            self::$agentConfigOld = array(
                'province' => '40',
                'city' => '37',
                'district' => '34',
            );
            return $key === null ? self::$agentConfigOld : self::$agentConfigOld[$key];
        }
    }

    public static function autotaskingOne($id, $sourceData = array()) {
        $tn = '{{franchisee_consumption_record}}';
        $time = Yii::app()->db->createCommand()->select('create_time')->from($tn)->where('id = ' . $id)->queryScalar();
        $accountFlowTable = AccountFlow::currentTableName($time);
        $transaction = Yii::app()->db->beginTransaction();
        try {
            self::autoTaskOne($id, $accountFlowTable, $sourceData);
//			Yii::app()->db->createCommand()->update('{{account_balance}}',array('debit_today_amount'=>100),'id=22');
//			Yii::app()->db->createCommand()->update('{{account_balance}}',array('debit_today_amount'=>200),'id=22');
//			throw new ErrorException('4654678', 400); 
//    		if (!DebitCredit::checkBalance($sourceData)) {
//               throw new Exception('DebitCredit Error!', '009');
//            }
            $transaction->commit();
            echo 'success' . "\n";
        } catch (Exception $e) {
            $transaction->rollBack();

//			if ($e->getCode() == '009') {
//                echo $e->getMessage() . " | Code: {$sourceData['id']} - Scene: 线下";
//                $msg = "线下订单id：{$id}，错误信息：{$e->getMessage()}，错误行号：{$e->getLine()} \n";
//		        file_put_contents(self::$logfile, $msg, FILE_APPEND);  
//				die;
//            }
        }
    }

    public static function autoTaskOne($id, $accountFlowTable, $sourceData) {
        $tn = '{{franchisee_consumption_record}}';
        $member_table = '{{member}}';
        $machine_table = 'gatetong_140321.gt_machine';
        $franchisee_table = '{{franchisee}}';
        $enterprise_table = '{{enterprise}}';
        $commont_account_table = CommonAccount::model()->tableName(); //公共账户表
        $data = Yii::app()->db->createCommand()
                ->select('t.id,t.distribute_config,t.serial_number,t.franchisee_id,t.member_id,t.machine_id,t.record_type,t.spend_money,t.gai_discount,t.member_discount,t.distribute_money,t.create_time,t.is_distributed,t.status,m.gai_number,m.username,m.type_id,m.account_expense_cash,m.account_expense_nocash,m.mobile,m.referrals_id,r.username as referrals_username,r.gai_number as referrals_gai_number,r.type_id as referrals_type_id,r.account_expense_cash as referrals_account_expense_cash,r.account_expense_nocash as referrals_account_expense_nocash,r.mobile as referrals_mobile,f.member_id as franchisee_member_id,f.name as franchisee_name,f.province_id,f.city_id,f.district_id,f.street,fm.gai_number as franchisee_gai_number,fm.mobile as franchisee_mobile,mam.id as intro_member_id,ma.name as machine_name,mam.username as machine_intro_username,mam.gai_number as machine_intro_gai_number,mam.type_id as machine_intro_type_id,mit.id as enterprise_id,mit.name as enterprise_name')
                ->from($tn . ' t')
                ->leftJoin($member_table . ' m', 't.member_id=m.id')
                ->leftJoin($member_table . ' r', 'm.referrals_id=r.id')
                ->leftJoin($machine_table . ' ma', 'ma.id=t.machine_id')
                ->leftJoin($member_table . ' mam', 'mam.gai_number=ma.intro_member_id')
                ->leftJoin($franchisee_table . ' f', 't.franchisee_id=f.id')
                ->leftJoin($member_table . ' fm', 'fm.id=f.member_id')
                ->leftJoin($enterprise_table . ' mit', 'mit.member_id=f.member_id')
                ->where('t.id = ' . $id)
                ->queryRow();
        if ($data) {
            if ($data['franchisee_member_id'] && $data['enterprise_id']) {
                //加盟商存在才执行
                self::offlineConsume($data, $accountFlowTable, $sourceData);
                self::offlineDistribute($data, $accountFlowTable, $sourceData);
            } else {
                FranchiseeConsumptionRecord::model()->deleteByPk($data['id']);  //删掉异常的消费记录
//				if($data['franchisee_member_id'] == '' && $data['enterprise_id'] == '')
//				{
//					$msg = '错误id：'.$id.'||错误内容：加盟商和企业会员不存在'."\n";
//					file_put_contents(self::$logfile, $msg, FILE_APPEND);
//					throw new ErrorException('加盟商和企业会员不存在', 400);
//				}
//				elseif ($data['franchisee_member_id'] == '')
//				{
//					$msg = '错误id：'.$id.'||错误内容：加盟商不存在'."\n";
//					file_put_contents(self::$logfile, $msg, FILE_APPEND);
//					throw new ErrorException('加盟商不存在', 400);
//				}
//				elseif ($data['enterprise_id'] == '')
//				{
//					$msg = '错误id：'.$id.'||错误内容：企业会员不存在'."\n";
//					file_put_contents(self::$logfile, $msg, FILE_APPEND);
//					throw new ErrorException('企业会员不存在', 400);
//				}
            }
        }
    }

    /**
     * 模拟线下消费
     */
    public static function offlineConsume($data, $accountFlowTable, $sourceData) {
        $time = $data['create_time'];
        $tn = '{{franchisee_consumption_record}}';
        $regionTable = Region::model()->tableName();
        $accountBalanceTable = AccountBalance::model()->tableName();
        $wealthTable = Wealth::model()->tableName();
        //创建南北盖网通消费公共账户
        $area = Yii::app()->db->createCommand()->select('area')->from($regionTable)->where('id=' . $data['province_id'])->queryScalar();
        if ($area == Region::AREA_NORTH) {
            $virtualCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_NORTH_MACHINE);
            $distributeCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_NORTH_MACHINE_DISTRIBUTE);
        } else {
            $virtualCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_SOUTH_MACHINE);
            $distributeCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_SOUTH_MACHINE_DISTRIBUTE);
        }

        $updateData = array();
        if ($data['serial_number'] == '') {
            $code = 'AL' . $data['create_time'] . rand(1000, 9999);
            $data['serial_number'] = AccountFlow::generateSerialNumber($code);
            $updateData['serial_number'] = $code;
        }
        if ($data['distribute_config'] == '') {
            $config = self::getConfig($time);
            $agentConfig = self::getAgentConfig($time);
            $configJson = CJSON::encode(array(
                        'allocation' => $config,
                        'agentDist' => $agentConfig,
            ));
            $updateData['distribute_config'] = $configJson;
        }
        if (!empty($updateData)) {
            Yii::app()->db->createCommand()->update($tn, $updateData, 'id=' . $data['id']);
        }


        /**
         * 1、消费者扣款,消费的钱进入盖网通消费公共账户
         */
        //当消费的钱大于余额，记录日志
        $member_table = '{{member}}';
        $memberData = Yii::app()->db->createCommand()->select('account_expense_cash,account_expense_nocash')->from($member_table)->where('id=' . $data['member_id'])->queryRow();
        $allConsumeMoney = $memberData['account_expense_cash'] + $memberData['account_expense_nocash'];
//    	if($allConsumeMoney<$data['spend_money'])
//		{
//			$msg = '消费金额（'.$data['spend_money'].'）大于当前余额（'.$allConsumeMoney.'），会员id为:'.$data['member_id'].';记录id:'.$data['id']."\n";
//			file_put_contents(self::$logfile, $msg, FILE_APPEND);
//		}
        //消费者扣款
        $memberBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $data['member_id'],
                    'gai_number' => $data['gai_number'],
                    'name' => $data['username'],
                    'owner_type' => AccountFlow::OWNER_MEMBER
        ));
        $newMemberBalance = AccountBalance::updateAccountBalance($memberBalance, $data['spend_money'], AccountBalance::OFFLINE_TYPE_DEDUCT);
        self::getConfig($time, 'gaiIncome') / 100;
        $consumeScore = $data['spend_money'] / self::$member_type_rate[$data['type_id']];
        $consumeScore = IntegralOfflineNew::getNumberFormat($consumeScore);
        $remark = IntegralOfflineNew::getContent(IntegralOfflineNew::CONSUMPTION_MEMBER_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $consumeScore
        ));

        //插入旧的日志表
        $wealthData = array(
            'owner' => AccountFlow::OWNER_MEMBER,
            'member_id' => $data['member_id'],
            'gai_number' => $data['gai_number'],
            'type_id' => AccountFlow::TYPE_GAI,
            'money' => $data['spend_money'],
            'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
            'target_id' => $data['id'],
            'content' => $remark,
            'create_time' => $time,
            'ip' => Tool::getIP(),
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);

        //消费者插入记录
        $accountFlow = array(
            'account_id' => $data['member_id'],
            'gai_number' => $data['gai_number'],
            'account_name' => $data['username'],
            'debit_amount' => $data['spend_money'],
            'create_time' => $time,
            'debit_previous_amount_cash' => $memberBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $memberBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newMemberBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newMemberBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $memberBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $memberBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newMemberBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newMemberBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $memberBalance['debit_today_amount'],
            'credit_previous_amount' => $memberBalance['today_amount'],
            'debit_current_amount' => $newMemberBalance['debit_today_amount'],
            'credit_current_amount' => $newMemberBalance['today_amount'],
            'debit_previous_amount_frezee' => $memberBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $memberBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newMemberBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newMemberBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_RECHARGE_PAY,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_MEMBER,
            'income_type' => AccountFlow::TYPE_GAI,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $remark,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlow);

        //虚拟账号插入数据
        $store_cash = $data['spend_money'] - $data['distribute_money'];
        $virtualBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $virtualCommonAccount['id'],
                    'name' => $virtualCommonAccount['name'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $newVirtualBalance = AccountBalance::updateAccountBalance($virtualBalance, $store_cash, AccountBalance::OFFLINE_TYPE_DEDUCT);
        $accountFlowVirtual = array(
            'account_id' => $newVirtualBalance['account_id'],
            'account_name' => $newVirtualBalance['name'],
            'credit_amount' => $store_cash,
            'create_time' => $time,
            'debit_previous_amount_cash' => $virtualBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $virtualBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newVirtualBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newVirtualBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $virtualBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $virtualBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newVirtualBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newVirtualBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $virtualBalance['debit_today_amount'],
            'credit_previous_amount' => $virtualBalance['today_amount'],
            'debit_current_amount' => $newVirtualBalance['debit_today_amount'],
            'credit_current_amount' => $newVirtualBalance['today_amount'],
            'debit_previous_amount_frezee' => $virtualBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $virtualBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newVirtualBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newVirtualBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_RECHARGE_PAY,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $remark,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);

        //向分配总账户插入数据
        $distributeBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $distributeCommonAccount['id'],
                    'name' => $distributeCommonAccount['name'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $newDistributeBalance = AccountBalance::updateAccountBalance($distributeBalance, $data['distribute_money'], AccountBalance::OFFLINE_TYPE_DEDUCT);
        $accountFlowVirtual = array(
            'account_id' => $newDistributeBalance['account_id'],
            'account_name' => $newDistributeBalance['name'],
            'credit_amount' => $data['distribute_money'],
            'create_time' => $time,
            'debit_previous_amount_cash' => $distributeBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $distributeBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newDistributeBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newDistributeBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $distributeBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $distributeBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newDistributeBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newDistributeBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $distributeBalance['debit_today_amount'],
            'credit_previous_amount' => $distributeBalance['today_amount'],
            'debit_current_amount' => $newDistributeBalance['debit_today_amount'],
            'credit_current_amount' => $newDistributeBalance['today_amount'],
            'debit_previous_amount_frezee' => $distributeBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $distributeBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newDistributeBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newDistributeBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_RECHARGE_PAY,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $remark,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);

//    	DebitCredit::check($sourceData);
    }

    /**
     * 模拟线下分配
     */
    public static function offlineDistribute($data, $accountFlowTable, $sourceData) {
        if ($data['is_distributed'] != 1) {
            return;
        }
        $time = $data['create_time'];
        $regionTable = Region::model()->tableName();
        $accountBalanceTable = AccountBalance::model()->tableName();

        $wealthTable = '{{wealth}}';
        $member_table = '{{member}}';
        $franchisee_table = '{{franchisee}}';
        $ip = Tool::getIP();
        //创建南北盖网通消费公共账户
        $area = Yii::app()->db->createCommand()->select('area')->from($regionTable)->where('id=' . $data['province_id'])->queryScalar();
        if ($area == Region::AREA_NORTH) {
            $virtualCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_NORTH_MACHINE);
            $distributeCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_NORTH_MACHINE_DISTRIBUTE);
        } else {
            $virtualCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_SOUTH_MACHINE);
            $distributeCommonAccount = self::createMachineCommonAccount(CommonAccount::TYPE_SOUTH_MACHINE_DISTRIBUTE);
        }

        /*         * *商家进账begin** */
        //虚拟账号扣款
        $virtualBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $virtualCommonAccount['id'],
                    'name' => $virtualCommonAccount['name'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $enterprise_cash_add = $data['spend_money'] - $data['distribute_money']; //商家增加的钱
        $newVirtualBalance = AccountBalance::updateAccountBalance($virtualBalance, $enterprise_cash_add, AccountBalance::OFFLINE_TYPE_ADD);
        $remark = IntegralOfflineNew::getContent(IntegralOfflineNew::COMPANY_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $data['distribute_money'],
                    $data['gai_discount'], $data['member_discount'], $enterprise_cash_add
        ));
        $accountFlowVirtual = array(
            'account_id' => $newVirtualBalance['account_id'],
            'account_name' => $newVirtualBalance['name'],
            'debit_amount' => $enterprise_cash_add,
            'create_time' => $time,
            'debit_previous_amount_cash' => $virtualBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $virtualBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newVirtualBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newVirtualBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $virtualBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $virtualBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newVirtualBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newVirtualBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $virtualBalance['debit_today_amount'],
            'credit_previous_amount' => $virtualBalance['today_amount'],
            'debit_current_amount' => $newVirtualBalance['debit_today_amount'],
            'credit_current_amount' => $newVirtualBalance['today_amount'],
            'debit_previous_amount_frezee' => $virtualBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $virtualBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newVirtualBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newVirtualBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $remark,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);

        //企业会员加钱
        $storeBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $data['enterprise_id'],
                    'gai_number' => $data['franchisee_gai_number'],
                    'name' => $data['enterprise_name'],
                    'owner_type' => AccountFlow::OWNER_COMPANY_INFO
        ));
        $newStoreBalance = AccountBalance::updateAccountBalance($storeBalance, $enterprise_cash_add, AccountBalance::OFFLINE_TYPE_ADD);
        $storeAccountFlow = array(
            'account_id' => $newStoreBalance['account_id'],
            'gai_number' => $newStoreBalance['gai_number'],
            'account_name' => $newStoreBalance['name'],
            'credit_amount' => $enterprise_cash_add,
            'create_time' => $time,
            'debit_previous_amount_cash' => $storeBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $storeBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newStoreBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newStoreBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $storeBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $storeBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newStoreBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newStoreBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $storeBalance['debit_today_amount'],
            'credit_previous_amount' => $storeBalance['today_amount'],
            'debit_current_amount' => $newStoreBalance['debit_today_amount'],
            'credit_current_amount' => $newStoreBalance['today_amount'],
            'debit_previous_amount_frezee' => $storeBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $storeBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newStoreBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newStoreBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMPANY_INFO,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $remark,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $storeAccountFlow);

        //插入旧的日志表
        $wealthData = array(
            'owner' => AccountFlow::OWNER_COMPANY_INFO,
            'member_id' => $data['franchisee_member_id'],
            'gai_number' => $data['franchisee_name'],
            'type_id' => AccountFlow::TYPE_CASH,
            'money' => $enterprise_cash_add,
            'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
            'target_id' => $data['id'],
            'content' => $remark,
            'create_time' => $time,
            'ip' => $ip,
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        /*         * *商家进账end** */

        /*         * *线下积分分配begin** */
        $gaiIncome = self::getConfig($time, 'gaiIncome') / 100;   //盖网收益率
        $offConsume = self::getConfig($time, 'offConsume') / 100;  //消费者
        $offRef = self::getConfig($time, 'offRef') / 100;    //会员推荐者
        $offAgent = self::getConfig($time, 'offAgent') / 100;   //代理
        $offGai = self::getConfig($time, 'offGai') / 100;    //盖网分配
        $offFlexible = self::getConfig($time, 'offFlexible') / 100;  //机动
        $offWeightAverage = self::getConfig($time, 'offWeightAverage') / 100; //盖网机推荐者
        $offRefMachine = self::getConfig($time, 'offRefMachine') / 100;  //最近一次消费的加盟商
        $commont_account_gw_city_name = '';  //是盖网公共账户的名称
        $commont_account_gw_city_id = self::checkCommonAccount($data['city_id'], CommonAccount::TYPE_GAI, $commont_account_gw_city_name); //市盖网公共账户的id
        /*         * *虚拟账户扣除分配金额begin** */
        $distributeBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $distributeCommonAccount['id'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $newDistributeVirtualBalance = AccountBalance::updateAccountBalance($distributeBalance, $data['distribute_money'], AccountBalance::OFFLINE_TYPE_ADD);
        $accountFlowVirtual = array(
            'account_id' => $newDistributeVirtualBalance['account_id'],
            'account_name' => $newDistributeVirtualBalance['name'],
            'debit_amount' => $data['distribute_money'],
            'create_time' => $time,
            'debit_previous_amount_cash' => $distributeBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $distributeBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newDistributeVirtualBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newDistributeVirtualBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $distributeBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $distributeBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newDistributeVirtualBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newDistributeVirtualBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $distributeBalance['debit_today_amount'],
            'credit_previous_amount' => $distributeBalance['today_amount'],
            'debit_current_amount' => $newDistributeVirtualBalance['debit_today_amount'],
            'credit_current_amount' => $newDistributeVirtualBalance['today_amount'],
            'debit_previous_amount_frezee' => $distributeBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $distributeBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newDistributeVirtualBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newDistributeVirtualBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => '开始积分分配，扣除分配金额',
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);
        /*         * *虚拟账户扣除分配金额end** */

        /*         * *盖网收益begin** */
        $gw_income = $data['distribute_money'] * $gaiIncome;
        $gw_income = IntegralOfflineNew::getNumberFormat($gw_income);
        $distribute_money = $data['distribute_money'] - $gw_income;
        /*         * *盖网收益end** */

        /*         * *消费者begin** */
        $consumer_money = $distribute_money * $offConsume; //正式会员分的钱
        $consumer_integral = $consumer_money / self::$member_type_rate['official'];
        $ratio = self::$member_type_rate['official'];
        if ($data['type_id'] == self::$member_type_rate['defaultType']) {
            $consumer_money = $consumer_integral * self::$member_type_rate['default'];
            $ratio = self::$member_type_rate['default'];
        }
        $consumer_money = IntegralOfflineNew::getNumberFormat($consumer_money);
        $consumer_integral = IntegralOfflineNew::getNumberFormat($consumer_integral);
        $consumer_content = IntegralOfflineNew::getContent(IntegralOfflineNew::CONSUMER_MEMBER_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $consumer_integral
        ));

        $consumerAccountBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $data['member_id'],
                    'gai_number' => $data['gai_number'],
                    'name' => $data['username'],
                    'owner_type' => AccountFlow::OWNER_MEMBER,
        ));
        $newConsumerAccountBalance = AccountBalance::updateAccountBalance($consumerAccountBalance, $consumer_money, AccountBalance::OFFLINE_TYPE_ADD);
        $consumerAccountFlow = array(
            'account_id' => $newConsumerAccountBalance['account_id'],
            'gai_number' => $newConsumerAccountBalance['gai_number'],
            'account_name' => $newConsumerAccountBalance['name'],
            'credit_amount' => $consumer_money,
            'create_time' => $time,
            'debit_previous_amount_cash' => $consumerAccountBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $consumerAccountBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newConsumerAccountBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newConsumerAccountBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $consumerAccountBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $consumerAccountBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newConsumerAccountBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newConsumerAccountBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $consumerAccountBalance['debit_today_amount'],
            'credit_previous_amount' => $consumerAccountBalance['today_amount'],
            'debit_current_amount' => $newConsumerAccountBalance['debit_today_amount'],
            'credit_current_amount' => $newConsumerAccountBalance['today_amount'],
            'debit_previous_amount_frezee' => $consumerAccountBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $consumerAccountBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newConsumerAccountBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newConsumerAccountBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_MEMBER,
            'income_type' => AccountFlow::TYPE_GAI,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $consumer_content,
            'serial_number' => $data['serial_number'],
            'ratio' => $ratio,
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $consumerAccountFlow);
        //插入旧的日志表
        $wealthData = array(
            'owner' => AccountFlow::OWNER_MEMBER,
            'member_id' => $data['member_id'],
            'gai_number' => $data['gai_number'],
            'type_id' => AccountFlow::TYPE_GAI,
            'score' => $consumer_integral,
            'money' => $consumer_money,
            'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
            'target_id' => $data['id'],
            'content' => $consumer_content,
            'create_time' => $time,
            'ip' => $ip,
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        /*         * *消费者end** */
        /*         * *会员推荐者begin** */
        $referrals_money = $distribute_money * $offRef;
        $referrals_money = IntegralOfflineNew::getNumberFormat($referrals_money);
        if ($data['referrals_id']) {
            $referrals_integral = $referrals_money / self::$member_type_rate['official'];
            $ratio = self::$member_type_rate['official'];
            if ($data['referrals_type_id'] == self::$member_type_rate['defaultType']) {
                //如果是消费推荐者
                $referrals_money = $referrals_integral * self::$member_type_rate['default'];
                $ratio = self::$member_type_rate['default'];
            }
            $referrals_money = IntegralOfflineNew::getNumberFormat($referrals_money);
            $referrals_integral = IntegralOfflineNew::getNumberFormat($referrals_integral);
            $referrals_content = self::getContent(IntegralOfflineNew::TUIJIANCUNZAI_MEMBER_CONTENT, array(
                        $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $referrals_integral
            ));

            $referralsAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $data['referrals_id'],
                        'gai_number' => $data['referrals_gai_number'],
                        'name' => $data['referrals_username'],
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newReferralsAccountBalance = AccountBalance::updateAccountBalance($referralsAccountBalance, $referrals_money, AccountBalance::OFFLINE_TYPE_ADD);
            $referralsAccountFlow = array(
                'account_id' => $newReferralsAccountBalance['account_id'],
                'gai_number' => $newReferralsAccountBalance['gai_number'],
                'account_name' => $newReferralsAccountBalance['name'],
                'credit_amount' => $referrals_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $referralsAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $referralsAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newReferralsAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newReferralsAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $referralsAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $referralsAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newReferralsAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newReferralsAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $referralsAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $referralsAccountBalance['today_amount'],
                'debit_current_amount' => $newReferralsAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newReferralsAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $referralsAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $referralsAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newReferralsAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newReferralsAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $data['id'],
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                'remark' => $referrals_content,
                'serial_number' => $data['serial_number'],
                'ratio' => $ratio,
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $referralsAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $data['referrals_id'],
                'gai_number' => $data['referrals_gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $referrals_integral,
                'money' => $referrals_money,
                'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                'target_id' => $data['id'],
                'content' => $referrals_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        } else {
            //会员推荐者不存在--进入盖网市公共账户
            $tuijian_member_content = self::getContent(IntegralOfflineNew::TUIJIAN_MEMBER_CONTENT, array(
                        $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $referrals_money
            ));
            $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $commont_account_gw_city_id,
                        'name' => $commont_account_gw_city_name,
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            ));
            $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $referrals_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
            $cityCommonAccountFlow = array(
                'account_id' => $newCityCommonAccountBalance['account_id'],
                'account_name' => $newCityCommonAccountBalance['name'],
                'credit_amount' => $referrals_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $data['id'],
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                'remark' => $tuijian_member_content,
                'serial_number' => $data['serial_number'],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'member_id' => $commont_account_gw_city_id,
                'gai_number' => $commont_account_gw_city_name,
                'type_id' => AccountFlow::TYPE_CASH,
                'score' => 0,
                'money' => $referrals_money,
                'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                'target_id' => $data['id'],
                'content' => $tuijian_member_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
        /*         * *会员推荐者end** */

        /*         * *代理begin** */
        $agent_money = $distribute_money * $offAgent;  //代理分的钱
        $agent_money = IntegralOfflineNew::getNumberFormat($agent_money);
        self::distributeAgent($agent_money, $data, $accountFlowTable, $area);
        /*         * *代理end** */

        /*         * *盖机推荐者begin** */
        $machine_intro_money = $distribute_money * $offWeightAverage;
        if ($data['machine_intro_type_id']) {
            $machine_intro_integral = $machine_intro_money / self::$member_type_rate[$data['machine_intro_type_id']];
            $machine_intro_money = IntegralOfflineNew::getNumberFormat($machine_intro_money);
            $machine_intro_integral = IntegralOfflineNew::getNumberFormat($machine_intro_integral);
            $machine_intro_content = self::getContent(IntegralOfflineNew::MACHINE_INTRO_CONTENT, array(
                        $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $machine_intro_integral
            ));

            $machineIntroAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $data['intro_member_id'],
                        'gai_number' => $data['machine_intro_gai_number'],
                        'name' => $data['machine_intro_username'],
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newMachineIntroAccountBalance = AccountBalance::updateAccountBalance($machineIntroAccountBalance, $machine_intro_money, AccountBalance::OFFLINE_TYPE_ADD);
            $machineIntroAccountFlow = array(
                'account_id' => $newMachineIntroAccountBalance['account_id'],
                'gai_number' => $newMachineIntroAccountBalance['gai_number'],
                'account_name' => $newMachineIntroAccountBalance['name'],
                'credit_amount' => $machine_intro_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $machineIntroAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $machineIntroAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newMachineIntroAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newMachineIntroAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $machineIntroAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $machineIntroAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newMachineIntroAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newMachineIntroAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $machineIntroAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $machineIntroAccountBalance['today_amount'],
                'debit_current_amount' => $newMachineIntroAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newMachineIntroAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $machineIntroAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $machineIntroAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newMachineIntroAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newMachineIntroAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $data['id'],
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                'remark' => $machine_intro_content,
                'serial_number' => $data['serial_number'],
                'ratio' => self::$member_type_rate[$data['machine_intro_type_id']],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $machineIntroAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $data['intro_member_id'],
                'gai_number' => $data['machine_intro_gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $machine_intro_integral,
                'money' => $machine_intro_money,
                'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                'target_id' => $data['id'],
                'content' => $machine_intro_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        } else {
            //不存在盖机推荐者，进入盖网市公共账户
            $machine_intro_money = IntegralOfflineNew::getNumberFormat($machine_intro_money);
            $machine_intro_no_content = self::getContent(IntegralOfflineNew::MACHINE_INTRO_NO_CONTENT, array(
                        $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $machine_intro_money
            ));

            $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $commont_account_gw_city_id,
                        'name' => $commont_account_gw_city_name,
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            ));
            $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $machine_intro_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
            $cityCommonAccountFlow = array(
                'account_id' => $newCityCommonAccountBalance['account_id'],
                'account_name' => $newCityCommonAccountBalance['name'],
                'credit_amount' => $machine_intro_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $data['id'],
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                'remark' => $machine_intro_no_content,
                'serial_number' => $data['serial_number'],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'member_id' => $commont_account_gw_city_id,
                'gai_number' => $commont_account_gw_city_name,
                'type_id' => AccountFlow::TYPE_CASH,
                'score' => 0,
                'money' => $machine_intro_money,
                'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                'target_id' => $data['id'],
                'content' => $machine_intro_no_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
        /*         * *盖机推荐者end** */

        /*         * *最近一次消费的加盟商begin** */
        $offRefMachine_money = $distribute_money * $offRefMachine;
        $offRefMachine_money = IntegralOfflineNew::getNumberFormat($offRefMachine_money);
        if ($offRefMachine_money) {
            $tn = FranchiseeConsumptionRecord::model()->tableName();
            $offRefMachinefranchisee = Yii::app()->db->createCommand()->select('m.id as member_id,m.username,m.gai_number,m.type_id')->from($tn . ' t')
                            ->leftJoin($franchisee_table . ' f', 'f.id=t.franchisee_id')
                            ->leftJoin($member_table . ' m', 'm.id=f.member_id')
                            ->where('t.member_id=' . $data['member_id'] . ' and  t.id<' . $data['id'])
                            ->order('t.create_time desc')->limit('1')->queryRow();
//			throw new ErrorException('4654678', 400);
            if ($offRefMachinefranchisee && $offRefMachinefranchisee['member_id']) {
                $offRefMachine_integral = $offRefMachine_money / self::$member_type_rate[$offRefMachinefranchisee['type_id']];
                $offRefMachine_integral = IntegralOfflineNew::getNumberFormat($offRefMachine_integral);
                $offRefMachine_content = self::getContent(IntegralOfflineNew::OFFREFMACHINE_CONTENT, array(
                            $data['gai_number'], $data['franchisee_name'], $offRefMachine_integral
                ));

                $offRefMachineBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $offRefMachinefranchisee['member_id'],
                            'gai_number' => $offRefMachinefranchisee['gai_number'],
                            'name' => $offRefMachinefranchisee['username'],
                            'owner_type' => AccountFlow::OWNER_MEMBER,
                ));
                $newOffRefMachineBalance = AccountBalance::updateAccountBalance($offRefMachineBalance, $offRefMachine_money, AccountBalance::OFFLINE_TYPE_ADD);
                $offRefMachineAccountFlow = array(
                    'account_id' => $newOffRefMachineBalance['account_id'],
                    'gai_number' => $newOffRefMachineBalance['gai_number'],
                    'account_name' => $newOffRefMachineBalance['name'],
                    'credit_amount' => $offRefMachine_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $offRefMachineBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $offRefMachineBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newOffRefMachineBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newOffRefMachineBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $offRefMachineBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $offRefMachineBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newOffRefMachineBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newOffRefMachineBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $offRefMachineBalance['debit_today_amount'],
                    'credit_previous_amount' => $offRefMachineBalance['today_amount'],
                    'debit_current_amount' => $newOffRefMachineBalance['debit_today_amount'],
                    'credit_current_amount' => $newOffRefMachineBalance['today_amount'],
                    'debit_previous_amount_frezee' => $offRefMachineBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $offRefMachineBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newOffRefMachineBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newOffRefMachineBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                    'trade_space' => $data['street'],
                    'trade_space_id' => $data['district_id'],
                    'trade_terminal' => $data['machine_id'],
                    'target_id' => $data['id'],
                    'owner_type' => AccountFlow::OWNER_MEMBER,
                    'income_type' => AccountFlow::TYPE_GAI,
                    'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                    'remark' => $offRefMachine_content,
                    'serial_number' => $data['serial_number'],
                    'ratio' => self::$member_type_rate[$offRefMachinefranchisee['type_id']],
                    'area_id' => $area,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $offRefMachineAccountFlow);
                //插入旧的日志
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_MEMBER,
                    'member_id' => $newOffRefMachineBalance['account_id'],
                    'gai_number' => $newOffRefMachineBalance['gai_number'],
                    'type_id' => AccountFlow::TYPE_GAI,
                    'score' => $offRefMachine_integral,
                    'money' => $offRefMachine_money,
                    'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                    'target_id' => $data['id'],
                    'content' => $offRefMachine_content,
                    'create_time' => $time,
                    'ip' => $ip,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            } else {
                //不存在最近一次消费的加盟商，则进入市公共账户
                $offRefMachine_no_content = self::getContent(IntegralOfflineNew::OFFREFMACHINE_NO_CONTENT, array(
                            $data['gai_number'], $data['franchisee_name'], $offRefMachine_money
                ));

                $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $commont_account_gw_city_id,
                            'name' => $commont_account_gw_city_name,
                            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                ));
                $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $offRefMachine_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
                $cityCommonAccountFlow = array(
                    'account_id' => $newCityCommonAccountBalance['account_id'],
                    'account_name' => $newCityCommonAccountBalance['name'],
                    'credit_amount' => $offRefMachine_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                    'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                    'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                    'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                    'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                    'trade_space' => $data['street'],
                    'trade_space_id' => $data['district_id'],
                    'trade_terminal' => $data['machine_id'],
                    'target_id' => $data['id'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'income_type' => AccountFlow::TYPE_CASH,
                    'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                    'remark' => $offRefMachine_no_content,
                    'serial_number' => $data['serial_number'],
                    'area_id' => $area,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
                //插入旧的日志
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'member_id' => $commont_account_gw_city_id,
                    'gai_number' => $commont_account_gw_city_name,
                    'type_id' => AccountFlow::TYPE_CASH,
                    'score' => 0,
                    'money' => $offRefMachine_money,
                    'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                    'target_id' => $data['id'],
                    'content' => $offRefMachine_no_content,
                    'create_time' => $time,
                    'ip' => $ip,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            }
        }

        /*         * *最近一次消费的加盟商end** */

        /*         * *机动begin** */
        $flexible_money = $distribute_money * $offFlexible;
        $flexible_money = IntegralOfflineNew::getNumberFormat($flexible_money);
        $commont_account_jidong_name = '';
        $commont_account_jidong_id = self::checkCommonAccount($data['city_id'], CommonAccount::TYPE_MOVE, $commont_account_jidong_name); //市机动公共账户的id
        $jidong_content = self::getContent(IntegralOfflineNew::JIDONG_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $flexible_money
        ));
        $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $commont_account_jidong_id,
                    'name' => $commont_account_jidong_name,
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
        ));
        $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $flexible_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
        $cityCommonAccountFlow = array(
            'account_id' => $newCityCommonAccountBalance['account_id'],
            'account_name' => $newCityCommonAccountBalance['name'],
            'credit_amount' => $flexible_money,
            'create_time' => $time,
            'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
            'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
            'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
            'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
            'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $jidong_content,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
        //插入旧的日志
        $wealthData = array(
            'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'member_id' => $commont_account_jidong_id,
            'gai_number' => $commont_account_jidong_name,
            'type_id' => AccountFlow::TYPE_CASH,
            'score' => 0,
            'money' => $flexible_money,
            'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
            'target_id' => $data['id'],
            'content' => $jidong_content,
            'create_time' => $time,
            'ip' => $ip,
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        /*         * *机动end** */

        /*         * *盖网公共begin** */
        $gw_fenpei = $data['distribute_money'] - ($consumer_money + $referrals_money + $agent_money + $machine_intro_money + $offRefMachine_money + $flexible_money);
        $gatewang_content = self::getContent(IntegralOfflineNew::GATEWANGFENPEI_CONTENT, array(
                    $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $gw_fenpei
        ));

        $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $commont_account_gw_city_id,
                    'name' => $commont_account_gw_city_name,
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
        ));
        $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $gw_fenpei, AccountBalance::OFFLINE_COMMON_ACOUNT);
        $cityCommonAccountFlow = array(
            'account_id' => $newCityCommonAccountBalance['account_id'],
            'account_name' => $newCityCommonAccountBalance['name'],
            'credit_amount' => $gw_fenpei,
            'create_time' => $time,
            'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
            'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
            'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
            'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
            'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
            'trade_space' => $data['street'],
            'trade_space_id' => $data['district_id'],
            'trade_terminal' => $data['machine_id'],
            'target_id' => $data['id'],
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
            'remark' => $gatewang_content,
            'serial_number' => $data['serial_number'],
            'area_id' => $area,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
        //插入旧的日志
        $wealthData = array(
            'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'member_id' => $commont_account_gw_city_id,
            'gai_number' => $commont_account_gw_city_name,
            'type_id' => AccountFlow::TYPE_CASH,
            'score' => 0,
            'money' => $gw_fenpei,
            'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
            'target_id' => $data['id'],
            'content' => $gatewang_content,
            'create_time' => $time,
            'ip' => $ip,
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        /*         * *盖网公共end** */

        /*         * *线下积分分配end** */
//			Yii::app()->db->createCommond('update 231123 (;')->execeue();
//		DebitCredit::check($sourceData);
    }

    /**
     * 单独对代理进行分配
     */
    public static function distributeAgent($agent_money, $data, $accountFlowTable, $area) {
        if ($agent_money <= 0) {
            return;
        }
        $time = $data['create_time'];
        $wealthTable = '{{wealth}}';
        $commont_account_dist_table = '{{common_account_agent_dist}}';
        $ip = Tool::getIP();
        $agents = IntegralOfflineNew::getAgentsMemberId($data['district_id']);
        $district_account_name = ''; //区代理的名称
        $district_agent_commont_account_id = self::checkCommonAccount($data['district_id'], CommonAccount::TYPE_AGENT, $district_account_name); //区代理公共账户

        $agentConfig_district = self::getAgentConfig($time, 'district');  //区代理的比例
        $agentConfig_city = self::getAgentConfig($time, 'city');    //市代理的比例
        $agentConfig_province = self::getAgentConfig($time, 'province');  //省代理的比例
        $agentConfig_district__real = ($agents['district'] == 0) ? 0 : $agentConfig_district;
        $agentConfig_city__real = ($agents['city'] == 0) ? 0 : $agentConfig_city - $agentConfig_district__real;
        $agentConfig_province__real = ($agents['province'] == 0) ? 0 : $agentConfig_province - ($agentConfig_city__real + $agentConfig_district__real);
        $agent_district_money = $agent_money * $agentConfig_district__real / 100;  //区代理分配的金额
        $agent_city_money = $agent_money * $agentConfig_city__real / 100;    //市代理分配的金额
        $agent_province_money = $agent_money * $agentConfig_province__real / 100;  //省代理分配的金额
        $agent_district_money = IntegralOfflineNew::getNumberFormat($agent_district_money);
        $agent_city_money = IntegralOfflineNew::getNumberFormat($agent_city_money);
        $agent_province_money = IntegralOfflineNew::getNumberFormat($agent_province_money);
        $agent_remainder_money = $agent_money - ($agent_district_money + $agent_city_money + $agent_province_money);  //剩余金额进入区代理商公共账户
        //插入代理分配记录表
        $commont_account_dist_arr = array(
            'common_account_id' => $district_agent_commont_account_id,
            'dist_money' => $agent_money,
            'remainder_money' => $agent_remainder_money,
            'province_id' => $data['province_id'],
            'province_member_id' => $agents['province'],
            'province_money' => $agent_province_money,
            'province_ratio' => $agentConfig_province__real,
            'city_id' => $data['city_id'],
            'city_member_id' => $agents['city'],
            'city_money' => $agent_city_money,
            'city_ratio' => $agentConfig_city__real,
            'district_id' => $data['district_id'],
            'district_member_id' => $agents['district'],
            'district_money' => $agent_district_money,
            'district_ratio' => $agentConfig_district__real,
            'create_time' => $time
        );
        Yii::app()->db->createCommand()->insert($commont_account_dist_table, $commont_account_dist_arr);
        $commont_account_dist_table_insert_id = Yii::app()->db->getLastInsertID();

        if ($agent_remainder_money) {
            $agent_content = self::getContent(IntegralOfflineNew::AGENT_CONTENT, array(
                        $data['gai_number'], $data['franchisee_name'], $data['machine_name'], $data['spend_money'], $agent_remainder_money
            ));
            $agentCommonAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $district_agent_commont_account_id,
                        'name' => $district_account_name,
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            ));
            $newAgentCommonAccountBalance = AccountBalance::updateAccountBalance($agentCommonAccountBalance, $agent_remainder_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
            $agentCommonAccountFlow = array(
                'account_id' => $newAgentCommonAccountBalance['account_id'],
                'account_name' => $newAgentCommonAccountBalance['name'],
                'credit_amount' => $agent_remainder_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $agentCommonAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $agentCommonAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newAgentCommonAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newAgentCommonAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $agentCommonAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $agentCommonAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newAgentCommonAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newAgentCommonAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $agentCommonAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $agentCommonAccountBalance['today_amount'],
                'debit_current_amount' => $newAgentCommonAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newAgentCommonAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $agentCommonAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $agentCommonAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newAgentCommonAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newAgentCommonAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $data['id'],
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_LINE_CONSUME,
                'remark' => $agent_content,
                'serial_number' => $data['serial_number'],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $agentCommonAccountFlow);

            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'member_id' => $district_agent_commont_account_id,
                'gai_number' => $district_account_name,
                'type_id' => AccountFlow::TYPE_CASH,
                'score' => 0,
                'money' => $agent_remainder_money,
                'source_id' => AccountFlow::SOURCE_LINE_CONSUME,
                'target_id' => $data['id'],
                'content' => $agent_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
        if ($agent_district_money) {
            $district_member_integral = $agent_district_money / self::$member_type_rate[$agents['district_type_id']];
            $district_member_integral = IntegralOfflineNew::getNumberFormat($district_member_integral);
            $district_member_dist_content = self::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $district_account_name, $agent_money, $agents['district_name'], $district_member_integral
            ));
            $districtMemberAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $agents['district'],
                        'gai_number' => $agents['district_gai_number'],
                        'name' => $agents['district_username'],
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newDistrictMemberAccountBalance = AccountBalance::updateAccountBalance($districtMemberAccountBalance, $agent_district_money, AccountBalance::OFFLINE_TYPE_ADD, 1);
            $districtMemberAccountFlow = array(
                'account_id' => $agents['district'],
                'gai_number' => $agents['district_gai_number'],
                'account_name' => $agents['district_username'],
                'credit_amount' => $agent_district_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $districtMemberAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $districtMemberAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newDistrictMemberAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newDistrictMemberAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $districtMemberAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $districtMemberAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newDistrictMemberAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newDistrictMemberAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $districtMemberAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $districtMemberAccountBalance['today_amount'],
                'debit_current_amount' => $newDistrictMemberAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newDistrictMemberAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $districtMemberAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $districtMemberAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newDistrictMemberAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newDistrictMemberAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $commont_account_dist_table_insert_id,
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'remark' => $district_member_dist_content,
                'serial_number' => $data['serial_number'],
                'ratio' => self::$member_type_rate[$agents['district_type_id']],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $districtMemberAccountFlow);

            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $agents['district'],
                'gai_number' => $agents['district_gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $district_member_integral,
                'money' => $agent_district_money,
                'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'target_id' => $commont_account_dist_table_insert_id,
                'content' => $district_member_dist_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
        if ($agent_city_money) {
            $city_member_integral = $agent_city_money / self::$member_type_rate[$agents['city_type_id']];
            $city_member_integral = IntegralOfflineNew::getNumberFormat($city_member_integral);
            $city_member_dist_content = self::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $district_account_name, $agent_money, $agents['city_name'], $city_member_integral
            ));
            $cityMemberAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $agents['city'],
                        'gai_number' => $agents['city_gai_number'],
                        'name' => $agents['city_username'],
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newCityMemberAccountBalance = AccountBalance::updateAccountBalance($cityMemberAccountBalance, $agent_city_money, AccountBalance::OFFLINE_TYPE_ADD, 1);
            $cityMemberAccountFlow = array(
                'account_id' => $agents['city'],
                'gai_number' => $agents['city_gai_number'],
                'account_name' => $agents['city_username'],
                'credit_amount' => $agent_city_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $cityMemberAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $cityMemberAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newCityMemberAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newCityMemberAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $cityMemberAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $cityMemberAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newCityMemberAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newCityMemberAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $cityMemberAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $cityMemberAccountBalance['today_amount'],
                'debit_current_amount' => $newCityMemberAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newCityMemberAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $cityMemberAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $cityMemberAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newCityMemberAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newCityMemberAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $commont_account_dist_table_insert_id,
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'remark' => $city_member_dist_content,
                'serial_number' => $data['serial_number'],
                'ratio' => self::$member_type_rate[$agents['city_type_id']],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $cityMemberAccountFlow);

            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $agents['city'],
                'gai_number' => $agents['city_gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $city_member_integral,
                'money' => $agent_city_money,
                'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'target_id' => $commont_account_dist_table_insert_id,
                'content' => $city_member_dist_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
        if ($agent_province_money) {
            $province_member_integral = $agent_province_money / self::$member_type_rate[$agents['province_type_id']];
            $province_member_integral = IntegralOfflineNew::getNumberFormat($province_member_integral);
            $province_member_dist_content = self::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                        $district_account_name, $agent_money, $agents['province_name'], $province_member_integral
            ));
            $provinceMemberAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $agents['province'],
                        'gai_number' => $agents['province_gai_number'],
                        'name' => $agents['province_username'],
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newProvinceMemberAccountBalance = AccountBalance::updateAccountBalance($provinceMemberAccountBalance, $agent_province_money, AccountBalance::OFFLINE_TYPE_ADD, 1);
            $provinceMemberAccountFlow = array(
                'account_id' => $agents['province'],
                'gai_number' => $agents['province_gai_number'],
                'account_name' => $agents['province_username'],
                'credit_amount' => $agent_province_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $provinceMemberAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $provinceMemberAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newProvinceMemberAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newProvinceMemberAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $provinceMemberAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $provinceMemberAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newProvinceMemberAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newProvinceMemberAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $provinceMemberAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $provinceMemberAccountBalance['today_amount'],
                'debit_current_amount' => $newProvinceMemberAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newProvinceMemberAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $provinceMemberAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $provinceMemberAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newProvinceMemberAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newProvinceMemberAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                'trade_space' => $data['street'],
                'trade_space_id' => $data['district_id'],
                'trade_terminal' => $data['machine_id'],
                'target_id' => $commont_account_dist_table_insert_id,
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'remark' => $province_member_dist_content,
                'serial_number' => $data['serial_number'],
                'ratio' => self::$member_type_rate[$agents['province_type_id']],
                'area_id' => $area,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $provinceMemberAccountFlow);

            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $agents['province'],
                'gai_number' => $agents['province_gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $province_member_integral,
                'money' => $agent_province_money,
                'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                'target_id' => $commont_account_dist_table_insert_id,
                'content' => $province_member_dist_content,
                'create_time' => $time,
                'ip' => $ip,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
        }
    }

    /**
     * 	创建南北盖网通公共账户
     */
    public static function createMachineCommonAccount($type) {
        $rs = IntegralOfflineNew::getGWPublicAcc($type);
        return $rs;
    }

    /**
     * 是否存在公共账户，不存在就创建
     */
    public static function checkCommonAccount($city_id, $type, &$account_name = '') {
        $rs = IntegralOfflineNew::getGWPublicAcc($type, $city_id);
        $id = $rs['id'];
        $account_name = $rs['name'];
        return $id;
    }

    /*     * ***扎帐脚本运行end**** */

    /*
     * 币值转换
     * $money 金额
     * $base_price 换算成人民币的汇率
     * symbol 币种
     */

    public static function conversion($money, $base_price, $symbol) {
        $money = $symbol == MachineProductOrder::HKD ? self::convertHKD($money, $base_price) : $money;
        return $money = IntegralOfflineNew::formatPrice($money, $symbol);
    }

    /**
     * 将人民币转化成港币
     */
    public static function convertHKD($money, $base_price) {
        return $money / $base_price * 100;
    }

}
