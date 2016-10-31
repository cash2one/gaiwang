	</div>
	</div>
	<div class="main">
            <?php 
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'bind-form',
                    'action'=>$this->createAbsoluteUrl('member/bindGht')
                ));
            ?>
                <input name="binBankId" id="binBankId" type="hidden">
                <input name="cardType" id="cardType" type="hidden">
                <input name="bankName" id="bankName" type="hidden">
            <?php $this->endWidget();?>
		<div class="listBox clearfix">
			<ul class="submenu clearfix">			
				<li style="width: 50%;" class="select" id="menu1" onclick="showfocuspic(1,1);"><a href="javascript:;">信用卡</a></li>
				<li class="" style="width: 50%;" id="menu2" onclick="showfocuspic(2,1);"><a href="javascript:;">储蓄卡</a></li>
			</ul>
			<h2>热门银行</h2>
			<ul style="display: block;" class="bankList" id="Info_11">		            	
				<li class="clearfix" onclick="selectBankProt('B011','招商银行','02')"><i class="bico cmb sel"></i><a href="javascript:void(0);">招商银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B001','中国工商银行','02')"><i class="bico icbc"></i><a href="javascript:void(0);">中国工商银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B002','中国农业银行','02')"><i class="bico abc"></i><a href="javascript:void(0);">中国农业银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B004','中国建设银行','02')"><i class="bico ccb"></i><a href="javascript:void(0);">中国建设银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B015','中国邮政储蓄银行','02')"><i class="bico psbc"></i><a href="javascript:void(0);">中国邮政储蓄银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B009','华夏银行','02')"><i class="bico hxb"></i><a href="javascript:void(0);">华夏银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B012','中国民生银行','02')"><i class="bico cmbc"></i><a href="javascript:void(0);">中国民生银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B006','兴业银行','02')"><i class="bico cib"></i><a href="javascript:void(0);">兴业银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B008','上海浦东发展银行','02')"><i class="bico spdb"></i><a href="javascript:void(0);">上海浦东发展银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B005','平安银行','02')"><i class="bico pab"></i><a href="javascript:void(0);">平安银行</a></li>
                                <li class="clearfix" onclick="selectBankProt('B014','上海银行','02')"><i class="bico shb"></i><a href="javascript:void(0);">上海银行</a></li>
                                <li class="clearfix" onclick="selectBankProt('B010','北京银行','02')"><i class="bico bob"></i><a href="javascript:void(0);">北京银行</a></li>				
				<li class="clearfix" onclick="selectBankProt('B016','广发银行','02')"><i class="bico cgb"></i><a href="javascript:void(0);">广发银行</a></li>	                            
				<li onclick="selectOtherBank()"><i class="bico cup"></i><a href="javascript:void(0);">其它银行</a></li>
			</ul>  
			<ul class="bankList" style="display: none;" id="Info_12">                        
				<li class="clearfix" onclick="selectBankProt('B002','中国农业银行','01')"><i class="bico abc"></i><a href="javascript:void(0);">中国农业银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B004','中国建设银行','01')"><i class="bico ccb"></i><a href="javascript:void(0);">中国建设银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B006','兴业银行','01')"><i class="bico cib"></i><a href="javascript:void(0);">兴业银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B008','上海浦东发展银行','01')"><i class="bico spdb"></i><a href="javascript:void(0);">上海浦东发展银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B003','中国银行','01')"><i class="bico boc"></i><a href="javascript:void(0);">中国银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B013','中信银行','01')"><i class="bico ecitic"></i><a href="javascript:void(0);">中信银行</a></li>
				<li class="clearfix" onclick="selectBankProt('B007','中国光大银行','01')"><i class="bico ceb"></i><a href="javascript:void(0);">中国光大银行</a></li>
			</ul> 
		</div>
		<script type="text/javascript">
//                    $('#form-type').submit();
		// 控制产品工具条宽度
		$(function(){			
			var prodCount = '2';
			if(prodCount == 1){
				$('.submenu li').css("width","100%")
			}else if(prodCount == 2){
				$('.submenu li').css("width","50%")
			}
		});
		// 签约时选择银行
		function selectBankProt(bankId,bankName,cardType){
			$('#binBankId').attr("value",bankId);
			$('#cardType').attr("value",cardType);
			$('#bankName').attr("value",bankName);
			//document.form.action="";//跳转对应银行页面url
			$('#bind-form').submit();
		}
		// 选择其他银行
		function selectOtherBank(){
			location.href="#";/*其他银行选择URL*/
		}
		// 商户产品显示银行列表
		var showfocuspic = function(n,num){
			if(num==1){
				clearInterval(id);
			}
			if(n>3)	n=1;
			time=n;
			for(var p=1; p<=3;p++){
				if(p==n){
					$('#menu'+p).addClass("select");
					$("#Info_1"+p).css("display","block");
				}else{
					$('#menu'+p).removeClass("select");
					$("#Info_1"+p).css("display","none");
				}
			}
		}
		var id = window.setInterval("showfocuspic(time+1)",3000);
		var startpic = function(){
			id=window.setInterval("showfocuspic(time+1)",3000);
		}
		</script>
    </div>	
</div>
</body>
</html>