<?php

/**
 * 用户反馈控制器
 * @author zhizhong.liu <404597544@qq.com>
 */
class FeedbackController extends Controller
{

    public $layout = '//layouts/miniMain';

    /*
     * 用户反馈
     */
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest){ 
            //throw new CHttpException(403, '亲，登陆后才能提交反馈哦!');
            Yii::app()->user->setReturnUrl($this->createAbsoluteUrl('/help'.Yii::app()->request->getUrl()));
            $this->redirect($this->createAbsoluteUrl("/member/home/login"));
          }
        $model = new Feedback;
        $this->performAjaxValidation($model);
        if (isset($_POST['Feedback'])) {
            $model->attributes = $this->getParam('Feedback');
            $model->gai_number = $this->getUser()->gw;
            $model->created = time();
            $model->ip = Tool::getIP();
            if ($model->save()) {
                //移动图片到指定目录
                $this->setFlash('success', Yii::t('Feedback', '提交成功！'));
                $this->refresh();
            } else {
                $this->setFlash('error', Yii::t('Feedback', '提交失败！'));
            }
        }
        $member = Member::model()->findByPk($this->getUser()->id);
        $model->mobile = $member->mobile;
        $model->username = $member->real_name;
        $this->render('index', array('model' => $model));

    }

}

?>