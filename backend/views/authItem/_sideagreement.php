<tr>
    <td rowspan="1">
        <input type="checkbox" name="rights[]" <?php if (in_array('Main.SideAgreementManagement', $rights)) echo 'checked="checked"'; ?> value="Main.SideAgreementManagement" id="MainSideAgreementManagement">
        <label for="MainSideAgreementManagement">补充协议管理</label>
    </td>   
    <td>
        <input type="checkbox" name="rights[]" <?php if (in_array('Sub.contract', $rights)) echo 'checked="checked"'; ?> value="Sub.contract" id="Contract"><label for="Contract">补充协议管理</label>
    </td>
    <td>
        <?php $this->renderPartial('_sideagreementinfo', array('rights' => $rights)); ?>
    </td>
</tr>