<div class="main">
    <?php
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    $this->renderPartial('/layouts/_left', array('article' => $article));
    ?>

    <div class="mainWrap right">
        <!--搜索 start-->    
        <div class="hPSearch">
            <span class="hpdetalbg"></span>
            <span class="hpdetalTxt"><?php echo $article['title'] ?></span>
            <span class="hpdetalbg"></span>
        </div>
        <!--搜索end--> 

        <!--合作加盟内容 start-->
        <div class="JoinUs">
            <?php echo $article['content'] ?>
            <!--p class="textIndent">
                盖网历经二年研究和技术开发，集网络商城、3G智能互动传媒系统、结算管理系统等三大系统优势于一身的盖网，即将带着自身的使命进入消费市场，实现老百姓便捷消费并获得消费增值的真正时代和让企业商家生意不再难做的时代里程碑。盖网平台计划在2014年前在全国各地落地生根，全新的线上线下模式，实现只要有消费的地方就会有盖网平台，至此盖网平台将拥有庞大的客户群，市场需求空间巨大。现盖网诚征各级联盟商、服务中心、技术开发合作伙伴...
            </p>
    
            <p class="txtTitle">各级联盟商</p>
    
            <p>帮助盖网完善消费者购买信息服务，维护区域市场稳定，解决地域市场中所遇到的特殊问题。各级联盟商可根据需求，衔接盖网已经建成的系统平台及构建其它服务衔接，统一快速地对各地盖网商家进行增值系统的可操作性的管理。</p>
    
            <p class="txtTitle">服务中心</p>
            <p>协同盖网做好渠道建设，产品推广销售；服务于各行业商家，为广大消费者提供更加完善良好的消费增值服务；将盖网产业链、各级联盟商、服务中心等关键环节打通，帮助建设盖网会员团体。</p>
            <p class="txtTitle">技术开发合作伙伴</p>
            <p>盖网为了实现电子技术的革新、创建新时代的商业模式，欢迎各大技术提供商，成为合作伙伴，为盖网提供辅助服务，提高运营效率，降低运营成本，促进互联网产业快速健康发展。</p-->

        </div>

        <!--合作加盟内容 start-->
    </div>
</div>