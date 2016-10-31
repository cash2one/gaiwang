<?php

/**
 * 派发红包，将 import_member 表中的金额，生成充值卡，充值到会员指定账户中去
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class GiveCashController extends MController
{

    public function init()
    {
        if (!$this->getUser()->isGuest && substr($this->getUser()->gw, 0, 4) != 'GW03') {
            throw new CHttpException(403);
        }
    }

    /**
     * 红包金额显示
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('memberGiveCash', '派发红包') . '_' . $this->pageTitle;
        $importMember = Yii::app()->db->createCommand()->from('{{import_member}}')->where('member_id=:id', array(':id' => $this->getUser()->id))->queryRow();
        $model = new GiveCashForm();
        $model->mobile2 = Yii::app()->db->createCommand()->select('mobile')->from('{{member}}')->where('id=:id',array(':id'=>$this->getUser()->id))->queryScalar();
        $this->performAjaxValidation($model);
        if (isset($_POST['GiveCashForm'])) {
            $model->attributes = $this->getPost('GiveCashForm');
            /**
             * 如果存在$_POST['gai_number'] 则是批量派发，将金额全部累加到 $model->cash 用于验证
             */
            if(isset($_POST['gai_number'])){
                $gai_numbersArr = $this->getPost('gai_number');
                $model->cash = 0;
                foreach($gai_numbersArr as $v){
                    $model->cash += $v;
                }
            }else{
                $gai_numbersArr = array($model->gai_number=>$model->cash);
            }
            if ($model->validate()) {
                    foreach($gai_numbersArr as $k => $v){
                        $this->_doGiveMoney($k,$v,$importMember);
                    }
                $this->refresh();
            } else {
                $this->setFlash('error', Yii::t('memberGiveCash', '验证提交数据失败'));
                throw new CHttpException(403);
            }
        }
        $this->render('index', array('importMember' => $importMember, 'model' => $model));
    }

    /**
     * 事务执行派发红包
     * @param $gai_number
     * @param $cash
     * @param array $importMember
     * @return bool
     */
    private function _doGiveMoney($gai_number,$cash,&$importMember){
        $type = MemberType::fileCache();
        $card = PrepaidCard::generateCardInfo();
        $version = 'v' . date('YmdHis', time());
        $value = sprintf("%.2f", $cash / $type['official']);
        $member = Yii::app()->db->createCommand()->from('{{member}}')->where('gai_number=:gw', array(':gw' => $gai_number))->queryRow();
        //事务
        $trans = Yii::app()->db->beginTransaction();
        try {
            //生成充值卡
            Yii::app()->db->createCommand()->insert('{{prepaid_card}}', array(
                'status' => PrepaidCard::STATUS_UNUSED,
                'create_time' => time(),
                'author_id' => $this->getUser()->id,
                'author_name' => $this->getUser()->gw,
                'author_ip' => Tool::ip2int(Yii::app()->request->userHostAddress),
                'value' => $value,
                'number' => $card['number'],
                'password' => $card['password'],
                'type' => PrepaidCard::TYPE_SPECIAL,
                'money' => $cash,
                'is_recon' => PrepaidCard::RECON_NO,
                'owner_id' => $this->getUser()->id,
                'version' => $version,
                'flag'=>GiveCashForm::FLAG_GIVE_CASH,
            ));
            $prepaidCard = array(
                'id' => Yii::app()->db->lastInsertID,
                'number' => $card['number'],
                'value' => $value,
                'type' => PrepaidCard::TYPE_SPECIAL,
                'version' => $version
            );

            $template = PrepaidCardUse::recharge($prepaidCard, $member, $type, false, false);
            //更新余额
            $sql = 'UPDATE `{{import_member}}` SET `cash`=:cash, `update_time`=:update_time  WHERE (`id`=:id)';
            $importMember['cash'] = $importMember['cash'] - $cash;
            Yii::app()->db->createCommand($sql)->bindValues(array(
                ':id' => $importMember['id'],
                ':cash' => $importMember['cash'],
                ':update_time' => time(),
            ))->execute();
            //检测借贷平衡
            $trans->commit();
            $this->setFlash('success', '派发红包成功');
            $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            $this->setFlash('error', Yii::t('memberGiveCash', '派发红包失败 001'));
            $flag = false;
        }
        // 发送短信
        if ($flag == true && $member['mobile']){
            SmsLog::addSmsLog($member['mobile'],$template);
        }
        return $flag;
    }
    /**
     * ajax 根据手机号，查找member 表中的盖网编号
     */
    public function actionFindGw()
    {
        $mobile = $this->getPost('mobile');
        $members = Member::model()->findAllByAttributes(array('mobile' => $mobile));
        $gwHtml = '';
        if ($members) {
            foreach ($members as $v) {
                $gwHtml .= CHtml::tag('option', array('value' => $v->gai_number), $v->gai_number, true);
            }
        }
        echo json_encode(
            array(
                'dropDownGW' => $gwHtml
            )
        );
    }
} 