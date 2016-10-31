<?php $this->breadcrumbs = array(Yii::t('gameExpend', '游戏管理'), Yii::t('gameExpend', '撤销兑换金币列表')); ?>
<?php $this->renderPartial('_search', array('model' => $model));?>
        <div class="c10"></div>
        <div id="gameExpend-grid" class="grid-view">
            <table class="tab-reg">
                <thead>
                <tr>
                    <th id="brand-grid_c0">GW号</th>
                    <th id="brand-grid_c1">撤销金币数量</th>
                    <th id="brand-grid_c2">剩余金币数量</th>
                    <th id="brand-grid_c3">是否成功</th>
                    <th id="brand-grid_c4">执行者</th>
                    <th id="brand-grid_c5">时间</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                <?php if(!empty($data)):?>
                    <?php foreach($data as $v):?>
                        <tr class=<?php echo $i%2==0 ? "even" : "odd";?>>
                            <td><?php echo $v['gai_number'];?></td>
                            <td><?php echo $v['expenditure'];?></td>
                            <td><?php echo $v['gold_num'];?></td>
                            <td><?php echo GameExpend::getState($v['result_code']);?></td>
                            <td><?php echo $v['username'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v['create_time']);?></td>
                        </tr>
                        <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>

            <div class="pager">
                    <?php
                    $this->widget('CLinkPager', array(
                            'header' => '',
                            'cssFile' => false,
                            'firstPageLabel' => Yii::t('page', '首页'),
                            'lastPageLabel' => Yii::t('page', '末页'),
                            'prevPageLabel' => Yii::t('page', '上一页'),
                            'nextPageLabel' => Yii::t('page', '下一页'),
                            'pages' => $pages,
                            'maxButtonCount' => 13
                        )
                    );
                    ?>
            </div>
        </div>





