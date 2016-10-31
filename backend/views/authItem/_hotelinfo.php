<?php 
$config = array(
    '酒店品牌列表' => array(
        '列表' => 'HotelBrand.Admin',
        '添加' => 'HotelBrand.Create',
        '编辑' => 'HotelBrand.Update',
        '删除' => 'HotelBrand.Delete'
    ),
    '酒店级别列表' => array(
        '列表' => 'HotelLevel.Admin',
        '添加' => 'HotelLevel.Create',
        '编辑' => 'HotelLevel.Update',
        '删除' => 'HotelLevel.Delete'
    ),
    '酒店热门地址' => array(
        '列表' => 'HotelAddress.Admin',
        '添加' => 'HotelAddress.Create',
        '编辑' => 'HotelAddress.Update',
        '删除' => 'HotelAddress.Delete'
    ),
    '酒店参数配置' => array(
        '编辑' => 'HotelParams.HotelParamsConfig'
    ),
    '酒店管理' => array(
        '列表' => 'Hotel.Admin',
        '添加' => 'Hotel.Create',
        '编辑' => 'Hotel.Update',
        '删除' => 'Hotel.Delete'
    ),
    '酒店客房列表' => array(
        '列表' => 'HotelRoom.Admin',
        '添加' => 'HotelRoom.Create',
        '编辑' => 'HotelRoom.Update',
        '删除' => 'HotelRoom.Delete'
    ),
    '国籍管理' => array(
        '列表' => 'Nationality.Admin',
        '添加' => 'Nationality.Create',
        '编辑' => 'Nationality.Update',
        '删除' => 'Nationality.Delete'
    ),
    '供应商管理' => array(
        '列表' => 'HotelProvider.Admin',
        '添加' => 'HotelProvider.Create',
        '编辑' => 'HotelProvider.Update',
        '删除' => 'HotelProvider.Delete'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>