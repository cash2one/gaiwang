<div class="sellerWebSignProgress">

    <?php
    $this->widget('GridView',array(
        'dataProvider' => $model->seachAuditSchedule($id),
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
                'name' => 'auditor',
                'value' => '$data->auditor',
            ),
            array(
                'headerHtmlOptions' => array('class' => 'bgOrange','width' => '50%'),
                'name' => 'event',
                'type' => 'raw',
                'value' => 'OfflineSignAuditLogging::returnEvent($data)',
            ),
        )
    ));
    ?>
</div>

<style>
    .noPass{
        color: #45a0ff;
    }
</style>