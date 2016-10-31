<?php
//侧栏分类导航

// 获取cid 分类ID
$cid = Yii::app()->request->getQuery('cid', 0);
$store_id = Yii::app()->request->getQuery('id');

?>
<div class="storeCate editor" id="shopCat">
    <div class="title">
        <span class="en">CLASSIFCATION OF GOODS</span>
        <h3><?php echo Yii::t('goods','店铺分类');?></h3>
    </div>
    <div class="content">
        <dl class="allProd">
            <dt>
                <?php echo CHtml::link(Yii::t('shop','查看所有商品'),array('shop/product','id'=>$store_id),array('class'=>'icon_v iconAdd')); ?>
            </dt>
            <dd>
                <?php echo CHtml::link('按销量',array('shop/product','order'=>1,'id'=>$store_id)); ?>
                <?php echo CHtml::link('按价格',array('shop/product','order'=>3,'id'=>$store_id)); ?>
                <?php echo CHtml::link('按评价',array('shop/product','order'=>4,'id'=>$store_id)); ?>
            </dd>
        </dl>

        <?php if (!empty($data)): ?>
            <?php foreach ($data as $key => $val): ?>
                <dl class="prodMenu">
                    <dt>
                        <?php
                        if(!isset($val['child'])){
                            $url = Yii::app()->createAbsoluteUrl('shop/product', array('id' =>$store_id, 'cid' => $val['id']));
                            $className = 'icon_v iconMinus';
                        }else{
                            $url = 'javascript:void(0);';
                            $className = 'icon_v iconAdd';
                        }
                        echo CHtml::link(Yii::t('category',$val['name']),$url , array(
                            'class' => $className,
                            'onclick' => 'showHide(this, "items' . $key . '");',
                        ));
                        ?>
                    </dt>
                    <?php if (isset($val['child'])): ?>
                        <dd class="clearfix" id="items<?php echo $key ?>">
                            <?php foreach ($val['child'] as $k => $v): ?>
                                <?php echo CHtml::link(Yii::t('category',$v['name']), Yii::app()->createAbsoluteUrl('shop/product', array('id' => $store_id, 'cid' => $v['id'])), array('title' => Yii::t('category',$v['name']), 'class' => ($v['id'] == $cid) ? 'curr' : '')); ?>
                            <?php endforeach; ?>
                        </dd>
                    <?php endif; ?>
                </dl>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>