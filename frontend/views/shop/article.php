<?php
/** @var $model StoreArticle */
?>
<div class="shopArticleDetail">
    <div class="title clearfix">
        <span class="artTip">Article</span>
        <span class="artTit"><?php echo CHtml::encode($model->title); ?></span>
    </div>
    <div class="content">
          <!-- 去掉反斜线 -->
        <?php echo stripslashes($model->content) ?>
    </div>
</div>