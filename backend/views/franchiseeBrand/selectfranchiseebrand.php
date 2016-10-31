<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeBrand', '请选择所属加盟商品牌'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchiseeBrand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">

    var btnOKClick = function(obj) {
        var id = obj.hash.replace('#', '');
        if (!id) {
            alert(<?php echo Yii::t('franchiseeBrand', "请选择所属加盟商品牌"); ?>);
            return false;
        }
        var p = artDialog.open.origin;
        
        if (p && p.onSelectFranchiseeBrand) {
            p.onSelectFranchiseeBrand(id);
        }
       art.dialog.close();
    }

    var btnCancelClick = function() {
        art.dialog.close();
    }
</script>
<?php
$model=$model;
$infos=$infos;
?>
<div  class="border-info clearfix search-form" id="nav">

    <table cellpadding="0" cellspacing="0" class="searchTable searchTag" >
        <tbody>
            <tr>         
                <td>                   
                    <?php echo CHtml::link('A', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'A')), array('name'=>'A','style'=>"font-size:20px;"))?>
                    <?php echo CHtml::link('B', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'B')), array('name'=>'B','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('C', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'C')), array('name'=>'C','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('D', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'D')), array('name'=>'D','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('E', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'E')), array('name'=>'E','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('F', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'F')), array('name'=>'F','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('G', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'G')), array('name'=>'G','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('H', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'H')), array('name'=>'H','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('I', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'I')), array('name'=>'I','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('J', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'J')), array('name'=>'J','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('K', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'K')), array('name'=>'K','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('L', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'L')), array('name'=>'L','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('M', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'M')), array('name'=>'M','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('N', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'N')), array('name'=>'N','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('O', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'O')), array('name'=>'O','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('P', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'P')), array('name'=>'P','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('Q', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'Q')), array('name'=>'Q','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('R', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'R')), array('name'=>'R','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('S', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'S')), array('name'=>'S','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('T', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'T')), array('name'=>'T','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('U', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'U')), array('name'=>'U','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('V', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'V')), array('name'=>'V','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('W', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'W')), array('name'=>'W','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('X', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'X')), array('name'=>'X','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('Y', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'Y')), array('name'=>'Y','style'=>'font-size:20px'))?>
                    <?php echo CHtml::link('Z', Yii::app()->createAbsoluteUrl('/franchiseeBrand/getFranchiseeBrand',array('py'=>'Z')), array('name'=>'Z','style'=>'font-size:20px'))?>
                </td>
                
            </tr>
            
        </tbody>
    </table>
</div>
<div id="franchiseeBrand-grid" class="grid-view">
<?php if($infos): ?>   
<table class="tab-reg">
<thead>
<tr>
<th class="button-column" id="franchiseeBrand-grid_c0">&nbsp;</th>
<th id="franchiseeBrand-grid_c1"><a class="sort-link" href="#">品牌名称</a></th>
<th id="franchiseeBrand-grid_c2"><a class="sort-link" href="#">品牌名称（首字母）</a></th>
</tr>
</thead>
 
<tbody>
<?php foreach($infos as $info):?>
<tr class="<?php echo ($info->id / 2==0) ? "odd" : "even";?>">    
    <td class="button-column">
        <a class="reg-sub" onclick="btnOKClick(this)" title="选择" href="#<?php echo $info->id?>">选择</a>
    </td>
    <td><?php echo $info->name;?></td>
    <td><?php echo $info->pinyin;?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<?php else:?>
<table class="tab-reg">
<thead>
<tr>
    <th class="button-column" id="franchiseeBrand-grid_c0" style="width:186px">&nbsp;</th>
<th id="franchiseeBrand-grid_c1"><a class="sort-link" href="#">品牌名称</a></th>
<th id="franchiseeBrand-grid_c2"><a class="sort-link" href="#">品牌名称（首字母）</a></th>
</tr>
</thead>
</table>
<div style="position: relative;top:20px;font-size:20px">没有该团购品牌</div>
<?php endif;?>    
<div class="summary">
<?php
//$this->widget('LinkPager', array(
//    'pages' => $pages,
//    'jump' => false,
//    'htmlOptions' => array('class' => 'pagination'),
//))
?>
<?php 
    $this->widget('CLinkPager', array(
            'header'	=>	'',
            'firstPageLabel'	=> '首页',
            'lastPageLabel'	=> '末页',
            'prevPageLabel'	=> '上一页',
            'nextPageLabel'	=> '下一页',
            'pages'			=> $pages,
            'maxButtonCount'=> 5,


            ));
?>
</div>

</div>
</div>     
