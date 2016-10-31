<tr>
    <td rowspan="6">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.SiteConfigurationManagement', $rights)): ?>checked="checked"<?php endif; ?> value="Main.SiteConfigurationManagement" id="MainSiteConfigurationManagement"><label for="MainSiteConfigurationManagement">网站配置管理</label>
    </td>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Config', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Config" id="SubConfig"><label for="SubConfig">网站配置管理</label>
    </td>   
    <td>
        <?php $this->renderPartial('_siteconfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Score', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Score" id="SubScore"><label for="SubScore">积分配置管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_scoreconfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Charity', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Charity" id="SubCharity"><label for="SubCharity">盖网通公益管理</label>
    </td>
    <td>
        <label>捐款列表</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Charity.Admin', $rights)): ?>checked="checked"<?php endif; ?> value="Charity.Admin" id="CharityAdmin">
        <label for="CharityAdmin">查看</label>
        )
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Data', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Data" id="SubCharity"><label for="SubData">网站数据管理</label>
    </td>
    <td>
        <label>缓存管理</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Cache.Admin', $rights)): ?>checked="checked"<?php endif; ?> value="Cache.Admin" id="CacheAdmin">
        <label for="CacheAdmin">查看列表</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Cache.Clear', $rights)): ?>checked="checked"<?php endif; ?> value="Cache.Clear" id="CacheClear">
        <label for="CacheClear">清除缓存</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Cache.Floor', $rights)): ?>checked="checked"<?php endif; ?> value="Cache.Floor" id="CacheFloor">
        <label for="CacheFloor">生成缓存</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('Cache.GetAllCache', $rights)): ?>checked="checked"<?php endif; ?> value="Cache.GetAllCache" id="CacheGetAllCache">
        <label for="CacheGetAllCache">更新所有缓存</label>
        )
        <label>多语言-后台</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.LanguageBackend', $rights)): ?>checked="checked"<?php endif; ?> value="Home.LanguageBackend" id="HomeLanguageBackend">
        <label for="HomeLanguageBackend">查看修改</label>
        )
        <label>多语言-前台</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.LanguageFrontend', $rights)): ?>checked="checked"<?php endif; ?> value="Home.LanguageFrontend" id="HomeLanguageFrontend">
        <label for="HomeLanguageFrontend">查看修改</label>
        )
        <label>多语言-API</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.LanguageApi', $rights)): ?>checked="checked"<?php endif; ?> value="Home.LanguageApi" id="HomeLanguageApi">
        <label for="HomeLanguageApi">查看修改</label>
        )
    </td>
</tr>
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Hongbao', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Hongbao" id="SubCharity"><label for="SubRed">红包配置管理</label>
    </td>
    <td>
        <label>线下红包配置</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.HongbaoConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.HongbaoConfig" id="HomeRedConfig">
        <label for="HomeRedConfig">查看修改</label>
        )
    </td>
</tr>

<!-- 新增盖象优选APP配置 -->
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.AppPayManage', $rights)): ?>checked="checked"<?php endif; ?> value="AppPayManage" id="SubAppPayManage"><label for="SubAppPayManage">盖象优选APP支付配置</label>
    </td>
    <td>
        <?php $this->renderPartial('_subapppaypanageconfig', array('rights' => $rights)); ?>
    </td>
</tr>

<!-- 盖付通配置 -->
<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Gft', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Gft" id="SubGaifutong"><label for="SubGaifutong">盖付通设置</label>
    </td>
    <td>
        <label>银行卡支付方式设置</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.PayMentlistConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.PayMentlistConfig" id="PayMentlistConfig">
        <label for="PayMentlistConfig">查看修改</label>
        )

        <label>是否开启菜单选项</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.GftMenuConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.GftMenuConfig" id="HOMEGftMenuConfig">
        <label for="HOMEGftMenuConfig">查看修改</label>
        )

        <label>主菜单设置</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('GftMenuConfig.Index', $rights)): ?>checked="checked"<?php endif; ?> value="GftMenuConfig.Index" id="GftMenuConfigIndex">
        <label for="GftMenuConfigIndex">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('GftMenuConfig.Create', $rights)): ?>checked="checked"<?php endif; ?> value="GftMenuConfig.Create" id="GftMenuConfigCreate">
        <label for="GftMenuConfigCreate">新增</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('GftMenuConfig.Update', $rights)): ?>checked="checked"<?php endif; ?> value="GftMenuConfig.Update" id="GftMenuConfigUpdate">
        <label for="GftMenuConfigUpdate">编辑</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('GftMenuConfig.Delete', $rights)): ?>checked="checked"<?php endif; ?> value="GftMenuConfig.Delete" id="GftMenuConfigDelete">
        <label for="GftMenuConfigDelete">删除</label>
        )
    </td>
</tr>

<!-- 该掌柜配置 -->
<tr>
    <td></td>
     <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Gzg', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Gzg" id="SubGzg"><label for="SubGzg">该掌柜配置</label>
    </td>   
    <td>
        <label>银行卡支付方式设置</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.GzgPayMentlistConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.GzgPayMentlistConfig" id="HOMEGzgPayMentlistConfig">
        <label for="HOMEGzgPayMentlistConfig">查看修改</label>
        )
    </td>
</tr>

<!-- 便民服务 -->
<tr>
<td></td>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.MobileRange', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.MobileRange" id="SubMobileRange"><label for="SubMobileRange">便民服务</label>
    </td>
    <td>
        <label>手机号码段管理</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('MobileRange.Index', $rights)): ?>checked="checked"<?php endif; ?> value="MobileRange.Index" id="MobileRange">
        <label for="MobileRange">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('MobileRange.Import', $rights)): ?>checked="checked"<?php endif; ?> value="MobileRange.Import" id="MobileRange">
        <label for="MobileRange">编辑</label>
        )
    
        <label>话费充值价格表</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('mobileMoneyRechargeConfig.Index', $rights)): ?>checked="checked"<?php endif; ?> value="mobileMoneyRechargeConfig.Index" id="mobileMoneyRechargeConfig">
        <label for="mobileMoneyRechargeConfig">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('mobileMoneyRechargeConfig.Import', $rights)): ?>checked="checked"<?php endif; ?> value="mobileMoneyRechargeConfig.Import" id="mobileMoneyRechargeConfig">
        <label for="mobileMoneyRechargeConfig">编辑</label>
        )
   
        <label>流量充值价格表</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('MobileFlowRechargeConfig.Index', $rights)): ?>checked="checked"<?php endif; ?> value="MobileFlowRechargeConfig.Index" id="MobileFlowRechargeConfig">
        <label for="MobileFlowRechargeConfig">查看</label>
        <input type="checkbox" name="rights[]" <?php if (in_array('MobileFlowRechargeConfig.Import', $rights)): ?>checked="checked"<?php endif; ?> value="MobileFlowRechargeConfig.Import" id="MobileFlowRechargeConfig">
        <label for="MobileFlowRechargeConfig">编辑</label>
        )
    </td>
</tr>
<!-- 电子化合同签约管理 -->
<tr>
    <td></td>
     <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.ElectronicSigningContract', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.ElectronicSigningContract" id="SubElectronicSigningContract"><label for="SubElectronicSigningContract">电子化合同签约管理</label>
    </td>   
    <td>
        <label>电子化签约合同模板</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.OfflineSignContractConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.OfflineSignContractConfig" id="HomeOfflineSignContractConfig">
        <label for="HomeOfflineSignContractConfig">编辑</label>
        )
    
        <label>电子化签约示例图片配置</label>
        (
        <input type="checkbox" name="rights[]" <?php if (in_array('Home.OfflineSignDemoImgsConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Home.OfflineSignDemoImgsConfig" id="HomeOfflineSignDemoImgsConfig">
        <label for="HomeOfflineSignDemoImgsConfig">编辑</label>
        )
    </td>
</tr>

<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Contract', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Contract" id="SubCharity"><label for="SubContract">网签合同管理</label>
    </td>
    <td>
        <?php
            $config = array(
                '盖网通及网店合同'=>array(
                    '查看修改'=>'Home.ContractStore',
                ),
//                '盖网通及网店合同(免费)'=>array(
//                    '查看修改'=>'Home.ContractStore2',
//                ),
                '网店管理规范及合作结算流程'=>array(
                    '查看修改'=>'Home.Management',
                ),
//                '合作及结算流程'=>array(
//                    '查看修改'=>'Home.Settlement',
//                ),
//                '承诺书'=>array(
//                    '查看修改'=>'Home.Commitment',
//                ),
//                '自有品牌承诺书'=>array(
//                    '查看修改'=>'Home.Commitment2',
//                ),
            );



        $this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
        ?>

    </td>
</tr>
