<?php

/* @var $this MemberController */
/* @var $model Member */

$this->renderPartial('_search', array('model' => $model));
?>

<?php

$params2 = array(
    'template' => '{update}{resetPass}{updateRecommend}',
    'buttons' => array(
        'resetPass' => array(
            'label' => '重设密码',
            'url' => 'Yii::app()->createUrl("member/resetPass",array("id"=>$data->id))',
            'visible' => 'Yii::app()->user->checkAccess("Member.ResetPass") && $data->role==$data::ROLE_ONLINE',
            'options' => array(
                'class' => 'regm-sub',
                'style' => 'width:83px; background: url("images/sub-fou.gif");',
                'onclick' => 'return confirm("' . Yii::t('member', '将会重新设定随机密码，并且发送短信到用户手机上，确定重设吗?') . '")',
            ),
        ),
        'updateRecommend' => array(
            'label' => '设推荐人',
            'url' => 'Yii::app()->createUrl("member/updateRecommend",array("id"=>$data->id))',
            'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
            'visible' => 'Yii::app()->user->checkAccess("Member.UpdateRecommend")',
        ),
    ),
);

$params1 = array(
    'class' => 'CButtonColumn',
    'header' => Yii::t('home', '操作'),
    'template' => '{update}{delete}',
    'updateButtonLabel' => Yii::t('home', '编辑'),
    'updateButtonImageUrl' => false,
    'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->id,"action"=>Yii::app()->request->getParam("r")))',
    'deleteButtonImageUrl' => false,
    'buttons' => array(
        'update' => array(
            'label' => Yii::t('user', '编辑'),
            'visible' => 'Yii::app()->user->checkAccess("Member.Update") && $data->role==$data::ROLE_ONLINE'
        ),
    )
);
$params = CMap::mergeArray($params1, $params2);
$this->widget('GridView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->search($this->auditing),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'gai_number',
        'username',
        'mobile',
        array(
            'name' => 'type_id',
            'value' => '$data->type_id',
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
//            'header' => Yii::t('member', '商家'),
//            'type' => 'raw',
//            'value' => '
//			        $data->enterprise_id>0 ? Member::isEnterprise($data->enterprise_id)
//			        :(Yii::app()->user->checkAccess("Enterprise.Update")
//			        ? CHtml::link("升级",array("enterprise/update","id"=>$data->id,"action"=>Yii::app()->request->getParam("r")),array("class"=>"reg-sub"))
//			        : Member::isEnterprise($data->enterprise_id))
//			    ',
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
        array(
            'name' => 'is_master_account',
            'value' => 'Member::masterAccount($data->is_master_account)'
        ),
        $params,
    ),
));
?>


<?php

$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>

