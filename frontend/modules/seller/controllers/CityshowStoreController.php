<?php 

 use OAuth2\Exception\InvalidAccessTokenException;
use Monolog\Handler\NullHandler;
/**
  * 商城商家城市馆商家控制器
  * @author wyee <yanjie.wang@g-emall.com>
  */

class CityshowStoreController extends SController {

    
    public $csid;
    public $showBack=true;
    
    /**
     * @see SController::beforeAction()
     */
    public function beforeAction($action){
        $this->csid=intval($this->getParam('csid'));
        if(empty($this->csid)){
            throw new CHttpException(403,'请先选择城市馆');
          }
         return parent::beforeAction($action);
      }
    /**
     * 商家列表
     */
    public function ActionStoreList(){
        $model =new CityshowStore();
        $csid=$this->csid;
        $model->unsetAttributes();
        if(isset($_GET['CityshowStore']))
            $model->attributes=$_GET['CityshowStore'];
        $dataProvider=$model->getCityShowStoreList($csid);
        $cityShowStore=$dataProvider->getData();
        $countArr=CityshowGoods::getGoodsNum('store_id',$csid);
        $this->Render('storeList',array(
                'cityShowStore'=>$cityShowStore,
                'pager'=>$dataProvider->pagination,
                'model'=>$model,
                'countArr'=>$countArr
        ));
    }
    
    /**
     * 添加城市馆商家
     */
    public function ActionStoreAdd(){
        $model=new CityshowStore();
        $res=Cityshow::getInfoById($this->csid);
        if($res->status!=Cityshow::STATUS_PASS || $res->is_show!=Cityshow::SHOW_YES)
            throw new CHttpException(403,'城市馆未通过审核或已停用');
        $csidArr=Cityshow::getcityShowBySid($this->storeId);
        $cisdRow=array();
        foreach ($csidArr as $v){
            $cisdRow[]=$v['id'];
          }
        if(isset($_POST['storeName'])) {
           $gwArr=array_filter($_POST['storeName']);
           $storeIdArr=CityshowStore::getStoreInfoBygw($gwArr,$cisdRow);
           if(!empty($storeIdArr)){
               $storeCount=count($storeIdArr);
              try {
                  $i=0;
                  $gwStr='';
                foreach ($storeIdArr as $v){
                 if($v['status']==Store::STATUS_PASS){
                     $insertId=Yii::app()->db->createCommand()->insert('{{cityshow_store}}', array(
                        'status' => CityshowStore::STATUS_YES,
                        'create_time' => time(),
                        'cityshow_id' => $this->csid,
                        'store_id' => intval($v['id']), 
                    ));
                   $i++;
                 }else{
                    $gwStr.=$v['gai_number'].','; 
                  }
               }    
              if($i>0){
                if($i<$storeCount){
                    $this->setFlash('success', Yii::t('cityShow', '城市馆部分商家添加成功，'.$gwStr.'未添加成功，请检测或联系客服人员'));
                 }else if($i==$storeCount){
                   $this->setFlash('success', Yii::t('cityShow', '城市馆商家添加成功'));
               }
              }else{
                 $this->setFlash('error', Yii::t('cityShow', $gwStr.'该商家未通过审核不能成为入驻商家，请联系管理员成为正式商家'));
              }
            }catch (Exception $e) {
              $this->setFlash('error', Yii::t('cityShow', '添加城市馆商家失败'));
            } 
           }else{
              $this->setFlash('error', Yii::t('cityShow', '添加城市馆商家失败,商家不存在或者已经添加过，请联系客服或者查看是否已添加'));
           }
           $this->redirect(array('storeList','csid'=>$this->csid));
        }
            
        $this->Render('storeAdd',array(
                'model'=>$model
        ));  
     }
    
     /**
      * 检测GW号商家的合法性
      */
     public function ActionVerifyStoreGw(){
      if($this->isAjax()){
         $retArr=array();
         $gw=$this->getParam('gw');
         $res=CityshowStore::getStoreInfoBygw($gw,null,'t.name,t.status');
         if($res){
           if($res[0]['status']==Store::STATUS_ON_TRIAL){
              $retArr=array('tips'=>'error','msg'=>Yii::t('cityshow', '该商家还在试用中不能成为入驻商家，请联系管理员成为正式商家'));
           }else if($res[0]['status']>Store::STATUS_PASS || $res[0]['status']==Store::STATUS_APPLYING){  
              $retArr=array('tips'=>'error','msg'=>Yii::t('cityshow', '该商家已关闭或者未通过审核不能成为入驻商家，请联系管理员成为正式商家'));
           }else{
              $retArr=array('tips'=>'success','msg'=>Yii::t('cityshow', '商家名称：').$res[0]['name']);
           }  
          }else{
            $retArr=array('tips'=>'error','msg'=>Yii::t('cityshow', '商家不存在或者已经添加过'));
          }
             echo CJSON::encode($retArr);
         }
     } 
    /**
     * 停用 AND 启用
     */
    public function ActionStoreDel(){
        $id=intval($this->getParam('sid'));
        $s=intval($this->getParam('s'));
        if($s!==CityshowStore::STATUS_DEL && $s!=CityshowStore::STATUS_YES){
           $this->setFlash('error', Yii::t('cityShow', '商家信息有误，请刷新重试！'));
           die();
        }
        if(!empty($id)){
            $up=CityshowStore::model()->updateByPk($id,array('status'=>$s));
            if($up) {
                $this->setFlash('success', Yii::t('cityShow', '成功！'));
            }else{
                $this->setFlash('error', Yii::t('cityShow', '失败！'));
            }
            $this->redirect(array('storeList','csid'=>$this->csid));
        }else{
           $this->setFlash('error', Yii::t('cityShow', '商家信息有误，请刷新重试！'));
        }
    }
    
    /**
     * 参与商品列表
     */
    public function ActionGoodsList(){
        $model =new CityshowGoods();
        $csid=$this->csid;
        $sid=intval($this->getParam('sid'));
        $dataProvider=$model->getCityShowGoodsList($csid,$sid,NULL);
        $cityShowGoods=$dataProvider->getData();
        $this->Render('goodsList',array(
                'cityShowGoods'=>$cityShowGoods,
                'pager'=>$dataProvider->pagination,
                'model'=>$model,
        ));
    }

   
}
?>