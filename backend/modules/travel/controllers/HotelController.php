<?php


class HotelController extends TController
{

    /**
     * 外部操作
     * @return array
     */
    public function actions()
    {
        return array(
            'ajaxUpdateSort' => array(
                'class' => 'CommonAction',
                'method' => 'ajaxUpdateSort',
                'params' => array(
                    'db' => 'tr',
                    'table' => '{{hotel}}',
                ),
            ),
        );
    }

    /**
     * 酒店列表
     */
    public function actionAdmin()
    {
        $model = new Hotel('search');
        $model->unsetAttributes();
        if (isset($_GET['Hotel']))
            $model->attributes = $this->getParam('Hotel');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 添加酒店
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Hotel();
        $this->performAjaxValidation($model);

        if (isset($_POST['Hotel'])) {
            $model->attributes = $this->getParam('Hotel');
            $dir = 'travel/hotel/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'appearance_pic_url', $dir);  // 上传图片
            $model->hotel_id = Hotel::createHandHotelID();
            $model->source = Hotel::SOURCE_BY_HAND;
            $model->created_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    UploadedFile::saveFile('appearance_pic_url', $model->appearance_pic_url);  // 保存图片
                    @SystemLog::record(Yii::app()->user->name . "添加酒店：{$model->chn_name}成功");
                    Yii::app()->user->setFlash('success', '添加酒店信息成功！');
                    $this->redirect(array('hotel/admin'));
                } else {
                    Yii::app()->user->setFlash('success', '添加酒店信息失败！');
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }

        $this->render('create', array(
            'model' => $model,

        ));
    }

    /**
     * 更新酒店信息
     * @param $id
     * @throws CHttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Hotel'])) {
            $model->attributes = $this->getParam('Hotel');
            $dir = 'travel/hotel/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'appearance_pic_url', $dir);  // 上传图片
            $model->updater = Yii::app()->user->id;
            $model->updated_at = time();

            if ($model->validate()) {
                $oldPic = $this->getParam('appearance_pic_url_old');
                if ($model->save(false)) {
                    UploadedFile::saveFile('appearance_pic_url', $model->appearance_pic_url, $oldPic, true);  // 保存图片并删除旧图
                    @SystemLog::record(Yii::app()->user->name . "更新酒店：{$model->chn_name}成功");
                    Yii::app()->user->setFlash('success', '更新酒店信息成功！');
                    $this->redirect(array('hotel/admin'));
                } else {
                    Yii::app()->user->setFlash('error', '更新酒店信息失败');
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }
        // 城市、地区下来选项的数据
        $model->province_code = City::model()->find(array('select'=>'province_code','condition'=>'code=:code','params'=>array(':code'=>$model->city_code)))->province_code;
        $model->nation_id = Province::model()->find(array('select'=>'nation_id','condition'=>'code=:code','params'=>array(':code'=>$model->province_code)))->nation_id;

        $province =  CHtml::listData(Province::model()->findAll('code = :code', array(':code' => $model->province_code)), 'code', 'name');
        $city = CHtml::listData(City::model()->findAll('code = :code', array(':code' => $model->city_code)), 'code', 'name');
        $distinct = $model->distinct ? CHtml::listData(District::model()->findAll('code = :code', array(':code' => $model->distinct)), 'code', 'name') : array();
        $business = $model->business ? CHtml::listData(Business::model()->findAll('code = :code', array(':code' => $model->business)), 'code', 'name') : array();
        $this->render('update', array(
            'province' => $province,
            'city' => $city,
            'district' => $distinct,
            'business' => $business,
            'model' => $model,

        ));
    }

    /**
     * 删除酒店
     * @param $hotelId
     */
    public function actionDelete($hotelId)
    {
        if (!is_numeric($hotelId)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $trans = Yii::app()->tr->beginTransaction();
        try {
            Hotel::model()->deleteAll('hotel_id=:hotel_id', array(':hotel_id' => $hotelId));
            HotelRoom::model()->deleteAll('hotel_id=:hotel_id', array(':hotel_id' => $hotelId));
            $trans->commit();
            Yii::app()->user->setFlash('success', '删除成功！');
        } catch (Exception $e) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', '删除失败！');
        }
        $this->redirect(array('hotel/admin'));
    }

} 