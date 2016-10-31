<?php

/**
 * 短信接口设置类
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class SmsApiConfigForm extends CFormModel
{

    //香港短信接口，易通讯
    public $ytAccountNo;
    public $ytPwd;
    public $ytSendUrl;

    //吉信通短信接口 @author lc
    public $yxCorpID;
    public $yxLoginName;
    public $yxSendUrl;
    public $yxPassword;

    //短信通短信接口
    public $dxtZh;
    public $dxtMm;
    public $dxtSendUrl;
    public $dxtDxlbid;
    public $dxtExtno;
    
    //吉信通短信接口
    public $jxtLoginName;
    public $jxtSendUrl;
    public $jxtPassword;

    //吉信通短信接口(广告)
    public $jxtadvertLoginName;
    public $jxtadvertSendUrl;
    public $jxtadvertPassword;

    //云通讯
    public $ytxSid;
    public $ytxToken;
    public $ytxUrl;
    public $ytxAppId;
    
    //云通讯提供模板id
    const CAPTCHE_ID = 52755; //验证码模板id
    const PASSWORD_CONTENT_ID = 56287; //短信临时密码内容模板id
    const DYNAMIC_PASS_CONTENT_ID = 56291; //短信动态密码内容模板id
    const ADD_MEMBER_CONTENT_ID = 56321; //添加新会员短信内容模板id
    const NEW_MEMBER_CONTENT_NO_ID = 57576; //新会员短信内容(无临时密码)模板id
    const NEW_MEMBER_CONTENT_ID = 57579 ; //新会员短信内容(临时密码)模板id
    const REGISTER_PHONE_FAILED_ID = 56323 ; //通过短信注册失败模板id
    const REGISTER_PHONE_SUCC_ID = 56324; //通过短信注册成功模板id
    const RESET_PASS_ID= 56325; //重设密码短信内容模板id
    const APPLY_CASH_ID = 56331; //积分兑换申请模板id
    const APPLY_CASH_FAIL_ID = 56335; //积分兑换失败模板id
    const PAY_ORDER_ID = 56336; //支付订单模板id
    const SIGN_ORDER_COMGET_ID = 56339; //签收订单商家提示模板id    
    const SIGN_ORDER_MEMREFGET_ID = 56341; //签收订单推荐者提示模板id
    const SIGN_ORDER_MEMREFSTOREGET_ID = 56343; //签收订单推荐商家会员提示模板id
    const CANCEL_SUCCEED_BUYER_ID = 56345; //卖家关闭交易买家提示模板id
    const REFUND_SUCCEED_BUYER_ID = 56346; //买家退款成功买家提示模板id
    const REPUR_SUCCEED_BUYER_ID = 60076; //买家退货成功买家提示模板id
    const  USE_PREPAIDCAR_SUCCEED_ID = 57869; //充值卡充值模板id
    const  CREATE_PREPAID_CAR_ID = 56369; //批发充值卡模板id
    const  COMMENT_ORDER_ID = 56371; //评价订单模板id
    const  STORE_RECON_ID = 56372; //企业会员对账提示模板id
    const  SELLER_NEW_ORDER_ID = 56373; //卖家新订单提示模板id
    const  STORE_ORDER_RIGHTS_UNSIGNED_ID = 56375; //消费者维权商家提示（未签收）模板id
    const  STORE_ORDER_RIGHTS_SIGNED_ID = 56376; //消费者维权商家提示（已签收）模板id
    const  MEMBER_ORDER_RIGHTS_ID = 56378; //消费者维权买家提示模板id
    const SIGN_RETURN_MONEY_ID = 56379; //会员签收获得返还金额短信模板id
    const  HOTEL_ORDER_PAY_ID = 56383; //酒店订单支付提示模板id
    const  HOTEL_ORDER_LOTTER_PAY_ID = 56384; //酒店订单及抽奖支付提示模板id
    const  HOTEL_ORDER_COMFIRM_ID = 56387; //酒店订单确认提示模板id
    const  HOTEL_ORDER_ROOM_CHANGE_ID = 56388; //酒店订单换房确认模板id
    const  HOTEL_ORDER_LOTTER_CONFIRM_ID = 56390; //酒店订单确认及中奖提示模板id
    const  HOTEL_ORDER_CANCLE_ID = 56392; //酒店订单取消提示模板id
    const  HOTEL_ORDER_LOTTER_CANCLE_ID = 56399; //酒店订单及抽奖取消提示模板id
    const  HOTEL_ORDER_REFUND_ID = 56403; //酒店订单退订提示模板id
    const  HOTEL_ORDER_LOTTER_REFUND_ID = 56404; //酒店订单及抽奖退订提示模板id
    const  HOTEL_ORDER_COMPLETE_RETURN_ID = 56406; //酒店订单完成返回积分提示模板id
    const  HOTEL_ORDER_COMPLETE_PRIZE_ID = 56408; //酒店订单完成获得中奖提示模板id
    const  HOTEL_ORDER_COMPLETE_MEMREF_ID = 56409; // 酒店订单完成推荐者提示模板id
    const  HOTEL_ORDER_COMMENT_ID = 56410; //酒店订单评价提示模板id
    const CONTRIBUTION_CONTENT_ID = 56426; //爱心捐款短信内容模板id
    const OFF_SCORE_CONSUME_MEMBER_ID = 56431; //线下对账-消费者返回积分模板id
    const OFF_SCORE_CONSUME_REF_ID = 56433; //线下对账-推荐者获得积分模板id
    const OFF_SCORE_CONSUME_ID = 56434; //积分消费扣除积分提醒模板id
    const PAY_MENT_CONSUME_ID = 57200; //银行卡消费提醒模板id
    const OFF_SOCRE_BIZ_RECON_ID = 58225; //线下对账-加盟商提醒短信模板id
    const LOTTERY_CHANCE_ID = 56441; //获得抽奖机会提醒模板id
    const LOTTERY_WIN_NONE_ID = 56442; //未中奖提醒模板id
    const LOTTERY_WIN_SCORE_ID = 56443; //中奖积分提醒模板id
    const LOTTERY_WIN_GOODS_ID = 56444; //中奖商品提醒模板id
    const MACHINE_ORDER_CONSUME_ID = 56438; //格子铺消费后的短信提醒模板id
    const MACHINE_ORDER_CONSUME_AFTER_VERIFY_ID = 56440; //格子铺消费验证成功后的短信模板id
    const RED_REGISTER_ID = 56446; //红包活动注册短信提示模板id
    const SHARE_REGISTER_ID = 56447; //分享注册短信提示模板id
    const OFFLINE_REGISTER_ID = 56448; //线下红包活动注册短信提示模板id
    const THE_SHOP_SUCC_ID = 56430; //开点成功商家短信模板id
    const ROOL_OUT_MONEY_ID = 57393; //会员转账短信核实（转出）模板id
    const ROOL_IN_MONEY_ID = 57394; //会员转账短信核实（转入）模板id
    const GT_RED_MONEY_ID = 57808; //盖网通会员红包模板id
    const GT_PASS_RESET_ID = 57877 ; //盖网通管理员重置密码模板id
    const MACHINE_PAY_FAIL_ID = 58206; //售货机支付失败短信模板id
//    const OFF_SOCRE_JMS_ID = 58225; //线下加盟商对账短信模板id
    const RED_COMPENSATION_ID = 58335;//红包补偿模板id
    const RECOVERY_PREPAID_CAR_ID = 58532 ; //回收充值卡（多充）
    const MACHINE_SHIPMENT_FAIL_ID = 58541; //售货机出货失败退款
    const WECHAT_PAY_ID = 127730; //微信支付模板id

    public $ytxVoiceVerify; //是否开启语音验证码
    const VOICE_VERIFY_YES = 1;
    const VOICE_VERIFY_NO = 0;

    //大陆当前短信接口
    public $currentAPI;

    /**是否开启语音验证码
     * @param null $k
     * @return array
     */
    public static function voiceVerifyStatus($k=null){
        $arr = array(
            self::VOICE_VERIFY_YES => Yii::t('home','开启'),
            self::VOICE_VERIFY_NO => Yii::t('home','关闭'),
        );
        return isset($arr[$k])? $arr[$k] : $arr;
    }

    public static function APIEnum($key = null)
    {
        $arr = array(
        	SmsLog::INTERFACE_YX => Yii::t('home', '易信'),
            SmsLog::INTERFACE_DXT => Yii::t('home', '短信通'),
            SmsLog::INTERFACE_JXT => Yii::t('home', '吉信通'),
              SmsLog::INTERFACE_RLY => Yii::t('home', '容联云通讯'),
        );
        return isset($arr[$key]) ? $arr[$key] : $arr;
    }

    public function rules()
    {
        return array(
            array('ytAccountNo,ytPwd,ytSendUrl','safe'),
            array('yxCorpID,yxLoginName,yxSendUrl,yxPassword,currentAPI', 'safe'),
            array('yxSendUrl,dxtSendUrl,ytSendUrl,jxtSendUrl,ytxUrl', 'url'),

            array('dxtZh,dxtMm,dxtSendUrl,dxtDxlbid,dxtExtno', 'required'),
            array('dxtZh,dxtMm,dxtSendUrl,dxtDxlbid,dxtExtno', 'safe'),
        		
        	array('jxtLoginName,jxtSendUrl,jxtPassword', 'safe'),
        	array('jxtadvertLoginName,jxtadvertSendUrl,jxtadvertPassword', 'safe'),

            array('ytxSid,ytxToken,ytxUrl,ytxAppId,ytxVoiceVerify', 'required'),
        	array('ytxSid,ytxToken,ytxUrl,ytxAppId,ytxVoiceVerify', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            //易通讯
            'ytAccountNo'=>Yii::t('home','账号'),
            'ytPwd'=>Yii::t('home','密码'),
            'ytSendUrl'=>Yii::t('home','短信发送URL'),
            //易信
        	'yxCorpID' => Yii::t('home', '企业ID'),
            'yxLoginName' => Yii::t('home', '登录用户名'),
            'yxSendUrl' => Yii::t('home', '短信发送URL'),
            'yxPassword' => Yii::t('home', '密码'),
            //短信通
            'dxtZh' => Yii::t('home', '账号'),
            'dxtMm' => Yii::t('home', '密码'),
            'dxtSendUrl' => Yii::t('home', '短信发送URL'),
            'dxtDxlbid' => Yii::t('home', '短信类别ID'),
            'dxtExtno' => Yii::t('home', '扩展码'),
        	//吉信通
        	'jxtLoginName' => Yii::t('home', '登录用户名'),
        	'jxtSendUrl' => Yii::t('home', '短信发送URL'),
        	'jxtPassword' => Yii::t('home', '密码'),
        	//吉信通(广告)
        	'jxtadvertLoginName' => Yii::t('home', '登录用户名'),
        	'jxtadvertSendUrl' => Yii::t('home', '短信发送URL'),
        	'jxtadvertPassword' => Yii::t('home', '密码'),
            //云通讯
            'ytxSid' => Yii::t('home','ACCOUNT SID'),
            'ytxToken' => Yii::t('home','AUTH TOKEN'),
            'ytxUrl' => Yii::t('home','发送URL'),
            'ytxAppId' => Yii::t('home','应用id'),
            'ytxVoiceVerify' => Yii::t('home','是否开启语音验证码'),
        );
    }
}

?>
