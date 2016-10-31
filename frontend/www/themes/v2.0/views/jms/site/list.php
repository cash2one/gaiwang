<!-- LOCAL LIFE -->
<div class="local-life">
    <div class="w1200">
        <!-- GOOD FOOD -->
        <?php if(!empty($mainF)){ ?>
        <div style="margin-top: 5px;margin-bottom: 10px" class="good-food">

            <a href="<?php echo $mainF[0]['link']; ?>" target="_blank">
                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $mainF[0]['picture'], 'c_fill,h_170,w_1200'),'',array('width'=>'1200px','height'=>'170px','alt'=>$mainF[0]['title']));?>
            </a>
            <p><?php if($mainF[0]['text']) echo mb_substr($mainF[0]['text'],0,200,'utf-8') ?></p>

        </div>
        <?php } ?>
        <!-- END GOOD FOOD -->
        <div class="main" <?php if(empty($mainF)){ ?> style="margin-top: 20px;" <?php } ?> >
            <?php if(!empty($newsFranchisees['list'])){ ?>
                <?php foreach($newsFranchisees['list'] as $key => $value){ ?>
                    <div class="item">
                        <div class="item-inner">
                            <a class="abs" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name']; ?>">
                            <div class="info cl">
                                <div class="clearfix">
                                    <a class="logo" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name'];?>">
                                        <?php echo CHtml::image(Tool::showImg($value['logo'], 'c_fill,h_68,w_138'),'',array('width'=>'138px','height'=>'68px','alt'=>$value['name']));?>
                                    </a>
                                    <div class="left-box">
                                        <em class="discount"><?php echo ($value['member_discount']/10).Yii::t('site', "折"); ?></em>
                                    </div>
                                </div>
                                <div class="description cl"><?php echo $value['summary']; ?></div>
                                <div class="right-box">
                                    <p class="views" style="color:#000000"><?php echo $value['visit_count'].Yii::t('site', "次"); ?></p>
                                </div>
                                <b class="tag <?php echo $value['bussbgclass']; ?>"></b>
                            </div></a>
                            <a class="abs" href="<?php echo $value['id']; ?>" target="_blank" title="<?php echo $value['name']; ?>">
                                <?php echo CHtml::image(Tool::showImg(ATTR_DOMAIN.'/'.$value['thumbnail'], 'c_fill,h_210,w_610'),'',array('width'=>'610px','height'=>'210px','alt'=>$value['name']));?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <div class="pageList mt50 clearfix"  style="margin-top: 29px;margin-bottom: 29px;">
                    <?php
                    $this->widget('SLinkPager', array(
                        'cssFile' => false,
                        'header' => '',
                        'firstPageLabel' => Yii::t('category','首页'),
                        'lastPageLabel' => Yii::t('category','末页'),
                        'prevPageLabel' => Yii::t('category','上一页'),
                        'nextPageLabel' => Yii::t('category','下一页'),
                        'pages' => $newsFranchisees['page'],
                        'maxButtonCount' => 5,
                        'htmlOptions' => array(
                            'class' => 'yiiPageer',
                        )
                    ));
                    ?>
                </div>
            <?php
            }else{ ?>
                <img width="944" src="<?php echo $this->theme->baseUrl.'/'; ?>images/bgs/xianxia_default.jpg" />
            <?php } ?>
        </div>
        <?php if(!empty($cityRecommends)) { ?>
        <div class="side" <?php if(empty($mainF)){ ?> style="margin-top: 20px;" <?php } ?> >
            <h3 class="title"><?php echo Yii::t('site', "盖网推荐"); ?></h3>
            <?php foreach ($cityRecommends as $key => $recommend) { ?>
                <div class="sd-item">
                    <a href="<?php echo $this->createAbsoluteUrl('view',array('id'=>$recommend['id']));?>" target="_blank" title="<?php echo $recommend['name']; ?>">
                        <?php $url = !empty($recommend['logo']) ? Tool::showImg(ATTR_DOMAIN . '/'.$recommend['logo'], 'c_fill,h_110,w_220') : DOMAIN.'/images/bgs/seckill_product_bg.png';
                        echo CHtml::image($url,'',array('width'=>'220px','height'=>'110px','alt'=>$recommend['name']));?>
                    </a>
                    <p class="color-block fw wh tc"><?php echo Tool::truncateUtf8String($recommend['name'],15); ?></p>
                </div>
                <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
<!-- END LOCAL LIFE -->

<script>
    $(function(){
        LAZY.init();
        LAZY.run();
    })
</script>
