<?php

/**
 * 电子化签约 示例图片配置Model
 */
class OfflineSignDemoImgsConfigForm extends CFormModel{

    //企业资质上传图片示例图
    public $license_image_demo; //企业营业执照示例照片
    public $tax_image_demo; //企业税务登记示例照片
    public $identity_image_demo; //企业法人身份证示例照片
    public $bank_permit_image_demo; //开户许可证电子版示例照片（对公）
    public $bank_account_image_demo; //银行卡复印件示例照片（对私）
    public $entrust_receiv_image_demo; //委托收款授权书电子版示例照片（对私）
    public $payee_identity_image_demo; //收款人身份证电子版示例照片（对私）

    //店铺资质上传图片示例图
    public $recommender_apply_image_demo; //盖机推荐者绑定申请示例照片
    public $store_banner_image_demo; //带招牌的店铺门面照示例照片
    public $store_inner_image_demo; //店铺内部照示例照片

    public function rules()
    {
        return array(

            array('license_image_demo,tax_image_demo,identity_image_demo,bank_permit_image_demo,bank_account_image_demo,entrust_receiv_image_demo,
                payee_identity_image_demo,recommender_apply_image_demo,store_banner_image_demo,store_inner_image_demo',
                'file', 'types' => array('jpg','jpeg','png','bmp'),'allowEmpty' => true,'wrongType'=>'文件格式不正确，文件 "{file}" 无法被上传'),
            array('license_image_demo,tax_image_demo,identity_image_demo,bank_permit_image_demo,bank_account_image_demo,entrust_receiv_image_demo,
                payee_identity_image_demo,recommender_apply_image_demo,store_banner_image_demo,store_inner_image_demo','safe'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'license_image_demo' => Yii::t('offlineSignContractConfigForm','企业营业执照示例照片'),
            'tax_image_demo' => Yii::t('offlineSignContractConfigForm','企业税务登记示例照片'),
            'identity_image_demo' => Yii::t('offlineSignContractConfigForm','企业法人身份证示例照片'),
            'bank_permit_image_demo' => Yii::t('offlineSignContractConfigForm','开户许可证电子版示例照片（对公）'),
            'bank_account_image_demo' => Yii::t('offlineSignContractConfigForm','银行卡复印件示例照片（对私）'),
            'entrust_receiv_image_demo' => Yii::t('offlineSignContractConfigForm','委托收款授权书电子版示例照片（对私）'),
            'payee_identity_image_demo' => Yii::t('offlineSignContractConfigForm','收款人身份证电子版示例照片（对私）'),
            'recommender_apply_image_demo' => Yii::t('offlineSignContractConfigForm','盖机推荐者绑定申请示例照片'),
            'store_banner_image_demo' => Yii::t('offlineSignContractConfigForm','带招牌的店铺门面照示例照片'),
            'store_inner_image_demo' => Yii::t('offlineSignContractConfigForm','店铺内部照示例照片'),
        );
    }
}
?>