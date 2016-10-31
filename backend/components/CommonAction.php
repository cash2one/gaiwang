<?php

/**
 * 公共动作类
 * @author zhenjun_xu <412530435@qq.com>
 */
class CommonAction extends CAction
{
    /**
     * @var string 需要执行本类的方法名称
     */
    public $method;
    public $params = array();

    public function run()
    {
        if (method_exists($this, $this->method)) {
            $method = $this->method;
            $this->$method();
        } else {
            throw new Exception('can not find the method :' . $this->method);
        }
    }

    /**
     * 异步更新排序
     * @throws Exception
     * @author jianlin.lin
     */
    public function ajaxUpdateSort() {
        $target = Yii::app()->request->getParam('id', null);
        $field = isset($this->params['field']) ? $this->params['field'] : 'sort';
        $sort = Yii::app()->request->getParam($field, null);
        if ($sort === null)
            throw new Exception("\"$field\" undefined.");
        $table = $this->params['table'];
        $db = isset($this->params['db'])?$this->params['db']:'db';
        $array = array($field => (int) $sort);
        $res = Yii::app()->$db->createCommand()->update($table, $array, 'id = :id', array(':id' => $target));
        echo (int) $res;
    }
} 