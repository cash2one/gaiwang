<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bacthCreate-form',
    'method' => 'post',
    'action' => array('member/batchCreate'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        )));
?>
<table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab mgtop10">
    <tbody>
        <tr> 
            <th width="142" height="40" align="center" class="tdBg">GW号码</th>
            <th width="142" height="40" align="center" class="tdBg">手机号码</th>
            <th width="142" height="40" align="center" class="tdBg">用户名</th>
            <th width="142" height="40" align="center" class="tdBg">密码</th>  
        </tr>

        <?php foreach ($data as $k => $v): ?>
            <tr>

                <td height="35" align="center" valign="middle" class="bgF4">
                    <input type="text" name="data[<?php echo $k ?>][gai_number]" readonly="readonly" value="<?php echo $v['gai_number']; ?>" />
                </td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <input type="text" name="data[<?php echo $k ?>][mobile]" value="" />
                </td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <input type="text" name="data[<?php echo $k ?>][username]" value="" />
                </td>
                <td height="35" align="center" valign="middle" class="bgF4">
                    <input type="text" name="data[<?php echo $k ?>][password]" value="<?php echo $v['password']; ?>" />
                </td>             
            </tr>          
        <?php endforeach; ?>
        <tr>          
           <td><?php echo CHtml::submitButton('确定', array('class' => 'reg-sub')) ?></td>
        </tr> 
    </tbody>
</table>
<?php $this->endWidget(); ?>