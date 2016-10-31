<div class="bannerSlide02 editor" id="diy">
    <div class="editTipsImg" style="height: 393px;">
        <?php
        if(!empty( $design->tmpData[DesignFormat::TMP_MAIN_diy])){
            echo $design->tmpData[DesignFormat::TMP_MAIN_diy];
        }else{
            echo Yii::t('sellerDesign','diy自定义区域');
        }
        ?>
    </div>
</div>

<div class="adbox02">
    <!-- 幻灯展示 -->
    <?php
    if (isset($design->tmpData[DesignFormat::TMP_MAIN_SLIDE]['Imgs'])):
        $this->widget('application.components.CommonWidget', array(
            'view' => 'banner',
            'data' => $design->tmpData[DesignFormat::TMP_MAIN_SLIDE]['Imgs'],
        ));
    else:
        ?>
        <div class="bannerSlide02 editor" id="banner">
            <div class="editTipsImg" style="height: 393px;"></div>
        </div>
    <?php endif; ?>
    <!-- end 幻灯展示 -->
</div>
<div class="busiProCate clearfix">
    <?php
    if (isset($design->tmpData[DesignFormat::TMP_MAIN_AD]['Imgs'])):
        $this->widget('application.components.CommonWidget', array(
            'view' => 'bannerBox',
            'data' => $design->tmpData[DesignFormat::TMP_MAIN_AD]['Imgs'],
        ));
    else:
        ?>
        <div class="bannerBox editor clearfix" id="probanner">
            <div class="editTipsImg" style="height: 145px;"></div>
        </div>
    <?php endif; ?>
</div>
<div class="clearfix">
    <div class="main_left">
        <?php
        // 商家服务信息
        $this->widget('application.components.ServiceWidget',
            array('store' => $this->store, 'design' => $design->tmpData[DesignFormat::TMP_LEFT_CONTACT]));
        ?>
        <?php
        // 商家分类信息
        $this->widget('application.components.CommonWidget', array(
            'view' => 'scategory',
            'data' => Scategory::scategoryInfo($this->store->id),
        ));
        ?>
        <?php
        // 热门销售
        $this->widget('application.components.HotWidget', array(
            'storeId' => $this->store->id,
            'tmpData' => $design->tmpData[DesignFormat::TMP_LEFT_PROLIST]
        ));
        ?>
        <?php
        // 历史浏览
        $this->widget('application.components.CommonWidget', array(
            'view' => 'historybrowse',
            'method' => 'getHistoryBrowse',
        ));
        ?>
    </div>

    <div class="main_rightContent">
        <?php
        // <!--优惠券-->
        $this->widget('application.components.CommonWidget', array(
            'view' => 'coupon',
            'data' => '',
        ));
        ?>

        <?php // 推荐列表
        $this->widget('application.components.GoodsRecommendWidget', array(
            'storeId' => $this->store->id,
            'design' => $design->tmpData[DesignFormat::TMP_RIGHT_PROLIST]
        ));
        $this->widget('application.components.GoodsListWidget', array(
            'storeId' => $this->store->id,
            'design' => $design->tmpData[DesignFormat::TMP_RIGHT_PROLIST_2],
            'route' => $this->route
        ));
        ?>

    </div>

</div>