<?php
/**
 * 秒杀活动控制器
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/5/7
 * Time: 16:52
 */

class SeckillController extends Controller{


    //秒杀活动主页
    public function actionIndex(){
        $nowTime = time();
		$this->render('index',array('nowTime'=>$nowTime));
    }

    public function actionGetListData(){
        $datalist = array();
        $limit     = 30;
		$startPage = intval($_POST['page']-1)*$limit;
		$endPage   = intval($_POST['page'])*$limit;
        $listData  = ActivityData::getActivityGoodsList();
        $setingList = ActivityData::getActivityRulesSeting();

		$nowTime = time();
		$status  = array('ongoing'=>0, 'coming'=>0);
        $endTime = $startTime = $list = $newResult   = $ongoing = $coming = $listdata = $timeslist = $has = $soldOut = $return = array();
		if(!empty($setingList)){
			foreach($setingList as $k=>$v){
                unset($v['description']);
                if($v['category_id'] == 3) {
                    $day1 = strtotime($v['date_start']);
                    $day2 = strtotime($v['date_end']);
                    $days = round($day2 - $day1)/86400+1;

                    if($days>1){
                        for($i=0; $i<$days; $i++){
                            $d = $i*86400 + $day1;

                            $v['date_start'] = date('Y/m/d',$d);
                            $v['date_end']   = date('Y/m/d',$d);
                            $v['start_dateline'] = date('Y-m-d',$d).' '.$v['start_time'];
                            $v['end_dateline']   = date('Y-m-d',$d).' '.$v['end_time'];
                            $list[] = array('id'=>$v['id'],'date_end'=>$v['date_end'],'date_start'=>$v['date_start'],'start_dateline'=>$v['start_dateline'],'end_dateline'=>$v['end_dateline']);
                        }
                    }else{
						$list[] = array('id'=>$v['id'],'date_end'=>$v['date_end'],'date_start'=>$v['date_start'],'start_dateline'=>$v['start_dateline'],'end_dateline'=>$v['end_dateline']);
					}
                }

			}

			foreach($list as $k=>$v){
				$start = strtotime($v['start_dateline']);
				$end   = strtotime($v['end_dateline']);	
				
				//过期,删除
				if($nowTime > $end){
					unset($list[$k]);
					continue;
				}
				
				//正在进行
				if($nowTime >= $start && $nowTime <= $end){
					$ongoing[] = $v;	
					$status['ongoing'] = 1;
				}else{
					$coming[] = $v;
					$status['coming'] = 1;
				}
			}
		}

		if($status['ongoing']==1){
		    $timeslist = !empty($ongoing) ? $ongoing : array();
		}else if($status['coming']==1 && $status['ongoing']==0){
            $today_goods = $tomorrow_goods = $times_array = array();

            foreach($coming as $k=>$v){
                if(strtotime($v['date_start']) == strtotime(date('Y/m/d'))){//筛选当天的活动商品
                    $today_goods[strtotime($v['start_dateline'])][] = $v;
                }elseif(strtotime($v['date_start']) >= strtotime(date('Y/m/d'))+86400){
                    $tomorrow_goods[strtotime($v['start_dateline'])][] = $v;
                }
            }

            $times_array = !empty($today_goods) ? $today_goods : $tomorrow_goods;
            ksort($times_array);

            //$times_array_new = array_slice($times_array,0,1);
            //$timeslist = !empty($times_array_new[0]) ? $times_array_new[0] : array();
			$timeslist = !empty($times_array) ? array_shift($times_array) : array();
		}

        if(!empty($listData)){
            foreach($listData as $key=>$value){
                if($value['rules_seting_id'] == $timeslist[0]['id']){
                    $value['start_dateline'] = $timeslist[0]['start_dateline'];
                    $value['end_dateline'] = $timeslist[0]['end_dateline'];
                    $datalist[] = $value;
                }
            }
        }

        if(empty($datalist)){
            echo json_encode(array('status'=>3,'datalist'=>$return,'nowTime'=>$nowTime));
            die;
        }

		$count = count($datalist);
        if(!empty($datalist) && $count > $startPage){
			
            foreach( $datalist as $key=>$value ){
				if($key < $startPage) continue;
				if($key >= $endPage) break;

                $value['difference_start'] = strtotime($value['start_dateline'])-$nowTime;
                $value['difference_end'] = strtotime($value['end_dateline'])-$nowTime;
                $value['url'] = $this->createAbsoluteUrl('/goods/view', array('id' => $value['id']));
                $value['stock'] = ActivityData::getActivityGoodsStock($value['id']);
                $value['product_name'] = ActivityData::getActivityGoodsName($value['id']);
                $startTime =strtotime($datalist[0]['start_dateline'])-$nowTime;
                $endTime = strtotime($datalist[0]['end_dateline'])-$nowTime;
                if($value['discount_rate'] != 0){
                    $value['active_price'] = number_format($value['price'] * $value['discount_rate']/100,2,'.','');
                }else{
                    $value['active_price'] = $value['discount_price'];
                }

                if($value['stock'] > 0){
                    $has[] = $value;
                }else{
                    $soldOut[] = $value;
                }
            }
            $return = array_merge($has,$soldOut);
        }
		
        $s = !empty($return)  ?  1 : 0;
        echo json_encode(array('status'=>$s,'datalist'=>$return,'nowTime'=>$nowTime,'startTime'=>$startTime,'endTime'=>$endTime));
    }

}