<?php

/**
 * 专题分类控制器
 * 操作:{添加专题分类,编辑专题分类,专题分类列表}
 * @author jianlin_lin <hayeslam@163.com>
 */
class SpecialTopicCategoryController extends Controller {

    public $specialId;  // 专题ID

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 在执行Action之前的操作
     * @param type $action
     */
    public function beforeAction($action) {
        parent::beforeAction($action);
        $this->specialId = $this->getParam('specialId');
        // 判断是否存在此专题
        if (!SpecialTopic::model()->exists('id = :stid', array(':stid' => $this->specialId)))
            throw new CHttpException(404, '请求的页面不存在.');
        return true;
    }

    /**
     * 添加专题分类
     * @param integer $specialId  专题ID
     */
    public function actionCreate() {
        $model = new SpecialTopicCategory;
        $model->special_topic_id = $this->specialId; // 所属专题ID赋值
        $this->performAjaxValidation($model);
        if (isset($_POST['SpecialTopicCategory'])) {
            $model->attributes = $_POST['SpecialTopicCategory'];
            $saveDir = 'zt/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail); // 保存文件
                @SystemLog::record(Yii::app()->user->name . "添加专题分类：{$model->name}");
                $this->setFlash('success', Yii::t('specialTopicCategory', "添加{$model->name}专题分类成功！"));
                $this->redirect(array('admin', 'specialId' => $this->specialId));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 编辑专题分类
     * @param integer $id   专题分类ID
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['SpecialTopicCategory'])) {
            $oldFile = $model->thumbnail;
            $model->attributes = $_POST['SpecialTopicCategory'];
            $saveDir = 'zt/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir);
            if ($model->save()) {
                UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true); // 保存并删除旧文件
                @SystemLog::record(Yii::app()->user->name . "添加专题分类：{$model->name}");
                $this->setFlash('success', Yii::t('specialTopicCategory', "添加{$model->name}专题分类成功！"));
                $this->redirect(array('admin', 'specialId' => $this->specialId));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 专题分类列表
     */
    public function actionAdmin() {
        $model = new SpecialTopicCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['SpecialTopicCategory']))
            $model->attributes = $_GET['SpecialTopicCategory'];
        $model->special_topic_id = $this->specialId;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
