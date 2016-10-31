<?php
/**
 * 店小二管理
 *
 * 操作(增删查改)
 * @author zhenjun_xu <412530435@qq.com>
 */
class AssistantController extends SController
{

    public function init()
    {
        $this->pageTitle = Yii::t('sellerAssistant', '_卖家平台_') . Yii::app()->name;
    }

    /**
     * 添加店小二
     */
    public function actionCreate()
    {
        $this->pageTitle = Yii::t('sellerAssistant', '添加店小二') . $this->pageTitle;
        $model = new Assistant;
        $this->performAjaxValidation($model);

        if (isset($_POST['Assistant'])) {
            $model->attributes = $this->getPost('Assistant');
            $model->member_id = $this->getUser()->id;
            $saveDir = 'assistant/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'avatar', $saveDir, Yii::getPathOfAlias('att'));
            if ($model->save()) {
                UploadedFile::saveFile('avatar', $model->avatar);
                $this->_setPermission($model->id);
                $this->setFlash('success', Yii::t('sellerAssistant','添加店小二成功'));
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeInsert,$model->id,'添加店小二:'.$model->username);
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('error', Yii::t('sellerAssistant','添加店小二失败'));
            }

        }
        $franchisee = Franchisee::model()->findAllByAttributes(array('member_id' => $this->getUser()->id));

        $this->render('create', array(
            'model' => $model,
            'franchisee' => $franchisee,
        ));
    }

    /**
     * 修改
     */
    public function actionUpdate($id)
    {
        $this->pageTitle = Yii::t('sellerAssistant', '修改店小二') . $this->pageTitle;
        $model = $this->loadModel($id);
        $model->scenario = 'change';

        $this->performAjaxValidation($model);

        if (isset($_POST['Assistant'])) {
            $model->attributes = $this->getPost('Assistant');
            $saveDir = 'assistant/' . date('Y/n/j');
            $oldFile = $model->avatar;
            $model = UploadedFile::uploadFile($model, 'avatar', $saveDir, Yii::getPathOfAlias('att'));
            if ($model->save()) {
                UploadedFile::saveFile('avatar', $model->avatar, $oldFile, true);
                $this->_setPermission($id);
                $this->setFlash('success', Yii::t('sellerAssistant','修改店小二成功'));
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$model->id,'修改店小二:'.$model->username);
                $this->refresh();
            } else {
                $this->setFlash('error', Yii::t('sellerAssistant','修改店小二失败'));
            }

        }
        $permissions = AssistantPermission::model()->findAllByAttributes(array('assistant_id' => $model->id));
        $franchisee = Franchisee::model()->findAllByAttributes(array('member_id' => $this->getUser()->id));
        $this->render('update', array(
            'model' => $model,
            'permissions' => $permissions,
            'franchisee' => $franchisee,
        ));
    }

    /**
     * 设置店小二权限
     * @param $assistantId
     */
    private  function _setPermission($assistantId){
        if(isset($_POST['item'])){
            //权限设定
            $items = array_filter($this->getPost('item'));
            $sql = '';
            foreach ($items as $item) {
                //  /seller/franchisee/CustomerList|||103
                $item = str_replace('/seller/', '', $item);
                $itemArr = explode('|||', $item);
                $item = $itemArr[0];
                $franchisee_id = count($itemArr) == 2 ? $itemArr[1] : 0;
                $sql .= "insert into {{assistant_permission}}(item,assistant_id,franchisee_id)values
                        ('{$item}','{$assistantId}','{$franchisee_id}');";
            }
            AssistantPermission::model()->deleteAllByAttributes(array('assistant_id' => $assistantId));
            Yii::app()->db->createCommand($sql)->execute();
            //更新缓存
            AssistantPermission::getPermission($assistantId, false);
        }else{
            AssistantPermission::model()->deleteAllByAttributes(array('assistant_id' => $assistantId));
        }
    }

    /**
     * 删除
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $file = Yii::getPathOfAlias('att').'/'.$model->avatar;
        UploadedFile::delete($file);
        SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeDel,$model->id,'删除店小二:'.$model->username);
        $model->delete();
        AssistantPermission::model()->deleteAllByAttributes(array('assistant_id'=>$id));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * 店小二列表
     */
    public function actionAdmin()
    {
        $this->pageTitle = Yii::t('sellerAssistant', '店小二列表') . $this->pageTitle;
        $model = new Assistant('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Assistant']))
            $model->attributes = $this->getQuery('Assistant');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * view 中检查权限是否已选
     * @param array $itemsArr 权限数组
     * @param $item
     * @return bool
     */
    public function checkPermission(Array $itemsArr, $item)
    {
        $route = str_replace('/seller/', '', $item);
        $routeArr = explode('|||',$route);
        foreach ($itemsArr as $v) {
            if(count($routeArr)==2){
                if($v->item == $routeArr[0] && $routeArr[1]==$v->franchisee_id) return true;
            }else{
                if ($v->item == $route) return true;
            }
        }
        return false;
    }

}
