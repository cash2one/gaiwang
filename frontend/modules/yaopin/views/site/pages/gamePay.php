<div class="main w1200">
    <div class="gamePayCont">
        <h3 class="title">帐号充值</h3>
        <div class="gamePayTo">
            <table class="paySelect" cellpadding="0" cellspacing="0" border="0" width="900">
                <tr>
                    <td height="40"><input type="radio" name="gameCate" checked /><label>直接充值到游戏</label></td>
                    <td><input type="radio" name="gameCate"  /><label class="red">充值到平台币</label></td>
                </tr>
                <tr>
                    <td height="40">
                        <select class="selUser">
                            <option value="魔力宝贝">魔力宝贝</option>
                            <option value="女神联盟">女神联盟</option>
                            <option value="天天富翁">天天富翁</option>
                            <option value="挂机传奇">挂机传奇</option>
                            <option value="塔防海贼王">塔防海贼王</option>
                            <option value="赤月版传奇">赤月版传奇</option>
                            <option value="争雄三国">争雄三国</option>
                            <option value="新天龙八部">新天龙八部</option>
                        </select>
                    </td>
                    <td>
                        <select class="selUser">
                            <option value="盖网">盖网</option>
                            <option value="盖象">盖象</option>
                        </select>
                    </td>
                </tr>
            </table>
            <hr>
            <div class="userInfo">
                <table class="paySelect" cellpadding="0" cellspacing="0" border="0" width="900">
                    <tbody>
                    <th colspan="3">请填写并确认充值信息</th>
                    <tr>
                        <td class="w120"><label>您需要充值的帐号:</label></td>
                        <td class="w250"><input type="text" class="userAccount" disabled="true" value="" placeholder="帐号" /></td>
                        <td class="red">填写有角色的帐号</td>
                    </tr>
                    <tr>
                        <td class="w120"><label>您确认充值的帐号:</label></td>
                        <td class="w250"><input type="text" class="userAccount" disabled="true" value="" placeholder="帐号" /></td>
                        <td class="red">填写上面的帐号</td>
                    </tr>
                    </tbody>
                </table>	
            </div>
            <hr>
            <div class="selAmount" id="selAmount">
                <dl>
                    <dt>请选择金额</dt>
                    <dd>
                        <a href="javascript:;" class="amount">10元</a>
                        <a href="javascript:;" class="amount">20元</a>
                        <a href="javascript:;" class="amount">30元</a>
                        <a href="javascript:;" class="amount">50元</a>
                        <a href="javascript:;" class="amount">100元</a>
                        <a href="javascript:;" class="amount">200元</a>
                        <a href="javascript:;" class="amount">300元</a>
                        <a href="javascript:;" class="amount">500元</a>
                        <a href="javascript:;" class="amount">1000元</a>
                    </dd>
                    <dd class="ddBlock">其他金额：<input type="text" value="" disabled="true" class="payAmount" />单笔金额最少为1元<span class="red">(输入全额的时候请键盘输入)</span></dd>

                </dl>
            </div>
            <hr>
            <div class="selBank">
                <h3>请选择支付方式</h3>
                <ul class="bankList clearfix">
                    <li><input type="radio" name="selBank" checked /><span class="bank01"></span></li>
                    <li><input type="radio" name="selBank" /><span class="bank02"></span></li>
                    <li><input type="radio" name="selBank" /><span class="bank03"></span></li>
                    <li><input type="radio" name="selBank" /><span class="bank04"></span></li>
                </ul>
                <p>充值<span class="red">0</span>元，可以获得<span class="red">0</span>元宝</p>
            </div>
            <hr>
            <div class="submitPay"><input type="submit" value="立即支付" /></div>
        </div>
    </div>

</div>