<?php
/**
 * 店铺装修控制器
 * 操作(店铺首页、实体店页面的自定义)
 * @author zhenjun_xu <412530435@qq.com>
 */

class DesignController extends SController
{
    /** @var  object 当前操作的 */
    public $currentDesign;
    /** @var  Store 店铺信息 */
    public $store;
    //店铺装修数据
    public $design;
    

    /**
     * html主框架显示页面
     */
    public function actionMain()
    {
        $this->layout = false;
        $this->render('main');
    }

    public function loadModel($id)
    {
        $model = Design::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('sellerDesign','请求的页面不存在'));
        if ($model->store_id !== $this->storeId)
            throw new CHttpException(403, Yii::t('sellerDesign','没有权限操作别人的店铺'));
        return $model;
    }

    public $createFirst = false;  //是否新增店铺装修
    public $createNew = false;   //是否第一次进入
    /**
     * 查找或者生成默认的店铺装修模板
     * @return CActiveRecord|Design
     */
    private function _getCurrentDesign(){
        $designs = Design::model()->findAll('store_id=:cid order by update_time DESC limit 1',
            array(':cid' => $this->getSession('storeId')));
        //没有数据，新增一条默认的
        if (!$designs) {
            $model = new Design();
            $data = new DesignFormat();
            $model->data = $data->getJson();
            $model->save();
            $currentDesign = $model;
            $this->createFirst = true;
            $this->createNew = true;
        } else {
            $currentDesign = $designs[0];
            if ($designs[0]->status == Design::STATUS_PASS) {
                $model = new Design();
                $model->attributes = $designs[0]->attributes;
                $model->id = null;
                $model->save();
                $currentDesign = $model;
                $this->createNew = true;
            }
        }
        return $currentDesign;
    }
    /**
     * 装修首页
     */
    public function actionIndex()
    {
        $this->layout = 'design';
        $this->pageTitle = Yii::t('sellerDesign','首页_店铺装修_').$this->pageTitle;
        //店铺分类
        $category = Scategory::model()->findAllByAttributes(array(
            'store_id' => $this->storeId,
            'parent_id' => 0,
            'status' => Scategory::STATUS_USING));
        $this->currentDesign = $this->_getCurrentDesign();
        $design = new DesignFormat($this->currentDesign->data);
        $this->design=$design;
        $this->store = Store::model()->findByPk($this->storeId);
        $this->render('index', array(
            'currentDesign' => $this->currentDesign,
            'design' => $design,
            'category' => $category,
        ) );
    }

    /**
     * 弹窗，设置背景
     */
    public function actionSetBg($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['bg'])) {
            $bg = $this->getPost('bg');
            $designs = new DesignFormat($model->data);
            $designs->BGColor = $bg['BGColor'];
            $upImgArr=explode("|", $bg['BGImg']);
            $upImg=array_pop($upImgArr);
            $designs->BGImg = $upImg;
            $designs->DisplayBgImage = $bg['DisplayBgImage'] == 'true' ? true : false;
            $designs->BGRepeat = $bg['BGRepeat'];
            $designs->BGPosition = $bg['BGPosition'];
            $model->data = $designs->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$model->id,Yii::t('sellerDesign','设置店铺装修背景'));
                echo '<script> var success = true; </script>';
            }

        }
        $this->renderPartial('_setBg', array('model' => $model), false, true);
    }

    /**
     * 设置店铺导航
     * @param $id
     */
    public function actionSetNav($id)
    {
        $model = $this->loadModel($id);
        //店铺分类
        $category = Scategory::model()->findAllByAttributes(array(
            'store_id' => $this->storeId,
            'parent_id' => 0,
            'status' => Scategory::STATUS_USING));
        //店铺文章
        $article = StoreArticle::model()->findAllByAttributes(array(
            'store_id' => $this->storeId,
            'is_publish' => StoreArticle::IS_PUBLISH_YES,
            'status' => StoreArticle::STATUS_THROUGH,
        ));
        if (!empty($_POST)) {
            $jsonData = array();
            $jsonData['Color'] = array(
                'NavigateBG' => $this->getPost('NavigateBG'), //导航栏背景色
                'LinkText' => $this->getPost('LinkText'), //链接文字颜色
                'LinkBGSelected' => $this->getPost('LinkBGSelected'), //当前选中背景颜色
                'LinkBGHover' => $this->getPost('LinkBGHover'), //链接鼠标悬停背景颜色
            );
            //固定的导航链接
            $jsonData['LinkList'] = array(
                0 => array('IsEdit' => false, 'LinkUrl' => '#', 'SourceId' => 0, 'Title' => Yii::t('sellerDesign','首页'), 'Type' => 0),
                1 => array('IsEdit' => false, 'LinkUrl' => '#', 'SourceId' => 1, 'Title' => Yii::t('sellerDesign','商家简介'), 'Type' => 4),
                2 => array('IsEdit' => false, 'LinkUrl' => '#', 'SourceId' => 0, 'Title' => Yii::t('sellerDesign','所有商品'), 'Type' => 5),
            );
            //组合传过来的导航链接
            $tmpLink = array();
            if ($this->getPost('nav')) {
                foreach ($this->getPost('nav') as $v) {
                    foreach ($v as $k2 => $v2) {
                        $tmpLink[$k2][] = $v2;
                    }
                }
                foreach ($tmpLink as $v) {
                    $jsonData['LinkList'][] = array(
                        'IsEdit' => true,
                        'LinkUrl' => $v[3],
                        'SourceId' => intval($v[2]),
                        'Title' => $v[0],
                        'Type' => DesignFormat::navType($v[1]),
                    );
                }
            }
            $design = new DesignFormat($model->data);
            $tmpData = $design->tmpData;
            $tmpData[DesignFormat::TMP_MAIN_NAV] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$model->id,Yii::t('sellerDesign','设置店铺导航'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_setNav', array(
            'model' => $model,
            'category' => $category,
            'article' => $article,
        ), false, true);
    }

    /**
     * 店铺导航view，检查checkbox是否应该选中
     */
    public function checkSelected($find,$links){
        foreach($links as $v){
            if(implode(',',$v)==implode(',',$find)){
                return true;
            }
        }
        return false;
    }

    /**
     * 设置幻灯片
     */
    public function actionSetSlide($id)
    {
        SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺幻灯片'));
        $this->_slide($id,DesignFormat::TMP_MAIN_SLIDE,'_setSlide');
    }

    /**
     * 设置三个图片产品广告
     */
    public function actionSetAdPic($id)
    {
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if (!empty($_POST)) {
            $imgUrl = $this->getPost('ImgUrl');
            $title = $this->getPost('Title');
            $link = $this->getPost('Link');
            $jsonData = array();
            if (!empty($imgUrl)) {
                for ($i = 0; $i < count($imgUrl); $i++) {
                    $jsonData['Imgs'][] = array(
                        'ImgUrl' => $imgUrl[$i],
                        'Title' => $title[$i],
                        'Link' => $link[$i],
                    );
                }
            } else {
                $jsonData = '';
                //删除图片
            }
            $tmpData[DesignFormat::TMP_MAIN_AD] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺产品广告'));
                echo '<script> var success = true; </script>';
            }
        } else {
            //设置三个默认
            if (empty($tmpData[DesignFormat::TMP_MAIN_AD])) {
                $jsonData = array();
                for ($i = 0; $i < 3; $i++) {
                    $jsonData['Imgs'][] = array(
                        'ImgUrl' => '',
                        'Title' => '',
                        'Link' => '',
                    );
                }
                $tmpData[DesignFormat::TMP_MAIN_AD] = $jsonData;
                $design->tmpData = $tmpData;
            }
        }

        $this->renderPartial('_setAdPic', array('model' => $model, 'design' => $design), false, true);
    }
    
    /**
     * v20设置五个图片产品广告
     */
    public function actionSetV20AdPic($id)
    {
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if (!empty($_POST)) {
            $imgUrl = $this->getPost('ImgUrl');
            $title = $this->getPost('Title');
            $link = $this->getPost('Link');
            $jsonData = array();
            if (!empty($imgUrl)) {
                for ($i = 0; $i < count($imgUrl); $i++) {
                    $jsonData['Imgs'][] = array(
                            'ImgUrl' => $imgUrl[$i],
                            'Title' => $title[$i],
                            'Link' => $link[$i],
                    );
                }
            } else {
                $jsonData = '';
                //删除图片
            }
            $tmpData[DesignFormat::TMP_V20_MAIN_AD] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺产品广告'));
                echo '<script> var success = true; </script>';
            }
        } else {
            //设置三个默认
            if (empty($tmpData[DesignFormat::TMP_V20_MAIN_AD])) {
                $jsonData = array();
                for ($i = 0; $i < 5; $i++) {
                    $jsonData['Imgs'][] = array(
                            'ImgUrl' => '',
                            'Title' => '',
                            'Link' => '',
                    );
                }
                $tmpData[DesignFormat::TMP_V20_MAIN_AD] = $jsonData;
                $design->tmpData = $tmpData;
            }
        }
    
        $this->renderPartial('_setAdPic', array('model' => $model, 'design' => $design), false, true);
    }
    
    /**
     * v20设置一个图片产品广告
     */
    public function actionSetV20Adv($id)
    {
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if (!empty($_POST)) {
            $imgUrlArr = explode("|", $this->getPost('ImgUrl'));
            $imgUrl=array_pop($imgUrlArr);
            $title = $this->getPost('Title');
            $link = $this->getPost('Link');
            $jsonData = array();
            if (!empty($imgUrl)) {
                    $jsonData['Imgs'][] = array(
                            'ImgUrl' => $imgUrl,
                            'Title' => $title,
                            'Link' => $link,
                    );
            } else {
                $jsonData = '';
                //删除图片
            }
            $tmpData[DesignFormat::TMP_V20_MAIN_PIC] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺产品广告'));
                echo '<script> var success = true; </script>';
            }
        } else {
            //设置三个默认
            if (empty($tmpData[DesignFormat::TMP_V20_MAIN_PIC])) {
                $jsonData = array();
                    $jsonData['Imgs'][] = array(
                            'ImgUrl' => '',
                            'Title' => '',
                            'Link' => '',
                    );
                $tmpData[DesignFormat::TMP_V20_MAIN_PIC] = $jsonData;
                $design->tmpData = $tmpData;
            }
        }
    
        $this->renderPartial('_setAdv', array('model' => $model, 'design' => $design), false, true);
    }
    

    /**
     * 设置咨询
     */
    public function actionSetContact($id)
    {
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if (!empty($_POST)) {
            $minDate = $this->getPost('MinDate');
            $maxDate = $this->getPost('MaxDate');
            $minTime = $this->getPost('MinTime');
            $maxTime = $this->getPost('MaxTime');
            $prefix = $this->getPost('Prefix');
            $contactNum = $this->getPost('ContactNum');
            $jsonData = array();
            //工作时间
            if (!empty($minDate)) {
                for ($i = 0; $i < count($minDate); $i++) {
                    $jsonData['CustomerWorkTime'][] = array(
                        'MaxDate' => $maxDate[$i],
                        'MaxTime' => $maxTime[$i],
                        'MinDate' => $minDate[$i],
                        'MinTime' => $minTime[$i],
                    );
                }
            }
            //在线咨询
            if (!empty($prefix)) {
                for ($i = 0; $i < count($prefix); $i++) {
                    $jsonData['CustomerData'][] = array(
                        'ContactNum' => $contactNum[$i],
                        'ContactPrefix' => $prefix[$i],
                    );
                }
            }
            $jsonData['CustomerTitle'] = $this->getPost('title');
            $tmpData[DesignFormat::TMP_LEFT_CONTACT] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺咨询'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_setContact', array('model' => $model, 'design' => $design), false, true);
    }

    /**
     * 店铺自定义商品列表
     * @param $id design id
     * @param $key DesignFormat $TemplateList key下标
     */
    public function actionGoodsFilter($id, $key)
    {
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        //店铺分类
        $category = Scategory::model()->findAllByAttributes(array(
            'store_id' => $this->storeId,
            'parent_id' => 0,
            'status' => Scategory::STATUS_USING));
        if (!empty($_POST)) {
            $jsonData = $tmpData[$key];
            $jsonData['TypeTitle'] = $this->getPost('TypeTitle');
            $jsonData['TypeChildTitle'] = $this->getPost('TypeChildTitle');
            $jsonData['Keywords'] = $this->getPost('Keywords');
            $jsonData['CatId'] = $this->getPost('CatId');
            $jsonData['MinMoney'] = $this->getPost('MinMoney');
            $jsonData['MaxMoney'] = $this->getPost('MaxMoney');
            $jsonData['ProCount'] = $this->getPost('ProCount');
            $jsonData['OrderMode'] = $this->getPost('OrderMode');
            $tmpData[$key] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置自定义商品模板'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_goodsFilter', array(
            'model' => $model,
            'tmpData' => $tmpData[$key],
            'category' => $category
        ), false, true);
    }

    /**
     * 帮助
     */
    public function actionHelp()
    {
        $this->renderPartial('_help',null,false,true);
    }

    /**
     * 申请
     * @param $id 店铺装修id
     */
    public function actionChangeStatus($id){
        /** @var $model Design */
        $model = $this->loadModel($id);
        if($this->getParam('status')==Design::STATUS_EDITING){
            $model->status = Design::STATUS_AUDITING; //申请审核
            SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺装修申请审核'));
        }elseif($model->status==Design::STATUS_AUDITING && $this->getParam('status')==Design::STATUS_AUDITING){
            $model->status = Design::STATUS_EDITING;  //取消申请
            SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺装修取消申请'));
        }elseif($model->status==Design::STATUS_NOT_PASS && $this->getParam('status')==Design::STATUS_NOT_PASS){
            $model->status = Design::STATUS_EDITING;  //编辑
            SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺装修编辑'));
        }

        if($model->save()){
            $this->setFlash('design_status',$model->status);
            $this->redirect(array('index'));
        }
    }

    /**
     * 还原默认
     */
    public function actionReBack($id){
        $model = $this->loadModel($id);
        $design = new DesignFormat();
//        $currentUse = Design::model()->findByAttributes(array('store_id'=>$this->storeId,'status'=>Design::STATUS_PASS));
//        if($currentUse){
//            $model->data = $currentUse->data;
//        }else{
//            $model->data = $design->getJson();
//        }
        $model->data = $design->getJson();
        if($model->save()){
            $this->setFlash('design_back',Yii::t('sellerDesign','店铺装修还原成功'));
            SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置店铺装修还原'));
            $this->redirect(array('index'));
        }
    }

    /**
     * 装修实体店
     */
    public function actionStore()
    {
        $this->pageTitle = Yii::t('sellerDesign','实体店_').$this->pageTitle;
        $this->layout = 'design';
        $this->currentDesign = $this->_getCurrentDesign();
        $design = new DesignFormat($this->currentDesign->data);
        $this->store = Store::model()->findByPk($this->storeId);
        $this->render('store',array('design'=>$design));
    }

    /**
     * 实体店介绍
     */
    public function actionStoreInfo($id){
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if(isset($_POST['synopsis'])){
            $tmpData[DesignFormat::TMP_STORE_SYNOPSIS]['synopsis'] = $this->getPost('synopsis');
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置实体店介绍'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_storeInfo',array('tmpData'=>$tmpData[DesignFormat::TMP_STORE_SYNOPSIS]),false,true);
    }

    /**
     * 实体店图片展示
     */
    public function actionStoreSlide($id){
        SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置实体店图片展示'));
        $this->_slide($id,DesignFormat::TMP_STORE_SLIDE,'_storeSlide');
    }

    /**
     * 实体店联系方式
     */
    public function actionStoreContact($id){
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if(!empty($_POST)){
            $prefix = $this->getPost('Prefix');
            $contactNum = $this->getParam('ContactNum');
            $emailList = $this->getPost('emailList');
            $phoneName = $this->getPost('phoneName');
            $phoneNum = $this->getPost('phoneNum');
            $jsonData1 = array();
            $jsonData2 = array();
            //qq联系
            if(!empty($prefix)){
                for ($i = 0; $i < count($prefix); $i++) {
                    $jsonData1[] = array(
                        'ContactNum' => $contactNum[$i],
                        'ContactPrefix' => $prefix[$i],
                    );
                }
                $tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerTitle'] = $this->getPost('CustomerTitle');
                $tmpData[DesignFormat::TMP_LEFT_CONTACT]['CustomerData'] = $jsonData1;
            }
            $jsonData2['CustomerEmail'] = $emailList;
            //联系电话
            if(!empty($phoneName)){
                for ($i = 0; $i < count($phoneName); $i++) {
                    $jsonData2['CustomerPhone'][] = array(
                        'ContactName' => $phoneName[$i],
                        'ContactNum' => $phoneNum[$i],
                    );
                }
            }
            $jsonData2['CountryId'] = $this->getPost('CountryId');
            $jsonData2['ProvinceId'] = $this->getPost('ProvinceId');
            $jsonData2['CityId'] = $this->getPost('CityId');
            $jsonData2['DistrictId'] = $this->getPost('DistrictId');
            $jsonData2['ZipCode'] = $this->getPost('ZipCode');
            $jsonData2['Street'] = $this->getPost('Street');
            $tmpData[DesignFormat::TMP_STORE_CONTACT] = $jsonData2;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置实体店联系方式'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_storeContact',array('model' => $model, 'design' => $design), false, true);
    }



    /**
     * 实体店地图
     * @param $id
     */
    public function actionStoreMap($id){
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if(!empty($_POST)){
            $tmpData[$design::TMP_STORE_MAP] = array(
                'Label' => $this->getPost('Label'),
                'POS_X' => $this->getPost('POS_X'),
                'POS_Y' => $this->getPost('POS_Y'),
            );
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if($model->save()){
                SellerLog::create(SellerLog::CAT_COMPANY,SellerLog::logTypeUpdate,$id,Yii::t('sellerDesign','设置实体店地图'));
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_storeMap',array('model'=>$model,'tmpData'=>$tmpData[$design::TMP_STORE_MAP]),false,true);
    }

    /**
     * 地图坐标选择
     */
    public function actionMapSelect(){
        $this->renderPartial('_mapSelect',null,false,true);
    }

    /**
     * 幻灯片公共方法
     * @param $id 模板id
     * @param $key 模板key
     * @param $view 视图文件
     */
    private function _slide($id,$key,$view){
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if (!empty($_POST)) {
            $imgUrl = $this->getPost('ImgUrl');
            $title = $this->getPost('Title');
            $link = $this->getPost('Link');
            $jsonData = array();
            if (!empty($imgUrl)) {
                for ($i = 0; $i < count($imgUrl); $i++) {
                    $jsonData['Imgs'][] = array(
                        'ImgUrl' => $imgUrl[$i],
                        'Title' => $title[$i],
                        'Link' => $link[$i],
                    );
                }
            } else {
                $jsonData = '';
                //删除图片
            }
            $tmpData[$key] = $jsonData;
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if ($model->save()) {
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial($view, array('model' => $model, 'design' => $design), false, true);
    }

    /**
     * 自定义区域编辑
     * @param $id
     * @throws CException
     * @throws CHttpException
     */
    public function actionSetDiy($id){
        $model = $this->loadModel($id);
        $design = new DesignFormat($model->data);
        $tmpData = $design->tmpData;
        if(isset($_POST['content'])){
            $filter = new CHtmlPurifier();
            $tmpData[DesignFormat::TMP_MAIN_diy] = $filter->purify($_POST['content']);
            $design->tmpData = $tmpData;
            $model->data = $design->getJson();
            if($model->save()){
                echo '<script> var success = true; </script>';
            }
        }
        $this->renderPartial('_diy',array('data'=>$tmpData[DesignFormat::TMP_MAIN_diy]),false,true);
    }

}