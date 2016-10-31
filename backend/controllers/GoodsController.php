<?php

/**
 * 后台商品控制器
 * 操作（列表，编辑）
 * @author binbin.liao <277250538@qq.com>
 */
class GoodsController extends Controller {

//    public function filters() {
//        return array(
//            'rights',
//        );
//    }
//
//    public function actionUpdate($id) {
//        $model = $this->loadModel($id);
//        $imgModel = new GoodsPicture;
//        $imgModel->path = $model->pic;
//        $imgModelPic = GoodsPicture::model()->findAll('target_id=' . $id);
//
//        $type_id = 9; //类型id
//        $cate_id = 1; //商品分类id
//        $store_id = $this->getSession('storeId'); //商铺id
//
//        if (isset($_POST['Goods'])) {
//            $model->attributes = $_POST['Goods'];
//            $model->store_id = $store_id; //所属商家id
//            $model->type_id = $type_id;
//            $model->category_id = $cate_id;
//
//
//            if ($model->save()) {
//            	@SystemLog::record(Yii::app()->user->name."修改商品：".$model->name);
//                $this->redirect(array('view', 'id' => $model->id));
//            }
//        }
//
//        $this->render('update', array(
//            'model' => $model,
//            'imgModelPic' => $imgModelPic, //多图片数据
//        ));
//    }
//
//    public function actionAdmin() {
//        $model = new Product('search');
//        $model->unsetAttributes();
//        if (isset($_GET['Goods']))
//            $model->attributes = $_GET['Goods'];
//
//        $this->render('admin', array(
//            'model' => $model,
//        ));
//    }
//
//    public function loadModel($id) {
//        $model = Goods::model()->with('goods2spec_id')->findByPk($id);
//
//        foreach ($model->goods2spec_id as $s) {
//            $model->spec_id = $s->id;
//        }
//        foreach ($model->goodsPicture as $p) {
//            $model->pic.=$p->path . '|';
//        }
//        if ($model === null)
//            throw new CHttpException(404, 'The requested page does not exist.');
//        return $model;
//    }
//
//    /**
//     * 删除附件(包括数据库的数据和文件)
//     * @return [type] [description]
//     */
//    public function actionRemove() {
//        $imageId = intval($this->getParam('imageId'));
//        try {
//            $imageModel = GoodsPicture::model()->findByPk($imageId);
//            if ($imageModel == false)
//                throw new Exception("附件已经被删除");
//            @unlink(Yii::getPathOfAlias('uploads') . $imageModel->path);
//            // @unlink($imageModel->thumb_name);
//            if (!$imageModel->delete())
//                throw new Exception("数据删除失败");
//            $var['state'] = 'success';
//            $var['message'] = '删除完成';
//            
//            @SystemLog::record(Yii::app()->user->name."删除商品附件：".$imageId);
//            
//        } catch (Exception $e) {
//            $var['state'] = 'errro';
//            $var['message'] = '失败：' . $e->getMessage();
//        }
//        exit(CJSON::encode($var));
//    }
//
//    /**
//     * AJAX 设置取消首页推荐
//     */
//    public function actionSetCancel() {
//        $id = $this->getParam('id');
//        if (Goods::model()->updateByPk($id, array('show' => 0))) {
//        	@SystemLog::record(Yii::app()->user->name."取消商品首页推荐：".$id);
//            $var['state'] = 'success';
//        }
//        exit(CJSON::encode($var));
//    }
//
//    /**
//     * AJAX 设置为首页推荐
//     */
//    public function actionSetShow() {
//        $id = $this->getParam('id');
//        if (Goods::model()->updateByPk($id, array('show' => 1))) {
//        	@SystemLog::record(Yii::app()->user->name."设置商品首页推荐：".$id);
//            $var['state'] = 'success';
//        }
//        exit(CJSON::encode($var));
//    }
//    /**
//     * 搜索商品
//     */
//    public function actionGetGoods() {
//        $model = new Goods('search');
//        $model->unsetAttributes();
//        if (isset($_GET['Goods']))
//            $model->attributes = $_GET['Goods'];
//        $this->render('selectgoods', array(
//            'model' => $model,
//        ));
//    }
//    
//    /**
//     * 获取商品 ajax 请求方式
//     * @param int $id
//     * @return json 
//     */
//    public function actionGetGoodsData($id) {
//        if ($this->isAjax()) {
//            $model = Goods::model()->find('id = :id', array('id' => $id));
//            if (!is_null($model))
//                echo CJSON::encode($model->attributes);
//            else
//                echo CJSON::encode(null);
//        }
//    }

}
