<?php
/* @var $this MemberController */
/* @var $model Member */
?>
<?php $this->renderPartial('_searchenterprise', array('model' => $model)); ?>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->enterprise(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'gai_number',
        'username',
        'mobile',
        array(
            'name' => 'type_id',
            'value' => 'isset($data->memberType) ? $data->memberType->name:""'
        ),
        array(
            'name' => 'referrals_id',
            'value' => 'isset($data->referrals) ? $data->referrals->gai_number : ""'
        ),
        array(
            'name' => 'register_time',
            'value' => 'date("Y-m-d H:i:s", $data->register_time)',
        ),
        array(
            'header' => Yii::t('member', '可提现金额'),
            'value' => '"<span class=\"jf\">¥".$data->getTotalCash($data->id)."</span>"',
            'type' => 'raw'
        ),
        array(
            'name' => 'register_type',
            'value' => 'Member::registerType($data->register_type)',
        ),
        array(
            'name' => 'enterprise_id',
            'value' => 'isset($data->enterprise) ? $data->enterprise->name:""'
        ),
        array(
            'name' => 'status',
            'value' => 'Member::status($data->status)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{resetPass}{bank}{updateRecommend}{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'resetPass' => array(
                    'label' => Yii::t('member', '重置密码'),
                    'url' => 'Yii::app()->createUrl("member/resetPass", array("id" => $data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("Member.ResetPass")',
                    'options' => array(
                        'class' => 'regm-sub',
                        'style' => 'width:83px; background: url("images/sub-fou.gif");',
                        'onclick' => 'return confirm("' . Yii::t('member', '将会重新设定随机密码，并且发送短信到用户手机上，确定重设吗?') . '")',
                    ),
                ),
                'bank' => array(
                    'label' => Yii::t('member', '银行帐号'),
                    'url' => 'Yii::app()->createUrl("bankAccount/edit", array("memberId" => $data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("BankAccount.Edit")',
                    'options' => array(
                        'class' => 'regm-sub',
                        'style' => 'width:83px; background: url("images/sub-fou.gif");',
                    ),
                ),
                'updateRecommend' => array(
                    'label' => Yii::t('member', '设推荐人'),
                    'url' => 'Yii::app()->createUrl("member/updateRecommend",array("id" => $data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("Member.UpdateRecommend")',
                    'options' => array(
                        'class' => 'regm-sub',
                        'style' => 'width:83px; background: url("images/sub-fou.gif");',
                    ),
                ),
                'update' => array(
                    'label' => Yii::t('member', '企业信息'),
                    'url' => 'Yii::app()->createUrl("enterprise/update", array("id" => $data->enterprise_id))',
                    'visible' => 'Yii::app()->user->checkAccess("Enterprise.Update")',
                    'options' => array(
                        'class' => 'regm-sub',
                        'style' => 'width:83px; background: url("images/sub-fou.gif");',
                    ),
                ),
            )
        )
    ),
));


$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>