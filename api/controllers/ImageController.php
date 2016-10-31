<?php

/**
 * 图片接口
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class ImageController extends Controller {

    /**
     * 图片获取接口
     * 没有图片缓存
     */
    public function actionIndex() {
        $this->checkRequest();
        $mediaId = $this->checkParam('MediaID');    //图片id
        $width = $this->getPost('Width');    //宽
        $height = $this->getPost('Height');    //高
        $mediaId = str_replace('/', DS, $mediaId);
        ImageTool::outPutImageById($mediaId, $width, $height);
        Yii::app()->end();
//        $this->imageRedirect($mediaId,$width='',$height='');
    }
    
    /**
     * 利用apache的地址跳转用前台的thumbController控制器来处理图片
     * http://att.gatewang.com/head_portrait/80x80,c_fill,h_128,w_128.gif
     * @param type $url
     */
    public function imageRedirect($mediaId,$width='',$height='') {
        $param = '';
        if($width) $param .= ',w_'.$width;//宽
        if($height) $param .= ',h_'.$height;//高
        if($param){
            $suf = substr($mediaId, strrpos($mediaId, '.'));
            $pre = str_replace($suf, '', $mediaId);
            $src = $pre.$param.$suf;
        }  else {
            $src = $mediaId;
        }
        $this->redirect($src);
    }




    /**
     * 
    public function actionGetImage() {
        $this->checkRequest();
        $mediaId = $this->checkParam('MediaID');    //图片id
        $mediaId = stripslashes($mediaId);
        $param = '';
        if($width = $this->getPost('Width')) $param .= ',w_'.$width;//宽
        if($height = $this->getPost('Height')) $param .= ',h_'.$height;//高
        if($param){
            $suf = substr($mediaId, strrpos($mediaId, '.'));
            $pre = str_replace($suf, '', $mediaId);
            $src = $pre.$param.$suf;
        }  else {
            $src = $mediaId;
        }
//        die($src);
        define('THUMB_SRC', $src); //图片地址
        $dir = Yii::getPathOfAlias('comvendor') . '/EvaThumber';
        $autoloader = $dir . '/vendor/autoload.php';
        $localConfig = $dir . '/config.local.php';
        if (file_exists($autoloader)) {
            $loader = include $autoloader;
        } else {
            die('Dependent library not found, run "composer install" first.');
        }

        $loader->add('EvaThumber', $dir . '/src');

        $config = new EvaThumber\Config\Config(include $dir . '/config.att.php');
        if (file_exists($localConfig)) {
            $localConfig = new EvaThumber\Config\Config(include $localConfig);
            $config = $config->merge($localConfig);
        }

        $thumb = new EvaThumber\Thumber($config);

        try {

            $thumb->show();
        } catch (Exception $e) {
            throw $e;
        }

        Yii::app()->end();
    }
     * 
     */
}

?>
