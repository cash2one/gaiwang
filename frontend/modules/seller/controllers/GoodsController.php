<?php

/**
 * 商品控制器(添加,修改,删除,管理)
 * @author zhenjun_xu <412530435@qq.com>
 */
class GoodsController extends SController
{

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'getGaiPrice';
    }
    //登记修改字段的产品信息
    private $_changeGoodsAttr = array(
        'name'=>1,
        'category_id'=>2,
        'stock'=>3,
        'content'=>4,
        'thumbnail'=>5,
        'price'=>7,
        'freight_payment_type'=>8,
        'is_score_exchange'=>9,
    );
    //登记修改产品副属性信息
    private  $_changeGoodsPictureAttr = array('goods_picture_path'=>6);

    //part 1------------------------------------------------------------------------------------------------------------
    /**
     * 商品添加第一步.选择商品分类
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionSelectCategory()
    {
        if ($this->getParam('class_id')) {
            if ($this->getParam('id') > 0) {
                $url = $this->createAbsoluteUrl('/seller/goods/updateBase', array(
                    'cate_id' => $this->getParam('class_id'),
                    'type_id' => $this->getParam('t_id'),
                    'id' => $this->getParam('id'),
                ));
            } else {
                $url = $this->createAbsoluteUrl('/seller/goods/create', array(
                    'cate_id' => $this->getParam('class_id'),
                    'type_id' => $this->getParam('t_id'),
                ));
            }
            $this->redirect($url);
        }
        $categoryStaple = CategoryStaple::model()->findAllByAttributes(array('store_id' => $this->storeId));
        $store = Store::model()->findByPk($this->storeId);
        $this->render('selectCategory', array('categoryStaple' => $categoryStaple,'store'=>$store));
    }

    /**
     * ajax调用分类json数据
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionGetJson()
    {
        if (!$this->isAjax()) die;
        $cid = $this->getParam('cid');
        //参数cid为空时，不返回任何数据
        if(empty($cid)) die;
        exit(Category::getCategory($cid));
    }

    /**
     * ajax 添加 店铺常用分类
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionAddCategoryStaple()
    {
        if (!$this->isAjax()) die;
        $msg = array();
        $cid = $this->getParam('cid');
        $name = $this->getParam('name');
        if (CategoryStaple::model()->countByAttributes(array('store_id' => $this->storeId)) >= 15) {
            $msg['msg'] = Yii::t('sellerGoods', '最多只能添加15条常用分类');
            $msg['done'] = false;
        } else {
            /** @var  Category $cModel */
            $cModel = Category::model()->findByPk($cid);
            $model = CategoryStaple::model()->findByAttributes(array('store_id' => $this->storeId, 'category_id' => $cid));
            if (!$cModel) $msg['msg'] = Yii::t('sellerGoods', '找不到分类数据');
            if (!$model && !isset($msg['msg'])) {
                $model = new CategoryStaple();
                $model->name = $name;
                $model->category_id = $cid;
                $model->type_id = $cModel->type_id;
                $model->store_id = $this->storeId;
                if ($model->save()) {
                    $msg['id'] = $model->id;
                    $msg['category_id'] = $model->category_id;
                    $msg['done'] = true;
                    $msg['msg'] = Yii::t('sellerGoods', '添加常用分类成功');
                } else {
                    $msg['done'] = false;
                    $msg['msg'] = Yii::t('sellerGoods', '添加常用分类失败');
                }
            } else {
                $msg['done'] = false;
                $msg['msg'] = Yii::t('sellerGoods', '此分类已经添加');
            }
        }
        echo CJSON::encode($msg);
    }

    /**
     * ajax 删除店铺常用分类
     * @param $id
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionDelStaple($id)
    {
        if (!$this->isAjax()) die;
        if (CategoryStaple::model()->deleteByPk($id)) {
            $msg['done'] = true;
        } else {
            $msg['done'] = false;
            $msg['msg'] = Yii::t('sellerGoods', '删除常用分类失败');
        }
        echo CJSON::encode($msg);
    }

    /**
     * ajax 选择店铺常用分类
     * @param $cid
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionSelectStaple($cid)
    {
        if (!$this->isAjax()) die;
        /** @var Category $model */
        $model = Category::model()->findByPk($cid);
        $msg = array();
        if ($model) {
            /** @var Category $topCat */
            $topCat = Category::model()->findByPk($model->parent_id);
            $topCatId = $topCat ? $topCat->parent_id : null;
            if ($topCatId) {
                $cArray = array($topCatId, $model->parent_id, $model->id); //有三级
            } else if ($model->parent_id != 0) {
                $cArray = array($model->parent_id, $model->id, null); //两级
            } else {
                $cArray = array($model->id, null, null); //一级
            }
            $msg['one'] = Category::getCategory($cArray[0], false);
            $msg['two'] = Category::getCategory($cArray[1], false);
            $msg['class_one'] = $cArray[0];
            $msg['class_two'] = $cArray[1];
            $msg['class_three'] = $cArray[2];
            $msg['type_id'] = $model->type_id;
            $msg['done'] = true;
        } else {
            $msg['done'] = false;
        }
        exit(CJSON::encode($msg));
    }
    //part 2------------------------------------------------------------------------------------------------------------
    /**
     * 检查商品分类是否被禁用
     * @param $id
     * @author zhenjun_xu <412530435@qq.com>
     */
    private function _checkCategory($id,$goods_id=0)
    {
        //如果分类id不存在.代表没有选择分类,就跳转到选择分类页面
        if (empty($id)) $this->redirect(array('selectCategory'));

        if (!$this->_checkCategoryIsUseable($id)) {
            $this->setFlash('error', Yii::t('sellerGoods', '该商品分类已经被禁用'));
            $redirect_url = $this->createAbsoluteUrl('selectCategory',$goods_id>0?array('id'=>$goods_id):array());
            $this->redirect($redirect_url);
        }

        if (!$this->_checkIsHaveCategory($id)) {
            $this->setFlash('error', Yii::t('sellerGoods', '您的店铺没有经营该类目，无法使用'));
            $this->redirect(array('selectCategory'));
        }

    }

    
	/**
     * 检查商品分类是否被禁用  部分逻辑
     * @param $id
     * @author leo8705
     */
    private function _checkCategoryIsUseable($id)
    {
        $model = Category::model()->findByPk($id);
//        $categoryTree = Tool::categoryBreadcrumb($id);
        //分类深度， 与获取面包屑 不一致，则有父类、或者该分类已经被禁用
        if ($model->status==Category::STATUS_DISABLE) return false;
        
        return true;
    }
    
    
	/**
     * 检查店铺没有经营该类目
     * @param $id
     * @author leo8705
     */
    private function _checkIsHaveCategory($id)
    {
    	$store = Store::model()->find(array(
            'select'=>'id,category_id',
            'condition'=>'id='.$this->getSession('storeId'),
        ));

        $categoryTree = Tool::categoryBreadcrumb($id);
        $topCategory = current($categoryTree);

        if (!empty($store->category_id) && $store->category_id!=$topCategory['id']) {
            return false;
        }else{
        	return true;
        }
    }
    
    
    /**
     * ajax 获取建议品牌名称
     * auto complete
     */
    public function actionSuggestBrands()
    {
        if (isset($_GET['term']) && ($keyword = trim($_GET['term'])) !== '') {
            $brands = Brand::model()->suggestBrands($keyword);
            echo CJSON::encode($brands);
        }
    }

    /**
     * 添加商品
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionCreate()
    {
        $cate_id = $this->getParam('cate_id'); //商品分类id
        $type_id = $this->getParam('type_id'); //分类 类型id
        $this->_checkCategory($cate_id);
        $model = new Goods();
        $model->category_id = $cate_id;
        $this->performAjaxValidation($model);
        if (isset($_POST['Goods'])) {
            /**
             * 商品表组合数据
             */
            $model->attributes = $this->getPost('Goods');
            $model->status = Goods::STATUS_AUDIT;
            $model->content = $_POST['Goods']['content']; //不转义数据
            //重新计算供货价
            $model->gai_price = Common::convertProductGaiPrice($model->price,$model->category_id);
            
            //多货币转换
            if (Yii::app()->language !== 'zh_cn') {
                $model->gai_price = Common::rateConvert($model->gai_price, Common::CURRENCY_RMB);
                $model->price = Common::rateConvert($model->price, Common::CURRENCY_RMB);
            }
            //判断是否参加活动
            if(isset($_POST['Goods']['seckill_seting_id'])){
                $model->seckill_seting_id = $_POST['Goods']['seckill_seting_id'];
            }

            $model->store_id = $this->storeId; //所属商家id
            $model->type_id = $type_id; //所属类型id
            $model->return_score = Common::convertReturn($model->gai_price, $model->price, $model->gai_income / 100); //返还积分
            $spec_val = $this->getPost('spec_val', array()); //已选择的，可自定义的商品规格
            $spec_type = $this->getPost('sp_type', array()); //规格类型，文字or图片
            $model->spec_name = !empty($spec_val) ? $this->getPost('sp_name') : '';
            $model->goods_spec = !empty($spec_val) ? $spec_val : '';
            $att = $this->getPost('attr'); //POST提交过来的属性数据
            if (!empty($att)) {
                $attrData = Attribute::attrValueData($att);
                $model->attribute = $attrData; //所选属性序列化
            }
            $trans = Yii::app()->db->beginTransaction();
            try {
                /**
                 * 批量上传颜色自定义的图片
                 */
                $colImgArr = $this->_uploadSpecPic($model, $spec_val, $spec_type);
                if (!empty($colImgArr)) {
                    $model->spec_picture = $colImgArr; //商品自定义颜色图片序列化
                }
                if (!$model->save()) {
                    throw new Exception('save goods data error');
                }
                /**
                 * 添加商品属性对应表 attribute_index
                 */
                if (isset($attrData)) {
                    $model->addAttributeIndex($att);
                }
                /**
                 * 添加商品规格表 goods_spec
                 */
                $model->goods_spec_id = $model->addSpec($this->getPost('spec', array()));
                if (!empty($model->goods_spec_id)) {
                    $model->save(false); //更新 goods表中的goods_spec_id值
                } else {
                    throw new Exception("update goods_spec_id error");
                }
                /**
                 * 添加商品与规格对应表 goods_spec_index
                 */
                $model->addSpecIndex($spec_val);
                /**
                 * 添加商品图片列表数据保存 goods_picture
                 */
                $imgList = explode('|', $_POST['GoodsPicture']['path']);
                $model->addGoodsPicture($imgList);

                /**
                 * 参加活动
                 * 判断已经参加某一活动
                 */
				$seckill_message   = '';
                if($this->getPost('category_id') > 0  && isset($_POST['Goods']['seckill_seting_id']) && $_POST['Goods']['seckill_seting_id'] > 0){
                    $nowTime = time();
						
					//如果报名时间还没开始 或者 已经截止 或者 活动被强行结束 或者 已达活动结束时间 不做参加活动的记录
					$rulesSetting = Yii::app()->db->createCommand()->select('m.date_start,m.date_end,m.singup_start_time,m.singup_end_time,rs.status,rs.start_time,rs.end_time,rs.seller,rs.id')
									  ->from('{{seckill_rules_main}} AS m')
									  ->join('{{seckill_rules_seting}} AS rs', 'm.id = rs.rules_id')
									  ->where('rs.id=:id', array(':id'=>$_POST['Goods']['seckill_seting_id']))
									  ->queryRow();
                                        //参与数
                                        $count = SeckillProductRelation::model()->count(array(
                                                    'condition'=>'rules_seting_id = :rid AND seller_id=:sid AND status!=:status',
                                                     'params' => array(':rid'=>$_POST['Goods']['seckill_seting_id'],':sid'=> $model->store_id,':status'=> SeckillProductRelation::STATUS_NOPASS)
                                                 ));
					if(empty($rulesSetting) || strtotime($rulesSetting['singup_start_time']) > $nowTime || strtotime($rulesSetting['singup_end_time']) < $nowTime 
						|| $rulesSetting['status'] == 4 || strtotime($rulesSetting['date_end'].' '.$rulesSetting['end_time']) < $nowTime || $count >= $rulesSetting['seller']){
						
						$model->seckill_seting_id = 0;
						$seckill_message = '参与活动失败!'; 
					}else{//满足条件才参与活动
					
					    $ActiveModel = new SeckillProductRelation();
						$store = Yii::app()->db->createCommand("select name from {{store}} where id={$model->store_id}")->limit("0,1")->queryRow();
						$ActiveModel->category_id = $this->getPost('category_id');
						$ActiveModel->rules_seting_id = $model->seckill_seting_id;
						$ActiveModel->product_id = $model->id;
						$ActiveModel->product_name = $model->name;
						$ActiveModel->seller_id = $model->store_id;
						$ActiveModel->product_category = $this->getPost('product_category');
						$ActiveModel->seller_name = $store['name'];
						$ActiveModel->status = 0;
						$ActiveModel->save();
						//SeckillProductRelation::delCache($model->id,$model->seckill_seting_id);
					}    
                }

                $trans->commit();
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeInsert, 0, '添加商品');
                $this->redirect(array('proStepThree', 'cate_id' => $cate_id, 'type_id' => $type_id, 'goods_id' => $model->id));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('sellerGoods', '添加商品失败:') . $e->getMessage());
            }
        }
        $typeSpec = TypeSpec::type_spec($type_id); //类型与规格关联数据
        $imgModel = new GoodsPicture; //商品多图片模型

        $CategoryList = SeckillCategory::getAllCategory($cate_id);

        $attribute = Attribute::model()->findAllByAttributes(array('type_id' => $type_id), array('order' => 'sort DESC'));
        $this->render('create', array(
            'model' => $model,
            'typeSpec' => $typeSpec,
            'imgModel' => $imgModel,
            'attribute' => $attribute,
            'CategoryList'  => !$CategoryList ? array() : $CategoryList,
        ));
    }

    /**
     * 商品自定义规格图片上传
     * @param Goods $model
     * @param array $spec_val
     * @param array $spec_type
     * @return array
     * @throws exception
     * @author zhenjun_xu <412530435@qq.com>
     */
    private function _uploadSpecPic($model, $spec_val, $spec_type)
    {
        $colImgArr = array();
        foreach ($spec_val as $k => $v) {
            if (isset($spec_type[$k]) && $spec_type[$k] == Spec::TYPE_IMG && !empty($_FILES)) {
                foreach ($v as $k2 => $v2) {
                    if (isset($_FILES[$v2]) && $_FILES[$v2]['error'] == 0) {
                        $saveDir = 'files/' . date('Y/n/j');
                        $model = UploadedFile::uploadFile($model, 'spec_picture', $saveDir, Yii::getPathOfAlias('uploads'), null, $v2); // 上传图片
                        if (!$model->validate(array('spec_picture'))) { //检查图片上传
                            throw new Exception(Yii::t('sellerGoods', '上传商品自定义规格图片出错'));
                            break;
                        } else {
                            UploadedFile::saveFile('spec_picture', $model->spec_picture); // 保存文件
                            CUploadedFile::reset();
                        }
                        $colImgArr[$k2] = $model->spec_picture;
                    }
                }
            }
        }
        return $colImgArr;
    }

    /**
     * 商品发布成功后显示的视图
     */
    public function actionProStepThree()
    {
        $this->render('productStepThree');
    }

    /**
     * 基本信息编辑
     * @param int $id 商品id
     * @author zhenjun_xu <412530435@qq.com>
     */
    public function actionUpdateBase($id)
    {
        /** @var $model Goods */
        $model = $this->loadModel($id);
        $this->checkAccess($model->store_id); //检查权限
        $this->performAjaxValidation($model);
        //分类选择的改变
        $cate_id = isset($_GET['cate_id']) ? $this->getParam('cate_id') : $model->category_id;
        $type_id = isset($_GET['type_id']) ? $this->getParam('type_id') : $model->type_id;

        $model->category_id = $cate_id;
        // Tool::p($data);exit;
        $model->type_id = $type_id;
        
        if (!$this->_checkCategoryIsUseable($model->category_id)){
        	$this->setFlash('error', Yii::t('sellerGoods', '该商品分类已经被禁用，请重新选择！'));
        }
        
    	if (!$this->_checkIsHaveCategory($model->category_id)){
        	$this->setFlash('error', Yii::t('sellerGoods', '您的店铺没有经营该类目，请重新选择！'));
        }

        if (isset($_POST['Goods'])) {
            // Tool::p($_POST['Goods']);exit;
            $oldThumbnail = $model->thumbnail;
            $oldName = $model->name;
            $oldAttributes = $model->attributes;
            
            $model->attributes = Tool::filterPost($this->getPost('Goods'), 'status', true);
            $model->content = $_POST['Goods']['content']; //不转义数据
			$model->labels = $_POST['Goods']['labels'];
            $spec_val = $this->getPost('spec_val', array()); //已选择的，可自定义的商品规格
            $spec_type = $this->getPost('sp_type', array()); //规格类型，文字or图片
            $specData = $this->getPost('spec', array()); //库存配置数据
            $model->spec_name = !empty($specData) ? $this->getPost('sp_name') : '';
            $model->goods_spec = !empty($specData) ? $spec_val : '';
            $att = $this->getPost('attr'); //POST提交过来的属性数据
            
            $this->_checkCategory($model->category_id,$id);
            
            if (!empty($att)) {
                $attrData = Attribute::attrValueData($att);
                $model->attribute = $attrData; //所选属性序列化
            }
            //如果商品是审核不通过，修改任意信息都要改成审核中 的状态,创建时间修改为 time()
            if($model->status==Goods::STATUS_NOPASS){
                $model->status = Goods::STATUS_AUDIT;
                $model->create_time = time();
            }
            //审核通过的商品修改标题，将会重新神审核
            if($model->status==Goods::STATUS_PASS && $model->name!=$oldName){
                $model->status = Goods::STATUS_AUDIT;
                $model->create_time = time();
            }
            $newAttributes = $model->attributes;
            
            //保存基本修改信息
            $change = $this->_changeAttributes($oldAttributes, $newAttributes, $model->change_field);
            if($model->pic != $_POST['GoodsPicture']['path']) $change['goods_picture_path'] = 6;
            if(isset($_GET['cate_id'])) $change['category_id'] = 2;
            if(!empty($change)) $model->change_field = serialize($change);
            $trans = Yii::app()->db->beginTransaction();
            try {
                /**
                 * 批量上传颜色自定义的图片
                 */
                $oldColImgArr = $model->spec_picture; //旧的
                $colImgArr = $this->_uploadSpecPic($model, $spec_val, $spec_type);
                $deleteImg = array(); //需要删除的旧图片
                if (!empty($oldColImgArr) && !empty($spec_val)) {
                    //新旧合并
                    foreach ($oldColImgArr as $k => $v) {
                        if (!isset($colImgArr[$k])) {
                            $colImgArr[$k] = $v;
                        } else {
                            $deleteImg[] = $v;
                        }
                    }
                }

                if (!empty($colImgArr)) {
                    $model->spec_picture = $colImgArr; //商品自定义颜色图片序列化
                } else {
                    $model->spec_picture = '';
                }

                // 清除缓存

                if($model->seckill_seting_id > 0){
                    Tool::cache(ActivityData::CACHE_SECKILL_NAME)->delete($model->id);
                    ActivityData:: cleanCache($model->seckill_seting_id,$model->id);
                }

                if (!$model->save()) {
                    throw new Exception('save goods data error');
                }

                /**
                 * 修改商品属性对应表 attribute_index
                 */
                AttributeIndex::model()->deleteAllByAttributes(array('goods_id' => $id));
                if (isset($attrData)) {
                    $model->addAttributeIndex($att);
                }
                /**
                 * 修改商品规格表 goods_spec
                 */
                GoodsSpec::model()->deleteAllByAttributes(array('goods_id' => $id));
                $model->goods_spec_id = $model->addSpec($specData);
                if (!empty($model->goods_spec_id)) {
                    $model->save(false); //更新 goods表中的goods_spec_id值
                } else {
                    throw new Exception("update goods_spec_id error");
                }

                /**
                 * 修改商品与规格对应表 goods_spec_index
                 */
                GoodsSpecIndex::model()->deleteAllByAttributes(array('goods_id' => $id));
                if (!empty($spec_val) && !empty($specData)) {
                    $model->addSpecIndex($spec_val);
                }
                /**
                 * 修改商品图片列表数据保存 goods_picture
                 */
                $imgList = explode('|', $_POST['GoodsPicture']['path']);
                if ($model->pic != $_POST['GoodsPicture']['path']) {
                    GoodsPicture::model()->deleteAllByAttributes(array('goods_id' => $id)); //删除旧的图片
                    $model->addGoodsPicture($imgList);
                    $oldPicArr = explode('|', $model->pic);
                    //旧的图片
                    foreach ($oldPicArr as $v) {
                        if (!in_array($v, $imgList)) {
                            $deleteImg[] = $v;
                        }
                    }
                }
                //旧的封面图片
                if ($oldThumbnail != $model->thumbnail) {
                    $deleteImg[] = $oldThumbnail;
                }
                //删除旧的图片
                if (!empty($deleteImg)) {
                    foreach ($deleteImg as $v) {
                        @UploadedFile::delete(Yii::getPathOfAlias('uploads') . '/' . $v);
                    }
                }

                $trans->commit();
                $this->_clearCache();
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $model->id, '更新商品基本信息');
                $this->setFlash('success', Yii::t('sellerGoods', '保存商品成功！'));
                //生成静态产品详情页
                $file = 'JF/'.$model->id;
                Tool::deleteWebwww($file);
                /*本地和206测试环境用
                $dir = Yii::getPathOfAlias('application');
                $file = $dir.'/www/JF/'.$model->id.'/index.html';
                $fileTw = $dir.'/www/JF/'.$model->id.'/tw.html';
                $fileEn = $dir.'/www/JF/'.$model->id.'/en.html';
                @unlink($file);
                @unlink($fileTw);
                @unlink($fileEn);
                $urlArray = parse_url(DOMAIN);
                $host = $urlArray['host'];
                $http = new HttpClient($host);
                $url = DOMAIN .'/JF/'.$model->id.'.html';
                $http->quickGet($url);
                */
		
                $this->redirect(array('index'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('sellerGoods', '修改商品') . $model->name . Yii::t('sellerGoods', '失败'));
//                Tool::pr($model->getErrors());
            }
        }

        $imgModel = new GoodsPicture;
        $imgModel->path = $model->pic;
        $attribute = Attribute::model()->findAllByAttributes(array('type_id' => $type_id), array('order' => 'sort DESC'));
        $typeSpec = TypeSpec::type_spec($type_id); //类型与规格关联数据
        //获取商品规格相关数据,如果有修改了分类选择，则不获取
        $goodsSpec = $this->getParam('cate_id') ? array() : GoodsSpec::getGoodsSpec($model->id);
        $spec = TypeSpec::specValue($typeSpec); //规格值数据,给视图中的循环选择规格用,
        $spec_value_array = isset($goodsSpec['spec_value_array']) ? $goodsSpec['spec_value_array'] : array();
        //如果相关类目的商品规格配置与商品里面的规格数据不一致，则说明类目的商品规格配置被删改过了，需要重新选择
        if(!empty($goodsSpec) && count($spec)!=count($goodsSpec[0]['spec_value'])){
            $goodsSpec = array();
        }
        $this->_mergeSpec($spec, $spec_value_array, $model->spec_picture);
        if($model->content){
            $model->setAttribute('content',stripslashes($model->content));
        }
        // Tool::p($model);exit;
        $this->render('updateBase', array(
            'model' => $model,
            'imgModel' => $imgModel,
            'attribute' => $attribute,
            'typeSpec' => $typeSpec,
            'goodsSpec' => $goodsSpec,
            'spec' => $spec,
        ));
    }
    /**
     * 得到商户编辑了产品哪些信息
     * @param array $oldattributes 修改前属性
     * @param array $newattributes 修改后属性
     * @param string $change_field 空或者序列化后数据
     * @return array 修改过的属性
     */
    private function _changeAttributes(Array $oldAttributes,Array $newAttributes,$change_field)
    {
        $oldInsersect = array_intersect_key($oldAttributes,$this->_changeGoodsAttr); //正交得到需要等级修改的字段
        $newInsersect = array_intersect_key($newAttributes,$this->_changeGoodsAttr);
        $change = array_intersect_key($this->_changeGoodsAttr,array_diff_assoc($newInsersect, $oldInsersect)); //修改项
        if ($change_field) {
            $oldChange = unserialize($change_field);
            return array_merge($oldChange, $change);
        }
        return $change;
    }


    /**
     * 合并组合spec
     * @param array $spec
     * @param array $specVal
     * @param $specPic
     */
    private function _mergeSpec(Array &$spec, Array $specVal, $specPic)
    {
        foreach ($spec as &$v) {
            foreach ($v['spec_value_data'] as &$v2) {
                if (isset($specVal[$v2['id']])) {
                    $v2['name'] = $specVal[$v2['id']];
                    $v2['checked'] = true;
                } else {
                    $v2['checked'] = false;
                }
                if (isset($specPic[$v2['id']])) {
                    $v2['thumbnail'] = $specPic[$v2['id']];
                }
            }
        }
    }

    /**
     * 修改商品重要信息，将会改变商品的审核状态
     * @param $id
     */
    public function actionUpdateImportant($id)
    {
        /** @var $model Goods */
        $model = $this->loadModel($id);
        $oldPrice = $model->price; //当前未修改时候的商品价格
        $this->checkAccess($model->store_id); //检查权限
        $SeckillCategory = new SeckillCategory();
        $CategoryList = $SeckillCategory::getAllCategory($model->category_id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Goods'])) {
            //重要信息修改项
            $oldAttributes = $model->attributes;
            $model->attributes = Tool::filterPost($this->getPost('Goods'), 'status', true);;
            $newAttributes = $model->attributes;
            
            $change = $this->_changeAttributes($oldAttributes, $newAttributes, $model->change_field);
            if(!empty($change)) $model->change_field = serialize($change);
            //多货币转换
            if (Yii::app()->language !== 'zh_cn') {
                $model->gai_price = Common::rateConvert($model->gai_price, Common::CURRENCY_RMB);
                $model->market_price = Common::rateConvert($model->market_price, Common::CURRENCY_RMB);
                $model->price = Common::rateConvert($model->price, Common::CURRENCY_RMB);
            }

            $model->return_score = Common::convertReturn($model->gai_price, $model->price, $model->gai_income / 100); //返还积分
            $model->publisher = Yii::app()->user->name; //暂时做标记，监测下为何商品有无故下架的操作，别删除了lwy

            //重新计算供货价
            $model->gai_price = Common::convertProductGaiPrice($model->price,$model->category_id);
            //如果没有参加了红包活动，则清除红包相关信息
            if($model->join_activity == Goods::JOIN_ACTIVITY_NO){
                $model -> activity_ratio = 0;
                $model -> activity_tag_id = 0;
                $model -> gai_sell_price = 0;
            }
            if($model->seckill_seting_id > 0){
                ActivityData::cleanCache($model->seckill_seting_id,$model->id);
            }

            $garp = Yii::app()->db->createCommand("select id from {{seckill_grab}} where product_id ={{$model->id}} limit 0,1");
            if($garp){//修改每日必抢
                Yii::app()->db->createCommand()->update("{{seckill_grab}}",array('product_price'=>$_POST['Goods']['price']),'product_id=:product_id',array(':product_id'=>$model->id));
                Tool::cache(ActivityData::CACHE_ACTIVITY_GRAB)->delete(ActivityData::CACHE_ACTIVITY_GRAB);
            }

            /**@author jiawei liao <569114018@qq.com>
             * 修改重要数据时，活动这个模块有以下情况：
             * 1：原本该商品参加了A活动，然后要修改为B活动；
             * 2：原本该商品参加了A活动，然后要修改为不参加商品活动。这是要修改或者删除活动商品关联表(gw_seckill_product_relation)对应的数据；
             * 3：原本没参加活动，然后要修改为参加活动。
             */
            $seckill_seting_id = 0;
			$seckill_message   = '';
            if($_POST['Goods']['seckill_category_id'] > 0 && (isset($_POST['Goods']['seckill_seting_id']) && $_POST['Goods']['seckill_seting_id'] > 0 || isset($_POST['Goods']['active_seting_id']) && $_POST['Goods']['active_seting_id'] > 0 )){

                    $seckill_seting_id = $_POST['Goods']['seckill_category_id'] == 3 ? $_POST['Goods']['seckill_seting_id'] : $_POST['Goods']['active_seting_id'];
                    $nowTime = time();
                    if($seckill_seting_id != $model->seckill_seting_id) {
                        //如果报名时间还没开始 或者 已经截止 或者 活动被强行结束 或者 已达活动结束时间 不做参加活动的记录
						$rulesSetting = Yii::app()->db->createCommand()->select('m.date_start,m.date_end,m.singup_start_time,m.singup_end_time,rs.status,rs.start_time,rs.end_time,rs.allow_singup,rs.seller')
										  ->from('{{seckill_rules_main}} AS m')
										  ->join('{{seckill_rules_seting}} AS rs', 'm.id = rs.rules_id')
										  ->where('rs.id=:id', array(':id'=>$seckill_seting_id))
										  ->queryRow();
						if(empty($rulesSetting) || strtotime($rulesSetting['singup_start_time']) > $nowTime || strtotime($rulesSetting['singup_end_time']) < $nowTime 
						    || $rulesSetting['status'] == 4 || strtotime($rulesSetting['date_end'].' '.$rulesSetting['end_time']) < $nowTime || $rulesSetting['allow_singup']==0){
							
							$seckill_seting_id = $model->seckill_seting_id;
							$seckill_message = '修改活动失败!'; 
						}else{//满足条件才参与活动
                                                    //检查商户报名该活动的商品数是否超出限制数
                                                    //seller为零时，报名商品数不受限制
                                                    $count = SeckillProductRelation::model()->count(
                                                                'seller_id=:seller_id AND rules_seting_id =:seting_id AND status!=:status',
                                                                array(':seller_id'=>$model->store_id,':seting_id'=>$seckill_seting_id,':status'=> SeckillProductRelation::STATUS_NOPASS)
                                                            );
                                                    if($rulesSetting['seller'] == 0 || ($rulesSetting['seller'] > 0 && $count < $rulesSetting['seller'])){
							SeckillProductRelation::saveData(
								array('product_id'=>$model->id,
									'rules_seting_id'=>$seckill_seting_id,
									'category_id'=>$_POST['Goods']['seckill_category_id'],
									'product_category'=>$_POST['Goods']['product_category'],
									'seller_id'=>$model->store_id,
									'store_id'=>$model->store_id,
									'product_name'=>$model->name,
									)
							);
                                                    } else {
                                                        $seckill_seting_id = $model->seckill_seting_id;
                                                        $seckill_message = "该活动每家商家只允许报名{$rulesSetting['seller']}个商品";
                                                    }
						}
                    } else if($seckill_seting_id == $model->seckill_seting_id && 0 != $model->seckill_seting_id) {
                       //  //审核未通的
                        $seting = SeckillRulesSeting::model()->findByPk($seckill_seting_id);
                        if($seting){
                            $count = SeckillProductRelation::model()->count(array(
                               'condition'=>'rules_seting_id = :rid AND seller_id=:sid AND status=:status',
                                'params' => array(':rid'=>$seckill_seting_id,':sid'=> $model->store_id,':status'=> SeckillProductRelation::STATUS_PASS)
                            ));
                            if($seting->seller > $count){ 
                                SeckillProductRelation::model()->updateAll(
                                        array('status'=>SeckillProductRelation::STATUS_AUDIT,'examine_time'=>0),
                                        'product_id=:pid AND rules_seting_id=:sid AND status=:status',
                                        array(':pid'=>$model->id,':sid'=>$model->seckill_seting_id,':status'=>SeckillProductRelation::STATUS_NOPASS)
                                );
                            } else {
                                $this->setFlash('error','该活动申请产品已超额!请选择其他活动');
                            $this->redirect(array('Goods/index'));
                            }
                        } else {
                            $this->setFlash('error','活动不存在');
                            $this->redirect(array('Goods/index'));
                        }
                    }

            }else{  //  商家没有参加任何活动或者是取消参与活动
                SeckillProductRelation::deleteData($model->id,$model->seckill_seting_id);
                $model->seckill_seting_id = 0;
            }
            //参与活动的情况，修改重要信息，统一修改为：审核中
            $model->status = GoodsPrice::getGoodsStatus($model->id,$model->price,$oldPrice,$model->status);
            //如果商品是审核不通过，修改任意信息都要改成审核中 的状态,创建时间修改为 time()
            if($model->status==Goods::STATUS_NOPASS){
                $model->status = Goods::STATUS_AUDIT;
                $model->create_time = time();
            }
            $model->seckill_seting_id = $seckill_seting_id;
            if ($model->save()) {
                //修改Goods_spec中的价格
                GoodsSpec::model()->updateAll(array('price' => $model->price), 'goods_id=:gid', array(':gid' => $model->id));
                $this->_clearCache();
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeUpdate, $id, '更新商品重要信息');
                $this->setFlash('success', Yii::t('sellerGoods', '商品重要信息编辑成功！').$seckill_message);
                //生成静态产品详情页
                $file = 'JF/'.$model->id;
                Tool::deleteWebwww($file);
                /*本地和206环境测试用
                $dir = Yii::getPathOfAlias('application');
                $file = $dir.'/www/JF/'.$model->id.'/index.html';
                $fileTw = $dir.'/www/JF/'.$model->id.'/tw.html';
                $fileEn = $dir.'/www/JF/'.$model->id.'/en.html';
                @unlink($file);
                @unlink($fileTw);
                @unlink($fileEn);
                $urlArray = parse_url(DOMAIN);
                $host = $urlArray['host'];
                $http = new HttpClient($host);
                $url = DOMAIN .'/JF/'.$model->id.'.html';
                $http->quickGet($url);
                */

                $this->redirect(array('index'));
            } else {
                $this->setFlash('error', Yii::t('sellerGoods', '商品重要信息编辑失败！').str_replace("\n",'',CHtml::errorSummary($model)));
            }
        }
        $ActiveData = $Rules = $setingList = $setingData = $CategoryListNew = $Rules_new = $setingTimes = array();
        if($model->seckill_seting_id != 0){
            $ActiveData = SeckillRulesSeting::getOneData($model->seckill_seting_id);
            $Rules = SeckillRulesMainSeller::getAllRules($ActiveData['category_id'],$model->category_id);
            if($ActiveData['category_id'] == 3){

                $Rules[] = array('id'=>$ActiveData['rules_id'],'date_start'=>$ActiveData['date_start'],'date_end'=>$ActiveData['date_end'],'seting_id'=>$ActiveData['id']);

                $setingTimes = SeckillRulesSeting::getSetingTimes($ActiveData['rules_id'],$model->category_id);
                $setingTimes[] = array('id'=>$ActiveData['id'],'start_time'=>$ActiveData['start_time'],'end_time'=>$ActiveData['end_time']);
                $setingList = self::assoc_unique($setingTimes,'id');

            }else{
                $Rules[] = array('id'=>$ActiveData['rules_id'],'name'=>$ActiveData['name'],'seting_id'=>$ActiveData['id']);
            }
            $Rules_new = self::assoc_unique($Rules,'id');
            $CategoryList[] = array('id'=>$ActiveData['category_id'],'name'=>$ActiveData['category_name']);
            $CategoryListNew = self::assoc_unique($CategoryList,'id');
        }else{
            $CategoryListNew = $CategoryList;
        }
        $this->render('updateImportant', array('model' => $model,'CategoryList'  => $CategoryListNew,'SetingList'=>$setingList,
                                                    'ActiveData'=>$ActiveData,'Rules'=>$Rules_new));
    }

    /**
     * 删除数据
     */
    public function actionDelete($id)
    {
        /** @var $model Goods */
        $model = $this->loadModel($id);
        //删除缓存文件
        $file = 'JF/'.$model->id;
        Tool::deleteWebwww($file);
        //如果已经有下单，则只是标记删除
        if (OrderGoods::model()->findByAttributes(array('goods_id' => $id))) {
            $model->life = $model::LIFE_YES;
            $model->is_publish = $model::PUBLISH_NO;
            $model->save();
        } else {
            //删除图片
            $imgArr = array();
            if (!empty($model->thumbnail)) { //缩略图
                $imgArr[] = $model->thumbnail;
            }
            if (!empty($model->pic)) { //图片列表
                $picArr = explode('|', $model->pic);
                foreach ($picArr as $v) {
                    $imgArr[] = 'files' . $v;
                }
            }
            //编辑器中的图片
            $contentImg = array();
            $pattern = '/<img.*?src="(.*?)(?=")/i';
            preg_match_all($pattern, $model->content, $contentImg);
            if (isset($contentImg[1])) {
                foreach ($contentImg[1] as $v) {
                    $imgArr[] = str_replace(IMG_DOMAIN . '/', '', $v);
                }
            }
            //颜色属性图片
            if (!empty($model->spec_picture)) {
                foreach ($model->spec_picture as $k => $v) {
                    if (is_numeric($k))
                        $imgArr[] = $v;
                }
            }
            foreach ($imgArr as $v) {
                UploadedFile::delete(Yii::getPathOfAlias('uploads') . '/' . $v);
            }
            if ($model->delete()) {
                GoodsPicture::model()->deleteAllByAttributes(array('goods_id' => $id)); //图片列表数据库
                GoodsSpecIndex::model()->deleteAllByAttributes(array('goods_id' => $id)); //产品与规格关联对应索引表
                GoodsSpec::model()->deleteAllByAttributes(array('goods_id' => $id)); //商品规格模型
                AttributeIndex::model()->deleteAllByAttributes(array('goods_id' => $id)); //商品属性关联索引
            }
        }
        // 清除缓存
        if($model->seckill_seting_id > 0){
			Yii::app()->db->createCommand()->delete('{{seckill_product_relation}}', "product_id=:id", array(':id'=>$id));
            ActivityData:: cleanCache($model->seckill_seting_id,$model->id);
        }
        $this->_clearCache();
        //添加操作日志
        @$this->_saveSellerLog(SellerLog::CAT_COMPANY, SellerLog::logTypeDel, $id, '删除商品');
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 商品列表
     */
    public function actionIndex()
    {
        $model = new Goods('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Goods']))
            $model->attributes = $this->getQuery('Goods');

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        /** @var Goods $model */
        $model = Goods::model()->findByPk($id);
        $this->checkAccess($model->store_id); //检查权限
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->pic = array();
        foreach ($model->goodsPicture as $p) {
            $model->pic[] = $p->path;
        }
        $model->pic = implode('|', $model->pic);
        return $model;
    }

    /**
     * 检查 商品属性 的下拉选择 ，在视图中调用
     * @param Array $attribute $model->attribute
     * @param $id
     * @param $name
     * @return bool
     */
    public function checkAttribute($attribute, $id, $name)
    {
        if (!empty($attribute)) {
            $attribute = is_array($attribute) ? $attribute : unserialize($attribute);
            foreach ($attribute[$id] as $v) {
                if ($v == $name)
                    return true;
            }
        }
        return false;
    }


    /**
     * 更新缓存
     */
    private function _clearCache()
    {
        Tool::cache('common')->delete('indexFloorGoods');
        Tool::cache('common')->delete('indexRecommendGoods');
    }

	/**
     * AJAX 获取供货价
     * 
     * 传入$price,$cat_id
     * 
     */
    public function actionGetGaiPrice($price,$cat_id) {
        $gai_price = Common::convertProductGaiPrice($price, $cat_id);
        $return = array('status' => 'success', 'gai_price' => $gai_price);
        echo json_encode($return);
    }

    /**
     * 红包活动协议
     */
    public function actionShowProtocol(){
        echo '同意参加盖象商城的活动并遵守活动的相关规则';
    }
    
    
    
    /**
     * 商品列表  ajax调用
     */
    public function actionAjaxList()
    {
    	$model = new GoodsSpec('search');
    	$model->unsetAttributes(); // clear any default values
    	if (isset($_GET['GoodsSpec']))
    		$model->attributes = $this->getQuery('GoodsSpec');
    
    	$this->layout = 'dialog';
    	
    	$this->render('ajaxList', array(
    			'model' => $model,
    	));
    }


    /**
     * 查看历史价格
     * @param $goods_id
     */
    public function actionGoodsPrice($goods_id){
        $data = GoodsPrice::model()->findAllByAttributes(array('goods_id'=>$goods_id));
        $this->renderPartial('goodsPrice',array('data'=>$data));
    }
    
    /**
     * 检测当前商品是否参加了拍卖活动
     */
    public function actionCheckProduct() {
        if($this->isAjax()) {
            $now = date("Y-m-d H:i:s");
            $id = $this->getPost('id');
            $cateId = $this->getPost('cateId');
            
            if($cateId > 0) {
                $sql1 = "SELECT srm.category_id ,srs.is_force,concat(srm.date_end,' ',srs.end_time) end_time,concat(srm.date_start,' ',srs.start_time) start_time
                        FROM {{seckill_auction}} g
                    LEFT JOIN {{seckill_rules_seting}} srs ON g.rules_setting_id = srs.id
                    LEFT JOIN {{seckill_rules_main}} srm ON srm.id = srs.rules_id
                        WHERE g.goods_id = '".$id."' order by g.id DESC limit 1";

                $other_active = Yii::app()->db->createCommand($sql1)->queryRow();
                if(!empty($other_active)) {
                    if($other_active['category_id'] ==4) {
                        if($other_active['is_force'] == 1){
                            echo json_encode(array('status'=>0));
                        } elseif(($other_active['end_time'] >= $now && $other_active['start_time'] <= $now) || $other_active['start_time'] >= $now){ //商品是否正在进行拍卖活动
                            echo json_encode(array('status'=>1,'message'=>'当前该商品正在参加拍卖活动，请先取消拍卖活动，才能参与本活动'));
                        } else {
                            echo json_encode(array('status'=>0));
                        }
                    } else {
                        echo json_encode(array('status'=>0));
                    }
                } else {
                    echo json_encode(array('status'=>0));
                }
            } else {
                echo json_encode(array('status'=>0));
            }
        }
    }

    /**
     * 根据AJAX提交的category_id进行获取数据
     */
    public function actionGetSeckillRulesList(){
        if($this->isAjax()){
            $Category_id = $this->getPost('category_id');
            $cate_id = $this->getPost('cate_id');
            $result = SeckillRulesMainSeller::getAllRules($Category_id,$cate_id);
            if(!empty($result)){
                echo json_encode(array('status'=>1,'data'=>$result));
            }else{
                echo json_encode(array('status'=>0, 'data'=>array()));
            }
        }
        exit;
    }

    /**
     * 获取秒杀活动规定时间的相关信息
     */
    public function actionGetSeckillSeting(){
        if($this->isAjax()){
            $id = $this->getPost('id');
            $cate_id = $this->getPost('cate_id');
            $result = SeckillRulesSeting::getSetingTimes($id,$cate_id);
            if(!empty($result)){
                echo json_encode(array('status'=>1,'data'=>$result));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }

    /**
     * 获取指定的秒杀活动规则数据
     */
    public function actionGetOneSeckllInfo(){
        $id = $this->getPost('id');
        $result = SeckillRulesMainSeller::getOneForSeckill($id);
        if(!empty($result)){
            $result['description'] = preg_replace("/\n/", '<br/>',$result['description']);
            $count = SeckillProductRelation::model()->count(
                        'seller_id=:sid AND status!=:status AND rules_seting_id=:rid', 
                        array(':sid'=>$this->storeId,':status'=>  SeckillProductRelation::STATUS_NOPASS,':rid'=>$id)
                    );
            $result['count'] = $count;
            echo json_encode(array('status'=>1,'data'=>$result));
        }else{
            echo json_encode(array('status'=>0,'data'=>array()));
        }
    }

    
    /**
     * 获取常规活动的规则信息
     */
    public function actionGetOneRulesInfo(){
        if($this->isAjax()){
            $id = $this->getPost('id');
                $result = SeckillRulesMainSeller::getOne($id);
            if(!empty($result)){
                echo json_encode(array('status'=>1,'data'=>$result));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }

    /**
     * 统计已确定上传的商品名额
     */
    public function actionCountContrasts(){
        if($this->isAjax()){

            $sql = "select limit_num from {{seckill_rules_seting}} where id={$_POST['id']} limit 0,1";
            $total = Yii::app()->db->createCommand($sql)->queryRow();
            $count = SeckillProductRelation::getCount($_POST['id']);
            $Contrast = floor($count / $total['limit_num'] * 100);
            if($Contrast >= 30){
                echo 1;
                die;
            }else{
                echo 0;
                die;
            }
        }
    }

    /**
     * 数组去重
     * @param $arr
     * @param $key
     * @return mixed
     */
    function assoc_unique($arr, $key){
        $tmp_arr = array();
        foreach($arr as $k => $v){
            if(in_array($v[$key], $tmp_arr)){
                unset($arr[$k]);
            }else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }

    /**
     * 商品审核记录
     * @param $goods_id
     * @throws CHttpException
     */
    public function  actionAudit($goods_id){
        $this->layout = false;
        $goods = $this->loadModel($goods_id);
        $audits = GoodsAudit::getGoodsAudit($goods_id);
        $this->render('audit',array('goods'=>$goods,'audits'=>$audits));
    }
}
