<?php

class FranchiseeBrandController extends Controller
{

    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions()
    {
        return 'getFranchiseeBrandName, getFranchiseeBrand,getInfo,getFranchiseeBrandAll';
    }

    public function actionGetFranchiseeBrand()
    {
        $model = FranchiseeBrand::model();
        $model->unsetAttributes();
        if ($model == NULL)
            $model = new FranchiseeBrand();
        $py = $this->getParam('py');
        $py = isset($py) ? $py : null;
        $c = $model->search2($py);

        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($c);
        $c->order = 'pinyin ASC';
        $infos = $model->findAll($c);

        $this->render('selectfranchiseebrand', array(
            'model' => $model,
            'infos' => $infos,
            'pages' => $pages,
        ));
    }

    /**
     * 品牌列表
     */
    public function actionAdmin()
    {
        $model = new FranchiseeBrand('search');
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeBrand'])) {
            $model->attributes = $this->getParam('FranchiseeBrand');
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 加盟商品牌添加
     */
    public function actionCreate()
    {
        $model = new FranchiseeBrand;

        $this->performAjaxValidation($model);

        if (isset($_POST['FranchiseeBrand'])) {
            $model->attributes = $this->getPost('FranchiseeBrand');
            if ($model->save()) {
                @SystemLog::record(Yii::app()->user->name . "创建加盟商品牌：" . $model->name);
                $this->setFlash('success', Yii::t('franchisee', '添加成功'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * 加盟商品牌编辑
     */
    public function actionUpdate()
    {
        $model = $this->loadModel($_GET['id']);
        $this->performAjaxValidation($model);
        if (isset($_POST['FranchiseeBrand'])) {
            $editor = false;
            foreach ($_POST['FranchiseeBrand'] as $key => $v) {
                if ($model->$key != $v)
                    $editor = true;
            }

            if ($editor) {
                $model->attributes = $this->getPost('FranchiseeBrand');
                if ($model->save()) {
                    @SystemLog::record(Yii::app()->user->name . "修改加盟商品牌：" . $model->name);
                    $this->setFlash('success', Yii::t('franchisee', '修改成功'));
                    $this->redirect(array('admin'));
                }
            } else {
                $this->setFlash('success', Yii::t('franchisee', '没有数据更新'));
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * 加盟商品牌删除
     */
    public function actionDelete()
    {
        if (isset($_GET['id'])) {
            $model = new FranchiseeBrand;
            $rs = $model->deleteByPk($_GET['id']);
            if ($rs) {
                $this->setFlash('success', Yii::t('franchisee', '删除成功'));
                $this->redirect(array('admin'));
            } else {
                $this->setFlash('fail', Yii::t('franchisee', '删除失败'));
                $this->redirect(array('admin'));
            }
        } else {
            $this->setFlash('fail', Yii::t('franchisee', '删除失败'));
            $this->redirect(array('admin'));
        }
    }

    /**
     * 绑定加盟商品牌
     */
    public function actionGetFranchiseeBrandAll()
    {
        $model = new FranchiseeBrand;
        $model->unsetAttributes();
        if (isset($_GET['FranchiseeBrand'])) {
            $model->attributes = $this->getParam('FranchiseeBrand');
        }
        $this->render('bizFranchiseeBrand', array('model' => $model));
    }

    /**
     * 获取所属加盟商品牌名称 ajax 请求方式
     * @param int $id
     * @return json
     */
    public function actionGetFranchiseeBrandName($id)
    {
        if ($this->isAjax()) {
            $model = FranchiseeBrand::model()->with('franchisee')->find('t.id = :id', array(':id' => $id));
            if (!is_null($model)) {
//                Tool::pr($model->franchisee);
                $data=array();
                $html='';
                $html.='<th class="odd">支持所属加盟商</th>';
                $html.='<td class="odd">';
                $html.='<input type="checkbox" id="checkAll" name="checkAll">全选  <br/>';
                foreach($model->franchisee as $franchisee){
                    $html.='<input type="checkbox" value="'.$franchisee->id.'" name="franchisee_id[]" data="checkList">'.$franchisee->name;
                }
                $html.="</td>";
                if(!$model->franchisee){
                    $html='';
                }
                $data['html']=$html ;
                $data['name']=$model->name;
                echo CJSON::encode($data);
            } else {
                echo CJSON::encode(null);
            }

        }
    }

}
