<tr class="info">
	 <td><?php echo $data->id?>
	<?php if($data->status == 0):?>
    <input class="cbbox" id="cbx_<?php echo $data->id?>" type="checkbox" value="<?php echo $data->id?>"/>
    <?php endif;?>
    </td>
    <td>
    <?php echo $data->franchisee_name.' ('.$data->franchisee_code.')'?>
    <?php //if($data->franchisee) echo $data->franchisee->name.' ('.$data->franchisee->code.')'?>
    </td>
    <td>
    <?php echo $data->gai_number?>
    <?php //if($data->member) echo $data->member->gai_number?>
    </td>
    <td>
    <span style="color:<?php echo $data->status ? 'green' : 'red';?>">
    	<?php 
    		if ($data->is_auto == FranchiseeConsumptionRecord::AUTO_CHECK){
    			echo FranchiseeConsumptionRecord::getAutoStatus($data->is_auto);
    		}else{
    	 		echo FranchiseeConsumptionRecord::getCheckStatus($data->status);
    	 	}
    	?>
    </span>
    </td>
    <td><?php echo $data->gai_discount?>%
    </td>
    <td><?php echo $data->member_discount?>%
    </td>
    <td><?php echo date("Y-m-d H:i:s",$data->create_time)?>
    </td>
    <td>
        <span class="jf">¥<?php echo $data->spend_money?></span>
    </td>
    <td>
        <span class="jf">¥<?php echo $data->distribute_money?></span>
    </td>
    <td>
        <span class="jf">¥<?php echo $data->spend_money-$data->distribute_money?></span>
    </td>
    </tr>
    <tr class="user">
    <td></td>
    <td colspan="10">
	    <?php echo $data->symbol == 'HKD' ? preg_replace("/消费￥\d+\.00/", '消费HK\$'.$data->entered_money, $data->remark) : $data->remark;?>
    </td>                   
</tr>
