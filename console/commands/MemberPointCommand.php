<?php
/**
 * Created by PhpStorm.
 * User: Gatewang
 * Date: 2016/8/18
 * Time: 16:16
 */
class MemberPointCommand extends CConsoleCommand {
		public function  actionRun(){
				try {
					set_time_limit(3000);
					//获取重置积分数据
					$MemberPointData = Yii::app()->db->createCommand()
											->select("id,day_limit_point,month_limit_point,day_point,month_point,update_time")
											->from(MemberPoint::model()->tableName())
											->queryAll();
					$sqlArr = array();
					$time = time();
					$num = 0;
					$id = "";
					$mid ="";
					$dayPointWhere = "";
					$monthPointWhere = "";
					foreach ($MemberPointData as $dataKey=>$dataVal){
						$num++;
						$id .= $dataVal["id"].",";
						//判断最后一次更新时间  新日时更新日额度，新月时更新月额度
						//更新日额度
						if($time > $dataVal["update_time"]){
							$dayPointWhere .= " when {$dataVal["id"]} then {$dataVal["day_point"]} ";
						}
							
						//月额度更新
						if(date("Y") == date("Y",$dataVal["update_time"])){
							if(date("m") > date("m",$dataVal["update_time"])){
							$mid .= $dataVal["id"].",";
							$monthPointWhere .= " when {$dataVal["id"]} then {$dataVal["month_point"]} ";
						}
						}else if($date("Y") > date("Y",$dataVal["update_time"])){
							$mid .= $dataVal["id"].",";
							$monthPointWhere .= " when {$dataVal["id"]} then {$dataVal["month_point"]} ";
						}
						
						
						if((($num % 80000) == 0) || ($dataKey == (count($MemberPointData) - 1))){
							$id = substr($id,0,-1);
							$sql = "UPDATE gw_member_point SET
							day_limit_point = CASE id
							{$dayPointWhere}
							END,
							update_time = {$time}
							where id in ({$id})";
							if($monthPointWhere != ""){
								$mid = substr($mid,0,-1);
									$sqlmonth = "UPDATE gw_member_point SET
									month_limit_point = CASE id
									{$monthPointWhere}
									END,
									update_time = {$time}
									where id in ({$mid})";
						            array_push($sqlArr, $sqlmonth);
							}
							$num = 0;$id = "";$dayPointWhere = "";$monthPointWhere = "";$mid="";
							array_push($sqlArr, $sql);
						}
					}

					$transaction = Yii::app()->db->beginTransaction();
					foreach ($sqlArr as $sqlVal){
					     Yii::app()->db->createCommand($sqlVal)->execute();
					}
					$transaction->commit();
					echo "更新成功";
				} catch (Exception $e) {
					$transaction->rollBack();
					echo $e->getMessage();
				}
				
				
			}
}