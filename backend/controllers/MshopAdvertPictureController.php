<?php

/**
 * 微商城 广告位图片控制器
 * @author wyee <yanjie.wang@g-emall.com>
 */
class MshopAdvertPictureController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 列表
     */
    public function actionAdmin($aid) {
        $model = new AdvertPicture('search');
        $model->advert_id = intval($aid);
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate($aid) {
        $model = new AdvertPicture;
        $model->advert_id = intval($aid);
        if (!$model->advert)
            throw new CHttpException(404, '请求的页面不存在.');
        $model->advertType = $model->advert->type;
        $model->start_time = date("Y-m-d H:i:s");
        $this->performAjaxValidation($model);
        if (isset($_POST['AdvertPicture'])) {
            $model->attributes = $_POST['AdvertPicture'];
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            if ($model->advertType == Advert::TYPE_IMAGE || $model->advertType == Advert::TYPE_SLIDE)
                $model = UploadedFile::uploadFile($model, 'picture', 'ad');
            elseif ($model->advertType == Advert::TYPE_FLASH)
                $model = UploadedFile::uploadFile($model, 'flash', 'ad');
            if ($model->save()) {
                if ($model->advertType == Advert::TYPE_IMAGE || $model->advertType == Advert::TYPE_SLIDE)
                    UploadedFile::saveFile('picture', $model->picture);
                elseif ($model->advertType == Advert::TYPE_FLASH)
                    UploadedFile::saveFile('flash', $model->flash);
                SystemLog::record(Yii::app()->user->name . "添加广告位图片：{$model->title}");
                $this->setFlash('success', Yii::t('advertPicture', '添加广告位图片：') . $model->title);
                $this->redirect(array('admin', 'aid' => $aid));
            } else {
                $model->start_time = $_POST['AdvertPicture']['start_time'];
                $model->end_time = $_POST['AdvertPicture']['end_time'];
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $model->advertType = $model->advert->type;
        $model->start_time = date('Y-m-d H:i:s', $model->start_time);
        $model->end_time = !empty($model->end_time) ? date('Y-m-d H:i:s', $model->end_time) : '';
        if (isset($_POST['AdvertPicture'])) {
            $oldPictrue = $model->picture;  // 旧文件
            $oldFlash = $model->flash;
            $model->attributes = $_POST['AdvertPicture'];
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            if ($model->advertType == Advert::TYPE_IMAGE || $model->advertType == Advert::TYPE_SLIDE)
                $model = UploadedFile::uploadFile($model, 'picture', 'ad');
            elseif ($model->advertType == Advert::TYPE_FLASH)
                $model = UploadedFile::uploadFile($model, 'flash', 'ad');
            if ($model->save()) {
                if ($model->advertType == Advert::TYPE_IMAGE || $model->advertType == Advert::TYPE_SLIDE)
                    UploadedFile::saveFile('picture', $model->picture, $oldPictrue, true);
                elseif ($model->advertType == Advert::TYPE_FLASH)
                    UploadedFile::saveFile('flash', $model->flash, $oldFlash, true);
                @SystemLog::record(Yii::app()->user->name . "修改广告位图片：{$model->title}");
                $this->setFlash('success', Yii::t('advertPicture', '修改广告位图片：') . $model->title);
                $this->redirect(array('admin', 'aid' => $model->advert_id));
            }else {
                @SystemLog::record(Yii::app()->user->name . "修改广告位图片：{$model->title} 失败");
            }
        }
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除
     * @param type $id
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除广告位图片：{$id}");
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

//    /**
//     * 批量删除
//     */
//    public function actionDelAll() {
//        if ($this->isPost()) {
//            $criteria = new CDbCriteria;
//            $criteria->addInCondition('id', $_POST['selectdel']);
//            AdvertPicture::model()->deleteAll($criteria);
//            @SystemLog::record(Yii::app()->user->name."批量删除广告位图片：".implode(',', $_POST['selectdel']));
//            if ($this->isAjax()) {
//                echo CJSON::encode(array('success' => true));
//            } else {
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//            }
//        } else {
//            throw new CHttpException(400, Yii::t('advertPicture', '无效的请求'));
//        }
//    }
}
