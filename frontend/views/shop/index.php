<div class="adbox02">
    <?php
    echo  $this->design->tmpData[DesignFormat::TMP_MAIN_diy];
    ?>
</div>

<div class="adbox02">
    <?php if ($this->id == 'shop' && ($this->action->id == 'view' || $this->action->id == 'preview')): ?>
        <!-- 幻灯展示 -->
        <?php
        $slide = $this->design->tmpData[DesignFormat::TMP_MAIN_SLIDE];
        $slide = isset($slide['Imgs']) ? $slide['Imgs'] : null;
        if ($slide) {
            $this->widget('application.components.CommonWidget', array(
                'view' => 'banner',
                'data' => $slide,
            ));
        }
        ?>
        <!-- end 幻灯展示 -->
    <?php endif; ?>
</div>
<div class="busiProCate clearfix">
    <?php
    # 3个图片的静态广告
    if (isset($design->tmpData[DesignFormat::TMP_MAIN_AD]['Imgs'])) {
        $this->widget('application.components.CommonWidget', array(
            'view' => 'bannerBox',
            'data' => $design->tmpData[DesignFormat::TMP_MAIN_AD]['Imgs'],
        ));
    }
    ?>
</div>
<div class="clearfix">
    <div class="main_left001">
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

    <div class="main_rightContent001">
        <?php
        // <!--优惠券-->
//        $this->widget('application.components.CommonWidget', array(
//            'view' => 'coupon',
//            'modelClass' => 'CouponActivity',
//            'criteriaOptions'=>array(
//                'select'=>'id,update_time,`name`,price,`condition`,valid_start,valid_end,sendout,excess,`status`,thumbnail,state',
//                'order'=>'create_time DESC',
//                'condition'=>'store_id=:storeId and status=:status and valid_end>=:endTime',
//                'params'=>array(
//                    ':storeId'=>$this->store->id,
//                    ':status'=>CouponActivity::COUPON_STATE_YES,
//                    ':endTime'=>time(),
//                ),
//            )
//        ));
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