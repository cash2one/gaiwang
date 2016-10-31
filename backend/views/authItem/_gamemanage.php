<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.GameConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Main.GameConfig" id="GameConfig"><label for="GameConfig">游戏管理</label>
    </td>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.GameConfig', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.GameConfig" id="SubGameConfig"><label for="SubGameConfig">游戏配置</label>
    </td>
    <td>
        <?php $this->renderPartial('_gameconfig', array('rights' => $rights)); ?>
    </td>
</tr>