<?php

/**
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 15-3-26 上午10:58
 */
class WebGoodsData
{

	const CACHE_TIME = 86400;//缓存时间

    /**
     * 检查商品状态
     * @param $id int 商品id
     * @return array
     * @author xiaoyan.luo
     */
    public static function checkGoodsStatus($id)
    {
        $goodsData = Yii::app()->db1->createCommand()
            ->select('g.*,b.name as bname,r1.short_name as city,r2.short_name as province,f.valuation_type,
            at.status as at_status,at.name as at_name,g.price as price,st.special_price as special_price,st.special_topic_category_id,
            m.name as special_name,m.start_time,m.end_time,m.id as special_topic_id,sc.integral_ratio')
            ->from('{{goods}} as g')
            ->leftJoin('{{brand}} as b', 'g.brand_id = b.id')
            ->leftJoin('{{freight_template}} as f', 'g.freight_template_id = f.id')
            ->leftJoin('{{store_address}} as s', 'f.store_address_id = s.id')
            ->leftJoin('{{region}} as r1', 'r1.id = s.city_id')
            ->leftJoin('{{region}} as r2', 'r2.id = s.province_id')
            ->leftJoin('{{activity_tag}} as at', 'at.id = g.activity_tag_id')
            ->leftJoin('{{special_topic_goods}} as st', 'st.goods_id = g.id')
            ->leftJoin('{{special_topic}} as m', 'st.special_topic_id = m.id')
            ->leftJoin('{{special_topic_category}} as sc', 'sc.id = st.special_topic_category_id')
            ->where('g.id = :id', array(':id' => $id))
            ->queryRow();
        $pictureData = Yii::app()->db1->createCommand()
            ->select('path')
            ->from('{{goods_picture}}')
            ->where('goods_id = :id', array(':id' => $id))
            ->queryAll();
        foreach ($pictureData as $key => $value) {
            $goodsData['path'][$key] = $value['path'];
        }
        $goodsData = Goods::HandleGoodsDetail($goodsData);
        return $goodsData;
    }

    /**
     * 获取店铺信息
     * @param $id int 店铺id
     * @return array
     * @author xiaoyan.luo
     */
    public static function getStoreData($id)
    {
        $data = Yii::app()->db1->createCommand()
            ->from('{{store}}')
            ->where('id = :id and status in (:status_pass , :status_try )', array(
                ':id' => $id, ':status_pass' => Store::STATUS_PASS, ':status_try' => Store::STATUS_ON_TRIAL))
            ->queryRow();
        return $data;
    }

    /**
     * 保存咨询数据
     * @param $query array 咨询数据
     * @return bool
     * @author xiaoyan.luo
     */
    public static function saveConsultData($query)
    {
        $guestBook = new GuestBook();
        foreach ($query as $key => $value) {
            $guestBook->$key = $value;
        }
        if ($guestBook->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取商家店铺装修数据
     * @param $storeId int 店铺id
     * @return array
     * @author xiaoyan.luo
     */
    public static function storeDesignData($storeId)
    {
        $data = Yii::app()->db->createCommand()
            ->from('{{design}}')
            ->where('store_id=:store_id and `status`=:status', array(
                ':store_id' => $storeId, ':status' => Design::STATUS_PASS))
            ->queryRow();
        return $data;
    }

    /**
     * 获取商品评价数据
     * @param $id int 商品id
     * @return array
     * @author xiaoyan.luo
     */
    public static function getCommentList($id)
    {
        $command = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{comment}} as t')
            ->where('t.status = :status and t.goods_id = :id'.$where, array(':status' => Comment::STATUS_SHOW, ':id' => $id));
        $newCommand = clone $command;
        //$count = $command->queryScalar();
        $data = $newCommand->select('t.id,t.content,t.create_time,t.reply_time,t.score,t.spec_value,m.head_portrait, m.gai_number')
            ->leftJoin('{{member}} as m', 't.member_id = m.id')
            ->order('t.id DESC')
            ->queryAll();
        return $data;
    }

   /**
    * 商品平均评价
    * @param int $goodsId 神品ID
    * @return Ambigous <number, string>
    * @author wyee
    */
    public static function getgGoodsAvgScore($goodsId){
        $avgScore=Yii::app()->db->createCommand()
            ->select('avg(score) AS avgScore')
            ->from('{{comment}}')
            ->where('goods_id = :goods_id',array(':goods_id'=>$goodsId))
            ->queryScalar();
        return (!empty($avgScore)) ? sprintf('%.2f', $avgScore) : 0;
     }
    /**
     * 获取商品评价数据 V2.0
     * @param $id int 商品id
     * @param integer $type 评价类型 1为所有评价 2为有图片的评价
     * @param integer $vote 按点赞排序 1为降序 2为升序
     * @param integer $time 按时间排序 1为降序 2为升序
     * @return array
     * @author wenhao.li
     */
    public static function getCommentListNew($id, $type=1, $vote, $time)
    {
        $where = $type == 1 ? '' : " and t.img_path!=''";
        $order = '';

        /*if($time == 1 && $vote == 2){
            $order = 't.create_time DESC, t.vote ASC';
        }else if($time == 2 && $vote == 1){
            $order = 't.vote DESC,t.create_time ASC';
        }else if($time == 1 && $vote == 1){
            $order = 't.create_time DESC, t.vote DESC';
        }else if($time == 2 && $vote == 2){
             $order = 't.create_time ASC, t.vote ASC';
        }*/

        if($vote ==1){
            $order = 't.vote DESC';
        }else if($vote == 2){
            $order = 't.vote ASC';
        }

        if($time == 1){
            $order = 't.id DESC';
        }else if($time == 2){
            $order = 't.id ASC';
        }

        $command = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{comment}} as t')
            ->where('t.status = :status and t.goods_id = :id'.$where, array(':status' => Comment::STATUS_SHOW, ':id' => $id));
        $newCommand = clone $command;

        $data = $newCommand->select('t.id,t.content,t.create_time,t.reply_time,t.score,t.spec_value,m.head_portrait,t.img_path,t.vote,t.goods_id,t.is_anonymity, m.gai_number')
            ->leftJoin('{{member}} as m', 't.member_id = m.id')
            ->order($order)
            ->queryAll();
        return $data;
    }

    /**
     * 获取商品成交记录
     * @param $id int 商品id
     * @param $pageSize int 每页记录数
     * @param int $page 第几页
     * @return array
     * @author xiaoyan.luo
     */
    public static function getDealData($id, $pageSize, $page = 1)
    {
        $command = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{order_goods}} as t')
            ->leftJoin('{{order}} as o', 'o.id = t.order_id')
            ->leftJoin('{{member}} as m', 'm.id = o.member_id')
            ->where('t.goods_id = :id and o.status = :status', array(':id' => $id, ':status' => Order::STATUS_COMPLETE));
        $newCommand = clone $command;
        $count = $command->queryScalar();
        $data = $newCommand->select('t.total_price, t.quantity, t.goods_name,o.sign_time,m.gai_number')
            ->limit($pageSize)->offset(($page - 1) * $pageSize)
            ->order('o.sign_time DESC')
            ->queryAll();
        return array('deal' => $data, 'count' => $count);
    }

    /**
     * 获取商品咨询数据
     * @param $id int 商品id
     * @param $pageSize int 每页记录数
     * @param int $page 第几页
     * @return array
     * @author xiaoyan.luo
     */
    public static function getConsultData($id)
    {
        $command = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{guestbook}} as t')
            ->where('t.owner_id = :id and t.status = :status', array(':id' => $id, ':status' => Guestbook::STATUS_PASS_CONFIRM));
        $newCommand = clone $command;
        $count = $command->queryScalar();
        $data = $newCommand->select('t.id,t.content,t.create_time,t.reply_content,t.reply_time,m.gai_number')
            ->leftJoin('{{member}} as m', 'm.id = t.member_id')
            ->order('t.id DESC')
//            ->limit($pageSize)->offset(($page - 1) * $pageSize)
            ->queryAll();
//        return array('guestbook' => $data, 'count' => $count);
        return $data;
    }

    /**
     * 查找商品规格值
     * @param $id int 商品id
     * @return array
     * @author xiaoyan.luo
     */
    public static function getSpecData($id)
    {
        $data = Yii::app()->db1->createCommand()->from('{{goods_spec}}')
            ->where('goods_id = :id', array(':id' => $id))
            ->queryAll();
        return $data;
    }

    /**
     * 动态获取库存评价信息
     * @param $goodsId int 商品id
     * @param $storeId int 店铺id
     * @return array
     * @author xiaoyan.luo
     */
    public static function getEvaluationData($goodsId, $storeId)
    {
        $data = Yii::app()->db->createCommand()
            ->select('g.views,g.stock,g.total_score,g.comments,s.description_match,s.comments as storeComments,s.serivice_attitude,s.speed_of_delivery')
            ->from('{{goods}} as g')
            ->leftJoin('{{store}} as s', 's.id = g.store_id')
            ->where('g.id = :id and g.store_id = :s_id', array(':id' => $goodsId, ':s_id' => $storeId))
            ->queryRow();
        $command = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{comment}} as t')
            ->where('t.status = :status and t.goods_id = :id', array(':status' => Comment::STATUS_SHOW, ':id' => $goodsId));
        $command_img = Yii::app()->db->createCommand()
            ->select('count(t.id) as count')
            ->from('{{comment}} as t')
            ->where('t.status = :status and t.goods_id = :id and img_path!=\'\'', array(':status' => Comment::STATUS_SHOW, ':id' => $goodsId));
        $count    = $command->queryScalar();
        $countImg = $command_img->queryScalar();
        $data['score'] = (!empty($data['total_score']) && !empty($data['comments'])) ? sprintf('%.1f', $data['total_score'] / $data['comments']) : 0;
        $data['scoreView'] = (!empty($data['total_score']) && !empty($data['comments'])) ? sprintf('%.1f', $data['total_score'] / $data['comments']) * 10 : 0;
        $data['descriptionMatch'] = (!empty($data['description_match']) && !empty($data['storeComments'])) ? sprintf('%.2f', $data['description_match'] / $data['storeComments']) : 0;
        $data['seriviceAttitude'] = (!empty($data['serivice_attitude']) && !empty($data['storeComments'])) ? sprintf('%.2f', $data['serivice_attitude'] / $data['storeComments']) : 0;
        $data['speedDelivery'] = (!empty($data['speed_of_delivery']) && !empty($data['storeComments'])) ? sprintf('%.2f', $data['speed_of_delivery'] / $data['storeComments']) : 0;
        $total = $data['description_match'] + $data['serivice_attitude'] + $data['speed_of_delivery'];
        $data['avg_score'] = (int) $total && (int) $data['storeComments'] ? sprintf('%0.2f', ($total / $data['storeComments']) / 3) : 0;
        $data['count']     = $count;
        $data['countImg']  = $countImg;
        $data['goodsAvgScore']=self::getgGoodsAvgScore($goodsId);
	    $data['consult']   = Yii::app()->db->createCommand()
		    ->select('COUNT(*) AS count')->from('{{guestbook}}')
			->where('owner_id=:goodsId AND status=:status', array(':goodsId'=>$goodsId,':status'=>Guestbook::STATUS_THROUGH))
			->queryScalar();

        unset($data['total_score'], $data['comments'], $data['description_match'], $data['storeComments'], $data['serivice_attitude'], $data['speed_of_delivery'], $total, $count);
        return $data;
    }

    /**
     * 获取已收藏的店铺或商品
     * @param int $id 店铺或商品ID
     * @param int $type 分类1为店铺 2为商品
     * @return int 返回收藏的id
     */
    public static function getCollects($id=0, $type=0){
        $result = 0;
		$userId = Yii::app()->user->id;
        if($id<1 || $type<1 || !$userId){ return $result;}

		$cacheKey = $type == 1 ? 'STORE_COLLECT_'.$id.'_'.$userId : 'GOODS_COLLECT_'.$id.'_'.$userId;
		$cache     = Tool::cache($cacheKey)->get($cacheKey);

		//如果有缓存则直接返回
		if($cache !== false && $cache !== true){
		    return $cache;
		}

        if($type == 1){//店铺收藏
            $result = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{store_collect}}')
                ->where('store_id = :id and member_id = :userId', array(':id' => $id, ':userId' => $userId))
                ->queryScalar();

        }else{//商品收藏
            $result = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{goods_collect}}')
                ->where('good_id = :id and member_id = :userId', array(':id' => $id, ':userId' => $userId))
                ->queryScalar();
        }

		Tool::cache($cacheKey)->set($cacheKey, $result, self::CACHE_TIME);

        return $result;
    }
}