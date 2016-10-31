<?php
/* @var $this Controller */
if (!$infos = $this->cache('article')->get('helpInfo'))
    $infos = Article::helpInfo();
?>
<div class="main">
    <?php $this->renderPartial('/layouts/_left'); ?>
    <div class="mainWrap right">
        <!--div class="hPSearch">
            <span class="bg"></span>
            <div class="fl">
                <input type="text" class="hpsearch_input" value="请输入你要搜索的问题" name="">
                <a class="hpsearch_inputupBtn" href=""></a>
            </div>
            <a class="hpsearch_btn" title="搜索" href="">搜索</a>
            <span class="bg mgleft10"></span>
        </div>-->
        <div class="hpListcontent" style="margin-top:93px;">
            <?php if ($infos): ?>
                <?php $i = 1 ?>
                <?php foreach ($infos as $v): ?>
                    <dl class="hplistBox <?php if ($i == 3): ?>mgleft45<?php endif; ?>">
                        <dt class="hplistBox_icon<?php echo $i ?>"></dt>
                        <dd><h3><?php echo Yii::t('help',$v['name']) ?></h3></dd>
                        <dd class="hplistTxt">
                            <?php foreach ($v['child'] as $c): ?>
                                <?php echo CHtml::link(Yii::t('help',$c['title']), $this->createAbsoluteUrl('/help/article/view', array('alias' => $c['alias'])), array('title' => $c['title'])); ?>
                            <?php endforeach; ?>
                        </dd>
                    </dl>
                    <?php $i++ ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="hlepProblem">
            <div class="hlepProblem_t"><span class="hlepProblem_t_bg"><?php echo Yii::t('help','常见问题');?></span> </div>
            <div class="hlepProblem_c">
                <?php if ($info): ?>
                    <?php foreach ($info as $v): ?>
                        <ul>
                            <?php foreach ($v as $a): ?>
                                <li>
                                    <span class="li_icon"></span>
                                    <?php echo CHtml::link($a['title'], $this->createAbsoluteUrl('/help/article/view', array('alias' => $a['alias'])), array('title' => $a['title'], 'target' => '_blank')); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
