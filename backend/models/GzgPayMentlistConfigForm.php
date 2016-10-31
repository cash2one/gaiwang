<?php

/**
 * 该掌柜支付方式  模型
 * 
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-08T14:28:27+0800
 */
class GzgPayMentlistConfigForm extends CFormModel
{

    public $tl_is_open;           
    public $um_is_open;
    public $union_is_open;
    public $wx_is_open;
    public $ali_is_open;
    public $tl_is_recommended;
    public $um_is_recommended;
    public $union_is_recommended;
    public $wx_is_recommended;
    public $ali_is_recommended;
    public $UM_PAY;
    public $UNION_PAY;
    public $TL_PAY;
    public $WX_PAY;
    public $ALI_PAY;

    //是否打开
    const  OPEN_ON = 1;   //开
    const  OPEN_OFF =0;   //关

    //是否推荐
    const RECOMMENDED_ON = 1 ; //推荐
    const RECOMMENDED_OFF= 0;  //不推荐

    public static function isOpen()
    {
        return array(
            self::OPEN_ON => '开',
            self::OPEN_OFF => '关',
        );
    }

    public static function isRecommend()
    {
        return array(
            self::RECOMMENDED_ON => '推荐',
            self::RECOMMENDED_OFF => '不推荐',
        );
    }


    public function rules() 
    {
        return array(
            array('tl_is_open,um_is_open,union_is_open, wx_is_open,ali_is_open,tl_is_recommended ,
                um_is_recommended,union_is_recommended,wx_is_recommended,ali_is_recommended ','required'),

            array('UM_PAY,UNION_PAY,TL_PAY,WX_PAY,ALI_PAY','safe'),
        );
    }



    public function attributeLabels() 
    {
        return array(
            'tl_is_open' => '是否打开',
            'um_is_open' => '是否打开',
            'union_is_open' => '是否打开',
            'ali_is_open' => '是否打开',
            'wx_is_open' => '是否打开',
            'tl_is_recommended' => '是否推荐',
            'um_is_recommended' => '是否推荐',
            'union_is_recommended' => '是否推荐',
            'ali_is_recommended' => '是否推荐',
            'wx_is_recommended' => '是否推荐',
            'UM_PAY'=>'联动优势支付',
            'UNION_PAY'=>'银联支付',
            'TL_PAY'=>'通联支付',
            'ALI_PAY'=>'支付宝支付',
            'WX_PAY'=>'微信支付',
        );
    }
}