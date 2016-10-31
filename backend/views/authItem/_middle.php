<?php

$config = array(
    '居间商管理' => array(
        '居间商列表'=>'MiddleAgent.admin',
        '商家详细信息'=>'MiddleAgent.viewStore',
        '商家销售额'=> 'MiddleAgent.viewPay',
        '查看直招商户' => 'MiddleAgent.partner',
        '查看记录明细'  => 'MiddleAgent.viewMonth',
        '添加居间商'   => 'MiddleAgent.create',
        '添加直招商户'   => 'MiddleAgent.createPartner',
        '删除'   => 'MiddleAgent.delete',
        '编辑'   => 'MiddleAgent.update',
    )
);

$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));