<div class="packageList">
    <div class="packageAbout">
        <ul class="clearfix">
            <li>
                <b>合约计划：</b>
                <select>
                    <option value="广州市">广州市</option>
                </select>&nbsp;&nbsp;|&nbsp;中国电信&nbsp;|“购机入网送话费”
            </li>
            <li><b>合约期：</b><i class="planDat">48个月</i></li>
            <li><b>套餐类型：</b><i class="planCat">新乐享4G上网版</i>套餐资费详情</li>
            <li></li>
        </ul>
    </div>
    <div class="packageDetail">
        <table class="packageCont">
            <colgroup>
                <col width="150">
                <col width="150">
                <col width="150">
                <col width="380">
                <col width="150">
                <col width="150">
                <col width="150">
            </colgroup>
            <thead>
                <tr>
                    <th class="radiusLeft">套餐月费</th>
                    <th>合约期赠送话费总额</th>
                    <th>套餐内每月实际缴费</th>
                    <th>返还话费规则(48个月)</th>
                    <th>通话时长(分钟)</th>
                    <th>短信条数</th>
                    <th class="radiusRight">上网流量</th>
                </tr>
            </thead>        
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($taocan as $v): ?>
                    <tr <?php if ($i == 0): ?>style="background-color: #fffacd"<?php endif; ?>>
                        <td><input type="radio" name="HeyuejiForm[taocan]" value="<?php echo $i; ?>" <?php if ($i == 0): ?>checked="checked"<?php endif; ?> onclick="changeBg(this)"  data-name="chk"/><b class="colore80800"><?php echo $v['fee']; ?></b>元/月</td>
                        <td><?php echo $v['give']; ?></td>
                        <td><?php echo $v['real_pay']; ?></td>
                        <td><?php echo $v['retCallRules']; ?></td>
                        <td><?php echo $v['duration']; ?></td>
                        <td><?php echo $v['msgNum']; ?></td>
                        <td><?php echo $v['flow']; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="7"><a href="javascript:" title="" class="btnPackage" onclick="showReturn()">确认套餐</a></td>
                </tr>
            </tbody>        
        </table>
    </div>
</div>
