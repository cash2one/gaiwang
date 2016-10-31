<?php

/**
 * api工具类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class Api {

    /**
     * 将数组转化成xml格式的字符串,适用于从数据库查询出来的二维数组
     * @param array  $data 数组
     * @param string $parentNode  父节点名称
     * @return string $xml
     */
    public static function arrayToXml($data, $parentNode) {
        $xml = '';
        foreach ($data as $value) {
            if ($parentNode)
                $xml .= "<$parentNode>";
            foreach ($value as $k => $v) {
//                $v = str_replace(array("&", "\"", "'", "<", ">"), array("&amp;", "&quot;", "&apos;", "&lt;", "&gt;"), $v);
                $v = self::xmlEncode($v);
                $xml .= "<$k>$v</$k>";
            }
            if ($parentNode)
                $xml .= "</$parentNode>";
        }
        return $xml;
    }

    /**
     * 将数组转化成xml格式的字符串,适用于从数据库查询出来的多维数组
     * @param array  $data 数组
     * @param string $node  节点名称
     * @param bool $parent 父节点
     * @return string $xml
     */
    public static function toXml($data, $node = '', $parent = true) {
        $xml = '';
        foreach ($data as $value) {
            $str = self::formatArrayToXml($value);
            if ($node)
                $xml .= "<$node>" . $str . "</$node>";
            else
                $xml .= $str;
        }
        if ($parent && $node)
            $xml = "<{$node}s>" . $xml . "</{$node}s>";
        return $xml;
    }

    public static function formatArrayToXml($data) {
        $xml = '';
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $xml .= "<$k>" . self::formatArrayToXml($v) . "</$k>";
            }
        } else {
            $xml = self::xmlEncode($data);
        }
        return $xml;
    }

    /**
     * 数据转义输出
     * @param string $string
     * @return string
     */
    public static function xmlEncode($string){
        if(!is_numeric($string) && preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $string) && 
                strpos($string, '.jpg') === false && strpos($string, '.png') === false && 
                !ctype_alnum($string)){//数字和英文的组合
            $string = Yii::t('appApi',$string);
        }//根据controller的语言设置,翻译内容
        return str_replace(array("&", "\"", "'", "<", ">"), array("&amp;", "&quot;", "&apos;", "&lt;", "&gt;"), $string);
    }

    /**
     * 返回图片url
     * @param string $path
     * @param string $type
     * @return string
     */
    public static function createImgUrl($path = '', $type = 'att') {
        $base = dirname(Yii::getPathOfAlias('uploads'));
        $url = '';
        $ary = array(
            'att' => 'attachments' . DS . $path,
            'img' => 'uploads' . DS . $path
        );
        if ($path) {
            if ($type == 'att') {
                if (file_exists($base . DS . $ary[$type])) {
                    $url = $ary[$type];
                } elseif (file_exists($base . DS . $ary['img'])) {
                    $url = $ary['img'];
                }
            } else {
                if (file_exists($base . DS . $ary[$type])) {
                    $url = $ary[$type];
                } elseif (file_exists($base . DS . $ary['att'])) {
                    $url = $ary['att'];
                }
            }
        }
        return $url;
    }
    
    /**
     * 验证手机号是否正确
     * @param unknown_type $mobile
     */
    public static function validateMobile($mobile)
    {
//     	$_pattern = "/^13[0-9]{1}[0-9]{8}$|^15[0-9]{1}[0-9]{8}$|^18[0-9]{1}[0-9]{8}$|^14[0-9]{1}[0-9]{8}$|^(852){0,1}[0-9]{8}$/";
		$_pattern = "/^1\d{10}$|^(852){0,1}[0-9]{8}$/";
    	if (!preg_match($_pattern, $mobile))
    	{
    		return false;
    	}
    	else
    	{
    		return true;
    	}
    }
    
    /**
     * 验证用户名是合法和唯一
     */
    public static function validateUsername($userName){
    	$result = Yii::app()->db->createCommand()
    	->select("id")
    	->from(Member::tableName())
    	->where('username = "' .$userName.'"')
    	->queryRow();
    	 
    	if (preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_\(\)（）]+$/u', $userName) && empty($result)){
    		return true;
    	}else {
    		return false;
    	}
    }
    
}
