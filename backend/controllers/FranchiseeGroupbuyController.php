<?php
/**
 * 线下团购
 * @author cong.zeng <zengcong220@qq.com>
 */

class FranchiseeGroupbuyController extends Controller
{
    public function filters()
    {
        return array(
            'rights',
        );
    }

    /*
     * 发布团购
     */
    public function actionCreate()
    {
        $model = new FranchiseeGroupbuy;
        $modelPic = new FranchiseeGroupbuyPicture();
        $this->performAjaxValidation($model);
        if (isset($_POST['FranchiseeGroupbuy'])) {
            $trans = Yii::app()->db->beginTransaction();
            $model->attributes = $this->getPost('FranchiseeGroupbuy');
            $model->dead_time = strtotime($_POST['FranchiseeGroupbuy']['dead_time']);
            $saveDir = 'groupbuy/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir); // 上传图片
            $model = $this->_attrDispose($model);
            try {
                if ($model->save()) {
                    UploadedFile::saveFile('thumbnail', $model->thumbnail);
                }
                /*团购对应图片列表*/
                $imgList = explode('|', $_POST['FranchiseeGroupbuy']['path']);
                foreach ($imgList as $val) {
                    Yii::app()->db->createCommand()->insert('{{franchisee_groupbuy_picture}}', array(
                        'path' => $val,
                        'franchisee_groupbuy_id' => $model->primaryKey,
                    ));
                }
                /*团购对应支持的所属加盟商*/
                $franchiseeList = isset($_POST['franchisee_id']) ? $_POST['franchisee_id'] : '';
                if($franchiseeList) {
                    foreach ($franchiseeList as $val) {
                        Yii::app()->db->createCommand()->insert('{{franchisee_groupbuy_to_franchisee}}', array(
                            'franchisee_groupbuy_id' => $model->primaryKey,
                            'franchisee_id' => $val,
                        ));
                    }
                }
                $trans->commit();
                $flag = true;
            } catch (Exception $e) {
                $trans->rollback();
                $flag = false;
                throw new Exception('团购发布失败' . $e->getMessage());
            }
            if ($flag) {
                @SystemLog::record(Yii::app()->user->name . "发布团购：" . $model->name);
                $this->setFlash('success', Yii::t('franchiseeGroupbuy', '发布团购') . $model->name . Yii::t('franchiseeGroupbuy', '成功'));
                $this->redirect(array('admin'));
            }

        }
        
        $this->render('create', array(
            'model' => $model,
            'imgModel' => $modelPic,
        ));
    }

    /**
     * 团购管理
     */
    public function actionAdmin()
    {
        $model = new FranchiseeGroupbuy();
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeGroupbuy']))
            $model->attributes = $this->getParam('FranchiseeGroupbuy');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 修改团购信息
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $franchiseeBrand = FranchiseeBrand::model()->find('id = :fid', array(':fid' => $model->franchisee_brand_id));
        $model->FranchiseeBrandName = isset($franchiseeBrand->name) ? $franchiseeBrand->name : '';
        $franchiseeGroupbuyCate = FranchiseeGroupbuyCategory::model()->find('id = :cid', array(':cid' => $model->franchisee_groupbuy_category_id));
        $model->FranchiseeGroupbuyCategoryName = isset($franchiseeGroupbuyCate->name) ? $franchiseeGroupbuyCate->name : '';

        /*查找已经选择过的加盟商*/
        $data = Yii::app()->db->createCommand()
                ->select()
                ->from('{{franchisee_groupbuy_to_franchisee}}')
                ->where('franchisee_groupbuy_id=:id', array(':id' => $id))
                ->queryAll();
        $franchisee_id = array(); //选中过的加盟商id
        foreach ($data as $v) {
            $franchisee_id[]=$v['franchisee_id'];
        }


        if (isset($_POST['FranchiseeGroupbuy'])) {
            $model->attributes = $this->getPost('FranchiseeGroupbuy');
            $model->dead_time = strtotime($_POST['FranchiseeGroupbuy']['dead_time']);
            $oldImg = $this->getParam('oldImg'); // 旧图
            $saveDir = 'groupbuy/' . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'thumbnail', $saveDir); // 上传图片

            $trans = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldImg, true); // 更新图片
                }
                /*团购对应图片列表*/
                $imgList = explode('|', $_POST['FranchiseeGroupbuy']['path']);
                if ($imgList) {
                    FranchiseeGroupbuyPicture::model()->deleteAll('franchisee_groupbuy_id=:franchisee_groupbuy_id', array(':franchisee_groupbuy_id' => $id));
                    foreach ($imgList as $val) {
                        Yii::app()->db->createCommand()->insert('{{franchisee_groupbuy_picture}}', array(
                            'path' => $val,
                            'franchisee_groupbuy_id' => $model->primaryKey,
                        ));
                    }
                }

                /*团购对应支持的所属加盟商*/
                $franchiseeList = isset($_POST['franchisee_id']) ? $_POST['franchisee_id'] : '';
                Yii::app()->db->createCommand()->delete('{{franchisee_groupbuy_to_franchisee}}', 'franchisee_groupbuy_id=:id', array(':id' => $id));
                if ($franchiseeList) {                    
                    foreach ($franchiseeList as $val) {
                        Yii::app()->db->createCommand()->insert('{{franchisee_groupbuy_to_franchisee}}', array(
                            'franchisee_groupbuy_id' => $model->primaryKey,
                            'franchisee_id' => $val,
                        ));
                    }
                }

                $flag = true;
                $trans->commit();
            } catch (Exception $e) {
                $flag = false;
                $trans->rollback();
                throw new Exception('更新数据失败' . $e->getMessage());
            }
            if ($flag) {
                @SystemLog::record(Yii::app()->user->name . "修改团购：{$model->name}");
                Yii::app()->user->setFlash('success', Yii::t('franchiseeGroupbuy', '数据更新成功'));
                $this->redirect(array('admin'));
            }
        }
        
        //处理路径
        $pics = FranchiseeGroupbuyPicture::getImgList($id);
        $pic_arr = array();
        foreach ($pics as $val) {
            $pic_arr[] = $val->path;
        }
        $model->path = implode('|', $pic_arr);

        $this->render('update', array(
            'model' => $model,
            'franchisee_id'=>$franchisee_id,
        ));
    }

    /*
     * 删除团购
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        @SystemLog::record(Yii::app()->user->name . "删除团购：{$model->name}");
        $model->deleteByPk($id);
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    }

    /**
     * 属性处理
     * @param type $model
     * @return type
     */
    private function _attrDispose($model)
    {
        if ($model->franchisee_brand_id) {
            $mModel = FranchiseeBrand::model()->find('id = :id', array('id' => $model->franchisee_brand_id));
            $model->FranchiseeBrandName = $mModel->name;
        }
        return $model;
    }
}