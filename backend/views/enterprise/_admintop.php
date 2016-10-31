<div class="signTab">
		<div class="signTab_title">
			<ul class="clearfix">
				<?php if(Yii::app()->user->checkAccess('Enterprise.DzbAdminZhaoshang')):?>
				<li <?php if ($this->getAction()->getId()=='dzbAdminZhaoshang'):?>class="cur"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl('enterprise/dzbAdminZhaoshang')?>"><?php echo Yii::t('enterprise', '资质电子版审核（招商）');?></a></li>
				<?php endif;?>
				
				<?php if(Yii::app()->user->checkAccess('Enterprise.ZzbAdminZhaoshang')):?>
				<li <?php if ($this->getAction()->getId()=='zzbAdminZhaoshang'):?>class="cur"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl('enterprise/zzbAdminZhaoshang')?>"><?php echo Yii::t('enterprise', '纸质资质审核（招商）');?></a></li>
				<?php endif;?>
				
				<?php if(Yii::app()->user->checkAccess('Enterprise.DzbAdminFawu')):?>
				<li <?php if ($this->getAction()->getId()=='dzbAdminFawu'):?>class="cur"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl('enterprise/dzbAdminFawu')?>"><?php echo Yii::t('enterprise', '资质电子版审核（法务）');?></a></li>
				<?php endif;?>
				
				<?php if(Yii::app()->user->checkAccess('Enterprise.ZzbAdminFawu')):?>
				<li <?php if ($this->getAction()->getId()=='zzbAdminFawu'):?>class="cur"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl('enterprise/zzbAdminFawu')?>"><?php echo Yii::t('enterprise', '纸质资质审核（法务）');?></a></li>
				<?php endif;?>
				
				<?php if(Yii::app()->user->checkAccess('Enterprise.FinishAdmin')):?>
				<li <?php if ($this->getAction()->getId()=='finishAdmin'):?>class="cur"<?php endif;?>><a href="<?php echo Yii::app()->createAbsoluteUrl('enterprise/finishAdmin')?>"><?php echo Yii::t('enterprise', '审核完毕');?></a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>