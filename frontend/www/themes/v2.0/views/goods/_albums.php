<?php
$goodsCollect = WebGoodsData::getCollects($goods['id'], 2);
?>
<div class="right-extra">
  <div>
    <div id="preview" class="spec-preview"> <span class="jqzoom">
    <?php if(!empty($gallery)){?>
    <img width="420" height="420" jqimg="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $gallery[0]['path'], 'c_fill,h_800,w_800'); ?>" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $gallery[0]['path'], 'c_fill,h_800,w_800'); ?>" />
    <?php }?>
    </span> </div>
    <div class="spec-scroll clearfix"> <a class="prev"></a> <a class="next"></a>
      <div class="items">
        <ul class="clearfix">
        <?php if (!empty($gallery) && is_array($gallery)): 
		          foreach ($gallery as $v):
		?>
          <li>
            <img alt=""  bimg="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_800,w_800'); ?>" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['path'], 'c_fill,h_800,w_800'); ?>" onmousemove="preview2(this);" />
          </li>
          <?php endforeach; 
		    endif;      
		  ?>
        </ul>
      </div>
    </div>
  </div>
  
    <dl class="gl-prodDisplay-info clearfix">
        <dd><?php echo Yii::t("goods", "商品编号"); ?>: <?php echo $goods['id'];?></dd>
        <dd><a href="javascript:void(0)" class="gl-prodDispla-share"><?php echo Yii::t("goods", "分享"); ?></a></dd>
        <dd><span class="gl-prodDispla-collect <?php if($goodsCollect>0){echo 'gl-prodDispla-collectSel';}?>" tag="<?php if($goodsCollect>0){echo '1';}else{echo '0';}?>"><?php echo Yii::t("goods", "收藏商品"); ?></span></dd>
    </dl>
    <dl style="display:none;" id="bshareDL">
    <div class="bshare-custom"><a href="http://www.bShare.cn/" id="bshare-shareto" class="bshare-more"><?php echo Yii::t("goods", "分享到"); ?></a><a class="bshare-sinaminiblog"><?php echo Yii::t("goods", "新浪微博"); ?></a><a title="MOre" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/button.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><a class="bshareDiv" onclick="javascript:return false;"></a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
    </dl>
</div>