<?php
/**
 * 游戏店铺商品
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 2015/11/20 16:55
 */
class GameStoreItemsController extends SController
{
    /**
     * 添加游戏商品
     */
    public function actionCreate() {
        $this->gameStoreCheck($this->gameStoreId);//检查权限
        $model = new GameStoreItems('Create');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->start_date = date('Y-m-d');
        $model->end_date = date("Y-m-d", time() + (60 * 60 * 24 * 7));
        $model->start_time = date('H:00:00',time() + 3600);
        $model->end_time = date('H:00:00',time() + (60 * 60 * 5));
        if (isset($_POST['GameStoreItems'])) {
            $model->attributes = $this->getPost('GameStoreItems');
            $model->store_id = $this->gameStoreId;
            $model->create_time = $model->update_time = time();
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreItems', '添加商品') . $model->item_name . Yii::t('GameStoreItems', '成功'));
                $this->redirect(array('index'));
            }
        }

        $storeItems = Yii::app()->db->createCommand()
            ->select('item_name')
            ->from('{{game_store_items}}')
            ->where('store_id = :id',array(':id'=>$this->gameStoreId))
            ->queryColumn();

        $this->render('create', array(
            'model' => $model,
            'items' => $storeItems
        ));
    }


    /**
     * 添加游戏特殊商品
     */
    public function actionCreateFlag() {
        $this->gameStoreCheck($this->gameStoreId);//检查权限
        $rs = GameStore::model()->findByPk($this->gameStoreId);
        if($rs->franchise_stores <> GameStore::FRANCHISE_STORES_IS)
            $this->redirect(array('index'));

        $model = new GameStoreItems('Createflag');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->start_date = date('Y-m-d');
        $model->end_date = date("Y-m-d", time() + (60 * 60 * 24 * 7));
        $model->start_time = date('H:00:00',time() + 3600);
        $model->end_time = date('H:00:00',time() + (60 * 60 * 5));
        $model->flag = GameStoreItems::FLAG_ITEMS_YES;
        if (isset($_POST['GameStoreItems'])) {
            $model->attributes = $this->getPost('GameStoreItems');
            $model->store_id = $this->gameStoreId;
            $model->create_time = $model->update_time = time();
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreItems', '添加商品') . $model->item_name . Yii::t('GameStoreItems', '成功'));
                $this->redirect(array('index'));
            }
        }

        $storeItems = Yii::app()->db->createCommand()
            ->select('item_name')
            ->from('{{game_store_items}}')
            ->where('store_id = :id',array(':id'=>$this->gameStoreId))
            ->queryColumn();

        $this->render('createflag', array(
            'model' => $model,
            'items' => $storeItems
        ));
    }

    /**
     * 修改游戏商品
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->setScenario('update');
        $this->gameStoreCheck($model->store_id);//检查权限
        $itemName = $model->item_name;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['GameStoreItems'])) {
            $model->attributes = $this->getPost('GameStoreItems');
            $model->item_name = $itemName;
            $model->update_time = time();
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreItems', '修改商品') . $model->item_name . Yii::t('GameStoreItems', '成功'));
                $this->redirect(array('index'));
            }
        }

        $storeItems = Yii::app()->db->createCommand()
            ->select('item_name')
            ->from('{{game_store_items}}')
            ->where('store_id = :id',array(':id'=>$this->gameStoreId))
            ->queryColumn();

        $this->render('update', array(
            'model' => $model,
            'items' => $storeItems
        ));
    }


    /**
     * 修改游戏特殊商品
     */
    public function actionUpdateFlag($id) {
        $model = $this->loadModel($id);
        $model->setScenario('updateflag');
        $this->gameStoreCheck($model->store_id);//检查权限
        $rs = GameStore::model()->findByPk($this->gameStoreId);
        if($rs->franchise_stores <> GameStore::FRANCHISE_STORES_IS)
            $this->redirect(array('index'));

        $itemName = $model->item_name;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['GameStoreItems'])) {
            $model->attributes = $this->getPost('GameStoreItems');
            $model->item_name = $itemName;
            $model->update_time = time();
            if ($model->save()){
                $this->setFlash('success', Yii::t('GameStoreItems', '修改商品') . $model->item_name . Yii::t('GameStoreItems', '成功'));
                $this->redirect(array('index'));
            }
        }

        $storeItems = Yii::app()->db->createCommand()
            ->select('item_name')
            ->from('{{game_store_items}}')
            ->where('store_id = :id',array(':id'=>$this->gameStoreId))
            ->queryColumn();

        $this->render('updateflag', array(
            'model' => $model,
            'items' => $storeItems
        ));
    }

    /**
     * 查看游戏店铺商品
     */
    public function actionIndex()
    {
        $this->gameStoreCheck($this->gameStoreId);//检查权限
        $model = new GameStoreItems();
        $model->store_id = $this->getSession('gameStoreId');
        $criteria = new CDbCriteria;
        if (isset($_POST['GameStoreItems'])) {
            $model->attributes = $this->getPost('GameStoreItems');
            $criteria->compare('item_name', $model->item_name, true);
        }
        $criteria->compare('store_id', $model->store_id);
        //$criteria->compare('item_status', $model->item_status);
        $criteria->order = 'id ASC';

        // 分页
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 13;
        $pager->applyLimit($criteria);
        $items = GameStoreItems::model()->findAll($criteria);
        $model->search();

        //查询是否特殊商品店铺
        $store = Yii::app()->db->createCommand()
            ->select('franchise_stores')
            ->from('{{game_store}}')
            ->where('id = :id', array(':id' => $this->gameStoreId))
            ->queryRow();

        $this->render('index', array(
            'pages' => $pager,
            'items' => $items,
            'model' => $model,
            'store' => $store
        ));
    }

    /**
     * 弹弓打鸟概率
     */
    public function actionBird(){
        $this->gameStoreCheck($this->gameStoreId);//检查权限
        $rs = GameStore::model()->findByPk($this->gameStoreId);
        if($rs->franchise_stores <> GameStore::FRANCHISE_STORES_IS)
            $this->redirect(array('index'));

        $model = new BirdConfigForm();
        $model->setAttributes($this->getConfig('bird'));
        //ajax表单验证
        $this->performAjaxValidation($model);

        if (isset($_POST['BirdConfigForm'])) {
            $model->attributes = $_POST['BirdConfigForm'];
            if ($model->validate()) {
                $string = serialize($model->attributes);
                $value = WebConfig::model()->findByAttributes(array('name' => 'bird'));
                if ($value) {
                    $webConfig = WebConfig::model();
                    $webConfig->id = $value->id;
                } else {
                    $webConfig = new WebConfig();
                }
                $webConfig->name = 'bird';
                $webConfig->value = $string;
                if ($webConfig->save()) { //向得到的文件路劲指定的文件里面插入数据
                    Tool::cache('birdconfig')->set('bird', $string);
                    Tool::orderApiPost('config/updateCache',array('configName' => 'birdconfig', 'value' => $string));
                    $this->setFlash('success', Yii::t('home', '数据保存成功'));
                    @$this->_saveSellerLog(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,0,Yii::app()->user->name . '修改弹弓打鸟配置文件');
//                    @SystemLog::record(Yii::app()->user->name . "修改配置文件：" . $this->action->id);
                } else {
                    $this->setFlash('error', Yii::t('home', '数据保存失败，请检查相关目录权限'));
                }
            }
        }
        $this->render('birdconfig', array('model' => $model));
    }
}