<?php

/**
 * 广告位控制器
 */
class AdvertController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 列表
     */
    public function actionAdmin()
    {
        $model = new Advert('search');
        $model->unsetAttributes();
        if (isset($_GET['Advert']))
            $model->attributes = $this->getParam('Advert');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate()
    {
        $model = new Advert();
        $this->performAjaxValidation($model);
        if (isset($_POST['Advert'])) {
            $model->attributes = $this->getPost('Advert');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "添加广告位：" . $model->name);
                $this->setFlash('success', Yii::t('advert', '添加广告位成功：') . $model->name);
                Advert::clearvpAdverCache();//清除盖象2.0广告缓存
                $this->redirect(array('admin'));
            }else{
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 更新
     * @param int $id
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Advert'])) {
            $model->attributes = $this->getPost('Advert');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "修改广告位：" . $model->name);
                $this->setFlash('success', Yii::t('advert', '更新广告位成功：') . $model->name);
                Advert::clearvpAdverCache();//清除盖象2.0广告缓存
                $this->redirect(array('admin'));
            }else{
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     * @param int $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $model->delete();
        SystemLog::record($this->getUser()->name . "删除广告位：" . $model->name);
        $this->setFlash('success', Yii::t('advert', '删除广告位成功：') . $model->name);
        Advert::clearvpAdverCache();//清除盖象2.0广告缓存
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 生成所有广告缓存
     */
    public function actionGenerateAllAdvertCache()
    {
        Tool::cache(Advert::CACHEDIR)->flush();  // 清除所有广告缓存
        Advert::generateAllAdvertCache();
        SystemLog::record($this->getUser()->name . "生成所有广告缓存");
        Advert::clearvpAdverCache();//清除盖象2.0广告缓存
        $this->setFlash('success', Yii::t('advert', '成功生成所有广告缓存文件'));
        $this->redirect(array('admin'));
    }

}
