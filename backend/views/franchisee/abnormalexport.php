<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'franchisee-grid',
	'title'=>'异常商户列表',
    'dataProvider' => $model->getData(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(    
           array(
            'name' => Yii::t('franchisee', '编号'),
            'value' => '!empty($data->franchisee->code)?$data->franchisee->code:"null"'
        ),
        array(
            'name' => Yii::t('franchisee', '名称'),
            'value' => '!empty($data->franchisee->name)?$data->franchisee->name:"null"'
        ),
           array(
            'name' => Yii::t('franchisee', '所属会员'),
            'value' => '!empty($data->franchisee->member_id)?Member::model()->findByPk($data->franchisee->member_id)->gai_number:"null"'
        ),
          array(
            'name' => Yii::t('franchisee', '电话'),
            'value' => '!empty($data->franchisee->mobile)?" ".($data->franchisee->mobile):"null"'
        ),
   
//        'sum_money',
    ),
));
?>