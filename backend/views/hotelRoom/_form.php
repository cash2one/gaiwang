<?php
/**
 * @var HotelRoomController $this
 * @var HotelRoom           $model
 * @var CActiveForm         $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hotelRoom-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => false, //客户端验证
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tbody>
        <tr>
            <th><?php echo $form->labelEx($model, 'name'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'num'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'num', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'num'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'bed'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'bed', HotelRoom::getBed(), array('separator' => '&nbsp;&nbsp;')); ?>
                <?php echo $form->error($model, 'bed'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'breadfast'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'breadfast', HotelRoom::getBreakfast(), array('separator' => '&nbsp;&nbsp;')); ?>
                <?php echo $form->error($model, 'breadfast'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'network'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'network', HotelRoom::getNetwork(), array('separator' => '&nbsp;&nbsp;')); ?>
                <?php echo $form->error($model, 'network'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'unit_price'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'unit_price', array('class' => 'text-input-bj', 'onblur' => 'getReturnScore()')); ?>
                <?php echo $form->error($model, 'unit_price'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'estimate_price'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'estimate_price', array('class' => 'text-input-bj', 'onblur' => 'getReturnScore()')); ?>
                <?php echo $form->error($model, 'estimate_price'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'gai_income'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'gai_income', array('class' => 'text-input-bj', 'onblur' => 'getReturnScore()')); ?>
                %
                <?php echo $form->error($model, 'gai_income'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'estimate_back_credits'); ?>：</th>
            <td id="returnIntegral"><?php echo $model->estimate_back_credits ? $model->estimate_back_credits : 0; ?></td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'event_name'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'event_name', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'event_name'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'activities_start'); ?>：</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'activities_start',
                    'options' => array('minDate' => date('Y-m-d')),
                ));
                ?>
                <?php echo $form->error($model, 'activities_start'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'activities_end'); ?>：</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'activities_end',
                    'options' => array('minDate' => date('Y-m-d'))
                ));
                ?>
                <span><font color="red"><?php echo Yii::t('hotelRoom', '不填则活动永久有效'); ?></font></span>
                <?php echo $form->error($model, 'activities_end'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'activities_price'); ?>：</th>
            <?php $model->activities_price = $model->activities_price == 0.00 ? '' : $model->activities_price ?>
            <td>
                <?php echo $form->textField($model, 'activities_price', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'activities_price'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'thumbnail'); ?>：</th>
            <td>
                <?php echo $form->fileField($model, 'thumbnail', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'thumbnail', array(), false); ?>
                <?php if (!$model->isNewRecord): ?>
                    <?php
                    echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $model->thumbnail, "c_fill,h_60,w_80"), '', array('class' => 'imgThumb', 'width' => 80, 'height' => 60)), ATTR_DOMAIN . '/' . $model->thumbnail, array('onclick' => 'return _showBigPic(this)')
                    );
                    ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($pictures, 'path'); ?>：</th>
            <td>
                <?php
                $this->widget('common.widgets.CUploadPic', array(
                    'form' => $form,
                    'model' => $pictures,
                    'attribute' => 'path',
                    'num' => 5,
                    'folder_name' => 'files',
                ));
                ?>
                <?php echo $form->error($pictures, 'path', array(), false, false); ?>
                <span><font color="red"><?php echo Yii::t('hotelRoom', '最多上传5张'); ?></font></span>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'content'); ?>：</th>
            <td>
                <?php echo $form->textArea($model, 'content', array('class' => 'text-area text-area2')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'status'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'status', HotelRoom::getStatus(), array('separator' => '&nbsp;&nbsp;')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'sort'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'sort'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <?php if (!$model->isNewRecord): ?>
                    <input type="hidden" name="hotelId" value="<?php echo $model->hotel_id; ?>">
                <?php endif; ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotel', '新增') : Yii::t('hotel', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript" language="javascript" src="/js/iframeTools.source.js"></script>
<script type="text/javascript">
    function getReturnScore() {
        var unitPrice = parseFloat($("#HotelRoom_unit_price").val());
        var gaiPrice = parseFloat($("#HotelRoom_estimate_price").val());
        var gaiIncome = parseFloat($("#HotelRoom_gai_income").val());
        var de = unitPrice - gaiPrice;
        if (101 <= de && de <= 500) {
            $('#HotelRoom_gai_income').val("60")
            gaiIncome = 60;
        }
        else if (de >= 501) {
            $('#HotelRoom_gai_income').val("70")
            gaiIncome = 70;
        }
        else if (0 < de && de <= 100) {
            $('#HotelRoom_gai_income').val("50")
            gaiIncome = 50;
        }
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/hotelRoom/getReturnScore"); ?>',
            data: {
                'unitPrice': unitPrice,
                'gaiPrice': gaiPrice,
                'gaiIncome': gaiIncome,
                'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'
            },
            success: function(data, textStatus, jqXHR) {
                var data = $.parseJSON(data);
                $('#returnIntegral').text(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown)
            },
            cache: false
        });
    }
</script>


