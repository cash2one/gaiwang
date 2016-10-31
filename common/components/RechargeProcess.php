<?php

/**
 * 积分充值处理
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 14-4-19
 * Time: 下午3:00
 */
class RechargeProcess
{

    /**
     * 积分充值处理+流水
     *
     * @param array $data 充值订单数据 Recharge
     * @param array $result 支付平台返回数据，跑数据时候留空
     * @return bool
     */
    public static function operate(Array $data,$result = array())
    {
        // 要充值的会员
        $member = Yii::app()->db->createCommand()->select()->from('{{member}}')->where("id='{$data['member_id']}'")->queryRow();
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();

        $data['pay_time'] = empty($data['pay_time']) ? time() : $data['pay_time'];

        // 要充值的金额
        $money = $data['money'];

        // 会员余额表记录创建
        $arr = array(
            'account_id'=>$member['id'],
            'type'=>AccountBalance::TYPE_CONSUME,
            'gai_number'=>$member['gai_number']
        );
        $memberAccountBalance = AccountBalance::findRecord($arr);
        $bankPayNo = isset($result['payTranNo']) ? '支付平台流水：'.$result['payTranNo'] : '';
        // 会员充值流水 贷 +
        $MemberCredit = array(
            'account_id' => $memberAccountBalance['account_id'],
            'gai_number' => $memberAccountBalance['gai_number'],
            'card_no' => $memberAccountBalance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '使用网银充值,金额为￥'.$money.$bankPayNo,
            'node' => self::nodeSelect($data['pay_type']),
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
            'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
        	'by_gai_number' => empty($data['by_gai_number'])?'':$data['by_gai_number'],
        );
        if($data['pay_type'] == Recharge::PAY_TYPE_POS){
            $MemberCredit['remark'] = '使用POS机刷卡充值,金额为￥'.$money;
        }

        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {

            // 会员账户余额表更新
            AccountBalance::calculate(array('today_amount' => $money), $memberAccountBalance['id']);
            // 借贷流水1.按月
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($MemberCredit));
            //更新充值记录
            Yii::app()->db->createCommand()->update('{{recharge}}',
                array(
                    'status' => Recharge::STATUS_SUCCESS,
                    'pay_time' => $data['pay_time'],
//                    'description' => isset($result['succ']) ? json_encode($_GET) : json_encode($_POST),
                ), "id='{$data['id']}'");

            $transaction->commit();

            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            echo $e->getMessage();
            echo '<pre>';
            echo $e->getTraceAsString();
            $flag = false;
        }
        return $flag;
    }

    /**
     * 根据支付类型，判断流水的业务节点
     * @param int $payType
     * @return string
     */
    public static function nodeSelect($payType){
        switch($payType){
            case Recharge::PAY_TYPE_YINLIANG:
                $node = AccountFlow::BUSINESS_NODE_EBANK_GUANGZHOUYINLIAN;
                break;
            case Recharge::PAY_TYPE_HUXUN:
                $node = AccountFlow::BUSINESS_NODE_EBANK_HUANXUN;
                break;
            case Recharge::PAY_TYPE_YI:
                $node = AccountFlow::BUSINESS_NODE_EBANK_YI;
                break;
            case Recharge::PAY_TYPE_POS:
                $node = AccountFlow::BUSINESS_NODE_EBANK_POS;
                break;
            case Recharge::PAY_TYPE_UM:
                $node = AccountFlow::BUSINESS_NODE_EBANK_UM;
                break;
            case Recharge::PAY_TYPE_UM_QUICK:
                $node = AccountFlow::BUSINESS_NODE_EBANK_UM;
                break;
            case Recharge::PAY_TYPE_TL:
                $node = AccountFlow::BUSINESS_NODE_EBANK_TL;
                break;
            case Recharge::PAY_TYPE_GHT:
                $node = AccountFlow::BUSINESS_NODE_EBANK_GHT;
               break;
            case Recharge::PAY_TYPE_GHTKJ:
                   $node = AccountFlow::BUSINESS_NODE_EBANK_GHT;
                   break;
            case Recharge::PAY_TYPE_GHT_QUICK:
                $node = AccountFlow::BUSINESS_NODE_EBANK_GHT;
               break;
            case Recharge::PAY_TYPE_EBC:
                $node = AccountFlow::BUSINESS_NODE_EBANK_EBC;
                break;
           case Recharge::PAY_TYPE_WEIXIN:
               $node = AccountFlow::BUSINESS_NODE_EBANK_WEIXIN;
               break;
            default:
                $node = '';
        }
        return $node;
    }
} 