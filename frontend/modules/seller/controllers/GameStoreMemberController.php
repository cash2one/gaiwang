<?php
/**
 * 游戏店铺用户信息
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/11/26 13:17
 */
class GameStoreMemberController extends SController
{
    /**
     * 查看游戏店铺用户
     */
    public function actionIndex()
    {
         //检查权限
        $gameStore = GameStore::model()->findByPk($this->gameStoreId);
        if(!$gameStore){
            throw new CHttpException(403,'您还没有创建游戏店铺！');
        }
        if($gameStore->franchise_stores <> GameStore::FRANCHISE_STORES_IS){
            throw new CHttpException(403,'您没有权限操作！');
        }

        $model = new GameOrder();
        $criteria = new CDbCriteria;
        if (isset($_POST['GameOrder'])) {
            $model->mobile = $_POST['GameOrder']['mobile'];
            $criteria->compare('mobile', $model->mobile,true);
        }
        $criteria->order = 'id DESC';

        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
        $pager->applyLimit($criteria);
        $items = GameOrder::model()->findAll($criteria);

        $this->render('index', array(
            'pages' => $pager,
            'items' => $items,
            'model' => $model
        ));
    }


    /**
     * 修改游戏用户信息
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->gameStoreCheck($model->store_id);//检查权限

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['GameStoreMember'])) {
            $model->real_name = $_POST['GameStoreMember']['real_name'];
            $model->mobile = $_POST['GameStoreMember']['mobile'];
            $model->member_address = $_POST['GameStoreMember']['member_address'];
            //$model->attributes = $this->getPost('GameStoreMember');
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreMember', '修改用户信息')  . Yii::t('GameStoreItems', '成功'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
}