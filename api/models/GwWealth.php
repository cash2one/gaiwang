<?php
class GwWealth extends ApiModel{

    public $tableName = '{{wealth}}';
    public $primaryKey = 'id';
    
    
    public function machineOrderConsume($moneyRMB,$member,$franchisee,$machineName,$orderCode,$recordId,$ip){
        $score = Common::convertSingle($moneyRMB, $member['type_id']);
        $content = '尊敬的盖网会员：{0}，您在线下加盟商【{1}】所属盖网通【{2}】支付订单【{3}】，共消费￥{4}，使用{5}盖网积分支付';
        $content = str_replace(array('{0}','{1}','{2}','{3}','{4}','{5}'), 
                array($member['gai_number'],$franchisee['franchisee_name'], $machineName, $orderCode,$moneyRMB,$score), $content);
        $wealth = array(
            'owner'=> Wealth::OWNER_MEMBER,
            'member_id'=> $member['id'],
            'gai_number'=> $member['gai_number'],
            'type_id'=> Wealth::TYPE_GAI,
            'score'=> -$score,
            'money'=> -$moneyRMB,
            'source_id'=> Wealth::SOURCE_LINE_CONSUME,
            'target_id'=> $recordId,
            'content'=> $content,
            'create_time'=>time(),
            'ip'=> $ip,
            'status'=>'2',
        );
        $this->insert($wealth);
    }
}

?>