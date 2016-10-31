            <!--<div class="gs-fdBut"><span class="more"><?php echo Yii::t('category','更多选项')?><ico></ico></span></div>-->
            <?php if(!empty($searchAttribute) && !(isset($searchAttribute['page']) && count($searchAttribute))):?>
            <dl class="clearfix">
                <dt><?php echo Yii::t('category','已选择')?></dt>
                <dd class="gs-ddmid">
                        <ul class="gs-xz clearfix">
                            <?php foreach ($searchAttribute as $k=>$s): if($k == 'brand_name' || $k== 'page') continue;?>
                            <?php if($k == 'brand_id'):?>  <!--除了这里其他地方都要-->
                            <?php
                                if(isset($p['brand_name'])){
                                    $brandName = $p['brand_name'];
                                    unset($p['brand_name']);
                                }
                            ?>
                                <li icon='<?php echo $k?>'><?php echo $brandName;?><a href="<?php  echo $this->createUrl('category/list',array_diff($p,array($k=>$s))); ?>"><span class="col"></span></a></li>
                            <?php else:?>
                                <li icon='<?php echo $k?>'><a href="<?php  echo $this->createUrl('category/list',array_diff($p,array($k=>$s))); ?>"><span class="col"></span></a></li>
                            <?php endif;endforeach;?>
                        </ul>
                </dd>
                <dd class="gs-ddright clearfix">
                    <a href="<?php echo $this->createUrl('category/list',$params)?>" class="gs-but gs-clearBut"><?php echo Yii::t('category','清除全部');?></a>
                </dd>
            </dl>
            <?php endif;?>
            <?php   
                if(isset($p['brand_id'])){
                     $p['brand_name'] = $brandName ;
                }
            ?>
            <?php if(!isset($searchAttribute['brand_id'])):?>
            <dl class="clearfix">
                <dt><?php echo Yii::t('categorys','品牌')?></dt>
                <dd class="gs-ddmid clearfix">
                    <input name="brand" placeholder="输入品牌名称" class="gs-sInp" id="brand"/>
                    <input type="button" value="搜索" class="gs-rBut" id="search-brand"/>
                    <?php 
                        $this->beginWidget('CActiveForm',array(
                            'id'=>'brand-form',
                            'method'=>'get',
                        ));
                    ?>
                    <div class="gs-brandSel" id="brand-sel">
                        <dl class="clearfix">
                            <?php  $brand = Brand::getBrandInfo($this->category_id,'',20);?>
                            <?php foreach ($brand as $b):?>
                            <?php if(!empty($b['logo'])):?>
                            <dd>
                                <?php
                                    //$params['brand_id'] = $b['id'];
//                                    $params['id'] = $this->category_id;
                                    echo CHtml::link(
                                        CHtml::image(Tool::showImg(IMG_DOMAIN . '/' .$b['logo'],'c_fill,h_40,w_100'),$b['name'],array('width'=>100,'height'=>42,'alt'=>$b['name'])),
                                        $this->createUrl('category/list',  array_merge($params,array('brand_id'=>$b['id'],'brand_name'=>$b['name']))),array('icon'=>$b['name'])
                                      );
                                ?>
                                <div class="gs-sel clearfix"><span></span></div>
                            </dd> 
                            <?php else:?>
                            <dd>
                                <?php
                                   echo CHtml::link(
                                           CHtml::tag('span', array('style'=>'display:inline-block;width:100%') ,$b['name']),
                                        $this->createUrl('category/list',  array_merge($params,array('brand_id'=>$b['id'],'brand_name'=>$b['name']))),array('icon'=>$b['name'])
                                      );
                                ?>
                                <div class="gs-sel clearfix"><span></span></div>
                            </dd>
                            <?php endif;?>
                            <?php endforeach;?>
                        </dl>
                    </div>
                    <div class="gs-brandBut clearfix">
                        <input type="submit" value="确定" class="gs-brandBut-left"/>
                        <input type="button" value="取消" class="gs-brandBut-right"/>
                    </div>
                    <?php $this->endWidget();?>
                </dd>
                <dd class="gs-ddright clearfix">
                    <span class="gs-but gs-selectsBut"><?php echo Yii::t('category','多选')?></span>
                    <span class="gs-more gs-more1"><?php echo Yii::t('category','更多')?></span>
                </dd>
            </dl>
            <?php endif;?>
            <div class="gs-line"></div>
<!--            <dl class="clearfix">
                    <dt>尺码</dt>
                    <dd class="gs-ddmid">
                            <ul class="gs-sizeList">
                                    <li>
                                            33
                                    </li>
                                    <li>
                                            33.5
                                    </li>
                                    <li>
                                            34
                                    </li>
                                    <li>
                                            34.5
                                    </li>
                                    <li>
                                            35
                                    </li>
                                    <li>
                                            35.5
                                    </li>
                                    <li>
                                            36
                                    </li>
                                    <li>
                                            36.5
                                    </li>
                                    <li>
                                            37
                                    </li>
                                    <li>
                                            37.5
                                    </li>
                                    <li>
                                            38
                                    </li>
                                    <li>
                                            38.5
                                    </li>
                                    <li>
                                            39
                                    </li>
                                    <li>
                                            39.5
                                    </li>
                                    <li>
                                            38
                                    </li>
                                    <li>
                                            38.5
                                    </li>
                                    <li>
                                            39
                                    </li>
                                    <li>
                                            39.5
                                    </li>
                            </ul>
                    </dd>
                    <dd class="gs-ddright clearfix">
                            <span class="gs-more gs-more2">更多</span>
                    </dd>
            </dl>-->
            <!--<div class="gs-line gs-line2"></div>-->
<!--    <dl class="clearfix">
        <dt>人群</dt>
        <dd>
                <ul class="gs-sizeList gs-RList">
                        <li>男士</li>
                        <li>情侣</li>
                        <li>中性</li>
                        <li>女士</li>
                        <li>儿童</li>
                </ul>
        </dd>
    </dl>-->
<!--    <div class="gs-moreInfo">
         <div class="gs-line gs-line2"></div>
         <dl class="clearfix">
                 <dt>其他</dt>
                 <dd>
                         <ul class="gs-sizeList gs-RList">
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                         </ul>
                 </dd>
         </dl>
         <div class="gs-line gs-line2"></div>
         <dl class="clearfix">
                 <dt>其他</dt>
                 <dd>
                         <ul class="gs-sizeList gs-RList">
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                                 <li>其他</li>
                         </ul>
                 </dd>
         </dl>
     </div>-->