<?php

/**
 * 专题商品控制器
 * 操作:{添加商品,批量删除专题商品,批量更新专题商品,分类商品列表}
 * @author jianlin_lin <hayeslam@163.com>
 */
class SpecialTopicGoodsController extends Controller {

    public $specialId;
    public $specialCatId;
    public $specialTopicCategory;

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
        return 'SelectGoods';
    }

    /**
     * 在执行Action之前的操作
     * @param type $action
     */
    public function beforeAction($action) {
        parent::beforeAction($action);
        $this->specialCatId = $this->getParam('categoryId');
        // 判断是否存在此专题
        $this->specialTopicCategory = SpecialTopicCategory::model()->find('id = :stcid', array(':stcid' => $this->specialCatId));
        if (!$this->specialTopicCategory)
            throw new CHttpException(404, '请求的页面不存在.');
        $this->specialId = $this->specialTopicCategory->special_topic_id;
        return true;
    }

    /**
     * 选择商品
     */
    public function actionSelectGoods() {
        $model = new Goods('search');
        $model->unsetAttributes();
        
        if (isset($_GET['Goods'])) {
            $model->attributes = $_GET['Goods'];
        }
        $this->render('selectgoods', array(
            'model' => $model,
        ));
    }

    /**
     * 添加商品
     */
    public function actionAddGoods() {
        if (Yii::app()->request->isPostRequest) {
            $goods = $this->getParam('selectdel', array());
            $inserts = array();
            foreach ($goods as $gid) {
//                if (SpecialTopicGoods::model()->exists('special_topic_category_id = :stcid AND goods_id = :gid', array(':stcid' => $this->specialId, ':gid' => $gid)))
//                    continue;
                $price = Goods::model()->findByPk($gid)->price;
                $inserts[] = "('{$this->specialCatId}', '{$gid}', '{$price}', '{$this->specialId}')";
            }
            if (!empty($inserts)) {
                // 批量插入组图数据
                $sql = "INSERT INTO {{special_topic_goods}} (`special_topic_category_id`, `goods_id`, `special_price`, `special_topic_id`) VALUES " . implode(',', $inserts);
                Yii::app()->db->createCommand($sql)->execute();
            }
            
            @SystemLog::record(Yii::app()->user->name . "为专题添加商品：special_topic_id=>{$this->specialId}|specialCatId=>{$this->specialCatId}|goods=>".implode(',', $goods) );
            
            
            if (isset(Yii::app()->request->isAjaxRequest))
                echo CJSON::encode(!empty($goods) ? 'true' : 'false');
            else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'categoryId' => $this->specialCatId));
        }
        else {
            throw new CHttpException(400, Yii::t('specialTopicGoods', '无效的请求。请不要再次重复这个请求。'));
        }
    }

    /**
     * 批量删除专题商品
     * @param integer $id
     */
    public function actionBatchDelete() {
        if (Yii::app()->request->isPostRequest) {
            $goods = $this->getParam('selectdel', array());
            if (!empty($goods)) {
                foreach ($goods as $g) {
                    $val = explode('|', $g);
                    $gid[] = $val[0];
                }
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $gid);
                if (SpecialTopicGoods::model()->deleteAll($criteria)) {
                    if (isset(Yii::app()->request->isAjaxRequest)) {
                        $this->setFlash('success', Yii::t('specialTopicGoods', '操作成功'));
                        echo CJSON::encode('true');
                    } else {
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'categoryId' => $this->specialCatId));
                    }
                    
                    @SystemLog::record(Yii::app()->user->name . "批量删除专题商品：special_topic_id=>{$this->specialId}|specialCatId=>{$this->specialCatId}|goods=>".implode(',', $gid) );
                    
                    
                } else {
                    echo CJSON::encode('false');
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('specialTopicGoods', '无效的请求。请不要再次重复这个请求。'));
        }
    }

    /**
     * 批量更新专题商品
     * @param integer $id
     */
    public function actionBatchUpdate() {
        if (Yii::app()->request->isPostRequest) {
            $goods = $this->getParam('selectdel', array());
            if (!empty($goods)) {
            	$gid = array();
                foreach ($goods as $k => $g) {
                    $val = explode('|', $g);
                    $gid[] = $val[0];
                    // $val 索引为0：专题商品ID, 1：专题价格
                    $sql = "UPDATE {{special_topic_goods}} SET `special_price` = {$val[1]} WHERE `id` = {$val[0]}";
                    Yii::app()->db->createCommand($sql)->execute();
                }
                if (isset(Yii::app()->request->isAjaxRequest)) {
                    $this->setFlash('success', Yii::t('specialTopicGoods', '更新成功'));
                    
                    @SystemLog::record(Yii::app()->user->name . "批量更新专题商品：special_topic_id=>{$this->specialId}|specialCatId=>{$this->specialCatId}|goods=>".implode(',', $gid) );
                    
                    echo CJSON::encode('true');
                } else {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'categoryId' => $this->specialCatId));
                }
            } else {
                echo CJSON::encode('false');
            }
        } else {
            throw new CHttpException(400, Yii::t('specialTopicGoods', '无效的请求。请不要再次重复这个请求。'));
        }
    }

    /**
     * 分类商品列表
     */
    public function actionAdmin() {
        $model = new SpecialTopicGoods('search');
        $model->special_topic_category_id = $this->specialCatId;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
