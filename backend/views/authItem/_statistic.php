<tr>
    <td rowspan="7">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.StatisticsManagement', $rights)): ?>checked="checked"<?php endif; ?> value="Main.StatisticsManagement" id="MainStatisticsManagement"><label for="MainStatisticsManagement">统计管理</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.MemberStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.MemberStatistics" id="SubMemberStatistics"><label for="SubMemberStatistics">会员统计</label>
    </td>
    <td>
        <label>会员人数统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.MemberCount', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.MemberCount" id="StatisticsMemberCount">
        <label for="StatisticsMemberCount">查看</label>
        )
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.ShopStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.ShopStatistics" id="SubShopStatistics"><label for="SubShopStatistics">商铺统计</label>
    </td>
    <td>
        <label>商铺统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoreCount', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoreCount" id="StatisticsStoreCount">
        <label for="StatisticsStoreCount">查看</label>
        )
        &nbsp;&nbsp;
        &nbsp;&nbsp;
        <label>商铺排行</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoreList', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoreList" id="StatisticsStoreList">
        <label for="StatisticsStoreList">查看</label>
        )
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.GoodsStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.GoodsStatistics" id="SubGoodsStatistics"><label for="SubGoodsStatistics">商品统计</label>
    </td>
    <td>
        <label>商品统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.Product', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.Product" id="StatisticsProduct">
        <label for="StatisticsProduct">查看</label>
        )
        &nbsp;&nbsp;
        &nbsp;&nbsp;
        <label>商品分类统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CatProCount', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CatProCount" id="StatisticsCatProCount">
        <label for="StatisticsCatProCount">查看</label>
        )
        &nbsp;&nbsp;
        &nbsp;&nbsp;
        <label>商品排行</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.ProductList', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.ProductList" id="StatisticsProductList">
        <label for="StatisticsProductList">查看</label>
        )
    </td>
</tr>
<tr>  
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.OrderStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.OrderStatistics" id="SubOrderStatistics"><label for="SubOrderStatistics">订单统计</label>
    </td>
    <td>
        <label>订单统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.OrderCount', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.OrderCount" id="StatisticsOrderCount">
        <label for="StatisticsOrderCount">查看</label>
        )
    </td>
</tr>
<tr>  
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.PromotionStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.PromotionStatistics" id="SubPromotionStatistics"><label for="SubPromotionStatistics">推广统计</label>
    </td>
    <td>
        <label>推广渠道列表</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Admin', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.Admin" id="PromotionStatisticsAdmin">
        <label for="PromotionStatisticsAdmin">列表</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Create', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.Create" id="PromotionStatisticsCreate">
        <label for="PromotionStatisticsCreate">添加</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Admin', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.View" id="PromotionStatisticsView">
        <label for="PromotionStatisticsView">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Update', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.Update" id="PromotionStatisticsUpdate">
        <label for="PromotionStatisticsUpdate">编辑</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Delete', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.Delete" id="PromotionStatisticsDelete">
        <label for="PromotionStatisticsDelete">删除</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.Member', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.Member" id="PromotionStatisticsMember">
        <label for="PromotionStatisticsMember">新增用户列表</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('PromotionStatistics.MemberLog', $rights)): ?>checked="checked"<?php endif; ?> value="PromotionStatistics.MemberLog" id="PromotionStatisticsMemberLog">
        <label for="PromotionStatisticsMemberLog">查看登陆日志</label>
        )
    </td>
</tr>
<tr>  
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.OtherStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.OtherStatistics" id="SubOtherStatistics"><label for="SubOtherStatistics">其它统计</label>
    </td>
    <td>
        <!--        <label>短信统计</label>
                (
                <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.SmsCount', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.SmsCount" id="StatisticsSmsCount">
                <label for="StatisticsSmsCount">查看</label>
                )
                <br/>-->
        <label>商家总销售额统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoresRank', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoresRank" id="StatisticsStoresRank">
        <label for="StatisticsStoresRank">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoresRankExport', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoresRankExport" id="StatisticsStoresRankExport">
        <label for="StatisticsStoresRankExport">导出excel</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoreCustomerRank', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoreCustomerRank" id="StatisticsStoreCustomerRank">
        <label for="StatisticsStoreCustomerRank">商家下消费者消费排名</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoreCustomerRankExport', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoreCustomerRankExport" id="StatisticsStoreCustomerRankExport">
        <label for="StatisticsStoreCustomerRankExport">商家下消费者消费排名 导出excel</label>
        )
        <br/>
        <label>消费者总消费统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerRank', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerRank" id="StatisticsCustomerRank">
        <label for="StatisticsCustomerRank">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerRankExport', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerRankExport" id="StatisticsCustomerRankExport">
        <label for="StatisticsCustomerRankExport">导出excel</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerStoreRank', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerStoreRank" id="StatisticsCustomerStoreRank">
        <label for="StatisticsCustomerStoreRank">消费者下商家销售排名</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerStoreRankExport', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerStoreRankExport" id="StatisticsCustomerStoreRankExport">
        <label for="StatisticsCustomerStoreRankExport">消费者下商家销售排名 导出excel</label>
        )
        <br/>
        <label>商家近三天销售额统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoresRankExtend', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoresRankExtend" id="StatisticsStoresRankExtend">
        <label for="StatisticsStoresRankExtend">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.StoreCustomerRankExtend', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.StoreCustomerRankExtend" id="StatisticsStoreCustomerRankExtend">
        <label for="StatisticsStoreCustomerRankExtend">消费者消费占比排行</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.RankExport', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.RankExport" id="StatisticsRankExport">
        <label for="StatisticsRankExport">导出excel</label>
        )
        <br/>
        <label>消费者近一个月消费统计</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerRankExtend', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerRankExtend" id="StatisticsCustomerRankExtend">
        <label for="StatisticsCustomerRankExtend">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Statistics.CustomerStoreRankExtend', $rights)): ?>checked="checked"<?php endif; ?> value="Statistics.CustomerStoreRankExtend" id="StatisticsCustomerStoreRankExtend">
        <label for="StatisticsCustomerStoreRankExtend">消费者下商家销售排名</label>
        )
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.WeeklyStatistics', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.WeeklyStatistics" id="SubWeeklyStatistics"><label for="SubWeeklyStatistics">每周统计</label>
    </td>
    <td>
        <label>盖机数据</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.Machine', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.Machine" id="WeeklyStatisticsMachine">
        <label for="WeeklyStatisticsMachine">查看</label>

        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MachineExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MachineExport" id="WeeklyStatisticsMachineExport">
        <label for="WeeklyStatisticsMachineExport">导出excel</label>
        )
        <br/>
        <label>加盟商数据</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.Franchisee', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.Franchisee" id="WeeklyStatisticsFranchisee">
        <label for="WeeklyStatisticsFranchisee">查看</label>


        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.FranchiseeExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.FranchiseeExport" id="WeeklyStatisticsFranchiseeExport">
        <label for="WeeklyStatisticsFranchiseeExport">导出excel</label>
        )
        <br/>
        <label>会员数据</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.Member', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.Member" id="WeeklyStatisticsMember">
        <label for="WeeklyStatisticsMember">查看</label>


        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MemberExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MemberExport" id="WeeklyStatisticsMemberExport">
        <label for="WeeklyStatisticsMemberExport">导出excel</label>
        )
        <br/>

        <label>订单数据</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.Machine', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.Order" id="WeeklyStatisticsOrder">
        <label for="WeeklyStatisticsOrder">查看</label>


        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.OrderExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.OrderExport" id="WeeklyStatisticsOrderExport">
        <label for="WeeklyStatisticsOrderExport">导出excel</label>
        )
        <br/>

        <label>盖机每日运行时间</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MachineTime', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MachineTime" id="WeeklyStatisticsMachineTime">
        <label for="WeeklyStatisticsMachineTime">查看</label>

        <label for="WeeklyStatisticsMachineTimeExport">导出excel</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MachineTimeExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MachineTimeExport" id="WeeklyStatisticsMachineTimeExport">
        )
        <br/>

        <label>盖机最新运行时间</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MachineDelay', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MachineDelay" id="WeeklyStatisticsMachineDelay">
        <label for="WeeklyStatisticsMachineDelay">查看</label>

        <label for="WeeklyStatisticsMachineDelayExport">导出excel</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('WeeklyStatistics.MachineDelayExport', $rights)): ?>checked="checked"<?php endif; ?> value="WeeklyStatistics.MachineDelayExport" id="WeeklyStatisticsMachineDelayExport">
        )
    </td>
</tr>