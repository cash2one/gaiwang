<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2015/9/10
 * Time: 9:35
 * @info: 审核记录
 */
?>
<div style="display: none;" id="confirmArea">
<style>
    .aui_buttons{
        text-align: center;
    }
</style>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
    <tbody>
    <tr class="confirmTR" >
        <th class="even"><p id="person"  style="width:250px; word-break:break-all;"></p></th>
        <td class="even" ><p id="personKey"  style="width:250px; word-break:break-all;"></p></td>
    </tr>
    <tr class="confirmTR" >
        <th class="even"><p id="time"  style="width:250px; word-break:break-all;"></p></th>
        <td class="even" ><p id="timeKey"  style="width:250px; word-break:break-all;"></p></td>
    </tr>
    <tr class="confirmTR" >
        <th class="even"><p id="status"  style="width:250px; word-break:break-all;"></p></th>
        <td class="even" ><p id="statusKey"  style="width:250px; word-break:break-all;"></p></td>
    </tr>
    </tbody>
</table>
</div>

<script type="text/javascript">

    /**
     * 弹出ajax请求的审核信息
     * @param id
     */
    function do_info(id,status,action){
        $.ajax({
                type: "post", async: false, dataType: "json", timeout: 5000,
                url: "<?php echo $this->createUrl('examineInfo') ?>",
                data:{YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>',id:id,status:status,type:action},
                error:function(){
                    art.dialog({
                        icon: 'error',
                        content: '获取审核信息失败！',
                        ok: true
                    });
                },

                //FranchiseeConsumptionRecordConfirm::getApplyStatus
                success:function(data){
                    $('#personKey').html(data.username);
                    $('#timeKey').html(data.time);
                    $('#statusKey').html(data.status);
                    $('#status').html('状态：');
                    if(action == 'repeal'){                     //加盟商对账撤销申请
                        if(status == <?php echo FranchiseeConsumptionRecordRepeal::STATUS_PASS?>){
                            $('#person').html('同意撤销对账人：');
                            $('#time').html('同意撤销对账时间：');
                        }else if(status == <?php echo FranchiseeConsumptionRecordRepeal::STATUS_REFUSE?>){
                            $('#person').html('拒绝撤销对账人：');
                            $('#time').html('拒绝撤销对账时间：');
                        }else if(status == <?php echo FranchiseeConsumptionRecordRepeal::STATUS_AUDITI?>){
                            $('#person').html('审核撤销对账人：');
                            $('#time').html('审核销对账时间：');
                        }
                    }else if(action == 'confirm'){              //加盟商对账申请
                        if(status == <?php echo FranchiseeConsumptionRecordConfirm::STATUS_PASS?>){
                            $('#person').html('同意对账人：');
                            $('#time').html('同意对账时间：');
                        }else if(status == <?php echo FranchiseeConsumptionRecordConfirm::STATUS_REFUSE?>){
                            $('#person').html('拒绝对账人：');
                            $('#time').html('拒绝对账时间：');
                        }else if(status == <?php echo FranchiseeConsumptionRecordConfirm::STATUS_AUDITI?>){
                            $('#person').html('审核对账人：');
                            $('#time').html('审核对账时间：');
                        }
                    }
                    art.dialog({
                        content: $("#confirmArea").html(),
                        ok:true
                    });
                }
            }
        );
    }
</script>