<?php

/**
 * 微商城 广告位推荐商品控制器
 * @author wyee<yanjie@g-emall.com>
 */
class MshopAdvertGoodsController extends Controller {

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
        return 'admin, insertTargetPro, topIndex, changeIndex, deleteItems, updateShowPage';
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new AdvertGoods('search');
        $model->advert_id = $this->getParam('aid');

        $goods_model = new Goods('search');
        $goods_model->unsetAttributes();
        if (isset($_POST['Goods']))
            $goods_model->attributes = $this->getPost('Goods');

        $goods_model->status = Goods::STATUS_PASS;
        $goods_model->is_publish = Goods::PUBLISH_YES;
        $goods_data = $goods_model->search()->getData();
        $advert_goods_data = $model->searchAll()->getData();
        $this->render('admin', array(
            'model' => $model,
            'goods_model' => $goods_model,
            'goods_data' => $goods_data,
            'advert_goods_data' => $advert_goods_data,
        ));
    }

    /**
     * 添加商品
     * Enter description here ...
     */
    public function actionInsertTargetPro() {
        if (empty($_POST['AdPosId']) || empty($_POST['proIds']))
            $this->_returnJson(Yii::t('advertGoods', '缺少数据！'), 'error');

        $model = new AdvertGoods();
        $model->advert_id = $_POST['AdPosId'] * 1;

        $post_ids = explode(',', $_POST['proIds']);

        $all_data = $model->searchAll()->getData();
        $all_ids = array();
        foreach ($all_data as $val) {
            $all_ids[$val->goods_id] = $val->goods_id;
        }

        $not_in_ids = array();
        foreach ($post_ids as $val) {
            if (!in_array($val, $all_ids)) {
                $not_in_ids[] = $val;
            }
        }

        $start_sort = count($all_data);

        foreach ($not_in_ids as $val) {
            $insert_model = new AdvertGoods();
            $insert_model->advert_id = $model->advert_id;
            $insert_model->goods_id = $val;
            $insert_model->sort = $start_sort;
            $insert_model->save();
            $start_sort++;
        }
        if ($not_in_ids) {
            SystemLog::record(Yii::app()->user->name . "广告位:" . $model->advert_id . ", 添加商品id:" . implode(',', $not_in_ids));
        }
        $this->_returnJson(Yii::t('advertGoods', '添加成功'), 'success');
    }

    /**
     * 顶置商品
     * Enter description here ...
     */
    public function actionTopIndex() {
        if (empty($_POST['AdPosId']) || empty($_POST['proId']))
            $this->_returnJson(Yii::t('advertGoods', '缺少数据！'), 'error');


        $advert_id = $_POST['AdPosId'] * 1;
        $goods_id = $_POST['proId'] * 1;
        $curr_data = AdvertGoods::model()->find("advert_id = {$advert_id} AND goods_id = {$goods_id}");

        $model = new AdvertGoods();
        $model->advert_id = $advert_id;
        $all_data = $model->searchAll()->getData();

        $command = Yii::app()->db->createCommand();
        $command->delete($model->tableName(), "advert_id={$advert_id}");


        foreach ($all_data as $data) {
            $insert_model = new AdvertGoods();
            $insert_model->advert_id = $data->advert_id;
            $insert_model->goods_id = $data->goods_id;
            $insert_model->sort = $data->sort;

            if ($data->sort < $curr_data->sort) {
                $insert_model->sort = $data->sort + 1;
            } elseif ($data->sort == $curr_data->sort) {
                $insert_model->sort = 0;
            }

            $insert_model->save();
        }
        if ($all_data) {
            SystemLog::record(Yii::app()->user->name . "广告位 顶置商品，广告位id:" . $advert_id . ",商品id:" . $goods_id);
        }
        $this->_returnJson(Yii::t('advertGoods', '顶置成功'), 'success');
    }

    /**
     * 商品更改排序  向上向下
     * Enter description here ...
     */
    public function actionChangeIndex() {
        if (empty($_POST['AdPosId']) || empty($_POST['proId']) || empty($_POST['changeStep']))
            $this->_returnJson(Yii::t('advertGoods', '缺少数据！'), 'error');

        $model = new AdvertGoods();
        $advert_id = $_POST['AdPosId'] * 1;
        $goods_id = $_POST['proId'] * 1;
        $change_step = $_POST['changeStep'] * 1;
        $curr_data = AdvertGoods::model()->find("advert_id = {$advert_id} AND goods_id = {$goods_id}");

        $command = Yii::app()->db->createCommand();
        $command->update($model->tableName(), array('sort' => $curr_data->sort), "advert_id={$advert_id} AND sort = " . ($curr_data->sort + $change_step));
        $command->update($model->tableName(), array('sort' => ($curr_data->sort + $change_step)), "advert_id={$advert_id} AND goods_id = {$goods_id}");

        SystemLog::record(Yii::app()->user->name . "广告位 " . $advert_id . " 更新排序");
        $this->_returnJson(Yii::t('advertGoods', '更改排序成功'), 'success');
    }

    /**
     * 删除推荐商品
     * Enter description here ...
     */
    public function actionDeleteItems() {
        if (empty($_POST['AdPosId']) || empty($_POST['proIds']))
            $this->_returnJson(Yii::t('advertGoods', '缺少数据！'), 'error');

        $model = new AdvertGoods();
        $advert_id = $_POST['AdPosId'] * 1;
        $goods_ids = explode(',', $_POST['proIds']);
        $model->advert_id = $advert_id;
        $all_data = $model->searchAll()->getData();

        $command = Yii::app()->db->createCommand();
        $command->delete($model->tableName(), "advert_id={$advert_id}");

        //重新排序插入
        $sort = 0;
        foreach ($all_data as $data) {
            if (!in_array($data->goods_id, $goods_ids)) {
                $command->insert($model->tableName(), array('advert_id' => $advert_id, 'goods_id' => $data->goods_id, 'sort' => $sort));
                $sort++;
            }
        }
        SystemLog::record(Yii::app()->user->name . "广告位 " . $advert_id . ",删除商品id:" . implode(',', $goods_ids));
        $this->_returnJson(Yii::t('advertGoods', '删除成功'), 'success');
    }

    /**
     * 同步到前台显示   更新缓存
     * Enter description here ...
     */
    public function actionUpdateShowPage() {
        if (empty($_POST['AdPosId']))
            $this->_returnJson(Yii::t('advertGoods', '缺少数据！'), 'error');

        $ad_model = new Advert();
        $advert_id = $_POST['AdPosId'] * 1;
        $ad = $ad_model->findByPk($advert_id);
//        Advert::generateAdGoods($ad->code);
//    	var_dump(Tool::cache(Advert::CACHEDIR)->get($ad->code));
        SystemLog::record(Yii::app()->user->name . "广告位 " . $advert_id . ",同步到前台显示   更新缓存 ");
        $this->_returnJson(Yii::t('advertGoods', '同步成功'), 'success');
    }

    /**
     * 输出json
     * Enter description here ...
     * @param unknown_type $rs
     */
    private function _returnJson($msg, $result = 'success') {
        $return['msg'] = $msg;
        $return['result'] = $result;

        echo json_encode($return);
        Yii::app()->end();
    }

}
