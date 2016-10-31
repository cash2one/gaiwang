<?php

/**
 * 常规活动控制器
 * @author shengjie.zhang <767326791@qq.com>
 */
class FestiveController extends Controller {

    /**
     * 常规活动主页显示
     */
    public function actionIndex(){
        $upComing = array();
        $ongoing = array();
        $over = array();
        $pmComing = array();
        $time = time();
        $allActive = $this->getAllActive()?$this->getAllActive():array();
        foreach ($allActive as $k => $v) {
            //过滤用于app端的季节性活动
                if(($v['category_id'] == 2) && ($v['sort'] >= 50) && ($v['sort'] != 99999)){
                    continue;
                }
            $v['intStart'] = strtotime($v['start_time']);
            $v['intEnd'] = strtotime($v['end_time']);
            if($v['category_id'] == 4) {
                
                if($v['status'] == 4){
                    $over[] = $v;
                }
                
                if($v['status'] == 3 &&  $v['intEnd'] < $time){
                    $v['status'] = 4;

                    $over[] = $v;
                }
                
                if($v['status'] == 3 && $v['intStart'] < $time && $v['intEnd'] > $time){
                    $v['time'] = $v['intEnd']-$time;
                    $pmComing[] = $v;
                }

                if($v['status'] == 2 && $v['intStart'] >$time){
                    $v['time'] = $v['intStart']-$time;
                    $pmComing[] = $v;
                }

                if($v['status'] == 2 && $v['intStart'] <$time && $v['intEnd'] >$time){
                    $v['status'] = 3;
                    $v['time'] = $v['intEnd']-$time;
                    $pmComing[] = $v;
                }
                
                if($v['status'] == 2 && $v['intEnd'] < $time){
                    $v['status'] = 4;
                    $over[] = $v;
                }
            } else {
            
                if($v['status'] == 4){
                    $over[] = $v;
                }

                if($v['status'] == 3 &&  $v['intEnd'] < $time){
                    $v['status'] = 4;

                    $over[]=$v;
                }

                if($v['status'] == 3 && $v['intStart'] < $time && $v['intEnd'] > $time){
                    $v['time'] = $v['intEnd']-$time;
                    $ongoing[] = $v;
                }

                if($v['status'] == 2 && $v['intStart'] >$time){
                    $v['time'] = $v['intStart']-$time;
                    $upComing[] = $v;
                }

                if($v['status'] == 2 && $v['intStart'] <$time && $v['intEnd'] >$time){
                    $v['status'] = 3;
                    $v['time'] = $v['intEnd']-$time;
                    $ongoing[] = $v;
                }

                if($v['status'] == 2 && $v['intEnd'] < $time){
                    $v['status']=4;
                    $over[]=$v;
                }
            }
        }

        $active = array();
        $active['upComing'] = $upComing;
        $active['ongoing'] = $ongoing;
        $active['over'] = $over;
        $upSort = array();
        $upStartTime = array();
        foreach ($upComing as $k => $v) {
            $upSort[$k] = $v['sort'];
            $upStartTime[$k] = $v['start_time'];
        }
        array_multisort($upSort, SORT_ASC, $upStartTime, SORT_ASC, $upComing);

        $onSort = array();
        $onEndTime = array();
        foreach ($ongoing as $k => $v) {
            $onSort[$k] = $v['sort'];
            $onEndTime[$k] = $v['end_time'];
        }
        array_multisort($onSort, SORT_ASC, $onEndTime, SORT_ASC, $ongoing);

        $overEndTime = array();
        foreach ($over as $k => $v) {
            $overEndTime[$k] = $v['end_time'];
        }
        array_multisort($overEndTime, SORT_DESC, $over);
        $over = array_slice($over,0,30);
            // 获取广告位图片，过滤过期图片并最多4张图片
        $advert = Advert::getConventionalAdCache('festive_index');
        $picAdvert =array();
        foreach ($advert as $k => $v) {
            if (AdvertPicture::isValid($v['start_time'], $v['end_time'])){
                $picAdvert [] = $v;
            }
        }

        $picAdvert = array_slice($picAdvert,0,4);

        //重新排序拍卖商品, 先按sort从低到高, 再按结束时间从低到高
        if( !empty($pmComing) ){
            $pmSort = Tool::returnArrayColomn($pmComing, 'sort');
            $pmEnd  = Tool::returnArrayColomn($pmComing, 'intEnd');
            array_multisort($pmComing, SORT_ASC, $pmSort, SORT_ASC, $pmEnd);
        }

        $this->render('index', array(
        'ongoing' => $ongoing,
        'upComing' => $upComing,
        'over' => $over,
        'picAdvert'=> $picAdvert,
        'pmComing' => $pmComing
        ));

    }

    public function actionAjaxProduct(){
        $comeOver = SeckillRulesSeting::TIME_OVER;
        if ($this->isAjax() && $this->isPost()) {
            $num = $this->getPost('id');
            $upComing = array();
            $ongoing = array();
            $over = array();
            $time = time();
            $allActive = $this->getAllActive()?$this->getAllActive():array();


            foreach ($allActive as $k => $v) {
                //过滤用于app端的季节性活动
                if(($v['category_id'] == 2) && ($v['sort'] >= 50) && ($v['sort'] != 99999)){
                    continue;
                }
                if($v['status'] == 4){
                    $over[]=$v;
                }
                if($v['status'] == 3 &&  strtotime($v['end_time']) < $time){
                    $v['status']= 4;

                    $over[]=$v;
                }
                if($v['status'] == 3 && strtotime($v['start_time']) < $time && strtotime($v['end_time']) > $time){
                    $v['time']=strtotime($v['end_time'])-$time;
                    $ongoing[]=$v;
                }
                if($v['status'] == 2 && strtotime($v['start_time']) >$time){
                    $v['time']=strtotime($v['start_time'])-$time;
                    $upComing[]=$v;
                }
                if($v['status'] == 2 && strtotime($v['start_time']) <$time && strtotime($v['end_time']) >$time){
                    $v['status']=3;
                    $v['time']=strtotime($v['end_time'])-$time;
                    $ongoing[]=$v;
                }
                if($v['status'] == 2 && strtotime($v['end_time']) < $time){
                    $v['status']=4;
                    $over[]=$v;
                }
            }
            $overEndTime=array();
            foreach ($over as $k => $v) {
                $overEndTime[$k]=$v['end_time'];
            }
            array_multisort($overEndTime, SORT_DESC, $over);
            array_multisort($overEndTime, SORT_DESC, $over);
            $page = $num+30;

            $data = array();

            if ($page < 300) {
                $over = array_slice($over,0,$page);
                exit(json_encode($over));
            } else {
                $over = array_slice($over,0,300);
                exit(json_encode($over));
            }
        }

    }

    // 优化代码
    public function getAllActive(){
        $name = ActivityData::CACHE_FESTIVE_ACTIVITY_OVER_ALL;
        // $config = Tool::cache($name)->delete($name);
        $config = Tool::cache($name)->get($name);
        $noBegin = SeckillRulesSeting::NO_BIGING;
        $onOpen = SeckillRulesSeting::BEGINING;
        $comeOver = SeckillRulesSeting::TIME_OVER;

        if ($config == FALSE) {
            $sql = "SELECT m.category_id,s.end_time,m.name,s.status,s.remark,s.link,s.picture,s.sort,s.id,concat(m.date_end,' ',s.end_time) end_time,concat(m.date_start,' ',s.start_time) start_time
            FROM {{seckill_rules_seting}} s
            LEFT JOIN {{seckill_rules_main}} m ON s.rules_id = m.id
            WHERE s.status IN ({$comeOver},{$noBegin},{$onOpen}) AND m.category_id != 3 ORDER BY concat(m.date_end,' ',s.end_time) DESC LIMIT 0,400";
            $over = Yii::app()->db->createCommand($sql)->queryAll();
            // Tool::P($over);EXIT;

            Tool::cache($name)->set($name, serialize($over),ActivityData::EXPIRE_TIME);
            $config = Tool::cache($name)->get($name);
            $config = unserialize($config);
        } else {
            $config = unserialize($config);
        }
        // Tool::p($config);exit;
        return $config;
    }

    /**
    * 常规活动详情页面展示
    * @param  [int] $id  活动的规则设置表的主键id
    * @return [type]
    */
    public function actionDetail($id){
        // 分配出常规活动页面主图及标题底图
        $pic = $this->getFestiveDetailBanner($id);
        if ($pic['status'] == SeckillRulesSeting::TIME_OVER)
        throw new CHttpException(404, Yii::t('error', '请求的页面不存在。'));

        //分配出常规活动里面所有商品
        $goods = $this->getFestiveDetailAllGoods($id);
        $goodsOne = array_slice($goods,0,6);
        $goodsTwo = array_slice($goods,6);

        $this->render('detail',array(
            'pic'=>$pic,
            'goodsOne'=>$goodsOne,
            'goodsTwo'=>$goodsTwo,
        ));

    }
    /**
     * 分配出常规活动页面主图及标题底图
     * @param  [type] $id 活动的规则设置表的主键id
     * @return [type]
     */
    public function getFestiveDetailBanner($id){
        $name = ActivityData::CACHE_FESTIVE_DETAIL_BANNER.$id;
        // $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_BANNER)->delete($name);
        $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_BANNER)->get($name);
        if($config == FALSE){
            $sql = "SELECT m.banner1,m.banner2,m.banner3,m.banner4,m.name,s.status FROM {{seckill_rules_seting}} s LEFT JOIN {{seckill_rules_main}} m  ON s.rules_id = m.id WHERE s.id = {$id}";
            $config = Yii::app()->db->createCommand($sql)->queryRow();
            Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_BANNER)->set($name, serialize($config), ActivityData::EXPIRE_TIME);
            $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_BANNER)->get($name);
            $config = unserialize($config);
        }else{
            $config = unserialize($config);
        }

        return $config;
    }

    /**
     * 查询出某个常规活动的所有商品
     * @param  [int] $id 活动的规则设置表的主键id
     * @return [type]
     */
    public function getFestiveDetailAllGoods($id){
        $name = ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS.$id;
        $publish=Goods::PUBLISH_YES;
        $status=Goods::STATUS_PASS;
        // $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS)->delete($name);
        $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS)->get($name);

        if($config == FALSE){
            $sql ="SELECT g.name,rs.remark,r.category_id,r.product_id,g.market_price,r.seller_name,g.price,g.stock,g.thumbnail,rs.discount_rate,rs.discount_price
            FROM {{seckill_product_relation}} r
            LEFT JOIN {{goods}} g ON r.product_id = g.id
            LEFT JOIN {{seckill_rules_seting}} rs ON rs.id = r.rules_seting_id
            WHERE r.rules_seting_id = {$id} AND g.is_publish = {$publish} AND g.status ={$status} AND r.status=1 ORDER BY g.stock DESC,r.examine_time ASC ";
            $config = Yii::app()->db->createCommand($sql)->queryAll();
            Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS)->set($name, serialize($config), ActivityData::EXPIRE_TIME);
            $config = Tool::cache(ActivityData::CACHE_FESTIVE_DETAIL_ALL_GOODS)->get($name);
            $config = unserialize($config);

        }else{
            $config = unserialize($config);
        }
        return $config;
    }


  }
