<?php

class TController extends Controller
{
    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 获取酒店后台配置的常用参数数据
     * @param string $name 该配置项的键名
     * @param string $key 属性名
     * @return array or string
     */
    public function getConfig($name, $key = null)
    {
        $val = Tool::cache($name)->get($name);
        $array = array();
        if ($val) {
            $array = unserialize($val);
        } else {
            $value = WebConfig::model()->findByAttributes(array('name' => $name));
            if ($value) {
                Tool::cache($name)->add($name, $value->value);
                $array = unserialize($value->value);
            }
        }
        return $key ? (isset($array[$key]) ? $array[$key] : '') : $array;
    }

} 