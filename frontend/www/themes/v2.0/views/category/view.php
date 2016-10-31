    <!--loading效果start-->
    <div class="gx-loading" style="display:none"><img width="124" height="124" src="<?php echo $this->theme->baseUrl;?>/images/bgs/loading2.gif"/></div>
    <!--loading效果end-->
    <!-- 面包屑start -->
    <div class="positionWrap goods-positionWrap pt10">
        <div class="position clearfix goods-position">
            <?php 
                $cat = array_reverse(Category::getTreeById($this->category_id));
                echo CHtml::link('首页&nbsp;&gt;&nbsp;',Yii::app()->homeUrl,array('class'=>'position-a'));
                foreach ($cat as $c){
                   if(end($cat) == $c){
                        echo CHtml::link(Category::getCategoryName($c),$this->createAbsoluteUrl('category/list',array('id'=>$c)),array('class'=>'position-a'));
                   } else {
                        echo CHtml::link(Category::getCategoryName($c).'&nbsp;&gt;&nbsp;',$this->createAbsoluteUrl('category/list',array('id'=>$c)),array('class'=>'position-a'));
                   }
                }
                $category = Category::searchCatTreeData($this->category_id,false);
            ?>
            <div class="goods-total"><?php echo HtmlHelper::langsTextConvert(Yii::t('category','共') .CHtml::tag('span',array(),'{value}'). Yii::t('category','件相关商品'), $goodsCount) ?></div>
        </div>
    </div>
    <!-- 面包屑end -->
    <!-- 商品筛选start -->
    <?php $p = array_merge($params,$searchAttribute);?>
    <!-- 商品筛选end -->
    
    <!-- 列表start -->
    <div class="goods-list">
    <?php $this->renderPartial('_sort',array('p'=>$p,'params'=>$params,'searchAttribute'=>$searchAttribute,'pager'=>$pager))?>
    </div>
    <?php if(!empty($goods)):?>
    <ul class="goods-list-main clearfix">
        <?php $this->renderPartial('_goodslist',array('p'=>$p,'params'=>$params,'searchAttribute'=>$searchAttribute,'goods'=>$goods))?>  
    </ul>
    <?php else:?>
        <div class="goods-prompt"><?php echo Yii::t('category','抱歉，没找到任何商品。');?></div>
    <?php endif;?>
    <!--列表end-->
    <!--分页start-->
    <div class="pageList mb50 clearfix">
    <?php $this->renderPartial('_pager',array('pager'=>$pager))?>     
    </div>
    <!--分页end-->
    <div class="gx-bot-module gx-bot-module-goods clearfix">
        <?php echo $this->renderPartial('//site/_doyoulike')?>
    </div>
    <script>
        var b,s,m; //定义三个个全局变量缓存ajax返回数据 //暂时不弄
        jQuery('#search-brand').on('click',function(){
            var brand = jQuery('#brand').val();
            morebrand(brand,10);
        });
        /*商品筛选start*/
        var selIS=0;//是否多选(0为单选/1为多选)
        $(".gs-brandSel").delegate('dl dd','click',function(){
            if(selIS==0){
                $(".gs-sel").hide();
                $(this).find(".gs-sel").toggle();
            }else{
                var $this = $(this);
                var icon = $this.children('a').attr('icon'),
                    alt = $this.find('img').attr('alt');
                if(!$('#brand_alt').length){
                    var input_name ="<input type='hidden' name='brand_name' id='brand_alt' value="+alt+">";
                    $('#brand-form .gs-brandSel').append(input_name);
                }
                if(!$('#brand_icon').length){
                    //不存在，该品牌时，添加input框
                    var input_id = "<input type='hidden' name='brand_id' id='brand_icon' value="+icon+">";
                    $('#brand-form .gs-brandSel').append(input_id);
                } else {
                    //存在移除
                    var val = $('#brand_alt').val();
                    var ival = $('#brand_icon').val();
                    if(ival.indexOf(icon) == -1){
                        ival = icon + ',' + ival;
                        $('#brand_icon').val(ival);
                        val = alt + '、' + val;
                        $('#brand_alt').val(val);
                    } else {
                        if(ival.indexOf(',') == -1){
//                            ival = ival.replace(icon,'');
                            $('#brand_icon').remove();
                            $('#brand_alt').remove();
                        } else{
                            ival = ival + ',';
                            ival = ival.replace(icon+',','');
                            ival = ival.split("").reverse().join("").substr(1).split("").reverse().join("");
                            $('#brand_icon').val(ival);
                            val = val + '、';
                            val = val.replace(alt+'、','');
                            val = val.split("").reverse().join("").substr(1).split("").reverse().join(""); //反转，再反转回来
                            $('#brand_alt').val(val);
                        }
                    }
                    
                }
                $this.find(".gs-sel").toggle();
            }

        });
        //品牌更多
        $(".gs-more1").click(function(){
            if(!$(this).hasClass('gs-moreSel')){
                $(this).text("收起");
                $(this).addClass("gs-moreSel");
                $(".gs-brandSel").addClass("gs-brandSel-DX");
                morebrand(null,null);
            }else{
                $(this).text("更多");
                $(this).removeClass("gs-moreSel");
                $(".gs-brandSel").animate({scrollTop:0},200).removeClass("gs-brandSel-DX");
                morebrand(null,10);
            }
        });
        //品牌取消
        $(".gs-brandBut-right").click(function(){
            $(".gs-brandSel").animate({scrollTop:0},200).removeClass("gs-brandSel-DX");
            $(".gs-selectsBut").show();
            $(".gs-more").show();
            $(".gs-brandBut").hide();
            $(".gs-sel").hide();
            selIS=0;
            morebrand(null,10);
        });    
        
        //品牌多选
        $(".gs-selectsBut").click(function(){
            selIS=1;
            $(".gs-brandSel").addClass("gs-brandSel-DX");
            $(this).hide();
            $(".gs-more").hide();
            $(".gs-brandBut").show();
            morebrand(null,null,true);
        });
        
        function morebrand(brand,limit,is_multi)
        {
            var csrf = '<?php echo Yii::app()->request->csrfToken; ?>';
            var url ='<?php echo $this->createurl('category/brand',  array_merge($params,$searchAttribute))?>';
            var search = {'YII_CSRF_TOKEN':csrf,'brand':brand,'limit':limit,'is_multi':is_multi,'id':<?php echo $this->id?>};
            jQuery.get(url,search,function(data){
                if(data.msg==0){
                	$(".gs-brandSel").removeClass("gs-brandSel-DX");
                  }
                jQuery('.gs-brandSel').html(data.brand); 
            },'json'); 
        }
        
        function getCategory(obj)
        {
            $('.gx-loading').show();
            //goods-screening  goods-list goods-ul pageList goods-total
            var url = $(obj).attr('tar');
            $.get(url,{},function(data){
                $('.gx-content .goods-screening').html(data.search);
                $('.gx-content .goods-list').html(data.sort);
                $('.gx-content .goods-ul').html(data.goodslist);
                $('.gx-content .pageList').html(data.pagelist);
                $('.gx-content .goods-total span').html(data.goodsCount);
                $('.gx-loading').fadeOut(200);
                $('.goods-type span').html($(obj).text());
                $(obj).addClass('col888').siblings().removeClass('col888');
            },'json');
        }
    </script>