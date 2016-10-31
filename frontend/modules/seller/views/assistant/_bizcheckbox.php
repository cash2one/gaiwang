<?php
/** @var $v Franchisee */
?>
<table>
    <?php foreach($franchisee as $v): ?>
    <tr>
        <td><?php echo $v->name ?> <input type="checkbox" class="firstItem franchisee_name"/></td>
        <td>
            <?php foreach ($items as $item => $val): ?>
                <span>
                    <?php $valChild = is_array($val) ? $val['value'] : $val ?>
                    <input type="checkbox"
                           name="item[]" <?php echo $this->checkPermission($permissions, $valChild.'|||'.$v->id) ? 'checked' : '' ?>
                           class="item secondItem" value="<?php echo $valChild.'|||'.$v->id ?>">
                    <b><?php echo $item ?></b>
                    <?php if (isset($val['actions']) && is_array($val['actions'])): ?>
                        {
                        <?php foreach ($val['actions'] as $action => $name): ?>
                            <input type="checkbox"
                                   name="item[]" <?php echo $this->checkPermission($permissions, $action.'|||'.$v->id) ? 'checked' : '' ?>
                                   class="item" value="<?php echo $action.'|||'.$v->id ?>"/>
                            <?php echo $name ?>
                        <?php endforeach; ?>
                        }
                    <?php endif; ?>
                    </span>
                <br/>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>