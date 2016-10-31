<?php 

 /**
  * 商城商家城市馆控制器
  * @author wyee <yanjie.wang@g-emall.com>
  */

class CityshowController extends SController {

    /**
     * 商家列表
     */
    public function ActionList(){
        
        $model =new Cityshow();
        $sid=$this->storeId;
        $model->unsetAttributes();
        if(isset($_GET['Cityshow']))
             $model->attributes=$_GET['Cityshow'];
        $dataProvider=$model->getCityShowList($sid);
        $num=$model->getCityShowStoreNum($sid);
        $countArr=array();
        foreach ($num as $k =>$v){
            $countArr[$v['id']]['store_count']=$v['store_count'];
            $countArr[$v['id']]['theme_count']=$v['theme_count'];
        }
        $cityShow=$dataProvider->getData();
        $this->Render('list',array(
                'cityShow'=>$cityShow,
                'pager'=>$dataProvider->pagination,
                'model'=>$model,
                'countArr'=>$countArr
        ));
    }
    
    /**
     * 添加城市馆
     */
    public function ActionCreate(){
        $model=new Cityshow(); 
        $this->performAjaxValidation($model);
        $model->sid=$this->storeId;
        $imgArr = array();
          for($i = 0; $i < 1; $i++) {
                    $imgArr[] = array('ImgUrl' => '','Link' => '');
                }
       if (isset($_POST['Cityshow'])) {
            $model->attributes = $this->getPost('Cityshow');  
            $model->subtitle=stripslashes($model->subtitle);//将字符串进行处理  
            $city=$model->city;
            //同一个城市不可以同时有两个或以上的城市馆存在
            $cityArr=Cityshow::cityShowIsExist($city);
            if($cityArr){
                //throw new CHttpException(403,'该城市已存在有城市馆，请重新选择城市上传');
                $this->setFlash('error', Yii::t('cityShow', '该城市已存在有城市馆，请重新选择城市上传'));
            }else{
            $imgUrl = $this->getPost('ImgUrl');
            $link = $this->getPost('Link');
            $imgArr = array();
            if (!empty($imgUrl)) {
                for ($i = 0; $i < count($imgUrl); $i++) {
                    if(empty($imgUrl[$i])) continue;
                       $imgArr[] = array(
                            'ImgUrl' => $imgUrl[$i],
                            'Link' => $link[$i],
                    );
                }
             }
             if(empty($imgArr)){
                 $this->setFlash('error', Yii::t('cityShow', '焦点图至少上传一张'));
             }
            $model->top_banner=serialize($imgArr);
            $model->create_time = time();
                if ($model->save(false)) {
                    $this->setFlash('success', Yii::t('cityShow', '添加城市馆') . $model->title . Yii::t('cityShow', '成功'));
                }else{
                    $this->setFlash('error', Yii::t('cityShow', '添加城市馆') . $model->title . Yii::t('cityShow', '失败'));
                }
                
            }    
                $this->redirect(array('list'));
        }  
        $this->Render('create',array(
                'imgArr'=>$imgArr,
                'model'=>$model,
        ));
         
    }  
    /**
     * 更新城市馆
     */
    public function ActionUpdate(){
        $id=intval($this->getParam('csid'));
        $model = Cityshow::model()->findByPk($id);
        $this->performAjaxValidation($model);
        $imgArr=unserialize($model->top_banner); 
        if (isset($_POST['Cityshow'])) {
            $model->attributes = $this->getPost('Cityshow');
            $model->subtitle=stripslashes($model->subtitle);//将字符串进行处理
            $imgUrl = $this->getPost('ImgUrl');
            $link = $this->getPost('Link');
            $imgArr = array();
            if (!empty($imgUrl)) {
                for ($i = 0; $i < count($imgUrl); $i++) {
                    if(empty($imgUrl[$i])) continue;
                    $imgArr[] = array(
                            'ImgUrl' => $imgUrl[$i],
                            'Link' => $link[$i],
                    );
                }
            }
            if(empty($imgArr)){
                $this->setFlash('error', Yii::t('cityShow', '焦点图至少上传一张'));
            }else{
            $model->top_banner=serialize($imgArr);
            $model->update_time = time();
            $model->status=Cityshow::STATUS_AUDIT;
            if($model->save(false)) {
                $this->setFlash('success', Yii::t('cityShow', '编辑城市馆') . $model->title . Yii::t('cityShow', '成功'));
               }else{
                $this->setFlash('error', Yii::t('cityShow', '编辑城市馆') . $model->title . Yii::t('cityShow', '失败'));
               }
            }
            $this->redirect(array('list'));
        }
        $this->Render('update',array(
                'imgArr'=>$imgArr,
                'model'=>$model,
        ));  
     }


     /**
      * 删除
      */
     public function ActionDelete(){
         $id=intval($this->getParam('csid'));
         if(!empty($id)){
             $up=$this->loadModel($id)->delete();
           if($up) {
               $this->setFlash('success', Yii::t('cityShow', '成功删除城市馆')); 
           }else{
               $this->setFlash('error', Yii::t('cityShow', '无法删除城市馆'));
           }
           $this->redirect(array('list'));
         }else{
             throw new CHttpException(403,'请先选择城市馆');
         }
     }
   
    
   
}
?>