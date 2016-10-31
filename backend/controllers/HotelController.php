<?php

/**
 * 酒店控制器(酒店列表,酒店添加,酒店编辑,酒店删除)
 * @author binbin.liao  <277250538@qq.com>
 */
class HotelController extends Controller {

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
                    'table' => '{{hotel}}',
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
        return 'ajaxUpdateSort';
    }

    /**
     * 酒店添加
     */
    public function actionCreate() {
        /** @var Hotel $model */
        $model = new Hotel;
        $pictures = new HotelPicture;
        $this->performAjaxValidation(array($model, $pictures));

        if (isset($_POST['Hotel'], $_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('Hotel');
            $pictures->attributes = $this->getParam('HotelPicture');
            $dir = 'images/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $dir);  // 上传图片
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!$model->save(false))
                        throw new Exception('酒店信息保存失败!');
                    $pictures->target_id = $model->id;
                    $pictures->type = HotelPicture::TYPE_HOTEL;
                    if (!$pictures->validate())
                        throw new Exception('图片集验证失败!');
                    $inserts = array();
                    $imgs = array_filter(explode('|', $pictures->path));
                    foreach ($imgs as $val)
                        $inserts[] = "({$model->id}, '{$val}', " . HotelPicture::TYPE_HOTEL . " )";
                    if (!empty($inserts)) {
                        // 批量插入组图数据
                        $sql = "INSERT INTO {{hotel_picture}} (`target_id`, `path`, `type`) VALUES " . implode(',', $inserts);
                        if (!Yii::app()->db->createCommand($sql)->execute())
                            throw new Exception('图片集保存失败!');
                    }
                    $transaction->commit();
                    UploadedFile::saveFile('thumbnail', $model->thumbnail);  // 保存图片
                    $flag = true;
                } catch (Exception $e) {
                    $transaction->rollback(); // 数据回滚
                    Yii::app()->user->setFlash('error', Yii::t('hotel', $e->getMessage()));
                    $flag = false;
                }
                if ($flag) {
                    @SystemLog::record(Yii::app()->user->name . "添加酒店：{$model->name}");
                    Yii::app()->user->setFlash('success', Yii::t('hotel', '添加酒店信息成功！'));
                    $this->redirect(array('hotelRoom/admin', 'hotelId' => $model->id));
                }
            }
        }
        // 城市、地区下来选项的数据
        $province = $model->countries_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->countries_id)), 'id', 'name') : array();
        $city = $model->province_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->province_id)), 'id', 'name') : array();
        $district = $model->city_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->city_id)), 'id', 'name') : array();
        $this->render('create', array(
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'model' => $model,
            'pictures' => $pictures,
        ));
    }

    /**
     * 酒店编辑
     * @param integer $id   酒店ID
     * @throws CHttpException
     */
    public function actionUpdate($id) {
        /** @var Hotel $model */
        $model = $this->loadModel($id);
        $pictures = new HotelPicture;
        $this->performAjaxValidation(array($model, $pictures));

        if (isset($_POST['Hotel'], $_POST['HotelPicture'])) {
            $model->attributes = $this->getParam('Hotel');
            $pictures->attributes = $this->getParam('HotelPicture');
            $oldFile = $model->thumbnail; // 旧文件
            $dir = 'images/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $dir); // 上传图片
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!$model->save(false))
                        throw new Exception('酒店信息保存失败!');
                    $pictures->target_id = $model->id;
                    $pictures->type = HotelPicture::TYPE_HOTEL;
                    if (!$pictures->validate())
                        throw new Exception('图片集验证失败!');
                    $inserts = array();
                    $imgs = array_filter(explode('|', $pictures->path));
                    foreach ($imgs as $val)
                        $inserts[] = "({$model->id}, '{$val}', " . HotelPicture::TYPE_HOTEL . " )";
                    if (!empty($inserts)) {
                        // 删除图集
                        HotelPicture::model()->deleteAll('target_id = :tid AND type = :type', array(':tid' => $model->id, ':type' => HotelPicture::TYPE_HOTEL));
                        // 批量插入图集数据
                        $sql = "INSERT INTO {{hotel_picture}} (`target_id`, `path`, `type`) VALUES " . implode(',', $inserts);
                        if (!Yii::app()->db->createCommand($sql)->execute())
                            throw new Exception('图片集保存失败!');
                    }
                    $transaction->commit();
                    UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true); // 更新图片
                    $flag = true;
                } catch (Exception $e) {
                    $transaction->rollback(); // 数据回滚
                    Yii::app()->user->setFlash('error', Yii::t('hotel', $e->getMessage()));
                    $flag = false;
                }
                if ($flag) {
                    @SystemLog::record(Yii::app()->user->name . "修改酒店：" . $model->name);
                    Yii::app()->user->setFlash('success', Yii::t('hotelRoom', '更新酒店信息成功！'));
                    $this->redirect(array('hotelRoom/admin', 'hotelId' => $model->id));
                }
            }
        }
        if (!$pictures->path) {
            foreach ($model->pictures as $val)
                $pictures->path .= $val->path . '|';
        }
        // 城市、地区下来选项的数据
        $province = $model->countries_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->countries_id)), 'id', 'name') : array();
        $city = $model->province_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->province_id)), 'id', 'name') : array();
        $district = $model->city_id ? CHtml::listData(Region::model()->findAll('parent_id = :pid', array(':pid' => $model->city_id)), 'id', 'name') : array();
        $this->render('update', array(
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'model' => $model,
            'pictures' => $pictures,
        ));
    }

    /**
     * 酒店删除
     * @param int $id   酒店ID
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除酒店：" . $id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 酒店列表
     */
    public function actionAdmin() {
        $model = new Hotel('search');
        $model->unsetAttributes();
        if (isset($_GET['Hotel']))
            $model->attributes = $this->getParam('Hotel');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
