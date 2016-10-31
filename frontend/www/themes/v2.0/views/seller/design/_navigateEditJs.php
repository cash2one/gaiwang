<script>
    $(function () {
        //导航设置、显示设置切换
        $(".Set").hide();
        $(".Tab_b li").each(function (i) {
            $(this).click(function () {
                $_this = $(".Set");
                $_this.hide().eq(i).show();
                $(this).siblings().removeClass('curr').end().addClass('curr');
                return false;
            });
        });
        $(".Tab_b li:first").trigger('click');

        //选择文章和分类
        $(".navEditcb.navEditcb2").find(".navEditinner").find("input:checkbox").each(function (i) {
            $(this).click(function () {
                var name = $(this).attr('data-name');
                var type = $(this).attr('data-type');
                var sourceid = $(this).attr('data-sourceId');
                var id = "link_" + type + "_" + sourceid;
                if ($(this).attr('checked')) {
                    //add
                    var linkHtml = '';
                    linkHtml += '<tr id="' + id + '" data-name="' + name + '" data-type="' + type + '" data-sourceId="' + sourceid + '" data-Url="">';
                    linkHtml += '<td class="navTitles">' + name + '</td>';
                    linkHtml += '<input type="hidden" name="nav[title][]" value="' + name + '" />';
                    linkHtml += '<input type="hidden" name="nav[type][]" value="' + type + '" />';
                    linkHtml += '<input type="hidden" name="nav[sourceid][]" value="' + sourceid + '" />';
                    linkHtml += '<input type="hidden" name="nav[url][]" value="" />';
                    linkHtml += '<td>';
                    linkHtml += '<a class="px up" href="javascript:moveUp(\'' + id + '\')" title="<?php echo Yii::t('sellerDesign','向上'); ?>"></a>';
                    linkHtml += ' <a class="px dow" href="javascript:moveDown(\'' + id + '\')" title="<?php echo Yii::t('sellerDesign','向下'); ?>"></a>';
                    linkHtml += '</td>';
                    linkHtml += '<td>';
                    linkHtml += ' <a href="javascript:opDele(\'' + id + '\')"><?php echo Yii::t('sellerDesign','删除'); ?></a>';
                    linkHtml += '</td>';
                    linkHtml += '</tr>';
                    $('#linkList').append(linkHtml);
                }
                else {
                    //remove
                    opDele(id);
                }

                setHeadFoot();

            });
        });
    });

    var validateAddDiyLink = function () {
        var valid = true;
        if (!validateEmpty("diyName")) {
            valid = false;
        }
        if (!validateEmpty("diyUrl")) {
            valid = false;
        }

        return valid;
    };

    var validateEmpty = function (id) {
        if (!$('#' + id).val()) {
            $('#' + id).siblings('.field-validation-error').css('display', 'inline');
            return false;
        }
        else {
            $('#' + id).siblings('.field-validation-error').css('display', 'none');
            return true;
        }
    };
    var addDiyLink = function (type) {
        if (!validateAddDiyLink()) {
            return;
        }

        var id = "link_" + type + "_" + diyLinkIdIndex;
        var name = $('#diyName').val();
        var url = $('#diyUrl').val();
        var diyHtml = '';
        diyHtml += '<tr id="' + id + '" data-name="' + name + '" data-type="' + type + '" data-Url="' + url + '" data-sourceId="' + diyLinkIdIndex + '">';
        diyHtml += '<td class="navTitles">' + name + '</td>';
        diyHtml += '<input type="hidden" name="nav[title][]" value="' + name + '" />';
        diyHtml += '<input type="hidden" name="nav[type][]" value="' + type + '" />';
        diyHtml += '<input type="hidden" name="nav[sourceid][]" value="' + diyLinkIdIndex + '" />';
        diyHtml += '<input type="hidden" name="nav[url][]" value="' + url + '" />';
        diyHtml += '<td>';
        diyHtml += ' <a class="px up" href="javascript:moveUp(\'' + id + '\')" title="<?php echo Yii::t('sellerDesign','向上'); ?>"></a>';
        diyHtml += ' <a class="px dow" href="javascript:moveDown(\'' + id + '\')" title="<?php echo Yii::t('sellerDesign','向下'); ?>"></a>';
        diyHtml += '</td>';
        diyHtml += '<td>';
        diyHtml += ' <a href="javascript:opEdit(\'' + id + '\')"><?php echo Yii::t('sellerDesign','编辑'); ?></a>';
        diyHtml += ' <a href="javascript:opDele(\'' + id + '\')"><?php echo Yii::t('sellerDesign','删除'); ?></a>';
        diyHtml += '</td>';
        diyHtml += '</tr>';
        $('#linkList').append(diyHtml);
        $('#diyName').val('');
        $('#diyUrl').val('');
        diyLinkIdIndex++;
        setHeadFoot();

        $('#hdLinkId').val('');
        $('#btnSaveDiyLink').css('display', 'none');
    };

    var saveDiyLink = function () {
        var id = $('#hdLinkId').val();

        var pEle = $('#' + id);
        var name = $('#diyName').val();
        var url = $('#diyUrl').val();

        pEle.attr('data-name', name);
        pEle.attr('data-Url', url);
        pEle.find('.navTitles').text(name);

        $('#hdLinkId').val('');
        $('#btnSaveDiyLink').css('display', 'none');
        $('#diyName').val('');
        $('#diyUrl').val('');
    };

    var moveUp = function (pId) {
        if ($('#' + pId).find('.upnot').length > 0) {
            return;
        }
        $('#' + pId).prev().before($('#' + pId));
        setHeadFoot();
    };

    var setHeadFoot = function () {
        $('#linkList .upnot').removeClass('upnot').addClass('up');
        $('#linkList .downot').removeClass('downot').addClass('dow');
        var upData = $('#linkList .up');
        if (upData.length > 0) {
            $(upData[0]).removeClass('up').addClass('upnot');
        }
        var dowData = $('#linkList .dow');
        if (dowData.length > 0) {
            $(dowData[dowData.length - 1]).removeClass('dow').addClass('downot');
        }

    };

    var moveDown = function (pId) {
        if ($('#' + pId).find('.downot').length > 0) {
            return;
        }
        $('#' + pId).next().after($('#' + pId));

        setHeadFoot();

    };

    var opDele = function (pId) {
        $('#' + pId).hide(500, function () {
            var re = /link/g;
            var cbxId = pId.replace(re, "cbx");
            if ($('#' + cbxId).attr('checked')) {
                $('#' + cbxId).attr('checked', false);
            }
            $('#' + pId).remove();
            setHeadFoot();
        });
    };

    var opEdit = function (id) {
        $('#hdLinkId').val(id);
        $('#btnSaveDiyLink').css('display', 'inline-block');

        var pEle = $('#' + id);
        $('#diyName').val(pEle.attr('data-name'));
        $('#diyUrl').val(pEle.attr('data-Url'));

    };

    var cancel = function () {
        var p = art.dialog.opener;
        if (p && p.doClose) p.doClose();
    };
</script>