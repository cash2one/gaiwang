<?php

/**
 * 线下服务控制器
 * @author ling.wu <178703790@qq.com>
 */
class SiteController extends Controller {
	public $size = '6'; //每页显示多少个商家信息
    public $newSize = '10'; //每页显示多少个商家信息,2.0版本
    public $cat;
    public $offlineCity = array();
    public $city;
    public $city_id;
    public $categorys;
    public $id = '';


    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction', 'method' => 'selectLanguage'),
        );
    }

    public function beforeAction($action) {
        //设置seo
        $seo = $this->getConfig('seo');
        $this->pageTitle = Yii::t('jms', $seo['jmsTitle']);
        $this->keywords = $seo['jmsKeyword'];
        $this->description = $seo['jmsDescription'];

        header("Content-type: text/html; charset=utf-8");

        return parent::beforeAction($action);
    }

    /**
     * 加盟商首页
     */
    public function actionIndex() {

        $this->city_id = $city_id = (!empty($_GET['city']) && $_GET['city'] > 0) ? $_GET['city'] : 237;
        // 线下活动城市数据
        $this->offlineCity = $offlineCity = FranchiseeActivityCity::fileCache();

         $city = $this->_getCity($city_id, $offlineCity);

        // 分类数据
        $this->categorys = $categorys = $this->_getCategorys();
        
     	// ajax最新入驻商家信息：		
    	if (Yii::app()->request->isAjaxRequest){
    		$offset = $this->getParam('offset');
    		echo $this->_getFranchisees($this->size,$offset,true,$city);
	        Yii::app()->end();
		}

        // 最新入驻商家信息
        $newsFranchisee = $this->_getFranchisees($this->size,0,false,$city);

        //推荐商家8条
        $recommends = $this->_getFranchiseeRecommend(8);

        //2.0版本内容开始
        $this->city = !isset($_GET['city']) ? $city : $_GET['city'];
        $bannerAdv = Advert::getChannelIndexAdver(Advert::JMS_BANNER_MAIN.'_'.$this->city,0,5);   // 轮播图广告5张图
        $bestWelcomeRecommend = Advert::getChannelIndexAdver(Advert::JMS_BANNER_WELCOME.'_'.$this->city,0,1);
        $bestRecommend = Advert::getChannelIndexAdver(Advert::JMS_BANNER_BEST.'_'.$this->city,0,1);
        $notice = Advert::getChannelIndexAdver(Advert::JMS_NOTICE.'_'.$this->city,0,1);//公告
        $newsFranchisees = $this->_getNewFranchisees(10,0,false,$this->city);

        $this->title = '盖网商城--盖网通加盟商';
        //推荐商家5条
        $cityRecommends = $this->_getFranchiseeRecommend(5,$this->city);
        $mainA = Advert::getChannelIndexAdver(Advert::JMS_MAIN_A.'_'.$city,0,1);
        $mainB = Advert::getChannelIndexAdver(Advert::JMS_MAIN_B.'_'.$city,0,1);
        $mainC = Advert::getChannelIndexAdver(Advert::JMS_MAIN_C.'_'.$city,0,1);
        $mainD = Advert::getChannelIndexAdver(Advert::JMS_MAIN_D.'_'.$city,0,1);
        $mainE = Advert::getChannelIndexAdver(Advert::JMS_MAIN_E.'_'.$city,0,2);
        $mainF = Advert::getChannelIndexAdver(Advert::JMS_MAIN_F.'_'.$city,0,1);

        $this->render('index', array(
            'categorys' => $categorys,
            'newsFranchisee' => $newsFranchisee,
            'offlineCity' => $offlineCity,
            'recommends' => $recommends,
            'city' => $city,
      		'size' => $this->size,
            'bannerAdv'=>$bannerAdv,
            'bestWelcomeRecommend'=>$bestWelcomeRecommend,
            'bestRecommend'=>$bestRecommend,
            'notice'=>$notice,
            'mainA'=>$mainA,
            'mainB'=>$mainB,
            'mainC'=>$mainC,
            'mainD'=>$mainD,
            'mainE'=>$mainE,
            'mainF'=>$mainF,
            'newsFranchisees'=>$newsFranchisees,
            'cityRecommends'=>$cityRecommends
        ));
    }

    /**
     * 加盟商列表页  
     */
    public function actionList() {
    	
   		//ajax商家信息    	
    	if (Yii::app()->request->isAjaxRequest){
    		$offset = $this->getParam('offset');
    		$ajaxCat = $this->getParam('ajaxCat');
    		$ajaxCity_id = $this->getParam('ajaxCity');
    		$ajaxKeyword = $this->getParam('ajaxKeyword');
    		
    		echo $this->_getFranchisees($this->size,$offset,true,$ajaxCity_id,$ajaxCat,$ajaxKeyword);
	        Yii::app()->end();
		}

        $this->cat = $cat = isset($_GET['cat']) ? $this->getParam('cat') : "";
        $city_id = (isset($_GET['city']) && $this->getParam('city') > 0) ? $this->getParam('city') : 237;
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

        if ($cat != "" && !is_numeric($cat))
            throw new CHttpException(404, Yii::t('jmsCategory', "访问出错！"));

        if ($city_id != "" && !is_numeric($city_id))
            throw new CHttpException(404, Yii::t('jmsCategory', "访问出错！"));

        // 线下活动城市数据
        $this->offlineCity = $offlineCity = FranchiseeActivityCity::fileCache();

        $cityName = "";
        if ($city_id) {
            //获取城市
            $city_id = $this->_getCity($city_id, $offlineCity);

            //当然城市名
            $cityName = $this->_getCityName($city_id);
        }

        // 分类
        $this->categorys = $categorys = $this->_getCategorys();

        //当前分类名
        $categoryName = null;
        if (!empty($cat))
            $categoryName = FranchiseeCategory::model()->findByPk($cat)->name;
        $this->title = '盖网商城--盖网通加盟商列表--'.$categoryName;

        //商家信息 
        $franchisees = $this->_getFranchisees($this->size,0,false,$city_id,$cat,$keyword);

        //推荐商家8条
        $recommends = $this->_getFranchiseeRecommend(8);

        //2.0版本内容开始
        $mainF = $newsFranchisees = array();
        $this->city = !isset($_GET['city']) ? $city_id : $_GET['city'];
        $keyword = empty($_POST['keyword']) ? null :$_POST['keyword'] ;
        $mainF = Advert::getChannelIndexAdver(Advert::JMS_LIST_T.'_'.$cat.'_'.$this->city,0,1);
        $newsFranchisees = $this->_getNewFranchisees(0,0,0,$this->city,$cat,$keyword);
        //推荐商家5条
        $cityRecommends = $this->_getFranchiseeRecommend(5,$this->city);

        $this->render('list', array(
            'categorys' => $categorys,
            'franchisees' => $franchisees,
            'categoryName' => $categoryName,
            'cat' => $cat,
            'city_id' => $city_id,
            'cityName' => $cityName,
            'keyword' => $keyword,
            'offlineCity' => $offlineCity,
            'recommends' => $recommends,
        	'size' => $this->size,
            'mainF'=>$mainF,
            'newsFranchisees'=>$newsFranchisees,
            'cityRecommends'=>$cityRecommends
        ));
    }

    /**
     * 加盟商详细页   
     */
    public function actionView($id) {

        $this->layout = 'main_1';

        // 商家信息
        $franchisee = $this->_getFranchisee($id);

        //动态图
        $pictures = yii::app()->db->createCommand()
        ->select('id, path')
        ->from('{{franchisee_picture}}')
        ->where('franchisee_id=:fid', array(':fid' => $id))
        ->order('sort DESC')
        ->queryAll();

        //与当然商家相同城市，不同分类的3个分类商家信息
        $difFranchisees = $this->_getDifFranchisee($id, $franchisee['franchisee_category_id'], 3);

        //2.0版本内容
        $city_id = null;
        // 线下活动城市数据
        $this->offlineCity = $offlineCity = FranchiseeActivityCity::fileCache();
        $city = $this->_getCity($city_id, $offlineCity);
        // 分类数据
        $this->categorys = $categorys = $this->_getCategorys();
        $this->title = '盖网商城--'.$franchisee['name'];
        $this->city = !isset($_GET['city']) ? $franchisee['city_id'] : $_GET['city'];

        $sql = "UPDATE `{{franchisee}}` SET `visit_count`=visit_count+1 WHERE id={$id}  ";
        Yii::app()->db->createCommand($sql)->query();
        
        $this->render('view', array(
            'franchisee' => $franchisee,
            'pictures' => $pictures,
            'difFranchisees' => $difFranchisees,
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


    /**
     * 获取加盟商信息
     * @param type $id 加盟商ID
     * @return type
     */
    private function _getFranchisee($id) {
        $data = yii::app()->db->createCommand()->select('f.id, f.name,ftc.franchisee_category_id,f.member_discount,f.description,f.thumbnail, f.summary,f.featured_content, f.province_id, f.main_course, f.logo,f.logo2, f.city_id, f.district_id, f.street, f.qq, f.mobile, f.lng, f.lat,rc.name as rc_name,rd.name as rd_name,f.visit_count')
        ->from('{{franchisee}} as f')
        ->leftjoin('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id')
        ->leftjoin('{{region}} as rc', 'f.city_id=rc.id')
        ->leftjoin('{{region}} as rd', 'f.district_id=rd.id')
        ->where('f.status=:status And f.id=:id', array(':status' => Franchisee::STATUS_ENABLE, ':id' => $id))
        ->queryAll();
        if (empty($data[0])) {
            throw new CHttpException(404, Yii::t('jms', "加盟商不存在！"));
        } else {
            return $data[0];
        }
    }

    /**
     * 获取推荐商家
     * @return array
     */
    private function _getFranchiseeRecommend($limit,$city=0) {

        $recommend = Yii::app()->db->createCommand()->select('id,name,logo,member_discount')->from('{{franchisee}}')
        ->where('is_recommend=:is_recommend', array('is_recommend' => 1))
        ->andWhere('status=:status', array(':status' => 0));
            if($city > 0){
                $recommend = $recommend->andWhere('city_id=:city', array(':city' => $city));
            }
        $recommend = $recommend->order('update_time desc')->limit($limit)->queryAll();
        return $recommend;
    }

    /**
     * 获取默认地址
     * @param $city_id
     * @param $offlineCity
     * @return int
     */
    private function _getCity($city_id, $offlineCity) {
        $position = array(
            'province_id' => '22',
            'province_name' => '广东',
            'city_id' => '237',
            'city_name' => '广州市',
        );

        // 获取用户的地址
        $memeber_city = Tool::getPosition();

        // 如果输入的城市不在线下城市范围内，判断用户所在的城市ID在不在下线城市范围内，否则全部指向广州    	
        $cityIds = array();
        foreach ($offlineCity as $c)
            array_push($cityIds, $c['city_id']);
        $city = null;
        if (!in_array($city_id, $cityIds)) {
            if (!in_array($memeber_city, $cityIds)) {
                $city = $position['city_id'];
            } else {
                $city = $memeber_city['city_id'];
            }
        } else {
            $city = $city_id;
        }
        return $city;
    }

    /**
     * 获取分类
     * @return array
     */
    private function _getCategorys() {
        $categorys = yii::app()->db->createCommand()->select('id,name,bgclass')
        ->from('{{franchisee_category}} as fc')
        ->where('parent_id=:parent_id  and status=:status and fc.show=:show', array(':parent_id' => 0, ':status' => 1, ':show' => 1))
        ->order('sort desc')
        ->queryAll();
        return $categorys;
    }

    /**
     * 获取城市名
     * @param int $city_id
     */
    private function _getCityName($city_id) {
        $cityName = "";
        $city = Region::model()->findByPk($city_id);
        if ($city) {
            $cityName = $city->name;
        }
        return $cityName;
    }

    /**
     * 获取与当前商家相同城市，不相同的分类的 各取1个商家信息
     * @param int $id
     * @param int $cid
     * @param int $limit
     * @return array
     */
    private function _getDifFranchisee($id, $cid, $limit) {
        $franchisees = array();

        //取与当前相同城市，不同的分类  
        $franchisee = Franchisee::model()->findByAttributes(array('id' => $id));
        $categorys = '';
        $city_id = '';
        if ($franchisee) {
            $city_id = $franchisee->city_id;
            if ($city_id) {
                $categorys = Yii::app()->db->createCommand()->select('ftc.franchisee_category_id')->from('{{franchisee}} as f')
                ->leftJoin('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id')
                ->where('f.status =:status and ftc.franchisee_category_id <>:franchisee_category_id and city_id=:city_id', array('status' => 0, ':franchisee_category_id' => $cid, ':city_id' => $city_id))->group('franchisee_category_id')->queryAll();
                if (!count($categorys)) {
                    return $franchisees;
                }
            } else {
                return $franchisees;
            }
        } else {
            return $franchisees;
        }


        $newCategorys = array();

        if (0 < count($categorys) && count($categorys) < $limit) {
            if (count($categorys) == 1) {
                $newCategorys[] = $categorys[0]['franchisee_category_id'];
            } else {
                $arr = array_rand($categorys, count($categorys));
                foreach ($arr as $a) {
                    $newCategorys[] = $categorys[$a]['franchisee_category_id'];
                }
            }
        } elseif (count($categorys) >= $limit) {
            $arr = array_rand($categorys, $limit);
            foreach ($arr as $a) {
                $newCategorys[] = $categorys[$a]['franchisee_category_id'];
            }
        }


        //各分类各取一个商家   		
        foreach ($newCategorys as $c) {            
            $rs = Yii::app()->db->createCommand()->select('count(*) as count ')->from('{{franchisee}} as f ')
            	->join('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id')
            	->where('f.status=:status and ftc.franchisee_category_id=:franchisee_category_id and f.city_id=:city_id',array(':status'=>0,':franchisee_category_id'=>$c,':city_id'=>$city_id))
            	->queryAll();            
            $count = $rs[0]['count'];
            $offset = mt_rand(0, $count - 1);
            $t_franchisse = Yii::app()->db->createCommand()->select('f.id,f.name,f.logo,f.member_discount,ftc.franchisee_category_id,f.city_id')
            ->from('{{franchisee}} as f')
            ->join('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id')
            ->where('f.status =:status and ftc.franchisee_category_id = :franchisee_category_id and f.city_id=:city_id', array(':status' => 0, ':franchisee_category_id' => $c, 'city_id' => $city_id))
            ->offset($offset)
            ->limit(1)
            ->queryAll();
            if (isset($t_franchisse[0])) {
                $franchisees[] = $t_franchisse[0];
            }
        }

        return $franchisees;
    }

    /**
     * 获取商家信息
     * @param $size
     * @param int $offset
     * @param $isAjax
     * @param null $city_id
     * @param null $cat
     * @param null $keyword
     * @return array
     */
    private function _getFranchisees($size,$offset=0,$isAjax,$city_id=null,$cat=null,$keyword=null){
        $franchise = yii::app()->db->createCommand()
            ->select('f.id, f.name,f.member_discount, f.logo,fc.name as c_name,f.thumbnail')
            ->from('{{franchisee}} as f')
            ->where('f.status=:status ', array(':status' => 0,));
        if (!empty($city_id))
            $franchise->andWhere('f.city_id=:city_id ', array(':city_id' => $city_id));
            $franchise->join('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id');
        if (!empty($cat)) {
            $franchise->andWhere('ftc.franchisee_category_id=:franchisee_category_id', array(':franchisee_category_id' => $cat));
        }else{
            //如果没有选择分类，而当前加盟商属于多个分类，则取第一个分类，不然会出现重复记录
        	$franchise->group('f.id');
            //$franchise->join('(select franchisee_category_id,franchisee_id from {{franchisee_to_category}}  group by franchisee_id ) as ftc', 'f.id=ftc.franchisee_id');
        }
        if (!empty($keyword)) {
            $franchise->andWhere('(f.name like :name or f.tags like :tags)', array(':name' => "%$keyword%", ':tags' => "%$keyword%"));
        }
        $franchisees = $franchise->join('{{franchisee_category}} as fc', 'ftc.franchisee_category_id=fc.id')
            ->order('id DESC')->limit($size)->offset($offset)->queryAll();

        if($isAjax){
            foreach ($franchisees as $k=>$v){
                $franchisees[$k]['id'] = $this->createAbsoluteUrl('view',array('id'=>$v['id']));
                $franchisees[$k]['logo'] = Tool::showImg( ATTR_DOMAIN . '/' . $v['logo'], 'w_240,h_120');
                $franchisees[$k]['thumbnail'] = Tool::showImg( ATTR_DOMAIN . '/' . $v['thumbnail'], 'w_600,h_200');
            }
            echo CJSON::encode($franchisees);
        }else{
            return  $franchisees;
        }
    }

    /**
     * 获取商家信息
     * @param $size
     * @param int $offset
     * @param $isAjax
     * @param null $city_id
     * @param null $cat
     * @param null $keyword
     * @return array
     */
    private function _getNewFranchisees($size,$offset=0,$isAjax,$city_id=null,$cat=null,$keyword=null){
        $model = new Franchisee();
        $condition = "t.status=:status";
        if (!empty($keyword)) {
            $condition .= " AND (t.name like '%$keyword%' OR t.tags like '%$keyword%')";
        }
        $criteria = new CDbCriteria(array(
            'condition' => $condition,
            'order' => 'id DESC',
            'params' => array(':status' => 0)
        ));
        $criteria->select = 't.id, t.name,t.member_discount,t.visit_count,t.logo,t.thumbnail,t.summary,ftc.franchisee_category_id,ftc.franchisee_id,fc.bussbgclass';
        if (!empty($city_id)) $criteria->compare('t.city_id', '='.$city_id);
        $criteria->join = "LEFT JOIN {{franchisee_to_category}} as ftc on ftc.franchisee_id = t.id LEFT JOIN {{franchisee_category}} as fc ON ftc.franchisee_category_id=fc.id";
        if (!empty($cat)) {
              $criteria->compare('ftc.franchisee_category_id', '='.$cat);
        }else{
            //如果没有选择分类，而当前加盟商属于多个分类，则取第一个分类，不然会出现重复记录
        	  $criteria->group='t.id';
            //$criteria->join = "LEFT JOIN (select ftc.franchisee_category_id,ftc.franchisee_id from gw_franchisee_to_category as ftc group by ftc.franchisee_id ) as ftc ON ftc.franchisee_id=t.id LEFT JOIN {{franchisee_category}} as fc ON ftc.franchisee_category_id=fc.id";
            //$criteria->join = "LEFT JOIN {{franchisee_category}} as fc ON ftc.franchisee_category_id=fc.id";
        }

        $count = Franchisee::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit($criteria);
        $franchisees = Franchisee::model()->findAll($criteria);

        if($franchisees){
            foreach ($franchisees as $k=>$v){
                $franchisees[$k]['id'] = $this->createAbsoluteUrl('site/view',array('id'=>$v['id']));
                $franchisees[$k]['logo'] = ATTR_DOMAIN . '/' . $v['logo'];
                $franchisees[$k]['thumbnail'] = ATTR_DOMAIN . '/' . $v['thumbnail'];
                $franchisees[$k]['summary'] = Tool::truncateUtf8String($v['summary'],43);
                $franchisees[$k]['bussbgclass'] = $v['bussbgclass'];
            }
        }
	    if($isAjax){
            $franchisees = CJSON::encode($franchisees);
	    }

        return array('list'=>$franchisees,'page'=>$pager);

    }

    /**
     * 获取商家公告
     * @param $size
     * @param int $offset
     * @param $isAjax
     * @param null $city_id
     * @param null $cat
     * @return array
     */
    private function _getFranchiseesNotice($size,$offset=0,$isAjax,$city_id=null,$cat=null){
        $franchise = yii::app()->db->createCommand()
            ->select('f.id, f.notice')
            ->from('{{franchisee}} as f')
            ->where('f.status=:status and f.notice <> "" ', array(':status' => 0,));
        if (!empty($city_id))
            $franchise->andWhere('f.city_id=:city_id ', array(':city_id' => $city_id));
        $franchise->join('{{franchisee_to_category}} as ftc', 'f.id=ftc.franchisee_id'); 
        if (!empty($cat)) {
            $franchise->andWhere('ftc.franchisee_category_id=:franchisee_category_id', array(':franchisee_category_id' => $cat));
        }else{
            //如果没有选择分类，而当前加盟商属于多个分类，则取第一个分类，不然会出现重复记录
        	$franchise->group('f.id');
            //$franchise->join('(select franchisee_category_id,franchisee_id from {{franchisee_to_category}}  group by franchisee_id ) as ftc', 'f.id=ftc.franchisee_id');
        }

        $franchisees = $franchise->join('{{franchisee_category}} as fc', 'ftc.franchisee_category_id=fc.id')
            ->order('f.update_time DESC')->limit($size)->offset($offset)->queryAll();

        if($isAjax){
            foreach ($franchisees as $k=>$v){
                $franchisees[$k]['id'] = $this->createAbsoluteUrl('view',array('id'=>$v['id']));
                $franchisees[$k]['logo'] = Tool::showImg( ATTR_DOMAIN . '/' . $v['logo'], 'w_240,h_120');
                $franchisees[$k]['thumbnail'] = Tool::showImg( ATTR_DOMAIN . '/' . $v['thumbnail'], 'w_600,h_200');
            }
            return CJSON::encode($franchisees);
        }else{
            return  $franchisees;
        }
    }
}
