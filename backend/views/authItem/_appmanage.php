<tr>
    <td rowspan="3">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.GateApp', $rights)): ?>checked="checked"<?php endif; ?> value="Main.GateApp" id="GateApp"><label for="GateApp">盖象APP</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Contract', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Contract" id="SubContract"><label for="SubContract">盖象APP主题</label>
    </td>
    
   
    <td>
        <?php $this->renderPartial('_appemallconfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
     <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Hot', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Hot" id="SubHot"><label for="SubContract">盖象APP热门分类</label>
    </td>
    <td>
        <?php $this->renderPartial('_appHotConfig', array('rights' => $rights)); ?>
    </td>
</tr>
<tr>
     <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.Service', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.Service" id="SubService"><label for="SubService">售后&咨询</label>
    </td>
    <td>
        <?php $this->renderPartial('_appServiceConfig', array('rights' => $rights)); ?>
    </td>
</tr>
