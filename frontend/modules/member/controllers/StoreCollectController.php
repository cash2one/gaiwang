 <?php
 /**
  * 收藏店铺控制器
  * @author zhizhong.liu <404597544@qq.com>
  */
class StoreCollectController extends MController
{
	public $getgoods = 5;//每个店铺展示五件商品
	
	public $getstore = 3;//每屏展示三间店铺
	
	public $getstoreadd = 1;//循环控制加1
  
    /**
     * 商品收藏列表
     */
    public function actionIndex()
    {   

        $criteria = new CDbCriteria();
        $store = Yii::app()->db->createCommand()->select('g.id,g.name,g.logo,t.id as tid')
        ->from('{{store_collect}} t')
        ->Join('{{store}} g', 'g.id=t.store_id')
        ->where('t.member_id = :member_id', array(':member_id' => $this->getUser()->id))
        ->order('id DESC')
        //->limit($this->getstore)
        ->queryAll();
        $this->render('index', array('store' => $store,'i'=>$this->getstoreadd));      
    }     
    /**
     *随机展示该店铺商品
     */
    public function actionGetGoods($id)
    {
        if(!$this->user->id){
            echo $data['msg'] = Yii::t('Collect','您太久没操作，请重新登陆！');
            exit();
        }
        $store_id = $this->getParam('id');
        $userId  = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $goods = Yii::app()->db->createCommand()->select('g.id,g.store_id,g.name,g.gai_price,g.price,g.thumbnail')
                ->from('{{goods}} g')
                ->where('g.store_id = :store_id', array(':store_id' => $store_id))
                ->order('rand() limit '.$this->getgoods)
                ->queryAll();
        $html='';
        foreach ($goods as $g){
            $html.='<li>
                        <a href="'.Yii::app()->createAbsoluteUrl('/goods/view/',array('id' => $g['id'])).'" title="'.Tool::truncateUtf8String($g['name'], 100, '..').'">'
                            .CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $g['thumbnail'], 'c_fill,h_122,w_174'), $g['name'], array('height' => '122', 'width' => '174')). 
                            '<p class="hp-name">'.Tool::truncateUtf8String($g['name'], 100, '..').'</p>
                            <p class="hp-price">'.HtmlHelper::formatPrice($g['price']).'</p>
                        </a>
                    </li>';

        }
        echo $html;
    }
    
    /**
     * 收藏店铺
     * **/
    public function actionCollect(){
        $model = new StoreCollect('search');
        $model->unsetAttributes();  // clear any default values
        //$this->performAjaxValidation($model);       
        $data = array('success'=>false, 'type'=>1, 'msg'=>'收藏失败！');
        $cb   = $this->getParam('jsoncallBack');       
        if(!$this->user->id){
            $data['msg'] = Yii::t('Collect','您还没有登录，请先登录！');
            exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
        }      
        if (isset($_GET['id'])){
            $rs = StoreCollect::model()->findByAttributes(array('store_id'=>$_GET['id'],'member_id'=>$this->getUser()->id));
            if ($rs){
                $msg = Yii::t('Collect','你已收藏过该店铺！');
                $data['success'] = true;
            }else {   
                $model->store_id = $this->getParam('id');
                $model->member_id = $this->getUser()->id;
                $model->creat_time = time();
                if ($model->save()) {
                    $msg = Yii::t('Collect','收藏成功！');
                    $data['success'] = true;
                }
                else{
                    $msg = Yii::t('Collect','收藏失败！');
                }            
            }
            $data['msg'] = $msg;
        }else{
            throw new CHttpException(400, Yii::t('Collect', '没有找到相应的店铺信息'));
        } 
        $data['msg'] = $msg;               
        exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
    }     
    /**
     * 删除收藏
     */
    public function actionDelete() {
        $colectid = $this->getParam('id');
        $data = array('success'=>false, 'msg'=>'取消失败！');
        $cb   = $this->getParam('jsoncallBack');
        if(!$this->user->id){
            $data['msg'] = Yii::t('Collect','您还没有登录，请先登录！');
            exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
        }        
        $model = new StoreCollect('search');
        $colectstore = StoreCollect::model()->findByAttributes(array('id'=>$colectid)); //查找是否有收藏该店  
        if(!empty($colectstore)){
            if($colectstore['member_id']==$this->getUser()->id){
                $model->deleteall('id=:postID', array(':postID'=>$colectid));
                $cacheKey='STORE_COLLECT_'.$colectstore->store_id.'_'.$colectstore->member_id;
                Tool::cache($cacheKey)->delete($cacheKey);
                $msg = Yii::t('Collect','取消成功！'); 
                $data['success'] = true;
            }else{
                //throw new CHttpException(403,Yii::t('Collect','您没有权限删除，请登录卖家平台！'));
               $msg = Yii::t('Collect','你无权限取消！');
            }
        }else{
            $msg = Yii::t('Collect','该店铺已从收藏列表中删除');
        }
        $data['msg'] = $msg;
        exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
    }
    
} 