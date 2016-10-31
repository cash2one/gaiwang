<?php 
//储蓄卡DEBITCARD

$bankArr=array(
        //借记卡(储蓄卡)
        'jjBank'=>array(
                'CCB'=>'DEBITCARD|CCB',//建设银行
                'ABC'=>'DEBITCARD|ABC',//农业银行
                'BOC'=>'DEBITCARD|BOC',//中国银行
                'CITIC'=>'DEBITCARD|CITIC',//中信银行
                'CEB'=>'DEBITCARD|CEB',//光大银行
                'CIB'=>'DEBITCARD|CIB',//兴业银行       
),
        //信用卡
       'xyBank'=>array(
               'ICBC'=>'CREDITCARD|ICBC',//工商银行,
               'CCB'=>'CREDITCARD|CCB',//建设银行,
               'ABC'=>'CREDITCARD|ABC',//工商银行,
               'BOC'=>'CREDITCARD|BOC',//中国银行,
               'ICBC'=>'CREDITCARD|ICBC',
               'CITIC'=>'CREDITCARD|CITIC',
               'PSBC'=>'CREDITCARD|PSBC',
               'CEB'=>'CREDITCARD|CEB',
               'CMB'=>'CREDITCARD|CMB',
               'CMBC'=>'CREDITCARD|CMBC',
               'HXB'=>'CREDITCARD|HXB',//华夏银行,
               'GDB'=>'CREDITCARD|GDB',//工商银行,
               'SPDB'=>'CREDITCARD|SPDB',//浦发银行,
               'SHB'=>'CREDITCARD|SHB',//上海银行,
               'BJB'=>'CREDITCARD|BJB',//北京银行,
               'BEA'=>'CREDITCARD|BEA',//东亚银行,
               'NBB'=>'CREDITCARD|NBB',//兴业银行,
               'BSB'=>'CREDITCARD|BSB',
               'CSCB'=>'CREDITCARD|CSCB',
               'CDB'=>'CREDITCARD|CDB',
               'CDRCB'=>'CREDITCARD|CDRCB',
               'CRCB'=>'CREDITCARD|CRCB',
               'CQB'=>'CREDITCARD|CQB',
               'CIB'=>'CREDITCARD|CIB',
        )
        
);
?>

<!--储蓄卡 $DEBITCARD-->
<div class="payMethodList PM_list" id="PM_list1">
        <ul>
        <?php foreach($bankArr['jjBank'] as $k => $v):?>
						<li>
							<input type="radio" name="bank" id="jjBank<?php echo $v ?>" value="<?php echo $v;?>" onclick="getBank('<?php echo $v?>')">
                            <label for="jjBank<?php echo $v ?>">
                            <div class="<?php echo $k;?> PMImg"></div>
                            </label>
							<div class="clear"></div>
						</li>
		<?php endforeach;?>
						<li class="clear"></li>
					</ul>
					<div class="clear"></div>
</div>
				
<!--信用卡  $CREDITCARD-->
<div class="payMethodList PM_list" id="PM_list2">
					<ul>
					<?php foreach($bankArr['xyBank'] as $kx =>$vy):?>
						<li>
							<input type="radio" name="bank" id="xyBank<?php echo $vy ?>" value="<?php echo $vy;?>" onclick="getBank('<?php echo $vy ?>')">
                            <label for="xyBank<?php echo $vy ?>">
                            <div class="<?php echo $kx;?> PMImg" ></div>
                            </label>
							<div class="clear"></div>
						</li>
					<?php endforeach;?>	
						<li class="clear"></li>
					</ul>
					<div class="clear"></div>
</div>
<script type="text/javascript">
   function getBank(bank){
	   var bankArr= new Array(); //定义一数组 
	       bankArr=bank.split("|"); //字符分割 
	       $("#payTypes").val(bankArr[0]);
	       $("#gateId").val(bankArr[1]);
	       $.ajax({
               type:"POST",
               url:"<?php echo $this->createAbsoluteUrl('/member/quickPay/signgo') ?>",
               data:{payTypes:bankArr[0],gateId:bankArr[1],code:"<?php echo $code;?>",YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken;?>"},
               success:function($msg){
                   $("#signTypes").val($msg);
               }
           });
	   }

</script>