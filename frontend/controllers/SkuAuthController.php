<?php 
/**
 * 用于sku项目账户认证
 *
 * @author wyee <yanjie.wang@g-emall.com>
 * 
 */
class SkuAuthController extends Controller {

    public $privateKye;
    public $access_method = 'POST'; // 默认访问方式
    public $publicKey;
    public $merchant_id='000000000100440';
    public $user_name='000000000100440';
    public $tooken='gaiwang_2016sku';
    public $params = array();
    public $post=array();
    
    
    /**
     * @param tooken 访问验证
     * @param bc 银行编号  如：光大是303
     * @param ano 银行卡号
     * @param aname 身份证名字
     * @param mobile 银行预留手机号
     * @param cardno 身份证号
     * @see Controller::beforeAction()
     */
    public function beforeAction($action){
        if($this->access_method != '' && Yii::app()->request->requestType != $this->access_method){
            throw new Exception('访问方式错误!');
        }
        $tooken=md5($this->tooken);
        $postTooken=$this->getParam('tooken');
        if($tooken!=$postTooken){
            throw new Exception('抱歉，无权限访问!');
         }
         $requiredFields=array('tooken','bc','ano','aname','mobile','cardno');//必填字段
         $post=$_POST;
         $filesKeys=array_keys($post);
         foreach ($requiredFields as $v){
           if($filesKeys){  
              if(!in_array($v, $filesKeys)){
                  throw new Exception('提交的数据不完整，请检测重新提交!');
               }else if(in_array($v, $filesKeys)){
                    if(trim($post[$v])==='')
                       throw new Exception($v.'提交的数据不能为空!');
              }else{
                 throw new Exception('没有提交数据');
             }
           }
         }
          $mobile=$post['mobile'];
          $ano=$post['ano'];
          $bc=$post['bc'];
          $cardno=$post['cardno'];
          if(!preg_match("/(^\d{18}$)|(^\d{15}$)/", $cardno)) throw new Exception($field.'提交的身份证信息有误!');
          if(!preg_match("/(^\d{3}$)/", $bc)) throw new Exception($field.'提交的银行代码信息有误!');
          if(!preg_match("/(^\d{16}$)|(^\d{19}$)/", $ano)) throw new Exception($field.'提交的银行账号信息有误!');
          if(!preg_match("/(^1[34578]{1}\d{9}$)|(^852\d{8}$)/", $mobile)) throw new Exception($field.'手机号有误!');
          array_shift($post);
          $this->post=$post;
          $authField=array(':bc'=>$post['bc'],':ano'=>$ano,':aname'=>$post['aname']);
          $condion='bank_code=:bc AND account_no=:ano AND account_name=:aname AND mobile=:mobile AND card_id=:cardno';
          $params =array(':bc'=>$bc,':ano'=>$ano,':aname'=>$post['aname'],':mobile'=>$post['mobile'],':cardno'=>$cardno);
          $authMem=Yii::app()->db->createCommand()
          ->select('count(id)')
          ->from('{{member_auth}}')
          ->where($condion,$params)
          ->queryScalar();
          if(!empty($authMem)){
              {
                  throw new Exception('提交的数据已进行验证，请修改信息重新验证');
             }
          }
         return parent::beforeAction($action);
     }
     
     /**
      * 账户验证
      */     
    public function actionIndex() {
        $thirdPayment=new ThirdPartyPayment();
        $thirdPayment->privateKye=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100440.pfx';
        $thirdPayment->publicKey=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100440.txt';
        $thirdPayment->merchant_id=$this->merchant_id;
        $thirdPayment->user_name=$this->user_name;
        $ghtOrderId=Tool::buildOrderNo(19,'Y');//交易流水号 待入库
        $info['req_id']=$ghtOrderId;
        $info['bank_code']=$this->post['bc'];
        $info['account_no']=$this->post['ano'];
        $info['account_name']=$this->post['aname'];
        $info['mobile']=$this->post['mobile'];
        $info['card_id']=$this->post['cardno'];
        $thirdPayment->set_data($info,'auth');
        $url='https://rps.gaohuitong.com:8443/d/merchant/';
        $thirdPayment->curl_access($url);
        $result=$thirdPayment->verify_ret();
        $jsonArr=array();
        $status=0;
        if($result['status']){
            $xml_obj=$result['info'];
            $infoArr = (array)$xml_obj->INFO;
            if ($infoArr['RET_CODE'] == '0000'){
                $ret_code = (string)$xml_obj->BODY->RET_DETAILS->RET_DETAIL->RET_CODE;
                 if ($ret_code == '0000'){
                     $jsonArr['status']=true;
                     $jsonArr['msg']='账户验证成功';
                     $status=1;
                }else{
                   $err_msg = (string)$xml_obj->BODY->RET_DETAILS->RET_DETAIL->ERR_MSG;
                     $jsonArr['status']=false;
                     $jsonArr['msg']='账户验证失败';
                }
            }else{
                 $jsonArr['status']=false;
                 $jsonArr['error']=$infoArr['ERR_MSG'];
            } 
            $insertArr=$info;
            $insertArr['status']=$status;
            $insertArr['create_time']=time();
            Yii::app()->db->createCommand()->insert('{{member_auth}}', $insertArr);
        }else{  
              throw new Exception($result['error']);
         }
         echo json_encode($jsonArr);
    }
    
    
    
    
    
    
}














?>