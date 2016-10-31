<?php
/* @var $this  SiteController */
/** @var $model Member */
$this->breadcrumbs = array(
    Yii::t('member', '账户管理') => '',
    Yii::t('member', '用户基本资料'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . "/js/ZeroClipboard.min.js");
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('member', '用户基本信息'); ?></span></a></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('member', '头像设置') . '</span>', $this->createAbsoluteUrl('/member/member/avatar')) ?></li>
            <li><?php echo CHtml::link('<span>' . Yii::t('member', '兴趣爱好') . '</span>', $this->createAbsoluteUrl('/member/interest/index')) ?></li>
        </ul>
    </div>
    <div class="mbRcontent">
        <?php $this->renderPartial('/layouts/_summary'); ?>
		<div class="regShare">
			<ul class="clearfix">
				<li class="lf01">
					<span class="elephantImg"></span>
					<div class="aboutStep">
						<a target="_blank"  class="m_icon_v activeDesc" href="<?php echo Yii::app()->createAbsoluteUrl('hongbao/site/register')?>" title=""><?php echo Yii::t('member', '活动说明'); ?></a>
						<div class="descDetail" style=" display:none">
							<i class="m_icon_v arrow"></i>
							<h3>注册分享奖红包步骤</h3>
							<p>1、分享注册 用户注册登录后，将注册链接分享给好友</p>
							<p>2、好友完成注册 好友通过您分享的注册链接完成注册，改为盖网会员</p>
							<p>3、奖励红包 注册成功并绑定手机后，马上获得盖网送出的红包，分享多多，奖励多多</p>
							<h3>注册分享奖红包说明</h3>
							<p>1、用户分享的次数不设上限，同一个分享链接新用户注册数量不设上限，赠送的红包数量不设上限；</p>
							<p>2、符合赠送条件的用户，红包会自动发放到红包账户中；</p>
							<p>3、红包可以在盖象商城购物时使用；</p>
							<p>4、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服</p>
						</div>
					</div>
				</li>
				<script>
					//$(function(){
						/*20141225活动说明*/
					$('.aboutStep').hover(
							function(){
								$('.descDetail').show();
							},
							function(){
								$('.descDetail').hide();
							}
						)
				//});
				
				</script>
				<li class="lf02">
					<h3>  <?php echo Yii::t('member', '分享注册奖红包活动'); ?> </h3>
					<p><?php echo Yii::t('member', '推荐好友注册，您还能拿到N倍红包，一变N，您还等什么呢？'); ?></p>
				</li>
                <?php $shareUrl = Yii::app()->createAbsoluteUrl('hongbao/site/registerCoupon',array('code'=>rawurlencode(Tool::lowEncrypt($model->gai_number,'encrypt')))) ?>
				<li class="lf03 clearfix">
					<div class="shareLinks clearfix"><input type="text" id ="fe_text" class="shareAddr" value="<?php echo $shareUrl ?>"  /><input type="button" id="d_clip_button" class="clip_button btnCopy"  value="<?php echo Yii::t('member', '复制链接'); ?>" /></div>
						<span class="fl">分享到：</span>
                        <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style fl" onmouseover="shareMouesOver()">
                            <a class="jiathis_button_qzone"></a>
                            <a class="jiathis_button_tsina"></a>
                            <a class="jiathis_button_tqq"></a>
                            <a class="jiathis_button_weixin"></a>
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                        </div>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                        <script type="text/javascript">
                            var shareMouesOver = function () {
                                jiathis_config = {
                                    url: '<?php echo $shareUrl ?>',
                                    title: '520红包等您！约吗？'
                                }
                            };
                        </script>
                        <!-- JiaThis Button END -->
				</li>
                
				<li class="lf04 clearfix">
                    <?php
                    $url = Yii::app()->createAbsoluteUrl('m/home/receiveRedBag',array('code'=>rawurlencode(Tool::lowEncrypt($model->gai_number,'encrypt'))));
                    $this->widget('comext.QRCodeGenerator',array(
                        'data' => $url,
                        'size'=>2.4,
                        'imageTagOptions' => array('width'=>'100','height'=>'100'),
                    )) ?>
					<p class="share">扫描分享</p>
				</li>
			</ul>
		</div>
        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('member', '账号信息预览'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('gai_number') ?>：</td>
                            <td width="70"></td>
                            <td><font class="red"><?php echo $model->gai_number ?></font></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('username') ?>：</td>
                            <td width="70"></td>
                            <td><?php echo $model->username ?></td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('member', '固定资料'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('real_name') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $model->real_name ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('identity_type') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->identityType($model->identity_type) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('identity_number') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->identity_number ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="20"><?php echo $model->getAttributeLabel('sex') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->gender($model->sex) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('birthday') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $model->birthday ? $this->format()->formatDate($model->birthday) : '' ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('member', '手机绑定'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="86"><?php echo $model->getAttributeLabel('mobile') ?>：</td>
                            <td width="70"></td>
                            <td><?php echo $model->mobile ?></td>
                        </tr>
                    </table>
                </div>
                <div class="upladaapBox">
                    <table width="980" border="0" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td width="51" height="30"></td>
                            <td width="86" height="30"><strong><?php echo Yii::t('member', '联系地址'); ?></strong></td>
                            <td width="70" height="30"></td>
                            <td width="615" height="30"></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td height="20"><?php echo Yii::t('member', '居住地'); ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo Region::model()->getName($model->province_id, $model->city_id) ?></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td height="20"><?php echo $model->getAttributeLabel('street') ?>：</td>
                            <td height="20"></td>
                            <td height="20"><?php echo CHtml::encode($model->street) ?></td>
                        </tr>
                        <tr>
                            <td height="20"></td>
                            <td width="86" height="20"><?php echo $model->getAttributeLabel('email') ?>：</td>
                            <td width="70" height="20"></td>
                            <td height="20"><?php echo $model->email ?></td>
                        </tr>
                    </table>
                </div>
                <table width="980" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <?php echo CHtml::link(Yii::t('member', '修改资料'), $this->createAbsoluteUrl('/member/member/update'), array('class' => 'dateBtn mgtop20')) ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mbDate1_b"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var client = new ZeroClipboard( $('#d_clip_button') );
    client.on( 'ready', function(event) {
        client.on( 'copy', function(event) {
            event.clipboardData.setData('text/plain', $('#fe_text').val());
        } );
        client.on( 'aftercopy', function(event) {
            myArtDialog();
        } );
    } );
    client.on( 'error', function(event) {
        ZeroClipboard.destroy();
    } );
    function myArtDialog(){
        art.dialog({
            icon: 'succeed',
            time: 2,
            content: '复制成功！',
            height: '80px',
            width:'160px'
        });
    }
	
</script>