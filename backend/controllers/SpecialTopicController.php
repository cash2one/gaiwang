<?php

/**
 * 专题活动控制器
 * 操作:{创建专题活动,更新专题活动,删除专题活动专,题活动列表}
 * @author jianlin_lin <hayeslam@163.com>
 */
class SpecialTopicController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建专题活动
     */
    public function actionCreate() {
        $model = new SpecialTopic;
        $this->performAjaxValidation($model);
        $model->start_time = date("Y-m-d H:i:s");
        $model->end_time = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 7));
        $model->discount = 100;
        if (isset($_POST['SpecialTopic'])) {
            $model->discount = 100;
            $model->attributes = $_POST['SpecialTopic'];
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            $saveDir = 'zt/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail); // 保存文件
                @SystemLog::record(Yii::app()->user->name . "添加专题活动：{$model->name}");
                $this->setFlash('success', Yii::t('specialTopic', "添加{$model->name}专题成功！"));
                $this->redirect(array('admin'));
            } else {
                $model->start_time = $_POST['SpecialTopic']['start_time'];
                $model->end_time = $_POST['SpecialTopic']['end_time'];
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 更新专题活动
     * @param integer $id  专题ID
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $model->start_time = $this->format()->formatDatetime($model->start_time);
        $model->end_time = $this->format()->formatDatetime($model->end_time);
        if (isset($_POST['SpecialTopic'])) {
            $oldFile = $model->thumbnail;
            $model->attributes = $_POST['SpecialTopic'];
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            $saveDir = 'zt/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true); // 保存并删除旧文件
                @SystemLog::record(Yii::app()->user->name . "编辑专题活动：{$model->name}");
                $this->setFlash('success', Yii::t('specialTopic', "编辑{$model->name}专题成功！"));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 删除专题活动专
     * @param integer $id  专题ID
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除专题：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 专题活动列表
     */
    public function actionAdmin() {
        $model = new SpecialTopic('search');
        $model->unsetAttributes();
        if (isset($_GET['SpecialTopic']))
            $model->attributes = $_GET['SpecialTopic'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
