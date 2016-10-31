<?php

/**
 * 币种类
 */
class Symbol{
	const RENMINBI = "RMB";				//人民币
	const HONG_KONG_DOLLAR = "HKD";		//港币
	const DOLLAR = "USD";				//美元
	const EN_DOLLAR = "EN";				//英镑		(目前按照人民币显示)
	
    public static function getMoneyTypeStr($key){
    	if (empty($key)) throw new Exception('非法币种');
		$data = array(
			self::RENMINBI => '￥',
			self::HONG_KONG_DOLLAR => 'HK$',
			self::EN_DOLLAR => '￡',		//(目前按照人民币显示)
			self::DOLLAR => '$',
		);
		return $data[$key];
    }
    
    /**
     * 兑换金额
     * @param intval $enteredMoney 输入金额
     * @param string $symbol
     * @param string $language
     * @throws ErrorException
     * @return array()
     */
    public static function exchangeMoney($enteredMoney,$symbol,$language = 'zh_cn')
    {
        // 消费金额转换成人民币
        Yii::app()->language = $language;
        switch ($symbol)
        {
            case self::EN_DOLLAR:
            case self::RENMINBI:
                $symbol = self::RENMINBI;
                $basePrice = 100;
                break;
            case self::HONG_KONG_DOLLAR:
                if($hkRate = Fun::getConfig('rate','hkRate'))
                {
                    $symbol = self::HONG_KONG_DOLLAR;
                    $basePrice = $hkRate;
                    Yii::app()->language = 'zh_tw';
                    break;
                }else
                throw new ErrorException(Yii::t('Symbol', '币种配置错误'));
            default:
                throw new ErrorException(Yii::t('Symbol', '币种错误'));
        }
        // 转换为人民币(100*0.75)
        return array(
                'amount'=>bcmul($enteredMoney, bcdiv($basePrice, 100, 5), 2),//转换金额
                'base_price'=>$basePrice  //转换概率
                );
    }

}
