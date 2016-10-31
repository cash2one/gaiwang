<?php
/**
 * 兴趣爱好
 * 操作(列表，修改)
 *  @author zhenjun_xu <412530435@qq.com>
 * Class InterestsController
 */

class InterestController extends MController {

    public function init(){
        $this->pageTitle = Yii::t('memberInterest','_用户中心_').Yii::app()->name;
    }
    /**
     * 个人兴趣列表选择
     */
    public function actionIndex(){
        $this->pageTitle = Yii::t('memberInterest','兴趣爱好').$this->pageTitle;
        $this->layout = 'member';
        $interestCat = InterestCategory::model()->findAll();
       $this->render('index',array('interestCat'=>$interestCat));
    }

    /**
     * ajax 修改兴趣爱好
     */
    public function actionUpdate(){
        if($this->isAjax()){
            $cid = $this->getPost('cid');
            $ids = $this->getPost('ids');
            $member_id = $this->getUser()->id;

            //先删除
            MemberProfile::model()->deleteAllByAttributes(array('interest_category_id'=>$cid,'member_id'=>$member_id));
            //再添加
            foreach(explode(',',$ids) as $v){
                Yii::app()->db->createCommand()->insert('{{member_profile}}',array(
                    'member_id'=>$member_id,
                    'interest_category_id'=>$cid,
                    'interest_id'=>$v,
                    'update_time'=>time(),
                    'show'=>$this->getPost('show',0),
                ));
            }
            echo 'ok';

        }
    }

    public static $profile = array();
    /** view 中判断是否已经选择了的数据
     * @param int $cid
     * @param int $id
     * @return bool|int
     */
    public function checkSelected($cid,$id=null){
        //会员的兴趣爱好数据
        if(isset(self::$profile[$cid])){
            $profile = self::$profile[$cid];
        }else{
            $profile = MemberProfile::model()->findAllByAttributes(array(
                'member_id'=>$this->getUser()->id,
                'interest_category_id'=>$cid));
            self::$profile[$cid] = $profile;
        }

        /** @var $v MemberProfile */
        if(!$profile) return false;
        foreach($profile as $v){
            if(!$id){
                if($v->interest_category_id == $cid){
                    return $v->show;
                }
            }else{
                if($v->interest_category_id==$cid && $v->interest_id == $id){
                    return true;
                }
            }
        }
        return false;
    }
} 