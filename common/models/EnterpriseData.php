<?php

/**
 *  {{企业证件资料}} 模型
 *   @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{enterprise_data}}':
 * @property string $id
 * @property string $license
 * @property string $license_photo
 * @property integer $license_province_id
 * @property integer $license_city_id
 * @property integer $license_district_id
 * @property integer $license_start_time
 * @property integer $license_end_time
 * @property string $business_scope
 * @property string $organization
 * @property string $organization_image
 * @property string $tax_id
 * @property string $taxpayer_id
 * @property string $tax_image
 * @property string $threec_image
 * @property string $cosmetics_image
 * @property string $food_image
 * @property string $jewelry_image
 * @property string $declaration_image
 * @property string $report_image
 * @property integer $exists_imported_goods
 * @property string $legal_man
 * @property string $legal_phone
 * @property string $identity_image
 * @property string $identity_image2
 * @property string $debit_card_image
 * @property string $debit_card_image2
 * @property string $enterprise_id
 * @property string $brand_image
 *
 * The followings are the available model relations:
 * @property Enterprise $enterprise
 */
class EnterpriseData extends CActiveRecord
{
	/**
	 * @var int 经营类目
	 */
	public $category_id;

    const EXISTS_IMPORTED_GOODS_NO = 0;
    const EXISTS_IMPORTED_GOODS_YES = 1;

    /**
     * 是否有进口商品
     * @param null $k
     * @return array|null
     */
    public static function existsImportedGoods($k=null){
        $array = array(
            self::EXISTS_IMPORTED_GOODS_NO=>Yii::t('EnterpriseData','无进口商品'),
            self::EXISTS_IMPORTED_GOODS_YES=>Yii::t('EnterpriseData','有进口商品'),
        );
        if($k==null) return $array;
        return isset($array[$k]) ? $array[$k] :null;

    }

	public function tableName()
	{
		return '{{enterprise_data}}';
	}

	public $rules = array(); //验证规则,用于动态修改验证规则

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$rules = array(
			array('brand_image,license_start_time,license_end_time','safe'),
			array('license, license_photo,license_start_time, license_end_time,organization_image,
			tax_image,legal_man', 'required','on'=>'enterpriseLog'),
			array('license_end_time', 'comext.validators.compareDateTime', 'compareAttribute' => 'license_start_time',
				'operator' => '>',
				'on'=>'enterpriseLog',
				'message' => Yii::t('member', '营业执照有效期结束时间 必须大于 开始时间'),),
			array('license, license_photo,tax_image,legal_man,identity_image,identity_image2,debit_card_image,debit_card_image2',
				'required','on'=>'enterpriseLog2'),
                        array('license_province_id, license_city_id, license_district_id','required','on'=>'enterpriseLog,enterpriseLog2,update'),
			//如果类目是个护化妆，必须上传化妆品卫生许可证或者全国工业生产许可证
			array('cosmetics_image','comext.validators.YiiConditionalValidator','if'=>array(
				array('category_id','compare','compareValue'=>Category::TOP_COSMETICS),
			),'then'=>array(
				array('cosmetics_image','required'),
			)),
			//如果类目是饮料食品，必须上传食品流通许可证或全国工业生产许可证
			array('food_image','comext.validators.YiiConditionalValidator','if'=>array(
				array('category_id','compare','compareValue'=>Category::TOP_FOOD),
			),'then'=>array(
				array('food_image','required'),
			)),
			//如果类目是珠宝首饰，必须上传第三方鉴定证书或鉴定报告
			array('jewelry_image','comext.validators.YiiConditionalValidator','if'=>array(
				array('category_id','compare','compareValue'=>Category::TOP_JEWELRY),
			),'then'=>array(
				array('jewelry_image','required'),
			)),
			//如果所选类目存在进口商品,必须上传 进出口商品报关单、进出口商品检测检验报告
			array('declaration_image,report_image','comext.validators.YiiConditionalValidator','if'=>array(
				array('exists_imported_goods','compare','compareValue'=>self::EXISTS_IMPORTED_GOODS_YES),
			),'then'=>array(
				array('declaration_image,report_image','required'),
			)),

			//后台添加企业会员
			array('license, license_photo', 'required','on'=>'insert,update'),
			//end 后台添加企业会员
			array('license_province_id, license_city_id, license_district_id , exists_imported_goods', 'numerical', 'integerOnly'=>true),
			array('license', 'length', 'max'=>64),
			array('license_photo, organization_image, tax_image, threec_image, cosmetics_image, food_image, jewelry_image, declaration_image, report_image, identity_image, identity_image2, debit_card_image, debit_card_image2', 'length', 'max'=>128),
			array('legal_man', 'length', 'max'=>20),
			array('legal_phone', 'length', 'max'=>16),
			array('enterprise_id', 'length', 'max'=>11),
			array('id, license, license_photo, license_province_id, license_city_id, license_district_id, license_start_time, license_end_time, business_scope, organization_image, tax_image, threec_image, cosmetics_image, food_image, jewelry_image, declaration_image, report_image, exists_imported_goods, legal_man, legal_phone, identity_image, identity_image2, debit_card_image, debit_card_image2, enterprise_id', 'safe', 'on'=>'search'),
		);
		if (!empty($this->rules)) {
			$rules = array_merge($this->rules, $rules);
		}
		return $rules;
	}

	public function beforeValidate(){
		if(parent::beforeValidate()){
			isset($_POST['Store']['category_id']) && $this->category_id = $_POST['Store']['category_id'];
			isset($_POST['EnterpriseData']['exists_imported_goods']) && $this->exists_imported_goods = $_POST['EnterpriseData']['exists_imported_goods'];
		}
		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'enterprise' => array(self::BELONGS_TO, 'Enterprise', 'enterprise_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('enterpriseData','主键'),
			'license' => Yii::t('enterpriseData','营业执照号'),
			'license_photo' => Yii::t('enterpriseData','营业执照图片'),
			'license_province_id' => Yii::t('enterpriseData','营业执照所在省'),
			'license_city_id' => Yii::t('enterpriseData','营业执照所在市'),
			'license_district_id' => Yii::t('enterpriseData','营业执照所在区/县'),
			'license_start_time' => Yii::t('enterpriseData','营业执照开始时间'),
			'license_end_time' => Yii::t('enterpriseData','营业执照结束时间'),
			'business_scope' => Yii::t('enterpriseData','法定经营范围'),
//			'organization' => Yii::t('enterpriseData','组织机构代码'), delete
			'organization_image' => Yii::t('enterpriseData','组织机构代码证电子版'),
//			'tax_id' => Yii::t('enterpriseData','税务登记证号'), delete
//			'taxpayer_id' => Yii::t('enterpriseData','纳税人识别号'), delete
			'tax_image' => Yii::t('enterpriseData','税务登记证电子版'),
			'threec_image' => Yii::t('enterpriseData','3c认证电子版'),
			'cosmetics_image' => Yii::t('enterpriseData','化妆品卫生许可证或者全国工业生产许可证'),
			'food_image' => Yii::t('enterpriseData','食品流通许可证或全国工业生产许可证'),
			'jewelry_image' => Yii::t('enterpriseData','第三方鉴定证书或鉴定报告'),
			'brand_image' => Yii::t('enterpriseData','商标注册证或授权书'),
			'declaration_image' => Yii::t('enterpriseData','进出口商品报关单'),
			'report_image' => Yii::t('enterpriseData','进出口商品检测检验报告'),
			'exists_imported_goods' => Yii::t('enterpriseData','所选类目是否存在进口商品'),
			'legal_man' => Yii::t('enterpriseData','法人代表'),
			'legal_phone' => Yii::t('enterpriseData','法人代表联系电话'),
			'identity_image' => Yii::t('enterpriseData','法人代表身份证正面照片'),
			'identity_image2' => Yii::t('enterpriseData','法人代表身份证反面照片'),
			'debit_card_image' => Yii::t('enterpriseData','法人代表银行借记卡正面照片'),
			'debit_card_image2' => Yii::t('enterpriseData','法人代表银行借记卡反面照片'),
			'enterprise_id' => Yii::t('enterpriseData','Enterprise'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('license',$this->license,true);
		$criteria->compare('license_photo',$this->license_photo,true);
		$criteria->compare('license_province_id',$this->license_province_id);
		$criteria->compare('license_city_id',$this->license_city_id);
		$criteria->compare('license_district_id',$this->license_district_id);
		$criteria->compare('license_start_time',$this->license_start_time);
		$criteria->compare('license_end_time',$this->license_end_time);
		$criteria->compare('business_scope',$this->business_scope,true);
//		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('organization_image',$this->organization_image,true);
//		$criteria->compare('tax_id',$this->tax_id,true);
//		$criteria->compare('taxpayer_id',$this->taxpayer_id,true);
		$criteria->compare('tax_image',$this->tax_image,true);
		$criteria->compare('threec_image',$this->threec_image,true);
		$criteria->compare('cosmetics_image',$this->cosmetics_image,true);
		$criteria->compare('food_image',$this->food_image,true);
		$criteria->compare('jewelry_image',$this->jewelry_image,true);
		$criteria->compare('declaration_image',$this->declaration_image,true);
		$criteria->compare('report_image',$this->report_image,true);
		$criteria->compare('exists_imported_goods',$this->exists_imported_goods);
		$criteria->compare('legal_man',$this->legal_man,true);
		$criteria->compare('legal_phone',$this->legal_phone,true);
		$criteria->compare('identity_image',$this->identity_image,true);
		$criteria->compare('identity_image2',$this->identity_image2,true);
		$criteria->compare('debit_card_image',$this->debit_card_image,true);
		$criteria->compare('debit_card_image2',$this->debit_card_image2,true);
		$criteria->compare('enterprise_id',$this->enterprise_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                //'defaultOrder'=>' DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
