

<div class="help-sidebar">
            <span class="help-index"><i class="help-sidebar-icon help"></i><?php echo Yii::t('help', '帮助中心')?></span>
            <ul id="helplist" class="helplist">
		      <?php foreach ($infos as $v): ?>
                <li <?php if(isset($article['category_id']) && ($article['category_id'] == $v['id'])): ?> class="active" <?php endif; ?>>
                    <a href="javascript:void(0)" class="item-name"><?php echo Yii::t('help', $v['name']) ?><i class="help-sidebar-icon <?php if (isset($article['category_id']) && ($article['category_id'] == $v['id'])): ?> minus <?php else:?> add <?php endif; ?>"></i></a>
                    <ul class="sub-helplist" <?php if (isset($article['category_id']) && ($article['category_id'] != $v['id'])): ?>style="display:none" <?php endif;?>>
                        <?php foreach ($v['child'] as $c): ?>
                        <li data-id="<?php echo $c['alias'];?>" class="click <?php if(isset($article['alias']) && $article['alias'] == $c['alias']):?>active<?php endif;?>" >
                          <a class="subitem-name" href="<?php echo $this->createAbsoluteUrl('/help/article/view', array('alias' => $c['alias']))?>"><?php echo  Yii::t('help', $c['title']);?></a> 
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
		    <?php endforeach; ?>
            </ul>
        </div>