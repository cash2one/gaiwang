<?php
/** @var $this FreightTypeController */
/** @var $model FreightType */
/** @var $templateModel FreightTemplate */
$title = Yii::t('freightType', '运费详情');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('freightType', '交易管理 '),
    Yii::t('sellerFreightTemplate', '运费模版'),
    $title,
);
?>
<div class="toolbar">
    <h3><?php echo $templateModel->name ?> - <?php echo $title ?></h3>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $model->getAttributeLabel('mode'); ?></th>
            <td width="90%"><?php echo $model::mode($model->mode) ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('freightType', '默认设置'); ?></th>
            <td>
                <?php echo Yii::t('freightType', '默认运费'); ?>：
                <?php echo $this->showDefaultSet($templateModel, $model) ?>
                &nbsp;&nbsp;&nbsp;
                <?php echo CHtml::link(Yii::t('freightType', '编辑'), array('freightType/update/', 'id' => $model->id)); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo Yii::t('freightType', '指定地区设置'); ?></th>
            <td>
                <p>
                    <?php echo CHtml::link(Yii::t('freightType', '添加指定区域'), array('freightArea/create/', 'id' => $model->id));
                    ?>
                </p>

                <p>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-con5">
                    <tbody>
                        <tr bgcolor="#fcfcfc">
                            <th>
                                <?php echo Yii::t('freightType', '地区'); ?>
                            </th>
                            <th style="width: 40px">
                                <?php echo $model->getAttributeLabel('default') ?>
                            </th>
                            <th style="width: 40px">
                                <?php echo $model->getAttributeLabel('default_freight') ?>
                            </th>
                            <th style="width: 40px">
                                <?php echo $model->getAttributeLabel('added') ?>
                            </th>
                            <th style="width: 40px">
                                <?php echo $model->getAttributeLabel('added_freight') ?>
                            </th>
                            <th style="width: 40px">
                                <?php echo Yii::t('freightType', '操作'); ?>
                            </th>
                        </tr>
                        <?php foreach ($groupArea as $v): ?>
                            <tr bgcolor="#fcfcfc" style="background-color: rgb(238, 238, 238);">
                                <td>
                                    <?php echo implode(',', Region::getNameArray($v['location_ids'])) ?>
                                </td>
                                <td>
                                    <?php echo $v['default'] ?>
                                </td>
                                <td>
                                    <?php echo HtmlHelper::formatPrice(($v['default_freight'])) ?>
                                </td>
                                <td>
                                    <?php echo $v['added'] ?>
                                </td>
                                <td>
                                    <?php echo HtmlHelper::formatPrice($v['added_freight']) ?>
                                </td>
                                <td>
                                    <?php
                                    echo CHtml::link(Yii::t('freightType', '编辑'), $this->createAbsoluteUrl('freightArea/update', array(
                                                'id' => $model->id,
                                                'default' => $v['default'],
                                                'default_freight' => $v['default_freight'],
                                                'added' => $v['added'],
                                                'added_freight' => $v['added_freight'],
                                                //'location_ids' => $v['location_ids'],
                                    )));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </p>
            </td>
        </tr>
    </tbody>
</table>

<div class="profileDo mt15">
    <a href="<?php echo $this->createAbsoluteUrl('freightTemplate/update/', array('id' => $templateModel->id)); ?>" class="sellerBtn01">
        <span><?php echo Yii::t('freightType', '返回'); ?></span>
    </a>
</div>