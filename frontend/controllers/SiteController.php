<?php

/**
 * 网站首页控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class SiteController extends Controller {

    public $layout = 'home';
    public $author;

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction', 'method' => 'selectLanguage'),
        );
    }

    public function beforeAction($action) {
        $seo = $this->getConfig('seo');
        $this->author = $seo['author'];
        $this->title = $seo['title'];
        $this->keywords = $seo['keyword'];
        $this->description = $seo['description'];
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $curLanguage = Yii::app()->language;
        $language = array(
            'zh_cn' => 'index.html',
            'zh_tw' => 'index_tw.html',
            'en' => 'index_en.html',
        );
        $dir = Yii::getPathOfAlias('webroot');

        foreach($language as $key => $v){
            if(YII_DEBUG) continue; //调试模式不生成文件
            Yii::app()->language = $key;
            $file = $dir.DS.$v;
            if(!file_exists($file))
            {
                $data = $this->render('index','',true);
                $ftp = fopen($file,'w');
                fwrite($ftp,$data);
                fclose($ftp);
            }
        }
        Yii::app()->language = $curLanguage;
        if($curLanguage === 'zh_cn')
        {
            $this->render('index');
        }
        else
        {
            $this->redirect(DOMAIN.'/'.$language[$curLanguage]);
        }
    }

    public function actionAdClose() {
        $this->setCookie('adClose', true, '3600');
    }

    public function actionError() {
        if($this->theme){
            $this->layout = false;
        }else{
            $this->layout = 'main';
        }
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * 鼠标停留 ajax 获取楼层分类相商品
     * @param $categoryId
     */
    public function actionAjaxFloor($cid)
    {
        if ($this->isAjax() && is_numeric($cid)) {
            $this->layout = 'null';
            $dir = 'ajaxFloor';
            $goods = Tool::cache($dir)->get('ajaxFloorGoods' . $cid);
            if (!$goods){
                $category = Category::getFloorCategoryGrandsonId(array($cid));
                $goods = Goods::getFloorGoods($category,10);
                if ($goods) {
                    Tool::cache($dir)->set('ajaxFloorGoods' . $cid, $goods, 30);
                }
            }
            if(empty($goods)) exit(Yii::t('site','暂无数据'));
            $str = $this->render('ajaxFloor', array('arr' => $goods), true);
           echo $str;
        }
    }

    /*获取登陆用户信息*/
    public function actionSelect(){
        if ($this->getUser()->id && !$this->getUser()->isGuest){
            $arr['username']= $this->getUser()->name;
            $arr['status'] =1;
        }else{
            $arr['username']= '';
            $arr['status'] =2;
        }
        exit('jsonpCallback(' . CJSON::encode($arr) . ')');
    }

    public function actionAjaxOffline($cid,$tag){
        if ($this->isAjax() && is_numeric($tag)) {
            $this->layout = 'null';
            $data = Advert::getOfflineDefaultAdvert(array('city_id'=>$cid),'index_offline_ad1'.$tag);
            $data1 = array_shift($data);
            $data = Advert::getOfflineDefaultAdvert(array('city_id'=>$cid),'index_offline_ad2'.$tag);
            $data2 = array_shift($data);
            if(!empty($data1) && !empty($data2)){
                $lastData = array_merge($data1['ad'],$data2['ad']);
            }else if(empty($data1)){
                $lastData = $data2['ad'];
            }else{
                $lastData = $data1['ad'];
            }
            $str = $this->render('ajaxOffline', array('data' =>$lastData), true);
            echo $str;
        }
    }

    /**
     * 首页底部，猜你喜欢，随机获取商品
     */
    public function actionAjaxRandGoods(){
        if($this->isAjax()){
            $data = array();
            $num = $this->getParam('num') >=1 ? $this->getParam('num') : 6;
            $num = (int)$num;
            $img = $this->getParam('img') ? $this->getParam('img') : 'c_fill,h_199,w_199';
            foreach(Goods::getRandRecord($num) as $v){
                $data[] = array(
                    'url'=>$this->createAbsoluteUrl('goods/view',array('id'=>$v['id'])),
                    'src'=>Tool::showImg(IMG_DOMAIN.'/'.$v['thumbnail'],$img),
                    'price'=>HtmlHelper::formatPrice($v['price']),
                    'name'=>Tool::truncateUtf8String($v['name'],12),
                    'spec_id'=>$v['goods_spec_id'],
                    'id'=>$v['id'],
                );
            }
            echo json_encode($data);
        }
    }
}
