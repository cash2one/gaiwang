<?php ?>
<script>
    function updatePercent(percent,$total,$number){
        jQuery('#msg').text('共'+$total+'条商品，正在导入第'+$number+'条,请耐心等候!');
        jQuery('#progress').css('width',percent);
        jQuery('#percent').text(percent);
        if(jQuery('#progress').width() == '100%'){
            jQuery('#progress').text('数据导入成功！');
        }
    }
</script>

<div style="margin:0 auto; margin-top:4px; margin-bottom:0; padding: 8px; padding-bottom:0; border: 1px solid gray; background: #EAEAEA; width:500px">   
   <div><font color="gray"><span style="font-size:12px;">此操作需要等待一段时间，在执行完毕之前，请不要关闭此页面</span></font></div>   
   <div style="padding: 0; background-color: white; border: 1px solid navy; width:500px">   
       <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;  height: 16px"></div>   
   </div>   
   <div id="msg" style="font-size:12px;"></div>
   <div id="percent" style="position: relative; top: -32px; text-align: center; font-weight: bold; font-size: 8pt;">0%</div>  
</div>