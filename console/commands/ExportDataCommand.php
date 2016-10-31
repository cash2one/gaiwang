<?php
/**
 * 月销售额利润
 */
class ExportDataCommand extends CConsoleCommand
{
	public function actionAccount()
	{
        try {
            /**
             *
             *
             *
             *线上销售额
             *
            SELECT COUNT(id),FROM_UNIXTIME(pay_time,'%Y%m') as c_month,SUM(pay_price),SUM(other_price),
            if(pay_type=1,1,0) as is_point
            from gw_order
            WHERE status=2 and delivery_status=4
            GROUP BY c_month,is_point;

            SELECT COUNT(id),FROM_UNIXTIME(pay_time,'%Y%m') as c_month,SUM(total_price),
            if(pay_type=1,1,0) as is_point
            from gw_hotel_order
            WHERE status=2 and pay_status=1
            GROUP BY c_month,is_point;
             *
             *
             * 线上,线下利润

            SELECT SUM(credit_amount),if(node in (0212,1011) ,1,2) as line_type
            from gw_account_flow_201501
            WHERE node in(0212,1011,1914,2514,1919) GROUP BY line_type;

            SELECT SUM(credit_amount),if(node in (0212,1011) ,1,2) as line_type
            from gw_account_flow_201502
            WHERE node in(0212,1011,1914,2514,1919) GROUP BY line_type;


            SELECT SUM(credit_amount),if(node in (0212,1011) ,1,2) as line_type
            from gw_account_flow_201503
            WHERE node in(0212,1011,1914,2514,1919) GROUP BY line_type;


            SELECT SUM(credit_amount),if(node in (0212,1011) ,1,2) as line_type
            from gw_account_flow_201504
            WHERE node in(0212,1011,1914,2514,1919) GROUP BY line_type;
             *
             *
             * 线下销售额
            SELECT SUM(r.spend_money),FROM_UNIXTIME(r.create_time,'%Y%m') as c_month
            from gw_franchisee_consumption_record_confirm as c
            LEFT JOIN gw_franchisee_consumption_record as r on c.record_id=r.id
            WHERE c.`status`=1
            GROUP BY c_month
             */
            $s_time = time(); //开始时间
            $command = Yii::app()->db->createCommand("");
            $command->execute();
            $reader = $command->query();
            foreach($reader as $row){

            }
            $i = 1;
            echo 'update '.$i.', use '.(time() - $s_time);

        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
	}

}