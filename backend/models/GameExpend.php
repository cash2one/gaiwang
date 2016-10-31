<?php

/**
 * 该掌柜支付方式  模型
 * 
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-08T14:28:27+0800
 */
class GameExpend extends CFormModel
{
    const REVOKE_NO = 0; //撤销失败
    const REVOKE_IS = 1; //撤销成功

    public $member_id;
    public $game_type;
    public $expenditure;
    public $gold_num;
    public $request;
    public $result_code;
    public $create_time;
    public $update_time;

    public function rules() 
    {
        return array(
            array('member_id,expenditure','required'),
            array('member_id','match','pattern'=>'/^GW[0-9]{8}$/','message'=>'请输入正确的GW号！'),
            array('member_id','checkGW'),
            array('expenditure','numerical','integerOnly'=>true),
            array('expenditure','compare','compareValue'=>'0','operator'=>'>','message'=>Yii::t('gameExpend','必须大于0')),
            array('member_id,game_type,expenditure,gold_num,request,result_code,create_time,update_time','safe'),
        );
    }

    public function checkGW(){
        if($this->member_id){
            $rs = Yii::app()->db->createCommand()->select('id')->from('game.gw_game_member')->where('gai_number=:gw',array('gw'=>$this->member_id))->queryScalar();
            if(!$rs){
                $this->addError('member_id', Yii::t('gameExpend','GW游戏账号不存在'));
            }
        }

    }

    public static function getState($key = null){
        $state = array(
            self::REVOKE_NO => Yii::t('gameExpend', '失败'),
            self::REVOKE_IS => Yii::t('gameExpend', '成功'),
        );
        return $key == null ? $state : $state[$key];
    }

    public function attributeLabels() 
    {
        return array(
            'member_id' => 'GW号',
            'expenditure' => '撤销金币数量',
        );
    }

    /**
     * 金币撤销插入数据
     * @param $data
     * @param $table
     */
    public static function insert($data,$table){
        $keys = array_keys($data);
        $tableName = 'game.' . $table;
        $sql = "INSERT INTO $tableName (" . implode(",", $keys) . ") VALUES ('" . implode("','", $data) . "');";
        $rs = Yii::app()->db->createCommand($sql)->execute();
        return Yii::app()->db->lastInsertID;
    }

    /**
     * 撤销金币更新
     * @param string $table 表
     * @param array $data 更新字段
     * @param array $condition 条件字段
     */
    public static function update($table,$data,$condition){
        $str = '';
        $str2 = '';
        foreach($data as $key => $v){
            $str .= $str == '' ? "`".$key."`=".$v : ",`".$key."`=".$v;
        }
        foreach($condition as $key2 => $v2){
            $str2 .= $str2 == '' ? "`".$key2."`=".$v2 : " AND `".$key2."`=".$v2;
        }
        $sql = "UPDATE game.`".$table."` SET ".$str." WHERE ".$str2;
        $rs = Yii::app()->db->createCommand($sql)->execute();
        return $rs;
    }

}