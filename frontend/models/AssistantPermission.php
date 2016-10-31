<?php

/**
 *  助手、店小二 权限项 模型
 * @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{assistant_permission}}':
 * @property string $item
 * @property string $assistant_id
 * @property string $franchisee_id
 */
class AssistantPermission extends CActiveRecord
{
    public function tableName()
    {
        return '{{assistant_permission}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('item, assistant_id, franchisee_id', 'required'),
            array('item', 'length', 'max' => 128),
            array('assistant_id, franchisee_id', 'length', 'max' => 11),
            array('item, assistant_id, franchisee_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'item' => Yii::t('assistantPermission', '操作项'),
            'assistant_id' => Yii::t('assistantPermission', '所属助手'),
            'franchisee_id' => Yii::t('assistantPermission', '所属加盟商'),
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('item', $this->item, true);
        $criteria->compare('assistant_id', $this->assistant_id, true);
        $criteria->compare('franchisee_id', $this->franchisee_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array( //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取店小二的权限数据，做缓存
     * @param $assistant_id
     * @param bool $cache
     * @return array|mixed|string
     */
    public static function getPermission($assistant_id, $cache = true)
    {
        $permission = '';
        if ($cache) {
            $permission = Tool::cache('assistant')->get($assistant_id);
        }
        if (empty($permission)) {
            $permission = Yii::app()->db->createCommand()->select('*')->from("{{assistant_permission}}")
                ->where('assistant_id=:id', array(':id' => $assistant_id))->queryAll();
            Tool::cache('assistant')->set($assistant_id, $permission, 3600 * 24 * 7);
        }
        return $permission;
    }


    /**
     * 检查店小二权限
     * @param $route
     * @return bool
     */
    public static function checkAssistant($route)
    {
        $route = str_replace('/seller/', '', $route);
        $routeArr = explode('/', $route);
        $assistantId = Yii::app()->user->getState('assistantId');
        if ($assistantId) {
            $permission = self::getPermission($assistantId);
            //所有店小二都可以访问的地址
            $assistantPublicPages = array(
                'home/login',
                'home/logout',
                'home/captcha',
                'home/error',
                'home/index',
                'assistantInfo',
                'assistantManage/defaultShow',
                'goods/getJson',
                'goods/proStepThree',
                'goods/imgRemove',
                'scategory/setStatus',
                'scategory/getTreeGridData',
                'assistantManage/changePw',
                'franchisee/change',
                'franchiseeUpload/index',
                'franchiseeUpload/upload',
                'franchiseeUpload/sure',
                'design/mapSelect',
                'prepaidCard/findGW',
                'prepaidCard/viewRechange',
                'goods/selectStaple',
                'upload/index',
                'upload/upload',
                'upload/sure',
                'ueditor/imageUp',
                'ueditor/fileDelete',
            );
            if (in_array($route, $assistantPublicPages)) return true;
            foreach ($permission as $v) {
                if (count($routeArr) == 2 && $routeArr[0] == 'franchisee') {
                    //加盟商管理权限判断
                    if ($route == $v['item'] && Yii::app()->user->getState('curr_franchisee_id') == $v['franchisee_id']) return true;
                } else {
                    if ($route == $v['item']) return true;
                }
            }
            return false;
        } else {
            return true;
        }
    }
}
