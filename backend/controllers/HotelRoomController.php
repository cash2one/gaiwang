<?php

/**
 * 酒店客房控制器(添加,修改,删除,列表)
 * @author binbin.liao <277250538@qq.com>
 */
class HotelRoomController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 外部操作
     * @return array
     * @author jianlin.lin
     */
    public function actions() {
        return array(
            'ajaxUpdateSort' => array(
                'class' => 'CommonAction',
                'method' => 'ajaxUpdateSort',
                'params' => array(
                    'table' => '{{hotel_room}}',
                ),
            ),
        );
    }

    /**
     * 不受权限控制的动作
     * @return string
     * @author jianlin.lin
     */
    public function allowedActions() {
        return 'ajaxUpdateSort, getReturnScore';
    }

    /**
     * 创建客房
     * @param int $hotelId 酒店ID
     */
    public function actionCreate($hotelId) {
        $model = new HotelRoom;
        $model->hotel_id = (int) $hotelId; // 酒店ID
        $pictures = new HotelPicture;
        $this->performAjaxValidation(array($model, $pictures));

        // 设置默认值
        $model->bed = 1;
        $model->breadfast = 0;
        $model->network = 0;
        $model->scenario='insert'; // 设置活动价场景
        if (isset($_POST['HotelRoom'], $_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('HotelRoom');
            $pictures->attributes = $this->getParam('HotelPicture');
            $dir = 'images/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $dir);  // 上传图片
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!$model->save(false))
                        throw new Exception('添加客房信息失败!');
                    $pictures->target_id = $model->id;
                    $pictures->type = HotelPicture::TYPE_ROOM;
                    if (!$pictures->validate())
                        throw new Exception('图片集验证失败!');
                    $inserts = array();
                    $imgs = array_filter(explode('|', $pictures->path));
                    foreach ($imgs as $val)
                        $inserts[] = "({$model->id}, '{$val}', " . HotelPicture::TYPE_ROOM . " )";
                    if (!empty($inserts)) {
                        // 批量插入图集数据
                        $sql = "INSERT INTO {{hotel_picture}} (`target_id`, `path`, `type`) VALUES " . implode(',', $inserts);
                        if (!Yii::app()->db->createCommand($sql)->execute())
                            throw new Exception('图片集保存失败!');
                    }
                    $transaction->commit();
                    UploadedFile::saveFile('thumbnail', $model->thumbnail);  // 保存图片
                    $flag = true;
                } catch (Exception $e) {
                    $transaction->rollback(); // 数据回滚
                    Yii::app()->user->setFlash('error', Yii::t('hotelRoom', $e->getMessage()));
                    $flag = false;
                }
                if ($flag) {
                    @SystemLog::record(Yii::app()->user->name . "添加客房信息：酒店ID[{$model->hotel_id}]|客房名称[{$model->name}]");
                    Yii::app()->user->setFlash('success', Yii::t('hotelRoom', '添加客房信息成功！'));
                    $this->redirect(array('admin', 'hotelId' => $model->hotel_id));
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'pictures' => $pictures,
        ));
    }

    /**
     * 更新客房信息
     * @param integer $id   客房ID
     * @throws CHttpException
     */
    public function actionUpdate($id) {
        /** @var HotelRoom $model */
        $model = $this->loadModel($id);
        $model->activities_start = $model->activities_start == 0 ? '' : date('Y-m-d H:i:s', $model->activities_start);
        $model->activities_end = $model->activities_end == 0 ? '' : date('Y-m-d H:i:s', $model->activities_end);
        $pictures = new HotelPicture;
        $this->performAjaxValidation(array($model, $pictures));
        
        $model->scenario='update'; // 设置活动价场景
        if (isset($_POST['HotelRoom'], $_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('HotelRoom');
            $pictures->attributes = $this->getParam('HotelPicture');
            $oldFile = $model->thumbnail;  // 旧文件
            $dir = 'images/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $dir);  // 上传图片
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!$model->save(false))
                        throw new Exception('更新客房信息失败！');

                    //检查 更新酒店状态
                    $this->checkRooms($model->hotel_id,$model->hotel->status);

                    $pictures->target_id = $model->id;
                    $pictures->type = HotelPicture::TYPE_ROOM;
                    if (!$pictures->validate())
                        throw new Exception('图片集验证失败!');
                    $inserts = array();
                    $imgs = array_filter(explode('|', $pictures->path));
                    foreach ($imgs as $val)
                        $inserts[] = "({$model->id}, '{$val}', " . HotelPicture::TYPE_ROOM . " )";
                    if (!empty($inserts)) {
                        // 删除图集
                        HotelPicture::model()->deleteAll('target_id = :tid AND type = :type', array(':tid' => $model->id, ':type' => HotelPicture::TYPE_ROOM));
                        // 批量插入图集数据
                        $sql = "INSERT INTO {{hotel_picture}} (`target_id`, `path`, `type`) VALUES " . implode(',', $inserts);
                        if (!Yii::app()->db->createCommand($sql)->execute())
                            throw new Exception('图片集保存失败！');
                    }
                    $transaction->commit();
                    UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true);  // 保存图片
                    $flag = true;
                } catch (Exception $e) {
                    $transaction->rollback(); // 数据回滚
                    Yii::app()->user->setFlash('error', Yii::t('hotelRoom', $e->getMessage()));
                    $flag = false;
                }
                if ($flag) {
                    @SystemLog::record(Yii::app()->user->name . "更新客房信息：酒店ID[{$model->hotel_id}]|客房名称[{$model->name}]");
                    Yii::app()->user->setFlash('success', Yii::t('hotelRoom', '更新客房信息成功！'));
                    $this->redirect(array('admin', 'hotelId' => $model->hotel_id));
                }
            }
        }
        if (!$pictures->path) {
            foreach ($model->pictures as $val)
                $pictures->path .= $val->path . '|';
        }

//        Tool::pr($model);
        $this->render('update', array(
            'model' => $model,
            'pictures' => $pictures,
        ));
    }

    /**
     * 删除酒店客房
     */
    public function actionDelete($id) {
        $tag = false;
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $model = $this->loadModel($id);
            $model->delete();
            $this->checkRooms($model->hotel_id,$model->hotel->status);
            $transaction->commit();
            $tag = true;
        }catch (Exception $e){
            $transaction->rollback(); // 数据回滚
            Yii::app()->user->setFlash('error', Yii::t('hotelRoom', $e->getMessage()));
        }
        if($tag)
            @SystemLog::record(Yii::app()->user->name . "删除客房信息：" . $id." 成功");
        else
            @SystemLog::record(Yii::app()->user->name . "删除客房信息：" . $id." 失败");

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 酒店客房列表
     * @param integer $hotelId 酒店ID
     * @throws CHttpException
     */
    public function actionAdmin($hotelId) {
        $hotel = Hotel::model()->with(array('level', 'brand', 'province', 'city'))->findByPk((int) $hotelId);
        if ($hotel === null) {
            throw new CHttpException(404, '请求的页面不存在.');
        }
        // 当前酒店下的客房数据
        $dataProvider = new CActiveDataProvider('HotelRoom', array(
            'criteria' => array('condition' => 'hotel_id = ' . $hotel->id),
            'sort' => array(
                'defaultOrder' => 'sort DESC',
            ),
        ));
        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'hotel' => $hotel,
        ));
    }

    /**
     * 获取预估返还积分
     */
    public function actionGetReturnScore() {
        if ($this->isAjax()) {
            $unitPrice = $this->getParam('unitPrice');
            $gaiPrice = $this->getParam('gaiPrice');
            $gaiIncome = $this->getParam('gaiIncome');
            $score = Common::convertReturn($gaiPrice, $unitPrice, $gaiIncome / 100, 'hotelOnConsume');
            echo $score < 0 ? 0 : json_encode($score);
        } else {
            throw new CHttpException(400, Yii::t('hotelOrder', '无效的请求。'));
        }
    }

    /**
     * 检查 酒店是否有房间或者是否有发布的房间，如果没，则更改酒店状态为未发布
     * @param $hotel_id
     * @param $status
     * @throws Exception
     */
    public function checkRooms($hotel_id,$status)
    {
        if ($status == Hotel::STATUS_UNPUBLISH)
            return true;
        $count = Yii::app()->db->createCommand()
            ->select('count(distinct id) as count')
            ->from('{{hotel_room}}')
            ->where('status = :status and hotel_id = :hotel_id', array(':status' => HotelRoom::STATUS_PUBLISH, ':hotel_id' => $hotel_id))
            ->queryScalar();
        if (!$count) {
            $rs = Hotel::model()->updateByPk($hotel_id, array('status' => Hotel::STATUS_UNPUBLISH));
            if (!$rs)
                throw new Exception('更新酒店状态失败');
        }
    }

}
