<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 14-1-14
 * Time: 下午3:30
 */

class DesignController extends Controller
{

    /**
     * 店铺装修列表
     */
    public function actionIndex()
    {
        $model=new Design('search');
        $model->unsetAttributes();
        if(isset($_GET['Design']))
            $model->attributes=$_GET['Design'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    /**
     * 审核
     * @param int $id 店铺装修模板id
     * @param string $pass yes or no
     */
    public function actionChangeStatus($id,$pass){
        /** @var $model Design */
        $model = $this->loadModel($id);
        if($pass=='yes'){
            $model->status = Design::STATUS_PASS;
            Design::model()->updateAll(array('status'=>Design::STATUS_HISTORY),
                'store_id='.$model->store_id.' and status='.Design::STATUS_PASS);
        }else{
            $model->remark = $this->getPost('remark');
            $model->status = Design::STATUS_NOT_PASS;
        }
        if(!$model->save()){
        	@SystemLog::record(Yii::app()->user->name."审核店铺装修：{$id} 失败");
            echo CJSON::encode(array('error'=>'修改失败'));
        }else{
        	@SystemLog::record(Yii::app()->user->name."审核店铺装修：{$id}");
        }
    }

    /**
     * ajax 批量审核
     */
    public function actionBatchOperate(){
         if($this->isAjax()){
             $ids = $this->getPost('ids');
             $designs = Design::model()->findAll('id in('.$ids.')');
             if(!$designs) return false;
             @SystemLog::record(Yii::app()->user->name."批量审核店铺装修：{$ids}");
             if($this->getPost('pass')=='yes'){
                 //通过
                 /** @var $v design */
                 foreach($designs as &$v){
                     $v->status = Design::STATUS_PASS;
                     Design::model()->updateAll(array('status'=>Design::STATUS_HISTORY),
                         'store_id='.$v->store_id.' and status='.Design::STATUS_PASS);
                     $v->save();
                 }

             }else{
                 //不通过
                 /** @var $v design */
                 foreach($designs as &$v){
                     $v->status = Design::STATUS_NOT_PASS;
                     $v->save();
                 }
             }
         }
        return true;
    }
} 