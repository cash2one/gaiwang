<div class="sellerWebSignProgress">

    <?php
    $this->widget('zii.widgets.grid.CGridView',array(
        'dataProvider' => $model->searchRemarks($id),
        'itemsCssClass' => 'tab-reg4',
        'template' => '{items}{pager}',
        'columns' => array(
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'create_time',
                'value' => 'date("Y-m-d H:i:s",$data->create_time)',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'audit_role',
                'value' => 'OfflineSignAuditlogging::getRoleValue($data->audit_role)',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange tc','width' => '20%px'),
                'name' => 'auditor',
                'value' => '$data->auditor',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange','width' => '50%'),
                'name' => 'remark',
                'value' => '$data->remark',
            ),
        )
    ));
    ?>
</div>