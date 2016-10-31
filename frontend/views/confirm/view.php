<div class="protocol">
	<?php if($prevois!=true){ ?>
	<h4 class='tips'><i class="icon-i"></i> 您好，因联盟商户合作相关合同内容有变更，请在同意以下补充协议后，再继续后续操作</h4>
	<?php } ?>
	<?php echo str_replace($search,$replace,$content);?>
	
	<?php if($prevois!=true){ ?>
	<p class='btn'>
		<a href='/confirm/confirm/id/<?php echo  $model->id;?>' >
			<button class='confirm'>同意协议并继续</button>
		</a>
		<a href="/confirm/reject">
			<button class='disagree'>取消</button>
		</a>
	</p>
	<?php } ?>
</div>
