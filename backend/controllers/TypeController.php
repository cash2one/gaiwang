<?php

/**
 * 商品规格控制器(创建,修改,删除,管理),
 * @author binbin.liao  <277250538@qq.com>
 */
class TypeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 创建
     */
    public function actionCreate() {
        $model = new Type;
        $specData = Spec::model()->findAll(); //规格和规格值
        $brand = Brand::model()->findAll(); //品牌列表
        $flag = ''; //事务状态标识
        $this->performAjaxValidation($model);
        if (isset($_POST['Type'])) {
            $model->attributes = $_POST['Type'];
            //关联添加到类型与规格索引表中
            $spec_id = $this->getParam('spec_id'); //规格值
            if ($spec_id) {
                foreach ((array) $spec_id as $v) {
                    $specArr[]['spec_id'] = $v;
                }
            }
//                $typeSpec = new TypeSpec;
//                foreach ((array)$spec_id as $v) {
//                    $specArr['type_id'] = $model->primaryKey;
//                    $specArr['spec_id'] = $v;
//                    $typeSpec->attributes = $specArr;
//                    $typeSpec->save();
//                    $typeSpec->setIsNewRecord(TRUE);
//                }
            //关联添加到类型与品牌索引表中
            $brand_id = $this->getParam('brand_id'); //品牌
            if ($brand_id) {
                foreach ((array) $brand_id as $v) {
                    $brandArr[]['brand_id'] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    $type_id = $model->primaryKey;
                    if (isset($specArr)) {
                        foreach ($specArr as $k => $val) {
                            Yii::app()->db->createCommand()->insert('{{type_spec}}', array(
                                'type_id' => $type_id,
                                'spec_id' => $val['spec_id'],
                            ));
                        }
                    }

                    if (isset($brandArr)) {
                        foreach ($brandArr as $k => $val) {
                            Yii::app()->db->createCommand()->insert('{{type_brand}}', array(
                                'type_id' => $type_id,
                                'brand_id' => $val['brand_id'],
                            ));
                        }
                    }
                }
                $flag = true;
                $transaction->commit();
                
                @SystemLog::record(Yii::app()->user->name . "添加商品规格：" . $model->name);
                
            } catch (Exception $e) {
                echo $e->getMessage();
                $transaction->rollBack();
                $flag = false;
            }
            if ($flag) {
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'specData' => $specData,
            'brand' => $brand,
            'specCheck' => array(),
            'brandCheck' => array(),
        ));
    }

    /**
     * 更新
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $specData = Spec::model()->findAll(); //规格和规格值
        $specCheck = Yii::app()->db->createCommand()
                ->select('spec_id')
                ->from('gw_type_spec')
                ->where('type_id=:tid', array(':tid' => $id))
                ->queryColumn();

        $brand = Brand::model()->findAll(); //品牌列表
        $brandCheck = Yii::app()->db->createCommand()
                ->select('brand_id')
                ->from('gw_type_brand')
                ->where('type_id=:tid', array(':tid' => $id))
                ->queryColumn();


        $this->performAjaxValidation($model);

        if (isset($_POST['Type'])) {
            TypeSpec::model()->deleteAll('type_id=' . $id); //在更新之前先删除以前的数据,这样不会引起重复的插入
            TypeBrand::model()->deleteAll('type_id=' . $id); //在更新之前先删除以前的数据
            $model->attributes = $_POST['Type'];
            //关联添加到类型与规格索引表中
            $spec_id = $this->getParam('spec_id'); //规格值
            if ($spec_id) {
                foreach ((array) $spec_id as $v) {
                    $specArr[]['spec_id'] = $v;
                }
            }

            //关联添加到类型与品牌索引表中
            $brand_id = $this->getParam('brand_id'); //品牌
            if ($brand_id) {
                foreach ((array) $brand_id as $v) {
                    $brandArr[]['brand_id'] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    $type_id = $model->primaryKey;
                    if (isset($specArr)) {
                        foreach ($specArr as $k => $val) {
                            Yii::app()->db->createCommand()->insert('{{type_spec}}', array(
                                'type_id' => $type_id,
                                'spec_id' => $val['spec_id'],
                            ));
                        }
                    }

                    if (isset($brandArr)) {
                        foreach ($brandArr as $k => $val) {
                            Yii::app()->db->createCommand()->insert('{{type_brand}}', array(
                                'type_id' => $type_id,
                                'brand_id' => $val['brand_id'],
                            ));
                        }
                    }
                }
                $flag = true;
                $transaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $transaction->rollBack();
                $flag = false;
            }
            if ($flag) {
                @SystemLog::record(Yii::app()->user->name . "更新商品规格：" . $model->name);
                $this->setFlash('success', Yii::t('type', '更新成功！'));
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                $this->setFlash('success', Yii::t('type', '更新失败！'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'specData' => $specData,
            'brand' => $brand,
            'specCheck' => $specCheck,
            'brandCheck' => $brandCheck,
        ));
    }

    /**
     * 删除
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        @SystemLog::record(Yii::app()->user->name . "删除商品规格：" . $id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * 管理
     */
    public function actionAdmin() {
        $model = new Type('search');
        $model->unsetAttributes();
        if (isset($_GET['Type']))
            $model->attributes = $_GET['Type'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
