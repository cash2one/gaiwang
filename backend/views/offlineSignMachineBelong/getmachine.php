<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<?php $checkMachine='OfflineSignMachineBelong/setMachines&';?>
<script type="text/javascript">
    var btnOKClick = function(obj) {
        var belong_to = obj.hash.replace('#', '');
        var belong_array = belong_to.split("#");
        belong_to = belong_array[1];
        var belong_id = belong_array[0];
        if (!belong_to) {
            alert(<?php echo Yii::t('offlineSignMachineBelong', "请选择归属方"); ?>);
            return false;
        }

        var p = artDialog.open.origin;
        if (p && p.onSelectInfo) {
            p.onSelectInfo(belong_to);
        }
        var extendId = <?php echo $extendId?>;
        var myUrl = createUrl("<?php echo Yii::app()->createUrl($checkMachine)?>",{'extendId':extendId,'machine_name':belong_id});
        jQuery.ajax({
            type: 'GET', async: false, cache: false, dataType: 'html',
            url: myUrl,
            error: function (request, status, errorcontent) {
                alert(request.responseText);
            },
            success: function (data){

            }
        });
        p.doClose();
    };
    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<div  class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <td>
                    <?php echo $form->label($model, 'belong_to'); ?>
                    <?php echo $form->textField($model, 'belong_to', array('class' => 'text-input-bj  least')); ?>
                </td>
                <td>
                    <?php echo CHtml::submitButton(Yii::t('offlineSignMachineBelong', '搜索'), array('class' => 'reg-sub')); ?>
                </td>    
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'offline-sign-machine-belong-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => Yii::t('offlineSignMachineBelong', '选择'),
                    'url' => '"#".$data->primaryKey."#".$data->belong_to',
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => 'btnOKClick(this)',
                    ),
                ),
            ),
        ),
        'belong_to',
        'number',
    ),
));
?>