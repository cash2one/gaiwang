<?php

/**
 * 专题控制器 
 * 操作 (专题列表,查看专题)
 * @author  jianlin.lin <hayeslam@163.com>
 */
class SiteController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction', 'method' => 'selectLanguage'),
        );
    }

    public $theme; //主题对象
    public function init() {
        $this->theme = Yii::app()->getTheme();
        // 加载专题css样式
//        Yii::app()->clientScript->registerCssFile(DOMAIN . '/css/zt.css');
    }

    /**
     * 调用单页文件
     * @param string $actionId
     */
    public function missingAction($actionId) {

        $actionId = substr($actionId, -5) == '.html' ? substr($actionId, 0, -5) : $actionId;
        $renderFile = 'application.modules.zt.views.site.pages.' . $actionId;

        if (file_exists(Yii::getPathOfAlias($renderFile) . '.php')) {
            // 小于 2015-12-7 日的专题，使用旧版layouts
            $fileTime  = filemtime(Yii::getPathOfAlias($renderFile).'.php');
            if($fileTime < 1449417600 ){
                Yii::app()->setTheme(null);
            }
            if(!Yii::app()->theme){
                $this->layout = 'application.views.layouts.main';
            }else if(Yii::app()->theme){
                $this->layout = '//layouts/main2';
            }
            $this->render($renderFile);
        } else {
            parent::missingAction($actionId);
        }
    }

    /**
     * 专题列表
     */
    public function actionIndex() {
        Yii::app()->setTheme(null);
        $seo = Tool::getConfig('seo');
        $this->pageTitle = $seo['ztTitle'];
        $this->keywords = $seo['ztKeyword'];
        $this->description = $seo['ztDescription'];
        $criteria = new CDbCriteria(array(
            'select' => 'id, name, start_time, end_time, thumbnail',
            'order' => 'start_time DESC'
        ));
        $dataProvider = new CActiveDataProvider('SpecialTopic', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 6,
            ),
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * 查看专题
     * @param integer $id
     */
    public function actionView($id) {
        Yii::app()->setTheme(null);
        // var_dump($id);
        $model = SpecialTopic::model()->with('specialTopicCategory')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('error', '请求的页面不存在。'));
        $this->pageTitle = Yii::t('zt', $model->title . ' - 盖网专题');
        $this->keywords = $model->keywords . ' - ' . Yii::app()->name;
        $this->description = $model->description . ' - ' . Yii::app()->name;
        $data = $model->getSpecialTopicGoods(); // 获取该专题分类下的商品
        $this->render('view', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}