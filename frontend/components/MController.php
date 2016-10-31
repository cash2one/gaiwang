<?php

/**
 * 会员中心控制器父类
 * 操作一些常用的查询，调用
 * 减少不必要的查询
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MController extends Controller {

    public $model;
    /**
     * @var array 账户积分相关数据
     */
    public $account;
    public $isMobile = true; //是否有绑定手机号码的标识
    public function beforeAction($action) {
        $this->model = Tool::getMemberLoginCache($this->getUser()->id);
        if($this->model->flag==Member::FLAG_NO){
            $this->setFlash('activation',Yii::t('member','您的账号还未激活，请激活'));
        }
        //如果会员没有绑定手机号码.要强制绑定手机号码的.
        if (empty($this->model->mobile)){
            $this->isMobile = false;
            //v2.0 未绑定手机进入会员中心，跳转到绑定手机页面
            if(Yii::app()->theme){
                if($this->id.'/'.$this->action->id != 'member/mobile' && !$this->isAjax()){
                    $this->redirect(array('/member/member/mobile'));
                }
            } else {
                $mustCheck = array(
                    'enterpriseLog/enterprise',
                    'enterpriseLog/enterprise2',
                    'member/setPassword1',
                    'member/setPassword2',
                    'member/setPassword3',
                    'applyCash/list',
                );
                if (in_array($this->id.'/'.$this->action->id,$mustCheck) && !$this->isAjax()){
                    $this->redirect(array('/member/member/update'));
                }
            }
        }

        if(!$this->isAjax()){
            $this->account = Member::account($this->model);
        }
        return parent::beforeAction($action);
    }
}
