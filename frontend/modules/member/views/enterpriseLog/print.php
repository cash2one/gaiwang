<?php
//网签
/** @var $enterprise Enterprise */
/** @var $form CActiveForm */
/** @var EnterpriseData $enterpriseData */
$this->breadcrumbs = array(
    Yii::t('memberMember', '打印合同') => '',
);
?>
<style>
    #tips,#tips li{
        list-style: decimal;
    }
    #tips li{
        line-height: 30px;
        margin-left: 30px;
    }
    #printList li{
        line-height: 20px;
        margin-left: 30px;
    }
    #printList{
        margin:20px;
    }
    #printList a{
        color:#005aa0;
    }
    #printList li{
        background:url(data:image/png;base64,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) no-repeat left center;
        padding:0 0 0 20px;
        margin:10px;
    }
</style>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr">
                <a href="javascript:;">
                    <span><?php echo Yii::t('memberMember', '打印网络店铺签约合同'); ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">
        <div class="mbDate">
            <div class="mbDate_t"><strong>温馨提示（必看）</strong>：</div>
            <div class="mbDate_c clearfix">
                <ol id="tips">
                    <li>请打印所有网络店铺签约合同文件；每份文件浏览完后，请按“打印”，打印该页面所示内容；</li>
                    <li>《盖网通格子铺租赁及网店开设合同2015》一式两份合同签署处由法人手写签字有效，合同乙方付款信息处盖章，合同乙方法人签字处盖章，再加盖一个齐缝章（合同期限由甲方填写）；</li>
                    <li>《网店管理规范网店管理规范及商城商品合作结算流程》一式2份盖章；</li>
<!--                    <li>《承诺书2014》填写打印2份盖章；</li>
                    <li>自有品牌承诺书2014》填写打印2份盖章；</li>-->
                    <li>由商家提供的公司资质证件、检测报告等各打印一份；</li>
                    <li>以上盖章后随合同及附件一起寄给商城招商部；商城招商部地址：广州市越秀区东风东路767号东宝大厦21楼。</li>
                </ol>
            </div>
            <div class="mbDate_b">
            </div>
        </div>
        <div>
            <ul id="printList">
                <?php
                $url = 'enterpriseLog/printView';
                $file =  'contractstore';
                ?>
                <li><?php echo CHtml::link('盖网通格子铺租赁及网店开设合同',array($url,'file'=>$file),array('target'=>'_blank')); ?></li>
                <li><?php echo CHtml::link('网店管理规范及合作结算流程',array($url,'file'=>'management'),array('target'=>'_blank')); ?></li>
                <li><?php // echo CHtml::link('商城商品合作及结算流程',array($url,'file'=>'settlement'),array('target'=>'_blank')); ?></li>
                <li><?php // echo CHtml::link('承诺书',array($url,'file'=>'commitment'),array('target'=>'_blank')); ?></li>
                <li><?php // echo CHtml::link('自有品牌承诺书',array($url,'file'=>'commitment2'),array('target'=>'_blank')); ?></li>
                <li><?php echo CHtml::link('您已上传的资质证明文件',array($url,'file'=>'pic'),array('target'=>'_blank')); ?></li>
            </ul>
        </div>
    </div>
</div>
