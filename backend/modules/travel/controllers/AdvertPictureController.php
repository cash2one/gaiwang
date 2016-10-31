<?php

/**
 * 广告位图片控制器
 */
class AdvertPictureController extends Controller
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
    public function actionAdmin($aid)
    {
        $model = new AdvertPicture('search');
        $model->unsetAttributes();
        $model->advert_id = intval($aid);
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate($aid)
    {
        $model = new AdvertPicture;
        $model->advert_id = intval($aid);
        if (!$model->advert)
            throw new CHttpException(404, '请求的页面不存在.');
        $this->performAjaxValidation($model);
        if (isset($_POST['AdvertPicture'])) {
            $model->attributes = $this->getParam('AdvertPicture');
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            $model = UploadedFile::uploadFile($model, 'picture', 'travel/ad');
            if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture);
                SystemLog::record(Yii::app()->user->name . "添加广告位图片：{$model->title}");
                $this->setFlash('success', Yii::t('advertPicture', '添加广告位图片：') . $model->title);
                $this->redirect(array('admin', 'aid' => $aid));
            } else {
                $model->start_time = date('Y-m-d H:i:s',$model->start_time);
                $model->end_time = date('Y-m-d H:i:s',$model->end_time);
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
        $model->start_time = !empty($model->start_time) ? date('Y-m-d H:i:s', $model->start_time) : '';
        $model->end_time = !empty($model->end_time) ? date('Y-m-d H:i:s', $model->end_time) : '';
        if (isset($_POST['AdvertPicture'])) {
            $oldPictrue = $model->picture;  // 旧文件
            $model->attributes = $this->getParam('AdvertPicture');
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            $model = UploadedFile::uploadFile($model, 'picture', 'travel/ad');

            if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture, $oldPictrue, true);
                @SystemLog::record(Yii::app()->user->name . "修改广告位图片：{$model->title}");
                $this->setFlash('success', Yii::t('advertPicture', '修改广告位图片：') . $model->title);
                $this->redirect(array('admin', 'aid' => $model->advert_id));
            } else {
                $model->start_time = date('Y-m-d H:i:s',$model->start_time);
                $model->end_time = date('Y-m-d H:i:s',$model->end_time);
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
        if ($model->delete()) {
            @SystemLog::record(Yii::app()->user->name . "删除广告位图片：{$id}");
            $this->setFlash('success', '删除广告位图片成功');
            Advert::clearvpAdverCache();//清除盖象2.0广告缓存
        } else
            $this->setFlash('error', '删除广告位图片失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin','aid'=>$model->advert_id));
    }

}
