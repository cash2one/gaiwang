<?php

/**
 * 商品详情控制器
 * @author binbin.liao  <277250538@qq.com>
 */
class GoodsController extends Controller {

    public $layout = 'store';
    public $defaultAction = 'view';
    public $store;
    // 商品数据
    public $goods;
    // 商品ID
    private $_goodsId;
    //店铺装修
    public $design;
	//猜你喜欢条数
	public $youlike = 5;
	//是否收藏了店铺
	public $storeCollect = 0;
    //是否收藏了商品
	public $goodCollect = 0;
	
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
        );
    }

    /**
     * 在行为之前的操作
     * 获取产品ID
     * 获取商家信息
     */
    public function beforeAction($action) {
        if ($action->id == 'captcha')
            return parent::beforeAction($action);
        if ($this->getParam('skip')) {
            return parent::beforeAction($action);
        }
        // 检查是否有该商品存在
        $g = WebGoodsData::checkGoodsStatus($this->getParam('id'));//调用接口
        if (empty($g))
            throw new CHttpException(404, Yii::t('goods', '没有找到相关商品！'));
        if (!$this->getParam('preview')) {
			
			if(isset(Yii::app()->theme->baseUrl) && Yii::app()->theme->baseUrl == '/themes/v2.0'){//V2.0版本下架条件个改为: 商品审核中 审核不通过 审核通过但未发布
                if($g['life'] == Goods::LIFE_YES){
					throw new CHttpException(404, Yii::t('goods', '很抱歉，您查看的商品不存在，或者已被转移！'));
				}
			}else{
			    if ($g['status'] != Goods::STATUS_PASS || $g['is_publish'] == Goods::PUBLISH_NO || $g['life'] == Goods::LIFE_YES) {
					throw new CHttpException(404, Yii::t('goods', '很抱歉，您查看的商品不存在，可能已下架或者被转移！'));
				}	
			}
			
        } else {
            if ($this->getSession('storeId') != $g['store_id']) {
                throw new CHttpException(403, Yii::t('goods', '只能登录后审核自己店铺的商品！'));
            }
        }
        $this->goods = $g;
        $this->_goodsId = $g['id'];
        if (!$this->isAjax()) {
            $this->store = WebGoodsData::getStoreData($g['store_id']);//调用接口
            if (empty($this->store)) {
                throw new CHttpException(404, Yii::t('goods', '没有找到相应的店铺信息！'));
            }
        }
        
		$this->storeCollect = WebGoodsData::getCollects($g['store_id'], 1);
		$this->goodCollect  = WebGoodsData::getCollects($g['id'], 2);
        $site_config = $this->getConfig('site');
        $this->pageTitle = $site_config['name'];   //设置默认标题，去掉控制器名
        return parent::beforeAction($action);
    }
	
	public function actionGetGoodsx(){
        $goodsId = $this->getParam('id');
        $goodsData = ActivityData::getGoodsCache($goodsId);

        echo $this->renderPartial('_activity', array(
            'goods' =>  $goodsData['goods'],
            'goodsSpec'=> $goodsData['goodsSpec'],
            'activityInfo'=> ActivityData::getGoodsInfo($goodsData['goods']['id'],$goodsData['goods']['seckill_seting_id'])
        )); //商品信息

    }
	
	/*商城V2.0改版 不能用原来的函数,公用不了*/
	public function actionGetGoodsv(){
        $goodsId   = $this->getParam('id');
        $goodsData = ActivityData::getGoodsCache($goodsId);
        
		//缓存店铺的商品,随机抽取三条做推荐
		//$randRecord = Goods::getGoodsRecommend($goodsData['goods']['category_id']);
        $randRecord = Goods::getRandRecord(3);
		
        echo $this->renderPartial('_activity', array(
            'goods' =>  $goodsData['goods'],
			'randRecord' => $randRecord,
            'goodsSpec'=> $goodsData['goodsSpec'],
            'activityInfo'=> ActivityData::getGoodsInfo($goodsData['goods']['id'],$goodsData['goods']['seckill_seting_id'],1)
        )); //商品信息

    }
	
	//商品详情页的猜你喜欢模块
	public function actionGetYouLike(){
        /*
		$goodsId = $this->getParam('id');
		$isFlash = $this->getParam('flash');
		$userId  = Yii::app()->user->id;
		
		$collection = array();
		if($isFlash > 0){//点击了换一批按钮
		    for($i=0; $i<$this->youlike; $i++){
				$row = Goods::getRandRecord();
				array_push($collection, $row);	
			}
		}else{//默认显示
			//从收藏的商品中取5条出来显示
		    $collection = Goods::getGuessYouLikeGoods($userId, $this->youlike);

			$count      = count($collection);
			if($count < $this->youlike){//小于5件的时候,随机补充其它商品
				$rand = $this->youlike - $count;
				for($i=0; $i<$rand; $i++){
					$row = Goods::getRandRecord();
				    array_push($collection, $row);	
				}
			}
		}
		*/
        $collection = Goods::getRandRecord($this->youlike);
		$html = '';
		foreach($collection as $v){			
            $html .= '<li>'.CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_110,w_110'), $v['name'], array('width' => 110, 'height' => 110)), $this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])), array('class' => 'gr-list-img', 'title' => $v['name'])).
            '<span>'.HtmlHelper::formatPrice($v['price']).'</span>'.
            '<a href="'.$this->createAbsoluteUrl('/goods/view', array('id' => $v['id'])).'" title="'.$v['name'].'">'.Tool::truncateUtf8String($v['name'], 12).'</a></li>';
		}

		echo $html;
		/*echo $this->renderPartial('_youlike', array(
            'collection' =>  $collection
        ));*/
	}

    /**
     * 显示商品详情信息
     * 商品咨询， 商品评论 等 ajax 请求处理
     */
    public function actionView() {

        // 商品咨询
        $guestbook = new Guestbook('validationCode');
        $this->performAjaxValidation($guestbook);
        if (isset($_POST['Guestbook'])) {
            if (!$this->getUser()->id) {
                echo "<script>alert('".Yii::t('guestbook', '亲，登录以后才能咨询哦!')."')</script>";
            } else {
                $guestbook->attributes = $this->getPost('Guestbook');
                $guestbook->content = Tool::banwordReplace(CHtml::encode($guestbook->content));
                $guestbook->owner = Guestbook::OWNER_GOODS;
                $guestbook->owner_id = $this->_goodsId;
                $guestbook->description = str_replace(array('{0}', '{1}'), array(Yii::app()->user->getState('gw'), $_POST['Guestbook']['goodsName']), $guestbook->template);
                if ($guestbook->validate()) {
                    $dataArr = array();
                    foreach($guestbook->attributes as $key => $v){
                        $dataArr[$key] = $v;
                    }
//                    Tool::pr($dataArr);
                    $rs = WebGoodsData::saveConsultData($dataArr);//调用接口保存数据
                    if($rs){
                        echo "<script>alert('".Yii::t('guestbook', '咨询问题提交成功!')."')</script>";
                    }else{
                        echo "<script>alert('".Yii::t('guestbook', '咨询问题提交失败!')."')</script>";
                    }
                }
            }
        }
        // 商品数据
        $goods = $this->goods;
        //$this->pageTitle = $goods['name'] . '_' . $this->store['name'] . '_' . $this->pageTitle;
		$labels = isset($goods['labels']) && !empty($goods['labels']) ? explode(' ', $goods['labels']) : array();
        $this->pageTitle   = $goods['name'].' 【价格 参数 评测 图片】– 盖象商城';
		$this->keywords    = !empty($labels) ? join($labels, ',') : '盖象商城,优品汇,盖象活动,盖象特价,商城优惠活动,特价,促销,特卖,优惠,特价促销,促销活动,打折商品,每日特价,名品特卖,品牌折扣,限时抢购,打折信息';
		$this->description = '盖象商城（G-emall.com）提供'.(count($labels) >= 1 && isset($labels[0]) ? $labels[0] : '').'正品行货质量有保证，并且包括'.
            (count($labels) >= 1 && isset($labels[0]) ? $labels[0] : '').'网购指南，'.
            (count($labels) >= 2 && isset($labels[1]) ? $labels[1] : '').'价格、'.
            (count($labels) >= 3 && isset($labels[2]) ? $labels[2] : '').'参数、'.
            (count($labels) >= 4 && isset($labels[3]) ? $labels[3] : '').'评测、图片等信息，网购'.
            (count($labels) >= 1 && isset($labels[0]) ? $labels[0] : '').'上盖象商城，放心又轻松，价格便宜质量优！';

        //查看是否拍卖商品,如果是则直接跳转拍卖页
        $auction = Yii::app()->db->createCommand()
            ->select('goods_id,rules_setting_id')
            ->from('{{seckill_auction}}')
            ->where('goods_id = :gid', array(':gid' => $this->_goodsId))
            ->order('id DESC')
            ->limit(1)
            ->queryRow();
        $auctionCache = !empty($auction) ? AuctionData::getActivityAuction($auction['rules_setting_id']) : array();
        if ( !empty($auctionCache)){
            $rulesStatus = $auctionCache['status'];
            $rulesEnd    = strtotime($auctionCache['date_end'].' '.$auctionCache['end_time']);
            if($rulesStatus != AuctionData::AUCTION_ACTIVE_STATUS_ONE && $rulesEnd > time()){
                $this->redirect( $this->createUrl('/active/auction/detail', array('setting_id'=>$auction['rules_setting_id'], 'goods_id'=>$auction['goods_id'])));
            }
        }

        // 商品组图数据
        $gallery = Yii::app()->db->createCommand()->from('{{goods_picture}}')->where('goods_id = :gid', array(':gid' => $this->_goodsId))->queryAll();
        // 商家店铺装修
        $design = WebGoodsData::storeDesignData($goods['store_id']);//调用接口
        $this->design = $design;
        if ($design) {
            if (empty($design)) {
                $data = '';
            } else {
                $data = $design['data'];
            }
            $this->design = new DesignFormat($data);
            $arr = CJSON::decode($design['data']);
            $design = Tool::array_2get($arr['TemplateList'], 'Code', '_left_Contact_1');
            $design = CJSON::decode($design['JsonData']);  //qq在线客服
        } else {
            $this->design = new DesignFormat();
        }

        // 根据当前的商品查找规格值.为js生成数据准备
//        $goodsSpec = GoodsSpec::getGoodsSpec($this->_goodsId);
        // 记录浏览历史
        $this->_setBrowseHistory();
        // 获取成交记录，暂时不显示
//        $completes = OrderGoods::getCompletes($this->_goodsId);
        /**
        不生成静态文件
        $curLanguage = Yii::app()->language;//初始语言
        $language = array(
            'zh_cn' => 'index.html',
            'zh_tw' => 'tw.html',
            'en' => 'en.html',
        );
        $dir = Yii::getPathOfAlias('webroot');
        Tool::createDir('JF'.DS.$this->_goodsId); //生成目录
        foreach($language as $key => $v){
            Yii::app()->language = $key;
            $file = $dir.DS.'JF'.DS.$this->_goodsId.DS.$v;
            $data = $this->render('view', array(
                'goods' => $goods,
//                'goodsSpec' => $goodsSpec,
                'gallery' => $gallery,
//                'completes' => $completes,
                'design' => $design,
                'guestbook' => $guestbook,
            ),true);
            $ftp = fopen($file,'w');
            fwrite($ftp,$data);
            fclose($ftp);
        }
        Yii::app()->language = $curLanguage;
         */

            $this->render('view', array(
                'goods' => $goods,
//                'goodsSpec' => $goodsSpec,
               'gallery' => $gallery,
//               'completes' => $completes,
                'design' => $design,
                'guestbook' => $guestbook,
            ));
    }

    /**
     * 这是商品浏览历史cookie
     */
    private function _setBrowseHistory() {
        $history = $this->getCookie('history');
        if (empty($history))
            $this->setCookie('history', $this->_goodsId, 3600 * 24 * 365);
        else {
            $array = explode(',', $history);
            if (!in_array($this->_goodsId, $array)) {
                if (count($array) > HISTORY_NUM)
                    unset($array[0]);
                array_push($array, $this->_goodsId);
                $this->setCookie('history', implode(',', array_filter($array)), 3600 * 24 * 365);
            }
        }
    }

    /**
     * 获取商品咨询
     * @return CActiveDataProvider
     */
    protected function _getGuestBooks() {
        $criteria = new CDbCriteria;
        $criteria->select = "t.content,t.create_time,t.reply_content,t.reply_time,member.gai_number";
        $criteria->condition = 't.status = :status And t.owner_id = :gid';
        $criteria->order = 't.create_time DESC';
        $criteria->params = array(':status' => Guestbook::STATUS_PASS_CONFIRM, ':gid' => $this->_goodsId);
        $criteria->with = array('member' => array('select' => 'gai_number'));
        return new CActiveDataProvider('Guestbook', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    /**
     * 获取评价
     * @return CActiveDataProvider
     */
    private function _getComments() {
        $criteria = new CDbCriteria;
        $criteria->select = "t.id,t.content,t.create_time,t.reply_content,t.reply_time,t.score,t.spec_value";
        $criteria->condition = 't.status = :status And t.goods_id = :gid';
        $criteria->order = 't.create_time DESC';
        $criteria->params = array(':status' => Comment::STATUS_SHOW, ':gid' => $this->_goodsId);
        $criteria->with = array(
            'member' => array(
                'select' => 'member.head_portrait, member.gai_number'
            ),
        );
        return new CActiveDataProvider('Comment', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    /**
     * ajax 计算运费
     */
    public function actionComputeFreight() {
        if ($this->isAjax()) {
            $city_id = $this->getPost('city_id');
            $province_id = $this->getPost('province_id');
            $city_name = $this->getPost('city_name');
            $province_name = $this->getPost('province_name');
            $quantity = $this->getPost('quantity');
            //设置访客位置cookie
            $position = array(
                'city_id' => $city_id,
                'city_name' => $city_name,
                'province_id' => $province_id,
                'province_name' => $province_name,
            );
            $cookie = new CHttpCookie('position', $position);
            $cookie->expire = time() + 3600 * 24 * 360;
            Yii::app()->request->cookies['position'] = $cookie;
            $goods = $this->goods;
            //计算运费
            $fee = ComputeFreight::compute($goods['freight_template_id'], $goods['size'], $goods['weight'], $city_id, $goods['valuation_type'], $quantity);
            foreach ($fee as $k => &$v) {
                if($k>1) unset($fee[$k]);
                $v['fee'] = Common::rateConvert($v['fee']);
            }
            echo CJSON::encode($fee);
        }
    }

    /**
     * 片段缓存
     * @param string $name
     * @return bool
     */
    protected function _beginCache($name) {
        Tool::cache('goods'); //设置缓存目录
        $id = $this->_goodsId . $name;
        $params = array('duration' => Yii::app()->params['cache']['GoodsCache'], 'cacheID' => 'fileCache');
        return $this->beginCache($id, $params);
    }
	
	/**
	* 买家印象
	* @param integer $goodsId 商品ID
	* return string 返回印象标签
	*/
	public function actionBuyesImpression(){
		$userId  = Yii::app()->user->id;
		$goodsId = intval($this->getParam('id'));
		
		$content   = '<b>'.Yii::t('goods','该商品暂未有任何印象标签~').'</b>';
		if($goodsId < 1){ echo $content; exit;}
		$cacheName = 'impress_'.$goodsId;
		$config    = Tool::cache($cacheName)->get($cacheName);
		if($config == false || $config == true){
		    $result = Yii::app()->db->createCommand()
		              ->select('impress_id')
					  ->from('{{comment}}')
					  ->where("goods_id = :goodsId and impress_id!='' and status=1 ", array(':goodsId' => $goodsId))
					  ->group('impress_id')
					  ->queryAll();	
			if(!empty($result)){
				Tool::cache($cacheName)->set($cacheName, serialize($result), 3600);
			}
		}else{
			$result = unserialize($config);
		}
		
		$html = '';
		if(!empty($result)){
			$impress = Comment::getImpress();
			foreach($result as $v){
				$class = $impress[$v['impress_id']]['type'] == 1 ? '' : 'class="pdTab2-font1"';
				$html .= "<li $class>".$impress[$v['impress_id']]['name'].'</li>';
			}
			
		}else{
		    $html = $content;
		}
		echo $html; exit;		
	}
	
}
