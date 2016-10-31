<?php

/**
 * 后台操作日志
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $id
 * @property string $user_id
 * @property string $username
 * @property string $info
 * @property string $ip
 */
class SystemLog extends CActiveRecord {

    public function tableName() {
        return '{{system_log}}';
    }

    public function rules() {
        return array(
            array('user_id, username, info, ip, create_time', 'safe')
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 写日志
     * @param string $message
     */
    public static function record($message) {
        if (!YII_DEBUG || 1 == 1) {
            $model = new SystemLog;
            $model->create_time = time();
            $model->ip = Tool::getIP();
            $model->user_id = PHP_SAPI === 'cli' ? '0' : Yii::app()->user->id;
            $model->username = PHP_SAPI === 'cli' ? 'system' : Yii::app()->user->name;
            $model->info = $message;
            $model->save();
        }
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t('user', '用户ID'),
            'username' => Yii::t('user', '用户名'),
            'info' => Yii::t('user', '操作详细'),
            'ip' => Yii::t('user', '操作ip'),
            'create_time' => Yii::t('user', '操作时间'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('info', $this->info, true);
        $criteria->order = 'create_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
