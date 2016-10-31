<?php 

/**
 * 居间商公共代码
 * @author wyee<yanjie.wang@g-emall.com>
 *
 */

  class MiddleCommon extends SController {
      
      /**
       * 得到月份数据
       */
      public static function getAccountMouth($sid){
          $criteria = new CDbCriteria;
          $criteria->compare('status', Order::STATUS_COMPLETE);
          $criteria->compare('store_id',$sid);
          $dateEnd =strtotime('-1 days',strtotime(date('Y-m-d 23:59:59')));
          $criteria->compare('pay_time','<='.$dateEnd);
          $criteria->select = " FROM_UNIXTIME(pay_time,'%Y%m') AS `months`,COUNT(id) AS `orderCount`,SUM(real_price) AS `account`";
          $criteria->group = 'months';
          $criteria->order='months DESC';
          $dataProvider = new CActiveDataProvider('Order', array(
                  'criteria' =>$criteria,
          ));
          $accountList=$dataProvider->getData();
          $allAcount=0.00;
          $months=array();
          //20150101开始
          $dateStart=strtotime('20150101');
          $storeModel=Store::model()->findByPk($sid);
          $storeStart=$storeModel->create_time;
          $dateStart = $dateStart>$storeStart ? $dateStart : $storeStart;
          $dateEnd=time();
          $t=intval(date('m'))-intval(date('m',$dateStart));
          for($i=0;$i<=$t;$i++){
              $months[]=date("Ym",strtotime("+$i month",$dateStart));
          }
          $accMouth=array();
          foreach($accountList as $k => $v){
              $allAcount+=$accountList[$k]->account;
              $accMouth[$k]=$v->months;
          }
          //没有数据的月份
          foreach ($months as $m){
              if(!in_array($m, $accMouth)){
                  $accountList[$m]->months=$m;
                  $accountList[$m]->orderCount='0';
                  $accountList[$m]->account='0.00';
              }
          }
          $accountList=array_values($accountList);
          $sortVolum=array();
          foreach ($accountList as $key => $row){
              $sortVolum[$key] = $row->months;
          }
          array_multisort($sortVolum,SORT_DESC,$accountList);
          $res['accountList']=$accountList;
          $res['months']=count($months);
          $res['allAcount']=$allAcount;
          return $res;
      }
      
      
      /**
       * @param int $sid 商家ID
       * @param string $mouth 传值月份
       * @return array
       */
      public static function getAccountDay($sid,$mouth){
          $dateStart=strtotime($mouth."01");
          $dateEnd=strtotime('+1 month',$dateStart);
          $dateTime=strtotime('-1 days',strtotime(date('Y-m-d 23:59:59')));
          $d=intval(abs($dateEnd-$dateStart)/86400);//计算每个月多少天
          $n=intval(date("j")-1);//本月几号
          $m=intval(substr($mouth, -2,2));
          $Nm=intval(date('m'));
          $t = $Nm > $m ? $d :$n;
          $isMouth = $Nm > $m ? $dateEnd : $dateTime;
          $dayData=Order::getDayOrderInfo($sid,$dateStart,$isMouth);
          $dayArr=array();//把每月的天数组装数组
          for($i=1;$i<=$t;$i++){
              $i = $i>=10 ? $i : "0$i";
              $dayArr[]=substr($mouth,0,4).'-'.substr($mouth, -2,2).'-'.$i;
          }
          $total_price='0.00';//月销售总额
          $dayRes=array();//有数据的天数数组
      
          foreach($dayData as $k => $v){
              $total_price+=$dayData[$k]['total_price'];
              $dayRes[$k]=$v['date'];
          }
          //没有数据的月份，重新组装数组
          foreach ($dayArr as $d){
              if(!in_array($d, $dayRes)){
                  $dayData[$d]['date']=$d;
                  $dayData[$d]['num']='0';
                  $dayData[$d]['total_price']='0.00';
              }
          }
          //对新组装数组进行排序
          $dayData=array_values($dayData);
          $sortVolum=array();
          foreach ($dayData as $key => $row){
              $sortVolum[$key] = $row['date'];
          }
          array_multisort($sortVolum,SORT_DESC,$dayData);
          $returnArr=array();
          $returnArr['dayData']=$dayData;
          $returnArr['total_price']=$total_price;
          return $returnArr;
      }
      
      
  }


