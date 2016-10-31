<style>
    #agentmember-grid table{width:100%;cellspacing:0;cellpadding:0;}
    a {color: #666666; }
</style>
<div class="line table_white" style="margin: 10px;">
    <?php $this->renderPartial('_search',array('model'=>$model));?>
    
    <?php 
//        Yii::app()->clientScript->registerScript('search', "
//            $('#agentmember-search-form').submit(function(){
//                    $('#agentmember-grid').yiiGridView('update', {
//                            data: $(this).serialize()
//                    });
//                    return false;
//            });
//        ");
    ?>
    
    <?php 
        $this->widget('application.modules.agent.widgets.grid.GridView',array(
            'id'=>'agentmember-grid',
            'itemsCssClass' => 'table1',
            'dataProvider' => $model->search(),
            'pagerCssClass' => 'line pagebox',
        	'template' => '{items}{pager}',
            'columns' => array(
                array(  //会员编号
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'gai_number',
                    'value' => '$data->gai_number',
                ),
                array(  //用户名
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'username',
//                    'value' => '$data->username',
                    'value' => '$data->enterprise_id == 0 ? $data->username : $data->enterpriseName',
                ),
                array(  //手机号码
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'mobile',
                    'value' => '$data->enterprise_id == 0 ? $data->mobile : $data->enterpriseMobile',
                ),
                array(  //会员类型：1.消费会员。2.正式会员
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => 'type_id',
                    'value' => '$data->memberType',
//                    'value' => '$data->type_id',
                ),
                array(  //地区
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Member','地区'),
                    'value' => '$data->enterprise_id == 0 ? $data->street : $data->enterpriseStreet',
                ),
                array(  //加入时间
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Member','加入时间'),
                    'value' => '$data->enterprise_id == 0 ? $data->register_time : $data->create_time',
                ),
                array(  //企业
                    'htmlOptions' => array('class' => 'tc'),
                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
                    'name' => Yii::t('Member','企业'),
                    'value' => 'MemberAgent::getStoreTypeNew($data->enterprise_id)',
                ),
//                array(  //操作
//                    'class'=>'CButtonColumn',
//                    'header' => Yii::t('Member','操作'),
//                    'headerHtmlOptions' => array('class' => 'tabletd tc'),
//                    'htmlOptions' => array('class' => 'tc'),
//                	'template' => '{update}{updateStore}',
//                    'buttons'=>array(
//                        'update' => array(
//                            'label' => Yii::t('Member','【编辑】'),
//                            'url' => 'Yii::app()->controller->createUrl("memberEdit", array("id"=>$data->primaryKey))',
//                            'imageUrl' => false,
//                			'visible' => '(!$data->is_enterprise)'
//                        ),
//                        'updateStore' => array(
//                        	'label' => Yii::t('Member','【申请修改】'),
//                        	'url' => 'Yii::app()->controller->createUrl("storeEdit", array("memberid"=>$data->primaryKey))',
//                            'visible' => '$data->is_enterprise'
//                        ),
//                    ),
//                ),
            )
        ));
    ?>
</div>
