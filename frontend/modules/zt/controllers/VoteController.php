<?php

/**
 * 军旅专题投票
 * @author qinbao.deng  <179266573@qq.com>
 */
class VoteController extends Controller
{

    //活动开始结束时间
    protected $_activeTime = array(
        'startTime' => '2016-05-19 00:00:00', //活动开始时间 格式: 2016-05-17 00:00:00
        'endTime' => '2016-05-29 00:00:00', //活动结束时间 
    );
    //红包session key
    protected $key = 'redBag'; 
    /*
     * 军旅专题投票
     * var rs = new Array();
      rs[1] = '投票成功！';
      rs[2] = '不能重复投票同一个人！';
      rs[3] = '投票次数不能超过三次！';
      rs[4] = '请登录后再投票！';
      rs[5] = '投票失败！';
     *
     */

    public function actionVotes()
    {
        if ($this->getUser()->isGuest) {
            $msg = array('status' => 1, 'msg' => "请登录后再投票");
            exit(json_encode($msg));
        }
        $candidateId = $this->getParam('candidateId');
        $userId = $this->getUser()->id;
        if (empty($candidateId)) {
            $msg = array('status' => 5, 'msg' => '投票失败');
            exit(json_encode($msg));
        }

        //投票总数不能超过三次
        $voteCount = Vote::model()->countByAttributes(array('member_id' => $userId));
        if ($voteCount >= 3) {
            $msg = array('status' => 3, 'msg' => '投票总数不能超过三次');
            exit(json_encode($msg));
        }
        //不能重复投票同一个人
        $isVote = Vote::model()->findByAttributes(array('member_id' => $userId, 'candidate_id' => $candidateId));
        if ($isVote) {
            $msg = array('status' => 2, 'msg' => '不能重复投票同一个人');
            exit(json_encode($msg));
        }

        $model = new Vote;
        $model->member_id = $userId;
        $model->candidate_id = $candidateId;
        $model->created = time();
        if ($model->save()) {
            Vote::voteReward($userId);
            $msg = array('status' => 1, 'msg' => '投票成功');
            exit(json_encode($msg));
        } else {
            $msg = array('status' => 6, 'msg' => '投票失败');
            exit(json_encode($msg));
        }
    }

    /**
     * 青岛专题签到送红包 开始时间 2015-10-20 (包括) 结束时间 2015-11-20 (包括)
     *  
     */
    public function actionSignIn()
    {
        if ($this->isAjax()) {
            $error = true;
            if ($this->getUser()->isGuest) {
                $msg = Yii::t('vote', '请登录后再签到');
                exit(json_encode(array('error' => $error, 'msg' => $msg)));
            }
            //查看今天是否签到 和 是否在活动期间
            $userId = $this->getUser()->id;
            $time = time();
            $begintime = strtotime('20151010');
            $endtime = strtotime('20151121');
            if ($time < $begintime) {
                $msg = Yii::t('vote', '活动未开启');
                exit(json_encode(array('error' => $error, 'msg' => $msg)));
            }
            if ($time > $endtime) {
                $msg = Yii::t('vote', '活动已结束');
                exit(json_encode(array('error' => $error, 'msg' => $msg)));
            }
            $model = new Vote;
            $member = Vote::isSignIn($time, $userId);
            if ($member) {
                $msg = Yii::t('vote', '您今天已经签到');
                exit(json_encode(array('error' => $error, 'msg' => $msg)));
            }
            $model->member_id = $model->candidate_id = $userId;
            $model->type = Vote::TYPE_SIGN;
            $model->created = $time;
            if ($model->save()) {
                Vote::signReword($userId);
                $msg = '签到成功';
                exit(json_encode(array('error' => false, 'msg' => $msg)));
            } else {
                $msg = '签到失败';
                exit(json_encode(array('error' => $error, 'msg' => $msg)));
            }
        }
        throw new CHttpException('404', Yii::t('vote', '该页面不存在'));
    }

    // 中奖比例：38元-520元，50%、20%、15%、10%、5%
    /**
     * 抽奖控制器
     */
    public function actionShopping()
    {
        $startTime = strtotime($this->_activeTime['startTime']); //开始时间戳
        $endTime = strtotime($this->_activeTime['endTime']); //结束时间戳
        $nowTime = time(); //当前时间
        //抽奖活动开始了吗
        if ($nowTime < $startTime) {
            $msg = array('status' => 0, 'msg' => '活动未开始');
            exit(json_decode($msg));
        }
        //抽奖活动结束了吗
        if ($nowTime > $endTime) {
            $msg = array('status' => 0, 'msg' => '活动已过期');
            exit(json_encode($msg));
        }

        //登录了吗
        if ($this->getUser()->isGuest) {
            $msg = array('status' => 0, 'msg' => '请登录后再投票','isLogin'=>1);
            exit(json_encode($msg));
        }
        $userId = $this->getUser()->id;

        $now = strtotime(date('Ymd', $nowTime));
        $rs = Yii::app()->db->createCommand()
                        ->select('member_id')
                        ->from('{{vote}}')
                        ->where('member_id = :mid and created > :beginTime and created <= :endTime', array(':mid' => $userId, ':beginTime' => $now, ':endTime' => $now + 86400))->queryColumn();
        if (!empty($rs)) {
            $msg = array('status' => 0, 'msg' => '你今天已抽奖');
            exit(json_encode($msg));
        }
        $session = Yii::app()->session;
        //默认38
        $type = isset($session[$this->key]['type']) ? $session[$this->key]['type'] : Activity::TPYE_LUCK_38;
        
        if(!Vote::elevenReward($userId, $type)){
            $model = new Vote;
            $model->member_id = $userId;
            $model->candidate_id = 0;
            $model->type = Vote::TYPE_LUCK;
            $model->created = time();
            $model->save();
            $session['isGet'] = 1;
            $result = array('status'=>1);
        } else {
            $result = array('status'=>0);
        }

        exit(json_encode($result)); //
    }

    //抽奖 转盘位置选择
    protected function _lotteryNumber($type)
    {
        $lottery = array(
            6 => array(0, 7), //38
            12 => array(5, 8), //68
            7 => array(3, 6), //88
            8 => array(1, 4), //188
            10 => array(2, 9) //520
        );
        $rotate = array(
            6 => array(18, 270), //38
            12 => array(198, 308), //68
            7 => array(126, 234), //88
            8 => array(54, 162), //188
            10 => array(90, 342) //520
        );
        $rand = mt_rand(0, 1);
        return array('angle' => $lottery[$type][$rand], 'rotate' => $rotate[$type][$rand]);
    }
    
    /**
     * 中西大厨PK专题投票
     */
    public function actionZxPkVotes()
    {
    	if ($this->getUser()->isGuest) {
    		$msg = array('status' => 2, 'msg' => "请登录后再投票");
    		exit(json_encode($msg));
    	}
    	
    	//查看今天是否签到 和 是否在活动期间
    	$userId = $this->getUser()->id;
    	$time = time();
    	$begintime = strtotime('20160830');
    	$endtime = strtotime('20160914');
    	if ($time < $begintime) {
    		$msg = Yii::t('vote', '活动未开启');
    		exit(json_encode(array('status' => 3, 'msg' => $msg)));
    	}
    	if ($time > $endtime) {
    		$msg = Yii::t('vote', '活动已结束');
    		exit(json_encode(array('status' => 3, 'msg' => $msg)));
    	}
    		
    	$candidateId = $this->getParam('candidateId');
    	$userId = $this->getUser()->id;
    	if (empty($candidateId)) {
    		$msg = array('status' => 3, 'msg' => '投票失败');
    		exit(json_encode($msg));
    	}
    	//不能重复投票
    	$isVote = Vote::model()->findByAttributes(array('member_id' => $userId, 'type' => Vote::TYPE_ZXPK_VOTE));
    	if ($isVote) {
    		$msg = array('status' => 3, 'msg' => '抱歉，您已投过票！');
    		exit(json_encode($msg));
    	}

    	$model = new Vote;
    	$model->member_id = $userId;
    	$model->type = Vote::TYPE_ZXPK_VOTE;
    	$model->candidate_id = $candidateId;
    	$model->created = time();
    	if ($model->save()) {
    		Vote::voteReward($userId);
    		$msg = array('status' => 1, 'msg' => '投票成功');
    		exit(json_encode($msg));
    	} else {
    		$msg = array('status' => 3, 'msg' => '投票失败');
    		exit(json_encode($msg));
    	}
    }
    
    

    /**
     * 获取中奖红包金额
     */
    public function actionRedBag()
    {   
        if(!$this->isAjax()) exit(json_encode(array('status'=>false,'msg'=>'无法获取红包')));
        
        $session = Yii::app()->session; //session
        $key = $this->key; //键值
        //只可以获取一次
        if(isset($session[$key]) && !empty($session[$key])){
            exit(json_encode(array('status'=>0,'angle' => $session[$key]['angle'], 'rotate' => $session[$key]['rotate'],'price'=>$session[$key]['price'] ,'isGet'=>$session['isGet']))); 
        }
        $result = Vote::luckDraw();
        $type = $result['type']; //获取红包金额类型
        
        $translate = $this->_lotteryNumber($result['type']);
        $session[$key] = array('type'=>$type,'angle'=>$translate['angle'],'rotate'=>$translate['rotate'],'price'=>$result['price']); //session 记录红包金额
        $session['isGet'] = 0;
        exit(json_encode(array('status' => 1, 'angle' => $translate['angle'], 'rotate' => $translate['rotate'],'price'=>$result['price'],'isGet'=>$session['isGet']))); //
    }
    
    /**
     * 双十一签到获取红包
     */
    public function actionDouble11(){
    	if ($this->isAjax()) {
    		$error = true;
    		if ($this->getUser()->isGuest) {
    			$msg = Yii::t('vote', '请登录后再签到');
    			exit(json_encode(array('error' => $error, 'msg' => $msg)));
    		}
    		//查看今天是否签到 和 是否在活动期间
    		$userId = $this->getUser()->id;
    		$time = time();
    		$begintime = strtotime('20161020');
    		$endtime = strtotime('20161113');
    		if ($time < $begintime) {
    			$msg = Yii::t('vote', '活动未开启');
    			exit(json_encode(array('error' => $error, 'msg' => $msg)));
    		}
    		if ($time > $endtime) {
    			$msg = Yii::t('vote', '活动已结束');
    			exit(json_encode(array('error' => $error, 'msg' => $msg)));
    		}
    		$model = new Vote;
    		$member = Vote::isSignIn($time, $userId);
    		if ($member) {
    			$msg = Yii::t('vote', '您今天已经签到');
    			exit(json_encode(array('error' => $error, 'msg' => $msg)));
    		}
    		$model->member_id = $model->candidate_id = $userId;
    		$model->type = Vote::TYPE_SIGN;
    		$model->created = $time;
    		if ($model->save()) {
    			Vote::signReword($userId);
    			$msg = '签到成功,并获得20元红包！';
    			exit(json_encode(array('error' => false, 'msg' => $msg)));
    		} else {
    			$msg = '签到失败';
    			exit(json_encode(array('error' => $error, 'msg' => $msg)));
    		}
    	}
    	throw new CHttpException('404', Yii::t('vote', '该页面不存在'));
    }
    
    /**
     * 双十一对商品进行投票
     */
    public function actionDouble11Vote(){
    	if ($this->getUser()->isGuest) {
    		$msg = array('status' => 2, 'msg' => "请登录后再投票");
    		exit(json_encode($msg));
    	}
    	 
    	//查看今天是否签到 和 是否在活动期间
    	$userId = $this->getUser()->id;
    	$time = time();
    	$begintime = strtotime('20161020');
    	$endtime = strtotime('20161113');
    	if ($time < $begintime) {
    		$msg = Yii::t('vote', '活动未开启');
    		exit(json_encode(array('status' => 3, 'msg' => $msg)));
    	}
    	if ($time > $endtime) {
    		$msg = Yii::t('vote', '活动已结束');
    		exit(json_encode(array('status' => 3, 'msg' => $msg)));
    	}
    	
    	$voteType = $this->getParam('voteType');
    	$userId = $this->getUser()->id;
    	if (empty($voteType)) {
    		$msg = array('status' => 3, 'msg' => '投票失败');
    		exit(json_encode($msg));
    	}
    	//不能重复投票
    	$isVote = Vote::model()->findByAttributes(array('member_id' => $userId, 'type' => Vote::TYPE_FZ_VOTE));
    	if ($isVote) {
    		$msg = array('status' => 3, 'msg' => '抱歉，您已投过票！');
    		exit(json_encode($msg));
    	}
    	
    	$model = new Vote;
    	$model->member_id = $userId;
    	$model->type = Vote::TYPE_FZ_VOTE;
    	$model->candidate_id = $voteType;
    	$model->created = time();
    	if ($model->save()) {
    		$msg = array('status' => 1, 'msg' => '投票成功');
    		exit(json_encode($msg));
    	} else {
    		$msg = array('status' => 3, 'msg' => '投票失败');
    		exit(json_encode($msg));
    	}
    }

}
