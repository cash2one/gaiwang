<?php
/** $@var AboutController $this */
/** @var Article $article */
$article = Article::fileCache('job');
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
            <?php if(!$article): ?>
            <div class="content-title"><?php echo Yii::t('job', '诚聘英才') ?></div>
            <div class="hr"></div>
            <div class="job-details">
                <p class="text-indent-2">
                    广州涌智信息科技有限公司（简称“涌智”），是一家专业为珠海横琴新区盖网通传媒有限公司（简称“盖网通”）提供技术服务、软件开发服务的外资科技公司。盖网通设立在广州的分公司是盖网通传媒设立的最大的分公司。涌智委托盖网通广州分公司进行招聘。所录用的相关技术人员将与涌智签订劳动合同。</p>
            </div>
            <div class="job-details">
                <p class="job-name">相关福利描述：</p>
                <p>1、福利：五险一金（按入职开始缴纳、全员缴纳综合医疗、全员缴纳住房公积金）+节假日员工福利礼品</p>
                <p>2、依法享受国家法定节假日（元旦、五一、国庆、春节、中秋等）；劳动法规定的带薪假（如：晚婚婚假3天、产假至少3个月、陪产假10天等），劳动法规定带薪年假</p>
                <p>3、标准工作周时间：一周五天工作制 （双休：周六、日休息）</p>
                <p>4、标准工作日时间：9：30-12：00；13：00-18：30，中午休息1小时</p>
            </div>
            <div class="job-details">
                <p>公司地址为广州市中心：广州市东风东路767号东宝大厦28楼</p>
            </div>
            <div class="job-details">
                <p>51job：<a href="http://search.51job.com/list/co,c,2841012,000000,10,1.html" class="blue"
                            title="http://search.51job.com/list/co,c,2841012,000000,10,1.html">http://search.51job.com/list/co,c,2841012,000000,10,1.html </a>
                </p>
                <p>智联招聘：<a href="http://company.zhaopin.com/CC226847936.htm" class="blue"
                           title="http://company.zhaopin.com/CC226847936.htm">http://company.zhaopin.com/CC226847936.htm</a>
                </p>
            </div>
            <?php else: ?>
                <?php echo $article['content'] ?>
            <?php endif; ?>
        </div>
    </div>
</div>