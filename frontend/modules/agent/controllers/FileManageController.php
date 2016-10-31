<?php
/**
 * 文件上传
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class FileManageController extends Controller{
	/**
	 * 显示上传控件
	 */
	public function actionIndex()
	{
		$this->layout = "left";
		
		$height = $_GET['height'];		//上传图片设定的高度
		$width = $_GET['width'];		//上传图片设定的宽度
		$classify = $_GET['classify'];	//图片类型
		$model = new FileManageAgent();
		
		$model->unsetAttributes();
		$model->classify = $classify;
		$model->height = $height;
		$model->width = $width;
		
		if(isset($_GET['FileManage'])){
            $model->attributes=$_GET['FileManage'];
        }
        
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 图片上传的方法
	 */
	public function actionUpload(){
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		} else if (isset($_GET["PHPSESSID"])) {
			session_id($_GET["PHPSESSID"]);
		}
		
		$classify = FileManageAgent::FILETYPE_PD;			//带用到文件model
		
		$upload_height = $_POST['HEIGHT'];
		$upload_width = $_POST['WIDTH'];
		
		
        if(!self::valiFileRightSize($upload_height,$upload_width))exit(0);
               
		if(!self::valiFileSize())exit(0);				//验证尺寸，这里实际上是是否超出php设定大小
		
		if(!self::valiFileUpload())exit(0);				//验证上传

        if(!self::valiFileLaw())exit(0);				//验证合法
              
		if(!self::valiFileBig())exit(0);				//验证大小
		
		if(!self::valiFileName())exit(0);				//验证文件名称
		
		$path_info = pathinfo($_FILES[FileManageAgent::FILE_UPLOAD_NAME]['name']);
		$file_extension = $path_info["extension"];
		if(!self::valiFileExt($file_extension))exit(0);	//验证文件扩展名
		
		$fileName = md5(date('Ymd').rand(FileManageAgent::NAMERANDMIN, FileManageAgent::NAEMRANDMAX)).".".$file_extension;
		
		if (UPLOAD_REMOTE_GT) {		//如果开启了FTP图片服务器
			$ftp = Yii::app()->gtftp;
			
			$save_path = str_replace("\\","/",Yii::getPathOfAlias('upload').DS.FileManageAgent::FILE_TMP_PATH.DS);
			
			if(!$ftp->createDir($save_path)) self::HandleError('fai:文件夹创建失败|');
            $file = str_replace("\\","/",$save_path.$fileName);
            $result = $ftp->put($file,$_FILES[FileManageAgent::FILE_UPLOAD_NAME]["tmp_name"]);
            if (!$result){
            	self::HandleError("fai:文件移动失败|");
            	exit(0);
            }
		} else {			//兼容旧的，本机或者未开启FTP服务器
			$imgpath= Yii::getPathOfAlias('uploads').DS.FileManageAgent::FILE_TMP_PATH.DS;  //图片保存的路径
			$save_path = str_replace('\\','/',$imgpath);
			
			//创建目录
			if(!self::create_folders($save_path)){
				self::HandleError("fai:文件夹创建失败|");
				exit(0);
			}
			
			if(!move_uploaded_file($_FILES[FileManageAgent::FILE_UPLOAD_NAME]["tmp_name"], $save_path.$fileName)) {
				self::HandleError("fai:文件移动失败|");
				exit(0);
		 	}
		}
        $imgMain = UPLOAD_REMOTE_GT ? GT_IMG_DOMAIN : IMG_DOMAIN;
        
        $randnum = rand(1000, 9999);					//随机码的目的是为了后来删除缓存数据
//	 		self::HandleError("suc:".$fileName."->,".$randnum."->,".FileManageAgent::TMP_FILE_HOST."/".FileManageAgent::FILE_TMP_PATH."/->,".$save_path.$fileName."|");
        self::HandleError("suc:".$fileName."->,".$randnum."->,".$imgMain."/".FileManageAgent::FILE_TMP_PATH."/->,".$save_path.$fileName."|");

        
        $newCacheData = array(			//本次缓存数据
            'filename' => $path_info['basename'],						//上传时候的文件名称
            'path' => $imgMain."/".FileManageAgent::FILE_TMP_PATH.'/'.$fileName,			//临时文件路径(网络路径)
            'localpath' => $save_path.$fileName,
            'randnum' => $randnum,
        	'width' => $upload_width,
        	'height' => $upload_height,
        );
        $cache_name = FileManageAgent::FILE_NAME.$this->getUser()->getId();	//获取会员缓存数据代号
        $cache_data = Yii::app()->fileCache->get($cache_name);				//根据代号获取会员缓存数据
        $cache_data[$randnum] = $newCacheData;								//将新的缓存数据加入
        Yii::app()->fileCache->set($cache_name, $cache_data, 60*30);		//重写缓存
        exit(0);

	}
	
	/**
	 * 选择图片的时候，如果是选择的是临时图片，那么就进行移动
	 */
	public function actionSure(){
		$imgdata =$_POST['imgdata'];
		$classify = $_GET['classify'];
		$imgs = explode("||", $imgdata);
		
		$imgsData = array();
		
		//移动图片并且保存数据
		foreach ($imgs as $img){		//每个循环对象里面有两个值，图片url和id
			if (empty($img))continue;
			$imgarr = explode(",", $img);
			if(count($imgarr)==4){					//表示选中的是临时图片,里面数据有(图片显示路径,图片本来的名称,缓存随机数,本地路径)
				//获取缓存数据
				$cache_name = FileManageAgent::FILE_NAME.$this->getUser()->getId();
				$cache_imgpaths = Yii::app()->fileCache->get($cache_name);
				$imgData = $cache_imgpaths[$imgarr[2]];
				
				//先进行图片上传
				$arr = explode(".", $imgarr[1]);
				
				if (UPLOAD_REMOTE_GT){	//如果开启了ftp图片服务器上传
                	//这里就需要保存数据
                	$model = new FileManageAgent();
                	
					$model->height = $imgData['height'];							//表中高
					$model->width = $imgData['width'];								//表中宽
					
					$replaceDir = date('Y').DS.date('m').DS.date('d');
					$oldImgPath= str_replace('\\','/','/uploads'.str_replace(GT_IMG_DOMAIN,"", $imgarr[0]));  //图片保存的的临时路径  /uploads/tmp/18ec4dd1545fd5d57b76833fa7f597c1.jpg
            		$newpath = str_replace('\\','/',str_replace(FileManageAgent::FILE_TMP_PATH, $replaceDir, $oldImgPath));//  /uploads/2014/08/21//18ec4dd1545fd5d57b76833fa7f597c1.jpg
            		
					$model->setAttribute('path',$newpath);			//表中路径
					
		                
					//得到后缀名和上传时候图片的名称
					$suffix = array_pop($arr);
					$model->setAttribute('filename', implode(".",$arr));		//表中名称
					$model->setAttribute('suffix', $suffix);					//表中后缀名
					
					//得到(名称)和类型
					$model->setAttribute('classify', $classify);
					$model->setAttribute('user_id',Yii::app()->user->id);
					
					$ftp = Yii::app()->gtftp;
					//服务器上面创建文件夹
                	if(!$ftp->createDir(dirname($newpath))) self::HandleError('fai:create dir error|');
                	
                	$result = $ftp->rename($oldImgPath,$newpath);
                	
                	if (!$result){
                		self::HandleError("fai:图片移动失败|");
                		exit(0);
                	}
					
					if($model->save(false)){
						$reData = array(
							'id' => $model->id,
							'path' => $model->path,
						);
					}else{
						self::HandleError("fai:图片记录保存失败|");
						exit(0);
					}
				} else {			//这个是为了兼容本地测试需要的
					$data = array(FileManageAgent::FILE_UPLOAD_NAME =>'@'.$imgarr[3],'name'=>$arr[0],'classify'=>$classify,'height'=>$imgData['height'],'width'=>$imgData['width']);
					$uploadRes = self::curl(GT_DOMAIN."/api/filemanage/upload",$data);
					
					if(empty($uploadRes))break;				//退出循环
					
					@unlink($imgarr[3]);					//删除商城的文件
					$reData = CJSON::decode($uploadRes);	//获取CURL访问返回数据
				}
					
				//清楚对应缓存记录
				unset($cache_imgpaths[$imgarr[2]]);
				Yii::app()->fileCache->set($cache_name, $cache_imgpaths, 60*30);
				
				$imgsData[] = array(
					'id' => $reData['id'],
					'realpath' => GT_IMG_DOMAIN.str_replace("/".FileManageAgent::FILE_BASE_PATH, "", $reData['path']),
				);
			}else{//已经存在服务器上的图片，内容（图片显示路径路径,图片id,保存到图片表里面的数据）
				$imgsData[] = array(
					'id' => $imgarr[1],
					'realpath' => $imgarr[0],
				);
			}
		}
		echo json_encode($imgsData);
	}
	
	/**
	 * 验证是否是指定尺寸
	 * @param int $height
	 * @param int $width
	 */
	public function valiFileRightSize($upload_height,$upload_width){
		$upload_name = FileManageAgent::FILE_UPLOAD_NAME;
		if($upload_height==0&&$upload_width==0)return true;
		list($width,$height,$type,$attr) = getimagesize($_FILES[$upload_name]['tmp_name']);
//		if($upload_height*$width==$upload_width&$height)return true;
	 	if($upload_width==$width && $upload_height== $height){
	 		return true;
	  	}
  		self::HandleError("fai:上传图片不是指定尺寸|");
  		return false;
	}
	
	/**
	 * 验证上传
	 */
	public function valiFileUpload(){
		$upload_name = FileManageAgent::FILE_UPLOAD_NAME;
		if (!isset($_FILES[$upload_name])) {
			self::HandleError("fai:没有发现上传 \$_FILES for " . $upload_name . "|");
			return false;
		} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
			self::HandleError(FileManageAgent::getUploadError($_FILES[$upload_name]["error"]));
			return false;
		} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
			self::HandleError("fai:Upload failed is_uploaded_file test.");
			return false;
		} else if (!isset($_FILES[$upload_name]['name'])) {
			self::HandleError("fai:文件没有名字|");
			return false;
		}
		return true;
	}
	
	/**
	 * 验证文件
	 */
	public function valiFileSize(){
		//检验post的最大上传的大小
		$POST_MAX_SIZE = ini_get('post_max_size');
		$unit = strtoupper(substr($POST_MAX_SIZE, -1));
		$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));
	
		if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
			self::HandleError("fai:超过最大允许的尺寸|");
			return false;
		}
		return true;
	}
	
	/**
	 * 验证合法
	 * 当不是一张合法图片时，$width、$height、$type、$attr 的值就全都为空，以此来判断图片的真实
	 */
	public static function valiFileLaw(){
		$upload_name = FileManageAgent::FILE_UPLOAD_NAME;
		list($width,$height,$type,$attr) = getimagesize($_FILES[$upload_name]['tmp_name']);
	 	if(empty($width) || empty($height) || empty($type) || empty($attr)){
	  		self::HandleError("fai:上传图片为非法内容|");
	  		return false;
	  	}
	  	return true;
	}
	
	/**
	 * 验证大小
	 * 警告:最大的文件支持这个代码2 GB
	 */
	public static function valiFileBig(){
		$upload_name = FileManageAgent::FILE_UPLOAD_NAME;
		$max_file_size_in_bytes = 2147483647;				// 2GB in bytes 最大上传的文件大小为2G
		$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			self::HandleError("fai:超过最高允许的文件的大小|");
			return false;
		}
		
		if ($file_size <= 0) {
			self::HandleError("fai:超出文件的最小大小|");
			return false;
		}
		return true;
	}
	
	/**
	 * 验证文件名称
	 */
	public static function valiFileName(){
		$upload_name = FileManageAgent::FILE_UPLOAD_NAME;
		$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-'; //允许在文件名字符(在一个正则表达式格式)
		$MAX_FILENAME_LENGTH = 260;
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			self::HandleError("fai:无效的文件|");
			return false;
		}	
		return true;
	}
	
	/**
	 * 验证文件扩展名
	 */
	public static function valiFileExt($ext){
		$is_valid_extension = false;
		$extension_whitelist = FileManageAgent::getFileType();	// 上传允许的文件扩展名称
		foreach ($extension_whitelist as $extension) {
			if (strcasecmp($ext, $extension) == 0) {
				$is_valid_extension = true;
				break;
			}
		}
		if (!$is_valid_extension){
			self::HandleError("fai:无效的扩展名|");
			return false;
		}
		return true;
	}
	
	/**
	 * 判断是否存在目录，不存在递归创建目录
	 */
	public static function create_folders($dir){ 
		return is_dir($dir) or (self::create_folders(dirname($dir)) and mkdir($dir, 0777));
	}
     
	/**
	 * 输出信息
	 * @param unknown_type $message
	 */
	public static function HandleError($message) {
		echo $message;
	}
	
	/**
	 * http访问上传图片
	 */
	public static function curl($url, $postFields = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //https 请求
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields))
        {
                $postBodyString = "";
                $postMultipart = false;
                foreach ($postFields as $k => $v)
                {
                        if("@" != substr($v, 0, 1))//判断是不是文件上传
                        {
                                $postBodyString .= "$k=" . urlencode($v) . "&"; 
                        }
                        else//文件上传用multipart/form-data，否则用www-form-urlencoded
                        {
                                $postMultipart = true;
                        }
                }
                unset($k, $v);
                curl_setopt($ch, CURLOPT_POST, true);
                if ($postMultipart)
                {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                }
                else
                {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
                }
        }
        $reponse = curl_exec($ch);
        
        if (curl_errno($ch))
        {
                throw new Exception(curl_error($ch),0);
        }
        else
        {
                $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if (200 !== $httpStatusCode)
                {
                        throw new Exception($reponse,$httpStatusCode);
                }
        }
        curl_close($ch);
        return $reponse;
	}
}
