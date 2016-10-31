<script>
    //证书示例
    var url = "<?php echo DOMAIN ?>";
    var img = {
        "picTips_threec_image":"3c.jpg",
        "picTips_cosmetics_image":"picTips_cosmetics_image.jpg",
        "picTips_food_image":"picTips_food_image.jpg",
        "picTips_jewelry_image":"picTips_jewelry_image.jpg",
        "picTips_declaration_image":"picTips_declaration_image.jpg",
        "picTips_report_image":"picTips_report_image.jpg",
        "picTips_brand_image":"picTips_brand_image.jpg",
        "picTips_license_photo":"picTips_license_photo.jpg",
        "picTips_organization_image":"picTips_organization_image.jpg",
        "picTips_licence_image":"picTips_licence_image.jpg",
        "picTips_tax_image":"picTips_tax_image.jpg",
        "picTips_identity_image":"picTips_identity_image.jpg",
        "picTips_identity_image2":"picTips_identity_image2.jpg",
        "picTips_debit_card_image":"picTips_debit_card_image.jpg",
        "picTips_debit_card_image2":"picTips_debit_card_image2.jpg"
    };
    for(var x in img){
        var imgUrl = url+'/images/example/'+img[x];
        $("#"+x).attr("href",imgUrl).click(function(){
            var href = $(this).attr('href');
            $.fancybox({
                'href': href,
                'overlayShow'	: true,
                'transitionIn'	: 'elastic',
                'transitionOut'	: 'elastic'
            });
            return false;
        });
    }
</script>