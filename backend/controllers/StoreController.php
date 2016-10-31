<?php

/**
 * 商铺管理控制器
 * 操作（列表，编辑）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class StoreController extends Controller {

    public $defaultAction = 'admin';

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
        return 'getStore, getStoreName';
    }

    /**
     * 编辑店铺
     * @param int $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->setScenario('updateStore');
        $this->performAjaxValidation($model);
        if (isset($_POST['Store'])) {
            $model->attributes = $this->getPost('Store');
			
			//如果勾选了商铺资质
			if(is_array($model->attributes['qualifications'])){
				$array = (array)$model->attributes['qualifications'];
			    $model->qualifications = join(',', $array);
			}
			
            if ($model->save()) {
                SystemLog::record($this->getUser()->name . "更新商铺：" . $model->name . '、状态：' . Store::status($model->status));
                $this->setFlash('success','更新成功');
                $this->redirect(array('admin'));
            }else{
                $this->setFlash('error','更新失败');
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }
    /**
     * 审核店铺
     * @param int $id
     */
    public function actionUpdateStatusPass($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if($model->status != Store::STORE_STATUS_PASS){
            $oldStatus = $model->status;
            $model->status = Store::STORE_STATUS_PASS;
            if ($model->save()) {
                $log = new StoreCheck('insert');
                $log->attributes = array(
                    'username' => $this->getUser()->name,
                    'content' => "更新商铺：" . $model->name . '、状态：'.Store::status($oldStatus) . ' > ' . Store::status($model->status),
                    'create_time' => time(),
                    'store_id' => $model->id,
                );
                $log->save();
                SystemLog::record($this->getUser()->name . "更新商铺：" . $model->name . '、状态：'.Store::status($oldStatus) . ' > ' . Store::status($model->status));
                $this->setFlash('success', Yii::t('store', '审核通过'));
                $this->redirect(array('admin'));
            }
        }
        $this->setFlash('error', Yii::t('store', '修改失败'));
        $this->redirect(array('admin'));
    }

    /**
     * 审核日志
     * @param $id
     */
    public function actionReviewLog($id) {
        $model = new StoreCheck('search');
        $model->unsetAttributes();
        if ($id) $model->store_id = $this->magicQuotes($id);
        $this->render('reviewLog', array(
            'model' => $model,
        ));
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new Store('search');
        $model->unsetAttributes();
        if (isset($_GET['Store']))
            $model->attributes = $this->getParam('Store');
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 修改店铺推荐人
     * @param int $id
     */
    public function actionUpdateRecommend($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'updateRecommend';
        $this->performAjaxValidation($model);
        if (isset($_POST['Store'])) { 
              if($model->member_id==$_POST['Store']['referrals_id']){
                  $this->setFlash('error', Yii::t('store', '商家不可以成为自己的推荐人，请重新设置'));
                  $this->redirect(array('admin'));
              }
            if($model->is_partner==Store::STORE_PARTNER_YES && $model->is_middleman!=Store::STORE_ISMIDDLEMAN_YES){
                 $rid=$model->member_id;
                 $trans = Yii::app()->db->beginTransaction();
             try {
                  $res=Store::model()->updateByPk($id,array('is_partner'=>Store::STORE_PARTNER_DEL));
                 if(!empty($res)){
                      $model->is_partner=Store::STORE_PARTNER_DEL;
                      $sidArr=array();
                      $partnerAgent=Store::model()->findAll(array(
                        'select'=>'id,under_id',
                        'condition'=>'referrals_id=:rid AND under_id=:uid',
                        'params'=>array(':rid'=>$rid,':uid'=>Store::STORE_UNDER_YES)
                  ));
              if(!empty($partnerAgent)){
                   foreach($partnerAgent as $k=>$v){                     
                          $sidArr[]=$v->id;
                    }  
                 $sidRes=Store::model()->updateByPk($sidArr,array('referrals_id'=>$model->referrals_id,'under_id'=>Store::STORE_UNDER_DEL));
                  if(empty($sidRes)){
                    $this->setFlash('error', Yii::t('store', '合作伙伴招入商家无法解除推荐关系'));
                    $this->redirect(array('admin'));
                }
              }
             }else{
                 $this->setFlash('error', Yii::t('store', '合作伙伴的属下商家推荐人更改出错'));
                 $this->redirect(array('admin'));
             }
            $trans->commit();
         }catch (Exception $e) {
             $trans->rollback();
             throw new CHttpException(403, $e->getMessage());
          }
            }
            $model->attributes = $this->getPost('Store');
            $mid=$model->referrals_id;
            //判断要设置的推荐商家是否是合作伙伴，根据结果作标记（在解除合作伙伴关系时，判断是否解除推荐关系）
            $sres=Store::model()->exists('member_id=:mid AND is_partner=:isp',array(':mid'=>$mid,':isp'=>Store::STORE_PARTNER_YES));
            $model->under_id= $sres ? Store::STORE_UNDER_YES : Store::STORE_UNDER_NO;
            
            if($model->is_middleman==Store::STORE_ISMIDDLEMAN_YES){
                $sres=Store::model()->exists('member_id=:mid AND is_middleman=:msp',array(':mid'=>$mid,':msp'=>Store::STORE_ISMIDDLEMAN_YES));
                if($sres){
                     $this->setFlash('error', Yii::t('store', '居间商不能成为居间商的推荐人'));
                     $this->redirect(array('admin'));
                }
            }
            if ($model->save(FALSE)){
                //保存记
                $recommendLog = new StoreRecommendLog();
                $recommendLog->store_id = $model->id;
                $recommendLog->parent_id = $model->referrals_id;
                $recommendLog->create_time = time();
                $recommendLog->save();
                SystemLog::record($this->getUser()->name . "修改店铺" . $model->name . "（id：" . $model->id . "）的推荐人为" . $_POST['RefMemberUsername'] . "(id:" . $recommendLog->parent_id . ")");
                $this->setFlash('success', Yii::t('store', '修改店铺推荐人成功'));
                $this->redirect(array('admin'));
            }
              } 
        $this->render('updaterecommend', array(
            'model' => $model,
        ));
    }

    public function actionGetStore() {
        $model = new Store('search');
        $model->unsetAttributes();
        if (isset($_GET['Store']))
            $model->attributes = $this->getParam('Store');
        $this->render('getstore', array(
            'model' => $model,
        ));
    }

    /**
     * 获取商家名称 ajax 请求方式
     * @param int $id
     * @return json 
     */
    public function actionGetStoreName($id) {
        if ($this->isAjax()) {
            $model = Store::model()->find('id = :id', array('id' => $id));
            if (!is_null($model))
                echo CJSON::encode($model->name);
            else
                echo CJSON::encode(null);
        }
    }

}
