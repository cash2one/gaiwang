<?php

/**
 * 产品页控制器
 * @author jianlin.lin <hayeslam@163.com>
 */
class ProductController extends Controller {

    public $layout = 'store';
	public $store;
	public $design;

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

    public function actionIndex() {
        $this->render('index');
    }
    
    /**
     * 获取库存、评分、热门搜索信息
     */
    public function actionStockScore(){
        $goodId = $this->getParam('goodId');
        $storeId = $this->getParam('storeId');
        $dataArray = WebGoodsData::getEvaluationData($goodId, $storeId);
        $dataArray['globalkeywords'] = '';
        if(!empty($this->globalkeywords)){
            foreach($this->globalkeywords as $k=> $val){
                if($k>6) break;
                $dataArray['globalkeywords'] .= "<li>".CHtml::link(Tool::truncateUtf8String(Yii::t('site', $val),9), array('/search/search', 'q' => $val,'target'=>'_blank'))."</li>";
            }
        }
        exit( CJSON::encode($dataArray));
    }

    /*
     * 获取产品浏览记录每浏览一次记录到memcache,每7次写入一次数据库
     */
    public function actionView(){
        $goodsId = $this->getParam('id');
        $views = Tool::cache($goodsId . 'goods')->get($goodsId . 'goods') ? Tool::cache($goodsId . 'goods')->get($goodsId . 'goods') : 0;
        $views = $views + 1;
        Tool::cache($goodsId . 'goods')->set($goodsId . 'goods', $views);
        if ($views == 7) {
            $rs = Yii::app()->db->createCommand()->select('views')->from('{{goods}}')->where('id=:id',array(':id'=>$goodsId))->queryRow();
            if(!empty($rs)){
                $views = $rs['views'] + $views;
                Goods::model()->updateByPk($goodsId, array('views' => $views));
                Tool::cache($goodsId . 'goods')->set($goodsId . 'goods', 0);
            }
        }
    }

    /*
     * 商品咨询列表，用于产品详情静态页
     */
    public function actionGuestList(){
        $id = $this->getParam('id');
        $guestBooks = Goods::ArrDataProvider(WebGoodsData::getConsultData($id),5);
        $this->renderPartial('_guestbooks', array('dataProvider' => $guestBooks),false,true);
    }

    /*
     * 商品评论列表，用于产品详情静态页
     */
    public function actionCommentList(){
        $id   = $this->getParam('id');
        $comments = Goods::ArrDataProvider(WebGoodsData::getCommentList($id),5);
        $this->renderPartial('_comments', array('dataProvider' => $comments),false,true);
    }
	
    /*
     * 商品评论列表，用于产品详情静态页 V2.0
     */
    public function actionCommentListNew(){
        $id   = $this->getParam('id');
		$vote = $this->getParam('vote');
		$time = $this->getParam('time');
        $comments = Goods::ArrDataProvider(WebGoodsData::getCommentListNew($id,1,$vote,$time),10);
        $this->renderPartial('_comments', array('dataProvider' => $comments),false,true);
    }
	
    /*
     * 商品评论列表，用于产品详情静态页(有图片的评论) V2.0
     */
    public function actionImgCommentListNew(){
        $id  = $this->getParam('id');
		$vote = $this->getParam('vote');
		$time = $this->getParam('time');
        $comments = Goods::ArrDataProvider(WebGoodsData::getCommentListNew($id,2,$vote,$time),10);
        $this->renderPartial('_imgcomments', array('dataProvider' => $comments),false,true);
    }

    /*
     * 店铺分类，用于产品详情静态页
     */
    public function actionCategory(){
        $storeId = $this->getParam('id');
        $data = Scategory::scategoryInfo($storeId);
        $this->renderPartial('_storecategory',array('data'=>$data,'storeId'=>$storeId));
    }

    /*
     * 火热销量，用于产品详情静态页
     */
    public function actionHotSales(){
        $storeId = $this->getParam('id');
        $sales = Goods::hotSales($storeId, 6);
        $this->renderPartial('_hotsales', array('sales' => $sales)); //热门销售
    }
	
	/**
	* 新品推荐, 用于产品详情页
	*/
	public function actionNewGoods(){
	    $storeId  = $this->getParam('id');
		$newGoods = Goods::NewGoods($storeId, 5);
		$this->renderPartial('_newgoods', array('newGoods' => $newGoods)); //热门销售	
	}

    /*
     * 咨询提交，用于产品详情静态页
     */
    public function actionGuest(){
        $this->layout = false;
        $guestbook = new Guestbook('validationCode');
        $goodsId = $this->getParam('id');
        $goodsName = $this->getParam('goodsName');
        $this->performAjaxValidation($guestbook);

        if (isset($_POST['Guestbook'])) {
            if (!$this->getUser()->id) {
                echo "<script>alert('".Yii::t('guestbook', '亲，登录以后才能咨询哦!')."')</script>";
            } else {
                $guestbook->attributes = $this->getPost('Guestbook');
                $guestbook->content = Tool::banwordReplace(CHtml::encode($guestbook->content));
                $guestbook->owner = Guestbook::OWNER_GOODS;
                $guestbook->owner_id = $goodsId;
                $guestbook->description = str_replace(array('{0}', '{1}'), array(Yii::app()->user->getState('gw'), $goodsName), $guestbook->template);
                if ($guestbook->validate()) {
                    $dataArr = array();
                    foreach($guestbook->attributes as $key => $v){
                        $dataArr[$key] = $v;
                    }
//                    Tool::pr($dataArr);
                    $rs = WebGoodsData::saveConsultData($dataArr);//调用接口保存数据
                    $guestbook->unsetAttributes();
                    $guestbook->verifyCode = null;
                    if($rs){
                        echo "<script>alert('".Yii::t('guestbook', '咨询问题提交成功!')."')</script>";
                    }else{
                        echo "<script>alert('".Yii::t('guestbook', '咨询问题提交失败!')."')</script>";
                    }
                }
            }
        }

        $this->render('_guest',array('guestbook'=>$guestbook));
    }
	
	/**
	* 用户点赞
	* @param integer $val 传递的产品ID和评论ID
	*/
	public function actionUserVote(){
	    $val     = $this->getParam('val');	
		$goodsId = $commentId = 0;
		$userId  = Yii::app()->user->id;
		
		list($commentId, $goodsId) = explode('|', $val);
		$data = array('success'=>false, 'msg'=>Yii::t('goods', '点赞失败!'));
		if($commentId<1 || $goodsId<1){
			echo json_encode($data);
		    exit;
		}
		
		if(!$userId){
			$data['msg'] = Yii::t('goods', '请选登录再进行操作!');
			echo json_encode($data);
		    exit;
		}
		
		//查看是否点过赞
		$result = Yii::app()->db->createCommand()
				  ->select('id')
				  ->from('{{comment_vote}}')
				  ->where('goods_id=:gid AND comment_id=:cid AND user_id=:uid', array(':gid'=>$goodsId, ':cid'=>$commentId, ':uid'=>$userId))
				  ->queryScalar();
		if($result){
			$data['msg'] = Yii::t('goods', '一个评价只能点赞一次!');
			echo json_encode($data);
		    exit;
		}
		
		$sql  = "UPDATE {{comment}} SET vote=vote+1 WHERE id=:id AND goods_id=:gid";
        if(Yii::app()->db->createCommand($sql)->bindValues(array(":id"=>$commentId,":gid"=>$goodsId))->execute()){
			//$sql = "INSERT INTO {{comment_vote}} (`goods_id`,`comment_id`,`user_id`,`dateline`) VALUES ('".intval($goodsId)."','".intval($commentId)."','$userId','$time')";
			//Yii::app()->db->createCommand($sql)->execute();
			Yii::app()->db->createCommand()->insert('{{comment_vote}}', array(
				'goods_id' => $goodsId,
				'comment_id' => $commentId,
				'user_id' => $userId,
				'dateline' => time()
           ));
		}
		
		$data['success'] = true;
		$data['msg']     = Yii::t('goods', '点赞成功!');;
		echo json_encode($data);
		exit;
	}

    /*
     * 维权，用于产品详情静态页
     */
    public function actionAdults(){
        $this->renderPartial('_adults');
    }
}