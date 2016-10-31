<?php

/**
 *  运费编辑管理
 * @author csj
 */
class FreightEditController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 运费编辑列表
     */
    public function actionAdmin() {
        $model = new FreightEdit('search');
        $model->unsetAttributes();
        if (isset($_GET['FreightEdit']))
            $model->attributes = $_GET['FreightEdit'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
