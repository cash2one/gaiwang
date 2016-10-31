<?php
$baseUrl = AGENT_DOMAIN . '/agent';
Yii::app()->clientScript->registerScriptFile($baseUrl . "/js/common.js"); 
?>
<div class="account_right">
    <div class="line table_white" style="margin:10px">
        <table width="100%" cellspacing="0" cellpadding="0" class="table1">
            <tr class="table1_title">
                <td colspan="7"><?php echo Yii::t('Agent', '代理进账明细') ?></td>
            </tr>
            <tr>
                <td colspan="7" class="table_search">
                    <?php
                    Yii::app()->clientScript->registerScript('search', "
				$('#account-search').submit(function(){
					$('#account-grid').yiiGridView('update', {
						data: $(this).serialize()
					});
					return false;
				});
				");
                    ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'account-search',
                        'action' => $this->createUrl($this->route),
                        'method' => 'get',
                    ));
                    ?>
                    <div class="form_search">
                        <label for="textfield"></label>
                        <p><?php echo Yii::t('Agent', '账单时间') ?>：</p>
                        <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'id' => 'createtime',
                            'cssClass' => 'datefield search_box3',
                            'model' => $model,
                            'name' => 'create_time',
                            'select' => 'date',
                        ));
                        ?>
                        <p style="margin-left:10px">─</p> 
                        <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'id' => 'endtime',
                            'cssClass' => 'datefield search_box3',
                            'model' => $model,
                            'name' => 'endTime',
                            'select' => 'date',
                        ));
                        ?>
                        <?php echo CHtml::submitButton("", array("class" => "search_button3")) ?>
                        <?php echo CHtml::button(Yii::t('Agent', '导出Excel'), array("class" => "btn1 btn_large13 fl", "onclick" => "exportExcel()")) ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $this->widget('application.modules.agent.widgets.grid.GridView', array(
                        'id' => 'account-grid',
                        'itemsCssClass' => 'table1',
                        'dataProvider' => $model->searchAgent(),
                        'template' => '{items}{pager}',
                        'pagerCssClass' => 'line pagebox',
                        'columns' => array(
                            array(//账单时间
                                'htmlOptions' => array('class' => 'tc'),
                                'headerHtmlOptions' => array('class' => 'tabletd tc'),
                                'name' => Yii::t('Agent', '账单时间'),
                                'value' => 'date("Y-m-d H:i:s",$data["create_time"])',
                            ),
                            array(//金额
                                'htmlOptions' => array('class' => 'tc'),
                                'headerHtmlOptions' => array('class' => 'tabletd tc'),
                                'name' => Yii::t('Agent', '金额'),
                                'value' => '"¥".$data["credit_amount"]',
                            ),
                            array(//积分
                                'htmlOptions' => array('class' => 'tc'),
                                'headerHtmlOptions' => array('class' => 'tabletd tc'),
                                'name' => Yii::t('Agent', '积分'),
                                'value' => '$data["ratio"] == 0 ? 0 : IntegralOfflineNew::getNumberFormat($data["credit_amount"]/$data["ratio"])',
                            ),
                            array(//备注
                                'htmlOptions' => array('class' => 'tc'),
                                'headerHtmlOptions' => array('class' => 'tabletd tc'),
                                'name' => Yii::t('Agent', '备注'),
                                'value' => '$data["remark"]',
                            ),
                        )
                    ))
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
//导出excel
    function exportExcel() {
        var createtime = $('#createtime').val();
        var endtime = $('#endtime').val();
        var url = createUrl("<?php echo $this->createUrl('gwdetail/exportExcel') ?>", {"createtime": createtime, "endtime": endtime});
        window.open(url);
    }
    function subPageJump(obj){var n=$(obj).children("input").val(); n = parseInt(n); if(n>0) $(obj).parent().prev("li").children("a").attr("href",$(obj).parent().attr("jumpUrl")+n)[0].click();}
</script>