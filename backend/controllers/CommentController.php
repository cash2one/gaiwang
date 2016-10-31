<?php

/**
 * 订单评论
 * 操作(查看，修改状态)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class CommentController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 修改状态
     * @param integer $id the ID of the model to be updated
     */
    public function actionChangeStatus($id) {
        /** @var $model Comment */
        $model = $this->loadModel($id);
        $model->status = $model->status ? $model::STATUS_HIDE : $model::STATUS_SHOW;
        
        $sql = "UPDATE ".Comment::model()->tableName()." set status={$model->status} where id={$model->id}";
        
        @SystemLog::record(Yii::app()->user->name."修改订单评论状态：".$id);
        echo Yii::app()->db->createCommand($sql)->execute();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->breadcrumbs = array(Yii::t('comment', '订单管理 '), Yii::t('comment', '订单评论列表'));

        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Comment']))
            $model->attributes = $_GET['Comment'];

        $c = $model->search();
        //分页
        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);

        $comments = $model->findAll($c);




        $this->render('admin', array(
            'model' => $model,
            'comments' => $comments,
            'pages' => $pages,
        ));
    }

}
