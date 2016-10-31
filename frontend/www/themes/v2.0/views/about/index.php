<?php
/** $@var AboutController $this */
/** @var Article $article */
$article = Article::fileCache('about');
if($article){
    $this->pageTitle = $article['title'];
    $this->keywords = $article['keywords'];
    $this->description = $article['description'];
}

?>

<div class="pt15">
    <div class="about-contain clearfix">
        <?php echo $this->renderPartial('//layouts//_pageLeft') ?>
        <div class="about-content">
            <div class="content-title">关于盖象（g-emall.com）</div>
            <div class="hr"></div>
            <div class="company-details">
                <?php if(!$article): ?>
                <p>盖网是一家创新型互联网技术应用企业，其利用互联网技术、云计算技术、移动互动媒体终端技术、打造出双向o2o电子商务平台，实现线上与线下的互动综合营销体系，由此服务于各地区、国家的消费者。</p>
                <p>
                    盖网的双向O2O消费增值模式，是O2O模式的创新，体现了生活消费互联网化的未来大趋势。通过盖象商城（G-emall.com）和盖网通智能终端机无缝连接，盖网成功创造出实现线上、线下互联互通，让互联网商业进入崭新的时代。而盖网Gnet
                    Points，正是盖网消费体系中的重要载体。Gnet
                    Points以消费商理论为基础，从每一次购物消费的折扣差中产生积分，按特定的比例分配给消费环节中的所有参与者，无论是消费者、供应商、联盟商户、推荐人、地区代理商，都可以共享消费的收益，通过提升消费者和商家与盖网的粘合度，从而达到拉动消费者的二次、三次和多次消费。盖网双向O2O模式成功在实体店（线下）和互联网（线上）之间搭建了一座桥梁，实现了让“消费者更便捷消费并增值”、“让商家没有难做的生意”的全新理念，最终实现共创、共享、共赢的开拓创新型生态经济圈层。
                </p>
                <p>
                    <b class="category">【公司定位】</b>
                    <span class="company-position">盖网结合网络整合营销与传统营销模式，开发消费者与企业彼此呼应的互功营销平台，形成互动综合营销诚信体系；围绕消费者、商家、社会，建立物流、媒体、广告、服务、营销、公益等各领域规模型立体化诚信服务平台。</span>
                </p>
                <p>
                    <b class="category">【公司文化】</b>
                    <span class="company-culture">底蕴——唯德者载物，巅峰——唯卓者屹立 ，革命——唯搏者引领。</span>
                    <span class="culture-tip">1、公司宗旨：盖聚百业、网通天下！<em class="tip-description">坚持以"盖"聚百业，整和资源，与所有合作伙伴一起成长，缔造消费新理念；遵循以"网"通达天下，透过互联网平台，分享成功的真谛，为社会、商家、消费者创造共赢。</em> </span>
                    <span class="culture-tip">2、公司使命：为企业和百姓服务！<em class="tip-description">以全新的互动综合营销模式为前提，实现立体化服务平台；以大众自然消费增值为导向，缔造诚信、利民、和谐的人类生活品质。</em> </span>
                    <span class="culture-tip">3、公司纲领：让我们一起创造美好生活！<em class="tip-description">以"共创、共享、共赢、利国、利企、利民"为核心价值，由员工、股东、合作商、消费者共同缔造盖网新传奇，一起创造美好生活。</em> </span>
                    <span class="culture-tip">4、公司责任：打造中国领先技术应用创新企业！<em class="tip-description">一个企业发展壮大的远景、一个行业兴起的宏伟蓝图、一个推动"互联网进程"和铸驻伟大中华民族辉煌的梦想。</em> </span>
                </p>
                <?php else: ?>
                    <?php echo $article['content'] ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>