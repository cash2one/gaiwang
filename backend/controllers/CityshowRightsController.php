<?php

/**
 * 城市馆商家权限
 * （列表、添加、删除）
 * @author zhenjun_xu <412530435@qq.com>
 *  DateTime 2016/4/27 18:14
 */
class CityshowRightsController extends Controller
{

    public function allowedActions(){
        return 'check';
    }
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights'
        );
    }

    /**
     * ajax 检测商家
     * @param $gw
     */
    public function actionCheck($gw){
        $res= CityshowRights::checkGW($gw);
        if($res){
            $retArr=array('tips'=>'success','msg'=>$res['name']);
        }else{
            $retArr=array('tips'=>'error','msg'=>Yii::t('cityshow', '商家不存在或者未通过审核或者已经添加过'));
        }
        echo CJSON::encode($retArr);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->layout = false;
        $model = new CityshowRights;

        $this->performAjaxValidation($model);

        if (isset($_POST['CityshowRights'])) {
            $model->attributes = $_POST['CityshowRights'];
            $res= CityshowRights::checkGW($model->gw);
            if(!empty($res)){
                $model->member_id = $res['id'];
                $model->create_time = time();
                $model->store_name = $res['name'];
                try{
                    if($model->save()){
                        $this->setFlash('success','添加成功');
                    }else{
                        $this->setFlash('error',"添加失败");
                    }
                }catch (Exception $e){
                    $this->setFlash('error',"商家不存在或者未通过审核或者已经添加过");
                }

            }else{
                $this->setFlash('error',"商家不存在或者未通过审核或者已经添加过");
            }
            echo "<script> var done = true;</script>";
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new CityshowRights('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CityshowRights']))
            $model->attributes = $_GET['CityshowRights'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
