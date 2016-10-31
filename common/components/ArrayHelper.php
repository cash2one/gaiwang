<?php

/**
 * 数组处理帮助类
 * @author jianlin.lin <hayeslam@163.com>
 */
class ArrayHelper {

    /**
     * 根据数据键名进行分组
     * @param array $data 数据源（一维数组）
     * @param string $key 键名依据
     * @return array 返回结果数组的键值为相应的 “键名依据” 值
     * @author jianlin.lin
     */
    public static function dataGroupByKey($data, $key) {
        $array = array();
        foreach($data as $val) {
            $array[$val[$key]][] = $val;
        }
        return $array;
    }

    /**
     * 将部分数据合并到数据源中
     * @param array $data 数据源
     * @param array $array 部分数据
     * @param string $findKey 查找键名
     * @param string $group 分组标识
     * @return array
     * @author jianlin.lin
     */
    public static function partDataMerge($data, $array, $findKey, $group) {
        foreach($data as $key => $val) {
            if (array_key_exists($val[$findKey], $array) === true) {
                $data[$key][$group] = $array[$val[$findKey]];
            }
        }
        return $data;
    }

    /**
     * 返回数组中指定的一列, $index_key为可选参，当指定$index_key,$colum_key的值将作为新数组键名，$index_keys作为键值，
     * 参见array_column（php5.3不支持此函数）
     * @param  array $input  数据源 二维数组
     * @param  mixed $colum_key   
     * @param  mixed $index_key
     * @return array  一维数组|二维数组
     * @author xuegang.liu@g-email.com
     * @since  2015-06-23
     */
    public static function array_column_Ex( $input, $column_key, $index_key=false){

        $res = array();
        if(!is_array($input)) return false;
        if($index_key && !is_string($column_key)) return false;
        foreach ($input as $key => $value) {
            if(is_array($value)){
                $tmpRes = self::array_column_Ex($value,$column_key,$index_key);
                if($tmpRes===false) return false;
                $res = array_merge($res,$tmpRes);  
            }else if($index_key){
                 if(!in_array($key, (array)$index_key)) continue;
                 if(is_array($index_key)){
                    $res[$input[$column_key]][] = $value; 
                 }else{
                    $res[$input[$column_key]] = $value;
                 }
            }else{
                if(in_array($key, (array)$column_key)) $res[] = $value;  
            }
        }//foreach end 
        return $res;
    }

}
