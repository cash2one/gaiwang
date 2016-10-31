<style>.tab-come th{text-align: center;}</style>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tbody>
        <tr>
            <th style="width: 150px;">
                <?php echo Yii::t('home','网站名称：'); ?>
            </th>
            <td>
                <?php echo $model['webname'];?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器主机名称(IP)：'); ?>
            </th>
            <td>
                <?php echo $model['serverip'];?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器操作系统:'); ?>
            </th>
            <td>
                <?php echo $model['serversys'];?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器脚本超时:'); ?>
            </th>
            <td>
                <?php echo $model['dotime'];?>
                秒
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器解译引擎:'); ?>
            </th>
            <td>
                <?php echo $model['serveryq'];?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器语言：'); ?>
            </th>
            <td>
                <?php echo $model['serverlanguage'];?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('home','服务器当前时间：'); ?>
            </th>
            <td>
                <?php echo date("Y-n-j H:i:s")?>
            </td>
        </tr>
    </tbody>
</table>