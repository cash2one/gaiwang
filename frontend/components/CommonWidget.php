<?php

/**
 * 常用挂件
 * @author jianlin.lin <hayeslam@163.com>
 */

/**
 *  使用方法
 *  
 *  view 视图文件名 （属性是必须）
 * 
 *  // 直接赋予 data 属性值方式
 *  $this->widget('application.components.CommonWidget', array(
 *      'view' => 'test',
 *      'data' => array(0 => array('123', '456')),
 *  ));
 * 
 *  // 使用 CDbCriteria 对象属性的方法
 *  $this->widget('application.components.CommonWidget', array(
 *      'view' => 'test',
 *      'modelClass' => 'Category', 这里如果不设置，默认这是当前控制器对应的模型
 *      'criteriaOptions' => array(
 *          'order' => 'create_time DESC',
 *          'limit' => 5,
 *      ),
 *  ));
 * 
 *  // $criteria 是一个 CDbCriteria 对象
 *  $this->widget('application.components.CommonWidget', array(
 *      'view' => 'test',
 *      'criteria' => $criteria
 *  ));
 * 
 *  // 自定义方法方式 给 method 属性指定本类方法名 （参见 getRecentlyBrowse 方法）
 *  $this->widget('application.components.CommonWidget', array(
 *      'view' => 'test',
 *      'method' => 'getHistoryBrowse',
 *  ));
 */
class CommonWidget extends CWidget {

    const METHOD_STR = 'custom';

    // 视图文件
    public $view;
    // 数据存储
    public $data = array();
    // CDbCriteria 属性
    public $criteriaOptions = array(
        'limit' => 10,
    );
    public $htmlOptions = array();
    // 特殊方法
    public $method = 'custom';
    // 存放 CDbCriteria 对象属性
    private $_criteria;
    // 模型类
    private $_modelClass;
    // 缓存时间 s
    public $cacheTime = 3600;
    /**
     * 缓存目录
     */
    const  CACHE_DIR = 'CommonWidgetCash';

    /**
     * 初始化
     * @throws CException
     */
    public function init() {
        if (!isset($this->view))
            throw new CException('未定义视图文件！');
        if (empty($this->data)) {
            if (!is_object($this->_criteria)) {
                $this->_criteria = new CDbCriteria($this->criteriaOptions);
            }
            if (isset($this->_modelClass)) {
                if (!is_object($this->_modelClass))
                    $this->_modelClass = new $this->_modelClass;
            } else {
                $controlName = $this->getController()->getId();
                $this->_modelClass = ucfirst($controlName);
            }
        }
        parent::init();
    }

    /**
     * 获取历史浏览记录 (商品) 
     * @return 
     */
    public function getHistoryBrowse() {
        $request = Yii::app()->request;
        $cookies = $request->cookies['history'];
        if (!empty($cookies)) {
            $this->_criteria->select = 'id, name, thumbnail, price, sales_volume';
            $this->_criteria->condition = 'status = ' . Goods::STATUS_PASS.' AND is_publish = '.Goods::PUBLISH_YES;            
            $this->_criteria->order = 'field(id, "' . addslashes($cookies->value) . '")';
            $this->_criteria->addInCondition('id', explode(',', $cookies->value));
            return Goods::model()->findAll($this->_criteria);
        }
    }

    /**
     * 运行Widget
     */
    public function run() {
        if ($this->method == self::METHOD_STR) {
            $object = $this->_modelClass;
            if (is_object($object)){
                $key = md5(serialize($this->_criteria));
                $this->data = Tool::cache(self::CACHE_DIR)->get($key);
                if(empty($this->data)){
                    $this->data = $object::model()->findAll($this->_criteria);
                    Tool::cache(self::CACHE_DIR)->set($key,$this->data,$this->cacheTime);
                }
            }
        } else {
            if (!method_exists($this, $this->method))
                throw new CException('方法不存在！');
            $exec = '$this->data = $this->' . $this->method . '();';
            eval($exec);
        }
        $this->render($this->view, array('data' => $this->data));
    }

    /**
     * 自定义 CDbCriteria
     * @param object $criteria    CDbCriteria
     * @throws CException
     */
    public function setCriteria($criteria) {
        if (!is_object($criteria))
            throw new CException('参数 $criteria 不是一个对象！');
        if (get_class($criteria) !== 'CDbCriteria')
            throw new CException('参数 ' . get_class($criteria) . ' 不是一个 CDbCriteria 对象！');
        $this->_criteria = $criteria;
        $this->data = array();     // data 属性清空
    }

    /**
     * 设置模型类
     * @param type $className
     * @throws CException
     */
    public function setModelClass($className) {
        if (!class_exists($className))
            throw new CException("{$className}" . '类不存在！');
        $this->_modelClass = $className;
        $this->data = array();     // data 属性清空
    }

}

