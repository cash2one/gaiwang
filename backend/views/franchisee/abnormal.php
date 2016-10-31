<?php
/* @var $this FranchiseeController */
/* @var $model AbnormalMerchants */
$this->breadcrumbs = array(Yii::t('franchisee', '异常商户管理') => array('admin'), Yii::t('franchisee', '列表'));

?>
<?php $this->renderPartial('_searchabnormal', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Franchisee.PullInto')): ?>
                <?php echo CHtml::button('选择商家', array('class' => 'reg-sub-01', 'readonly' => true, 'id' => 'setAbnormal')); ?>

    <div class="c10"></div>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-grid',
    'dataProvider' => $model->getdata(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
         array(
            'name' => Yii::t('franchisee', '名称'),
             'value' => '$data->franchisee->name'
        ),
           array(
            'name' => Yii::t('franchisee', '编号'),
             'value' => '$data->franchisee->code'
        ),
          array(
            'name' => Yii::t('franchisee', '所属会员'),
             'value' => '!empty($data->franchisee)?$data->franchisee->member->gai_number:"null"'
        ),
           array(
            'name' => Yii::t('franchisee', '电话'),
             'value' => '$data->franchisee->mobile'
        ),

        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('franchisee', '操作'),
            'template' => '{remove}',

            'buttons' => array(
              
                'remove' => array(
                     
                    'label' =>  '移出' ,
                     'visible' => '(Yii::app()->user->checkAccess("Franchisee.Remove"))? TRUE :FALSE',
                   'url' =>'Yii::app()->createUrl("franchisee/remove", array("id"=>$data->id))',
                ),
               
            )
        )
    ),

));
?>

<?php
$title = '导出异常商户列表';
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,'title'=>$title
));
?>

<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('', "
var dialog = null;
var doClose = function() {
    if (null != dialog) {
        dialog.close();
    }
};
jQuery(function($) {
    $('#setAbnormal').click(function() {
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('/franchisee/getFranchisee') . "', { 'id': 'selectmemberinfo', title: '搜索商家', width: '800px', height: '620px', lock: true });
    })
})

var onSelectMemeberInfo = function (id) {  
    if (id) {
        $.ajax({
            cache:false,
            dataType: 'json',
            url:'" . $this->createAbsoluteUrl('/franchisee/pullInto') . "&id='+id+'&YII_CSRF_TOKEN=" . Yii::app()->request->csrfToken . "',
            success:function(data){
            if(data){
            alert('拉入异常列表成功！');
            window.location.reload();
            }else{
            alert('该商家已进入异常列表！');
            }
               
            }
        })
    }
};
", CClientScript::POS_HEAD);
?>