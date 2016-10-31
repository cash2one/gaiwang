<?php

/**
 * 酒店订单控制器 
 * 操作 (支付,详情,删除)
 * @author  wencong.lin <183482670@qq.com>
 */
class HotelOrderController extends MController {

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('memberHotelOrder', '酒店订单') . '_' . $this->pageTitle;
        $model = new HotelOrder('frontSearch');
        $model->unsetAttributes();
        if (isset($_GET['HotelOrder']))
          $model->attributes = $this->getQuery('HotelOrder');
        if (isset($_GET['HotelOrder']['code']) && trim($_GET['HotelOrder']['code'])!=''){
            if( preg_match('/^H\d+$/', trim($_GET['HotelOrder']['code'])) ){//纯数字是是订单号,否则是商品名称
                $model->code = trim($_GET['HotelOrder']['code']);
                $model->hotel_name  = '';
            }else{
                $model->code = '';
                $model->hotel_name = trim($_GET['HotelOrder']['code']);
            }
        }
        $data = $model->frontSearch();
        
        //新订单
        $newNum = Yii::app()->db->createCommand()->from('{{hotel_order}}')->select('count(*)')
        ->where('member_id=:mid and status=:status', array(
                ':mid' => $this->getUser()->id,
                ':status' => HotelOrder::STATUS_NEW,
        ))->queryScalar();
        
        //订单确认
        $verifyNum = Yii::app()->db->createCommand()->from('{{hotel_order}}')->select('count(*)')
        ->where('member_id=:mid and status=:status', array(
                ':mid' => $this->getUser()->id,
                ':status' => HotelOrder::STATUS_VERIFY,
        ))->queryScalar();
        //订单完成
        $successNum = Yii::app()->db->createCommand()->from('{{hotel_order}}')->select('count(*)')
        ->where('member_id=:mid and status=:status', array(
                ':mid' => $this->getUser()->id,
                ':status' => HotelOrder::STATUS_SUCCEED,
        ))->queryScalar();
        //订单关闭
        $closeNum = Yii::app()->db->createCommand()->from('{{hotel_order}}')->select('count(*)')
        ->where('member_id=:mid and status=:status', array(
                ':mid' => $this->getUser()->id,
                ':status' => HotelOrder::STATUS_CLOSE,
        ))->queryScalar();
        $this->render('index', array(
            'data' => $data,
            'model' => $model,
            'newNum'=>$newNum,
            'verifyNum'=>$verifyNum,
            'successNum'=>$successNum,
            'closeNum'=>$closeNum
        ));
    }

    /**
     * 订单详细
     * 查看或评论属于会员自己的酒店订单
     * @param int $id   订单ID
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $this->checkPostRequest();  //检查重复提交
        $sql = "SELECT * FROM {{hotel_order}} WHERE id = :id And member_id = :mid FOR UPDATE";
        $with = array(
            'hotel' => array(
                'select' => 'hotel.thumbnail, hotel.province_id, hotel.city_id, hotel.street',
            ),
            'room' => array(
                'select' => 'room.thumbnail',
            )
        );
        $model = HotelOrder::model()->with($with)->findBySql($sql, array(':id' => $id, ':mid' => Yii::app()->user->id));
        if ($model == null) {
            throw new CHttpException(400, Yii::t('memberHotelOrder', '请求的页面不存在！'));
        }
        $model->setScenario('comment');
        $this->performAjaxValidation($model);
        if (isset($_POST['HotelOrder']) && ($model->status == HotelOrder::STATUS_SUCCEED && $model->score == 0))
        {
            $model->attributes = $this->getPost('HotelOrder');
            if ($model->validate()) {
                // 评论成功以后,将返还金额返还给用户
                $res = HotelComment::Comment($model->attributes);
                if ($res === true) {
                    $this->setFlash('success', Yii::t('memberHotelOrder', '评价成功！'));
                } else {
                    $this->setFlash('error', Yii::t('memberHotelOrder', "抱歉，评价失败！"));
                }
                $this->refresh();
            }
        }
        $this->pageTitle = Yii::t('memberHotelOrder', '酒店订单详细') . '_' . $this->pageTitle;
        $this->render('view', array('model' => $model));
    }

}

?>
