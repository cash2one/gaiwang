<?php
use JPush\Model\tag;

use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

class JPushTool
{
    const TokenAppKey = '284721c15e67bd42ca49f681';
    const TokenMasterSecret = '05fbd7ca4f9198f934ecbba5';
    const TokenApnsProduction = false; //true表示正式环境
    const GtAppKey = 'eda5af4d432923cdc03f61a4';
    const GtMasterSecret = '2498a4b6a3521a9d8536f566  ';
    const GtApnsProduction = false;
    const Time_to_live = 86400;//存活时间
    
    /**
     * 推送接口封装
     * @param string $appKey
     * @param string $masterSecret
     * @param string $notification
     * @param array $tag
     * @param string $setPlatform
     * @throws Exception
     */
    public static function push($appKey,$masterSecret,$notification,$audience = array(),$setPlatform = '',$audienceType = 'alias')
    {
        try {
            $path = Yii::getPathOfAlias('root') .DS.'common'.DS . 'extensions' . DS.'vendor' . DS .'autoload.php';
            require_once $path;
            $client = new JPushClient($appKey,$masterSecret);
            if(empty($setPlatform)) $setPlatform = M\all;
            if(empty($audience))$tag = M\all;
            $AudienceOption = ($audienceType == 'tag') ? M\tag($audience):M\alias($audience);
            if(is_array($notification))
            {
                $content = ' ';
                $extras = $notification;
            }elseif(is_string($notification)){
                $content = $notification;
                $extras = null;
            }
            $result = $client->push()
                    ->setPlatform(M\all)
                    ->setAudience($AudienceOption)
                    ->setNotification(M\notification(M\android($content,null,null,$extras),M\ios($content,null,'+1',null,$extras)))
                    ->setOptions(M\options(null,self::Time_to_live,null,self::TokenApnsProduction))
                    ->send();
            return $result;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * 盖付通推送接口
     * @param string $moblie
     * @param string $notification
     * @return boolean
     */
    public static function tokenPush($mobile,$content)
    {
        try {
            $imsiTable = "{{member_mobile_imsi}}";
            $db = Yii::app()->db;
            $imsis = $db->createCommand()
                    ->select('imsi')
                    ->from($imsiTable)
                    ->where('mobile =:mobile and is_push = 1',array(':mobile'=>$mobile))
                    ->queryColumn();
            if(empty($imsis))return;
            foreach($imsis as $imsi)
            {
                self::push(self::TokenAppKey,self::TokenMasterSecret,$content,array($imsi));
            }
            return true;
            // return self::push(self::TokenAppKey,self::TokenMasterSecret,$content,array($imsi));
        }catch(Exception $e){
            return false;
        }
    }
    
    /**
     * 盖付通推送盖网通接口
     * @param 机器编码 $code
     * @param 数据 $data
     * @param 接口 $actionType
     */
    public static function gtPush($code,$data,$actionType)
    {
        try {
            $code = (string)$code;
            $resultData = array();
            $resultData['Response'] = array();
            $resultData['Response']['ResultData'] = $data;
            $resultData['Response']['ResultType'] = $actionType;
            return self::push(self::GtAppKey,self::GtMasterSecret,$resultData,array($code));
        }catch(Exception $e){
            return false;
        }
    }
}
