<?php
$config = array(
    '专题活动管理' => array(
        '列表' => 'SpecialTopic.Admin',
        '添加' => 'SpecialTopic.Create',
        '修改' => 'SpecialTopic.Update',
        '删除' => 'SpecialTopic.Delete',
        '查看分类' => 'SpecialTopicCategory.Admin',
        '添加分类' => 'SpecialTopicCategory.Create',
        '编辑分类' => 'SpecialTopicCategory.Update',
    ),
    '充值红包活动' => array(
        '列表' => 'RedEnvelopeActivity.Admin',
        '添加充值红包' => 'RedEnvelopeActivity.Create',
        '添加金额' => 'RedEnvelopeActivity.AddHongBaoAmount',
        '金额添加历史' => 'RedEnvelopeActivity.CommonAccountlog',
        '修改日期' => 'RedEnvelopeActivity.UpdateValidEnd',
        '暂停领取' => 'RedEnvelopeActivity.StatusChange',
    ),
    '红包活动商品标签' => array(
        '列表' => 'RedActivityTag.Admin',
        '添加活动标签' => 'RedActivityTag.Create',
        '修改状态' => 'RedActivityTag.StatusChange',
        '标签重命名' => 'RedActivityTag.UpdateName',
        '修改比例' => 'RedActivityTag.UpdateRatio',
    ),
    '红包补偿' => array(
        '列表' => 'RedCompensation.Admin',
        '红包补偿' => 'RedCompensation.Create',
        '红包批量补偿' => 'RedCompensation.BatchCreate',
    ),
    '红包兑换管理' => array(
        '列表' => 'RedCompensation.ExchangeCode',
        '录入兑换码' => 'RedCompensation.EntryPage',       
    ),
);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>



