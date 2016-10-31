<?php
    
    /**
     * 1.绑定邮箱唯一性验证
     * 2.修改邮箱前后是否一样验证
     * @author qiuye.xu<qiuye.xu@g-emall.com>
     */
    class emailUnique extends CUniqueValidator
    {
        protected function validateAttribute($object, $attribute)
        {
            $value = $object->$attribute;
            if ($this->allowEmpty && $this->isEmpty($value))
                return;
            if (is_array($value)) {
                $this->addError($object, $attribute, Yii::t('yii', '{attribute} is invalid.'));
                return;
            }

            $member = Yii::app()->db->createCommand()
                    ->select('count(id) as id,email')
                    ->from('{{member}}')
                    ->where('email=:email',array(':email'=>$object->email))
                    ->queryRow();
            if($member['id']){
//                $this->addError($object, $attribute, Yii::t('yii', '{attribute} is .'));
                parent::validateAttribute($object, $attribute);
            }
            if($member['email'] == $object->email){
                $this->addError($object, $attribute, Yii::t('yii', '修改{attribute}前后一样'));
                 parent::validateAttribute($object, $attribute);
            }
        }
    }
     
?>
