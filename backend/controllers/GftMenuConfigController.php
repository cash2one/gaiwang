<?php

/**
 * 盖付通，主菜单 配置
 *
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-08T14:47:09+0800
 */
class GftMenuConfigController extends Controller
{

    public function actionIndex()
    {
        $model = new GftMenuConfig();
        
        // if(isset($_GET['GftMenuConfig'])){
        //     $model->attributes = $this->getParam('GftMenuConfig');
        // }

        $this->render('index',array(
            'model'=>$model,
        ));
    }
    
    /**
     * Create
     */
    public function actionCreate()
    {
        $model = new GftMenuConfig();
        $this->performAjaxValidation($model);
        if(isset($_POST['GftMenuConfig'])){
            $model->attributes = $_POST['GftMenuConfig'];

            $saveDir = 'icon/' . date('Y/m');
            $model = UploadedFile::uploadFile($model, 'icon', $saveDir);  // 上传图片
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "新增盖付通主菜单：" . $model->title);
                UploadedFile::saveFile('icon', $model->icon); // 更新图片
                $this->setFlash('success', Yii::t('gftmenuconfig', '修改品牌') . $model->title . Yii::t('gftmenuconfig', '成功'));
                $this->redirect(array('index'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if(isset($_POST['GftMenuConfig'])){
            $model->attributes = $_POST['GftMenuConfig'];
            $oldImg = $this->getParam('oldImg');  // 旧图
            $saveDir = 'icon/' . date('Y/m');
            $model = UploadedFile::uploadFile($model, 'icon', $saveDir);  // 上传图片
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "修改盖付通主菜单：" . $model->title);
                UploadedFile::saveFile('icon', $model->icon, $oldImg, true); // 更新图片
                $this->setFlash('success', Yii::t('gftmenuconfig', '修改品牌') . $model->title . Yii::t('gftmenuconfig', '成功'));
                $this->redirect(array('index'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
    

    public function actionDelete($id)
    {
        if($this->loadModel($id)->delete()){
            $this->setFlash('success', Yii::t('gftmenuconfig', '删除成功'));
        }
        $this->redirect(array('index'));    

    }
}