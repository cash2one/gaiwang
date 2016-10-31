<?php


class HotAddressController extends TController
{


    /**
     * 酒店列表
     */
    public function actionAdmin()
    {
        $model = new HotAddress('search');
        $model->unsetAttributes();
        if (isset($_GET['HotAddress']))
            $model->attributes = $this->getParam('HotAddress');
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
        $model = new HotAddress();
        $this->performAjaxValidation($model);

        if (isset($_POST['HotAddress'])) {
            $model->attributes = $this->getParam('HotAddress');
            $model->creater = Yii::app()->user->name;
            $model->created_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "添加热门地址：{$model->name}成功");
                    Yii::app()->user->setFlash('success', '添加热门地址成功！');
                    $this->redirect(array('hotAddress/admin'));
                } else {
                    Yii::app()->user->setFlash('success', '添加热门地址失败！');
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
     * 更新热门地址
     * @param $id
     * @throws CHttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = HotAddress::model()->findByPk($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['HotAddress'])) {
            $model->attributes = $this->getParam('HotAddress');
            $model->updater = Yii::app()->user->name;
            $model->updated_at = time();
            if ($model->validate()) {
                if ($model->save(false)) {
                    @SystemLog::record(Yii::app()->user->name . "更新热门地址：{$model->name}成功");
                    Yii::app()->user->setFlash('success', '更新热门地址成功！');
                    $this->redirect(array('hotAddress/admin'));
                } else {
                    Yii::app()->user->setFlash('success', '更新热门地址失败！');
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }
        // 省份、城市下拉选项的数据
        $model->province_code = City::model()->find(array('select'=>'province_code','condition'=>'code=:code','params'=>array(':code'=>$model->city_code)))->province_code;
        $model->nation_id = Province::model()->find(array('select'=>'nation_id','condition'=>'code=:code','params'=>array(':code'=>$model->province_code)))->nation_id;

        $province =  CHtml::listData(Province::model()->findAll('nation_id = :nation_id', array(':nation_id' => $model->nation_id)), 'code', 'name');
        $city = CHtml::listData(City::model()->findAll('province_code = :province_code', array(':province_code' => $model->province_code)), 'code', 'name');
        $this->render('update', array(
            'province' => $province,
            'city' => $city,
            'model' => $model,

        ));
    }

    /**
     * 删除酒店
     * @param $hotelId
     */
    public function actionDelete($id)
    {
        if (!is_numeric($id)) {
            Yii::app()->user->setFlash('error', '参数错误！');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $trans = Yii::app()->tr->beginTransaction();
        try {
            HotAddress::model()->deleteByPk($id);
            $trans->commit();
            Yii::app()->user->setFlash('success', '删除成功！');
        } catch (Exception $e) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', '删除失败！');
        }
        $this->redirect(array('hotAddress/admin'));
    }

} 