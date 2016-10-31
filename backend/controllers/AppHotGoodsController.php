<?php

class AppHotGoodsController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'checkGoodsID, getHotGoods';
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new AppHotGoods('search');
        $model->unsetAttributes();
        if (isset($_GET['AppHotGoods'])) {
            $model->attributes = $this->getParam('AppHotGoods');
            $model->name = $_GET['AppHotGoods']['name'];
            $model->categoryName = $_GET['AppHotGoods']['categoryName'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Ajax创建热卖商品
     */
    public function actionCreate(){
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            $type = $this->getPost('type');
            $order = $this->getPost('order');
            if (empty($order) || !preg_match("/^[1-9]\d*$/",$order) ) {
                exit(json_encode(array('error' => '排序值不能为空或不合格！')));
            }
            $model = new AppHotGoods();
            $model->goods_id = (int)$id;
            $model->type = (int)$type;
            $model->order = (int)$order;
            $model->status = 0;

            if($model->save()){
                SystemLog::record($this->getUser()->name . "创建商城热卖商品：" . $model->goods_id);
                exit(json_encode(array('success' => '创建商城热卖商品'.$model->goods_id.'成功')));
            }else
                exit(json_encode(array('error' => '添加失败')));
        }
    }

    /**
     * Ajax修改热卖商品
     */
    public function actionUpdate(){
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            $order = $this->getPost('order');
            if (empty($order) || !preg_match("/^[1-9]\d*$/",$order) ) {
                exit(json_encode(array('error' => '排序值不能为空或不合格！')));
            }
            $model = $this->loadModel($id);
            $model->order = (int)$order;

            if($model->save()){
                SystemLog::record($this->getUser()->name . "修改商城热卖商品：" . $model->goods_id);
                exit(json_encode(array('success' => '修改商城热卖商品'.$model->goods_id.'成功')));
            }else
                exit(json_encode(array('error' => '添加失败')));
        }
    }

    /**
     * AJAX验证商品ID是否是上架产品和是否已添加到热卖商品
     */
    public function actionCheckGoodsID() {
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            if (empty($id) || !preg_match("/^[1-9]\d*$/",$id)) {
                exit(json_encode(array('error' => '商品ID不能为空或不合格！')));
            }

            $type = $this->getPost('type');
            $result = AppHotGoods::isAddHotGoods($id,$type);
            if ($result) {
                exit(json_encode(array('error' => '该商品已添加到' . AppHotGoods::getType($type). '，请重新选择商品！')));
            }
            $goodsInfo = AppHotGoods::searchGoodsInfo($id);
            if (empty($goodsInfo)) {
                exit(json_encode(array('error' => '该商品不存在或没上架，请重新选择商品！')));
            } else {
                $goodsInfo['success'] = TRUE;
                exit(json_encode($goodsInfo));
            }
        }
    }

    /**
     * ajax获取热卖商品信息
     */
    public function actionGetHotGoods($id){
        $result = AppHotGoods::searchHotGoodsInfo($id);
        echo $result;
    }

    /**
     * ajax删除商品
     */
    public function actionRemove() {
        if ($this->isAjax()) {
            $id = $this->getQuery('id');
            $model = $this->loadModel($id);
            $oldModel = $model;
            $result = array(
                'error' => 1,
                'content' => Yii::t('AppHotGoods', ''),
            );
            if($model->delete()){
                SystemLog::record($this->getUser()->name . '删除商城app' . AppHotGoods::getType($oldModel->type) . '，ID为：' . $oldModel->id);
                $result['error'] = 0;
                $result['content'] = Yii::t('AppHotGoods', '删除商城app') . '"' . AppHotGoods::getType($oldModel->type) . '"' . Yii::t('AppHotGoods', '成功');
            }else{
                $result['error'] = 1;
                $result['content'] = '移除失败';
            }
            echo CJSON::encode($result);
        }
        Yii::app()->end();
    }
}
