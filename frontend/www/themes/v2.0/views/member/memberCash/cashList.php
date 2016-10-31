<!--主体start-->  	
      <div class="main-contain">  
        <div class="withdraw-contents">
        	
            <div class="accounts-box">
                <p class="accounts-title cover-icon"><?php echo Yii::t('memberWealth', '提现列表') ?></p>
                <div class="withdraw-box">
                    <?php $this->renderPartial('_searchCash',array('model'=>$model)) ?>
               <?php if(!empty($log)):?>
                    <table class="withdraw-table" border="0">
                      <tr class="withdraw-title">
                        <td class="table-time"><?php echo Yii::t('memberWealth', '申请时间') ?></td>
                        <td class="table-money"><?php echo Yii::t('memberWealth', '申请金额') ?></td>
                        <td class="table-fee"><?php echo Yii::t('memberWealth', '手续费') ?></td>
                        <td class="table-rates"><?php echo Yii::t('memberWealth', '手续费费率') ?></td>
                        <td class="table-real"><?php echo Yii::t('memberWealth', '实扣金额') ?></td>
                        <td class="table-status"><?php echo Yii::t('memberWealth', '状态') ?></td>
                        <td class="table-remark"><?php echo Yii::t('memberWealth', '备注') ?></td>
                      </tr>
                  <?php foreach($log as $v): 
                      $v->money = Common::rateConvert($v->money);
                  ?>
                      <tr>
                        <td height="35" align="center" valign="middle">
                                <?php echo $this->format()->formatDatetime($v->apply_time) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <b><?php echo HtmlHelper::formatPrice($v->money) ?></b>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $fee = sprintf('%0.2f',$v->money*$v->factorage/100) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v->factorage ?>%
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v->money+$fee ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <?php echo $v::status($v->status) ?>
                            </td>
                            <td height="35" align="center" valign="middle">
                                <b class="red">
                                    <?php echo $v->reason ?>
                                </b>
                            </td>
                      </tr>
                    <?php endforeach;?> 
                    </table>
                    <?php else:?>
                     <table class="withdraw-table" border="0">
                      <tr class="withdraw-title">
                        <td class="table-time"><?php echo Yii::t('memberWealth', '申请时间') ?></td>
                        <td class="table-money"><?php echo Yii::t('memberWealth', '申请金额') ?></td>
                        <td class="table-fee"><?php echo Yii::t('memberWealth', '手续费') ?></td>
                        <td class="table-rates"><?php echo Yii::t('memberWealth', '手续费费率') ?></td>
                        <td class="table-real"><?php echo Yii::t('memberWealth', '实扣金额') ?></td>
                        <td class="table-status"><?php echo Yii::t('memberWealth', '状态') ?></td>
                        <td class="table-remark"><?php echo Yii::t('memberWealth', '备注') ?></td>
                      </tr>
                     </table> 
                    <div class="withdraw-list">
                    	<p class="withdraw-not"><?php echo Yii::t('memberWealth', '没有找到数据') ?></p>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        
        
      </div>      
    </div>  
    <!-- 主体end -->