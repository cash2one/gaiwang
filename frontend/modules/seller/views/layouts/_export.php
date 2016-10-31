<div  id="export-all" class="pager" style="display:none;">
        <?php if ($exportPages->getItemCount() > 0): ?>
        <div class="pager">
            （每份<?php echo $exportPages->pageSize; ?>条记录）:
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $exportPages,
                'cssFile' => false,
                'maxButtonCount' => 10000,
                'header' => false,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                'firstPageLabel' => false,
                'lastPageLabel' => false,
            ))
            ?>  
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/seller/'.$exportPages->route, $exportPages->params) ?>" ><?php echo Yii::t('main', '导出全部') ?></a>
        </div>
        <?php else: ?>
            <?php echo Yii::t('main','没有数据') ?>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript"  src="/js/iframeTools.source.js"></script>
<script type="text/javascript">
    function exportExcel() {
        art.dialog({
            content: $("#export-all").html(),
            title: '<?php echo Yii::t('main', '导出excel(该窗口在3秒后自动关闭)') ?>',
            time: 3
        }); 
    } 
   </script> 