<?php

/**
 * 红包控制器
 * @author 
 */
class BonusController extends WController
{
    
    public $top=true;
    public $showTitle='盖网红包';
    public $layout=' ';
    
    /**
     * 红包列表
     */
     public function actionIndex() {
         $this->render('redBag');
    }
    /**
     * 红包广场(购物红包）
     */
    public function actionRedQuare(){
        $data = Yii::app()->db->createCommand()
            ->select('t.thumbnail,s.name,s.category_id')
            ->from(CouponActivity::model()->tableName().' t')
            ->leftJoin(Store::model()->tableName().' s', 's.id = t.store_id')
            ->where('t.valid_end >= :valid_end and t.status = :status ', array(':valid_end' => time(), ':status' => CouponActivity::COUPON_STATUS_PASS))
            ->queryAll();
        $category = array();
        foreach($data as $value){
            $categoryModel = Category::model()->findByPk($value['category_id'],array('select' => 'name'));
            $category[$value['category_id']] = $categoryModel['name'];
        }
        $this->render('redQuare',array('category' => $category));
    }
    /**
     * 红包广场详情
     */
     public function actionRedQuareDetail() {
         $this->render('redDetail');
    }
    /**
     * 注册送红包
     */
    public function actionRedRegister() {
        $criteria=new CDbCriteria();
        $criteria->select = 't.id,t.price,t.condition,t.valid_start,t.valid_end,t.thumbnail,s.name';
        $criteria->join = 'left join `gw_store` s on(s.id=t.store_id)';
        $criteria->condition = 't.valid_end >= :valid_end and t.status = :status';
        $criteria->params = array(':valid_end' => time(), ':status' => CouponActivity::COUPON_STATUS_PASS);
        $count = CouponActivity::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->pageSize = 2;//每页显示两条优惠券记录
        $pages->applyLimit($criteria);
        $data = CouponActivity::model()->findAll($criteria);
        $this->render('redRegister',array('data' => $data, 'pages' => $pages));
    }
    /**
     * 红包分享
     */
    public function actionShareStep() {
        $this->render('shareStep');
    }
    /**
     * 我的红包积分
     */
    public function actionRedPoint() {
        $this->showTitle=Yii::t('redEnvelopeActivity','我的红包积分');
        $this->render('redPoint');
    }

    /**
     * 红包领取记录
     */
    public function actionBonusPointsRecord(){
        $this->render('record');
    }
    
    
}
