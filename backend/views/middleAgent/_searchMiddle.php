<div class="border-info search-form clearfix">
    <?php
       $form = $this->beginWidget('CActiveForm', array(
           // 'enableAjaxValidation' => true,
           'enableClientValidation' => true,
           'action' => Yii::app()->createUrl($this->route),
           'method'=>'get',
           'id'=>'search_middleAgent'
       ));
    ?>


    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'gai_number') ?></th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj middle')); ?></td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'mobile') ?></th>
            <td><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj least')); ?></td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii:: t('member', '搜索'), array('class' => 'reg-sub')); ?></td>
            <td>
                <?php if ($this->getUser()->checkAccess('MiddleAgent.Create')): ?>
                    <a class="regm-sub"
                       href="<?php echo $this->createAbsoluteUrl('/middleAgent/create') ?>"><?php echo Yii::t('category', '添加居间商') ?></a>
                <?php endif; ?>
            </td>
        </tr>
    </table>


    <?php $this->endWidget(); ?>
</div>

<script>
    $('#search_middleAgent').submit(function(){
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/middleAgent/search'); ?>';
        if($("#MiddleAgent_gai_number").val().length ==0 && $("#MiddleAgent_mobile").val().length==0){
            window.location.reload();
            return false;
        }
        $.post(url, $(this).serialize(), function(data) {
            $('#treeGrid').treegrid('loadData',data);//加载数据更新treegrid
        }, 'json');
        return false;
    });
</script>