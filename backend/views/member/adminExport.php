<?php
/* @var $this MemberController */
/* @var $model Member */
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '会员列表',
    'cssFile' => false,
    'columns' => array(
        'gai_number',
        'username',
		'real_name',
        'mobile',
        array(
            'name' => 'type_id',
            'value' => '$data->type_id',
        ),
        array(
            'header' => Yii::t('member', '地区'),
            'value' => 'Region::getName($data->province_id,$data->city_id,$data->district_id)',
        ),
        array(
            'header' => Yii::t('member', '消费账户余额'),
            'value' => '"<span class=\"jf\">¥".$data->getTotalPrice(AccountBalance::TYPE_CONSUME,$data->id,$data->gai_number)."</span>"',
            'type' => 'raw'
        ),
        array(
            'name' => 'register_time',
            'value' => 'date("Y-m-d H:i:s",$data->register_time)',
        ),
//        array(
//            'name' => 'is_enterprise',
//            'type' => 'raw',
//            'value' => '$data->is_enterprise ? Member::isEnterprise($data->is_enterprise) :
//            CHtml::link("升级",array("member/storeUpdate/id/".$data->id),array("class"=>"reg-sub"))',
//        ),
        array(
            'header' => Yii::t('member', '无主'),
            'value' => 'empty($data->referrals_id) ? Yii::t("member","是"):Yii::t("member","否")',
        ),
        array(
            'name' => 'is_internal',
            'value' => '$data->is_internal==Member::INTERNAL ? Yii::t("member","是"):Yii::t("member","否")',
        ),
        array(
            'name' => 'register_type',
            'value' => 'Member::registerType($data->register_type)',
        ),
    ),
));
?>


