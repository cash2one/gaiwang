<?php

/**
 * 站内信控制器
 * 操作（群发）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MessageController extends Controller {

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
        return 'getMember';
    }
    

    public function actionCreate() {
        set_time_limit(3600);
        @ini_set('memory_limit', '2000M');
        $model = new Message;
        $this->performAjaxValidation($model);
        if (isset($_POST['Message'])) {
            $model->attributes = $this->magicQuotes($_POST['Message']);
            if (!empty($_POST['select_all']))
                $condition = 'role=0';
            else {
                $gaiNumbers = explode(',', $model->receiveId);
                $string = $condition = '';
                foreach ($gaiNumbers as $value)
                    $string .= "'" . $value . "',";
                $condition = '`gai_number` IN (' . rtrim($string, ',') . ')';
            }
            $memberIds = Yii::app()->db->createCommand()->select('id')->from('{{member}}')->where($condition)->queryAll();
            if(empty($memberIds)){
                $this->setFlash('error','接收者GW号有误');
                $this->refresh();
            }
            $flag = false;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(!$model->validate()){
                    throw new Exception('validate error');
                }
                Yii::app()->db->createCommand()->insert('{{message}}', array(
                    'title' => $model->title,
                    'content' => $model->content,
                    'create_time' => time(),
                    'sender_id' => $this->getUser()->id,
                    'sender' => 'GW',
                    'receipt_time' => strtotime($model->receipt_time)
                ));
                
                
                $file_path = Yii::getPathOfAlias('webroot').'/../runtime/message_create_sql.sql';
                $file_data = '';
		    	foreach ($memberIds as $value)
		               $file_data .= '"' . Mailbox::STATUS_UNRECEIVE . '","' . $value['id'] . '","' . Yii::app()->db->lastInsertID . '"'."\n";
				file_put_contents($file_path, $file_data);
                
				$sql = '
					load data local infile "'.$file_path.'" 
					into table {{mailbox}} 
					FIELDS TERMINATED BY "," 
					ENCLOSED BY \'"\' 
					ESCAPED BY "\\\" 
					LINES TERMINATED BY "\n" 
					(`status`, `member_id`, `message_id`)
					';
				
		
				Yii::app()->db->createCommand($sql)->execute();
				

                $transaction->commit();
                $flag = true;
            } catch (Exception $e) {
                $transaction->rollBack();
                $this->setFlash('error',Yii::t('message','添加失败:').$e->getMessage());
            }

            @SystemLog::record(Yii::app()->user->name . "添加站内信：" . $model->title);
            if ($flag)
                $this->setFlash('success', Yii::t('message', '添加成功'));
            $this->redirect(array('create'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 获取会员搜索列表
     */
    public function actionGetMember() {
        set_time_limit(120);
        @ini_set('memory_limit', '500M');
        $model = new Member('search');
        $model->unsetAttributes();

        //这里用模糊搜索
        if (isset($_GET['Member'])) {
            $model->searchKeyword = $_GET['Member']['searchKeyword'];
        }

        if (isset($_GET['getall']))
            $model->search_all = $_GET['getall'];

        $this->render('getmember', array(
            'model' => $model,
        ));
    }

}
