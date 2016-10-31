<?php
/**
 * 游戏店铺发货
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/11/26 17:32
 */
class GameStoreDeliveryController extends SController{
    /**
     * 添加发货记录
     */
    public function actionCreate($id) {
        $model = new GameStoreDelivery();
        if($model->find('total_order_id = :id',array('id'=>$id))){
            $this->setFlash('error', Yii::t('GameStoreDelivery', '已提交发货记录，请不要重复提交'));
            $this->redirect(array('gameStore/view'));
        }

        //检查权限
        $gameStore = GameStore::model()->findByPk($this->gameStoreId);
        if(!$gameStore){
            throw new CHttpException(403,'您还没有创建游戏店铺！');
        }
        if($gameStore->franchise_stores <> GameStore::FRANCHISE_STORES_IS){
            throw new CHttpException(403,'您没有权限操作！');
        }

        $modelOrder = GameOrder::model()->findByPk($id);
        $this->performAjaxValidation($modelOrder);
        if (isset($_POST['GameOrder'])) {
            $order = GameStoreMember::model()->findAllByAttributes(array('order_id'=>$id,'status'=>GameStoreMember::STATUS_NOT_DELIVERY));
            if(!$order){
                $this->setFlash('error', Yii::t('gameStoreDelivery', '订单错误'));
                $this->redirect(array('gameStoreMember/index'));
            }
            $deliveryTime = isset($_POST['GameOrder']['delivery_time']) ? strtotime($_POST['GameOrder']['delivery_time']) : time(); //发货时间
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach($order as $v){
                    $model = new GameStoreDelivery();
                    $model->order_id = $v->id;
                    $model->delivery_store_id = $v->store_id;
                    $model->delivery_items=$v->items_info;
                    $model->receive_member_id=$v->member_id;
                    $model->delivery_time=$deliveryTime;
                    $model->total_order_id=$id;
                    $model->save();
                    GameStoreMember::model()->updateAll(array('status' => GameStoreMember::STATUS_DELIVERY),'id = :id', array(':id' => $v->id));
                }
                GameOrder::model()->updateAll(array('status'=>GameStoreMember::STATUS_DELIVERY,'delivery_time'=>$deliveryTime,'update_time'=>time()),'id=:id',array(':id'=>$id));
                $transaction->commit();
                $this->setFlash('success', Yii::t('GameStoreDelivery', '添加发货记录') . Yii::t('GameStoreDelivery', '成功'));
                $this->redirect(array('gameStoreMember/index'));
            }catch (Exception $e){
                $transaction->rollback();
                $this->setFlash('error', Yii::t('GameStoreDelivery', '发货失败'));
                $this->redirect(array('gameStoreMember/index'));
            }
        }

        $this->render('create', array(
            'modelOrder' => $modelOrder,
        ));
    }

    /**
     * 修改发货记录
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $this->gameStoreCheck($model->delivery_store_id);//检查权限
        $model->delivery_time = $this->format()->formatDatetime($model->delivery_time);
        if (isset($_POST['GameStoreDelivery'])) {
            $model->attributes = $this->getPost('GameStoreDelivery');
            $model->delivery_time = strtotime($_POST['GameStoreDelivery']['delivery_time']);
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreDelivery', '修改发货记录') . Yii::t('GameStoreDelivery', '成功'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 查看发货记录
     */
    public function actionIndex()
    {
        $this->gameStoreCheck($this->gameStoreId);//检查权限
        $model = new GameStoreDelivery();
        $model->delivery_store_id = $this->gameStoreId;
        $criteria = new CDbCriteria;
        if (isset($_POST['GameStoreDelivery'])) {
            $model->attributes = $this->getPost('GameStoreDelivery');
            $criteria->compare('delivery_items', $model->delivery_items, true);
        }
        $criteria->with = array('info' => array('select' => 'info.real_name,info.mobile,info.member_address'));
        $criteria->compare('delivery_store_id', $model->delivery_store_id);
        $criteria->order = 't.delivery_time DESC';

        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
        $pager->applyLimit($criteria);
        $items = GameStoreDelivery::model()->findAll($criteria);
        $model->search();

        $this->render('index', array(
            'pages' => $pager,
            'items' => $items,
            'model' => $model
        ));
    }
}