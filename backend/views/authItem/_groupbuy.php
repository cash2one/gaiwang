<tr>
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.GroupbuyManagement', $rights)): ?>checked="checked"<?php endif; ?> value="Main.GroupbuyManagement" id="MainGroupbuyManagement"><label for="MainGroupbuyManagement">团购管理</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.groupbuy', $rights)): ?>checked="checked"<?php endif; ?> value="Sub.groupbuy" id="SubGroupbuy"><label for="SubGroupbuy">团购管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_groupbuyinfo', array('rights' => $rights)); ?>
    </td>
</tr>