<?php

/**
 * 商品评分控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class CommentController extends MController
{

    public function actionIndex()
    {
        $model = new Comment('searchList');
        $model->unsetAttributes();
        if (isset($_GET['Comment']))
            $model->attributes = $this->getQuery('Comment');

        $comments = $model->searchList();

        $this->render('index', array(
            'comments' => $comments,
            'model' => $model
        ));
    }

    /**
     * 店铺评价,以及此店铺下的商品评价
     */
    public function actionEvaluate($code)
    {
        //$ftp = Yii::app()->ftp;
        //var_dump($ftp);
        /** @var Comment $model */
        /** @var Order $orderModel */
        /** @var Store $storeModel */
        extract($this->getOrderGoods($code));
        
        $storeCommentModel->setScenario('comment');
        //防止重复提交
        $this->checkPostRequest();
        //验证订单评论有效性
        $checkRes=$this->_check($orderModel);
        if(!$checkRes['flag']){
        	$this->setFlash('success', Yii::t('memberComment', $checkRes['msg']));
        	$this->redirect(array('order/admin'));
        }else{
         $order = $orderModel->attributes;
         $post = Yii::app()->request->getPost('Comment');
        //var_dump($post);
        //exit;
         if (!empty($post)) {
            $valid = true;
            $models = array();
            $impress_id = $post['impress_id'];
            $is_anonymity = isset($post['is_anonymity']) ? $post['is_anonymity'] : 0;
            unset($post['is_anonymity']);
            unset($post['impress_id']);
            foreach ($post as  $comment) {
                if (!empty($comment['content'])) {
                    $comment['content'] = Tool::banwordReplace(CHtml::encode($comment['content']));
                }  //评论过滤
                if (isset($comment)) {
                    //组装各个评论模型
//                    $m = new Comment; 
                    $model = clone $model;
                    $model->attributes = $comment;
                    $model->order_id = $order['id'];
                    $model->store_id = $order['store_id'];
                    $model->member_id = $order['member_id'];
                    $model->create_time = time();
                    $model->status = Comment::STATUS_SHOW;
                    $model->impress_id = $impress_id;
                    $model->is_anonymity = $is_anonymity;
                    if(isset($comment['img_path'])){
                        $model->img_path = implode('|', $comment['img_path']);
                    }
                    $model->spec_value = Tool::authcode($model->spec_value, 'DECODE');
//                    $model->impress_id = Yii::app()->request->getPost('impress_id');
                    /*comment检测评论内容*/
                    $valid = $model->validate(array('content', 'score')) && $valid;
                    $models[] = $model;
                }
            }
            
            $storeCommentModel->attributes = Yii::app()->request->getPost('StoreComment');
            $valid = $storeCommentModel->validate(array('description_match', 'serivice_attitude', 'speed_of_delivery')) && $valid;

            // 商家评论 修改商家数据结构
            $storeCommentModel->store_id = $orderModel->store_id;
            $storeCommentModel->order_id = $orderModel->id;

            if ($valid) {
                //计算待返还金额
                /*
                 * 当会员从普通会员变为正式会员，这种计算方法有误
                $inCome = OnlineCalculate::orderIncome($order, $orderGoods);
                $return = OnlineCalculate::memberAssign($inCome['surplusAssign'], $member, $ratio['ratio'], $memberType);
                */
                $member = $this->model->attributes;
                $account = Yii::app()->ac->createCommand()
                    ->select('credit_amount')
                    ->from('gw_account_flow_'.date('Ym',$order['sign_time']))
                    ->where('account_id = :mid and order_id=:oid and node=:node')
                    ->bindValues(array(':mid'=>$member['id'],':oid'=>$order['id'],':node'=>AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REWARD))
                    ->queryScalar();
                $return['memberIncome'] = $account!==false ? $account : 0.00;

                //执行方法
                $msg = OnlineComment::operate($order, $member, $return, $storeCommentModel, $models);
                if ($msg['flag']) {
                    $this->setFlash('success', Yii::t('memberComment', $msg['info']));
                    $this->redirect(array('index'));
                } else {
                    $this->setFlash('error', Yii::t('memberComment', $msg['info']));
                    $this->redirect(array('index'));
                }
            }
          }
        }
        //与描述相符，
        $des_match = StoreComment::getDescriptionMatch($order['store_id'])->description_match;
        $model->impress_id = Comment::IMPRESS_NONE;
        $this->render('evaluate', array(
            'model' => $model,
            'orderModel' => $orderModel,
            'store' => $store,
            'storeComment'=>$storeCommentModel,
            'des_match' => $des_match
        ));
    }
    /**
     * 修改评论，评论只允许修改一次
     * @param int $code 订单号
     */
    public function actionEdit($code)
    {
        //根据订单ID查找评论
        $model = new Comment;
        $comment = $model->with(
                        array(
                            'orderGoods' => array(
                                'select' => 'goods_name,goods_picture,goods_id,spec_value,quantity,unit_price,gai_income,gai_price,original_price,ratio,activity_ratio',
                        ))
                    )
            ->findAll('t.order_id=:order_id AND is_edit=:edit',array(':order_id'=>$code,':edit'=> Comment::EDIT_FALSE));
        //根据订单号查找店铺评论
        $storeComment = StoreComment::model()->find('order_id=:order_id',array(':order_id'=>$code));
        //订单产品
        $orderModel = Order::model()->findByPk($code);
        if(empty($comment) || empty($storeComment)){
            $this->setFlash('error',  Yii::t('membercomment','该订单不允许修改'));
            $this->redirect(array('order/admin'));
        }
        $this->checkPostRequest();
        $post = Yii::app()->request->getPost('Comment');
        $storePost = Yii::app()->request->getPost('StoreComment');
        //此处修改评论
        if(!empty($post) && !empty($storeComment) ){
            $trans = Yii::app()->db->beginTransaction();
            try{
                $impress_id = $post['impress_id'];
                unset($post['impress_id']);
                $is_anonymity = isset($post['is_anonymity']) ? $post['is_anonymity'] : 0;
                unset($post['is_anonymity']);
                foreach($comment as $k=>$c){
                    $c->attributes = $post[$k];
                    $c->spec_value = Tool::authcode($post[$k]['spec_value'], 'DECODE');
                    $c->is_edit = Comment::EDIT_TRUE;
                    $c->impress_id = $impress_id;
                    $c->is_anonymity = $is_anonymity;
                    if(isset($post[$k]['img_path'])){
                        $c->img_path = implode('|', $post[$k]['img_path']);
                    }
                    $c->save();
                }
                $storeComment->attributes = $storePost;
                $storeComment->save();
                $trans->commit();
                $this->setFlash('success','修改评价成功');
                $this->redirect(array('order/admin'));
            } catch(Exception $e){
                $trans->rollback();
                $this->setFlash('error',  Yii::t('membercomment','修改失败'));
                $this->refresh();
            }
        }
        $des_match = StoreComment::getDescriptionMatch($orderModel->store_id)->description_match;
        $this->render('edit',array(
           'model' => $model,
           'storeComment' => $storeComment,
            'orderModel' => $orderModel,
            'comment'=>$comment,
            'des_match'=>$des_match
        ));
    }
    /**
     * 根据订单号获取该订单
     * @param int $code
     * @return array 
     */
    protected function getOrderGoods($code)
    {
        $model = array();
        $model['orderModel'] = Order::model()->with(
            array(
                'orderGoods' => array(
                    'select' => 'goods_name,goods_picture,goods_id,spec_value,quantity,unit_price,gai_income,gai_price,original_price,ratio,activity_ratio',
                )
            )
        )->find('code =:code ', array(':code' => $code));
        $model['storeCommentModel'] = new StoreComment;
        $model['model'] = new Comment;
        $model['store'] = new Store();
        return $model;
    }
    
    /**
     * ajax上传图片
     */
    public function actionUpload()
    {
        //$model = new Comment();
        $config = $this->getConfig('upload');
        //$model->img_path = $file;
        if($this->isAjax()){
            //判断图片是否符合上传
            $file = CUploadedFile::getInstanceByName('img_path');
            if($file->getError()) exit(json_encode (array('error'=>1)));
            if($file->getSize() > $config['imageFilesize']*1024) exit(json_encode (array('error'=>2)));
            
            $ext = '.' . $file->getExtensionName();
            $allowExt = explode('|', $config['imageTypes']);
            if(!in_array(strtolower($ext),$allowExt)) exit(json_encode (array('error'=>3))); 
            //图片上传
            $remote = 'files/'.date('Y/m/d/').Tool::generateSalt() . $ext;
            $result = UploadedFile::upload_file($file->getTempName(),$remote,'','uploads');
            if(!$result) exit(json_encode (array('error'=>4))); 
            exit(json_encode(array('error'=>false,'ajaxfile'=>$remote,'path'=>IMG_DOMAIN . '/'. $remote)));
        }
        $this->setFlash('error',  Yii::t('membercomment','请求有误!'));
        $this->redirect(array('/member/site/index'));
    }
    
    /**
     * 删除评论图片
     */
    public function actionDeleteImg()
    {
        if($this->isAjax()){
            $src = str_replace(IMG_DOMAIN, Yii::getPathOfAlias('uploads'),Yii::app()->request->getPost('src'));
            $result = UploadedFile::delete($src);
            if($result){
                exit(json_encode(array('error'=>false)));
            } else {
                exit(json_encode(array('error'=>true)));
            }
        }
        $this->setFlash('error',  Yii::t('membercomment','请求有误!'));
        $this->redirect(array('/member/site/index'));       
    }    
    /**
     * 评论之前对订单做检查
     * @param $model 订单模型
     * @throws CHttpException
     */
    private function _check($model)
    {
        $condition = array(
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_RECEIVE,
            'is_comment' => Order::IS_COMMENT_NO,
        	'is_distribution' => Order::IS_DISTRIBUTION_YES,
            'sign_time' => array('', ' ', null, 0),
        );
        $result=array();
        $result=array('flag'=>true);
        foreach ($condition as $k => $v) {
            if (is_array($v)) {
                if (!isset($model->$k) || in_array($model->$k, $v)) 
                	 $result=array('flag'=>false,'msg'=>'订单状态未更新，请稍后进行评价！');
                	//throw new CHttpException(404, $k . '请求的订单条件错误.');
            } else {
                if (!isset($model->$k) || $model->$k != $v) 
                	$result=array('flag'=>false,'msg'=>'订单状态未更新，请稍后进行评价！');
                	//throw new CHttpException(404, $k . '请求的订单条件错误.');
            }
        }
        return $result;
    }

}
