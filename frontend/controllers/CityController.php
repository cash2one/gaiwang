<?php

/**
 * 城市频道控制页
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2016/4/14
 * Time: 16:25
 */
class CityController extends Controller
{

    public $layout ='city';

    public function actionIndex(){
        $this->title = "城市频道 - ".$this->pageTitle;
        $this->render('index');
    }

    public function missingAction($actionId){
        if($actionId=='view' && isset($_GET['id'])){ //当 city后面是数字，此时actionId 是view，有$_GET['id']
            $actionId = $_GET['id'];
        }
        $city = Cityshow::getCityByEncode($actionId);
        if(!$city) throw new CHttpException(404,"没有找到数据");
        $this->theme = Yii::app()->getTheme();
        $this->title = $city['title']."-城市馆-".$this->pageTitle;
        $cityGoods=CityshowGoods::getCityViewGoods($city['id']);
        $this->render('city',array('cityInfo'=>$city,'cityGoods'=>$cityGoods));
    }
    /**
     * 城市馆预览
     * @throws CHttpException
     */
    public function actionPreview(){
        if(isset($_GET['id'])){
            $id = Tool::authcode(base64_decode($_GET['id']),'DECODE',DOMAIN,300);
        }else{
            $id = false;
        }
        if(!$id) throw new CHttpException(404,"没有找到数据");
        $city = Cityshow::model()->findByAttributes(array('encode'=>$id));
        $this->theme = Yii::app()->getTheme();
        $this->title = $city['title']."-城市馆-".$this->pageTitle;
        $cityGoods=CityshowGoods::getCityViewGoods($city['id']);
        $this->render('city',array('cityInfo'=>$city,'cityGoods'=>$cityGoods));
    }
}