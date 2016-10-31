<?php
/** @var  CActiveForm $form */
/** @var UploadForm $model */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'importMember-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'file') ?>
            </td>
            <td>
                <?php echo $form->fileField($model, 'file') ?>
                <?php echo $form->error($model, 'file', array(), false); ?>
            </td>
        </tr>
        <tr>
            <td>
                 发送短信
            </td>
            <td>
                <?php echo CHtml::radioButtonList('smg', 0, array(0=>'否',1=>'是')) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton('上传', array('class' => 'reg-sub')) ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>
<?php if (!empty($result)): ?>
    <br/>
    <hr/>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <thead>
        执行结果：  <?php echo CHtml::link('导出excel',array('importMember/export','file'=>$model->file),array('class'=>'regm-sub')) ?>
        </thead>
        <tr>
            <td>序号</td>
            <td>盖网通编号</td>
            <td>用户名</td>
            <td>密码</td>
            <td>金额</td>
            <td>手机号</td>
            <td>操作类型</td>
            <td>状态</td>
            <td>备注</td>
        </tr>
        <?php foreach ($result as $k => $v):
            $data = json_decode($v['data'],true);
        ?>
          <tr>
              <td><?php echo $k+1 ?></td>
              <td><?php echo $data['gai_number'] ?></td>
              <td><?php echo $data['username'] ?></td>
              <td><?php echo $data['password'] ?></td>
              <td><?php echo $data['cash'] ?></td>
              <td><?php echo $data['mobile'] ?></td>
              <td><?php echo $data['type'] ?></td>
              <td><?php echo $v['status']==0 ? '成功':'失败' ?></td>
              <td><?php echo $v['mark'] ?></td>
          </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>