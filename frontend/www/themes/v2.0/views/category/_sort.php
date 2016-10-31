<div class="goods-list-title">
    <dl class="gst-sort clearfix">
        <dt><?php echo Yii::t('category','排序');?></dt>
        <dd class="<?php if($params['order']===0) echo 'ddSel'?>"><?php echo HtmlHelper::generateSortUrl('default', $this->route, $p, $this->_uriParamsCriterion(), 'abg'); ?></dd>
        <dd class="<?php if($params['order']==1) echo 'ddSel'?>"><?php echo HtmlHelper::generateSortUrl('views', $this->route, $p,$this->_uriParamsCriterion())?></dd>
        <dd class="<?php if($params['order']==2 || $params['order']==3) echo 'ddSel'?>"><?php echo HtmlHelper::generateSortUrl('price', $this->route, $p, $this->_uriParamsCriterion(), ''); ?></dd>
        <dd class="<?php if($params['order']==4) echo 'ddSel'?>"><?php echo HtmlHelper::generateSortUrl('audit_time', $this->route, $p, $this->_uriParamsCriterion(), ''); ?></dd>
    </dl>
    <?php 
        unset($p['min']);unset($p['max']);
        unset($p['freight_payment_type']);
        unset($p['seckill_seting_id']);
        $this->beginWidget('CActiveForm',array(
            'id'=>'price-form',
            'method'=>'get',
            'action'=>$this->createUrl('category/list',$p)
         ));
    ?>
    <dl class="gst-address">
<!--        <dd>
            <input type="checkbox" name="seckill_seting_id" <?php //if($params['seckill_seting_id']) echo 'checked'?> class="gst-box" value="<?php //echo $params['seckill_seting_id']?>"/><?php //echo Yii::t('category','参与活动')?>
        </dd>-->
        <dd>
            <input type="checkbox" name="freight_payment_type" <?php if($params['freight_payment_type']) echo 'checked'?> class="gst-box" value="<?php echo $params['freight_payment_type']?>"/><?php echo Yii::t('category','包邮')?>
        </dd>
        <dd>
            <div class="gst-range gst-range2">
                ￥<input name="min" value="<?php echo $params['min']?>">
            </div>
            <div class="gst-line">-</div>
            <div class="gst-range">￥<input name="max" value="<?php echo $params['max']?>"></div>
            <input type="submit" value="确定" class="gst-range-but" style="display: none;">
        </dd>
    </dl>
    <?php $this->endWidget();?>
    <script>
        $(function(){
            $('.gst-address .gst-box').click(function(){
                var val = $(this).val();
                val = parseInt(val) ? 0 : 1;
                $(this).val(val);
                $('.gst-range-but').click();
            })
        })
    </script>
    <div class="gst-title-paging">
        <?php $params['id'] = $this->id?>
        <div class="paging-num"><?php echo $pager->getPageCount() == 0 ? $pager->getCurrentPage() .'/'.$pager->getPageCount() : ($pager->getCurrentPage())+1 .'/'.$pager->getPageCount()?></div>
        <?php echo 
            $pager->getCurrentPage() ? 
            CHtml::link('',$this->createUrl('category/list',  array_merge($params,$searchAttribute,array('page'=>$pager->getCurrentPage()))),array('class'=>'paging-left'))
            : CHtml::link('','javascript:void(0)',array('class'=>'paging-left'));
        ?>
        <?php echo 
            $pager->getCurrentPage()+1 == $pager->getPageCount() || !$pager->getPageCount() ?
            CHtml::link('','javascript:void(0)',array('class'=>'paging-right'))
            : CHtml::link('',$this->createUrl('category/list',  array_merge($params,$searchAttribute,array('page'=>$pager->getCurrentPage()+2))),array('class'=>'paging-right'));
        ?>
    </div>
</div>