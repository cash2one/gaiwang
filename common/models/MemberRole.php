<?php

/**
 *  会员角色模型
 *  @author qinghao.ye <qinghaoye@sina.com>
 */
class MemberRole extends CActiveRecord {

    public function tableName() {
        return '{{member_role}}';
    }

    public function rules() {
        return array(
            array('name, code, deadline,description', 'required'),
            array('thumbnail','required','on'=>'insert'),
            array('deadline', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('code', 'length', 'max' => 56),
            array('description', 'length', 'max' => 256),
            array('id, name, code, thumbnail, deadline, description', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('memberRole', '主键id'),
            'name' => Yii::t('memberRole', '角色名称'),
            'code' => Yii::t('memberRole', '角色编码'),
            'thumbnail' => Yii::t('memberRole', '角色头像'),
            'deadline' => Yii::t('memberRole', '期限（天）'),
            'description' => Yii::t('memberRole', '说明'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('deadline', $this->deadline);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            'defaultOrder'=>'id ASC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 删除角色的时候 把它的上传图片文件也删掉
     */
    protected function afterDelete() {
        parent::afterDelete();
        $this->deleteImg($this->thumbnail);
    }
    
    /**
     * 删除图片和目录
     * @param type $dir
     */
    public function deleteImg($url){
        if ($url) {
            $path = substr($url, strpos($url, 'role/'));
            $file = Yii::getPathOfAlias('att') . DS . $path;
            UploadedFile::delete($file);
        }
    }


}
