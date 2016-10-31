<div class="account_right">
    <div class="line table_white" style="margin: 10px">
         <?php 
            Yii::app()->clientScript->registerScript('search', "
                $('#applylist-search-form').submit(function(){
                        $('#applylist-grid').yiiGridView('update', {
                                data: $(this).serialize()
                        });
                        return false;
                });
            ");
        ?>
        
        <?php 
            $form = $this->beginWidget('CActiveForm',array(
                'id' => 'applylist-search-form',
                'action' => $this->createUrl($this->route),
                'method' => 'get',
            ));
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
            <tr class="table1_title">
                <td colspan="8"><?php echo Yii::t('Member','申请列表')?>(<?php echo $model->search()->totalItemCount?>)</td>
            </tr>
            <tr>
                <td colspan="8" class="table_search">
                    <div class="form_search">
                        <p><?php echo Yii::t('Member','企业会员名称')?>：</p>
                        <?php echo $form->textField($model,'apply_name',array('class'=>'search_box3'))?>
                        <?php echo CHtml::submitButton('',array('class'=>'search_button3'))?>
                    </div>
                </td>
            </tr>
        </table>
        <?php $this->endWidget();?>
    
        <?php 
            $this->widget('application.modules.agent.widgets.grid.GridView',array(
                'id'=>'applylist-grid',
                'itemsCssClass' => 'table1',
                'dataProvider' => $model->search(),
                'pagerCssClass' => 'line pagebox',
            	'template' => '{items}{pager}',
                'columns' => array(
                    array(  //申请类型
                        'htmlOptions' => array('class' => 'tc'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'name' => Yii::t('Member','申请类型'),
                        'value' => 'Auditing::getApplyType($data->apply_type)',
                    ),
                    array(  //企业会员名称
                        'htmlOptions' => array('class' => 'tc'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'name' => Yii::t('Member','企业会员名称'),
                        'value' => '$data->apply_name',
                    ),
                    array(  //创建时间
                        'htmlOptions' => array('class' => 'tc'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'name' => Yii::t('Member','创建时间'),
                        'value' => 'date("Y-m-d H:i:s",$data->create_time)',
                    ),
                    array(  //申请时间
                        'htmlOptions' => array('class' => 'tc'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'name' => Yii::t('Member','申请时间'),
                        'value' => 'date("Y-m-d H:i:s",$data->submit_time)',
                    ),
                    array(  //申请状态
                        'htmlOptions' => array('class' => 'tc'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'name' => Yii::t('Member','申请状态'),
                        'value' => 'Auditing::getStatus($data->status)',
                    ),
                    array(  //操作
                        'class'=>'CButtonColumn',
                        'header' => Yii::t('Member','操作'),
                        'headerHtmlOptions' => array('class' => 'tabletd tc'),
                        'htmlOptions' => array('class' => 'tc'),
                        'template' => '{update}',
                        'buttons'=>array(
                            'update' => array(
                                'label' => Yii::t('Member','【查看】'),
                                'url' => 'Yii::app()->controller->createUrl("storeEdit", array("id"=>$data->primaryKey))',
                                'imageUrl' => false,
                                'style' => '12',
                            ),
                        ),
                    ),
                )
            ));
        ?>
    </div>
</div>
