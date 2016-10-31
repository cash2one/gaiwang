<?php
$this->breadcrumbs = array(
    Yii::t('member', '居间属下商家搜索'),
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>/css/reg.css">
<script type="text/javascript" src="<?php echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero"></script>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<script type="text/javascript">
    var btnOKClick = function(obj) {
        var id = obj.hash.replace('#', '');
        if (!id) {
            alert(<?php echo Yii::t('member', "请选择所属会员"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        if (p && p.onSelectMemeber) {
            p.onSelectMemeber(id);
        }
        p.doClose();
    }

    var btnCancelClick = function() {
    	art.dialog.close();
    }
</script>
<div  class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <thead>
            <tr style="height: 50px">
                <td colspan="4">
                    <?php echo Yii::t('member', '请输入会员名/盖网号'); ?> :
                    <input class="text-input-bj middle" style="width:320px;" size="60" maxlength="128" name="keywords" id="keywords"  type="text" value="<?php echo $keywords;?>" />
                    <?php echo CHtml::submitButton(Yii::t('member', '搜索'), array('class' => 'reg-sub')); ?>
                    <?php echo CHtml::button(Yii::t('member', '取消'), array('class' => 'reg-sub', 'onclick' => 'btnCancelClick()')); ?>
                </td>
            </tr>
        </thead>
    </table>
    <?php $this->endWidget(); ?>
</div>
<?php
$this->widget('GridView', array(
    'id' => 'store-grid',
    'dataProvider' => $store->getMiddleAgent(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => Yii::t('member','选择'),
                    'url' => '"#".$data->id', 
                    'options' => array(
                        'class' => 'reg-sub',
                        'onclick' => "btnOKClick(this)",
                    ),
                ),
            ),
        ),
        array(
            'name' => '会员名',
            'value' => '$data->name'
        ),
       array(
        'name' => '盖网号',
        'value' => '$data->username'
)
),
));
?>