<?php

/**
 * 酒店房间控制器
 * Class HotelRoomController
 */
class HotelRoomController extends TController
{
    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return '';
    }


    /**
     * 酒店房间列表
     * @param $hotelId 酒店ID
     */
    public function actionAdmin($hotelId)
    {
        if (!is_numeric($hotelId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $hotel = Hotel::model()->find(array('select' => 'hotel_id,chn_name,star,plate_id,city_code,chn_address,status,source,created_at,updated_at', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $hotelId)));
        if (!$hotel) {
            Yii::app()->user->setFlash('error', '酒店不存在！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $model = new HotelRoom('search');
        $model->unsetAttributes();
        $model->hotel_id = $hotelId;
        if (isset($_GET['Hotel']))
            $model->attributes = $this->getParam('Hotel');
        $this->render('admin', array(
            'model' => $model,
            'hotel' => $hotel,
        ));
    }

    /**
     * 添加手工酒店房间
     */
    public function actionCreate($hotelId)
    {
        if (!is_numeric($hotelId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $model = new HotelRoom();
        $model->hotel_id = $hotelId;

        $this->performAjaxValidation($model);
        if (isset($_POST['HotelRoom'])) {
            $model->attributes = $this->getParam('HotelRoom');
            $model->room_id = HotelRoom::createHandHotelRoomId();
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            $pictures = explode('|', $model->roomPicture);
            $trans = Yii::app()->tr->beginTransaction();
            try {
                if ($model->save()) {
                    foreach ($pictures as $picture) {
                        $p = new HotelPicture();
                        $p->hotel_id = $hotelId;
                        $p->room_id = $model->room_id;
                        $p->type = HotelPicture::TYPE_FANG_XING;
                        $p->path = $picture;
                        $p->creater = Yii::app()->user->name;
                        $p->created_at = $model->created_at;
                        if (!$p->save()) {
                            throw new Exception(CHtml::errorSummary($p));
                        }
                    }
                } else {
                    throw new Exception(CHtml::errorSummary($model));
                }
                $trans->commit();
                @SystemLog::record(Yii::app()->user->name . "添加酒店房间：{$model->room_id}成功");
                Yii::app()->user->setFlash('success', '添加酒店房间成功！');
                $this->redirect($this->createAbsoluteUrl('hotelRoom/admin', array('hotelId' => $model->hotel_id)));
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * 更新手工酒店房间
     * @param $roomId
     */
    public function actionUpdate($roomId)
    {
        if (!is_numeric($roomId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $model = HotelRoom::model()->find('room_id=:room_id', array(':room_id' => $roomId));
        $this->performAjaxValidation($model);

        $hotelPicture = HotelPicture::model()->findAll(array('select' => 'id,path', 'condition' => 'room_id=:room_id', 'params' => array(':room_id' => $roomId)));
        $pic = array('path'=>array(),'id'=>array());
        foreach($hotelPicture as $v){
            $pic['path'][] = $v->path;
            $pic['id'][] = $v->id;
        }
        $model->roomPicture = implode('|', $pic['path']);

        if (isset($_POST['HotelRoom'])) {
            $model->attributes = $this->getParam('HotelRoom');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();

            $pictures = explode('|', $model->roomPicture);

            $delPic = array();//删除的图片
            $hasPic = array();//未删除图片
            foreach ($pic['path'] as $k=>$v) {
                if(in_array($v,$pictures)){
                    $hasPic[] = $v;
                }else
                    $delPic[] = $pic['id'][$k];
            }
            $andPic = array_diff($pictures,$hasPic); //添加的图片

            $trans = Yii::app()->tr->beginTransaction();
            try {
                if ($model->save()) {
                    foreach ($andPic as $picture) {
                        $p = new HotelPicture();
                        $p->hotel_id = $model->hotel_id;
                        $p->room_id = $model->room_id;
                        $p->type = HotelPicture::TYPE_FANG_XING;
                        $p->path = $picture;
                        $p->creater = Yii::app()->user->name;
                        $p->created_at = $model->created_at;
                        if (!$p->save()) {
                            throw new Exception(CHtml::errorSummary($p));
                        }
                    }
                    if($delPic) {
                        $num = HotelPicture::model()->deleteByPk($delPic);
                        if(!$num)
                            throw new Exception('删除图片记录失败！'.implode('|',$delPic));
                    }
                } else {
                    throw new Exception(CHtml::errorSummary($model));
                }
                //删除图片文件
                $keyArr = array_flip($pic['id']);
                foreach($delPic as $v){
                    UploadedFile::delete(Yii::getPathOfAlias('uploads').'/'.$pic['path'][$keyArr[$v]]);
                }
                $trans->commit();
                @SystemLog::record(Yii::app()->user->name . "更新酒店房间：{$model->room_id}成功");
                Yii::app()->user->setFlash('success', '更新酒店房间成功！');
                $this->redirect($this->createAbsoluteUrl('hotelRoom/admin', array('hotelId' => $model->hotel_id)));
            }catch (Exception $e){
                $trans->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
        $this->render('update', array('model' => $model));

    }

    /**
     * 删除酒店房间
     * @param $roomId
     */
    public function actionDelete($roomId)
    {
        if (!is_numeric($roomId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $trans = Yii::app()->tr->beginTransaction();
        try {
            $room = HotelRoom::model()->find('room_id=:room_id', array(':room_id' => $roomId));
            $room->delete();
            $trans->commit();
            Yii::app()->user->setFlash('success', '删除成功！');
        } catch (Exception $e) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', '删除失败！');
        }
        $this->redirect($this->createAbsoluteUrl('hotelRoom/admin', array('hotelId' => $room->hotel_id)));
    }


    public function actionSetStock($roomId)
    {
        if (!is_numeric($roomId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $model = HotelRoom::model()->find('room_id=:room_id', array(':room_id' => $roomId));
        $this->render('setStock', array('model' => $model));
    }
} 