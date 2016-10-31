<?php

/**
 * 商品控制器
 * 操作（列表，编辑）
 * @author wanyun.liu <wanyun_liu@163.com>
 */
//use backend\models\SeckillRulesSeting;

class ProductController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'suggestStores, suggestProducts, suggestBrands, getActivityTagRatio, setRecommend, recommend, unRecommend, approved, pending, unPublished, published,getGaiPrice,goodsPrice,audit,comparePrice';
    }


    /**
     * 更新
     * @param $id
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario='updateBack';
        $oldPrice = $model->price; //未修改前的商品价格
        $type_id = $model->type_id;

        $this->performAjaxValidation($model);
        if (isset($_POST['Goods'])) {
            $oldThumbnail = $model->thumbnail;
            $model->attributes = $this->getPost('Goods');
            $update_time = empty($model->update_time) ? $model->create_time : $model->update_time; //记录提交商品审核的时间
            $fail_cause = $model->fail_cause;   //将审核不通过原因保存起来，再清空goods表中的内容，将原因保存到单独的gw_goods_audit
            $model->fail_cause = '';

            if(isset($_POST['Goods']['content'])){
                $model->content = $_POST['Goods']['content']; //不转义数据
            }
            //重新计算供货价
            $model->gai_price = Common::convertProductGaiPrice($model->price,$model->category_id);
            
            //如果不存在 $_POST['Goods']['content'] 说明只修改基本信息，商品的规格、图片、内容等不会被修改
            if(isset($_POST['Goods']['content'])){
                $spec_val = $this->getPost('spec_val', array()); //已选择的，可自定义的商品规格
                $spec_type = $this->getPost('sp_type', array()); //规格类型，文字or图片
                $specData = $this->getPost('spec',array());      //库存配置数据
                $model->spec_name = !empty($specData) ? $this->getPost('sp_name') : '';
                $model->goods_spec = !empty($specData) ? $spec_val : '';
            }
            $att = $this->getPost('attr'); //POST提交过来的属性数据
            if(!empty($att)){
                $attrData = Attribute::attrValueData($att);
                $model->attribute = $attrData; //所选属性序列化
            }
            //如果参加红包活动，则更新活动支持比率
            if($model->join_activity == Goods::JOIN_ACTIVITY_YES){
                $activityTag = ActivityTag::model()->find(array('select'=>'ratio','condition'=>'id=:id','params'=>array(':id'=>$model->activity_tag_id)));
                if($activityTag)
                    $model->activity_ratio = $activityTag->ratio;
                else {
                    $this->setFlash('error', Yii::t('Product', '选择的红包活动不存在') );
                    $this->refresh();
                }
            }else{
                $model->activity_tag_id = 0;
                $model->join_activity = 0;
                $model->activity_ratio = 0;
            }
            //活动商品,无法限制积分支付比例
            if(isset($_POST['seckill']['status'])){
                if($model->jf_pay_ratio>0 && $_POST['seckill']['status']!=SeckillProductRelation::STATUS_NOPASS){
                    $model->jf_pay_ratio = 0;
                    $this->setFlash('error','活动商品,无法限制积分支付比例');
                }
            }
            $trans = Yii::app()->db->beginTransaction();
            try{
                //审核通过，设置初始价格
                if($model->status==Goods::STATUS_PASS && $model->market_price=='0.00'){
                    $model->market_price = $model->price;
                }
                if($model->status == Goods::STATUS_PASS) $model->change_field = ''; //重置修改项;
                if (!$model->save()) {
                    throw new Exception(CHtml::errorSummary($model));
                }

                if(isset($_POST['Goods']['content'])){
                    /**
                     * 批量上传颜色自定义的图片
                     */
                    if($model->spec_picture) $model->spec_picture = unserialize($model->spec_picture);
                    $oldColImgArr = $model->spec_picture; //旧的
                    $colImgArr = $this->_uploadSpecPic($model,$spec_val,$spec_type);
                    $deleteImg = array(); //需要删除的旧图片
                    if(!empty($oldColImgArr) && !empty($spec_val)){
                        //新旧合并
                        foreach($oldColImgArr as $k=>$v){
                            if(!isset($colImgArr[$k])){
                                $colImgArr[$k] = $v;
                            }else{
                                $deleteImg[] = $v;
                            }
                        }
                    }
                    $model->spec_picture = !empty($colImgArr) ? $colImgArr : '';

                    /**
                     * 修改商品属性对应表 attribute_index
                     */
                    AttributeIndex::model()->deleteAllByAttributes(array('goods_id' => $id));
                    if(isset($attrData)){
                        $model->addAttributeIndex($att);
                    }
                    /**
                     * 修改商品规格表 goods_spec
                     */
                    GoodsSpec::model()->deleteAllByAttributes(array('goods_id'=>$id));
                    $model->goods_spec_id = $model->addSpec($specData);
                    if(!empty($model->goods_spec_id)){
                        $model->save(false);  //更新 goods表中的goods_spec_id值
                    }else{
                        throw new Exception("update goods_spec_id error");
                    }
                    /**
                     * 修改商品与规格对应表 goods_spec_index
                     */
                    GoodsSpecIndex::model()->deleteAllByAttributes(array('goods_id'=>$id));
                    if(!empty($spec_val) && !empty($specData) ){
                        $model->addSpecIndex($spec_val);
                    }
                    /**
                     * 修改商品图片列表数据保存 goods_picture
                     */
                    $imgList = explode('|', $_POST['GoodsPicture']['path']);
                    if($model->pic!=$_POST['GoodsPicture']['path']){
                        GoodsPicture::model()->deleteAllByAttributes(array('goods_id' => $id)); //删除旧的图片
                        $model->addGoodsPicture($imgList);
                        $oldPicArr = explode('|',$model->pic);
                        //旧的图片
                        foreach($oldPicArr as $v){
                            if(!in_array($v,$imgList)){
                                $deleteImg[] = $v;
                            }
                        }
                    }
                    //旧的封面图片
                    if($oldThumbnail!=$model->thumbnail){
                        $deleteImg[] = $oldThumbnail;
                    }
                    //删除旧的图片
                    if(!empty($deleteImg)){
                        foreach($deleteImg as $v){
                            @UploadedFile::delete(Yii::getPathOfAlias('uploads').'/'.$v);
                        }
                    }
                }else{
                    //如果没有修改商品规格，而价格被修改了，更新goods_spec的价格
                    if($model->price!=$oldPrice){
                        GoodsSpec::model()->updateAll(array('price'=>$model->price),'goods_id='.$model->id);
                    }
                }

                //判断是否商品下架
                if($_POST['Goods']['status'] == 2){
                    $one = Yii::app()->db->createCommand("select id from {{seckill_grab}} where product_id ={$model->id} limit 1")->queryRow();
                    if($one) SecKillGrab::model()->del($one['id']);
                }

                //判断是否已经参加活动
                $relation = SeckillProductRelation::getOne($model->id);
                if(isset($_POST['seckill']['status']) && $relation['status'] != $_POST['seckill']['status']){
                    $seckill_status = ($_POST['Goods']['status'] == 2) ? 2 : $_POST['seckill']['status']; //如果商品审核失败就不通过。
                    
                    //判断单个商户，审核商品是否超过限制
                    if($seting = SeckillRulesSeting::model()->findByPk($relation['rules_seting_id'])){
                        $limit = $seting->seller;
                        //商家参加活动商品数
                        $count = SeckillProductRelation::model()->count(
                                    'seller_id=:seller_id AND status=:status AND rules_seting_id=:rid', 
                                    array(':seller_id'=>$relation['seller_id'],':status'=>SeckillProductRelation::STATUS_PASS,':rid'=>$relation['rules_seting_id'])
                                );
                        if($relation['status'] == SeckillProductRelation::STATUS_PASS) $count -= 1;
                        if($limit > 0 && $count >= $limit){
                            $this->setFlash('error','该商家参加此活动已经超过限制，无法通过审核');
                            $this->redirect($this->getParam('backUrl'));
                            Yii::app()->end();
                        }
                    }
                    //活动产品状态更新
                    $status = SeckillProductRelation::upStatus($seckill_status,$model->seckill_seting_id,$_POST['seckill']['limit_num'],$model->id);
                    if($status == 2){
                        $this->setFlash('error','活动商品数量已满，无法通过审核');
                        $this->redirect($this->getParam('backUrl'));
                        Yii::app()->end();
                    }
                    //活动审核记录
                    Yii::app()->db->createCommand()->insert('{{seckill_product_audit}}', array(
                        'user_id' => $this->getUser()->id,
                        'goods_id' => $id,
                        'relation_id'=> $relation['rules_seting_id'],
                        'price' => $model->price,
                        'created' => time(),
                        'add_time' => $update_time,
                        'content' => $_POST['seckill']['content'],
                        'status' => $seckill_status,
                    ));
                }


                if($model->seckill_seting_id > 0){   //刷新缓存
                    ActivityData:: cleanCache($model->seckill_seting_id, $model->id);
                }

                //审核记录
                Yii::app()->db->createCommand()->insert('{{goods_audit}}', array(
                    'user_id' => $this->getUser()->id,
                    'goods_id' => $id,
                    'price' => $model->price,
                    'created' => time(),
                    'add_time' => $update_time,
                    'content' => $fail_cause,
                    'status' => $model->status,
                ));

                $trans->commit();
                $this->_clearCache();
                @SystemLog::record(Yii::app()->user->name . "更新商品：" . $model->name);
                $this->setFlash('success', Yii::t('Product', '修改商品') . $model->name . Yii::t('Product', '成功'));
				//当前价格如果不等天最新的历史价格, 审核通过是则要增加记录,否则不增加记录 2015-08-20 李文豪
				$rsPrice = Yii::app()->db->createCommand()->select('price')->from('{{goods_price}}')
                           ->where('goods_id=:goods_id', array(':goods_id'=>$id))
					       ->order('create_time DESC')
					       ->limit('1')
                           ->queryScalar();
				if($model->status == 1 && $rsPrice != $model->price){
				    Yii::app()->db->createCommand()->insert('gw_goods_price',array('goods_id'=>$id,'price'=>$model->price,'create_time'=>time()));
				}
				
		        //生成新的产品详情静态页
                $file = 'JF/'.$model->id;
                Tool::deleteWebwww($file);
                
                /**本地和206测试环境用
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
                 **/
		$this->redirect($this->getParam('backUrl'));
            }catch (Exception $e){
                $trans->rollback();
                $this->setFlash('error', Yii::t('Product', '修改商品') . $model->name . Yii::t('sellerGoods', '失败').$e->getMessage());
            }
        }
        $Active = array();
        if($model->seckill_seting_id != 0){
            $Active = SeckillRulesMainSeller::getOneForSeckill($model->seckill_seting_id,$model->id);
            $Active['counts'] = SeckillProductRelation::getCount($model->seckill_seting_id);
        }

        //品牌名称
        $brand = Brand::model()->find('id=:id', array(':id' => $model->brand_id));
        if ($brand)
            $model->brand_name = $brand->name;
        //图片列表
        $imgModel = new GoodsPicture;
        $imgModel->path = $model->pic;
        //属性
        $attribute = Attribute::model()->findAllByAttributes(array('type_id' => $type_id), array('order' => 'sort DESC'));
        $typeSpec = TypeSpec::type_spec($type_id); //类型与规格关联数据
        $goodsSpec = GoodsSpec::getGoodsSpec($model->id);
        $spec = TypeSpec::specValue($typeSpec); //规格值数据,给视图中的循环选择规格用,
        $spec_value_array = isset($goodsSpec['spec_value_array']) ? $goodsSpec['spec_value_array']:array();
        //如果相关类目的商品规格配置与商品里面的规格数据不一致，则说明类目的商品规格配置被删改过了，需要重新选择
        if(count($spec)!=count($goodsSpec[0]['spec_value'])){
            $goodsSpec = array();
        }
        $this->_mergeSpec($spec,$spec_value_array,$model->spec_picture);

        $ratio = ActivityTag::model()->findAll(array('select'=>'id,ratio')); //红包活动比率
        if($ratio){
            $ratioArr=array();
            foreach($ratio as $v){
                $ratioArr[$v->id]=$v->ratio;
            }
            ksort($ratioArr);
            if(array_key_exists($model->activity_tag_id,$ratioArr)){
                $ratio=$ratioArr[$model->activity_tag_id];
            }else{
                $ratio = array_shift($ratioArr);
            }
        }else{
            $ratio=0;
        }
        if($model->content){
            $model->setAttribute('content',stripslashes($model->content));
        }
        $this->render('update', array(
            'model' => $model,
            'attribute' => $attribute,
            'imgModel' => $imgModel,
            'typeSpec'=>$typeSpec,
            'goodsSpec'=>$goodsSpec,
            'ratio' => $ratio,
            'spec'=>$spec,
            'Active'=>$Active,
            'referer'=> isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->createUrl('Product/admin') ,
        ));
    }

    // 列表
    public function actionAdmin() {
        $model = new Product('search');
        $model->unsetAttributes();
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];
        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'product/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }
    /**
     * 参与活动的商品列表
     */
    public function actionActiveAdmin(){
        $model = new SeckillProductRelation('search');
        $model->unsetAttributes();
        if (isset($_GET['SeckillProductRelation'])){
            
            $seckill = $_GET['SeckillProductRelation'];
            $model->setAttributes('date_end',$seckill['date_end']);
            $model->setAttributes('date_start',$seckill['date_start']);
            $model->setAttributes('true_category_id',$seckill['true_category_id']);
            $model->setAttributes('g_category_id',$seckill['g_category_id']);
            $model->setAttributes('price',$seckill['price']);
            $model->setAttributes('end_price',$seckill['end_price']);
            $model->attributes = $seckill;
        }
        $this->showExport = true;
        $this->exportAction = 'ActiveAdminExport';
//
        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'product/ActiveAdminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('activeAdmin', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionAdminExport() {
        set_time_limit(2400);
        @ini_set('memory_limit','1024M');
        $model = new Product('search');
        $model->unsetAttributes();
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];


        @SystemLog::record(Yii::app()->user->name . "导出商品列表");

        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

    public function actionActiveAdminExport() {
        set_time_limit(2400);
        @ini_set('memory_limit','1024M');
        $model = new SeckillProductRelation('search');
        $model->unsetAttributes();
        if (isset($_GET['SeckillProductRelation'])){
            $seckill = $_GET['SeckillProductRelation'];
            $model->setAttributes('date_end',$seckill['date_end']);
            $model->setAttributes('date_start',$seckill['date_start']);
            $model->setAttributes('g_category_id',$seckill['g_category_id']);
            $model->setAttributes('price',$seckill['price']);
            $model->setAttributes('end_price',$seckill['end_price']);
            $model->attributes = $seckill;
        }


        @SystemLog::record(Yii::app()->user->name . "导出活动商品列表");

        $model->isExport = 1;
        $this->render('activeAdminExport', array(
            'model' => $model,
        ));
    }
    
    /**
     * 获取建议商家名称
     * 搜索商品时用
     * auto complete
     */
    public function actionSuggestStores() {
        if (isset($_GET['term']) && ($keyword = trim($_GET['term'])) !== '') {
            $stores = Store::model()->suggestStores($keyword);
            echo CJSON::encode($stores);
        }
    }

    /**
     * 获取建议商品名称
     * 搜索商品时用
     * auto complete
     */
    public function actionSuggestProducts() {
        exit('去掉模糊搜索');
        if (isset($_GET['term']) && ($keyword = trim($_GET['term'])) !== '') {
            $products = Product::model()->suggestProducts($keyword);
            echo CJSON::encode($products);
        }
    }

    /**
     * 获取建议品牌名称
     * 搜索商品时用
     * auto complete
     */
    public function actionSuggestBrands() {
        if (isset($_GET['term']) && ($keyword = trim($_GET['term'])) !== '') {
            $brands = Brand::model()->suggestBrands($keyword);
            echo CJSON::encode($brands);
        }
    }

    /**
     * 取得红包活动比率
     * @param $id
     */
    public function  actionGetActivityTagRatio($id){
        if($this->isAjax()){
            $ratio = ActivityTag::model()->find(array('select'=>'ratio','condition'=>'id=:id','params'=>array(':id'=>$id)));
            if($ratio)
                echo $ratio->ratio;
            else
                echo Yii::t('product','没有找到支持比率');
        }
    }

    /**
     * 设定商品为推荐
     */
    public function actionSetRecommend() {
        $id = $this->getPost('id');
        $type = $this->getPost('type');

        if ($type === 'cancel')
            Product::model()->updateByPk($id, array('show' => Product::SHOW_NO));
        elseif ($type == 'recommend')
            Product::model()->updateByPk($id, array('show' => Product::SHOW_YES));

        @SystemLog::record(Yii::app()->user->name . "设定商品是否推荐：" . $id . '|' . $type);


        echo CJSON::encode(array('status' => 1));
        Yii::app()->end();
    }

    /**
     * 批量审核通过
     * @throws CHttpException
     */
    public function actionApproved() {
        if ($this->isPost()) {
            $db = Yii::app()->db;
            $trans = $db->beginTransaction();
            try{
                foreach($_POST['ids'] as $v){
                    $goods = $db->createCommand('select update_time,create_time,price,market_price from gw_goods where id='.$v)->queryRow();
                    //审核通过，设置初始价格
                    if($goods['market_price']=='0.00'){
                       $db->createCommand()->update('{{goods}}',array('market_price'=>$goods['price']),'id='.$v);
                    }
                    //审核记录
                    $db->createCommand()->insert('{{goods_audit}}', array(
                        'user_id' => $this->getUser()->id,
                        'goods_id' => $v,
                        'created' => time(),
                        'price' => $goods['price'],
                        'add_time' => empty($goods['update_time'])?$goods['create_time']:$goods['update_time'],
                        'content' => '',
                        'status' => Goods::STATUS_PASS,
                    ));
					
					//拿历史价格和当前价格做对比,不相等的,则记入历史记录
					$lastPrice = Yii::app()->db->createCommand()->select('price')->from('{{goods_price}}')
								     ->where('goods_id=:goods_id', array(':goods_id'=>$v))
								     ->order('create_time DESC')
								     ->limit('1')
								     ->queryScalar();
					$nowPrice  = Yii::app()->db->createCommand()->select('price')->from('{{goods}}')
								     ->where('id=:goods_id', array(':goods_id'=>$v))
								     ->limit('1')
								     ->queryScalar();
					if($lastPrice != $nowPrice){
						$db->createCommand()->insert('gw_goods_price',array('goods_id'=>$v,'price'=>$nowPrice,'create_time'=>time()));
					}
                }
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $_POST['ids']);
                Product::model()->updateAll(array('status' => Goods::STATUS_PASS, 'reviewer' => $this->getUser()->name, 'audit_time' => time(),'change_field'=>''), $criteria);

                $trans->commit();
            }catch (Exception $e){
                $trans->rollback();
                echo CJSON::encode(array('success' => false));
            }
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量审核商品通过：id=>" . implode(',', $_POST['ids']));
            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 批量审核不通过
     * @throws CHttpException
     */
    public function actionPending() {
        if ($this->isPost()) {
            $db = Yii::app()->db;
            $trans = $db->beginTransaction();
            try{
                foreach($_POST['ids'] as $v){
                    $goods = $db->createCommand('select update_time,create_time,price from gw_goods where id='.$v)->queryRow();
                    //审核记录
                    $db->createCommand()->insert('{{goods_audit}}', array(
                        'user_id' => $this->getUser()->id,
                        'goods_id' => $v,
                        'created' => time(),
                        'price' => $goods['price'],
                        'add_time' => empty($goods['update_time'])?$goods['create_time']:$goods['update_time'],
                        'content' =>$this->getPost('reason'),
                        'status' => Goods::STATUS_NOPASS,
                    ));
                }
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $_POST['ids']);
                Product::model()->updateAll(array('status' => Goods::STATUS_NOPASS, 'reviewer' => $this->getUser()->name, 'audit_time' => time()), $criteria);

                $trans->commit();
            }catch (Exception $e){
                $trans->rollback();
                echo CJSON::encode(array('success' => false));
            }
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量审核商品不通过：id=>" . implode(',', $_POST['ids']));

            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 批量首页推荐
     * @throws CHttpException
     */
    public function actionRecommend() {
        if ($this->isPost()) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $_POST['ids']);
            Product::model()->updateAll(array('show' => Product::SHOW_YES), $criteria);
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量首页推荐商品：id=>" . implode(',', $_POST['ids']));

            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 批量取消首页推荐
     * @throws CHttpException
     */
    public function actionUnRecommend() {
        if ($this->isPost()) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $_POST['ids']);
            Product::model()->updateAll(array('show' => Product::SHOW_NO), $criteria);
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量取消首页推荐商品：id=>" . implode(',', $_POST['ids']));

            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 批量取消发布
     * @throws CHttpException
     */
    public function actionUnPublished() {
        if ($this->isPost()) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $_POST['ids']);
            Product::model()->updateAll(array('is_publish' => Goods::PUBLISH_NO, 'publisher' => $this->getUser()->name), $criteria);
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量取消发布商品：id=>" . implode(',', $_POST['ids']));

            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 批量发布
     * @throws CHttpException
     */
    public function actionPublished() {
        if ($this->isPost()) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $_POST['ids']);
            Product::model()->updateAll(array('is_publish' => Goods::PUBLISH_YES, 'publisher' => $this->getUser()->name), $criteria);
            $this->_clearCache();
            @SystemLog::record(Yii::app()->user->name . "批量发布商品：id=>" . implode(',', $_POST['ids']));

            if (isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, '无效的操作，请不要重复');
    }

    /**
     * 更新缓存
     */
    private function _clearCache() {
        Tool::cache('common')->delete('indexFloorGoods');
        Tool::cache('common')->delete('indexRecommendGoods');
        foreach($this->getPost('ids',array()) as $id){
            ActivityData::delGoodsCache($id);
        }
    }

    public function loadModel($id)
    {
        /** @var Goods $model */
        $model = Goods::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, '暂时还查找不到该商品，可能数据库还没同步');
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
     * 合并组合spec
     * @param array $spec
     * @param array $specVal
     * @param $specPic
     */
    private function _mergeSpec(Array &$spec, Array $specVal,$specPic){
        foreach($spec as &$v){
            foreach($v['spec_value_data'] as &$v2){
                if(isset($specVal[$v2['id']])){
                    $v2['name'] = $specVal[$v2['id']];
                    $v2['checked'] = true;
                }else{
                    $v2['checked'] = false;
                }
                if(isset($specPic[$v2['id']])){
                    $v2['thumbnail'] = $specPic[$v2['id']];
                }
            }
        }
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
    private function _uploadSpecPic($model,$spec_val,$spec_type){
        $colImgArr = array();
        foreach ($spec_val as $k => $v) {
            if (isset($spec_type[$k]) && $spec_type[$k] == Spec::TYPE_IMG && !empty($_FILES)) {
                foreach ($v as $k2 => $v2) {
                    if (isset($_FILES[$v2]) && $_FILES[$v2]['error'] == 0) {
                        $saveDir = 'files/' . date('Y/n/j');
                        $model = UploadedFile::uploadFile($model, 'spec_picture', $saveDir, Yii::getPathOfAlias('uploads'),null,$v2); // 上传图片
                        if (!$model->validate(array('spec_picture'))) { //检查图片上传
                            throw new Exception(Yii::t('sellerGoods','上传商品自定义规格图片出错'));
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
     * 查看历史价格
     * @param $goods_id
     */
    public function actionGoodsPrice($goods_id){
        $data = GoodsPrice::model()->findAllByAttributes(array('goods_id'=>$goods_id));
        $this->renderPartial('goodsPrice',array('data'=>$data));
    }

    /**
     * ajax 查询慢慢买接口
     */
    public function actionComparePrice($title){
        $http = new HttpClient('');
        $title = urlencode(mb_convert_encoding($title,'gb2312','utf-8'));
        $content =  $http->quickGet('http://sapi.manmanbuy.com/Search_simple.aspx?AppKey=CJx0Q12unfJ2SSUo&Key='.$title);
        $content = mb_convert_encoding($content,'utf-8','gb2312');
        $content = json_decode($content);
        if(empty($content)){
            $content = array('State'=>1000);
        }
        echo json_encode($content);
    }

    /**
     * 商品审核记录
     * @param $goods_id
     * @throws CHttpException
     */
    public function  actionAudit($goods_id){
        $goods = Goods::model()->findByPk($goods_id);
        if(!$goods) throw new CHttpException(404,'商品不存在');
        $audits = GoodsAudit::getGoodsAudit($goods_id);

        $this->render('audit',array('goods'=>$goods,'audits'=>$audits));
    }

    
    /**
     * 评论审核活动商品 批量修改活动商品审核状态，与商品表无关不做检查啦
     * status = 1 通过
     * status = 2 不通过 
     */
    public function actionAuditActive(){
        if($this->isAjax()){ 
            $ids = $this->getPost('ids'); //id
            $status = $this->getpost('status');
            $user_id = Yii::app()->getUser()->id;
            $sql = '';
            $goods_id = '';
            $count = 0;
            $db = Yii::app()->db;
            $trans = $db->beginTransaction();
            try{
                foreach ($ids as $gid => $rid){
                    if(empty($rid) || empty($gid)) continue; 
//                    $goods_id .= $gid.',';
//                    //若审核通过，
                        //得到该产品的基本信息
                        $relation = SeckillProductRelation::model()->findByPk($gid); //活动产品
                        if($relation && $relation->status != $status){
                            $pid = $relation->product_id;
                            if(SeckillProductRelation::STATUS_PASS == $status){
                               if($rules = SeckillRulesSeting::model()->findByPk($rid)){
                                    $limit = $rules->limit_num; //限制数
                                    $limit_seller = $rules->seller; //商家限制数
                                    $product = Product::model()->findByPk($pid);
                                    if($product){ //积分+现金商品不允许参加活动
                                        if($product->jf_pay_ratio > 0 && $product->jf_pay_ratio < 100){
                                            $result = Product::model()->updateByPk($pid, array('jf_pay_ratio'=>0));
                                            if(!$result) continue;
                                        }
                                    }
                                    //活动通过产品
                                    $count = SeckillProductRelation::model()->count(
                                                'rules_seting_id=:rid AND status=:status',
                                                array(':rid'=>$rid,':status'=> SeckillProductRelation::STATUS_PASS)
                                            );
                                    if($limit <= $count || $relation->status == SeckillProductRelation::STATUS_NOPASS) continue; //产品审核达到限制数或状态未通过，不予审核
                                    //商家限制数
                                    $count_seller = SeckillProductRelation::model()->count(
                                                        'rules_seting_id=:rid AND status=:status AND seller_id=:sid',
                                                        array(':rid'=>$rid,':status'=> SeckillProductRelation::STATUS_PASS,':sid'=>$relation->seller_id)
                                                    );
                                    if(($limit_seller > 0 && $limit_seller <= $count_seller) || $relation->status == SeckillProductRelation::STATUS_NOPASS) continue;
                               }
                            }
                            $sql .= "({$pid},{$rid},{$status},{$user_id},".time()."),";
                            //更新产品状态
                            $db->createCommand()->update('{{seckill_product_relation}}',
                                    array('status'=>$status,'examine_time'=>date('Y-m-d H:i:s')),
                                    'id=:id',array(':id'=>$gid)
                                );
                            $goods_id .= $pid .',';
                        }
                }
                if(!empty($sql) && $relation->status != $status){
                    $sql = 'INSERT INTO {{seckill_product_audit}} (`goods_id`,`relation_id`,`status`,`user_id`,`created`) VALUES ' . trim($sql,',');
                    Yii::app()->db->createCommand($sql)->execute();
                }
                //更改审核表的审核状态
                @SystemLog::record(Yii::app()->user->name . "批量审核商品：id=>$goods_id");
                $trans->commit();
                exit(CJSON::encode(array('result'=>true)));
            } catch(CException $e){
                $trans->rollback();
                exit(CJSON::encode(array('result'=>false,'msg'=>$e->getMessage())));
            }
        }
        throw new CHttpException('403','错误请求');
    }
}
