<div class="packageDetail clearfix" id="packageDetail">
    <table class="packagePhoneNum" id="table_html1">
        <colgroup>
            <col width="250">
            <col width="200">
            <col width="200">
        </colgroup>
        <thead>
            <tr>                                   
                <th class="radiusLeft">号码</th>
                <th>盖网价</th>
                <th>包含话费</th>
            </tr>
        </thead>        
        <tbody>
            <?php foreach ($phones as $key => $v): ?>
                <?php if ($key % 2 == 0): ?>                          
                    <tr <?php if ($key == 0): ?>style="background-color: #fffacd"<?php endif; ?>>
                        <td><input type="radio" name="HeyuejiForm[phone]" value="<?php echo $v['id']; ?>" <?php if ($key == 0): ?>checked="checked"<?php endif; ?> onclick="changeBg(this)" data-name="number"/><b><?php echo $v['number'] ?></b></td>
                        <td><?php echo $v['price'] ?>元</td>
                        <td><?php echo $v['hasfee'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>        
    </table>
    <table class="packagePhoneNum" id="table_html2">
        <colgroup>
            <col width="250">
            <col width="200">
            <col width="200">
        </colgroup>
        <thead>
            <tr>                                   
                <th class="radiusLeft">号码</th>
                <th>盖网价</th>
                <th class="radiusRight">包含话费</th>
            </tr>
        </thead>        
        <tbody>
            <?php foreach ($phones as $k => $value): ?>
                <?php if ($k % 2 != 0): ?>
                    <tr>
                        <td  class="borderLeft"><input type="radio" name="HeyuejiForm[phone]" value="<?php echo $value['id']; ?>" data-name="number" onclick="changeBg(this)" /><b><?php echo $value['number'] ?></b></td>
                        <td><?php echo $value['price'] ?>元</td>
                        <td><?php echo $value['hasfee'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>        
    </table>
    <div class="packagePage clearfix">
        <div class="pageList clearfix">
            <ul class="yiiPageer">
                <?php
                $this->widget('common.widgets.LinkPager', array(
                    'pages' => $pages,
                    'maxButtonCount' => 5,
                    'jump' => false
                ));
                //分页
                Yii::app()->clientScript->registerScript('ajaxPager', "$('.pageList .yiiPager a').live('click', function(){
                        $.ajax({
                            url:$(this).attr('href'),
                            success:function(html){
                                $('#packageDetail').html(html);
                            }
                        });
                        return false;
                    });"
                );
                ?>  
            </ul> 
        </div>
    </div>
</div>
