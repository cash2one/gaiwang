<div class="signTab">
		<div class="signTab_title">
			<ul class="clearfix">
                <!--大区经理、销售总监、大区审核、审核组长、审核组长、运营总监、运作部大区审核、运作部经理-->
                <!--为角色，登录用户具有这个角色，且这个角色具有 “浏览审核列表” 权限，则可以显示-->
                <!--审核完毕列表页、全部签约列表页 不是角色，是单独的权限。 同“浏览审核列表”权限-->
                <!--大区经理-->
                <?php foreach($this->roleArr as $value):?>
                    <?php if(Yii::app()->user->checkAccess('OfflineSignStoreExtend.Admin')):?>
                        <li <?php if($this->role == $value['id']):?>class="cur"<?php endif;?>>
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('OfflineSignStoreExtend/admin',array('role'=>$value['id']))?>">
                                <?php echo $value['roleName']?>
                            </a>
                        </li>
                    <?php endif;?>
                <?php endforeach;?>

                <!--审核完毕-->
				<?php if($this->role == OfflineSignAuditLogging::PASS_AUDIT || $this->role == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES || $this->role == OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER || $this->role == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS || $this->role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER || $this->role == OfflineSignAuditLogging::ALL_SIGN):?>
				<li <?php if ($this->role == OfflineSignAuditLogging::PASS_AUDIT):?>class="cur"<?php endif;?>>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('OfflineSignStoreExtend/finishAdmin',array('role'=>OfflineSignAuditLogging::PASS_AUDIT))?>">
                        <?php echo Yii::t('OfflineSignStore', '审核完毕');?>
                    </a>
                </li>
				<?php endif;?>
                <!--全部签约-->
                <?php if($this->role == OfflineSignAuditLogging::PASS_AUDIT || $this->role == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES || $this->role == OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER || $this->role == OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS || $this->role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER || $this->role == OfflineSignAuditLogging::ALL_SIGN):?>
                    <li <?php if ($this->getAction()->getId()=='allContractAdmin'):?>class="cur"<?php endif;?>>
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('OfflineSignStoreExtend/allContractAdmin',array('role'=>OfflineSignAuditLogging::ALL_SIGN))?>">
                            <?php echo Yii::t('OfflineSignStore', '全部签约');?>
                        </a>
                    </li>
                <?php endif;?>
			</ul>
		</div>
	</div>

<script type="text/javascript">
    /**
     * 查看备注
     * @param id
     */
    function showRemarks(id){
        var url = "<?php echo Yii::app()->createAbsoluteUrl('offlineSignAuditLogging/showRemarks')?>"+"&id="+id;
        art.dialog.open(url,{
            title: "查看备注",
            lock: true,
            width: 886,
            height: 610,
            init:function(){},
            ok:true,
            cancel:true
        });
    }
    /**
     * 审核进度
     * @param id
     */
    function AuditSchedule(id){
        var url = "<?php echo Yii::app()->createAbsoluteUrl('offlineSignAuditLogging/auditSchedule')?>"+"&id="+id;
        art.dialog.open(url,{
            title: "查看审核进度",
            lock: true,
            width: 886,
            height: 610,
            init:function(){},
            ok:true,
            cancel:true
        });
    }
</script>

