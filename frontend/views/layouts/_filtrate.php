<?php
// 产品规格属性筛选区
/* @var $this Controller */

if (!isset($id))
    throw new CException(Yii::t('category','参数错误！'));
//$brands = Brand::getCategoryBrands($id);

?>
<!--产品特征筛选卡 begin-->
<div id="filter" class="filterBox clearfix">
    <div class="filterItem clearfix"> 
        <div class="filterTit">品牌：</div>
        <div class="filterCon">
            <dl class="filterDl">
                <dd><a class="seled">全部</a> </dd>
                <dd><a>惠普(hp)</a></dd>
                <dd><a>联想(Lenovo)</a></dd>
                <dd><a>联想(ThinkPad)</a></dd>
                <dd><a>宏基(acer)</a></dd>
                <dd><a>Tsinghua Tongfang/清华同方</a></dd>
                <dd><a>戴尔</a></dd>
                <dd><a>三星</a></dd>
                <dd><a>索尼</a></dd>
                <dd><a>东芝</a></dd>
                <dd><a>Gateway</a></dd>
                <dd><a>微星</a></dd>
                <dd><a>海尔</a></dd>
                <dd><a>清华同方</a></dd>
                <dd><a>富士通</a></dd>
                <dd><a>苹果(Apple)</a></dd>
                <dd><a>神舟</a></dd>
                <dd><a>方正</a></dd>
                <dd><a>优雅</a></dd>
            </dl>	
        </div>
        <div class="filterAdd">
            <a href="javascript:;" onclick="javascript:turnoff('getChose,chomore')" class="filterChose" id="chomore">多选</a>
            <p class="getChose" id="getChose">
                <a href="javascript:;" class="filterSure hide">确定</a>
                <a href="javascript:;" class="filterCancel hide" onclick="javascript:turnoff('chomore,getChose')">回单选</a>
            </p>
        </div>
    </div>

    <div class="filterItem clearfix"> 
        <div class="filterTit"> LED背光灯类型：</div>
        <div class="filterCon">
            <dl class="filterDl">
                <dd><a class="seled">全部</a> </dd>
                <dd><a>侧入式</a></dd>
                <dd><a>直下式</a></dd>
                <dd><a>侧光式</a></dd>

            </dl>	
        </div>
        <div class="filterAdd">
            <a href="javascript:;" onclick="javascript:turnoff('getChose,chomore')" class="filterChose" id="chomore">多选</a>
            <p class="getChose" id="getChose">
                <a href="javascript:;" class="filterSure hide">确定</a>
                <a href="javascript:;" class="filterCancel hide" onclick="javascript:turnoff('chomore,getChose')">回单选</a>
            </p>
        </div>
    </div>

    <div class="filterItem clearfix"> 
        <div class="filterTit">价格：</div>
        <div class="filterCon">
            <dl class="filterDl">
                <dd><a class="seled">全部</a> </dd>
                <dd><a>1000-2999</a></dd>
                <dd><a>3000-3499</a> </dd>
                <dd><a>3500-3999</a> </dd>
                <dd><a>4000-4499</a> </dd>
                <dd><a>4500-4999</a> </dd>
                <dd><a>5000-5999</a> </dd>
                <dd><a>6000-6999</a> </dd>
                <dd><a>7000-9999</a> </dd>
                <dd><a>10000以上</a> </dd>
            </dl>	
        </div>
        <div class="filterAdd">
            <a href="javascript:;" onclick="javascript:turnoff('getChose,chomore')" class="filterChose" id="chomore">多选</a>
            <p class="getChose" id="getChose">
                <a href="javascript:;" class="filterSure hide">确定</a>
                <a href="javascript:;" class="filterCancel hide" onclick="javascript:turnoff('chomore,getChose')">回单选</a>
            </p>
        </div>
    </div>
    <div class="filterItem clearfix"> 
        <div class="filterTit">尺寸：</div>
        <div class="filterCon">
            <dl class="filterDl">
                <dd><a class="seled">全部</a> </dd>
                <dd><a>8.9英寸及以下</a></dd>
                <dd><a>11英寸</a></dd>
                <dd><a>12英寸</a></dd>
                <dd><a>13英寸</a></dd>
                <dd><a>14英寸</a></dd>
                <dd><a>15英寸</a></dd>
                <dd><a>16英寸-17英寸</a></dd>
            </dl>	
        </div>
        <div class="filterAdd">
            <a href="javascript:;" onclick="javascript:turnoff('getChose,chomore')" class="filterChose" id="chomore">多选</a>
            <p class="getChose" id="getChose">
                <a href="javascript:;" class="filterSure hide">确定</a>
                <a href="javascript:;" class="filterCancel hide" onclick="javascript:turnoff('chomore,getChose')">回单选</a>
            </p>
        </div>
    </div>
</div>
<!--产品特征筛选卡 End-->