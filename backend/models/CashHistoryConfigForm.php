<?php
/**
 * 商家提现白名单配置模型
 * @author wyee <yanjie.wang@g-emall.com>
 * Date: 2016/08/24
 * Time: 15:00
 */

class CashHistoryConfigForm extends CFormModel {

    public $whiteList;

    public function rules() {
        return array(
            array('whiteList','required'),
        );
    }

    public function attributeLabels() {
        return array(
            'whiteList'=>'白名单',
        );
    }
} 