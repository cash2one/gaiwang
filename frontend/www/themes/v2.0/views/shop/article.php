<?php
/** @var $model StoreArticle */
?>
<div class="shopArticleDetail">
    <div class="content">
          <!-- 去掉反斜线 -->
        <?php echo str_replace('\&quot;', '', $model->content);?>
    </div>
</div>