  <?php
    /**
 *  @var CityCardController $this
 *  @var CityCard $model
 *  @var ActiveForm $form
 */
        $form = $this->beginWidget('ActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
    ?>
    <div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'name'); ?>：</th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>
                <th><?php echo $form->label($model, 'city_name'); ?>：</th>   
                <?php $city_name = CHtml::listData(CityCard::model()->findAll(),'city_code','city_name');?>
                <td><?php echo $form->dropDownList($model, 'city_name',$city_name,array(
                   'class'=>'text-input-bj','empty' => '全部',));
                ?></td>
                 <td><?php echo CHtml::submitButton(Yii::t('citycard', '查询'), array('class' => 'regm-sub')); ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <?php $this->endWidget(); ?>
