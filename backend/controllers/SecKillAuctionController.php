<?php

/**
 * 拍卖活动管理
 */
class SecKillAuctionController extends Controller {
    
   
    public function filters() {
           return array('rights');
        }

    public function allowedActions() {
            return 'checkProductId';
        }

     /**
     * 拍卖商品活动列表
     * @param integer $rulesSetingId 活动规则表的id
     * active_status 活动状态
     */
    public function actionAdmin()
    {

        $model = new SeckillAuction;
        $goods_id = strtolower(Yii::app()->request->getParam('goods_id'));
        $rules_name = strtolower(Yii::app()->request->getParam('rules_name'));
        if( $this->isPost()){
            $_GET['page']="";
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'g.name AS goods_name, s.name seller_name,
                   t.status,
                   t.id,
                   t.goods_id AS gds_id,
                   t.create_user,
                   t.create_time,
                   g.id AS goods_id,
                   g.stock AS product_stock,
                   t.start_price AS start_price,
                   t.price_markup,
                   t.rules_setting_id,
                   srm.name AS rules_name,
		           srs.status AS active_status,
				   srs.is_force,
				   sap.reserve_price,
                   concat(srm.date_start," ",srs.start_time) AS start_time,
                   concat(srm.date_end," ",srs.end_time) AS end_time
                   ';
        $criteria->join = 'LEFT JOIN {{goods}} g  ON t.goods_id = g.id
		           LEFT JOIN {{seckill_auction_price}} sap ON t.rules_setting_id = sap.rules_setting_id AND t.goods_id = sap.goods_id
		           LEFT JOIN {{store}} s ON s.id = g.store_id
                   LEFT JOIN {{seckill_rules_seting}} srs
                   ON srs.id = t.rules_setting_id
                   LEFT JOIN {{seckill_rules_main}} srm
                   ON srm.id = srs.rules_id';
        $criteria->addSearchCondition('t.goods_id',$goods_id);
        $criteria->addSearchCondition('srm.name',$rules_name);

        $criteria->order='t.id desc';
        $count = $model->count($criteria);
        $pages = new CPagination($count);

        $url1=$url2="";
        if($goods_id){
            $url1 = "&goods_id={$goods_id}";
        }
        if($rules_name){
            $url2 ="&rules_name={$rules_name}";
        }
        $pages->route = 'secKillAuction/admin' . $url1.$url2;

        $pages->pageSize =10;
        $pages->applyLimit($criteria);
        $data = $model->findAll($criteria);
        $now = date("Y-m-d H:i:s");
	
        $rules = Yii::app()->db->createCommand()
            ->select("srs.id AS rules_seting_id, srs.status, srm.category_id,srm.name")
            ->from('{{seckill_rules_main}} srm')
            ->leftJoin('{{seckill_rules_seting}} srs', 'srs.rules_id = srm.id')
            ->where("srm.category_id =:cid AND srs.status !=:is_running AND srs.status !=:is_over AND concat(srm.date_start,' ',srs.start_time) > '".$now."' " ,array(':cid'=>SeckillRulesSeting::SECKILL_CATEGORY_FOUR, ':is_running'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':is_over'=>SeckillRulesSeting::ACTIVITY_IS_OVER))
	        ->queryAll();

        $this->render('admin', array(
                   'model' => $model,
                   'labels' => $model->attributeLabels(),
                   'data' => $data,
                   'rules' => $rules,
                   'pages' => $pages,

        ));
    }

      
          

     /* AJAX验证商品ID是否是上架产品和是否已添加到拍卖商品
      *$other_active判断商品是否有参加其它活动（进行中的）
      * $data2获取搜索到商品的活动时间
      * $data3获取到未参加过活动的商品
      * $data4搜索正在进行的活动商品
	  * $data5搜索该商品是否已参加过活动
      */
    public function actionCheckProductId()
    {
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');

	        $sql1 = "SELECT srm.category_id ,concat(srm.date_end,' ',srs.end_time) end_time,concat(srm.date_start,' ',srs.start_time) start_time
	            FROM {{goods}} g
                LEFT JOIN {{seckill_rules_seting}} srs ON g.seckill_seting_id = srs.id
                LEFT JOIN {{seckill_rules_main}} srm ON srm.id = srs.rules_id
	            WHERE g.id = '".$id."'";

            $other_active = Yii::app()->db->createCommand($sql1)->queryRow();

            $sql2 = "SELECT sa.goods_id, srs.is_force,concat(srm.date_end,' ',srs.end_time) end_time,concat(srm.date_start,' ',srs.start_time) start_time
	            FROM {{seckill_auction}} sa
                LEFT JOIN {{seckill_rules_seting}} srs ON sa.rules_setting_id = srs.id
                LEFT JOIN {{seckill_rules_main}} srm ON srm.id = srs.rules_id
	            WHERE sa.goods_id = '".$id."'";

            $data2 = Yii::app()->db->createCommand($sql2)->queryRow();

            $product_id =$data2['goods_id'];

            $now = date("Y-m-d H:i:s");

			
			$sql3 = "SELECT sa.goods_id,concat(srm.date_end,' ',srs.end_time) end_time,concat(srm.date_start,' ',srs.start_time) start_time
	            FROM {{seckill_auction}} sa
                LEFT JOIN {{seckill_rules_seting}} srs ON sa.rules_setting_id = srs.id
                LEFT JOIN {{seckill_rules_main}} srm ON srm.id = srs.rules_id
	            WHERE sa.goods_id = '".$id."' AND concat(srm.date_start,' ',srs.start_time) > '".$now."' ";

            $data3 = Yii::app()->db->createCommand($sql3)->queryRow();
	    
	      
			
	        $sql4 = "SELECT sa.goods_id,srs.is_force,concat(srm.date_end,' ',srs.end_time) end_time,concat(srm.date_start,' ',srs.start_time) start_time
	            FROM {{seckill_auction}} sa
                LEFT JOIN {{seckill_rules_seting}} srs ON sa.rules_setting_id = srs.id
                LEFT JOIN {{seckill_rules_main}} srm ON srm.id = srs.rules_id
	            WHERE sa.goods_id = '".$id."' AND concat(srm.date_start,' ',srs.start_time) <= '".$now."' AND concat(srm.date_end,' ',srs.end_time) >= '".$now."'";
            
			$data4 = Yii::app()->db->createCommand($sql4)->queryRow();
			
			$sql5 = "SELECT sa.goods_id 
			    FROM {{seckill_auction}} sa
				LEFT JOIN {{goods}} g ON g.id = sa.goods_id
				WHERE sa.goods_id = '".$id."'";
				
			$data5 = Yii::app()->db->createCommand($sql5)->queryRow();	
			
			$auction = $data5['goods_id']; 
			
            
			if($data2['end_time'] >= $now && $data2['start_time'] <= $now && $data2['is_force']==0){ //第一次活动正在进行中 未强制结束
                exit(json_encode(array('error' => '该商品正在进行活动拍卖，请重新选择商品！')));
            }
            
			if($data2['end_time'] >= $now && $data2['start_time'] <= $now && $data2['is_force']==1){ //第一次活动正在进行中 强制结束
                if(count($data3)>1) {
                    exit(json_encode(array('error' => '该商品已添加到拍卖商品，请重新选择商品！')));
                }
            }
			
			if($data4['end_time'] < $now && $data4['is_force']==1){ //第一次活动正在进行中（强制结束）第二次活动正在进行中
			    if($data4['end_time'] >= $now && $data4['start_time'] <= $now && $data4['is_force']==0 ){ 
                    exit(json_encode(array('error' => '该商品正在进行活动拍卖，请重新选择商品！')));
				}
            }
			
            if($data4['end_time'] >= $now && $data4['start_time'] <= $now && $data4['is_force']==0 ){ //第二次/N次活动正在进行中 未强制结束
                exit(json_encode(array('error' => '该商品正在进行活动拍卖，请重新选择商品！')));
            }
			
			if($data4['end_time'] >= $now && $data4['start_time'] <= $now && $data4['is_force']==1 ){ //第二次/N次活动正在进行中 强制结束
			    if(count($data3)>1) {
                    exit(json_encode(array('error' => '该商品已添加到拍卖商品，请重新选择商品！')));
                }
            }
			
	        if($other_active['end_time'] >= $now && $other_active['start_time'] <= $now){ //商品是否正在进行别的活动（比如红包活动）
	            if($other_active['category_id'] ==1 || $other_active['category_id'] ==2 || $other_active['category_id'] == 3 ){
	                exit(json_encode(array('error' => '当前该商品正在进行其它活动，请先取消其它活动，才能参与本活动！')));
	            }
	        }
			
			if($other_active['start_time'] > $now){ //商品是否已经参加别的活动（比如红包活动）
	            if($other_active['category_id'] ==1 || $other_active['category_id'] ==2 || $other_active['category_id'] == 3 ){
	                exit(json_encode(array('error' => '当前该商品已参加其它活动，请先取消其它活动，才能参与本活动！')));
	            }
	        }

            if($data2['start_time'] > $now && $product_id ){ //还未开始活动
                exit(json_encode(array('error' => '该商品已添加到拍卖商品，请重新选择商品！')));
            }

            if($data2['end_time'] < $now){ //已结束活动
			    if($data2['end_time'] >= $now && $data2['start_time'] <= $now && $data2['is_force']==1){ //正在进行中，强制结束
                    if(count($data3)>1) {
                        exit(json_encode(array('error' => '该商品已添加到拍卖商品，请重新选择商品！')));
                    }
				}
            }
			
			if($data2['end_time'] < $now){ //已结束活动
			    if(count($data3)>1) {
                    exit(json_encode(array('error' => '该商品已添加到拍卖商品，请重新选择商品！')));
                }
				
            }

            if (empty($id)) {
                exit(json_encode(array('error' => '商品ID不能为空！')));
            }

            $goods = Goods::model()->findByPk(array('id' => $id));
            if (empty($goods)) {
                exit(json_encode(array('error' => '该商品不存在，请重新选择商品！')));
            }
			
            if ($goods['stock'] == 0) {
                exit(json_encode(array('error' => '该商品已无库存')));
            }
			
			
			if(empty($auction)){ //商品未参加过活动
                if ($goods['is_publish'] == Goods::PUBLISH_NO ) {
                    exit(json_encode(array('error' => '该商品未上架，请重新选择商品！')));
                }
			
			    if ($goods['status'] != Goods::STATUS_PASS) {
                    exit(json_encode(array('error' => '该商品未通过审核，请重新选择商品！')));
                }
			
			    if ($goods['life'] != Goods::LIFE_NO) {
                    exit(json_encode(array('error' => '该商品已删除，请重新选择商品！')));
                }
			
			}else{ //商品已参加活动
				if ($goods['is_publish'] == Goods::PUBLISH_NO ) {
                    exit(json_encode(array('error' => '该商品未上架，请重新选择商品！')));
                }
				if ($goods['life'] != Goods::LIFE_NO) {
                    exit(json_encode(array('error' => '该商品已删除，请重新选择商品！')));
                }
			}
			
            if ($goods['is_publish'] == Goods::PUBLISH_YES) {
                $id = $goods['store_id'];
                $result = Store::model()->findByPk(array('id' => $id));
                $msg = array();
                $msg['goodsname'] = $goods['name'];
                $msg['storename'] = $result['name'];
                $msg['startprice'] = $goods['price'];
                $msg['success'] = TRUE;
                exit(json_encode($msg));
            }

        }
    }

    //添加拍卖商品
    /*
     ** $addData1 插入拍卖商品表seckill_auction
     ** $addData2 插入拍卖商品价格表seckill_auction_price
     **
     */
    public function actionAdd()
    {
        $model = new SeckillAuction;
        $model->scenario = 'add';
        $this->performAjaxValidation($model);
        $this->checkPostRequest();
         
        if ($this->isAjax() && $this->isPost()) {
            $goods_id = $this->getPost('goods_id');
            $price_markup=$this->getPost('price_markup');
            $status=$this->getPost('status');
            $rules_setting_ids=$this->getPost('rules_setting_id');
            $start_price=$this->getPost('start_price');
            $member_id=$this->getPost('member_id');
			$reserve_price=$this->getPost('reserve_price');
            
            //防止用户点击添加商品的时，还能添加商品到正在进行的活动中
            if(!empty($rules_setting_ids)) {
                $now = date("Y-m-d H:i:s");
                $rules = Yii::app()->db->createCommand()
                    ->select("srs.id AS rules_seting_id, srs.status, srm.category_id,srm.name")
                    ->from('{{seckill_rules_main}} srm')
                    ->leftJoin('{{seckill_rules_seting}} srs', 'srs.rules_id = srm.id')
                    ->where("srs.id = :rsid AND srm.category_id =:cid AND srs.status !=:is_running AND srs.status !=:is_over AND concat(srm.date_start,' ',srs.start_time) > '".$now."' " ,array(':rsid'=>$rules_setting_ids,':cid'=>SeckillRulesSeting::SECKILL_CATEGORY_FOUR, ':is_running'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':is_over'=>SeckillRulesSeting::ACTIVITY_IS_OVER))
                    ->queryRow();
                
                if(empty($rules)) {
                    $tip = array();
                    $tip['is_error'] = '该活动已经开始，不能进行添加商品！';
                    exit(json_encode($tip));
                }
            }
            
            $sql = "SELECT
                    g.id AS goods_id,
                    g.price AS start_price,
                    g.seckill_seting_id AS rules_setting_id,
		            g.store_id,
		            g.status
                    FROM {{goods}} g
		            LEFT JOIN {{seckill_rules_seting}} srs
		            ON g.seckill_seting_id = srs.id
                    WHERE g.id ={$goods_id}";
            $return = Yii::app()->db->createCommand($sql)->queryRow();
			
			$sqlEndTime = "SELECT
			        concat(srm.date_end,' ',srs.end_time) end_time
					FROM {{seckill_rules_seting}} srs
					LEFT JOIN {{seckill_rules_main}} srm
					ON srs.rules_id = srm.id
					WHERE srs.id = '".$rules_setting_ids."'";
			$endTimeResult = Yii::app()->db->createCommand($sqlEndTime)->queryRow();
		    $auctionEndTime = $endTimeResult["end_time"];
			$auction_end_time = strtotime($auctionEndTime);
			
            $data1 = array(
                    'goods_id' => $return["goods_id"],
                    'store_id' => $return["store_id"],
                    'start_price' =>$start_price,
                    'rules_setting_id' =>  $rules_setting_ids,
                    'price_markup' => $price_markup,
                    'status'=> $status,
                    'create_time' => date('Y-m-d H:i:s'),
                    'create_user'=>Yii::app()->user->name,
            );
            $data2 = array(
                    'goods_id' => $return["goods_id"],
		            'price' => $start_price,
                    'rules_setting_id' =>  $rules_setting_ids,
		            'member_id' => $member_id,
                    'goods_status' => $return["status"],
					'reserve_price' => $reserve_price,
					'auction_end_time' => $auction_end_time,
            );
		
            $addData1 = Yii::app()->db->createCommand()->insert('{{seckill_auction}}', $data1);
            $addData2 = Yii::app()->db->createCommand()->insert('{{seckill_auction_price}}', $data2);
            if($status ==1) {
                 Yii::app()->db->createCommand()->update('{{goods}}', array('status'=>2), 'id=:id', array(':id' =>$goods_id));//更新goods表的status(1为审核通过，2为不通过)
            }
            if($status ==0) {
                Yii::app()->db->createCommand()->update('{{goods}}', array('status'=>1), 'id=:id', array(':id' =>$goods_id));//更新goods表的status(1为审核通过，2为不通过）
            }
			
			@SystemLog::record(Yii::app()->user->name . "添加拍卖活动商品,活动id:" . $rules_setting_ids . "商品id:".$goods_id);
			
            if ($addData1 && $addData2) {
                $tip = array();
                $tip['success'] = '拍卖商品添加成功！';
                exit(json_encode($tip));
            } else {
                $tip = array();
                $tip['error'] = '拍卖商品添加失败！';
                exit(json_encode($tip));
            }
                
        }
    }

     //移除拍卖商品
     /*
     **  $deleteData2移除拍卖商品表seckill_auction
     ** $deleteData1删除拍卖商品价格表seckill_auction_price
     *  $updateSession更新缓存
     */
    public function actionDelete($id) {

        $sql = "SELECT
                sa.goods_id AS gds_id,
                sa.id AS id,
		sa.rules_setting_id AS rules_setting_id,
                g.id AS goods_id,
                sap.goods_status
		FROM {{seckill_auction}} sa
		LEFT JOIN {{seckill_auction_price}} sap
		ON sap.goods_id = sa.goods_id AND sap.rules_setting_id = sa.rules_setting_id
		LEFT JOIN {{goods}} g
		ON  sa.goods_id = g.id
		WHERE sa.id={$id}";
        $return = Yii::app()->db->createCommand($sql)->queryRow();
        $rules_id = $return['rules_setting_id'];
		$gds_id = $return['gds_id'];
        Yii::app()->db->createCommand()->update('{{goods}}', array('status'=>$return["goods_status"]), 'id=:id', array(':id' =>$return['goods_id']));//更新goods表的status(1为审核通过，2为不通过)
        $deleteData1 = Yii::app()->db->createCommand()->delete('{{seckill_auction_price}}','goods_id=:id AND rules_setting_id =:rules_id', array(':id' => $gds_id,':rules_id' => $rules_id));
        $deleteData2 = SeckillAuction::model()->del($id);
		
		@SystemLog::record(Yii::app()->user->name . "删除拍卖活动商品,活动id:" . $rules_id . "商品id:".$gds_id);
		
        AuctionData::updateActivityAuction($rules_id,1);
        if ($deleteData2) {
            $this->setFlash("success","成功删除拍卖商品");
            $this->redirect(array('admin'));
        }
    }

    /**
     * 更新拍卖商品
     * @param $rules_id 活动规则表ID
     * $rules为未开始与未开启活动
     * $rules_running 为正在进行的活动
      */
    public function actionUpdate($id)
    {

        $model = SeckillAuction::model()->findByPk($id);
        $model->scenario = 'update';
        $this->performAjaxValidation($model);
        $rules_id = $model['rules_setting_id'];
        $goods_id = $model['goods_id'];
		$now = date("Y-m-d H:i:s");
        $rules = Yii::app()->db->createCommand()
                ->select("srs.id AS rules_seting_id, srs.status, srm.category_id,srm.name")
                ->from('{{seckill_rules_main}} srm')
                ->leftJoin('{{seckill_rules_seting}} srs', 'srs.rules_id = srm.id')
                ->where("srm.category_id =:cid AND srs.status !=:is_running AND srs.status !=:is_over AND concat(srm.date_start,' ',srs.start_time) > '".$now."' " ,array(':cid'=>SeckillRulesSeting::SECKILL_CATEGORY_FOUR, ':is_running'=>SeckillRulesSeting::ACTIVITY_IS_RUNNING, ':is_over'=>SeckillRulesSeting::ACTIVITY_IS_OVER))
	            ->queryAll();
        $rules_running =  Yii::app()->db->createCommand()
                ->select("srs.id AS rules_seting_id, srs.status AS active_status, m.name AS rules_name, concat(m.date_end,' ',srs.end_time) end_time,concat(m.date_start,' ',srs.start_time) start_time")
                ->from('{{seckill_rules_main}} m')
                ->leftJoin('{{seckill_rules_seting}} srs', 'srs.rules_id = m.id')
                ->where("srs.id = $rules_id")
                ->queryRow();
        $data = Yii::app()->db->createCommand()
                ->select("g.name AS goods_name,sa.goods_id,sa.rules_setting_id,sa.id ,sa.status,s.name AS seller_name,sa.start_price,sa.price_markup,srm.name AS rules_name,sa.create_user,sa.create_time,sap.reserve_price")
                ->from('{{seckill_auction}} sa')
                ->leftJoin('{{seckill_rules_seting}} srs','srs.id = sa.rules_setting_id')
                ->leftJoin('{{seckill_rules_main}} srm','srm.id = srs.rules_id')
				->leftJoin('{{seckill_auction_price}} sap','sap.rules_setting_id = sa.rules_setting_id AND sap.goods_id = sa.goods_id')
                ->leftJoin('{{goods}} g','g.id = sa.goods_id')
                ->leftJoin('{{store}} s','s.id = g.store_id')
                ->where("sa.id = $id")
                ->queryRow();
		
		$gid = $data['goods_id']; //获取到goods_id
		$rid = $data['rules_setting_id']; //获取到rules_setting_id
		
		
        if(isset($_POST['SeckillAuction'])){
            $model->attributes = $_POST['SeckillAuction'];
            if($model->save()){
                $status = $model['status'];
		        $rules_setting_id = $model['rules_setting_id'];
				$start_price = $model['start_price'];
				$reserve_price=$this->getPost('reserve_price');
				
                if($status ==1) {
                    Yii::app()->db->createCommand()->update('{{goods}}', array('status'=>2), 'id=:id', array(':id' =>$goods_id));//更新goods表的status(1为审核通过，2为不通过)
                }
                if($status ==0) {
                    Yii::app()->db->createCommand()->update('{{goods}}', array('status'=>1), 'id=:id', array(':id' =>$goods_id));//更新goods表的status(1为审核通过，2为不通过）
                }
		        $updateAuction = Yii::app()->db->createCommand()->update('{{seckill_auction_price}}',array('rules_setting_id'=>$rules_setting_id,'price'=>$start_price,'reserve_price'=>$reserve_price),'goods_id=:gid AND rules_setting_id=:rid',array(':gid'=>$gid,':rid'=>$rid));//同步更新拍卖商品价格表的rules_setting_id
				
				$sqlEndTime = "SELECT
			        concat(srm.date_end,' ',srs.end_time) end_time
					FROM {{seckill_auction_price}} sap
					LEFT JOIN {{seckill_rules_seting}} srs
					ON srs.id = sap.rules_setting_id
					LEFT JOIN {{seckill_rules_main}} srm
					ON srs.rules_id = srm.id
					WHERE sap.rules_setting_id = '".$rules_setting_id."'
					AND sap.goods_id ='".$gid."'";
				
				$endTimeResult = Yii::app()->db->createCommand($sqlEndTime)->queryRow();
		        $auctionEndTime = $endTimeResult["end_time"];
			    $auction_end_time = strtotime($auctionEndTime);
				
				if($updateAuction){
				    Yii::app()->db->createCommand()->update('{{seckill_auction_price}}',array('auction_end_time'=>$auction_end_time),'goods_id=:gid AND rules_setting_id=:rid',array(':gid'=>$gid,':rid'=>$rules_setting_id));
				}
				
				@SystemLog::record(Yii::app()->user->name . "修改拍卖活动商品,活动id:" . $rid . "商品id:".$goods_id);
				
                AuctionData::updateActivityAuction($rules_id,1);
                $this->setFlash("success","成功修改拍卖商品");
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
                'model' => $model,
                'rules' => $rules,
                'rules_running' => $rules_running,
                'data' => $data,
        ));

    }

}