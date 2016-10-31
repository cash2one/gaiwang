<?php
/**
 * 代扣配置模型
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2014/11/15
 * Time: 10:50
 */

class HistoryBalanceConfigForm extends CFormModel {

    public $currentPay;
    public $bestCardNumbers;

    public function rules() {
        return array(
            array('currentPay,bestCardNumbers','required'),
        );
    }

    public function attributeLabels() {
        return array(
            'currentPay'=>'当前使用接口',
            'bestCardNumbers'=>'银行卡号',
        );
    }
} 