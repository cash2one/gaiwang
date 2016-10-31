<?php 
    $stores = array();
?>
<?php 
    foreach($goods as $g){
        $stores[] = $g['store_id'];
    }
    $ids = array_unique($stores);
    $criteria = new CDbCriteria;
    $criteria->select = 'id,name';
    $criteria->addInCondition('id', $ids);
    $sModel = new Store(DbCommand::DB);
    $info = $sModel->findAll($criteria);
    $s = array();
    foreach($info as $i){
        $s[$i->id] = $i['name'];
    }
    Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/lazyLoad.js');
?>
<?php foreach($goods as $g):?>
<li>
    <?php $image_url = Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_225,w_225');?>
    <?php echo CHtml::link(CHtml::image('', $g['name'], array('class'=>'gs-list-bigImg lazy','width' => '225', 'height' => '225','alt'=>$g['name'],'data-url'=>$image_url)), $this->createAbsoluteUrl('goods/view', array('id' => $g['id'])), array('title' => $g['name'],'target'=>'_blank')); ?>
    <div class="goods-list-info store_<?php echo $g['store_id']?>">
        <p class="gs-price"><?php echo HtmlHelper::formatPrice($g['price']);?></p>
        <p class="gs-details"  style="overflow: hidden;text-overflow:ellipsis;height: 1.5em" title="<?php echo $g['name'];?>"><?php echo Tool::truncateUtf8String($g['name'], 16, '...')?></p>
        <?php echo CHtml::link(Tool::truncateUtf8String($s[$g['store_id']], 8, '...').'&nbsp;&gt;',array('shop/view','id'=>$g['store_id']),array('title'=>$s[$g['store_id']]))?>
    </div>

    <!--<div class="goods-list-border"></div>-->
    <?php //if($g['seckill_seting_id'] && $g['at_status'] == SeckillProductRelation::STATUS_PASS):?>
    <!--<div class="gx-goodsico <?php //echo 'gx-goodsico'.$g['active_id'];?>"></div>-->
    <?php //endif;?>
</li>

<?php endforeach;?>
<script>
    LAZY.init();
    LAZY.run();
</script>