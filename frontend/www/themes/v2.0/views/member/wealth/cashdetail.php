<?php $sourceArr = $model::getOperateTypeOther();
$sourceArr[0] = Yii::t('memberWealth', '全部');
$sourceArr = array_reverse($sourceArr, true);
?>

<!--删除收货地址-->

        <div id="err_info" class="delete-pop" style="display: none">
            <div class="address-bg"></div>
            <div class="delete-pop-bg">
                <p class="pop-title">结束时间不能小于开始时间</p>
                <p class="pop-btn">
                    <input id="err_but" style="margin-left: 55px" class="btn-deter" type="button" value="确定" />
                </p>
            </div>
        </div>

<!--删除收货地址结束-->

<div class="main-contain address-receiving">
<div class="withdraw-contents">
    <div class="accounts-box">
        <p class="accounts-title cover-icon"><?php echo Yii::t('wealth', '积分明细查询'); ?></p>
        <div class="withdraw-box">
            <div class="withdraw-time">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createAbsoluteUrl($this->route),
                    'method' => 'get',
                ));
                ?>
                <span class="withdraw-left"><?php echo Yii::t('wealth', '起止日期'); ?>：</span>
                <div class="select-time">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            //'readonly' => 'readonly',
                            'id'=>"date-start"
                        )
                    ));
                    ?>  -  <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'endTime',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            //'readonly' => 'readonly',
                            'id'=>"date-end"
                        )
                    ));
                    ?>
                    <input type="hidden" id="operate_type" name="AccountFlow[operate_type]" />
                    <input type="submit" class="seach-btn" value="查询">
                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <!--<div class="withdraw-status">
                <span class="withdraw-left"><?php /*echo Yii::t('wealth', '类    型'); */?>：</span>
                <div class="select-status">
                    <span><a <?php /*if(isset($_GET['type']) && $_GET['type'] == 2) echo 'style="color:red;"';*/?>
                            href="<?php /*echo Yii::app()->createAbsoluteUrl('/member/wealth/cashDetail',array('type'=>2)) */?>"><?php /*echo Yii::t('wealth', '冻结'); */?></a></span>
                </div>
            </div>-->
            <div class="withdraw-search">
                <span class="withdraw-left"><?php echo Yii::t('wealth', '积分来源'); ?>：</span>
                <div class="select-status">
                    <!--<span class="on"><?php /*echo Yii::t('wealth', '全部'); */?></span>-->
                    <?php foreach($sourceArr as $key => $value){ ?>
                    <span class="source_arr" values="<?php if($key > 0) echo $key; ?>" <?php
                    if($key < 1){
                        if(!isset($_GET['AccountFlow']['operate_type']) || $_GET['AccountFlow']['operate_type'] == 0) echo 'style="color:red;"';
                    }elseif($key > 0){
                        if(isset($_GET['AccountFlow']['operate_type']) && $_GET['AccountFlow']['operate_type'] == $key) echo 'style="color:red;"';
                    } ?> ><?php echo Yii::t('wealth', $value); ?></span>

                    <?php } ?>
                </div>
            </div>

            <table class="consume-table" border="0" >
                <tr class="consume-title">
                    <td class="table-time"><?php echo Yii::t('wealth', '发生时间'); ?></td>
                    <td class="table-message"><?php echo Yii::t('wealth', '明细说明'); ?></td>
                    <td class="table-money"><?php echo Yii::t('wealth', '金额'); ?></td>
                    <td class="table-types"><?php echo Yii::t('wealth', '类型'); ?></td>
                    <td class="table-source"><?php echo Yii::t('wealth', '积分来源'); ?></td>
                    <td class="table-member"><?php echo Yii::t('wealth', '充值者'); ?></td>
                </tr>

                <?php $wealth = $model->search(); ?>
                <?php if ($weathsData = $wealth->getData()){ ?>
                <?php foreach ($weathsData as $v): ?>
                <tr>
                    <td valign="top"><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                    <td valign="top" class="table-left"><?php
                        echo strtr(AccountFlow::formatContent($v['remark']), array(
                            '订单' => '订单(' . $v['order_code'] . ')',
                        ));
                        ?></td>
                    <td valign="top"><b><?php echo AccountFlow::showPrice($v['credit_amount'], $v['debit_amount']); ?></b></td>
                    <td valign="top"><?php echo AccountFlow::showType($v['type']); ?></td>
                    <td valign="top"><?php echo AccountFlow::showOperateType($v['operate_type']); ?></td>
                    <td valign="top"><?php echo $v['by_gai_number'] ?></td>
                </tr>
                <?php endforeach; ?>

                <?php
                }else{ ?>
                <tr><td valign="top" colspan="6"><?php echo Yii::t('wealth','暂无数据') ?></td></tr>
                <?php  } ?>

            </table>

            <div class="pageList clearfix">

                <?php
                $this->widget('SLinkPager', array(
                    'header' => '',
                    'cssFile' => false,
                    'firstPageLabel' => Yii::t('page', '首页'),
                    'lastPageLabel' => Yii::t('page', '末页'),
                    'prevPageLabel' => Yii::t('page', '上一页'),
                    'nextPageLabel' => Yii::t('page', '下一页'),
                    'maxButtonCount' => 13,
                    'pages' => $wealth->pagination,
                    'htmlOptions'=>array(
                        'class'=>'yiiPageer',   //包含分页链接的div的class
                        'id' => 'yw0'
                    )
                ));
                ?>
            </div>
        </div>
    </div>

</div>
</div>

<script>
    $(function(){
        $('.source_arr').each(function(i){
            var url = "<?php
                    if(isset($_GET["AccountFlow"]['create_time']) && isset($_GET["AccountFlow"]['endTime'])){
                        echo $this->createAbsoluteUrl('cashdetail',array('AccountFlow[create_time]'=>$_GET["AccountFlow"]['create_time'],'AccountFlow[endTime]'=>$_GET["AccountFlow"]['endTime'])).'&';
                    }else{
                    echo $this->createAbsoluteUrl('cashdetail').'?';
                    }
             ?>";
            $(this).click(function(){
                var value = $(this).attr('values');
                $('#operate_type').val(value);
                window.location = url+"AccountFlow[operate_type]="+value;
            });
        });



        $('#date-end').change(function(){
            var start = $('#date-start').val();
            var end =   $('#date-end').val();
            if(start != ''){
                if(end < start){
                    $('#err_info').css('display','block');
                }
            }
        })

        $('#date-start').change(function(){
            var start = $('#date-start').val();
            var end =   $('#date-end').val();
            if(end != ''){
                if(end < start){
                    $('#err_info').css('display','block');
                }
            }
        })

        $('#err_but').click(function(){
            $('#err_info').css('display','none');
            $('#date-end').focus();
        })


    })
</script>