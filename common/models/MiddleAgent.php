<?php

/**
 *  居间商关系模型
 *
 * The followings are the available columns in table '{{middle_agent}}':
 * @property string $id
 * @property string $parent_id
 * @property string $member_id
 * @property string $store_id
 * @property integer $level
 * @property int $create_time
 *
 * @property Member $member
 * @property Store $store
 * @property MiddleAgent $parent
 */
class MiddleAgent extends CActiveRecord
{

    public $gai_number;
    public $mobile;
    public $count;
    public $state;
    public $username;

    const LEVEL_PARTNER = 0;
    const LEVEL_ONE = 1;
    const LEVEL_TWO = 2;
    const LEVEL_THREE = 3;

    /**
     * 获取居间商级别
     * @param null $k
     * @return array|mixed|null
     */
    public static function getLevel($k = null)
    {
        $a = array(
            self::LEVEL_THREE => '三级',
            self::LEVEL_TWO => '二级',
            self::LEVEL_ONE => '一级',
        );
        if($k==null) return $a;
        $a[self::LEVEL_PARTNER] = '直招商户';
        return isset($a[$k]) ? $a[$k] : null;
    }

    public function tableName()
    {
        return '{{middle_agent}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('member_id, store_id', 'required'),
            array('level', 'numerical', 'integerOnly' => true),
            array('parent_id, member_id, store_id', 'length', 'max' => 10),
            array('id, parent_id, member_id, store_id, level,create_time', 'safe', 'on' => 'search'),
            array('gai_number,create_time,mobile,username,count,state', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'parent'=>array(self::BELONGS_TO,'MiddleAgent','parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('middleAgent', '编号id'),
            'parent_id' => Yii::t('middleAgent', '上级id'),
            'member_id' => Yii::t('middleAgent', '会员id'),
            'store_id' => Yii::t('middleAgent', '店铺id'),
            'level' => Yii::t('middleAgent', '级别（0,1,2,3）'),
            'create_time' => Yii::t('middleAgent', '添加时间'),
            'mobile' => Yii::t('middleAgent', '手机号'),
            'gai_number' => Yii::t('middleAgent', 'gw号'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('m.mobile', $this->mobile);
        $criteria->compare('m.gai_number', $this->gai_number);
//        $criteria->addCondition('t.level !='.self::LEVEL_PARTNER);
        $criteria->select = 't.*,m.gai_number,m.username,m.mobile,(select count(*) from gw_middle_agent as c where c.parent_id=t.id and c.level=0) as count,(select b.id from gw_middle_agent as b where b.parent_id = t.id limit 1) as state';
        $criteria->join = 'left join gw_member as m on m.id=t.member_id';
        $data =  self::model()->findAll($criteria);
        $result = array();
        if($data){
            foreach ($data as $k => $v){
                $result[$k] = $v->attributes;
                //搜索三级时候默认不展示下级
                if($v['level']==self::LEVEL_THREE){
                    $result[$k]['state'] = 'open';
                }else{
                    $result[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
                }
                $result[$k]['gai_number'] = $v['gai_number'];
                $result[$k]['username'] = $v['username'];
                $result[$k]['count'] = $v['count'];
                $result[$k]['mobile'] = $v['mobile'];
            }
        }
//        Tool::pr($result);
        return $result;
    }

    /**
     * @param string $className
     * @return MiddleAgent
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取指定父类ID分类树数据
     * @param int $id 可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @param  int  $level 默认 level > 0
     * @return array
     */
    public function getTreeData($id = null,$level=0)
    {
        $data = array();
        $db = Yii::app()->db;
        $level= $level==0 ? 0 : -1;
        $sql = ' SELECT
                t.*, m.gai_number,
                m.username,
                m.mobile,
                (
                    SELECT  count(*) FROM  gw_middle_agent AS c  WHERE   c.parent_id = t.id   AND c.level = 0
                ) AS count,
                (
                    SELECT   b.id  FROM  gw_middle_agent AS b WHERE   b.parent_id = t.id and b.`level` >0 LIMIT 1
                ) AS state
            FROM
                `gw_middle_agent` `t`
            LEFT JOIN `gw_member` `m` ON m.id = t.member_id
            WHERE
                (t.level > :l)
            AND (t.parent_id = :pid)
            ORDER BY
                `id` DESC';
        //总父类分页
        if ($id == 0) {
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
            $start = ($page-1)*$rows;
            $record = $db->createCommand($sql." limit $start,$rows")->bindValues(array(':pid'=>$id,':l'=>$level))->queryAll();
        }else{
            $record = $db->createCommand($sql)->bindValues(array(':pid'=>$id,':l'=>$level))->queryAll();
        }
        foreach ($record as $k => $v) {
            $data[$k] = $v;
            $data[$k]['state'] = is_null($v['state']) ? 'open' : 'closed';
        }
        return $data;

    }

    public function getById($id){
        return  Yii::app()->db->createCommand('
                SELECT
                    t.*, m.gai_number,
                    m.username,
                    m.mobile,
                    (
                        SELECT
                            count(*)
                        FROM
                            gw_middle_agent AS c
                        WHERE
                            c.parent_id = t.id
                        AND c.`level` = :l
                    ) AS count,
                    CONCAT(\'open\') as state
                FROM
                    `gw_middle_agent` `t`
                LEFT JOIN `gw_member` `m` ON m.id = t.member_id
                WHERE
                t.id = :id
          ')->bindValues(array(':id'=>$id,':l'=>self::LEVEL_PARTNER))->queryRow();
    }
    

    /**
     * 用于卖家前台数据
     * 获取指定父类ID分类树数据
     * @param int $id 可指定父类ID，$id为Null则查询所有分类， "0" :则获取顶级分类
     * @return array
     */
    public $status;
    public $sid;
    public function getSellerTreeData($id,$level=null)
    {  
        $criteria = new CDbCriteria;
        $criteria->select ='t.*, m.gai_number,m.mobile,s.id as sid,s.name as username,s.status';
        $criteria->join ='LEFT JOIN {{member}} AS m ON m.id=t.member_id LEFT JOIN {{store}} AS s ON t.store_id=s.id';
        $criteria->compare('t.parent_id',$id);
        if($level!==null){
            $criteria->addCondition('t.level ='.$level);
        }
       return new CActiveDataProvider($this, array(
                'criteria' =>$criteria,
                'pagination' => array(
                        'pageSize' => 10,
                ),
                'sort' => array(
                        'defaultOrder' => 't.id DESC'
                ),
        ));
    }
    
    /**
     * 用于卖家平台
     * @param int $id 居间商ID
     * @param int $level 商家级别
     */
     public static function getMiddleNum($id,$level=NULL){
         $command = Yii::app()->db->createCommand();
         $command->where('parent_id ='.$id);
         //是否算全部
         if ($level !== null) {
             $command->andWhere('level = :l', array(':l' =>$level));
         }
         
        $res=$command->from('{{middle_agent}}')
            ->select('count(*) AS count')  
            ->queryScalar();
         return $res;
     }

    
    /**
     * 得到居间ID
     * @param int $memId 用户ID
     * @return 居间列表ID
     */
    public static function getMidId($memId){
        $res=Yii::app()->db->createCommand()
        ->select('id,level')
        ->from('{{middle_agent}}')
        ->where('member_id ='.$memId .' AND level > '.MiddleAgent::LEVEL_PARTNER)
        ->queryRow();
        return $res;
    }
     
    /**
     * 根据居间商ID得到卖家的店铺名称
     * @param int $lid 居间商ID
     */
    public static function getStoreNameByLid($lid){
        $res=Yii::app()->db->createCommand()
        ->select('s.name')
        ->from('{{middle_agent}} t')
        ->leftJoin('{{store}} s', 't.store_id=s.id')
        ->where('t.id = :lid',array(':lid'=>$lid))
        ->queryScalar();
        return $res;
    }
    
    
    /**
     * 递归，根据子类获取完整父类,为空则返回自身
     */
    public  function getAllTreeByChild($child){
        $data = array();
        $pTree = $this->getById($child['parent_id']);
        if($pTree){
            $data = $pTree;
            $data['children'][] = $child;
            if($pTree['parent_id']>0){
                return $this->getAllTreeByChild($data);
            }
        }
        if(empty($data)) return $child;
        return $data;
    }
    /**
     * 递归，根据子类获取完整父类
     * @param  int $pid 父类id
     * @param  array $result 保存上一次查询的结果
     * @return array
     */
    public static function findParents($pid,$result=array()){
        $pTree = Yii::app()->db->createCommand('select * from gw_middle_agent WHERE id=:pid')
            ->bindValue(':pid',$pid)->queryRow();;
        if($pTree){
            $result[] = $pTree;
            if($pTree['parent_id']>0){
                return self::findParents($pTree['parent_id'],$result);
            }
        }
        return $result;
    }

    /**
     * 查找居间商，分配使用
     * @param $sid
     * @return array
     */
    public static  function findMiddleAgent($sid){
        //第一个，parent_id 必须大于0
        $data = Yii::app()->db->createCommand('SELECT
                a2.*
            FROM
                gw_middle_agent a1
            LEFT JOIN gw_middle_agent a2 ON a1.parent_id = a2.id
            WHERE
                a1.store_id = :sid
            AND a1.parent_id > 0')
            ->bindValues(array(':sid'=>$sid))->queryRow();
        if($data){
            //剩下的递归查找
            return array_merge(array($data),self::findParents($data['parent_id']));
        }else{
            return array();
        }
    }
}
