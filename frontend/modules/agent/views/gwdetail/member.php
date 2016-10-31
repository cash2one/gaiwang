<div class="account_right">
    <!-- -->
    <div class="line table_white" style="margin:10px">
        <table width="100%" cellspacing="0" cellpadding="0" class="table1">
           <tr class="table1_title">
              <td colspan="7"><?php echo Yii::t("Agent","消费会员概况")?></td>
           </tr>
           <tr>
              <td colspan="7" class="table_search">
              <div class="form_search">
    	        <label for="textfield"></label>
    	    		<p>
    	    			<?php echo Yii::t("Agent","您所代理的地区有")?>
    	    			<?php 
    	    				foreach ($addressName as $key=>$val){
    	    					echo $val.",";
    	    				}
    	    			?>
    	    		</p>
              </div>
              </td>
           </tr>
           <tr>
    		   <td width="36%" class="tabletd tc"><?php echo Yii::t('Agent','地区（省、市、县/区）')?></td>
    		   <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent','普通消费会员数量')?></td>
    		   <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent','普通正式会员数量')?></td>
    		   <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent','企业消费会员数量')?></td>
               <td width="16%" class="tabletd tc"><?php echo Yii::t('Agent','企业正式会员数量')?></td>
           </tr>
           <?php foreach ($data as $key=>$val){?>
		   <tr>
		   	  <td class="tc">
		   	  	<?php 
		   	  		$arr = explode("|", $val['tree']);
		   	  		echo $refArr[$arr['1']]." ".$refArr[$arr['2']]." ".$refArr[$arr['3']];
		   	  	?>
		   	  </td>
		   	  <td class="tc"><?php echo isset($tmpArr[$val['id']])?$tmpArr[$val['id']]['defaultNum']:0;?></td>
		   	  <td class="tc"><?php echo isset($tmpArr[$val['id']])?$tmpArr[$val['id']]['officialNum']:0;?></td>
		   	  <td class="tc"><?php echo isset($tmpArr[$val['id']])?$tmpArr[$val['id']]['defaultComNum']:0;?></td>
		   	  <td class="tc"><?php echo isset($tmpArr[$val['id']])?$tmpArr[$val['id']]['officialComNum']:0;?></td>
		   </tr>
		   <?php }?>
           <tr>
           	  <td colspan="7">
			     <div class="line pagebox">
				 <?php    
    				$this->widget('application.modules.agent.widgets.LinkPager',array(    
                            'header'=>'',    
                            'firstPageLabel' => Yii::t('Public','首页'),    
                            'lastPageLabel' => Yii::t('Public','末页'),    
                            'prevPageLabel' => Yii::t('Public','上一页'),    
                            'nextPageLabel' => Yii::t('Public','下一页'),    
                            'pages' => $pages,    
                            'maxButtonCount'=>13    
                            )    
                        );    
				?>  
			    </div>
			  </td>
           </tr>
       </table>
     </div>
   </div>
