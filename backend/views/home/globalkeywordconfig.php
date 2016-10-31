<style>.tab-come th{text-align: center;}</style>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
            <tbody>
                <tr>
                    <td class="title-th" colspan="3">
                        <?php echo Yii::t('home','近三个月搜索词情况：'); ?>
                    </td>
                </tr>
                <tr class="tab-reg-title" style="background-color: #C4C0C0">
                    <th>
                        <?php echo Yii::t('home','搜索词'); ?>
                    </th>
                    <th>
                        <?php echo Yii::t('home','搜索次数'); ?>
                    </th>
                    <th>
                        <?php echo Yii::t('home','相关商品数量'); ?>
                    </th>
                </tr>
                <tr>
                    <td class="title-th" colspan="3">
                        <?php echo Yii::t('home','全局搜索热门词配置'); ?>:
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <?php echo $form->textField($model,'hotSearchKeyword',array('class' => 'text-input-bj long valid'));?>
                        <?php echo $form->error($model,'hotSearchKeyword');?>
                        <?php echo Yii::t('home','(用"|"分割)'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php $this->endWidget();?>
</div>