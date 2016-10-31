<script type="text/javascript">
 /* $(function(){
		   $("#imgContent img").each(function(){  
			   var s=$(this).width();
			   if(s>870){
                     $(this).css('width','100%');
				   }
		     }); */
})
</script>


<div class="help-content">
            <div class="content-top">
                <a style= "cursor:default"><?php echo Yii::t('help', '帮助中心')?></a>
                <a style= "cursor:default"><?php echo Yii::t('help',Article::getCateName($article['category_id']))?></a>
                <a style= "cursor:default"><?php echo Yii::t('help', $article['title']);?></a>
            </div>
            <div class="content-details">
                <div class="details-title"><?php echo Yii::t('help', $article['title']);?></div>
                <div class="hr"></div>
              <div id="imgContent">
                <?php 
                 /*   preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $article['content'], $match);
                   foreach ($match[1] as $k => $v) {
                     $src='src="'.$v.'"';
                     $recSrc='src="'.$v.'" width=100%';
                     $matchs=getimagesize($v); 
                    if($matchs){
                       if($matchs[0]>'860'){
                        $article['content']=str_replace($src,$recSrc,$article['content']);
                       } 
                      }
                   } */
                       echo Yii::t('help', $article['content']);
                   ?>
            </div>
       </div>
 </div>