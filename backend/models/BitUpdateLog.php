<?php

/**
 *  {{bit_update_log}} 模型
 *
 * The followings are the available columns in table '{{bit_update_log}}':
 * @property integer $id
 * @property string $content
 * @property string $dev
 * @property string $test
 * @property string $created
 */
class BitUpdateLog extends CActiveRecord
{
	public function tableName()
	{
		return '{{bit_update_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('content, code, dev, test', 'required'),
			array('dev, test', 'length', 'max'=>30),
			array('created', 'length', 'max'=>10),
			array('id, content,code, dev, test, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('bitUpdateLog','ID'),
			'content' => Yii::t('bitUpdateLog','更新内容'),
			'code' => Yii::t('bitUpdateLog','代码路径'),
			'dev' => Yii::t('bitUpdateLog','开发者'),
			'test' => Yii::t('bitUpdateLog','测试人'),
			'created' => Yii::t('bitUpdateLog','更新时间'),
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('dev',$this->dev,true);
		$criteria->compare('test',$this->test,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //分页
            ),
            'sort'=>array(
                'defaultOrder'=>'id DESC', //设置默认排序
            ),
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->created = time();
            }
            return true;
        }
        return false;
    }
}
