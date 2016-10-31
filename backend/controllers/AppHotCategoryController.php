<?php

class AppHotCategoryController extends Controller {

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
        return 'depthCategory';
    }

    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new AppHotCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['AppHotCategory'])) {
            $model->attributes = $this->getParam('AppHotCategory');
            $model->name = $_GET['AppHotCategory']['name'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 创建热卖分类
     */
    public function actionCreate(){
        $model = new AppHotCategory('create');
        $this->performAjaxValidation($model);
        if (isset($_POST['AppHotCategory'])) {
            $postArr = $this->getPost('AppHotCategory');
            $model->attributes = $postArr;
            $model->category_id = !empty($postArr['depthTwo']) ? $postArr['depthTwo'] : (!empty($postArr['depthOne']) ? $postArr['depthOne'] : (!empty($postArr['depthZero']) ? $postArr['depthZero'] : ''));
            $model->create_time = time();
            $model->update_time = time();
            $saveDir = 'AppHotCategory' . DS . date('Y/n/j');
            $model = UploadedFile::uploadFile($model, 'picture', $saveDir);
            if(!empty($_FILES['AppHotCategory']['name']['picture'])){
            	$ImageSize = getimagesize($_FILES['AppHotCategory']['tmp_name']['picture']);
            	
            	if($ImageSize[0] !=400 || ($ImageSize[1] !=400 && $ImageSize[1] !=480)){
            		 
            		$model->addError("picture","请上传400*480或者400*400的图片");
            		$this->render('_form',array(
            				'model'=>$model,
            		));exit;
            	}
            }else{
            	$model->addError("picture","请上传图片");
            	$this->render('_form',array(
            			'model'=>$model,
            	));exit;
            }
           
            $model->name = AppHotCategory::getCategoryName($model->category_id);
            if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture);
                SystemLog::record($this->getUser()->name . "创建商城热卖分类商品分类：" . $model->name);
                $this->setFlash('success', Yii::t('category', '创建商城热卖分类商品分类') . '"' . $model->name . '"' . Yii::t('AppHotCategory', '成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 修改热卖分类
     */
    public function actionUpdate($id){
    	$model = $this->loadModel($id);
        $depth = AppHotCategory::getParentCategory($model->category_id);
        foreach($depth as $key => $val){
            if($key == Category::DEPTH_ZERO)
                $model->depthZero = $val;
            if($key == Category::DEPTH_ONE)
                $model->depthOne = $val;
            if($key == Category::DEPTH_TWO)
                $model->depthTwo = $val;
        }
        $oldPicture = $model->picture;
        $this->performAjaxValidation($model);
    	if (isset($_POST['AppHotCategory'])) {
    		$postArr = $this->getPost('AppHotCategory');
    		$model->attributes = $postArr;
    		$model->category_id = !empty($postArr['depthTwo']) ? $postArr['depthTwo'] : (!empty($postArr['depthOne']) ? $postArr['depthOne'] : (!empty($postArr['depthZero']) ? $postArr['depthZero'] : ''));
    		$model->update_time = time();
    		$saveDir = 'AppHotCategory' . DS . date('Y/n/j');
            if(empty($model->picture)){
                $model->picture = $oldPicture;
            }
            if(!empty($_FILES['AppHotCategory']['name']['picture'])){
            	$ImageSize = getimagesize($_FILES['AppHotCategory']['tmp_name']['picture']);
            	 
            	if($ImageSize[0] !=400 || ($ImageSize[1] !=400 && $ImageSize[1] !=480)){
            		 
            		$model->addError("picture","请上传400*480或者400*400的图片");
            		$this->render('_form',array(
            				'model'=>$model,
            		));exit;
            	}
            }
    		$model = UploadedFile::uploadFile($model, 'picture', $saveDir);
    		$model->name = AppHotCategory::getCategoryName($model->category_id);
    		if ($model->save()) {
                UploadedFile::saveFile('picture', $model->picture,$oldPicture,true);
    			SystemLog::record($this->getUser()->name . "修改商城热卖分类商品分类：" . $model->name);
    			$this->setFlash('success', Yii::t('category', '修改商城热卖分类商品分类') . '"' . $model->name . '"' . Yii::t('AppHotCategory', '成功'));
    			$this->redirect(array('admin'));
    		}
    	}
    	
    	$this->render('_form', array(
    			'model' => $model,
    	));
    }

    /**
     * 删除热卖分类
     */
    public function actionDelete($id){
    	$model = $this->loadModel($id);
        $oldPictureMame = AppHotCategory::getCategoryName($model->category_id);
    	if ($model->delete()){
    		SystemLog::record($this->getUser()->name . '删除商城app热门分类' . $oldPictureMame . '，ID为：' . $model->id);
            $this->setFlash('success', Yii::t('category', '删除商城热卖分类商品分类') . '"' . $oldPictureMame . '"' . Yii::t('AppHotCategory', '成功'));
    	}
    	$this->redirect(array('admin'));
    }

    /**
     * ajax处理二级、三级分类
     */
    public function actionDepthCategory(){
        if ($this->isPost()) {
            $pid = isset($_POST['pid']) ? (int) $_POST['pid'] : "9999999";
            $type = isset($_POST['type']) ?  $_POST['type'] : "depthOne";

            switch ($type){
                case 'depthOne':                    //获取二级分类
                    $dropDownCities = "<option value=''>" . Yii::t('AppHotCategory', '选择二级分类') . "</option>";
                        $depthOne = AppHotCategory::getChildCategory($pid);
                        foreach ($depthOne as $value => $name)
                            $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);

                    $dropDownCounties = "<option value=''>" . Yii::t('Region', '选择三级分类') . "</option>";
                    echo CJSON::encode(array(
                        'dropDownCategory' => $dropDownCities,
                        'dropDownCounties' => $dropDownCounties
                    ));
                    break;
                case 'depthTwo':                //获取三级分类
                    $dropDownCities = "<option value=''>" . Yii::t('AppHotCategory', '选择三级分类') . "</option>";
                    $depthTwo = AppHotCategory::getChildCategory($pid);
                    foreach ($depthTwo as $value => $name)
                        $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);

                    $dropDownCounties = "<option value=''>" . Yii::t('AppHotCategory', '选择三级分类') . "</option>";
                    echo CJSON::encode(array(
                        'dropDownCategory' => $dropDownCities,
                        'dropDownCounties' => $dropDownCounties
                    ));
                    break;
            }
        }else{
            echo array();
        }
    }
}
