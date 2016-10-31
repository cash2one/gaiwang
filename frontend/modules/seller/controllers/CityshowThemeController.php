<?php 

 /**
  * 商城商家城市馆主题控制器
  * @author wyee <yanjie.wang@g-emall.com>
  */

class CityshowThemeController extends SController 
{
    
    public $csid;
    public $themeNum;
    public $showBack=true;
    
    public function beforeAction($action){
        $route= $route = $this->id . '/' . $action->id;
        $this->csid=$this->getParam('csid');
        $this->csid= !empty($this->csid) ? intval($this->csid):null;
        if(empty($this->csid)){
            throw new CHttpException(403,'请先选择城市馆');
           }  
         $this->themeNum=intval(CityshowTheme::getThemeCount($this->csid));
          if($this->themeNum == 5 && $route=='cityShowTheme/create'){
                 $this->setFlash('error', Yii::t('cityShow', '城市馆主题最多有5个'));
                 $this->redirect(array('list','csid'=>$this->csid));  
         }
        return parent::beforeAction($action);
      }

    /**
     * 城市馆主题列表
     */
    public function ActionList(){
        $model =new CityshowTheme();
        $countArr=CityshowGoods::getGoodsNum('theme_id'); 
        //Tool::pr($countArr);
        $model->unsetAttributes();
        if(isset($_GET['CityshowTheme']))
            $model->attributes=$_GET['CityshowTheme'];
        $dataProvider=$model->getCityShowThemeList($this->csid);
        $cityShowTheme=$dataProvider->getData();
        $this->Render('list',array(
                'cityShowTheme'=>$cityShowTheme,
                'pager'=>$dataProvider->pagination,
                'model'=>$model,
                'countArr'=>$countArr
        ));
    }
    
    /**
     * 添加城市馆主题
     */
    public function ActionCreate(){
         $model=new CityshowTheme();
         $this->performAjaxValidation($model);
         $res=Cityshow::getInfoById($this->csid);
         if($res->is_show!=Cityshow::SHOW_YES)
              throw new CHttpException(403,'城市馆已停用');        
        if (isset($_POST['themeName'])) {
            $nameArr=array_filter($_POST['themeName']);
            $num=5-$this->themeNum;
            if(empty($nameArr)){
                $this->setFlash('error', Yii::t('cityShow', '城市馆主题不能为空！'));
            }else{
              $nameArr=array_slice($nameArr,0, $num);
               try {
                foreach ($nameArr as $v){
                  $insertId=Yii::app()->db->createCommand()->insert('{{cityshow_theme}}', array(
                        'create_time' => time(),
                        'cityshow_id' => $this->csid,
                        'name' => $v, 
                    ));
                }
                if($insertId){
                      Cityshow::model()->updateByPk($this->csid,array('status'=>Cityshow::STATUS_AUDIT));
                      $this->setFlash('success', Yii::t('cityShow', '添加成功,城市馆最多有5个主题'));
                }
            }catch (Exception $e) {
              $this->setFlash('error', Yii::t('cityShow', '添加城市馆主题失败'));
            } 
          }
            $this->redirect(array('list','csid'=>$this->csid));
          }
         $this->Render('create',array(
                'model'=>$model,
           ));
         
    }
    
    /**
     * 更新城市馆主题的排序
     */
    public function ActionUpdate(){
        $this->layout=false;
        $id=intval($this->getParam('tid'));
        $model = CityshowTheme::model()->findByPk($id);
        $name=$model->name;
        if(!$model){
            throw new CHttpException(403,'主题不存在，请刷新重试');
        }
        $this->performAjaxValidation($model);
       if (isset($_POST['CityshowTheme'])) {
         $model->attributes = $this->getPost('CityshowTheme');
         $up=CityshowTheme::model()->updateByPk($id,array('sort'=>$model->sort,'name'=>$model->name));
         if($up){
             if($name!=$model->name){
                 Cityshow::model()->updateByPk($this->csid,array('status'=>Cityshow::STATUS_AUDIT));
              }
            $this->setFlash('success', Yii::t('cityShow', '编辑主题成功'));
         }else{
            $this->setFlash('error', Yii::t('cityShow', '编辑主题失败'));
           }
        }
        $this->Render('update',array(
                'model'=>$model
        ));
     }

     /**
      * 删除城市馆主题
      */
     public function ActionDelete(){
         $id=intval($this->getParam('tid'));
         if(!empty($id)){ 
             $up=$this->loadModel($id)->delete();
             if($up) {
                 $this->setFlash('success', Yii::t('cityShow', '成功删除主题'));
             }else{
                 $this->setFlash('error', Yii::t('cityShow', '无法删除主题'));
             }
             $this->redirect(array('list','csid'=>$this->csid));
         }else{
             throw new CHttpException(403,'请先选择城市馆');
         }
     }
    
     /**
      * 参与商品列表
      */
     public function ActionGoodsList(){
         $model =new CityshowGoods();
         $csid=$this->csid;
         $tid=intval($this->getParam('tid'));
         $dataProvider=$model->getCityShowGoodsList(null,null,$tid);
         $cityShowGoods=$dataProvider->getData();
         $this->Render('goodsList',array(
                 'cityShowGoods'=>$cityShowGoods,
                 'pager'=>$dataProvider->pagination,
                 'model'=>$model,
         ));
     }
     
     /**
      * 添加商品读取视图
      */
     public function ActionGoodsAdd(){
         $this->layout=false;
         $model=new CityshowGoods();
         $themeId=$this->getParam('tid');
         $res=Cityshow::getInfoById($this->csid); 
         //根据这个查询goods表里所有的商家的商品
         $storeIdArr=CityshowStore::getStoreIdByCsid($this->csid,NULL);
          if(empty($storeIdArr)){
              $this->redirect(array('/seller/cityShowTheme/error','csid'=>$this->csid,'tid'=>$themeId));
          }
         $goodsModel=new Goods();
         $goodsId=array();
         $cityShowGoods=array();
         //查出某一个城市馆主题里的所有已经参加的商品ID 
         $goodsId=$model::getGoodsIdByTidSid($storeIdArr['sid']);
         //暂时同一个城市馆不可以添加相同的商品
         $dataProvider=$goodsModel->getGoodsByStoreIdArr($storeIdArr['store_id'],$goodsId);
         $cityShowGoods=$dataProvider->getData();
         $this->Render('goodsAdd',array(
                 'cityShowGoods'=>$cityShowGoods,
                 'pager'=>$dataProvider->pagination,
                 'model'=>$model,
         ));
     }
      
     /**
      * 添加商品动作
      */
     public function ActionGoodsDoAdd(){
         $goodsId=$this->getParam('gid');
         $store_id=$this->getParam('sid');
         $themeId=$this->getParam('tid');
         //根据store_id查找cityshow_store的主键
         $cs_storeId=CityshowStore::getCityShowStoreId($store_id);
         if(empty($cs_storeId))
             throw new CHttpException(403,'商品信息有误，请重新刷新重试！');
         $isExist=CityshowGoods::themeGoodsIsExist($themeId,$goodsId);//检测商品是否已添加 
         if($isExist){
              $this->setFlash('success', Yii::t('cityShow', '商品已添加成功'));
           }else{
                $insertId=Yii::app()->db->createCommand()->insert('{{cityshow_goods}}', array(
                     'create_time' => time(),
                     'store_id' => $cs_storeId,
                     'goods_id' => $goodsId,
                     'theme_id'=>$themeId
                 ));
                 if($insertId){
                     $this->setFlash('success', Yii::t('cityShow', '添加商品成功'));
                 }else{
                     $this->setFlash('error', Yii::t('cityShow', '添加商品失败'));
                 }
         }
         $this->redirect(array('goodsAdd','csid'=>$this->csid,'tid'=>$themeId));
     }
     
     /**
      * 批量添加商品
      * @throws CHttpException
      */
     public function actionGoodsMore() {
         if($this->isAjax()){
            $themeId=intval($this->getParam('tid'));
               try{
                   foreach($_POST['ids'] as $v){
                       $cs_storeId='';
                       $vArr=explode('|', $v);
                       if(isset($vArr[1]) && !empty($vArr[1]) && isset($vArr[0]) && !empty($vArr[0])){
                           $cs_storeId=CityshowStore::getCityShowStoreId($vArr[1]);
                           if(empty($cs_storeId)){
                               throw new CHttpException(403,'商品信息有误，请重新刷新重试！');
                           }
                        }
                      $insertId=Yii::app()->db->createCommand()->insert('{{cityshow_goods}}', array(
                             'create_time' => time(),
                             'store_id' => $cs_storeId,
                             'goods_id' => $vArr[0],
                             'theme_id'=>$themeId
                     ));  
                 }
               echo CJSON::encode(array('tips' => true,'msg'=>'添加商品成功'));exit;
             }catch (Exception $e){
               echo CJSON::encode(array('tips' => false,'msg'=>'添加商品失败'));exit;
             }
        }
     }
      
     /**
      * 更新商品的排序
      */
     public function ActionGoodsUpdate(){
         $this->layout=false;
         $id=intval($this->getParam('gid'));
         $themeId=$this->getParam('tid');
         $model = CityshowGoods::model()->findByPk($id);
         $nameArr=Goods::model()->findByPk($model->goods_id,array('select'=>'name'));
         if(!$model){
             throw new CHttpException(403,'商品不存在，请刷新重试');
         }
         $this->performAjaxValidation($model);
         if (isset($_POST['CityshowGoods'])) {
             $model->attributes = $this->getPost('CityshowGoods');
             $up=CityshowGoods::model()->updateByPk($id,array('sort'=>$model->sort));
             if($up){
                 $this->setFlash('success', Yii::t('cityShow', '编辑商品排序成功'));
                  
             }else{
                 $this->setFlash('error', Yii::t('cityShow', '编辑商品排序失败'));
             }
         }
         $this->Render('goodsUpdate',array(
                 'model'=>$model,
                 'name'=>$nameArr->name
         ));
     }
     
     /**
      * 删除商品
      */
     public function ActionGoodsDel(){
         $id=intval($this->getParam('gid'));
         $themeId=$this->getParam('tid');
         if(!empty($id)){
             $up=CityshowGoods::model()->deleteByPk($id);
             if($up) {
                 $this->setFlash('success', Yii::t('cityShow', '成功删除商品'));
             }else{
                 $this->setFlash('error', Yii::t('cityShow', '无法删除商品'));
             }
             $this->redirect(array('goodsList','csid'=>$this->csid,'tid'=>$themeId));
         }else{
             throw new CHttpException(403,'请先选择要删除的商品');
         }
     }
     
     /**
      * 错误页面
      */
     
     public function actionError(){
         $this->layout=false;
         $this->render('error');
     }
     
    
   
}
?>