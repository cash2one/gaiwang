<tr class="info">
	<td>
		<?php if($data->status == FranchiseeConsumptionRecordRepeal::STATUS_APPLY || $data->status == FranchiseeConsumptionRecordRepeal::STATUS_AUDITI):?>
		<input class="cbbox" id="cbx_<?php echo $data->id?>" type="checkbox" value="<?php echo $data->id?>"/>
<!--		<input type="hidden" value="<?php //echo $data->fcrid?>"/>-->
		<?php endif;?>
	</td>
    <td>
    	<?php echo $data->franchisee_name.' ('.$data->franchisee_code.')'?>
    </td>
    <td>
    	<?php echo $data->gai_number?>
    </td>
    <td>
        <span style="color:<?php  echo $data->status== FranchiseeConsumptionRecordRepeal::STATUS_PASS ? 'green' : 'red';?>">
    		<?php echo FranchiseeConsumptionRecordRepeal::getBackStatus($data->status)?>
    	</span>
    </td>
    <td>
    	<?php echo $data->gai_discount?>%
    </td>
    <td>
    	<?php echo $data->member_discount?>%
    </td>
    <td>
    	<?php echo date("Y-m-d H:i:s",$data->create_time)?>
    </td>
    <td>
        <span class="jf">
        	¥<?php echo $data->spend_money?>
        </span>
    </td>
    <td>
        <span class="jf">
        	¥<?php echo $data->distribute_money?>
        </span>
    </td>
    <td>
        <span class="jf">
        	¥<?php echo $data->spend_money-$data->distribute_money?>
        </span>
    </td>
    <td>
		<?php echo $data->apply_user_name?>
    </td>
    <td>
        <?php echo date("Y-m-d H:i:s",$data->apply_time)?>
    </td>
    <td>
        <?php if($data->status != FranchiseeConsumptionRecordRepeal::STATUS_APPLY):?>
            <a class='regm-sub' href='javascript:do_info(<?php echo $data->id ?>,<?php echo $data->status?>,"repeal")'>审核记录</a>
        <?php endif;?>
    </td>
</tr>
<tr class="user">
    <td></td>
    <td colspan="12">
    <?php echo $data->symbol == 'HKD' ? preg_replace("/消费￥\d+\.00/", '消费HK\$'.$data->entered_money, $data->remark) : $data->remark;?>
    </td>                   
</tr>
