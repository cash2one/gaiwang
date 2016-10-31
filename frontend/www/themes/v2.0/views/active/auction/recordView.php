<table>
    <tr>
        <td width="15%"><span class="jp-state<?php echo $data['status'];?>"><?php echo $data['status']==2 ? Yii::t('auction','出局') : Yii::t('auction','领先');?></span></td>
        <td width="15%"><?php echo  $data['gw'];?></td>
        <td width="45%"><?php echo HtmlHelper::formatPrice($data['balance']); ?></td>
        <td width="25%"><?php echo $data['auction_time'];?></td>
    </tr>
</table>