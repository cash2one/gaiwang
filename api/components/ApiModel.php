<?php

/**
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class ApiModel {

    public $tableName = null;
    public $primaryKey = null;
    public $insertId = null;

    /**
     * 构建sql
     * @param array $condition 条件
     * @param array $fields 查询项
     * @param string $order 排序
     * @param string $limit 限制
     * @return object
     */
    public function buildQuery($condition=array(),$fields=array('*'), $order='', $limit=''){
        $query = Yii::app()->db->createCommand();
        if($fields){
            $query->select($fields);
        }
        $query->from($this->tableName);
        if($condition){
            foreach ($condition as $key => $value) {
                $conditionKey[] = "$key=:$key";
                $conditionValue[":$key"] = $value;
            }
            $conditionKey = implode(' AND ', $conditionKey);
            $query->where($conditionKey, $conditionValue);
        }
        if($order){
            $query->order($order);
        }
        if($limit){
            $query->limit($limit);
        }
        return $query;
    }

    /**
     * 查询单行记录
     * @param array $condition 条件
     * @param array $fields 查询项
     * @param string $order 排序
     * @param string $limit 限制
     * @return array
     */
    public function find($condition=array(),$fields=array('*'), $order=''){
        $query = $this->buildQuery($condition, $fields, $order);
        return $query->queryRow();
    }
    
    /**
     * 通过主键查询一行数据
     * @param int $primaryKey 主键
     * @param array $fields 查询项
     * @return array
     */
    public function findByPk($primaryKey,$fields=array('*')){
        if($this->primaryKey && $primaryKey){
            $condition = array($this->primaryKey => $primaryKey);
            $query = $this->buildQuery($condition, $fields);
            return $query->queryRow();
        }
    }
    
    /**
     * 查询多行数据
     * @param array $condition 查询条件
     * @param array $fields 查询项
     * @param string $order 排序
     * @param string $limit 限制
     * @return array
     */
    public function findAll($condition=array(),$fields=array('*'), $order='', $limit=''){
        $query = $this->buildQuery($condition, $fields, $order, $limit);
        return $query->queryAll();
    }
    
    /**
     * 查询字段内容
     * @param array $condition 查询条件
     * @param array $fields 查询项
     * @param string $order 排序
     * @return array
     */
    public function findScalar($condition=array(),$fields=array('*'), $order=''){
        $query = $this->buildQuery($condition, $fields, $order);
        return $query->queryScalar();
    }
    
    /**
     * 查询列
     * @param array $condition 查询条件
     * @param array $fields 查询项
     * @param string $order 排序
     * @param string $limit 限制
     * @return array
     */
    public function findColumn($condition=array(),$fields=array('*'), $order='', $limit=''){
        $query = $this->buildQuery($condition, $fields, $order, $limit);
        return $query->queryColumn();
    }
    
    /**
     * 更新
     * @param array $condition 查询条件
     * @param array $data 更新的数据
     * @return bool
     */
    public function update($condition, $data){
        foreach ($condition as $key => $value) {
            $conditionKey[] = "$key=:$key";
            $conditionValue[":$key"] = $value;
        }
        $conditionKey = implode(' AND ', $conditionKey);
        return Yii::app()->db->createCommand()->update($this->tableName, $data, $conditionKey, $conditionValue);
    }
    
    /**
     * 插入数据
     * @param array $columns 数据
     * @return bool|int
     */
    public function insert($columns){
        $status = Yii::app()->db->createCommand()->insert($this->tableName, $columns);
        return $status ? Yii::app()->db->getLastInsertID() : false;
    }
    
}
