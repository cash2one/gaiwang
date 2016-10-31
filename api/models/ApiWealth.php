<?php
class ApiWealth extends ApiModel{

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
    
    public static function addWealth_gtDeduct($moneyRMB,$score, $member,$franchisee,$recordId){
        $now = time();
        // 记录
        $content = '尊敬的盖网会员：{gai_number}，您在线下加盟商{franchisee_name}的盖网机{franchisee_name}处消费￥{money}，使用{score}盖网积分支付。';
        $content = str_replace(array('{gai_number}','{franchisee_name}','{money}','{score}'), array($member['gai_number'],$franchisee['name'],$moneyRMB,$score), $content);
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
            'create_time'=>$now,
            'ip'=> Tool::ip2int(Yii::app()->request->getUserHostAddress()),
            'status'=>'2',
        );
        Yii::app()->db->createCommand()->insert('{{wealth}}', $wealth);
    }
    
    public static function addWealth_gtIncome($member,$cardNum,$card){
        $now = time();
        // 记录
        $content = '{gai_number}使用充值卡{cardNum}充值{score}盖网积分，此积分为不可兑现的盖网积分。';
        $content = str_replace(array('{gai_number}','{cardNum}','{score}'), array($member['gai_number'],$cardNum,$card['score']), $content);
        $wealth = array(
            'owner'=> Wealth::OWNER_MEMBER,
            'member_id'=> $member['id'],
            'gai_number'=> $member['gai_number'],
            'type_id'=> Wealth::TYPE_GAI,
            'score'=> $card['score'],
            'money'=> $card['money'],
            'source_id'=> Wealth::SOURCE_PREPAID_CARD,
            'target_id'=> $card['cardId'],
            'content'=> $content,
            'create_time'=>$now,
            'ip'=> Tool::ip2int(Yii::app()->request->getUserHostAddress()),
            'status'=>'2',
        );
        Yii::app()->db->createCommand()->insert('{{wealth}}', $wealth);
    }
    
}

?>