<?php $src = DOMAIN.Yii::app()->theme->baseUrl.'/images/bgs/pord_gradeico.png';?>
<li class="clearfix">
    <div class="pdTab2-comInfo"><?php echo Tool::banwordReplace($data['content'], '*'); ?></div>
    <div class="pdTab2-gradeIco">
    <?php if($data['score'] > 0){
	    $c = floor($data['score']);
		for($i=0; $i<$c; $i++){
	?>
        <img width="15" height="14" src="<?php echo $src;?>"/>
    <?php }}else{?>
    &nbsp;&nbsp;
    <?php }?>
    </div>
    <div class="pdTab2-comInfo2">
    <?php if (!empty($data['spec_value'])): ?>
        <?php foreach (unserialize($data['spec_value']) as $ksp => $vsp): ?>
			<?php echo '<span>'.$ksp.'</span>：'.$vsp.'<br/>'; ?>
        <?php endforeach; ?>
    <?php else: ?>
        &nbsp;&nbsp;
    <?php endif; ?>
    </div>
    <div class="pdTab2-comInfo3">
        <?php if($data['is_anonymity']) {echo Yii::t('Goods','匿名');} else { echo substr_replace($data['gai_number'], '****', 3, 4);} ?><br/>
        <span class="pdTab2-comInfo3-font1"><?php echo date('Y-m-d H:i', $data['create_time']); ?></span>
        <span class="pdTab2-zanIco clickVote"></span><?php echo Yii::t('goods', '赞'); ?>(<span class="vote_num vote_<?php echo $data['id'];?>"  rel="<?php echo $data['id'].'|'.$data['goods_id'];?>"><?php echo $data['vote'];?></span>)
    </div>
    <div class="pdTab2-ImgShow">
    <?php if($data['img_path'] != ''){
	    $array = explode('|', $data['img_path']);	
	?>
        <ul class="clearfix">
        <?php foreach($array as $v){?>
            <li><img title="<?php echo Yii::t('goods', '点击放大'); ?>" width="82" height="82" src="<?php echo IMG_DOMAIN.'/'.$v;?>"/></li>
        <?php }?>
        </ul>
        <div class="pdTab2-ImgShow-float">
            <img title="<?php echo Yii::t('goods', '点击缩小'); ?>" width="300" height="300" src=""/>
        </div>
    <?php }?>    
    </div>
</li>