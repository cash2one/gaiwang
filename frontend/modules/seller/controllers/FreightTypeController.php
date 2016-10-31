<?php

/**
 *
 * 运费类型
 * 操作(查改)
 * @author zhenjun_xu <412530435@qq.com>
 */
class FreightTypeController extends SController {

    public $defaultAction = 'view';
    /**
     * 查看运费类型
     * @param $id
     * @throws CHttpException
     */
    public function actionView($id) {
        $model = FreightType::model()->findByAttributes(array('id' => $id));
        $templateModel = FreightTemplate::model()->findByPk($model->freight_template_id);
        $this->checkAccess($templateModel->store_id);
        $groupArea = FreightArea::groupArea($id);
        $this->render('view', array(
            'model' => $model,
            'templateModel' => $templateModel,
            'groupArea' => $groupArea,
        ));
    }

    /**
     * 修改默认运费
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id) {
        $model = FreightType::model()->findByAttributes(array('id' => $id));
        $templateModel = FreightTemplate::model()->findByPk($model->freight_template_id);
        $this->checkAccess($templateModel->store_id);
        $this->performAjaxValidation($model);
        if (isset($_POST['FreightType'])) {
            $model->attributes = $this->getPost('FreightType');
            //如果不是简体，则转换货币
            if(Yii::app()->language!='zh_cn'){
                $model->default_freight = Common::rateConvert($model->default_freight,Common::CURRENCY_RMB);
                $model->added_freight = Common::rateConvert($model->added_freight,Common::CURRENCY_RMB);
            }
            if ($model->save()) {
            	//添加操作日志
		    	@$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,'修改默认运费');
                $this->redirect(array('freightType/view/', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model, 'templateModel' => $templateModel));
    }

    /**
     * 显示默认的运费设置
     * @param $model
     * @param $typeModel
     * @return string
     */
    public function showDefaultSet($model, $typeModel) {
        /** @var $model FreightTemplate */
        /** @var $typeModel FreightType */
        switch ($model->valuation_type) {
            case $model::VALUATION_TYPE_NUM:
                $str = Yii::t('freightType', '{1} 件 内，{2} ，每增加 {3}件，增加运费 {4}');
                break;
            case $model::VALUATION_TYPE_WEIGHT:
                $str = Yii::t('freightType', '{1} kg 内，{2} ，每增加 {3}，增加运费 {4}');
                break;
            case $model::VALUATION_TYPE_BULK;
                $str = Yii::t('freightType', '{1} m³ 内，{2} ，每增加 {3}m³，增加运费 {4}');
                break;
        }

        return strtr($str, array(
            '{1}' => $typeModel->default,
            '{2}' => HtmlHelper::formatPrice($typeModel->default_freight),
            '{3}' => $typeModel->added,
            '{4}' => HtmlHelper::formatPrice($typeModel->added_freight),
        ));
    }

    /**
     * ajax 关闭运送方式
     */
    public function actionClose(){
        if($this->isAjax()){
            $result = FreightType::model()->deleteAllByAttributes(array('mode'=>$this->getPost('mode'),
                'freight_template_id'=>$this->getPost('freightTmp')));
            if($result) echo 'ok';
        }
    }

}
