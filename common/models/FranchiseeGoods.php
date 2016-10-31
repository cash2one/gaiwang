<?php

/**
 * This is the model class for table "{{franchisee_goods}}".
 *
 * The followings are the available columns in table '{{franchisee_goods}}':
 * @property string $id
 * @property string $franchisee_goods_category_id
 * @property string $franchisee_id
 * @property string $name
 * @property string $thumbnail
 * @property string $sales_volume
 * @property integer $status
 * @property string $content
 * @property string $comments
 * @property string $total_score
 * @property string $create_time
 * @property string $update_time
 * @property integer $discount
 * @property string $member_price
 * @property string $seller_price
 *
 * The followings are the available model relations:
 * @property Franchisee $franchisee
 * @property FranchiseeGoodsCategory $franchiseeGoodsCategory
 * @property FranchiseeGoodsComment[] $franchiseeGoodsComments
 * @property FranchiseeGoodsPicture[] $franchiseeGoodsPictures
 */
class FranchiseeGoods extends CActiveRecord
{

// 状态
    const STATUS_DRAFT = 0;
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;
    
    public $path;			//图片路径

public static function getStatus($status=null) {
        $arr =  array(
            self::STATUS_DRAFT => Yii::t('franchiseeGoods', '草稿'),
            self::STATUS_ENABLE => Yii::t('franchiseeGoods', '上架'),
            self::STATUS_DISABLE => Yii::t('franchiseeGoods', '下架'),
        );
        return $status!==null?$arr[$status]:$arr;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('franchisee_id, name, thumbnail, content, discount, member_price, seller_price,status,franchisee_goods_category_id', 'required'),
			array('status, discount', 'numerical', 'integerOnly'=>true),
			array('franchisee_goods_category_id, franchisee_id, sales_volume, comments, total_score, create_time, update_time', 'length', 'max'=>11),
			array('name, thumbnail', 'length', 'max'=>128),
			array('member_price, seller_price', 'length', 'max'=>18),
			array('path', 'length', 'max' => 1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, franchisee_goods_category_id, franchisee_id, name, thumbnail, sales_volume, status, content, comments, total_score, create_time, update_time, discount, member_price, seller_price,path', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
			'franchiseeGoodsCategory' => array(self::BELONGS_TO, 'FranchiseeGoodsCategory', 'franchisee_goods_category_id'),
			'franchiseeGoodsComments' => array(self::HAS_MANY, 'FranchiseeGoodsComment', 'franchisee_goods_id'),
			'franchiseeGoodsPictures' => array(self::HAS_MANY, 'FranchiseeGoodsPicture', 'franchisee_goods_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'franchisee_goods_category_id' => '线下商品分类',
			'franchisee_id' => '所属线下商家',
			'name' => '名称',
			'thumbnail' => '代表图',
			'sales_volume' => '销量',
			'status' => '状态',
			'content' => '说明',
			'comments' => '评论数',
			'total_score' => '总评分',
			'create_time' => '创建时间',
			'update_time' => '更新时间',
			'discount' => '折扣',
			'member_price' => '会员价',
			'seller_price' => '销售价',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('franchisee_goods_category_id',$this->franchisee_goods_category_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);
		$criteria->compare('sales_volume',$this->sales_volume,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('total_score',$this->total_score,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('member_price',$this->member_price,true);
		$criteria->compare('seller_price',$this->seller_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function afterSave() {
		parent::afterSave();
	
		//保存图片列表
		$paths = explode('|', $this->path);
		if (!empty($paths) && !empty($this->path)) {
			if (!$this->isNewRecord) {
				//删除旧的图片列表关系    先找出所有图片 然后对比删除不存在的图片
				$all_paths_rs = FranchiseeGoodsPicture::model()->findAll("franchisee_goods_id={$this->id}");
				$all_paths = array();
				foreach ($all_paths_rs as $path) {
					$all_paths[] = $path->path;
				}
	
				foreach ($all_paths as $p) {
					if (!in_array($p, $paths)) {
						UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $p);
					}
				}
	
				FranchiseeGoodsPicture::model()->deleteAll("franchisee_goods_id={$this->id}");
			}

			foreach ($paths as $path) {
				$fp = new FranchiseeGoodsPicture();
				$fp->franchisee_goods_id = $this->id;
				$fp->path = $path;
				$fp->save();
			}
		}
		return true;
	}
	
}
