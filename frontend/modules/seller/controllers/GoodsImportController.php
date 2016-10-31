<?php
class GoodsImportController extends SController
{
    const FILE_FILES_PATH = "files";
    const DATA_TAOBBAO = 2;
    const DATA_TIANMAO = 1;

    public function beforeAction($action)
    {
        throw new CHttpException('404','错误请求');
        parent::beforeAction($action);
    }
    
    /**
     * 导入商品数据包
     */
    public function actionIndex()
    {
        $config = $this->getConfig('upload');
        $goods = new Goods();
        $storeId = $this->getSession('storeId');
//        var_dump($_SESSION);
        $sql = "SELECT id FROM {{goods_tmp}} WHERE store_id={$storeId}";
        if(Yii::app()->db->createCommand($sql)->query()->count()){
            $this->redirect(array('goodsImport/stepThree'));
        }
        //查找店铺类目
        $store = Store::model()->find(array(
            'select'=>'t.category_id,c.name,t.upload_time,t.upload_total',
            'join'=> 'LEFT JOIN {{category}} as c ON c.id=t.category_id',
            'condition'=>'t.id=:id',
            'params'=>array(':id'=>$storeId)
        ));
        //判断店家是否已经达到当天上传总数
        //当天凌晨0点时间戳
        $time = strtotime(date('Ymd'));
        if($store->upload_time == $time && $store->upload_total >=$config['uploadTotal'])
        {
            $this->setFlash('error',  Yii::t('goods','对不起，产品上传已经达到今天上传最大数'));
            $this->redirect(array('goods/index'));
        } else if($store->upload_time < $time){
            store::model()->updateByPk($storeId, array('upload_time'=>$time,'upload_total'=>0));
            $store->upload_total = 0;
        }
        $goods->freight_payment_type = Goods::FREIGHT_TYPE_SELLER_BEAR;
        $this->render('exportgoods', array(
            'total'=> $config['uploadTotal'],
            'store'=>$store,
            'goods' => $goods,
        ));
    }

    /**
     * 导入数据包第二步
     */
    public function actionStepTwo()
    {
        $goods = new Goods();
        $this->performAjaxValidation($goods);
        $post = Yii::app()->request->getPost('Goods');
        // 此次控制没有值，调回第一步
        if (empty($post)) {
            $this->redirect(array('goodsImport/index'));
        }
        if (isset($post)) {
            $goods->attributes = $post;
        }
        $this->render('steptwo', array('model' => $goods));
    }

    /**
     * 实际导入数据包到产品临时表
     */
    public function actionGoodsImport()
    {
        $post = Yii::app()->request->getPost('Goods');
        try {
            //$datatype = Yii::app()->request->getParam('datatype'); //天猫/淘宝
            header("Content-type:text/html;charset=utf-8");
            $file = CUploadedFile::getInstanceByName('filename');
            if ($file->getError() !== 0) {
                throw new CException('上传文件错误');
            }

            $extension = $file->getExtensionName();
            $allow_ext = array('xlsx','xls');
            if(!in_array($extension, $allow_ext)){
                throw new CException('不允许的文件类型');
            }
            
            if($file->getSize() > 4*1024*1024){
                throw new CException('导入文件太大');
            }

            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/IOFactory.php';
            $fileType = PHPExcel_IOFactory::identify($file->getTempName());
            $objReader = PHPExcel_IOFactory::createReader($fileType);
            $objExecl = $objReader->load($file->getTempName());
            $sheet = $objExecl->getActiveSheet()->toArray(null,true,true,true);
            array_shift($sheet);array_shift($sheet);array_shift($sheet); //文件三个头部
            $count = count($sheet);
            $config = $this->getConfig('upload'); //配置
            if($config['uploadTotal'] < $count) throw new CException(Yii::t('goodsImport','超过单次导入上限,请修改数据包'));
            if(empty($sheet) || $count <= 0) throw new CException('数据包为空');
            $datacache =  str_replace('\\', '/', Yii::getPathOfAlias('root')) .'/frontend/runtime/';
            $this->create_folders($datacache);
            //防止数据导入重叠
            $filename = uniqid().'.txt';
            $filePath = $datacache . $filename;
            if(file_exists($filePath)) @unlink ($filePath);
            file_put_contents($filePath, serialize($sheet),LOCK_EX);
            //
            if(UPLOAD_REMOTE){
                $save_path = self::FILE_FILES_PATH . '/' . date('Y/m/d/') . $filename;
                UploadedFile::import($filePath, $save_path);
                @unlink ($filePath);
                $filePath = IMG_DOMAIN . '/' . $save_path;
            }

            
            $this->setSession('filepath',  urlencode($filePath)); 
            // 删除本地文件
            $this->render('import',array('key'=>1,'fail'=>0,'count'=>$count,'post'=> serialize($post)));

        } catch (CException $e) {
            $this->setFlash('error', '文件上传错误:'.Yii::t('goods',$e->getMessage()));
            $this->redirect(array('goodsImport/index'));
        }
    }

    /**
     * 导入第三步
     */
    public function actionStepThree()
    {
        $connect = Yii::app()->db;
        $store_id = $this->getSession('storeId');
        $sql = "SELECT t.id,t.name,t.stock,t.price,t.freight_payment_type,t.freight_template_id,t.create_time,g.name AS gname,s.name AS sname FROM {{goods_tmp}} AS t 
            LEFT JOIN {{category}} as g ON t.category_id = g.id 
            LEFT JOIN {{scategory}} as s ON t.scategory_id = s.id WHERE t.store_id = {$store_id}";
        $goods = $connect->createCommand($sql)->queryAll();
        //存产品标题
        if(empty($goods)) {
            $this->setFlash('error',  Yii::t('goods','没有数据导入'));
            $this->redirect(array('goodsImport/index'));
        }
        $name = array();
        foreach ($goods as $key => $good) {
            $name[$key] = $good['name'];
        }
        $unique = array_unique($name);
        $different = array_diff_assoc($name, $unique); //返回的是重复的数据
        
        //店铺信息
        $store = Store::model()->findByPk($this->getSession('storeId'));
        $config = $this->getConfig('upload');
        $this->render('stepthree', array(
            'data' => $goods,
            'different' => $different,
            'unique' => $unique,
            'store'=>$store,
            'total'=>$config['uploadTotal']
        ));
    }

    public $failed =0; //记录导入失败个数
    /**
     * 导入文件
     * @param array $file
     * @param array $post 
     */
    public function actionImportFile()
    {
        $m = memory_get_usage();
        set_time_limit(0);
        header("Content-Type:text/html;Charset=utf-8");
//        header('Content-Encoding:gzip');
        //读取session中需要导入数据
        //$start1 = microtime(1);
        //$config = $this->getConfig('upload');
        $filepath = urldecode($this->getSession('filepath'));
        $post = Yii::app()->request->getPost('post');
        $post = empty($post) ? '' : unserialize(Yii::app()->request->getPost('post'));
        $count = Yii::app()->request->getPost('count');
        $index = Yii::app()->request->getPost('key');
        $index = empty($index) ? $count : $index;
        $fail = Yii::app()->request->getPost('fail');

        $category_id = isset($post['category_id']) ? $post['category_id'] : 0;
        $category = Category::model()->findByPk($category_id);
        $fee = ($category->fee) / 100;
        $scategory_id = isset($post['scategory_id']) ? $post['scategory_id'] : 0;
        $freight_id = isset($post['freight_template_id']) ? $post['freight_template_id'] : 0;
        $connection = Yii::app()->db;
        //上传配置         
        $store_id = $this->getSession('storeId');
        
        //导入条数满了。跳转到导入列表页
        if ($count == ($index - 1)) {
            @unlink($filepath);
            if(UPLOAD_REMOTE){
                $ftp = Yii::app()->ftp;
                @$ftp->delete(Yii::getPathOfAlias('uploads') . str_replace(IMG_DOMAIN,'',$filepath));
            }
            $this->setSession('filepath');
            $this->redirect(array('goodsImport/stepThree', 'fail' => $fail));
        }
//        ob_start();
//        readfile($filepath);
//        $sheet = ob_get_contents();
//        ob_end_clean();
//        $sheet = unserialize($sheet);
        $sheet = unserialize(file_get_contents($filepath));
        //$end1 = microtime(1);
        //$step1 = sprintf('%.5fs',$end1-$start1);
        
        //$start2 = microtime(1);
        //组装导入产品必须项
        $product = array(
            'type_id'=>$category->type_id,
            'store_id'=>$store_id,
            'category_id'=>$category_id,
            'scategory_id'=>$scategory_id,
            'freight_template_id'=>$freight_id,
            'freight_payment_type'=>$post['freight_payment_type'],
            'is_publish'=>  Goods::PUBLISH_YES
        ); 
        //产品的type_id
        //session取当前数据
        $goodslist = $sheet[$index-1];
        unset($sheet);
        //解析数据包数据，组装产品数据结构   
        $product['name'] = isset($goodslist['A']) ? $goodslist['A']: ''; //标题
        $product['price'] = isset($goodslist['H']) ? $goodslist['H'] : ''; // 零售价
        $product['gai_price'] = isset($goodslist['H']) ? bcsub($goodslist['H'], bcmul($goodslist['H'], $fee, 2), 2) : ''; // 供货价
        $product['stock'] = isset($goodslist['J']) ? $goodslist['J'] : ''; // 库存
        $product['publisher'] = isset($goodslist['AN']) ? $goodslist['AN'] : ''; //  发布人

        $product['content'] = isset($goodslist['U']) ? $this->_getDescImage($goodslist['U']) : ''; 
        
        //$end2 = microtime(1);
        //$step2 = sprintf('%.5fs',$end2-$start2);
        
        //$start4 = microtime(1);
         // 描述
        $picture = isset($goodslist['AC']) ?  $this->_getPictureList($goodslist['AC']) :  '';// 图片
        $product['thumbnail'] = (is_array($picture) && !empty($picture)) ?  current($picture) : '';
        $product['create_time'] = time();
        //$end4 = microtime(1);
        //$step4 = sprintf('%.5fs',$end4-$start4);
        unset($goodslist);
        //$start3 = microtime(1);
        //产品数据是否完整 不完整记录失败
        if(empty($product['name']) || empty($product['price']) || empty($product['gai_price']) || empty( $product['stock']) || empty($product['thumbnail']) || empty($product['content'])){
            //失败删除图片
            if(UPLOAD_REMOTE){
                $ftp = Yii::app()->ftp;
                $upload = Yii::getPathOfAlias('uploads');
                preg_match_all('/((http|https):\/\/[\w-\/\.\s!\v\t|\?=]*)/i', $product['content'],$match);
                if(isset($match[0]) && is_array($match[0])){
                    foreach ($match[0] as $m){
                        $dpath = $upload . str_replace($upload , '' , str_replace(IMG_DOMAIN, '', $m));
                        @$ftp->delete($dpath); //无论成功与否，都不提醒
                    }
                }
                if (is_array($picture) && !empty($picture)) {
                    foreach ($picture as $p) {
                        $delete_path = $upload . '/' . $p['path'];
                        @$ftp->delete($delete_path); //无论成功与否，都不提醒
                    }
                }
            }
            $fail  += 1;
        } else {
            $transaction = $connection->beginTransaction();
            try {
                $connection->createCommand()->insert('{{goods_tmp}}', $product);
                $goods_id = $connection->lastInsertID;
                //规格表  goods_spec_value
                $goodsSpec = array(
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'goods_id'=>$goods_id,
                    'spec_value'=>'',
                    'spec_name'=>''
                );
                //规格值 goods_spec_index
                    $connection->createCommand()->insert('{{goods_spec_tmp}}', $goodsSpec);
                    $spec_id =  $connection->lastInsertID;
                    //更新goods_tmp表中的spec_id;
                    $connection->createCommand()->update('{{goods_tmp}}', array('goods_spec_id'=>$spec_id), 'id=:id',array(':id'=>$goods_id));
                
                //产品图片
                if(!empty($picture) && is_array($picture)){
                    $pics = '';
                    foreach ($picture as $p) {
                        $pics .= "('{$p}','{$goods_id}'),";
                    }
                    $sql = "INSERT INTO {{goods_picture_tmp}} (`path`,`goods_id`) VALUES " . trim($pics,',');
                    $connection->createCommand($sql)->execute();
                }    
                $transaction->commit();
            } catch (CException $e) {
                $transaction->rollback();
                $fail +=1;
                $this->setFlash('error',$e->getMessage());
                $this->redirect(array('goodsImport/stepThree','fail'=>$fail));
            }
        }
//        $end3 = microtime(1);
//        $step3 = sprintf('%.5fs',$end3-$start3);
//        $momery = memory_get_usage();
//        $str = "result:第{$index}条导入,第一步：{$step1},图片列表耗时:{$step4},第三步:{$step3},描述耗时:{$step2},运行前:{$m},运行后：{$momery}\n";
//        file_put_contents(str_replace('\\', '/', Yii::getPathOfAlias('root')) .'/frontend/runtime/'.'bb.txt', $str,FILE_APPEND);
        unset($product);
        $index +=1;
        $this->render('import',array('key'=>$index,'fail'=>$fail,'count'=>$count,'post'=> serialize($post)));
    }

    /**
     * 处理产品规格信息
     * @param string $spec
     * @return string $prototype
     */
    protected function _getGoodsSpec($spec)
    {
        /////要处理下$k的ID
        $prototype = array();
        if (is_string($spec) && !empty($spec)) {
            $p = explode(';', $spec);
            foreach ($p as $k=>$v) {
                $prototype[1][$k+1] = substr($v, strrpos($v, ':') + 1);
//                $prototype[] = iconv('gb2312', 'UTF-8', substr($v, strrpos($v, ':') + 1));
            }
        }
        return $prototype;
    }

    /**
     * 处理图片列表
     * @param string $picture
     * @return array $picturs 
     */
    protected function _getPictureList($picture)
    {
        $pictures = array();
        if (is_string($picture)) {
            //按 ';'分割字符串 // 40bc45f9633e4fbf33e9cdcb5220a7f3:1:0:|http://img.newgatewang.com/tmp/8cb52002bf2b9087c8a144b177b35e78.jpg
            $p = explode(';', $picture);
            array_pop($p);
            foreach ($p as $v) {
                $file = substr($v,-(strlen($v)-stripos($v,'|')-1));
                $pictures[] = $this->_getImg($file);
            }
        }
        return str_replace(IMG_DOMAIN, '', $pictures);
    }

    /**
     * 匹配图片
     * @param string $desc 导入的描述
     */
    protected function _getDescImage($desc)
    {
        return preg_replace_callback("/((http|https):\/\/[\w-\/\.\s!\v\t|\?=]*)/i", array($this, '_processImg'), $desc);
    }


    /**
     *  回调函数
     * @param type $match
     */
    protected function _processImg($match)
    {
        return $this->_getImg($match[0]);
    }
    
    /**
     * 处理文件上传
     * @param string 文件名
    */
    protected function _getImg($file)
    {
        $ext = array('jpg', 'jpeg', 'png', 'gif');
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (!in_array($extension, $ext)) {
            return str_replace($file, 'javascript:void(0)', $file);
        }
        $filename = Tool::generateSalt() . '.' . $extension;
        $save_path = self::FILE_FILES_PATH . '/' . date('Y/m/d/') . $filename; 
        $path = UploadedFile::import($file,$save_path);
        return str_replace($file, $path, $file);
    }

    /**
     * 判断是否存在目录，不存在递归创建目录
     */
    public static function create_folders($dir)
    {
        return is_dir($dir) or ( self::create_folders(dirname($dir)) and mkdir($dir, 0777));
    }

    // 重命名文件
    public function actionRename()
    {
        $id = Yii::app()->request->getPost('id');
        $name = addslashes(trim(Yii::app()->request->getPost('name')));
        if(empty($name) || strlen($name) > 240 ) exit(json_encode (array('error'=>true,'msg'=>  Yii::t('goods','多于80字或者为空，请重新输入'))));
        $store_id = $this->getSession('storeId');
        $sql = "UPDATE {{goods_tmp}} set name='{$name}' WHERE id={$id} AND store_id={$store_id} ";
        if ($id > 0 && Yii::app()->db->createCommand($sql)->execute()) {
            exit(json_encode(array('error' => false)));
        }
        exit(json_encode(array('error' => true,'msg'=>Yii::t('goods','重命名失败'))));
    }

    /**
     * 用户取消导入数据
     */
    public function actionStepCancel()
    {
        ///////还要修改
        $connect = Yii::app()->db;
        $store_id = $this->getSession('storeId');
        $transaction = $connect->beginTransaction();
        try {
            $gsql = "SELECT id FROM {{goods_tmp}} WHERE store_id={$store_id}";
            $products = $connect->createCommand($gsql)->queryAll();
            $goods_id = array();
            foreach ($products as $product){
                $goods_id[] = $product['id'];
            }
            $ids = implode(',', $goods_id);
            //删除图片 只有FTP图片远程开启的时候才能删除图片，否则操作
            if(UPLOAD_REMOTE){
                $ftp = Yii::app()->ftp;
                $path = $connect->createCommand("SELECT `path` FROM {{goods_picture_tmp}} WHERE goods_id IN({$ids})" )->queryAll();
                $content = $connect->createCommand("SELECT `content` FROM {{goods_tmp}} WHERE id IN({$ids})")->queryAll();
                $upload = Yii::getPathOfAlias('uploads');
                if(is_array($path) && !empty($path)){
                    foreach ($path as $p){
                        $delete_path = $upload . '/' . $p['path'];
                        @$ftp->delete($delete_path); //无论成功与否，都不提醒
                    }
                }

                //匹配描述里面的图片
                foreach($content as $c){
                    preg_match_all('/((http|https):\/\/[\w-\/\.\s!\v\t|\?=]*)/i', $c['content'],$match);
                    if(isset($match[0]) && is_array($match[0])){
                        foreach ($match[0] as $m){
                            $dpath = $upload . str_replace($upload , '' , str_replace(IMG_DOMAIN, '', $m));
                            $a = @$ftp->delete($dpath); //无论成功与否，都不提醒
                        }
                    }
                }

            }
            
            //删除两个属性表
            //$connect->createCommand("DELETE FROM {{goods_picture_tmp}} WHERE goods_id IN({$ids})")->execute();
            $connect->createCommand("DELETE FROM {{goods_spec_tmp}} WHERE goods_id IN({$ids})")->execute();
            //删除图片表
            $connect->createCommand("DELETE FROM {{goods_picture_tmp}} WHERE goods_id IN({$ids})")->execute();
            $connect->createCommand("DELETE FROM {{goods_tmp}} WHERE store_id={$store_id}")->execute();
            $transaction->commit();
            $this->setFlash('success', '取消提交成功');
            $this->redirect(array('goodsImport/index'));
        } catch (CException $e) {
            $transaction->rollback();
            throw new CHttpException(403,"取消提交失败:".$e->getMessage());
        }
    }

    /**
     * 用户提交数据审核
     */
    public function actionStepReview()
    {
        $ids = Yii::app()->request->getPost('goods_id');
//        $ids = array(108);
            $connect = Yii::app()->db;
            if (is_array($ids)) {
                $config = $this->getConfig('upload');
                $store_id = $this->getSession('storeId');
                foreach ($ids as $id) {
                    $store = Store::model()->findByPk($store_id);
                    if($store->upload_total >= $config['uploadTotal'])
                    {
                        $this->setFlash('error','对不起达到今天导入最大产品数');
                        $this->redirect(array('goodsImport/stepThree'));
                    }
                    $transaction = $connect->beginTransaction();
                    try {
                        $gsql = "INSERT INTO {{goods}} (`name`,`price`,`store_id`,`type_id`,`category_id`,`scategory_id`,`gai_price`,`stock`,`publisher`,`freight_payment_type`,`freight_template_id`,`content`,`thumbnail`,`goods_spec`,`spec_name`,`create_time`,`is_publish`) SELECT
                          `name`,`price`,`store_id`,`type_id`,`category_id`,`scategory_id`,`gai_price`,`stock`,`publisher`,`freight_payment_type`,`freight_template_id`,`content`,`thumbnail`,`goods_spec`,`spec_name`,`create_time`,`is_publish` FROM {{goods_tmp}} WHERE id={$id}";
    //                    echo $gsql;
                        $connect->createCommand($gsql)->execute();
                        $goods_id = $connect->lastInsertID;
                        //移动属性 到 goods_spec中
                        $connect->createCommand()->update('{{goods_spec_tmp}}', array('goods_id'=>$goods_id),'goods_id=:id',array(':id'=>$id));
                        $ssql = "INSERT INTO {{goods_spec}} (`goods_id`,`spec_name`,`price`,`stock`,`spec_value`)  SELECT `goods_id`,`spec_name`,`price`,`stock`,`spec_value` FROM {{goods_spec_tmp}} WHERE goods_id={$goods_id}";
                        $connect->createCommand($ssql)->execute();
                        $goodsSpec_id = $connect->lastInsertID;
                        //更新goods
                        $connect->createCommand()->update('{{goods}}', array('goods_spec_id'=>$goodsSpec_id),'id=:id',array(':id'=>$goods_id));
                        
                        //移动属性都 goods_spec_index表中
                        //$connect->createCommand()->update('{{goods_spec_index_tmp}}', array('goods_id'=>$goods_id),'goods_id=:id',array(':id'=>$id));
                        //$isql = "INSERT INTO {{goods_spec_index}} SELECT * FROM {{goods_spec_index_tmp}} WHERE goods_id={$goods_id}";
                        //$connect->createCommand($isql)->execute();

                        //移动图片到goods_picture table中
                        $psql = "UPDATE {{goods_picture_tmp}} set goods_id = {$goods_id} WHERE goods_id={$id}";
                        $connect->createCommand($psql)->execute();
                        $sql = "INSERT INTO {{goods_picture}} (`path`,`goods_id`) SELECT `path`,`goods_id` FROM {{goods_picture_tmp}} WHERE goods_id={$goods_id}";
                        $connect->createCommand($sql)->execute();
                        ///逐个删除信息
                        $d_sql = "DELETE FROM {{goods_tmp}} WHERE id={$id}";
                        $connect->createCommand($d_sql)->execute();
                        $connect->createCommand("DELETE FROM {{goods_picture_tmp}} WHERE goods_id={$goods_id}")->execute();
                        //$connect->createCommand("DELETE FROM {{goods_spec_index_tmp}} WHERE goods_id={$goods_id}")->execute();
                        $connect->createCommand("DELETE FROM {{goods_spec_tmp}} WHERE goods_id={$goods_id}")->execute();
                        //导入 +1
                        $connect->createCommand("update {{store}} set upload_total=upload_total+1 where id={$store_id}")->execute();
                        $transaction->commit();
                    } catch (CException $e) {
                        $transaction->rollback();
                        $this->setFlash('error','提交审核失败');
                        $this->redirect(array('goodsImport/stepThree'));
                    }
                    unset($transaction);
                }
            }
            $this->render('stepfour');

    }
    
    protected function _getImage()
    {
        
    }
}