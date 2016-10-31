<?php

/**
 * 加盟商模型
 * @author jianlin_lin <hayeslam@163.com>
 *
 * @property string $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property string $password
 * @property string $salt
 * @property string $alias_name
 * @property integer $categoryId
 * @property string $logo
 * @property string $logo2
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $street
 * @property string $description
 * @property string $qq
 * @property string $url
 * @property string $lng
 * @property string $lat
 * @property string $fax
 * @property string $zip_code
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $mobile
 * @property string $member_id
 * @property integer $max_machine
 * @property string $main_course
 * @property string $summary
 * @property string $notice
 * @property string $keywords
 * @property string $parent_id
 * @property string $thumbnail
 * @property string $background
 * @property string $banner
 * @property string $code
 * @property string $country_id
 * @property integer $status
 * @property int $create_ip
 * @property int $update_ip
 * @property string $author_id
 * @property string $author_name
 */
class Franchisee extends CActiveRecord {

    const STATUS_DISABLED = 1;
    const STATUS_ENABLE = 0;
    const CACHEDIR = 'franchisee';
    //是否推荐人
    const IS_RECOMMEND = 1;
    const NO_RECOMMEND = 0;
    
    //是否自动对账  1自动对账  0不是自动对账
    const  IS_AUTO_CHECK =1;
    const  NO_AUTO_CHECK =0;
    

    public $parentName, $memberName, $update_ip;
    public $path; //定义加盟商图片
    public $originalPassword, $confirmPassword;
    public $_oldPassword; //修改密码用
    public $isExport; //是否导出excel
    public $exportPageName = 'page'; //导出excel时的分页参数名
    public $exportLimit = 5000; //导出excel长度
    public $sum_money; //加盟商营业额统计
    public $pm_gai_number;
    public $gai_discount;
    public $member_discount;
    public $categoryId;
    public $startTime;
    public $endTime;
    public $franchisee_category_id;
    public $bussbgclass;//商家分类LOGO

    //获取是否推荐
    public static function getRecommend($key = NULL) {
        $arrayRecommend = array(
            self::IS_RECOMMEND => '是',
            self::NO_RECOMMEND => '否',
        );
        return isset($key) ? $arrayRecommend[$key] : $arrayRecommend;
    }
    
    //获取是否自动对账
    public static function getAutoCheck($key=null) {
        $AutoCheck = array(
            self::IS_AUTO_CHECK => '是',
            self::NO_AUTO_CHECK => '否',
        );
        return $key == null ? $AutoCheck : $AutoCheck[$key];
    }
   
    // 加盟商编码长度
    const FRANCHISEE_CODE_LENGTH = 11;

    public function tableName() {
        return '{{franchisee}}';
    }

    public function rules() {
        return array(
            array('name, alias_name,mobile, province_id, city_id, district_id, street, member_id, main_course, summary,description', 'required', 'on' => 'insert,update'),
            array('name','unique','on'=>'insert,updateImportant'),
            array('main_course, summary,description', 'required', 'on' => 'update'),
            array('name, alias_name, province_id, city_id, district_id, street, member_id', 'required', 'on' => 'updateImportant'),
            array('gai_discount, member_discount, max_machine, status', 'numerical', 'integerOnly' => true),
            array('create_time, update_time, province_id, city_id, district_id, parent_id, country_id', 'length', 'max' => 11),
            array('name, password, salt, alias_name, logo,logo2, street, url, lng, lat, main_course, keywords, thumbnail, background, banner, code', 'length', 'max' => 128),
            array('qq', 'length', 'max' => 256),
            array('path', 'length', 'max' => 1000),
            array('fax', 'length', 'max' => 32),
            array('zip_code', 'length', 'max' => 16),
            array('gai_discount, member_discount', 'numerical', 'max' => 100),
            array('gai_discount', 'compareMDiscount'),
            array('member_discount', 'compareGDiscount'),
            array('name, alias_name, code', 'unique', 'on' => 'insert'),
//            array('name','match','pattern' => '/([\s]+)/', 'not' => true, 'message'=>Yii::t('goods', '商品名不能有空格！')),
            array('password, confirmPassword', 'required', 'on' => 'insert'),
            array('originalPassword, confirmPassword, password', 'required', 'on' => 'modify'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user', '确认密码不正确'), 'on' => 'modify,insert,updateImportant'),
            array('originalPassword', 'checkPassword', 'on' => 'modify'),
            array('url', 'url'),
//            array('mobile', 'comext.validators.isMobile', 'errMsg' => Yii::t('franchisee', '请输入正确的您的手机号码')),
            array('mobile', 'match','pattern' => '/^1\d{10}$|^(0\d{2,3}-?|\(0\d{2,3}\))?[1-9]\d{4,7}(-\d{1,8})?$|^(852){0,1}[0-9]{8}$/', 'message' => Yii::t('franchisee', '请输入正确的您的手机号码或电话号码'),'on' => 'insert,update'),
            array('logo', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => $this->getScenario() == 'update' ? true : true,
                'tooLarge' => Yii::t('franchiseeCategory', '{thumbnail}最大不超过1MB，请重新上传!')),
            array('logo2', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => $this->getScenario() == 'update' ? true : true,
                'tooLarge' => Yii::t('franchiseeCategory', '{thumbnail}最大不超过1MB，请重新上传!')),
            array('thumbnail', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => $this->getScenario() == 'update' ? true : true,
                'tooLarge' => Yii::t('franchiseeCategory', '{thumbnail}最大不超过1MB，请重新上传!')),
            array('notice, thumbnail, background, banner, country_id, status,sum_money, featured_content, tags, franchisee_brand_id, is_recommend,auto_check', 'safe'),
            array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'on' => 'insert'),
            array('id, create_time, update_time, name, password, salt, alias_name, categoryId, logo,logo2, province_id, city_id, district_id, street, description, qq, url, lng, lat, fax, zip_code, gai_discount, member_discount, mobile, member_id, max_machine, main_course, summary, notice, keywords, parent_id, thumbnail, background, banner, code, country_id, status,pm_gai_number, featured_content, tags, franchisee_brand_id, is_recommend', 'safe', 'on' => 'search,searchWithStatistics'),
            array('member_id', 'checkStoreMember'),
            array('name, mobile, code, startTime, endTime, member_id', 'safe', 'on' => 'search')
        );
    }

    /**
     * 添加加盟商时检测是否是企业会员
     * @author lc
     */
    public function checkStoreMember($attribute, $params) {
        $model = Member::model()->findByPk($this->member_id);
        if (!empty($model) && $model->enterprise_id == 0) {
            $this->addError($attribute, Yii::t('franchisee', '该会员不是企业会员') . '!');
        }
    }

    /**
     * 盖网折扣比较会员折扣
     * @author hhb
     */
    public function compareMDiscount($attribute, $params) {
        if ($this->member_discount < $this->gai_discount) {
            $this->addError($attribute, Yii::t('franchisee', '会员折扣不能小于盖网通折扣') . '!');
        }
    }

    /**
     * 盖网折扣比较会员折扣
     * @author hhb
     */
    public function compareGDiscount($attribute, $params) {
        if ($this->gai_discount > $this->member_discount) {
            $this->addError($attribute, Yii::t('franchisee', '盖网通折扣不能大于会员折扣') . '!');
        }
    }

    /**
     * 验证旧密码是否输入正确
     * @param type $attribute
     * @param type $params
     */
    public function checkPassword($attribute, $params) {
        if (!CPasswordHelper::verifyPassword($this->originalPassword, $this->_oldPassword))
            $this->addError($attribute, Yii::t('franchisee', '原始密码不正确'));
    }

    /**
     * 生成唯一编码
     * @return string
     */
    private function generateUniqueCode() {
        $code = str_pad(mt_rand(), self::FRANCHISEE_CODE_LENGTH, '0', STR_PAD_LEFT);
        if ($this->exists('code = :code', array('code' => $code)))
            $this->generateUniqueCode();
        return $code;
    }

    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'province' => array(self::BELONGS_TO, 'Region', 'province_id'),
            'city' => array(self::BELONGS_TO, 'Region', 'city_id'),
            'district' => array(self::BELONGS_TO, 'Region', 'district_id'),
            'abnormalmerchants'=>array(self::HAS_ONE,'AbnormalMerchants','merchants_id'),
        );
    }

    /**
     * 状态
     * @return array
     */
    public static function getStatus($key=null) {
        $status = array(
            self::STATUS_ENABLE => Yii::t('franchisee', '启用'),
            self::STATUS_DISABLED => Yii::t('franchisee', '停用')
        );
        return $key == null ? $status : $status[$key];
    }

    /**
     * 显示状态
     * @param int $key
     * @return string
     */
    public static function showStatus($key) {
        $status = self::getStatus();
        return $status[$key];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('franchisee', '加盟商编号'),
            'create_time' => Yii::t('franchisee', '创建时间'),
            'update_time' => Yii::t('franchisee', '修改时间'),
            'name' => Yii::t('franchisee', '名称'),
            'password' => Yii::t('franchisee', '密码'),
            'salt' => Yii::t('franchisee', '密钥'),
            'alias_name' => Yii::t('franchisee', '别名'),
            'categoryId' => Yii::t('franchisee', '分类'),
            'logo' => Yii::t('franchisee', '商家LOGO'),
            'logo2' => Yii::t('franchisee', '商家LOGO2'),
            'province_id' => Yii::t('franchisee', '省份'),
            'city_id' => Yii::t('franchisee', '城市'),
            'district_id' => Yii::t('franchisee', '区/县'),
            'street' => Yii::t('franchisee', '详细地址'),
            'description' => Yii::t('franchisee', '说明'),
            'qq' => Yii::t('franchisee', 'QQ'),
            'url' => Yii::t('franchisee', '网址'),
            'lng' => Yii::t('franchisee', '经度'),
            'lat' => Yii::t('franchisee', '纬度'),
            'fax' => Yii::t('franchisee', '传真'),
            'zip_code' => Yii::t('franchisee', '邮编'),
            'gai_discount' => Yii::t('franchisee', '盖网通折扣'),
            'member_discount' => Yii::t('franchisee', '会员折扣'),
            'mobile' => Yii::t('franchisee', '手机号码'),
            'member_id' => Yii::t('franchisee', '所属会员'),
            'max_machine' => Yii::t('franchisee', '最大绑定盖机数'),
            'main_course' => Yii::t('franchisee', '主营'),
            'summary' => Yii::t('franchisee', '简介'),
            'notice' => Yii::t('franchisee', '公告'),
            'keywords' => Yii::t('franchisee', '关键词'),
            'parent_id' => Yii::t('franchisee', '父级加盟商'),
            'thumbnail' => Yii::t('franchisee', '代表图'),
            'background' => Yii::t('franchisee', '背景图'),
            'banner' => Yii::t('franchisee', 'BANNER'),
            'code' => Yii::t('franchisee', '编号'),
            'country_id' => Yii::t('franchisee', '国家'),
            'status' => Yii::t('franchisee', '状态'),
            'confirmPassword' => Yii::t('franchisee', '确认密码'),
            'originalPassword' => Yii::t('franchisee', '旧密码'),
            'create_time' => Yii::t('franchisee', '时间'),
            'sum_money' => Yii::t('franchisee', '营业额统计'),
            'featured_content' => Yii::t('franchisee', '精品推荐'),
            'tags' => Yii::t('franchisee', '标签'),
            'franchisee_brand_id' => Yii::t('franchisee', '加盟商品牌'),
            'is_recommend' => Yii::t('franchisee', '推荐'),
            'auto_check' => Yii::t('franchisee', '自动对账')
        );
    }

    /**
     * 后台列表
     * @return \CActiveDataProvider
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.mobile', $this->mobile);
        $criteria->compare('t.is_recommend', $this->is_recommend);
        $criteria->compare('t.code', $this->code);
        $criteria->with = array('member' => array('select' => 'gai_number'));
        $criteria->compare('member.gai_number', $this->member_id);
        $searchDate = Tool::searchDateFormat($this->startTime, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);
        $pagination = array(
            'pageSize' => 20, //分页
        );
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination
        ));
    }
       
    /**
     * 获取加盟商下所选的分类名称
     * @param type $id
     * @return type
     */
    public static function franchiseeCategoryName($id) {
        $data = array();
        $categorys = Yii::app()->db->createCommand()->from('{{franchisee_to_category}}')
                        ->select('franchisee_category_id')
                        ->where('franchisee_id = :fid', array(':fid' => $id))
                        ->queryAll();
        foreach ($categorys as $val) {// 这里键原有的键值替换为分类自身ID
            $data[$val['franchisee_category_id']] = FranchiseeCategory::getFanchiseeCategoryName($val);
        }
        return implode(' ',$data);
        unset($data);
    }

    /**
     * 带有统计的搜索方法
     */
    public function searchWithStatistics() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.name', $this->name, true);
        if (!empty($this->member_id)) {
            $member_table = Member::model()->tableName();
            $sql = "select distinct id from $member_table
			where username like '%" . $this->member_id . "%'
			or real_name like '%" . $this->member_id . "%'
			or gai_number like '%" . $this->member_id . "%'";
            $data = Yii::App()->db->createCommand($sql)->queryColumn();
            $criteria->addInCondition('member_id', $data);
        }

        $criteria->select = 't.*,concat(" ",t.code) as code,concat(" ",t.mobile) as mobile';
        $criteria->compare('t.mobile', $this->mobile, true);
        $criteria->compare('t.code', $this->code, true);
//        $criteria->with = 'member';

        $pagination = array(
            'pageSize' => 20, //分页
        );

        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 前台调用的搜索列表
     */
    public function searchList() {
        $criteria = new CDbCriteria;

        $criteria->compare('member_id', $this->member_id);
        $criteria->compare('mobile', $this->mobile);
        $criteria->compare('code', $this->code);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    /**
     *
     * @return CActiveDataProvider
     */
    public function getParentFranchisee($extends=NULL) {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('mobile', $this->name, true, 'or');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 查找商户信息，联表查下所属会员 编号gai_number
     *
     * @param  string|array|NULL $extends
     * @return CActiveDataProvider
     */
    public function getFranchisee($extends=NULL) {
        $criteria = new CDbCriteria;
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.mobile', $this->name, true, 'or');
        $criteria->with = array('member' => array('select' => 'gai_number'));
        $criteria->compare('member.gai_number',$this->name,true,'or');

        if($extends!=NULL){
            foreach ((array)$extends as $key => $value) {
                $criteria->compare($value,$this->name,true,'or');
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 生成的密码哈希.
     * @param string $password
     * @return string $hash
     */
    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password . $this->salt);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->salt = Tool::generateSalt();
                $this->password = $this->hashPassword($this->password);
                $this->code = $this->generateUniqueCode();
                $this->update_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
                $this->author_id = Yii::app()->user->id;
                $this->author_name = Yii::app()->user->name;
                $this->create_time = time();
            } else {
                if (!empty($this->password)) {
//                	$this->salt = Tool::generateSalt();
                    $this->password = $this->hashPassword($this->password);
                } else {
                    $this->password = $this->find('id = :id', array('id' => $this->id))->password;
                }
                $this->update_time = time();
                $this->update_ip = Tool::ip2int(Yii::app()->request->userHostAddress);
            }

            return true;
        } else
            return false;
    }

    public function afterSave() {
        parent::afterSave();

        //保存缩略图
        $paths = explode('|', $this->path);
        if (!empty($paths) && !empty($this->path)) {
            if (!$this->isNewRecord) {
                //删除旧的缩略图关系    先找出所有图片 然后对比删除不存在的图片
                $all_paths_rs = FranchiseePicture::model()->findAll("franchisee_id={$this->id}");
                $all_paths = array();
                foreach ($all_paths_rs as $path) {
                    $all_paths[] = $path->path;
                }

                foreach ($all_paths as $p) {
                    if (!in_array($p, $paths)) {
                        UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $p);
                    }
                }

                FranchiseePicture::model()->deleteAll("franchisee_id={$this->id}");
            }

            foreach ($paths as $path) {
                $fp = new FranchiseePicture();
                $fp->franchisee_id = $this->id;
                $fp->path = $path;
                $fp->save();
            }
        }
        return true;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();
        $this->_oldPassword = $this->password;

//        $pics = FranchiseePicture::model()->findAll("target_id={$this->id}");
//        $pic_arr = array();
//        foreach ($pics as $val) {
//            $pic_arr[] = $val->path;
//        }
//        $this->path = implode('|', $pic_arr);
    }

    /**
     * 修改盖网通数据库machine表的加盟商名称
     * @author LC
     */
    public static function saveMachineFranchiseeName($franchisee_id, $franchisee_name) {
        $tb = '{{machine}}';
        $data = array(
            'biz_name' => $franchisee_name
        );
        Yii::app()->gt->createCommand()->update($tb, $data, 'biz_info_id=:bid', array(':bid' => $franchisee_id));
    }

    /**
     * 增加了会员的多个账号属性，必须从多个账号取加盟商
     *
     * 做了缓存处理
     * @deprecated 又改成了一个GW
     */
    public static function getAllFranchiseeByMemberId($member_id) {
        $member_id = $member_id * 1;

        //读取缓存
        $cache_id = self::CACHEDIR . '_m_' . $member_id;
        $franchisee = Tool::cache(self::CACHEDIR)->get($cache_id);
        if (!empty($franchisee))
            return $franchisee;

        $members = Member::getAllMembers($member_id, true);
        if (empty($members))
            return false;

        $values = array();
        if (!empty($members)) {
            foreach ($members as $son) {
                $values[] = $son->id;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.member_id', $values);
        $franchisee = Franchisee::model()->findAll($criteria);

        //写入缓存
        Tool::cache(self::CACHEDIR)->set($cache_id, $franchisee, 300);
        return $franchisee;
    }

    /**
     * 查找加盟商分类ID
     * params $id 加盟商ID
     * return array  返回分类ID
     */
    public static function findCategoryId($id) {
        return Yii::app()->db->createCommand()
                        ->select('franchisee_category_id')
                        ->from('{{franchisee_to_category}}')
                        ->where('franchisee_id=:franchisee_id', array(':franchisee_id' => $id))
                        ->queryColumn();
    }

    public static function findFranchiseeByBrand($franchisee_brand_id) {
        $data = self::model()->findAll('franchisee_brand_id=:franchisee_brand_id', array(':franchisee_brand_id' => $franchisee_brand_id));
        $arr = array();
        foreach ($data as $val) {
            $arr[$val->id] = $val->name;
        }
        return $arr;
    }

    /**
     * 获取异常商家的信息
     */
    public function getAbnormal($id){
        $data = self::model()->findByPk($id);
        return $data;
    }
    
    public function searchfranchisee(){
          $criteria = new CDbCriteria;
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.mobile', $this->mobile);
        $criteria->compare('t.is_recommend', $this->is_recommend);
        $criteria->compare('t.code', $this->code);
        $criteria->with = array('member' => array('select' => 'gai_number'));
        $criteria->compare('member.gai_number', $this->member_id);
           $criteria->with=array('abnormalmerchants');
//        $criteria->join='left join {{abnormal_merchants}} as am on t.id=am.merchants_id ';
        $criteria->addCondition('abnormalmerchants.id is null');
        $pagination = array(
            'pageSize' => 20, //分页
        );
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination
        ));
    }
}
