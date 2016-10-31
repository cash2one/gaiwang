
			<div class="main">
                <div class="container">
                    <div class="mgtop15"></div>
                    <?php if(empty($picture)){
                        echo '该商品相册暂时还没有图片';
                    }else{ ?>
                    <div class="touchslider proSlider">
                        <div class="touchslider-viewport">
                            <?php foreach($picture as $pic){ ?>
                            <div class="touchslider-item"><a href="#" tag="<?php echo $model->name;?>"><img src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $pic->path, 'c_fill,h_380,w_400'); ?>"/></a></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="ablumMsg clearfix">
                        <div class="fl ablumInfor" id="ablumInfor"><?php echo CHtml::encode($model->name);?></div>
                        <div class="fr albumNum"><span class="red" id="currNum"><?php echo $currentPage;?></span>/<span class="albumTotal gray" id="albumTotal"><?php echo $count;?></span></div>
                    </div>
                    <?php } ?>
                </div>
			</div>

	    <script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>		          
        <script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
		<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>