<?php
//Yii::import('common.components.ActivityData');  

/**
 * 活动模块控制器
 * @author jiawei.liao <569114018@qq.com>
 */
class SiteController extends Controller {
	
	public static  $pageSize = 30;//下拉要加载的个数
        public $category_id = 0;//栏目默认为0 无栏目区别

        public function beforeAction($action)
        {
            $seo = $this->getConfig('seo');
            if(isset($seo['activeTitle'])&& !empty($seo['activeTitle'])) $this->pageTitle = Yii::t('active', $seo['activeTitle']);
            if(isset($seo['activeKeyword'])&& !empty($seo['activeKeyword']))$this->keywords = $seo['activeKeyword'];
            if(isset($seo['activeDescription'])&& !empty($seo['activeDescription']))$this->description = $seo['activeDescription'];
            header("Content-type: text/html; charset=utf-8");
            return parent::beforeAction($action);
        }
    
	/**
     * 活动首页
     */
        public function actionIndex() {
		
		$nowTime      = time();
		$dataProvider = $active = array();
		$page = $this->getParam('page') ? $this->getParam('page') : 1; //当前页数
                $category_id = $this->getParam('category_id') ? $this->getParam('category_id') : 0;
                
		//检查是否有秒杀活动
		$seckill  = $seckills = $ongoing = $ready = $stop = $rules = array();
		$activity = ActivityData::getActivityRulesSeting();

		if(!empty($activity)){
			foreach($activity as $k=>$v){
				//过滤用于app端的季节性活动
				if(($v['category_id'] == 2) && ($v['sort'] >= 50) && ($v['sort'] != 99999)){
					continue;
				}
				$st = strtotime($v['start_dateline']);
				$et = strtotime($v['end_dateline']);
				
				//将不正确的状态3改回状态2或4
				if($v['status'] == 3){
					if($nowTime<$st){$v['status']=2;}
					if($nowTime>$et){$v['status']=4;}
				}
				
				//将不正确的状2改回3
				if( $v['status'] == 2 && $nowTime >= $st && $nowTime <= $et ){
					$v['status'] = 3;
				}
				
				//正在进行
				if($v['category_id'] != 3 && $v['status']==3){
					$ongoing[] = $v;
				}
				
				//准备开始
				if($v['status'] == 2 && $v['category_id'] != 3){
					$ready[] = $v;
				}
				
				//根据规则表id记录一个数组,用于展示活动商品
				$rules[$v['id']] = array('start_dateline'=>$v['start_dateline'], 'end_dateline'=>$v['end_dateline'], 'discount_rate'=>$v['discount_rate'], 'discount_price'=>$v['discount_price'], 'category_id'=>$v['category_id'], 'status'=>$v['status']);
				
				$active[$v['id']] = $v;
				
				if($v['category_id'] == 3 ){//秒杀活动 过滤已结束的活动
					if($nowTime > strtotime($v['end_dateline'])) continue;
					$seckills[] = $v;
				}
			}
		}

		//已结束
		if(empty($ongoing) && empty($ready)){
		    $stop = ActivityData::getActivityRulesExpire();
			if(empty($stop)){
				$stop = array();
			}else{
			    uasort($stop, 'self::stopCMP');	
			}
		}
		
		//修改广告排序
		//$adverts = Tool::cache('adverts')->get('seckill-index-banner');
		$adverts = Advert::getConventionalAdCache('seckill-index-banner');
		$adCount = 0;
		if(!empty($adverts) && $adverts!=false){
			foreach($adverts as $k => $v){
				if( !isset($v['sort']) ){
					$sort = 99999; 
			    }else{
					$sort = $v['sort']>0 ? $v['sort'] : 99999;
				}
                
				$adverts[$k]['sort'] = $sort;
				$adverts[$k]['background'] = isset($v['background']) ? $v['background'] : '#000';
			}
			$adCount = count($adverts);
		}
		
		//处理秒杀时间
		if($seckills){
			foreach($seckills as $v){
				$day1 = strtotime($v['date_start']);
                $day2 = strtotime($v['date_end']);
                $days = round(($day2 - $day1)/86400)+1;
				
				if($days>1){
					for($i=0; $i<$days; $i++){
						$d  = $day1 + $i*86400;
						
						$de = date('Y-m-d', $d);
						
						$v['date_start']     = $de;
						$v['date_end']       = $de;
						$v['start_dateline'] = $de.' '.$v['start_time'];
						$v['end_dateline']   = $de.' '.$v['end_time']; 
						$seckill[] = $v;
					}
				}else{
					$seckill[] = $v;
				}
			}//end foreach

			foreach($seckill as $k=>$v){
				if(strtotime($v['end_dateline']) < $nowTime) unset($seckill[$k]);
			}
		}
		
		$secCount = empty($seckill) ? 0 : count($seckill);
		if($secCount>1) uasort($seckill, 'self::secCMP');
		
		//正在进行的活动,处理数组排序
		$onCount = count($ongoing);
		if($onCount>1 && !empty($ongoing)){//数组大于一个时,先排sort排,再排结束时间从先到后排
			foreach ( $ongoing  as  $k  =>  $v ) {
				 $onSort[$k] =  $v['sort'];
				 $onTime[$k] =  $v['end_dateline'];
			}
			array_multisort ( $onSort ,  SORT_ASC ,  $onTime ,  SORT_ASC ,  $ongoing ); 
		}
		
		//如果正在进行的活动小于3个 则处理即将开始的活动,按同样的处理方式排序
		$reCount = count($ready);
		if($onCount<3 && !empty($ready) && $reCount>1){
			foreach ( $ready  as  $k  =>  $v ) {
				 $reSort[$k] =  $v['sort'];
				 $reTime[$k] =  $v['end_dateline'];
			}
			array_multisort ( $reSort ,  SORT_ASC ,  $reTime ,  SORT_ASC ,  $ready );
		}
		
		$actArray = $onCount>2 ? $ongoing : array_merge($ongoing, $ready);
		//$actCount = empty($actArray) ? 0 : count($actArray);
		//if($actCount>1) uasort($actArray, 'self::actCMP');

		//$this->pageTitle = str_replace('Site', '', $this->pageTitle) .'活动主页';
		if($adCount > 1) uasort($adverts, 'self::advCMP');
		$this->render('index', array(
            'dataProvider' => $dataProvider,
			'adverts' => $adverts,
			'seckill' => array_shift($seckill),
			'grab' => ActivityData::getGrabPlaying(),
			'activity' => !empty($actArray) ? $actArray : $stop,
			'productCategory' => ActivityData::getProductCategory(),
			'productRelation' => ActivityData::getActivityProductAll($page,$category_id,self::$pageSize),
			'rules' => $rules,
			'active' => $active,
			'pageSize' => self::$pageSize,
			'nowTime' => $nowTime,
        ));
    }
	
	/**
	* 处理秒杀排序
	*/
	public static function secCMP($a, $b){
	    if ( $a['start_dateline']  ==  $b['start_dateline'] ) {
			return  0 ;
		}
		return ( strtotime($a['start_dateline'])  >  strtotime($b['start_dateline']) ) ? 1  :  -1 ;	
	}
	
	/**
	* 处理活动排序
	*/
	public static function actCMP($a, $b){
	    if ( $a['end_dateline']  ==  $b['end_dateline'] ) {
			return  0 ;
		}
		return ( strtotime($a['end_dateline'])  >  strtotime($b['end_dateline']) ) ? 1  :  -1 ;	
	}
	
	/**
	* 处理已结束活动排序
	*/
	public static function stopCMP($a, $b){
	    if ( $a['end_dateline']  ==  $b['end_dateline'] ) {
			return  0 ;
		}
		return ( strtotime($a['end_dateline'])  <  strtotime($b['end_dateline']) ) ? 1  :  -1 ;	
	}
	
	/**
	* 处理广告排序
	*/
	public static function advCMP($a, $b){
	    if ( $a['sort']  ==  $b['sort'] ) {
			return  0 ;
		}
		return ( $a['sort']  >  $b['sort'] ) ?  1  :  -1 ;
	}


    /**
	* 出错处理页面
	*/
	public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
	
	/**
	* 处理下拉加载更多的函数
	* @param integer $productCategory 产品的一级分类id
	* @param integer $page 当前页数
	* @return array 返回处理后的数组
	*/
	public function actionGetProduct(){
//            exit(CJSON::encode(array('resutl'=>'soooooo')));
	    $return          = array();
		$productCategory = intval($this->getParam('category_id'));
//                var_dump($productCategory);exit;
		//$page            = intval($this->getParam('page'));
		$page            = 1;
		
		$result   = ActivityData::getActivityProductAll($page,$productCategory);//参加活动的商品
		$start    = self::$pageSize * ($page-1);
		$end      = self::$pageSize * $page;
		$nowTime  = time();
        
		$product  = array();
		if($productCategory){//按分类获取产品
		    //整理出分类产品数组
			if($result){
				foreach($result as $k=>$v){
					if($v['product_category'] != $productCategory) continue;
					
					$product[] = $v;
				}
				
				//判断是否有值
				$total = count($product);
				if(empty($product) || $total < $start){
					echo json_encode($return);
					exit;
				}
				
				//筛选满足条件的记录
				foreach($product as $k=>$v){
					if($k < $start) continue;
					if($k>=$end) break;
					$return[] = $v;
				}
			}
		}else{//获取所有产品
			$total = $result ? count($result) : 0;
			if(empty($result) || $total < $start){
				echo json_encode($return);
				exit;
			}
			
			if($end < $total || ($total>=$start && $total<=$end)){
				foreach($result as $k=>$v){
					if($k < $start) continue;
					if($k>=$end) break;
					$return[] = $v;
				}
			}
		}
		
		if($return){//处理url 价格 时间
			$activity = ActivityData::getActivityRulesSeting();//活动相关内容
			
			if(!empty($activity)){//筛选要用的数组
				foreach($activity as $k=>$v){
					//if( $nowTime > strtotime($v['end_dateline']) ) continue;
					$rules[$v['id']] = array('start_dateline'=>$v['start_dateline'], 'end_dateline'=>$v['end_dateline'], 'discount_rate'=>$v['discount_rate'], 'discount_price'=>$v['discount_price'], 'category_id'=>$v['category_id'], 'status'=>$v['status'], 'category_id'=>$v['category_id']);
				}
			}
			
			foreach($return as $k=>$v){
				$v['href'] = $this->createAbsoluteUrl('/goods/view', array('id' => $v['product_id']));
				$v['thumbnail'] = IMG_DOMAIN . '/' .$v['thumbnail'];
				
				$v['times'] = 0;
				$price      = $v['price'];
				$v['dt']    = '0天0时0分0秒';
				$setingId   = $v['rules_seting_id'];
				if($setingId){
					if( $setingId && ($nowTime >= strtotime($rules[$setingId]['start_dateline']) && $nowTime <= strtotime($rules[$setingId]['end_dateline'])) && $rules[$setingId]['category_id']!=1){//若商品有参加活动,则显示活动价(红包活动原价显示)
						$price = $rules[$setingId]['discount_rate']>0 ? number_format($rules[$setingId]['discount_rate']*$price/100, 2) : number_format($rules[$setingId]['discount_price'], 2);
					}
					if($rules[$setingId]['status']==2){
						$v['times'] = strtotime($rules[$setingId]['start_dateline']) - $nowTime;
					}else if($rules[$setingId]['status']==3){
						$v['times'] = strtotime($rules[$setingId]['end_dateline']) - $nowTime;
					}
					
					$v['dt'] = self::DealTimes($v['times']);
				    $v['price'] = $price;
				}
				
			    $return[$k] = $v;
			}
		}
		echo json_encode($return);
		exit;
	}
	
	/** 
	* 处理时间函数,返回可显示的时间
	* @param integer $time 要处理的时间
	* @return string 返回处理后的字符串数组
	*/
	public static function DealTimes($time=0){
	    $return = '0天0时0分0秒';
		$hour   = 3600;
		$day    = 86400;
		
		if($time>0){
			$d = intval($time/$day);
			$h = floor(($time-$day*$d)/$hour);
			$m = floor(($time-$day*$d-$h*$hour)/60);
			$s = $time-$day*$d-$h*$hour-$m*60;
			
			$return = "{$d}天{$h}时{$m}分{$s}秒";
		}
		return $return;	
	}
}

