<?php
/**
 * @var $this MiddleAgentController
 */
$operateLinks = '';
if ($this->getUser()->checkAccess('MiddleAgent.Update')):
    $operateLinks .= "<a href='" . urldecode($this->createAbsoluteUrl('middleAgent/update', array('id' => '"+value+"'))) . "'>【编辑】</a>";
endif;
if ($this->getUser()->checkAccess('MiddleAgent.Create')):
    $operateLinksAdd = "<a href='" . urldecode($this->createAbsoluteUrl('middleAgent/create', array('parentId' => '"+value+"'))) . "'>【添加居间商】</a>";
endif;
if ($this->getUser()->checkAccess('MiddleAgent.CreatePartner')):
    $operateLinks .= "<a href='" . urldecode($this->createAbsoluteUrl('middleAgent/createPartner', array('parentId' => '"+value+"'))) . "'>【添加直招商户】</a>";
endif;
if ($this->getUser()->checkAccess('MiddleAgent.Delete')):
    $comfirmText = Yii::t('category', '确定要删除此居间商？');
    $operateLinks .= "<a href='" . urldecode($this->createAbsoluteUrl('middleAgent/delete', array('id' => '"+value+"'))) . "' class='delete' onclick='return confirm(&apos;$comfirmText&apos;);'>【删除】</a>";
endif;
?>
<?php
$this->renderPartial('_searchMiddle', array(
    'model' => $model,
));
?>
<style>
    .datagrid-pager{
        width:100%;
        padding:0;
    }
</style>
<div class="c10"></div>
<table id="treeGrid"></table>
<script type="text/javascript" language="javascript" src="/js/iframeTools.source.js"></script>
<script type="text/javascript">
    function partnerList(a) {
        art.dialog.open(a.href,{width:850});
        return false;
    }
    function replacePartnerLink(value,id) {
        var link = '<?php echo CHtml::link('xxx',array('/middleAgent/partner','pid'=>'xid'),
            array('style'=>'color:blue','class'=>'partnerList','onclick'=>'return partnerList(this)')) ?>';
        if(value==0) return 0;
        link = link.replace('xid',id);
        return link.replace('xxx',value);
    }

    jQuery(function ($) {
        $('#treeGrid').treegrid({
            url: '<?php echo Yii::app()->createAbsoluteUrl('/middleAgent/getTreeGridData'); ?>',
            idField: 'id',
            treeField: 'gai_number',
            pagination: true,
            rownumbers: true,
            fitColumns: true,
            autoRowHeight: false,
            pageSize: 20,
            pageList: [20,50,100],
            queryParams: {'id': 0, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'},
            columns: [[
                {field: 'gai_number', title: '<?php echo Yii::t('category', 'GW号'); ?>', width: '200'},
                {field: 'username', title: '<?php echo Yii::t('category', '用户名'); ?>', width: '200'},
                {field: 'mobile', title: '<?php echo Yii::t('category', '手机'); ?>', width: '200'},
                {field: 'level', title: '<?php echo Yii::t('category', '级别'); ?>', width: '100', align: 'center'},
                {field: 'count', title: '<?php echo Yii::t('category', '直招商户数量'); ?>', width: '100', align: 'center',
                        formatter:function (value,row) {
                            return replacePartnerLink(value,row.id);
                    }
                },
                {
                    field: 'id',
                    title: '<?php echo Yii::t('category', '操作'); ?>',
                    width: '300',
                    formatter: function (value,row) {
                        if(row.level<=2){
                            var add = "<?php echo $operateLinksAdd ?>";
                        }else{
                             add = '';
                        }
                        return row.level==0 ? '': "<?php echo $operateLinks; ?>" + add;
                    }
                }
            ]],
            onBeforeExpand: function (row) {
                //动态设置展开查询的url
                var url = "<?php echo $this->createAbsoluteUrl('/middleAgent/getTreeGridData'); ?>&id=" + row.id + '&YII_CSRF_TOKEN=<?php echo Yii::app()->request->csrfToken; ?>';
                $("#treeGrid").treegrid("options").url = url;
                return true;
            }
        });

    });
</script>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/default/easyui.css");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/easyui/themes/icon.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/easyui/jquery.easyui.min.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/easyui/locale/easyui-lang-zh_CN.js");
?>

