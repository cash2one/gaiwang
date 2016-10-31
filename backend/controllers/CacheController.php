<?php

/**
 * 缓存控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class CacheController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    public function actionAdmin() {
        $this->render('admin');
    }

    public function actionGetAllCache() {
        /** 适用于本地环境 @author DQB
        $dir = Yii::getPathOfAlias('application');
        $file = str_replace('backend','frontend\www\index.html',$dir);
        $fileTw = str_replace('backend','frontend\www\index_tw.html',$dir);
        $fileEn = str_replace('backend','frontend\www\index_en.html',$dir);
        @unlink($file);
        @unlink($fileTw);
        @unlink($fileEn);
        if(!is_file($file) && !is_file($fileTw) && !is_file($fileEn)){
            $url = parse_url(DOMAIN);
            $host = $url['host'];
            $http = new HttpClient($host);
            $http->quickGet(DOMAIN);

            SystemLog::record($this->getUser()->name . "生成首页静态页");
            $this->setFlash('success', Yii::t('advert', '成功生成首页静态页'));
        }else{
            $this->setFlash('error', Yii::t('advert', '生成首页静态页失败'));
        }
        $this->redirect($this->createAbsoluteUrl('/cache/admin'));
         **/

    	/**
    	 * bit环境和生产环境@author LC
    	 */
    	if(Tool::deleteWebwww('index.html') && Tool::deleteWebwww('index_tw.html') && Tool::deleteWebwww('index_en.html') && Advert::clearvpAdverCache())
    	{
//    		SystemLog::record($this->getUser()->name . "生成首页静态页");
    		$this->setFlash('success', Yii::t('advert', '成功生成首页静态页'));

    	}
    	else 
    	{
    		$this->setFlash('error', Yii::t('advert', '生成首页静态页失败'));
    	}
    	
        $this->redirect($this->createAbsoluteUrl('/cache/admin'));
    }

}
