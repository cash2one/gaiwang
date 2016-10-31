<?php
/**
 * EvaThumber : 基于URL的图片处理库 (可实现缩略图 | 二维码 | 水印 | 面部识别等,基于PHP)
 *
 * 需要开启apache 模块：mod_proxy.so,mod_proxy_http.so
 * 需要配置文件
 * /common/vendor/EvaThumber/config.att.php   对应 根目录下的 attachments
 * /common/vendor/EvaThumber/config.img.php   对应 根目录下的 uploads
 *
 * @see http://avnpc.com/pages/evathumber
 * @author zhenjun_xu <412530435@qq.com>
 */
class ThumbController extends Controller
{

    public function actionIndex()
    {

        define('THUMB_SRC', str_replace('thumb_cache/','',$_GET['src'])); //图片地址
        //
        $dir = Yii::getPathOfAlias('comvendor') . '/EvaThumber';
        $autoloader = $dir . '/vendor/autoload.php';
        $localConfig = $dir . '/config.local.php';
        if (file_exists($autoloader)) {
            $loader = include $autoloader;
        } else {
            die('Dependent library not found, run "composer install" first.');
        }

        $loader->add('EvaThumber', $dir . '/src');

        $config = new EvaThumber\Config\Config(include $dir . '/config.'.$_GET['path'].'.php');
        if (file_exists($localConfig)) {
            $localConfig = new EvaThumber\Config\Config(include $localConfig);
            $config = $config->merge($localConfig);
        }

       
        try {
			$thumb = new EvaThumber\Thumber($config);
            $thumb->show();
        } catch (Exception $e) {
//            throw $e;
//          header('location:' . $config->error_url . '?msg=' . urlencode($e->getMessage()));
        }

        Yii::app()->end();

    }


} 