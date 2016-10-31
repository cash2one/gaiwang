<?php

/**
 *
 * 区域运费
 *
 * 操作(增改)
 * @author zhenjun_xu <412530435@qq.com>
 */
class FreightAreaController extends SController {

    /**
     * 新增区域运费
     * @param $id
     */
    public function actionCreate($id) {
        $model = new FreightArea();
        $model->default = $model::PARAM_DEFAULT;
        $model->default_freight = $model::PARAM_DEFAULT_FREIGHT;
        $model->added = $model::PARAM_ADDED;
        $model->added_freight = $model::PARAM_ADDED_FREIGHT;
        $this->performAjaxValidation($model);
        $typeModel = FreightType::model()->findByPk($id);
        $templateModel = FreightTemplate::model()->findByPk($typeModel->freight_template_id);
        if (isset($_POST['FreightArea'])) {
            //删除旧的数据
            $this->checkAccess($templateModel->store_id);
            $model = new FreightArea();
            $model->attributes = $this->getPost('FreightArea');

            FreightArea::model()->deleteAllByAttributes(array(
                'freight_type_id' => $id,
                'default' => $model->default,
                'default_freight' => $model->default_freight,
                'added' => $model->added,
                'added_freight' => $model->added_freight,
            ));
            //批量插入
            foreach ($_POST['FreightArea']['location_id'] as $v) {
                $model = new FreightArea();
                $model->attributes = $this->getPost('FreightArea');
                //如果不是简体，则转换货币
                if(Yii::app()->language!='zh_cn'){
                    $model->default_freight = Common::rateConvert($model->default_freight,Common::CURRENCY_RMB);
                    $model->added_freight = Common::rateConvert($model->added_freight,Common::CURRENCY_RMB);
                }
                $model->freight_type_id = $typeModel->id;
                $model->location_id = $v;
                $model->save();
            }
            //添加操作日志
            @$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeInsert,0,'新增区域运费');
            $this->redirect(array('freightType/view/', 'id' => $id));
        }


        $this->render('create', array('model' => $model, 'typeModel' => $typeModel));
    }

    /**
     * 修改区域运费
     * @param $id 运费类型id
     * @param $default 首量
     * @param $default_freight 首费
     * @param $added 续量
     * @param $added_freight 续费
     */
    public function actionUpdate($id, $default, $default_freight, $added, $added_freight) {
        $model = new FreightArea();
        $model->default = $default;
        $model->default_freight = $default_freight;
        $model->added = $added;
        $model->added_freight = $added_freight;
        $this->performAjaxValidation($model);
        $typeModel = FreightType::model()->findByPk($id);
        $groupArea = FreightArea::model()->findAllByAttributes(array(
            'freight_type_id' => $id,
            'default' => $model->default,
            'default_freight' => $model->default_freight,
            'added' => $model->added,
            'added_freight' => $model->added_freight,
        ));
        $areaArray = array();
        foreach ($groupArea as $v) {
            $areaArray[] = $v->location_id;
        }
        //更新
        $templateModel = FreightTemplate::model()->findByPk($typeModel->freight_template_id);
        if (isset($_POST['FreightArea'])) {
            //删除旧的数据
            $this->checkAccess($templateModel->store_id);
            $model->attributes = $this->getPost('FreightArea');

            //上一次的价格
            FreightArea::model()->deleteAllByAttributes(array(
                'freight_type_id' => $id,
                'default' => $default,
                'default_freight' => $default_freight,
                'added' => $added,
                'added_freight' => $added_freight,
            ));
            //本次修改后的价格
            FreightArea::model()->deleteAllByAttributes(array(
                'freight_type_id' => $id,
                'default' => $model->default,
                'default_freight' => $model->default_freight,
                'added' => $model->added,
                'added_freight' => $model->added_freight,
            ));
            //批量插入
            foreach ($_POST['FreightArea']['location_id'] as $v) {
                $model = new FreightArea();
                $model->attributes = $this->getPost('FreightArea');
                //如果不是简体，则转换货币
                if(Yii::app()->language!='zh_cn'){
                    $model->default_freight = Common::rateConvert($model->default_freight,Common::CURRENCY_RMB);
                    $model->added_freight = Common::rateConvert($model->added_freight,Common::CURRENCY_RMB);
                }
                $model->freight_type_id = $typeModel->id;
                $model->location_id = $v;
                $model->save();
            }
            
            
            //添加操作日志
		    @$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'修改区域运费');
            
            $this->redirect(array('freightType/view/', 'id' => $id));
        }

        $this->render('update', array('model' => $model, 'typeModel' => $typeModel, 'areaArray' => $areaArray));
    }

}
