<?php

class AuditingController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Auditing('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Auditing'])) {
            $model->attributes = $_GET['Auditing'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 查看申请的详情
     */
    public function actionView() {
        $id = $this->getParam('id');
        if ($id) {
            $model = $this->loadModel($id);
            $dataArr = CJSON::decode($model->apply_content);
            $model->attributes = $dataArr;
            if (isset($dataArr['path']))
                $model->path = $dataArr['path'];
            if ($model->status != Auditing::STATUS_APPLY || !in_array($model->apply_type, array(Auditing::APPLY_TYPE_BIZ_ADD, Auditing::APPLY_TYPE_BIZ_BASE, Auditing::APPLY_TYPE_BIZ_GUANJIAN))) {
                throw new CHttpException(404, '此页面不存在');
            }
        }

        if ($model->apply_type == Auditing::APPLY_TYPE_BIZ_BASE) { //基本信息
            $this->breadcrumbs = array('加盟商管理', '审核加盟商【' . $model->apply_name . '】的基础信息');
            $model->setScenario('base');
            $this->performAjaxValidation($model);
            if (isset($_POST['Auditing'])) {
                $model = $this->loadModel($_POST['Auditing']['id']);


                $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                $model->auditor_id = Yii::app()->user->id;
                $model->auditor_name = Yii::app()->user->name;
                $model->audit_time = time();

                if ($_POST['Auditing']['status'] == Auditing::STATUS_PASS) {
                    $model->attributes = $_POST['Auditing'];
                    $dataArr['province_id'] = isset($_POST['Auditing']['province_id']) ? $_POST['Auditing']['province_id'] : $dataArr['province_id'];
                    $dataArr['city_id'] = isset($_POST['Auditing']['city_id']) ? $_POST['Auditing']['city_id'] : $dataArr['city_id'];
                    $dataArr['district_id'] = isset($_POST['Auditing']['district_id']) ? $_POST['Auditing']['district_id'] : $dataArr['district_id'];
                    $dataArr['street'] = isset($_POST['Auditing']['street']) ? $_POST['Auditing']['street'] : $dataArr['street'];
                    $dataArr['lat'] = isset($_POST['Auditing']['lat']) ? $_POST['Auditing']['lat'] : $dataArr['lat'];
                    $dataArr['lng'] = isset($_POST['Auditing']['lng']) ? $_POST['Auditing']['lng'] : $dataArr['lng'];
                    $dataArr['summary'] = isset($_POST['Auditing']['summary']) ? $_POST['Auditing']['summary'] : $dataArr['summary'];
                    $dataArr['main_course'] = isset($_POST['Auditing']['main_course']) ? $_POST['Auditing']['main_course'] : $dataArr['main_course'];
                    $dataArr['category_id'] = isset($_POST['Auditing']['category_id']) ? $_POST['Auditing']['category_id'] : $dataArr['category_id'];
                    $dataArr['logo'] = isset($_POST['Auditing']['logo']) ? $_POST['Auditing']['logo'] : $dataArr['logo'];
                    $dataArr['path'] = isset($_POST['Auditing']['path']) ? $_POST['Auditing']['path'] : $dataArr['path'];
                    $dataArr['mobile'] = isset($_POST['Auditing']['mobile']) ? $_POST['Auditing']['mobile'] : $dataArr['mobile'];
                    $dataArr['qq'] = isset($_POST['Auditing']['qq']) ? $_POST['Auditing']['qq'] : $dataArr['qq'];
                    $dataArr['url'] = isset($_POST['Auditing']['url']) ? $_POST['Auditing']['url'] : $dataArr['url'];
                    $dataArr['keywords'] = isset($_POST['Auditing']['keywords']) ? $_POST['Auditing']['keywords'] : $dataArr['keywords'];
                    $dataArr['fax'] = isset($_POST['Auditing']['fax']) ? $_POST['Auditing']['fax'] : $dataArr['fax'];
                    $dataArr['zip_code'] = isset($_POST['Auditing']['zip_code']) ? $_POST['Auditing']['zip_code'] : $dataArr['zip_code'];
                    $dataArr['notice'] = isset($_POST['Auditing']['notice']) ? $_POST['Auditing']['notice'] : $dataArr['notice'];
                    $dataArr['description'] = isset($_POST['Auditing']['description']) ? $_POST['Auditing']['description'] : $dataArr['description'];

                    $model->apply_content = CJSON::encode($dataArr);
                    $rs = Auditing::passBiz($model);
                    if ($rs) {
                        @SystemLog::record(Yii::app()->user->name . "批量通过加盟商审核基础信息：{$model->apply_name}");
                        $this->setFlash('succeed', Yii::t('auditing', '批量通过成功！'));
                    } else {
                    	@SystemLog::record(Yii::app()->user->name . "批量通过加盟商审核基础信息：{$model->apply_name} 失败");
                        $this->setFlash('error', Yii::t('auditing', '操作有误，请重新操作'));
                    }
                } else {
                    $model->status = Auditing::STATUS_NOPASS;
                    $model->audit_opinion = $_POST['Auditing']['audit_opinion'];
                    $model->update();
                    
                    @SystemLog::record(Yii::app()->user->name . "通过加盟商审核基础信息：{$model->apply_name}");
                }


                $this->redirect(array('auditing/admin'));
            }
        } elseif ($model->apply_type == Auditing::APPLY_TYPE_BIZ_GUANJIAN) {
            $this->breadcrumbs = array('加盟商管理', '审核加盟商【' . $model->apply_name . '】的关键信息');
            $model->setScenario('key');
            $this->performAjaxValidation($model);
            if (isset($_POST['Auditing'])) {
                $model = $this->loadModel($_POST['Auditing']['id']);


                $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                $model->auditor_id = Yii::app()->user->id;
                $model->auditor_name = Yii::app()->user->name;
                $model->audit_time = time();
                if ($_POST['Auditing']['status'] == Auditing::STATUS_PASS) {
                    $model->attributes = $_POST['Auditing'];
                    $dataArr['name'] = isset($_POST['Auditing']['name']) ? $_POST['Auditing']['name'] : $dataArr['name'];
                    $dataArr['alias_name'] = isset($_POST['Auditing']['alias_name']) ? $_POST['Auditing']['alias_name'] : $dataArr['alias_name'];
                    $dataArr['parent_id'] = isset($_POST['Auditing']['parent_id']) ? $_POST['Auditing']['parent_id'] : $dataArr['parent_id'];
                    $dataArr['max_machine'] = isset($_POST['Auditing']['max_machine']) ? $_POST['Auditing']['max_machine'] : $dataArr['max_machine'];
                    $dataArr['gai_discount'] = isset($_POST['Auditing']['gai_discount']) ? $_POST['Auditing']['gai_discount'] : $dataArr['gai_discount'];
                    $dataArr['member_discount'] = isset($_POST['Auditing']['member_discount']) ? $_POST['Auditing']['member_discount'] : $dataArr['member_discount'];
                    $dataArr['gai_number'] = isset($_POST['Auditing']['member_id']) ? $_POST['Auditing']['member_id'] : $dataArr['gai_number'];
                    //将盖网编号转化成盖网id
                    $sql = "select id from " . Member::model()->tableName() . " where gai_number = '" . $_POST['Auditing']['member_id'] . "' limit 1";
                    $member = Yii::app()->db->createCommand($sql)->queryRow();
                    $dataArr['member_id'] = $member['id'];
                    $model->apply_content = CJSON::encode($dataArr);
                    $rs = Auditing::passBiz($model);
                    if ($rs) {
                        @SystemLog::record(Yii::app()->user->name . "批量通过加盟商审核关键信息：{$model->apply_name}");
                        $this->setFlash('succeed', Yii::t('auditing', '批量通过成功！'));
                    } else {
                    	@SystemLog::record(Yii::app()->user->name . "批量通过加盟商审核关键信息：{$model->apply_name} 失败");
                        $this->setFlash('error', Yii::t('auditing', '操作有误，请重新操作'));
                    }
                } else {
                    $model->status = Auditing::STATUS_NOPASS;
                    $model->audit_opinion = $_POST['Auditing']['audit_opinion'];
                    $model->update();
                    @SystemLog::record(Yii::app()->user->name . "通过加盟商审核关键信息：{$model->apply_name}");
                }
                $this->redirect(array('auditing/admin'));
            }
        } else {
            //添加加盟商
            $this->breadcrumbs = array('加盟商管理', '审核添加加盟商');
            $model->setScenario('create');
            $this->performAjaxValidation($model);
            if (isset($_POST['Auditing'])) {
                $model = $this->loadModel($_POST['Auditing']['id']);

                $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                $model->auditor_id = Yii::app()->user->id;
                $model->auditor_name = Yii::app()->user->name;
                $model->audit_time = time();

                if ($_POST['Auditing']['status'] == Auditing::STATUS_PASS) {
                    $model->attributes = $_POST['Auditing'];
                    $dataArr = array(
                        'alias_name' => $_POST['Auditing']['alias_name'],
                        'parent_id' => $_POST['Auditing']['parent_id'],
                        'max_machine' => $_POST['Auditing']['max_machine'],
                        'gai_discount' => $_POST['Auditing']['gai_discount'],
                        'member_discount' => $_POST['Auditing']['member_discount'],
                        'province_id' => $_POST['Auditing']['province_id'],
                        'city_id' => $_POST['Auditing']['city_id'],
                        'district_id' => $_POST['Auditing']['district_id'],
                        'street' => $_POST['Auditing']['street'],
                        'lat' => $_POST['Auditing']['lat'],
                        'lng' => $_POST['Auditing']['lng'],
                        'summary' => $_POST['Auditing']['summary'],
                        'main_course' => $_POST['Auditing']['main_course'],
                        'category_id' => $_POST['Auditing']['category_id'],
                        'logo' => $_POST['Auditing']['logo'],
                        'path' => $_POST['Auditing']['path'],
                        'mobile' => $_POST['Auditing']['mobile'],
                        'qq' => $_POST['Auditing']['qq'],
                        'url' => $_POST['Auditing']['url'],
                        'keywords' => $_POST['Auditing']['keywords'],
                        'fax' => $_POST['Auditing']['fax'],
                        'zip_code' => $_POST['Auditing']['zip_code'],
                        'notice' => $_POST['Auditing']['notice'],
                        'description' => $_POST['Auditing']['description'],
                        'parentname' => $_POST['Auditing']['parentname'],
                    );

                    //将盖网编号转化成盖网id
                    $sql = "select id from " . Member::model()->tableName() . " where gai_number = '" . $_POST['Auditing']['member_id'] . "' limit 1";
                    $member = Yii::app()->db->createCommand($sql)->queryRow();
                    $dataArr['gai_number'] = $_POST['Auditing']['member_id'];
                    $dataArr['member_id'] = $member['id'];
                    $oldArray = CJSON::decode($model->apply_content);
                    $dataArr = CMap::mergeArray($oldArray, $dataArr);
                    $model->apply_content = CJSON::encode($dataArr);
                    $rs = Auditing::passBiz($model);
                    if ($rs) {
                        @SystemLog::record(Yii::app()->user->name . "审核添加加盟商：{$_POST['Auditing']['alias_name']}");
                        $this->setFlash('succeed', Yii::t('auditing', '审核通过成功！'));
                        $this->redirect(array('auditing/admin'));
                    } else {
                    	@SystemLog::record(Yii::app()->user->name . "审核添加加盟商：{$_POST['Auditing']['alias_name']} 失败");
                        $this->setFlash('error', Yii::t('auditing', '操作有误，请重新操作'));
                    }
                } else {
                    $model->status = Auditing::STATUS_NOPASS;
                    $model->audit_opinion = $_POST['Auditing']['audit_opinion'];
                    $model->update();
                    @SystemLog::record(Yii::app()->user->name . "审核添加加盟商：{$_POST['Auditing']['alias_name']}");
                    $this->redirect(array('auditing/admin'));
                }
            }
        }

        $model->member_id = Auditing::findGWNoById($model->member_id);
        $this->render('view', array(
            'model' => $model
        ));
    }

    /**
     * 批量通过申请
     */
    public function actionPass($id) {
        $id = explode(',', $id);
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $id);
        $criteria->addCondition('status = ' . Auditing::STATUS_APPLY);
        $criteria->addInCondition('apply_type', array(Auditing::APPLY_TYPE_BIZ_ADD, Auditing::APPLY_TYPE_BIZ_BASE, Auditing::APPLY_TYPE_BIZ_GUANJIAN));
        $models = Auditing::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
            $model->auditor_id = Yii::app()->user->id;
            $model->auditor_name = Yii::app()->user->name;
            $model->audit_time = time();
            $model->status = Auditing::STATUS_PASS;
        }
        $rs = Auditing::batchPassBiz($models);
        if ($rs) {
            @SystemLog::record(Yii::app()->user->name . "批量通过审核加盟商：" . implode(',', $id));
            $this->setFlash('succeed', Yii::t('auditing', '批量通过成功！'));
        } else {
        	@SystemLog::record(Yii::app()->user->name . "批量通过审核加盟商：" . implode(',', $id)."失败");
            $this->setFlash('error', Yii::t('auditing', '操作有误，请重新操作'));
        }
        $this->redirect(array('auditing/admin'));
    }

    /**
     * 批量审核不通过
     */
    public function actionNotPass($id) {
        header("Content-type:text/html;charset=utf-8");
        $id = explode(',', $id);
        $txtOpinion = $this->getParam('txtOpinion');
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $id);
        $criteria->addCondition('status = ' . Auditing::STATUS_APPLY);
        $criteria->addInCondition('apply_type', array(Auditing::APPLY_TYPE_BIZ_ADD, Auditing::APPLY_TYPE_BIZ_BASE, Auditing::APPLY_TYPE_BIZ_GUANJIAN));
        $models = Auditing::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
            $model->auditor_id = Yii::app()->user->id;
            $model->auditor_name = Yii::app()->user->name;
            $model->audit_time = time();
            $model->status = Auditing::STATUS_NOPASS;
            $model->audit_opinion = $txtOpinion;
            $model->save(false);
        }
        @SystemLog::record(Yii::app()->user->name . "审核加盟商批量不通过：" . implode(',', $id));
        $this->setFlash('succeed', Yii::t('auditing', '批量不通过成功！'));
        $this->redirect(array('auditing/admin'));
    }

}
