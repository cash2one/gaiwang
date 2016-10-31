<?php
/* @var $this  InterestController */
/** @var $model Interest */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberInterest', '账号管理') => array('home/index'),
    Yii::t('memberInterest', '兴趣爱好'),
);
?>
<style>
    .mbDate1 .mbDate1_c table a.mbDateBox {
        display: none;
    }

    .mbDate1 .mbDate1_c .interest .on, .interest a.mbDateBox:hover {
        background: none repeat scroll 0 0 #FFBBBB;
        border: 1px solid #CC0000;
        color: #000000;
        display: block;
    }

</style>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li>
                <?php
                $memberBase = $this->getSession('enterpriseId') ? Yii::t('memberInterest', '企业基本信息') : Yii::t('memberInterest', '用户基本信息');
                echo CHtml::link('<span>' . $memberBase . '</span>',
                    $this->createAbsoluteUrl('/member/site/index'))
                ?>
            </li>
            <li><?php echo CHtml::link('<span>' . Yii::t('memberInterest', '头像设置') . '</span>', $this->createAbsoluteUrl('/member/member/avatar')) ?></li>
            <li class="curr"><?php echo CHtml::link('<span>' . Yii::t('memberInterest', '兴趣爱好') . '</span>', '#') ?></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <!--end 头像及基本信息-->
        <?php $this->renderPartial('/layouts/_summary'); ?>
        <!--end 头像及基本信息-->
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">

                <h3 class="mgleft45 mgtop10"><?php echo Yii::t('memberInterest', '兴趣爱好');?></h3>

                <p class="mgleft45"><?php echo Yii::t('memberInterest','填写兴趣爱好能让盖网更了解您，从而提供更切合的服务。')?></p>
                <?php foreach ($interestCat as $k => $v):?>
                    <table width="890" border="0" cellpadding="0" cellspacing="0" class="mbDateBd mgleft45">
                        <tbody>
                        <tr>
                            <td width="153" height="35"><b><?php echo Yii::t('memberInterest',$v->name) ?></b></td>
                            <td width="620" height="35">&nbsp;</td>
                            <td width="117" height="35" align="right">
                                <?php echo CHtml::dropDownList('show', $this->checkSelected($v->id), MemberProfile::show(),
                                    array('data-cid' => $v->id)) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="890" border="0" cellpadding="0" cellspacing="0" class="mgleft45">
                        <tbody>
                        <tr>
                            <td width="42" class="pdleft45">&nbsp;</td>
                            <td width="679" class="pdleft45 interest">
                                <?php foreach ($v->interest as $k2 => $v2) {
                                    echo CHtml::link(Yii::t('memberInterest',$v2->name), '#', array(
                                        'class' => $this->checkSelected($v->id, $v2->id) ? 'mbDateBox on' : 'mbDateBox',
                                        'data-id' => $v2->id,
                                        'data-cid' => $v->id));
                                }
                                ?>
                            </td>
                            <td width="45" height="35"></td>
                            <td width="91" height="35" align="center" valign="top">
                                <?php echo CHtml::link(Yii::t('memberInterest','确定'), '#', array(
                                    'class' => 'mbDateqd mgleft45 submit',
                                    'data-id' => $v->id,
                                    'style' => 'display:none',
                                )) ?>
                                <?php echo CHtml::link(Yii::t('memberInterest','编辑'), '#', array(
                                    'class' => 'mbDateqd_1 mgleft45 edit',
                                    'data-id' => $v->id,
                                )) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
            <div class="mbDate1_b"></div>

        </div>
    </div>
</div>

<script>
    //点击选择效果
    $(".mbDateBox").click(function () {
        var cid = $(this).attr('data-cid');
        var submit = $(".submit[data-id="+cid+"]:visible");
       if(submit.length==0) return false; //非编辑状态，直接返回
        if ($(this).hasClass('on')) {
            $(this).removeClass('on');
            $(this).show();
        } else {
            $(this).addClass('on');
        }
        return false;
    });
    //ajax 提交选择
    $(".submit").click(function () {
        var that = $(this);
        var cid = $(this).attr('data-id');
        var show = $("select[data-cid=" + cid + "]").find("option:selected").val();
        var selectedInterest = $(".on[data-cid=" + cid + "]");
        if (selectedInterest.length == 0) return false;
        var ids = [];
        selectedInterest.each(function (index, obj) {
            ids.push($(obj).attr('data-id'));
        });
        ids = ids.join(',');
        var url = "<?php echo $this->createAbsoluteUrl('update') ?>";
        var data = {ids: ids, cid: cid, show: show, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"};
        $.post(url, data, function (msg) {
            if (msg == 'ok') {
                $(".mbDateBox[data-cid=" + cid + "]").hide();
                $(".on").show();
                that.hide();
                $(".edit[data-id=" + cid + "]").show();
            }
        });
        return false;
    });
    //点击编辑
    $(".edit").click(function () {
        var cid = $(this).attr('data-id');
        $(this).hide();
        $(".mbDateBox[data-cid=" + cid + "]").show();
        $(".submit[data-id=" + cid + "]").show();
        return false;
    });
</script>