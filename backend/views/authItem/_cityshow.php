<?php
/**
 *  @author zhenjun_xu <412530435@qq.com>
 *  DateTime 2016/4/28 18:18
 */
$config = array(
    '城市馆大区' => array(
        '大区列表'=>'CityshowRegion.admin',
        '添加大区'   => 'CityshowRegion.create',
        '删除'   => 'CityshowRegion.delete',
        '编辑'   => 'CityshowRegion.update',
    ),
    '城市馆审核列表'=>array(
        '列表'   => 'Cityshow.admin',
        '审核'   => 'Cityshow.update',
        '城市馆排序'   => 'Cityshow.sort',
        '主题排序'   => 'Cityshow.themeSort',
        '修改发布状态'   => 'Cityshow.changeShow',
        '入驻商家'   => 'Cityshow.store',
        '商品列表'   => 'Cityshow.goods',
        '修改入驻商家状态'   => 'Cityshow.changeStore',
        '删除入驻商家'   => 'Cityshow.deleteStore',
        '城市馆主题'   => 'Cityshow.theme',
    ),
    '城市馆权限管理列表'=>array(
        '商家列表'=>'CityshowRights.admin',
        '添加商家'=>'CityshowRights.create',
        '删除商家'=>'CityshowRights.delete',
    ),
);

$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));