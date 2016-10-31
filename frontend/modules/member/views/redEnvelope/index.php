<?php
/* @var $this RedEnvelopeController */
/* @var $model RedEnvelope */
//获取会员红包账户过期时间
$validEnd = Yii::app()->db->createCommand()
        ->select('valid_end')
        ->from('{{member_account}}')
        ->where('member_id=:member_id', array(':member_id' => $this->model->id))
        ->queryScalar();
?>

<?php 
$frontUrl=Yii::app()->request->urlReferrer;
$path=parse_url($frontUrl,PHP_URL_PATH);
if($path=='/site/registerCoupon'):

    $model = Member::model()->find(array(
            'select' => 'id,gai_number',
            'condition' => 'id = :id',
            'params' => array(':id' => $this->getUser()->id)
    ));
?>
<?php $this->renderPartial('/home/_statisticsJs',array('model'=>$model)) ?>
<?php endif;?>

<script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
<div class="mbRight">
    <div class="purseCont">
        <h3>我的钱包</h3>
        <div class="purseBalance">
            <ul class="clearfix">
                <li class="li01">
                    <p>我的余额： </p>
                    <p class="clearfix"><div class="fl"><span class="balanceCount"><?php echo HtmlHelper::formatPrice($this->account['money']) ?></span><b>元</b></div> <a href="<?php echo Yii::app()->createAbsoluteUrl('/member/wealth/cashDetail') ?>" class="btnCheck">余额查询</a></p>
                </li>
                <li>
                    <p>红包： </p>
                    <div class="clearfix">
                        <div class="fl"><span class="balanceCount red"><?php echo HtmlHelper::formatPrice($this->account['red'], 'font', array('class' => 'red')) ?></span><b>元</b> </div>
                        <div class="limitDays">
                            <?php if ($this->account['red'] > 0): ?>
                                <div class="m_icon_v remain">有效期还剩 &nbsp;&nbsp;<span id="clock" class="clock"></span></div>
                            <?php endif; ?>
                            <div class="descDetail" id="descDetail" style="display: none;">
                                <i class="m_icon_v arrow"></i>
                                <h4>有效期时间说明：</h4> 
                                <p>1、红包积分的余额是有使用的有效期，当有效期时间变为0时，红包积分余额清零</p>
                                <p>2、每次领取到新的红包积分，有效期时间会变成30天，然后重新倒数</p>
                            </div>
                        </div>
                    </div>			
                </li>
                <li class="li03">
                    <p><a href="<?php echo Yii::app()->createUrl('/member/redEnvelope/redList') ?>" class="m_icon_v checkList">查看领取清单<i class="m_icon_v"></i></a><p>
                        <?php if ($this->account['red'] > 0): ?>
                        <p><a href="<?php echo $this->createAbsoluteUrl('/zt/site/homeField'); ?>">有钱就是任性，马上到红包专场逛一逛！</a> </p>
                    <?php else: ?>
                        <p><?php //echo CHtml::link('我要领取红包',Yii::app()->createAbsoluteUrl('/hongbao/site/share'))           ?></p>
                    <?php endif; ?>
                    <div class="wantShare">
                        <?php echo CHtml::link('我要分享(领取红包奖励)', Yii::app()->createAbsoluteUrl('/hongbao/site/share')) ?>？
                        <div style="display:none;" class="wantShareDetail">
                            <i class="m_icon_v arrow"></i>
                            <h4>分享奖红包步骤</h4>
                            <p>1、<strong>分享链接</strong>  用户注册登录后，将注册链接分享给好友</p>
                            <p>2、<strong>好友注册成功</strong>  好友通过您分享的注册链接完成注册，成为盖网会员</p>
                            <p>3、<strong>奖励红包</strong> 成功注册并绑定手机后，马上就能获得盖网送出的红包，分享多多，奖励多多</p>
                            <h4>分享奖红包说明</h4>
                            <p>1、用户分享的次数不设上限，同一个分享链接新用户注册数量不设上限，赠送的红包数量不设上限；</p>
                            <p>2、符合赠送条件的用户，红包会自动发放到红包账户中；</p>
                            <p>3、红包可以在盖象商城购物时使用；</p>
                            <p>4、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服</p>
                        </div>
                    </div>
                </li>
            </ul>
            
        </div>
		
        <script type="text/javascript">
            $(function() {
                $(".wantShare").hover(function() {
                    $(".wantShareDetail").css({'display': "block"});
                }, function() {
                    $(".wantShareDetail").css({'display': "none"});
                })
            })
        </script>
        <div class="purseList">
            <!--            <div class="purseNav">-->
            <!--                <ul class="clearfix">-->
            <!--                    <li id="purse1" onmouseover="setTab('purse',1,3)" class="odd curr">未使用盖惠券</li>-->
            <!--                    <li id="purse2" onmouseover="setTab('purse',2,3)" class="even">已使用盖惠券</li>-->
            <!--                    <li id="purse3" onmouseover="setTab('purse',3,3)" class="odd">已过期盖惠券</li>-->
            <!--                </ul>-->
            <!--            </div>-->
            <!--            <div class="purseDetail">-->
            <!--                --><?php
//                  $data =array();
//                  if(!empty($data)):
            ?>
            <!--                <ul class="purse_1 clearfix" id="tabCon_purse_1">-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立马使用</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立即领取</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="mgRig0 icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立即领取</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立马使用</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立即领取</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="mgRig0 icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">立即领取</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--                <ul class="purse_2 clearfix" id="tabCon_purse_2" style="display:none">-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已使用</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已使用</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="mgRig0 icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已使用</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!---->
            <!--                </ul>-->
            <!--                <ul class="purse_3 clearfix" id="tabCon_purse_3" style="display:none">-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已过期</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已过期</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                    <li class="mgRig0 icon_v_h_02">-->
            <!--                        <p class="price clearfix"><span class="unit">￥</span>100<a href="#" title="" class="getBtn">已过期</a></p>-->
            <!--                        <p class="pd_bt10">消费满150使用</p>-->
            <!--                        <p>北面旗舰店满150减50</p>-->
            <!--                        <p>有效期：2014-10-23 至 2014-11-31</p>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--                --><?php //else:           ?>
            <!--                      <div class="no-data">没有找到可用盖惠券</div>-->
            <!--                --><?php //endif;           ?>
            <!--            </div>-->
        </div>
    </div>
</div>

<script>
    //ajax 红包充值
    function recharge(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createAbsoluteUrl('redEnvelope/getRed') ?>",
            dataType: 'json',
            data: {
                "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                "id": id
            },
            success: function(msg) {
                art.dialog({
                    icon: 'succeed',
                    lock: true,
                    content: msg.tip,
                    okVal: '<?php echo Yii::t('member', '确定') ?>',
                    title: '<?php echo Yii::t('member', '消息') ?>',
                    ok: function() {
                        location.reload();
                    }
                });
            }
        });
    }
    /*20141226有限期说明*/
    $('.limitDays').hover(
            function() {
                $('#descDetail').show();
            },
            function() {
                $('#descDetail').hide();
            }
    )
</script>
<script>
    var validEnd = '<?php echo date('Y/m/d H:i:s', $validEnd) ?>';
    var validStart = '<?php echo date('Y/m/d H:i:s') ?>';
    $('#clock').countdown(validEnd, function(event) {
        $(this).html(event.strftime('%D 天 %H:%M:%S'));
    }, validStart);
</script>


