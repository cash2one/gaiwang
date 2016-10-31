<?php

/**
 * 公共动作类
 * @author zhenjun_xu <412530435@qq.com>
 */
class CommonAction extends CAction
{
    /**
     * @var string 需要执行本类的方法名称
     */
    public $method;

    public function run()
    {
        if (method_exists($this, $this->method)) {
            $method = $this->method;
            $this->$method();
        } else {
            throw new Exception('can not find the method :' . $this->method);
        }
    }

    /**
     * ajax 选择语言
     */
    protected function selectLanguage()
    {
        Yii::app()->user->setState('selectLanguage', Yii::app()->request->getParam('language'));
    }

    /**
     * ajax 检查支付密码
     */
    public function validatePassword3() {
        /** @var Member $data */
        $data = Member::model()->findByPk(Yii::app()->user->id);
        $error = array();
        if($data->password3){
            $result = $data->validatePassword3( Yii::app()->request->getPost('password3') );
            if(!$result) $error['msg'] =  Yii::t('orderFlow', '支付密码错误!');
        }else{
            $error['msg'] = Yii::t('orderFlow','您还未设置盖网支付密码！');
        }
        exit(CJSON::encode($error));
    }

} 