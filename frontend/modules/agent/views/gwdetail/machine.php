<div class="account_right">   
    <div class="line table_white" style="margin:10px">
        <table width="100%" cellspacing="0" cellpadding="0" class="table1">
           <tr class="table1_title">
              <td colspan="7"><?php echo Yii::t("Agent","盖网机概况")?></td>
           </tr>     
        	<tr>
              <td colspan="7" class="table_search">
              <div class="form_search">
    	    	    <label for="textfield"></label>
    	    		<p>
    	    			<?php echo Yii::t("Agent","您所代理的地区有")."： "?>
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
    		  <td width="34%" class="tabletd tc"><?php echo Yii::t('Agent','加盟商名称')?></td>
    		  <td width="30%" class="tabletd tc"><?php echo Yii::t('Agent','盖机数量')?></td>
           </tr>
           <?php foreach ($data as $key=>$val){?>
		   <tr>
		   	  <td class="tc">
		   	  <?php echo $refArr[$val['province_id']]." ".$refArr[$val['city_id']]." ".$refArr[$val['district_id']];?>
		   	  </td>
		   	  <td class="tc"><?php echo $val['name']?></td>
		   	  <td class="tc"><?php echo $val['num']?></td>
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
