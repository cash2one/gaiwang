<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<div class="audit-type clearfix">
    <p><span class="sign-title" style=" padding-right: 15px;">新增类型</span>新商户</p>
    <p><span class="sign-title" style=" padding-right: 15px;">企业名称</span><?php echo $name?></p>
</div>

<div class="sign-reminder">
    <p><strong>温馨提示(<span>必看</span>)：</strong></p>
    <p>1、请打印下方所示联盟商户合作合同文件，文件浏览完后，请按“打印”，打印该页面所示内容；</p>
    <p>2、《联盟商户合作合同》一式三份合同签署处由法人或授权代表人手写签字并加盖公章有效，再加盖一个合同骑缝章（合同期限由乙方填写为准）；</p>
    <p>3、打印合同在盖章后，请扫描（注意合同扫描为PDF格式文件），感谢配合。</p>
</div>

<div class="c10"></div>

<div class="sign-dl-list">
    <ul>
        <li>
            <a href="<?php echo $this->createUrl('offlineSignContract/printContract',array('contractId'=>$contractId))?>" target="_blank">《联盟商户合作合同》</a>
        </li>
    </ul>
</div>