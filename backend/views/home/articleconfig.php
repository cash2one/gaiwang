<style>.tab-come th{text-align: center;} .regm-sub:hover{cursor: pointer;}</style>

<div class='form'>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
    
    <script src="/js/iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">
        var dialog = null;
        var SearchArt = function (i, j) {
            alert('<?php echo Yii::t('home','目前没有本地文件'); ?>');
            return;
            var url = '/Article/SearchArt.html' + "?i=" + i + "&j=" + j;
            dialog = art.dialog.open(url, { 'id': 'SearchCat', title: '添加站内文章', width: '640px', height: '600px', lock: true });
        }
        var onSelectedArt = function (Id, Title, i, j) {
            $("#artname_" + i + "_" + j).val(Title);
            $("#arturl_" + i + "_" + j).val('http://helptest.<?php echo SHORT_DOMAIN ?>/' + "Article/" + Id + ".html");
        }
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        }
    </script>

    <table width="100%" border="0" class="tab-come" cellspacing="1" cellpadding="0">
        <tbody>
                <tr>
                    <td colspan="2" class=" title-th">
                        <?php echo $form->textField($model,'cat_0',array('class' => 'text-input-bj middle'));?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_0_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_0_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(0,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_0_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_0_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(0,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_0_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_0_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(0,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_0_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_0_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(0,3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_0_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_0_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(0,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class=" title-th">
                        <?php echo $form->textField($model,'cat_1',array('class' => 'text-input-bj middle'));?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_1_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_1_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(1,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_1_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_1_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(1,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_1_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_1_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(1,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_1_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_1_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(1,3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_1_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_1_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(1,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class=" title-th">
                        <?php echo $form->textField($model,'cat_2',array('class' => 'text-input-bj middle'));?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_2_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_2_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(2,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_2_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_2_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(2,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_2_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_2_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(2,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_2_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_2_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(2,3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_2_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_2_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(2,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class=" title-th">
                        <?php echo $form->textField($model,'cat_3',array('class' => 'text-input-bj middle'));?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_3_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_3_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(3,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_3_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_3_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(3,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_3_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_3_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(3,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_3_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_3_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(3,3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_3_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_3_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(3,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class=" title-th">
                         <?php echo $form->textField($model,'cat_4',array('class' => 'text-input-bj middle'));?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_4_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_4_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(4,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_4_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_4_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(4,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_4_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_4_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(4,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_4_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_4_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(4，3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_4_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_4_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(4,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class=" title-th">
                        <?php echo $form->textField($model,'cat_5',array('class' => 'text-input-bj middle','readonly' => 'readonly','value' => Yii::t('home','系统文章')));?>
                        <br />
                        <span style="font-size: 12px"><?php echo Yii::t('home','在首页下面显示，系统相关文章显示请在"Help/"后面加相应文字:关于(About)、声明(Disclaimer)、地图(WebMap)、服务(ServiceCenter);如Help/About/4.html'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_0',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_0',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,0)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_1',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_1',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,1)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_2',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_2',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,2)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_3',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_3',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,3)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_4',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_4',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,4)')) ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <span><?php echo $form->labelEx($model,'artname');?>：</span>
                        <?php echo $form->textField($model,'artname_5_5',array('class' => 'text-input-bj least'));?>
                    </th>
                    <td>
                        <span><?php echo $form->labelEx($model,'arturl');?>：</span>
                        <?php echo $form->textField($model,'arturl_5_5',array('class' => 'text-input-bj long'));?>
                        <?php echo CHtml::button(Yii::t('home','添加本地'),array('class' => 'regm-sub','onclick' => 'SearchArt(5,5)')) ?>
                    </td>
                </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class' => 'reg-sub'))?>
    <?php $this->endWidget();?>
</div>