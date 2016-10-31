<?php

class FranchiseeCodeController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//	public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 批量生成预设加盟商编号
     * @param int $num   要生成个数
     */
    public function actionCreate() {
        $num = FranchiseeCode::NUMBER;
        if ($num > 0) {
            $tn = '{{franchisee_code}}';
            $status = FranchiseeCode::UNUSED;
            $time = time();
            $sql_insert = "INSERT INTO $tn(`code`,`status`,`create_time`)VALUE";
            for ($i = $num; $i > 0; $i--) {
                $code = FranchiseeCode::generateUniqueCode();   //生成预设加盟商编号
                $sql_insert .= "('" . $code . "','" . $status . "','" . $time . "'),";
            }
            $sql_insert = substr($sql_insert, 0, strlen($sql_insert) - 1);
            Yii::app()->db->createCommand($sql_insert)->execute();
//                echo '已创建' . $num . '个预设加盟商编号';
			@SystemLog::record(Yii::app()->user->name."批量创建 ' . $num . ' 个预设加盟商编号");
            $this->redirect(array('admin'));
        } else {
            echo '请输入大于0的整数';
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new FranchiseeCode('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['FranchiseeCode'])) {
            $model->attributes = $_GET['FranchiseeCode'];
            if (isset($_GET['FranchiseeCode']['endTime']))
                $model->endTime = $_GET['FranchiseeCode']['endTime'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 导出生成预设加盟商编号
     */
    public function actionUpdate() {
            $model = new FranchiseeCode();
            $model->create_time = $_GET['create_time'];
            
            $this->render('franchiseeCodeExport',array(
               'model'=>$model, 
            ));
    }

}
