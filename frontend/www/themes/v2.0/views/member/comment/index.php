<script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/js/jquery.raty.js" type="text/javascript"></script>
<script>
    $.fn.raty.defaults.path = '<?php echo Yii::app()->theme->baseUrl?>/images/bgs';
    $(function () {
        $(".star-1").raty({readOnly: true, score: 1});
        $(".star-2").raty({readOnly: true, score: 2});
        $(".star-3").raty({readOnly: true, score: 3});
        $(".star-4").raty({readOnly: true, score: 4});
        $(".star-5").raty({readOnly: true, score: 5});
    })
</script>
<div class="main-contain">
    <div class="evaluate-hd">
        <span class="title"><?php echo Yii::t('memberComment','我的评价')?></span>
    </div>
    <table class="evaluate-tab" style="word-break:break-all;">
        <thead>
        <tr class="col-name">
            <th><?php echo Yii::t('memberComment','评价时间')?></th>
            <th><?php echo Yii::t('memberComment','评价内容')?></th>
            <th><?php echo Yii::t('memberComment','订单编号')?></th>
            <th><?php echo Yii::t('memberComment','商品名称')?></th>
            <th><?php echo Yii::t('memberComment','商家名称')?></th>
        </tr>
        </thead>
        <tbody class="evaluate-list">
            <?php if($commentData = $comments->getData()):?>
            <?php foreach ($commentData as $m):?>
            <tr>
                <td class="even comment-date" valign="top"><?php echo date('Y-m-d',$m['create_time'])?></td>
                <td class="comment-content" valign="top">
                    <p class="star-<?php echo (int)$m->score?>"></p>
                    <p><?php echo $m['content']?></p>
                    <?php if(!empty($m['img_path'])):?>
                    <ul class="clearfix" >
                        <?php 
                            $img = explode('|', $m['img_path']);
                            foreach($img as $i):
                        ?>
                        <li class="evaluate-img">
                            <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $i, 'c_fill,h_50,w_50'),'',array('width'=>'50px','height'=>'50px','style'=>'padding-top:2px'));?>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </td>
                <td class="even" valign="top"><?php echo $m->order->code?></td>
                <td valign="top">
                    <?php echo CHtml::link($m->goods->name,$this->createUrl('/goods/view',array('id'=>$m->goods->id),array('class'=>'link')))?>
                    <p class="color-classify">
                    <?php 
                        $attr = unserialize($m->spec_value);
                        if($attr){
                            foreach ($attr as $k=>$a)
                            {
                                echo $k .":" . $a . '</br>';
                            }
                        }
                    ?>
                    </p>
                </td>
                <td class="even" valign="top">
                    <?php echo CHtml::link($m->store->name,$this->createUrl('/shop/'.$m->store->id,array(),array('class'=>'link')))?>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?>
            <tr><td colspan="5" align='center'><?php echo Yii::t('memberComment','没有订单评论')?></td></tr>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageList clearfix">
<!--        <ul id="yw0" class="yiiPageer">
            <li class="first"><a href="#">首页</a></li>
            <li class="previous"><a href="#">上一页</a></li>
            <li class="page selected"><a href="#">1</a></li>
            <li class="page"><a href="#">2</a></li>
            <li class="page"><a href="#">3</a></li>
            <li class="page"><a href="#">4</a></li>
            <li class="page"><a href="#">5</a></li>
            <li class="next"><a href="#">下一页</a></li>
            <li class="last"><a href="#">末页</a></li>
        </ul>-->
        <?php
            $this->widget('SLinkPager', array(
                'header' => '',
                'cssFile' => false,
                'firstPageLabel' => Yii::t('page', '首页'),
                'lastPageLabel' => Yii::t('page', '末页'),
                'prevPageLabel' => Yii::t('page', '上一页'),
                'nextPageLabel' => Yii::t('page', '下一页'),
                'maxButtonCount' => 5,
                'pages' => $comments->pagination,
                'htmlOptions' => array(
                    'class' => 'yiiPageer'
                )
            ));
        ?>  
    </div>

</div>