<?php
/*
 * 城市名片控制器（城市名片增删改查）
 * @author zehui.hong
 */
class CityCardController extends TController{
    
    
    /**
     * 外部操作
     * @return array
     */
     public function actions() {
        return array(
            'ajaxUpdateSort' => array(
                'class' => 'CommonAction',
                'method' => 'ajaxUpdateSort',
                'params' => array(
                    'table' => '{{city_card}}',
                ),
            ),
        );
    }
    
  /*
   * 城市名片列表
   */
    public function actionAdmin()
    {       
            $model = new CityCard('search');
            $model->unsetAttributes();
            if (isset($_GET['CityCard']))
                $model->attributes = $this->getParam('CityCard');
            $this->render('admin', array(
                'model' => $model,
            ));          
    }
    
    /*
     * 城市名片添加操作
     */
    public function actionCreate(){
        $model=new CityCard;      
        $this->performAjaxValidation(array($model));
        if(isset($_POST['CityCard'])){ 
            $nactions = Nation::model()->find('id=:nation', array(':nation'=>(int) $_POST['nation']));
            $provinces=  Province::model()->find('code=:province',array(':province'=>$_POST['province']));
            $city = City::model()->find('code=:city',array(':city'=>$_POST['city']));
            $model->attributes = $this->getParam('CityCard');
            $model->city_name=$city['name'];
            $model->city_code=$_POST['city'];
            $time = time();
            $model->created_at = $time;
            if($model->validate()){
                if($model->save()){
                  @SystemLog::record(Yii::app()->user->name . "添加城市名片：" . $model->name);             
                  Yii::app()->user->setFlash('success', Yii::t('citycard', '添加城市名片成功！'));
                    $this->redirect(array('admin'));
                }
            }
        }
         
        $this->render('create',array('model'=>$model));
    }
    
    /*
     * 城市名片更新
     */
    public function actionUpdate($id){
        $model = $this->loadModel($id);
         $this->performAjaxValidation(array($model));
         $city = City::model()->find('code=:city',array(':city'=>$model->city_code));      
         $province=  Province::model()->find('code=:province',array(':province'=>$city->province_code));
         $nation = Nation::model()->find('id=:nation', array(':nation'=>$province->nation_id));
  
         if(isset($_POST['CityCard'])){
             
             $model->attributes = $this->getParam('CityCard');
             $model->city_name=$city['name'];
             $model->city_code=$_POST['city'];
             $time = time();
             $model->created_at = $time;
             if ($model->validate()) {              
                if ($model->save()) {
                    @SystemLog::record(Yii::app()->user->name . "修改城市名片：" . $model->name);
                    Yii::app()->user->setFlash('success', '成功');
                    $this->redirect(array('citycard/admin', 'id' => $model->id));
                }
            }
        }     
        // 城市、地区下来选项的数据
   
        $this->render('update', array(           
            'nation'=>$nation,
            'city' => $city,
            'province'=>$province,
            'model' => $model,
        ));
    }
    
    /*
     * 城市名片删除
     */
    public function actionDelete($id){
        $this->loadModel($id)->delete();
        $model=  ViewSpot::model()->findAll('city_card_id=:id',array(':id'=>$id));
        $ids=[];
        foreach($model as $k=>$v){
            $ids['id']=$v['id'];
            SurroundingBusinesses::model()->deleteAll('view_spot_id=:id',array(':id'=>$ids['id']));        
        }
//        var_dump($ids);die;
        ViewSpot::model()->deleteAll('city_card_id=:id',array(':id'=>$id));
        @SystemLog::record(Yii::app()->user->name . "删除城市名片：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    /*
     * 国家，省份，城市联动
     */
     public function actionUpdateProvince()
    {
        //provinces
        $data = Province::model()->findAll('nation_id=:nation', array(':nation'=>(int) $_POST['nation']));
        $data = CHtml::listData($data,'code','name');
        $dropDownProvince = "<option value=''>选择城市</option>";
        foreach($data as $value=>$name)
            $dropDownProvince .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

        //Cities
        $dropDownCities = "<option value='null'>选择区域</option>";

        // return data (JSON formatted)
        echo CJSON::encode(array(
            'dropDownProvince'=>$dropDownProvince,
            'dropDownCities'=>$dropDownCities
        ));
    }

    /*
     * 省份，城市联动
     */
    public function actionUpdateCities()
    {
        $data = City::model()->findAll('province_code=:province', array(':province'=>  trim($_POST['province'])));
        $data = CHtml::listData($data,'code','name');
        echo "<option value=''>选择区域</option>";
        foreach($data as $value=>$name)
            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
    }
}
