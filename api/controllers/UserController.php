<?php

/**
 * 盖网通会员接口
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class UserController extends Controller {

    /**
     * 注册新用户
     */
    public function actionRegister() {
        $this->actionType = '';
        $this->checkRequest();
        $rsa = new RSA();
        $userPhone = $rsa->decrypt($this->checkParam('UserPhone'));    //用户手机号
        $checkCode = $this->checkParam('CheckCode');    //验证码(加密)
        $Invite = $this->getPost('Invite');    //推荐人
        $machineId =  $this->checkParam('machineId');    //盖机id
        $regType =  $this->getPost('RegType');
        $password = $this->getPost('passWord');
        $tempPassword = $password;//记录传送过来的密码，仅发短信的时候使用
        $password = empty($password)?substr(time(), 7) . sprintf("%03d", rand(1, 999)):$rsa->decrypt($password);
        // 解密
        $checkCode = $rsa->decrypt($checkCode);
        
        // 检查验证码
        $this->checkVerifyCode($checkCode);
        
        switch ($regType)
        {
            case 2:
                if(!Api::validateUsername($userPhone))$this->errorEndXml(Yii::t('MachineForGt', '该用户名已被注册'));
                break;
            default:
                // 检查电话号码是否已经注册
                if(!Api::validateMobile($userPhone))$this->errorEndXml(Yii::t('MachineForGt', '该电话号码格式不正确'));
                $count = ApiMember::getMemberCountByMobile($userPhone);
                if ($count) {
                    $this->errorEndXml(Yii::t('MachineForGt', '该电话号码已被注册'));
                }
                break;
        }
        //注册没有填推荐者时,默认绑定本机商户为推荐者
        if($Invite == false){
            $sql = "SELECT mm.id,mm.`status`,mm.mobile FROM gaitong.gt_machine AS m
            INNER JOIN gaiwang.gw_franchisee AS mf ON mf.id=m.biz_info_id
            INNER JOIN gaiwang.gw_member AS mm ON mm.id=mf.member_id
            WHERE m.id='{$machineId}'";
            $referrals = Yii::app()->db->createCommand($sql)
                ->queryRow();
            if(empty($referrals)){
                $this->errorEndXml(Yii::t('MachineForGt','该机器的商家账号不存在'));
            }elseif($referrals['status'] > Member::STATUS_NORMAL){
                $this->errorEndXml(Yii::t('MachineForGt','该机器的商家账号已被冻结'));
            }
        }
        elseif(!$referrals = ApiMember::getMemberByGainumber($Invite))
            $this->errorEndXml(Yii::t('MachineForGt','该盖网号不存在或者已冻结'));
        
        $referrals_id = isset($referrals['id'])?$referrals['id']:'';
        // 添加用户
        $gaiNumber = ApiMember::makeGaiNumber();
		if(empty($tempPassword)){
			$smsContent = "欢迎您成为盖网的{0}，会员编码是：{1}，临时密码是：{2}。请尽快登录盖象修改密码，切忌转发。";
			$smsContent = str_replace(array('{0}','{1}','{2}'), array(Yii::t('MachineForGt','会员'),$gaiNumber,$password),$smsContent);
                                                     $datas = array(Yii::t('MachineForGt','会员'),$gaiNumber,$password);
                                                     $smsConfig = $this->getConfig('smsmodel');
                                                     $tmpId = $smsConfig['newMemberContentId'];
		}else{
			$smsContent = "欢迎您成为盖网的{0}，会员编码是：{1}。请登录盖象商城完善资料。";
			$smsContent = str_replace(array('{0}','{1}'), array(Yii::t('MachineForGt','会员'),$gaiNumber),$smsContent);
                                                    $datas = array(Yii::t('MachineForGt','会员'),$gaiNumber);
                                                     $smsConfig = $this->getConfig('smsmodel');
                                                     $tmpId = $smsConfig['newMemberNoContentId'];
		}
        switch ($regType)
        {
            case 2:
                $res = ApiMember::AddMember_gt_Name($userPhone, $password, $gaiNumber,$machineId,$referrals_id, $smsContent,1);
                break;
            default:            
                $res = ApiMember::AddMember_gt($userPhone, $password, $gaiNumber,$machineId,$referrals_id, $smsContent,1, $datas, $tmpId);
                break;
        }
        
        if($res)
        {
            if($referrals_id!='')
            {
                
                if($activity = RedEnvelopeTool::createGtRedEnvelope($referrals_id,Activity::TYPE_SHARE,Coupon::SOURCE_GT))
                {
                    RedEnvelopeTool::_sendSms($referrals['mobile'], Activity::TYPE_SHARE, $activity['money']);
                }
            }
            $xml = '';
            $xml.='<GWNumber>' . $gaiNumber . '</GWNumber>';

            //检查活动
            if(ApiActivity::checkRunning($machineId)){
                $xml.='<Prize>1</Prize>';
            }else{
                $xml.='<Prize>0</Prize>';
            }

            echo $this->exportXml($xml);
        } else {
            $this->errorEndXml(Yii::t('MachineForGt','注册失败'));
        }
    }

    /**
     * 用户签到后要增加相应的积分
     */
    public function actionSignin(){
        $this->addLog('apiGwt',"1.post: ",$_POST);
        $this->actionType = 'member/regi';
        $this->checkRequest();
        // 解密
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode'))); //验证码
        $ipAddress = $this->checkParam('Ip');    //ip
        $machineId = $this->checkParam('machine_id');    //盖网通id
        $userPhone = '';
        $gaiNumber = $this->getPost('Name');//用户账号
        if($gaiNumber != false){
            $member = ApiMember::getMemberByGainumber($gaiNumber);
            if(empty($member)) $this->errorEndXml('账号不存在');
        }else{
            $userPhone = $this->checkParam('UserPhone');    //用户手机号
            $member = $this->findMemberByPhone($userPhone);
        }
        $this->addLog('apiGwt',"2.post: ".$gaiNumber.'-'.$userPhone,$member);
        if($member['status'] > Member::STATUS_NORMAL){
            $status = Member::status((int)$member['status']);
            if(is_array($status)) $status = '未知';
            $this->errorEndXml('当前用户为"'.$status.'"状态');
        }
        $memberId = $member['id'];
        
        // 是否今天已签订
        $signed = ApiMember::getSigninCountToday($memberId, $machineId);
        if($signed){
            $this->errorEndXml('您今天已经在本机上签到了');
        }
        // 签到
        if(!ApiMember::signin($member, $machineId, Tool::ip2int($ipAddress))){
            $this->errorEndXml('签到失败');
        }
        
        // 输出
        $memberDis = Yii::app()->db->createCommand()->select(array('discount'))->from('{{member_type}}')
                ->where('id=:id', array(':id'=>$member['type_id']))
                ->queryScalar();
        $type = $member['type_id'] == MemberType::MEMBER_EXPENSE ? '消费会员' : ($member['type_id'] == MemberType::MEMBER_OFFICAL ? '正式会员' : '');
        $memberDis = $memberDis ? $memberDis : 0;
        $xml = '<MemberType>'.$type.'</MemberType><Discount>'.$memberDis.'</Discount>';
        echo $this->exportXml($xml);
    }
    
    /**
     * 会员登陆充值接口
     * 
     */
    public function actionLoginAddPoint(){
        $this->checkRequest();
        $checkCode = $this->checkParam('CheckCode');    //验证码
        $userPhone = $this->checkParam('UserPhone');    //用户手机号
        $password = $this->checkParam('MemberCode');    //密码
        $point = $this->checkParam('Point');    //积分
        if(!is_numeric($point) || $point < 1){
            $this->errorEndXml('请输入正确积分');
        }
        // 解密
        $rsa = new RSA();
        $checkCode = $rsa->decrypt($checkCode);
        $userPhone = $rsa->decrypt($userPhone);
        $password = $rsa->decrypt($password);
        // 检查验证码
        $this->checkVerifyCode($checkCode);
        // 会员验证
//        $member = $this->findMemberByPhone($userPhone);
        $member = ApiMember::getMemberByPhone($userPhone);
        if(!is_array($member) && is_string($member)){
            if($member == '账号不存在!'){
               $this->errorEndXml($member,'<ErrorType>1</ErrorType>'); 
            }
            $this->errorEndXml($member);
        }
        if(!ApiMember::verifyPwd($password,$member)){
            $this->errorEndXml('密码错误','<ErrorType>2</ErrorType>');
        }elseif($member['status'] > Member::STATUS_NORMAL){
            $status = Member::status((int)$member['status']);
            if(is_array($status)) $status = '未知';
            $this->errorEndXml('当前用户为"'.$status.'"状态');
        }
        // 生成充值卡
        $card = $this->createCard($member,$point);
        // 充值
        if(empty($card)){
            $this->errorEndXml('创建充值卡失败');
        }
        $memberType = MemberType::fileCache();
        if ($memberType === null) $this->errorEndXml('意外出错');
        $restult = PrepaidCardUse::recharge($card, $member, $memberType);
        if($restult == false){
            $this->errorEndXml('充值失败');
        }
        $xml = "<RechargeCardNo>{$card['number']}</RechargeCardNo><RechargeTime>".date("Y-m-d H:i:s")."</RechargeTime><GaiNumber>{$member['gai_number']}</GaiNumber>";
        echo $this->exportXml($xml);
    }
    
    /**
     * 注册帐号充值
     */
    public function actionRegAddPoint(){
        $this->checkRequest();
        $checkCode = $this->checkParam('CheckCode');    //验证码
        $userPhone = $this->checkParam('UserPhone');    //用户手机号
        $point = $this->checkParam('Point');    //积分
        if(!is_numeric($point) || $point < 1){
            $this->errorEndXml('请输入正确积分');
        }
        $bizId = $this->checkParam('BizId');    //加盟商id
        
        // 检查验证码
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($checkCode));
        $userPhone = $rsa->decrypt($userPhone);
        
        // 检查电话号码是否已经注册
        $count = ApiMember::getMemberCountByMobile($userPhone);
        if ($count) {
            $this->errorEndXml('该电话号码已被注册');
        }
        // 添加用户
        $gaiNumber = ApiMember::makeGaiNumber();
        $password = substr(time(), 7) . sprintf("%03d", rand(1, 999));
        $smsContent = $this->getConfig('smsmodel','addMemberContent');//registerPhoneSucc
        $smsContent = str_replace(array('{0}','{1}','{2}','{3}'), array('会员',$userPhone,$gaiNumber,$password),$smsContent);
        $datas = array('会员',$userPhone,$gaiNumber,$password);
        $smsConfig = $this->getConfig('smsmodel');
        $tmpId = $smsConfig['addMemberContentId'];
        $memberId = ApiMember::AddMember_gt($userPhone, $password, $gaiNumber, $bizId, $smsContent,1,$datas , $tmpId);
        if (!$memberId) {
            $this->errorEndXml('注册失败');
        }
        $member = ApiMember::getMemberByPhone($userPhone);
        if (empty($member)) {
            $this->errorEndXml('注册失败');
        }
        // 生成充值卡
        $card = $this->createCard($member,$point);
        // 充值
        if(empty($card)){
            $this->errorEndXml('创建充值卡失败');
        }
        $memberType = MemberType::fileCache();
        if ($memberType === null) $this->errorEndXml('意外出错');
        $restult = PrepaidCardUse::recharge($card, $member, $memberType);
        if($restult == false){
            $this->errorEndXml('充值失败');
        }
        $xml = "<RechargeCardNo>{$card['number']}</RechargeCardNo><RechargeTime>".date("Y-m-d H:i:s")."</RechargeTime><GaiNumber>{$member['gai_number']}</GaiNumber>";
        echo $this->exportXml($xml);
    }
    
    public function createCard($member,$point) {
        $commit = false;
        $addCard = array();
        if($point > 0){
            $money = Common::reverseSingle($point, $member['type_id']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $card = PrepaidCard::generateCardInfo();
                $addCard = array(
                    'money' => $money,
                    'status' => PrepaidCard::STATUS_UNUSED,
                    'create_time' => time(),
                    'author_id' => $member['id'],
                    'author_name' => $member['username'],
                    'author_ip' => Tool::ip2int(Yii::app()->request->userHostAddress),
                    'value' => $point,
                    'number' => $card['number'],
                    'password' => $card['password'],
                    'type' => PrepaidCard::TYPE_SPECIAL,
                    'is_recon' => PrepaidCard::RECON_NO,
                    'owner_id' => $member['id'],
                    'version' => 'v' . date('YmdHis', time())
                );
                Yii::app()->db->createCommand()->insert('{{prepaid_card}}', $addCard);
                $addCard['id'] = Yii::app()->db->getLastInsertID();
                $transaction->commit();
                $commit = true;
            }catch (Exception $e){
                $transaction->rollBack();
                $commit = false;
            }
        }
        if($commit == true){
            $name = $member['username'] ? $member['username'] : $member['gai_number'];
            @SystemLog::record('盖网通用户'.$name.'登录充值,添加充值卡：'. $card['number'] . ' money->' . $money);
            return $addCard;
        }
        return false;
    }
    
    public function actionLoginGW(){
        $this->actionType = 'member/loginGW';
        $this->checkRequest();
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码
        $userPhone = $rsa->decrypt($this->checkParam('UserPhone'));    //用户手机号
        $uptime = $rsa->decrypt($this->checkParam('Uptime'));    //提交时间
        $res = Yii::app()->db->createCommand()->from('{{member}}')->select('gai_number,type_id,password')
                    ->where('(username=:params or mobile=:params) and status<=:status and role=:role', array(
                            ':params' => $userPhone,':status'=> Member::STATUS_NORMAL, 'role'=>'0'))
                ->queryAll();
        if(empty($res)){
            $this->errorEndXml('该用户不存在');
        }
        foreach ($res as $key => $val) {
            $ary[$key]['MemberName'] = $val['gai_number'];
            $ary[$key]['MemberType'] = $val['type_id'];
            $ary[$key]['MemberID'] = $val['password'];
            $memberDis = ApiMember::getMemberDiscount($val['type_id']);
            $ary[$key]['Discount'] = $memberDis ? $memberDis : 0;

        }
        $xml = '<Members>'.Api::arrayToXml($ary, 'Member').'</Members>';
        echo $this->exportXml($xml);
    }
    
    public function actionLoginCheck(){
        $this->actionType = 'member/loginCheck';
        $this->checkRequest();
        $rsa = new RSA();
        $rsa->decrypt($this->checkParam('Name'));    //用户账户
        $gainumber = $rsa->decrypt($this->checkParam('Number'));    //用户密码
        $uptime = $rsa->decrypt($this->checkParam('Uptime'));    //提交时间
        
        $res = Yii::app()->db->createCommand()->from('{{member}}')->select('gai_number')
                    ->where('gai_number=:params and status<=:status and role=:role', array(
                            ':params' => $gainumber,':status'=> Member::STATUS_NORMAL, 'role'=>'0'))
                ->queryScalar();
        if(!$res){
            $this->errorEndXml('该用户不存在');
        }
//        if(){
//            
//        }
        echo $this->exportXml('');
    }
    
    /**
     * 10.登陆时先获取GW账户 返回一个或多个，再进行登录
     */
    public function actionLoginGetAccount(){
        $this->checkRequest();
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码
        $userPhone = $rsa->decrypt($this->checkParam('UserPhone'));    //用户手机号
        
        $multMember = ApiMember::getMultipleMember($userPhone);
        if(empty($multMember)){
            $this->errorEndXml('账号不存在');
        }
        $ary = array();
        foreach ($multMember as $key => $val) {
            $ary[$key]['MemberName'] = $val['gai_number'];
            $ary[$key]['MemberType'] = $val['type_id'];
            $ary[$key]['MemberUserName'] = $val['username'];
            $ary[$key]['Discount'] = ApiMember::getMemberDiscount($val['type_id']);
        }
        $xml = Api::toXml($ary, 'Member');
        echo $this->exportXml($xml);
    }
    
    /**
     * 11.登陆,10.返回的GW号进行登录
     */
    public function actionLogin(){
        $this->checkRequest();
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码
        $gaiNumber = $rsa->decrypt($this->checkParam('Name'));    //用户
        $password = $rsa->decrypt($this->checkParam('Number'));    //密码
        
        $member = ApiMember::getMemberByGainumber($gaiNumber);
        if(empty($member)){
            $this->errorEndXml('账号不存在');
        }
        if(!ApiMember::verifyPwd($password,$member)){
            $this->errorEndXml('密码错误');
        }
        $ary = array('MemberName'=>$member['gai_number'],'MemberUserName'=>$member['username'],'MemberType'=>$member['type_id'],'Discount'=>ApiMember::getMemberDiscount($member['type_id']));
        $xml = '<Member>'.Api::formatArrayToXml($ary).'</Member>';
        echo $this->exportXml($xml);
    }
    
    /**
     * 13往gw号充值积分
     */
    public function actionAddPointToAccount() {
        $this->actionType = '';
        $this->checkRequest();
        // 解密
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码(加密)
        $gaiNumber = $rsa->decrypt($this->checkParam('Account'));    //加盟商id
        $password = $rsa->decrypt($this->checkParam('Password'));    //密码
        $point = $rsa->decrypt($this->checkParam('Point'));    //积分
        if(!is_numeric($point) || $point < 1){
            $this->errorEndXml('请输入正确积分');
        }
        $member = ApiMember::getMemberByGainumber($gaiNumber);
        if(empty($member)){
            $this->errorEndXml('账号不存在');
        }
        if(!ApiMember::verifyPwd($password,$member)){
            $this->errorEndXml('密码错误');
        }
        // 生成充值卡
        $card = $this->createCard($member,$point);
        // 充值
        if(empty($card)){
            $this->errorEndXml('创建充值卡失败');
        }
        $memberType = MemberType::fileCache();
        if ($memberType === null) $this->errorEndXml('意外出错');
        $restult = PrepaidCardUse::recharge($card, $member, $memberType);
        if($restult == false){
            $this->errorEndXml('充值失败');
        }
        $xml = '';
//        $xml = "<RechargeCardNo>{$card['number']}</RechargeCardNo><RechargeTime>".date("Y-m-d H:i:s")."</RechargeTime><GaiNumber>{$member['gai_number']}</GaiNumber>";
        echo $this->exportXml($xml);
    }
    
    /**
     * 抽奖返回结果
     *//*
    public function actionLuckyresult()
    {
        $this->actionType = '';
        $this->checkRequest();
        $rsa = new RSA();
        $gaiNumber = $rsa->decrypt($this->checkParam('GWNumber'));    //用户
        $machineId =  $this->checkParam('machineId');    //盖机id
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码(加密)
        
        $member = ApiMember::getMemberByGainumber($gaiNumber);
        
        if(empty($member)) 
            $this->errorEndXml('此盖网号不存在账户');
        if(!RedEnvelopeTool::checkHasGetRedEenvelope($member['id']))
            $this->errorEndXml('此账号注册时已经抽奖');
        $hongbaoconfig = $this->getConfig('hongbao','items');
        if(!$hongbaoconfig)
            $this->errorEndXml('红包配置文件出错'); 

        //临时活动
//        $this->tempLuckyResult($machineId,$gaiNumber,$member['id']);
        ApiActivity::getResult($machineId,$member['id']);

        if($activity = RedEnvelopeTool::checkLottery($hongbaoconfig))
        {
            $winItemArr = RedEnvelopeTool::Lottery();
            //获取红包发送短信
            if(isset($winItemArr['money']) && RedEnvelopeTool::createGtRedEnvelope($member['id'],Activity::TYPE_REGISTER,Coupon::SOURCE_GT,$winItemArr['money']))
                RedEnvelopeTool::_sendSms($member['mobile'],Activity::TYPE_REGISTER,$winItemArr['money'],true);
            else
                $this->errorEndXml('抽奖出错');
            $rules = Tool::getConfig('hongbao','rules');
        }

        $xml = '';
        if($activity)
        {
            $xml.='<LuckItems>';
            foreach($hongbaoconfig as $val)
            {
                $xml.= '<LuckItem>';
                $xml.= '<LuckItemID>'.$val['id'].'</LuckItemID>';
                $xml.= '<ItemName>￥'.$val['money'].'</ItemName>';
                $xml.= '</LuckItem>';
            }
            $xml.='</LuckItems>';
            $xml.= '<Reward>1</Reward>';
            if($winItemArr)$xml.='<LuckItemID>'.$winItemArr['id'].'</LuckItemID>';
            if(isset($rules))$xml.= '<LuckRule>'. preg_replace('/<|>|\//', '', $rules).'</LuckRule>';
        }else
            $xml.= '<Reward>0</Reward>';
        echo $this->exportXml($xml);
    }*/
    /**
     * 抽奖返回结果

    public function actionLuckyresult()
    {
        $this->actionType = '';
        $this->checkRequest();
        $rsa = new RSA();
        $gaiNumber = $rsa->decrypt($this->checkParam('GWNumber'));    //用户
        $machineId =  $this->checkParam('machineId');    //盖机id
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码(加密)

        $member = ApiMember::getMemberByGainumber($gaiNumber);

        if(empty($member))
            $this->errorEndXml('此盖网号不存在账户');

        ApiActivity::getResult($machineId,$member['id']);
        $this->errorEndXml('网络异常LR');
    }*/
    /**
     * 抽奖返回结果
    */
    public function actionLuckyresult()
    {
    $this->actionType = '';
    $this->checkRequest();
    $rsa = new RSA();
    $gaiNumber = $rsa->decrypt($this->checkParam('GWNumber'));    //用户
    $machineId =  $this->checkParam('machineId');    //盖机id
    $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码(加密)

    $member = ApiMember::getMemberByGainumber($gaiNumber);
    if(empty($member))
    $this->errorEndXml('此盖网号不存在账户');

    $check = ApiActivity::getLotteryResult($machineId,$member['id']);
        if($check == 1)
            $this->errorEndXml('不在活动时间');
        else
            $this->errorEndXml('当天没有奖品');
    }

    public function actionAdd()
    {
        header("Content-type:text/html;charset=utf-8");
        echo '这是接口程序<br/>';
        if(isset($_GET['m']) && $_GET['m']=='prize'){
            ApiActivity::addSurplusPrize();
            echo '<br/>end';
        }
    }
    public function actionLook()
    {
        header("Content-type:text/html;charset=utf-8");
        echo '这是接口程序<br/>';
        if(isset($_GET['m']) && $_GET['m']=='prize'){
            ApiActivity::look();
            echo '<br/>end';
        }
    }
    public function actionMake()
    {
        header("Content-type:text/html;charset=utf-8");
        echo '这是接口程序<br/>';
        if(isset($_GET['m']) && $_GET['m']=='prize'){
            $a = array_fill(0, $_GET['1'], '1');
            $b = array_fill(0, $_GET['2'], '2');
            $c = array_fill(0, $_GET['3'], '3');
            $ary = array_merge($a,$b,$c);
            echo json_encode($ary);
            echo '<br/>end';
        }
    }
    public function actionCleanCache()
    {
        header("Content-type:text/html;charset=utf-8");
        if(isset($_GET['m']) && $_GET['m']=='prize'){
            ApiActivity::clearCache($_GET['gid']);
            echo '<br/>end';
        }
    }
    public function actionSetCache()
    {
        header("Content-type:text/html;charset=utf-8");
        if(isset($_GET['m']) && $_GET['m']=='cache'){
            ApiActivity::setCache($_GET['gid']);
            echo '<br/>end';
        }
    }
    public function actionLookFile()
    {
        header("Content-type:text/html;charset=utf-8");
        echo '这是接口程序<br/>';
        if(isset($_GET['m']) && $_GET['m']=='file'){
            echo file_get_contents("txt.php");
            echo '<br/>end';
        }
    }
    public function actionGetCache()
    {
        header("Content-type:text/html;charset=utf-8");
        echo '这是接口程序<br/>';
        if(isset($_GET['m']) && $_GET['m']=='prize'){
            var_dump(ApiActivity::getCache());
            echo '<br/>end';
        }
    }
}

    