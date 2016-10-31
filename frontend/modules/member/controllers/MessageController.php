<?php

/**
 * 站内信控制器
 * 操作（列表，详情预览，批量阅读，批量删除）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MessageController extends MController {

    // 站内信详情
    public function actionView($id) {
        $model = $this->_loadModel($id);
        $model->status = Mailbox::STATUS_RECEIVED;
        $model->save();
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionViews($id) {
        $model = $this->_loadModel($id);
        $this->title = '盖象商城';
        $model->status = Mailbox::STATUS_RECEIVED;
        $model->save();
        $this->renderPartial('view', array(
            'model' => $model,
        ));
    }

    // 批量阅读
    public function actionUpdate() {
        if ($this->isPost()) {
            $ids = $this->getPost('ids');
            if (!empty($ids)) {
                $criteria = new CDbCriteria;
                $criteria->addInCondition("id", $ids);
                $criteria->addCondition('member_id = ' . $this->getUser()->id);
                Mailbox::model()->updateAll(array('status' => Mailbox::STATUS_RECEIVED), $criteria);
                $this->setFlash('success', Yii::t('memberMessage', '批量阅读信息成功'));
                $this->redirect(array('/member/message'));
            }
        }
        $this->redirect(array('/member'));
    }

    // 批量删除
    public function actionDelete() {
        if ($this->isPost()) {
            $ids = $this->getPost('ids');
            if (!empty($ids)) {
                $criteria = new CDbCriteria;
                $criteria->addInCondition("id", $ids);
                $criteria->addCondition('member_id = ' . $this->getUser()->id);
                Mailbox::model()->deleteAll($criteria);
                $this->setFlash('success', Yii::t('memberMessage', '批量删除信息成功'));
                $this->redirect(array('/member/message'));
            }
        }
        $this->redirect(array('/member'));
    }

    // 列表
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Mailbox', array(
            'criteria' => array(
                'condition' => 'member_id = ' . $this->getUser()->id,
                'order' => 't.id DESC',
                'with' => array('message' => array('condition' => 'receipt_time < ' . time())),
            ),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    // 加载单个模型
    private function _loadModel($id) {
        $model = Mailbox::model()->with('message')->findByPk($id, 'member_id=:member_id', array(
            ':member_id' => $this->getUser()->id
        ));
        if ($model === null)
            throw new CHttpException(404, Yii::t('memberMessage', '你请求的页面在不存在！'));
        return $model;
    }

    /**
     * ajax 获取未读条数
     */
    public function actionUnreadMessageNum(){
        echo Mailbox::newMessageCount();
    }

}
