<?php

/**
 *  {{franchisee_picture}} 模型
 *
 * The followings are the available columns in table '{{franchisee_picture}}':
 * @property string $id
 * @property string $franchisee_id
 * @property string $path
 * @property integer $sort
 */
class FranchiseePicture extends CActiveRecord {

	public $pageSize;		//分页大小
	
    public function tableName() {
        return '{{franchisee_picture}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('franchisee_id, path', 'required'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('franchisee_id', 'length', 'max' => 11),
            array('path', 'length', 'max' => 128),
            array('id, franchisee_id, path, sort', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('franchiseePicture', '主键id'),
            'franchisee_id' => Yii::t('franchiseePicture', '所属加盟商'),
            'path' => Yii::t('franchiseePicture', '路径'),
            'sort' => Yii::t('franchiseePicture', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('path', $this->path);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => empty($this->pageSize)?20:$this->pageSize, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }
    
public function searchAll() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('path', $this->path);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
