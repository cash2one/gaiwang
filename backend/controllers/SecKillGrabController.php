<?php

/**
 * 今日必抢管理控制器
 * @author  shengjie.zhang
 */
class SecKillGrabController extends Controller {
    
	public function filters() {
        return array(
            'rights',
            );
    }
        /**
     * 不作权限控制的action
     * @return string
     */
        public function allowedActions() {
            return 'addProduct, chechkProductId';
        }

        
    //今日必抢商品列表
        public function actionAdmin() {
            $num = self::getProductNum();
            $curNum = self::getCurProductNum();       
            
            $sql="SELECT id,rules_id FROM {{seckill_grab}}";
            $result = Yii::app()->db->createCommand($sql)->queryALL();
            foreach ($result as $key => $value) {
                if($value['rules_id']>0){
                    $sql = "SELECT m.name name,concat(m.date_end,' ',srs.end_time) end_time,concat(m.date_start,' ',srs.start_time) start_time  
                    FROM {{seckill_rules_main}} m 
                    LEFT JOIN {{seckill_rules_seting}} srs ON srs.rules_id = m.id 
                    WHERE srs.id='$value[rules_id]'";
                    $rs = Yii::app()->db->createCommand($sql)->queryRow();
                    $Id = $value['id'];
                    $rulesName = isset($rs['name']) && strtotime($rs['end_time'])>time()?$rs['name']:'';

                    $sql   = "UPDATE {{seckill_grab}} SET rules_name='$rulesName' WHERE id={$Id}";
                    Yii::app()->db->createCommand($sql)->execute();
                }
            }
            $model = new SecKillGrab();
            $model->unsetAttributes();
            if (isset($_GET['SecKillGrab']))
                $model->attributes = $_GET['SecKillGrab'];

            $this->render('admin', array(
                'model' => $model,
                'num' => $num,
                'curNum'=>$curNum
                ));
        }

//获取今日必抢商品总数
        private function getProductNum() {
            $sql = "SELECT count(*) FROM {{seckill_grab}}";
            $num = SecKillGrab::model()->countBySql($sql);
            return $num;
        }
    // 获取今日必抢当前展示商品
        private function getCurProductNum(){
            $sql = "SELECT now_number FROM {{seckill_playing}}";
            $num = Yii::app()->db->createCommand($sql)->queryRow();
            return $num['now_number'];
        }

//    AJAX验证商品ID是否是上架产品和是否已添加到今日必抢
        public function actionChechkProductId() {
            if ($this->isAjax() && $this->isPost()) {
                $num = self::getProductNum();
                if ($num >= 20) {
                    exit(json_encode(array('error' => '当前添加商品为20件，如若添加请先移除后再添加！')));
                }
                $id = $this->getPost('id');
                $result = SecKillGrab::model()->findByAttributes(array('product_id' => $id));
                if (empty($id)) {
                    exit(json_encode(array('error' => '商品ID不能为空！')));
                }
                if ($result) {
                    exit(json_encode(array('error' => '该商品已添加到今日必抢，请重新选择商品！')));
                }
                $goods = Goods::model()->findByPk(array('id' => $id));
                if (empty($goods)) {
                    exit(json_encode(array('error' => '该商品不存在，请重新选择商品！')));
                }
                if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
                    exit(json_encode(array('error' => '该商品未上架或未通过审核，请重新选择商品！')));
                }
                if ($goods['is_publish'] == Goods::PUBLISH_YES) {
                    $id = $goods['store_id'];
                    $result = Store::model()->findByPk(array('id' => $id));
                    $msg = array();
                    $msg['goodsname'] = $goods['name'];
                    $msg['storename'] = $result['name'];
                    $msg['success'] = TRUE;
                    exit(json_encode($msg));
                }
                
                
            }
        }

//添加今日必抢商品
        public function actionAddProduct() {
            if ($this->isAjax() && $this->isPost()) {
                $num = self::getProductNum();
                $num ? $num : 0;
                if ($num >= 20) {
                    $tip = array();
                    $tip['error'] = '今日必抢商品已添加20件,请先移除后再重新添加！';
                    exit(json_encode($tip));
                }
                $id = $this->getPost('id');
                $sql = "SELECT g.name product_name,
                s.name seller_name,
                g.id product_id,
                g.stock product_stock,
                g.price product_price,
                g.market_price,
                g.seckill_seting_id rules_id 
                FROM {{goods}} g 
                LEFT JOIN {{store}} s 
                ON g.store_id=s.id 
                WHERE g.id ={$id}";
                $return = Yii::app()->db->createCommand($sql)->queryRow();
                $msg = $return;
                $msg['sort'] = $num + 1;
                if ($return['rules_id']>0) {
                    $ruleId = $return['rules_id'];
                    $sql = "SELECT m.name name,concat(m.date_end,' ',srs.end_time) end_time,concat(m.date_start,' ',srs.start_time) start_time  
                    FROM {{seckill_rules_main}} m 
                    LEFT JOIN {{seckill_rules_seting}} srs ON srs.rules_id = m.id 
                    WHERE srs.id={$ruleId}";
                    $ruleName = Yii::app()->db->createCommand($sql)->queryRow();
                    
                    $msg['rules_name'] = isset($ruleName['name']) && strtotime($ruleName['end_time'])>time()?$ruleName['name']:'';
                }
                $totalNum = $msg['sort'];
                if (Yii::app()->db->createCommand()->insert('{{seckill_grab}}', $msg)) {
                    $sql = "SELECT * FROM {{seckill_playing}}";
                    $res = Yii::app()->db->createCommand($sql)->queryRow();
                    if ($res) {
                        $sql = " UPDATE {{seckill_playing}} SET total_number = {$totalNum},now_number=1,dateline = now()";
                        Yii::app()->db->createCommand($sql)->execute();
                    } else {
                        $sql = " INSERT INTO {{seckill_playing}} SET total_number={$totalNum},now_number=1,dateline = now()";
                        Yii::app()->db->createCommand($sql)->execute();
                    }
                    $tip = array();
                    $tip['success'] = '今日必抢商品添加成功！';
                    exit(json_encode($tip));
                } else {
                    $tip = array();
                    $tip['error'] = '今日必抢商品添加失败！';
                    exit(json_encode($tip));
                }
                
                SecKillGrab::model()->updateGrabCache();
            }
        }

    //更新所有必抢商品信息
        public function actionUpdateAll() {
            $sql = "SELECT id,product_id FROM {{seckill_grab}}";
            $pid = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($pid as $k => $v) {
                $id = intval($v['id']);
                $pid = intval($v['product_id']);
                SecKillGrab::model()->updateProduct($id, $pid);
            }
            
            SecKillGrab::model()->updateGrabCache();
            $this->setFlash('success', '更新成功！');
            $this->redirect(array('admin'));
        }

//    移除今日必抢商品
        public function actionDelete($id) {
            if (SecKillGrab::model()->del($id)) {			
             SecKillGrab::model()->updateGrabCache();
             @SystemLog::record(Yii::app()->user->name . "删除今日必抢商品：{$id}");
             $this->redirect(array('admin'));
         }
     }

 }