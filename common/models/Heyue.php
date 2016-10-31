<?php

/**
 * 合约机号码,套餐
 *
 */
class Heyue extends CActiveRecord
{

    public $haoduan; //号码段
    public $rules; //靓号规则
    public $path; //图片路径
    public $is_lock;

    const LOCK = 1; //已占用
    const NOT_LOCK = 0; //可以用
    const PAY_WAIT = 1; //待支付
    const PAY_OK = 2; //已支付
    const NUMBER_3G = 0; //3g号码
    const NUMBER_4G = 1; //4g号码

    public static function getLock($key = null)
    {
        $arr = array(
            self::LOCK => Yii::t('order', '已占用'),
            self::NOT_LOCK => Yii::t('order', '可以用'),
        );
        return is_null($key) ? $arr : $arr[$key];
    }

    public static $goodsName = array(
        '三星N9009省级合约白色' => '三星 Galaxy Note3 N9009 16G版 电信3G手机（玫瑰金）CDMA2000/GSM 双模双待双通',
        '苹果IP5S16G金色省级合约机' => '苹果（Apple）iPhone 5s 16G版 3G手机（金色）电信版',
        '小米3灰色普通机' => '小米（MI） 小米3 电信3G手机（星空灰） CDMA2000/CDMA',
        '三星S5白色省级合约机' => '三星 Galaxy S5 G9009D 电信3G手机（闪耀白）CDMA2000/GSM 双模双待双通',
        '红米1S灰色普通机' => '小米（MI） 红米1s电信 3G手机（金属灰） CDMA2000/GSM 双模双待',
        '华为P7白色普通机' => '华为 Ascend P7-L09 4G手机（白色）TD-LTE/CDMA2000/GSM 双模双待双通',
        '华为P7白色普通机（省天翼机）' => '华为 Ascend P7-L09 4G手机（白色）TD-LTE/CDMA2000/GSM 双卡双待双通',
        '华为P7黑色普通机（省天翼机）' => '华为 Ascend P7-L09 4G手机（黑色）TD-LTE/CDMA2000/GSM 双卡双待双通',
        '酷派5892白色普通机（省天翼机）' => '酷派 5892-C00 电信4G手机（智尚白）FDD-LTE/CDMA2000',
        '三星S5白色省级合约机' => '三星 Galaxy S5 G9009W 4G手机（白）FDD-LTE/TD-LTE/CDMA2000/GSM 双卡双待双通',
        '三星S5黑色省级合约机' => '三星 Galaxy S5 G9009W 4G手机（黑）FDD-LTE/TD-LTE/CDMA2000/GSM 双卡双待双通',
        '酷派S6白色普通机' => '酷派 S6（9190L） 电信4G手机（智尚白） FDD-LTE/CDMA2000/GSM 双卡双待双通',
        'VIVOX3V白色普通机' => 'vivo X3V 电信4G手机 TDD-LTE/CDMA2000/GSM 双卡双待双通 极光白',
        '三星N7509黑色普通机（省天翼机）' => '三星GALAXY Note 3 Lite（N7509V/电信4G版） 单卡',
        '新乐享套餐59元套餐' => '广州电信4G卡59元套餐（月租低至31元，套餐外话费7折！）',
        '新乐享套餐79元套餐' => '广州电信4G卡79元套餐（月租低至35元，套餐外话费7折！）',
        '新乐享套餐99元套餐' => '广州电信4G卡99元套餐（月租低至49元，套餐外话费7折！）',
    );

    public function tableName()
    {
        return '{{heyue}}';
    }

    public function rules()
    {
        return array(
            array('is_lock', 'numerical', 'integerOnly' => true),
            array('pic', 'required', 'message' => Yii::t('member', '请选择上传图片')),
            array('number, type', 'length', 'max' => 30),
            array('price, hasfee', 'length', 'max' => 12),
            array('member_id, order_id', 'length', 'max' => 11),
            array('id, number, price, hasfee, is_lock, type, member_id, order_id', 'safe', 'on' => 'search'),
            array('rules, number_type, number', 'safe', 'on' => 'searchList'),
        );
    }

    public function relations()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'number' => '号码',
            'price' => '盖网价',
            'hasfee' => '包含话费',
            'is_lock' => '是否被占用',
            'type' => 'Type',
            'member_id' => 'Member',
            'order_id' => 'Order',
        );
    }

    /**
     * 前台选择号段
     * @return \CActiveDataProvider
     */
    public function searchList()
    {
        $criteria = new CDbCriteria;
        //锁定的号码不查询出来
        $criteria->addCondition('create_time < ' . (time() - 15 * 60) . ' AND is_lock = ' . Heyue::NOT_LOCK);
        if ($this->number_type == self::NUMBER_3G)
            $criteria->compare('number_type', self::NUMBER_3G);
        if ($this->number_type == self::NUMBER_4G)
            $criteria->compare('number_type', self::NUMBER_4G);
        if ($this->number == '181' || $this->number == '177' || $this->number == '180')
            $criteria->addCondition('number like "' . $this->number . '%"');
        if ($this->rules == 'CBA')
            $criteria->addCondition("number REGEXP '(987)$|(876)$|(765)$|(654)$|(543)$|(432)$|(321)$|(210)$'");
        if ($this->rules == 'AA')
            $criteria->addCondition("number REGEXP '0{2}$|1{2}$|2{2}$|3{2}$|4{2}$|5{2}$|6{2}$|7{2}$|8{2}$|9{2}$'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
        $criteria->compare('number', $this->number, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('hasfee', $this->hasfee, true);
        $criteria->compare('is_lock', $this->is_lock);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('member_id', $this->member_id, true);
        $criteria->compare('order_id', $this->order_id, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function searchNumber()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.number,t.price,t.hasfee';

        if (Heyue::model()->haoduan == '选择号段') {

        } elseif (Heyue::model()->haoduan == '180') {
            $criteria->addSearchCondition('number', '180');
        } elseif (Heyue::model()->haoduan == '181') {
            $criteria->addSearchCondition('number', '181');
        }
        return new CActiveDataProvider('Heyue', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 16,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Heyue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 合约机订单信息推送
     * @param array $orderDate 订单数据
     * @return mixed
     * @author binbin.liao
     */
    public static function heyueDataTraffic(array $orderDate)
    {
        $orderArray = array();//要返回的订单信息
        //合约订单信息
        $orderDate2 = Yii::app()->db->createCommand()
            ->select('type,name,cardNumber,number,idPicture1,idPicture2,idPicture3')
            ->from('{{heyue}}')
            ->where('order_id=:order_id', array(':order_id' => $orderDate['id']))
            ->queryRow();
        //收货地址信息
        $address = explode(' ', $orderDate['address']);
        //会员信息

        if (empty($orderDate) && empty($orderDate2)) {
            $orderArray['status'] = 2;   //status为2表示不存在该订单
            return $orderArray;
        }
        //发起SOAP请求
        $client = new SoapClient(HEYUE_SERVICE_URL . '/order?wsdl', array(
            'trace' => true,
            'exceptions' => true,
        ));
        //发起请求数据
        $result = $client->create(
            array(
                'username' => HEYUE_USERNAME,//API用户名
                'password' => HEYUE_PASSWORD,//API密码
                //订单基本数据(必填项目)
                'request' => array(
                    'business' => '移动产品', //业务类型
                    'outOrderNo' => $orderDate['code'],//商城的订单号
                    'jobNumber' => '30214001', //揽装工号
                    'expressType' => '电信代发货',//配送方式
                    'customerName' => $orderDate2['name'],//客户名称
                    'customerNumber' => $orderDate['mobile']//客户电话
                ),
                //订单扩展数据
                'properties' => array(
                    array('IDNumber', $orderDate2['cardNumber']),
                    array('IDType', '身份证'),
                    array('promotionTypeName', '标准资费'),
                    array('agreementTypeName', '合约机(存费送机/0元购)'),
                    array('agreementType', '31'),
                    array('handleType','PROD201501273061434'),//话费套餐产品SKU
                    array('handleTypeName', $orderDate2['type']),
                    array('mobilePayType', '代理商打款'),
                    array('payInputMoney', '10000'),
                    array('taocanPayType', '现金交付'),
                    array('province', $address[0]),
                    array('city', $address[1]),
                    array('county', $address[2]),
                    array('receiverAddress', $address[3]),
                    array('concatPerson', $orderDate['consignee']),
                    array('concatTelephone', $orderDate['mobile']),
                    array('sfxyfp', '不需要发票'),
                    array('mainNumberCard', $orderDate2['number']),
                    array('mainCardMobile',$orderDate['goods_name']),
                )
            )
        );
//        Tool::pr($result);
        $status = $result->return->resultCode;
        $orderArray['resultCode'] = $result->return->orderNumber;
        $status == 'SUCCESS' ? $orderArray['status'] = 1 : $orderArray['status'] = 0;

        //如果订单同步成功，则执行同步身份证图片
        if($status == 'SUCCESS'){
            //订单号信息
            $result['code'] = $orderDate['code'];
            $result['resultCode'] = $orderArray['resultCode'];
            //图片信息
            $imgPath['idPicture1'] = $orderDate2['idPicture1'];
            $imgPath['idPicture2'] = $orderDate2['idPicture2'];
            $imgPath['idPicture3'] = $orderDate2['idPicture3'];

            $return = self::_uploadID($result,$imgPath);
            if(!$return['isOk']){
                throw new CHttpException(503,Yii::t('heyueji',$return['msg']));
            }
        }

        return $orderArray;
    }

    /**
     * 合约机订单，把上传的身份证图片同步给合约机分销平台
     * @param $result //订单号信息
     * @param $imgPath //上传身份证图片路径
     * @return mixed
     * @author binbin.liao
     */
    private static function _uploadID($result,$imgPath)
    {
        $status = array();
        $client = new SoapClient(HEYUE_SERVICE_URL . '/order?wsdl');
        $pic1= file_get_contents($imgPath['idPicture1']); //正面照
        $pic2= file_get_contents($imgPath['idPicture2']); //反面照
        $pic3= file_get_contents($imgPath['idPicture3']); //手持照

        $mime1 = Tool::getImageMime($imgPath['idPicture1']);
        $mime2 = Tool::getImageMime($imgPath['idPicture2']);
        $mime3 = Tool::getImageMime($imgPath['idPicture3']);
        $result = $client->upload(
            array(
                'username' => HEYUE_USERNAME,
                'password' => HEYUE_PASSWORD,
                'number'=>$result['resultCode'],//营销平台订单号
                'outOrderNo'=>$result['code'], //内部订单号
                'attachments' => array(
                    array('name'=>'正面照.jpg','type'=>'idPicture1','contentType'=>$mime1,'content'=>$pic1),
                    array('name'=>'反面照.jpg','type'=>'idPicture2','contentType'=>$mime2,'content'=>$pic2),
                    array('name'=>'手持照.jpg','type'=>'idPicture3','contentType'=>$mime3,'content'=>$pic3),
                ),
            )
        );
        $status = $result->return->resultCode;
        $status['isOk'] =  $status=='SUCCESS' ? true : false;
        $status['msg'] = $status=='SUCCESS' ? '' : $result->return->resultMesssage;
        return $status;
    }

    /**
     * 获取配置中的3G合约机
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public static function get3G()
    {
        $telecom3g = Tool::getConfig('heyueji', 'telecom_3g');
        if ($telecom3g)
            return explode(',', $telecom3g);
        return array();
    }

    /**
     * 获取配置中的4G合约机
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public static function get4G()
    {
        $telecom4g = Tool::getConfig('heyueji', 'telecom_4g');
        if ($telecom4g)
            return explode(',', $telecom4g);
        return array();
    }

    /**
     * 获取配置中3G、4G列表
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public static function getHeyueList()
    {
        return CMap::mergeArray(self::get3G(), self::get4G());
    }

    /**
     * 号码段
     * @param type $type
     * @return array $arr
     * @author binbin.liao
     */
    public static function getHaoduan($type = null)
    {
        $arr = array();
        if ($type == self::NUMBER_4G) {
            $arr = array('177' => 177);
        }
        if ($type == self::NUMBER_3G) {
            $arr = array('180' => 180, '181' => 181);
        }
        return $arr;
    }

    /**
     * 靓号规则
     * @author binbin.liao
     * @param type $type
     * @return array $arr
     */
    public static function getNumberRules($type = null)
    {
        $arr = array();
        if ($type == self::NUMBER_4G) {
            $arr = array('靓号规则' => Yii::t('Heyue', '靓号规则'));
        }
        if ($type == self::NUMBER_3G) {
            $arr = array('靓号规则' => Yii::t('Heyue', '靓号规则'), 'AA' => 'AA', 'CBA' => 'CBA');
        }
        return $arr;
    }

    /**
     * 查询同步的订单信息
     * @author binbin.liao
     * @param $code 订单号
     *
     */
    public static function SyncOrderInfo($code)
    {
        $client = new SoapClient(HEYUE_SERVICE_URL . '/queryWl?wsdl');
        $result = $client->getScheduleDemand(array(
            'username' => HEYUE_USERNAME,//API用户名
            'password' => HEYUE_PASSWORD,//API密码
            'outOrderNo' => $code, //商城的订单号
        ));
        Tool::pr($result);
    }
}
