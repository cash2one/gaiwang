<?php

/**
 * 数据收集
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class RecordController extends Controller {

    public function beforeAction($action) {
        if (!$this->isPost())
            exit(0);
        parent::beforeAction($action);
    }

    // flag + 企业ID + GW号 + 门店ID + 加盟商编号 + 终端号
    public function actionCollect() {
        $data = $this->getPost('data');
        $array = array(
            'enterprise_id' => 1,
            'gw' => 'GW00000001',
            'store_id' => 1,
            'franchisee_id' => 1,
            'machine_id' => 1,
            'flag' => 1, // (0禁用，1启用)
        );

        // 查询记录
        $condition = 'enterprise_id=:enterpriseId AND gw=:gw AND store_id=:storeId AND franchisee_id=franchiseeId AND machine_id=machineId';
        $params = array(':enterpriseId' => $data['enterprise_id'], ':gw' => $data['gw'], ':storeId' => $data['store_id'], ':franchiseeId' => $data['franchisee_id'], ':machineId' => $data['machine_id']);
        $record = Yii::app()->db->createCommand()->select()->from('{{relation}}')->where($conditions, $params)->queryRow();

        if ($record === null) {
            Yii::app()->db->createCommand()->insert('{{relation}}', $data);
            Yii::app()->db->createCommand()->update('{{member}}', array('role' => 0), 'gai_number=:gw', array(':gw' => $data['gw']));
        } else {
            if ($record['flag'] != $data['flag'])
                Yii::app()->db->createCommand()->update('{{relation}}', array('flag' => $data['flag']), $condition, $params);
        }
        echo CJSON::encode(array('status' => 'success'));
    }

}
