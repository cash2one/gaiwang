<?php

/**
 * 酒店图片控制器
 * Class HotelPictureController
 */
class HotelPictureController extends TController
{
    /**
     * 列表
     */
    public function actionAdmin($hotelId)
    {
        $model = new HotelPicture('search');
        $model->unsetAttributes();
        $model->hotel_id = $hotelId;
        if (isset($_GET['HotelPicture']))
            $model->attributes = $this->getParam('HotelPicture');
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     *  添加
     * @param $hotelId
     * @throws CDbException
     */
    public function actionCreate($hotelId)
    {
        $model = new HotelPicture();
        $this->performAjaxValidation($model);
        $model->hotel_id = $hotelId;
        if (isset($_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('HotelPicture');
            $pictures = explode('|', $model->path);
            $trans = Yii::app()->tr->beginTransaction();
            try {
                $time = time();
                foreach ($pictures as $picture) {
                    $p = new HotelPicture();
                    $p->hotel_id = $hotelId;
                    $p->room_id = $model->room_id;
                    $p->type = $model->type;
                    $p->sort = $model->sort;
                    $p->path = $picture;
                    $p->creater = Yii::app()->user->name;
                    $p->created_at = $time;
                    if(!$p->save()){
                        throw new Exception(CHtml::errorSummary($p));
                    }
                }
                $trans->commit();
                $this->setFlash('success', '添加酒店图片：' . '成功！');
                $this->redirect($this->createAbsoluteUrl('admin', array('hotelId' => $model->hotel_id)));

            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', $e->getMessage());
            }
        }
        $hotelName = Hotel::model()->find(array('select' => 'chn_name', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $model->hotel_id)));
        $this->render('_form', array(
            'model' => $model,
            'hotelName' => $hotelName,
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
        if (isset($_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('HotelPicture');
            if ($model->save()) {
                $this->setFlash('success', '更新酒店图片：' . '成功！');
                $this->redirect($this->createAbsoluteUrl('admin', array('hotelId' => $model->hotel_id)));
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $hotelName = Hotel::model()->find(array('select' => 'chn_name', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $model->hotel_id)));
        $this->render('_form', array(
            'model' => $model,
            'hotelName' => $hotelName,
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
            $this->setFlash('success', '删除酒店图片成功');
        } else
            $this->setFlash('error', '删除酒店图片失败');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $this->createAbsoluteUrl('admin', array('hotelId' => $model->hotel_id)));
    }
} 