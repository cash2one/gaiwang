<?php
/**
 * 代理商后台
 * Created by PhpStorm.
 * User: pc
 * Date: 2015/11/18
 * Time: 20:08
 */
class OfflineUploadController extends Controller{
    public $prefix = 'offline';

    protected function beforeAction($action) {
        header("Content-type: text/html; charset=utf-8");
        return parent::beforeAction($action);
    }

    /**
     * 删除图片 防止无限上传导致服务器存储过多无用文件
     */
    public function actionDeleteFile(){
        $id = $this->getParam('id');                            //图片文件id   OfflineSignFile-->id
        $deleteModel = $this->getParam('model');                //要删除表的模型
        $field = $this->getParam('field');                      //要删除表的字段
        $modelId = $this->getParam('modelId');                  //要删除表的id
        if($id){                        //如果图片存在
            if($modelId) {               //如果该条记录存在
                $fileId = OfflineSignFile::returnFileId($deleteModel,$field,$modelId);
                //如果表中存储的文件id和要删除的文件id不一致，可以删除记录和文件
                if ($fileId != $id) {
                    $model = OfflineSignFile::model()->findByPk($id);
                    if ($model) {
                        OfflineSignFile::deleteFile($model->path);//删除文件
                        $model->delete();//删除记录
                    }
                }
            }else{
                $model = OfflineSignFile::model()->findByPk($id);
                if ($model) {
                    OfflineSignFile::deleteFile($model->path);//删除文件
                    $model->delete();//删除记录
                }
            }

        }
    }

    /**
     * 电子签约用到的图片上传
     */
    public function actionOfflineIndex(){
        $model = new OfflineUploadForm('picture');
        //$this->performAjaxValidationOffine($model);
        if(isset($_FILES['OfflineUploadForm'])){
            $code = $this->getParam('code');
            $file = CUploadedFile::getInstance($model, 'fileName');
            if (!$file){
                $this->redirect('offlineIndex');
                Yii::app()->end();
            }
            $oldfileName = $file->getName();
            $returnError = '';
            $images_info = $_FILES['OfflineUploadForm']['name']['fileName'];
            $images_size = $_FILES['OfflineUploadForm']['size']['fileName'];
            $filePre = pathinfo($images_info, PATHINFO_EXTENSION);
            $filePre = strtolower($filePre);
            if($images_size > 3000000){
                $returnError = '文件 "'.$images_info.'" 无法被上传. 文件大小3M以内.';
            }
            if (!in_array($filePre,array('jpg','jpeg','gif','bmp'))) {
                $returnError = '文件 "'.$images_info.'" 无法被上传. 只有附档名如下的文件是被允许的: jpg、jpeg、gif、bmp.';
            }
            $oldfileName = substr($oldfileName, 0, strrpos($oldfileName, '.'));
            $fileName = $this->prefix . time() . mt_rand(1000,9999);
            $model = UploadedFile::uploadFile($model, 'fileName', 'offline'. '/' . date('Y/n/j'), null, $fileName);
            if(empty($returnError)) {
                $path = UploadedFile::saveFile('fileName', $model->fileName);
                if($path){
                    $url = ATTR_DOMAIN . '/' . $model->fileName;
                    //入库
                    $fileModel = new OfflineSignFile();
                    $fileModel->old_file_name = $file->getName();
                    $fileModel->path = $model->fileName;
                    $fileModel->classify = $code;
                    $fileModel->suffix = $file->getExtensionName();
                    $fileModel->save();
                    $error = 0;
                }else{
                    $error = 1;
                }
            }
        }

        $this->renderPartial('offlineIndex',array(
            'model'=>$model,
            'url'=>isset($url) ? $url : '',                                 //图片url，为了预览
            'error' => isset($error) ? $error : 2,                          //是否上传错误
            'newFileName' => isset($fileModel->id) ? $fileModel->id : 0,    //文件id，用于入库
            'oldFileName' => isset($oldfileName) ? $oldfileName : '',       //旧文件名(显示)
            'returnError' => !empty($returnError) ? $returnError : '',
        ));
    }

    /**
     * 电子签约用到的图片上传
     */
    public function actionOfflinePdf(){
        $model = new OfflineUploadForm('pdf');
        //$this->performAjaxValidationOffine($model);
        if(isset($_FILES['OfflineUploadForm'])){
            $code = $this->getParam('code');
            $file = CUploadedFile::getInstance($model, 'fileName');
            if (!$file){
                $this->redirect(array('offlinePdf'));
                Yii::app()->end();
            }

            $oldfileName = $file->getName();
            $returnError = '';
            $images_info = $_FILES['OfflineUploadForm']['name']['fileName'];
            $images_size = $_FILES['OfflineUploadForm']['size']['fileName'];
            $filePre = pathinfo($images_info, PATHINFO_EXTENSION);
            $filePre = strtolower($filePre);
            if($images_size > 3000000){
                $returnError = '文件 "'.$images_info.'" 无法被上传. 文件大小3M以内.';
            }
            if (!in_array($filePre,array('pdf'))) {
                $returnError = '文件 "'.$images_info.'" 无法被上传. 只有附档名如下的文件是被允许的: pdf.';
            }
            $oldfileName = substr($oldfileName, 0, strrpos($oldfileName, '.'));
            $fileName = $this->prefix . time() . mt_rand(1000,9999);
            $model = UploadedFile::uploadFile($model, 'fileName', 'offline'. '/' . date('Y/n/j'), null, $fileName);
            if(empty($returnError)) {
                $path = UploadedFile::saveFile('fileName', $model->fileName);
                if($path){
                    $url = ATTR_DOMAIN . DS . $model->fileName;
                    //入库
                    $fileModel = new OfflineSignFile();
                    $fileModel->old_file_name = $file->getName();
                    $fileModel->path = $model->fileName;
                    $fileModel->classify = $code;
                    $fileModel->suffix = $file->getExtensionName();
                    $fileModel->save();
                    $error = 0;
                }else{
                    $error = 1;
                }
            }
        }
        $this->renderPartial('offlineIndex',array(
            'model'=>$model,
            'url'=>isset($url) ? $url : '',                                 //图片url，为了预览
            'error' => isset($error) ? $error : 2,                          //是否上传错误
            'newFileName' => isset($fileModel->id) ? $fileModel->id : 0,    //文件id，用于入库
            'oldFileName' => isset($oldfileName) ? $oldfileName : '',       //旧文件名(显示)
            'returnError' => !empty($returnError) ? $returnError : '',
        ));
    }
    /**
     * 通用的ajax表单验证
     * @param CModel $model
     * @return void
     */
    protected function performAjaxValidationOffine($model) {
        if (isset($_FILES['OfflineUploadForm'])) {
            CActiveForm::validate($model);
        }
    }
}