<?php

/**
 * 文件上传
 * @author jianlin_lin <hayeslam@163.com>
 * @example 
 * // 上传
 * $model = UploadedFile::uploadFile($model, 'thumbnail', 'logo'); // 处理上传的文件
 * UploadedFile::saveFile('thumbnail', $model->thumbnail); // 上传
 * 
 * // 更新
 * $oldFile = $model->thumbnail;
 * $model = UploadedFile::uploadFile($model, 'thumbnail', 'logo'); // 处理上传的文件
 * UploadedFile::saveFile('thumbnail', $model->thumbnail, $oldFile, true); 
 * 
 */
class UploadedFile extends CUploadedFile {

    // 上传文件属性
    static private $uploadFiles = array();
    // 保存路径属性
    static private $savePath;

    /**
     * 文件上传
     * @param object $model     AR对象
     * @param string $fileField AR对象中的文件字段
     * @param string $saveDir   保存目录可递归形式 具体查看 Tool::createDir() 方法
     * @param string $savePath  保存路径默认或路径不存在则使用 Yii::getPathOfAlias('att')
     * @param string $fileName  文件名称，默认系统生成唯一的一串字符
     * @param string $name   the name of the file input field. 当文件上传于与 AR对象中的文件字段 不一样时候使用
     * @return object
     */
    public static function uploadFile($model, $fileField, $saveDir = 'files', $savePath = null, $fileName = null,$name=null) {
        if (!isset(self::$uploadFiles[$fileField]) && empty($name)){
            self::$uploadFiles[$fileField] = CUploadedFile::getInstance($model, $fileField);
        }
        if($name){
            self::$uploadFiles[$fileField] = CUploadedFile::getInstanceByName($name);
        }
        if (self::$uploadFiles[$fileField] !== null) {
            self::$savePath[$fileField] = is_null($savePath) ? Yii::getPathOfAlias('att') : $savePath;
            if (is_null($fileName))
                $fileName = Tool::generateSalt() . '.' . self::$uploadFiles[$fileField]->getExtensionName();
            else
                $fileName = $fileName . '.' . self::$uploadFiles[$fileField]->getExtensionName();
            $model->$fileField = $saveDir . '/' . $fileName;
        }
        return $model;
    }

    /**
     * 保存文件
     * @param string $fileField AR对象中的文件字段
     * @param string $file      涵相对路径文件名称(一般为入库名称)
     * @param string $oldFile   旧文件路径，$isUpdate必须为true生效
     * @param boolean $isUpdate 是否更新，为true则执行删除旧文件
     * @return boolean
     * @throws Exception
     */
    public static function saveFile($fileField, $file, $oldFile = null, $isUpdate = false) {
        $dir = pathinfo($file, PATHINFO_DIRNAME);
        $savePath = isset(self::$savePath[$fileField]) ? self::$savePath[$fileField] : null;
        /** @var CUploadedFile $CUploadedFile */
        $CUploadedFile = isset(self::$uploadFiles[$fileField]) ? self::$uploadFiles[$fileField] : null;
        if ($CUploadedFile !== null) {
            //如果配置了远程图片服务器目录，则ftp上传到远程图片服务器
            if(UPLOAD_REMOTE){
                $ftp = Yii::app()->ftp;
                $fullPathFile = $savePath.'/'.$file;
                if(!$ftp->createDir(dirname($fullPathFile))){
                    throw new Exception('create dir error');
                }
                $ftp->put($fullPathFile,$CUploadedFile->tempName);
                if ($isUpdate === true)
                     @$ftp->delete(UPLOAD_REMOTE. $oldFile); // 删除旧文件
                return true;
            }else{
                Tool::createDir($dir, $savePath);
                $uploadResult = $CUploadedFile->saveAs($savePath . DS . $file); // 保存新文件
                if(!$uploadResult){
                    throw new Exception('save file error');
                }
                if ($isUpdate === true)
                    @unlink($savePath . DS . $oldFile); // 删除旧文件
                return $savePath . DS . $file;
            }
        }
        return false;
    }

    /**
     * 删除文件
     *
     * @param string $file
     * @return bool
     */
    public static function delete($file){
        $file = str_replace('\\','/',$file);
        if(UPLOAD_REMOTE){
            return @Yii::app()->ftp->delete($file);
        }else{
            return @unlink($file);
        }
    }

    /**
     * 创建目录
     * @param string $dir
     * @return bool
     */
    public static function mkdir($dir){
        $dir = str_replace('\\','/',$dir);
        if(UPLOAD_REMOTE){
            return Yii::app()->ftp->createDir($dir);
        }else{
            $result = mkdir($dir);
            chmod($dir, 0777);
            return $result;
        }
    }

    /**
     * 判断文件是否存在
     * @param $file
     * @return bool
     */
    public static function file_exists($file)
    {
        $file = str_replace('\\','/',$file);
        if(UPLOAD_REMOTE){
            return Yii::app()->ftp->size($file) > 0 ? true : false;
        }else{
            return file_exists($file);
        }
    }

    /**
     * 上传普通文件，必须是完整路径
     * @param string $local  本地文件 
     * @param string $remote 上传路径
     * @param string $deleteDir 删除文件路径
     * @return boolean 
     */
    public static function upload_file($local,$remote,$deleteDir='',$pathAlias = 'att')
    {
        if($local && $remote){
            if (UPLOAD_REMOTE) {
                $ftp = Yii::app()->ftp;
                $remote = Yii::getPathOfAlias($pathAlias).'/'.$remote;
                if(!$ftp->createDir(dirname($remote))) {
                    throw new Exception('create dir error');
                }
                if (!empty($deleteDir)) {
                   @$ftp->delete($deleteDir);
                }
                $ftp->put($remote,$local);
            }else {
                $path = str_replace('\\', '/', Yii::getPathOfAlias($pathAlias));
                $filename = $path . '/' . $remote;
                Tool::createDir(dirname($remote),$path);
                if(!move_uploaded_file($local, $filename)){
                    throw new Exception('保存文件失败');
                }
                if (!empty($deleteDir)) {
                    @unlink($deleteDir);
                }
            }
            return true;
        }
        return false;
    }
    /**
     * 
     * @param string $url 淘宝图片URL
     * @param string $save_path 保存路径
     * @return boolean
     * @throws Exception
     */
    public static function import($url,$save_path,$pathAlias='uploads')
    {
        //兼容FTP和本地上传
        if(UPLOAD_REMOTE)
        {
            $ftp = Yii::app()->ftp;
//            echo Yii::getPathOfAlias('att');
            $path = str_replace('\\', '/', Yii::getPathOfAlias('uploads'));
//            echo $path;exit;
            if (!$ftp->createDir(dirname($path.'/'.$save_path))) {
                throw new Exception('create dir error');
            }
            @$ftp->put('/'.$path.'/'.$save_path, $url);
            return IMG_DOMAIN . '/' . $save_path;
        } else {
            $path = str_replace('\\', '/', Yii::getPathOfAlias('uploads'));
            Tool::createDir(dirname($save_path),$path);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0); 
            curl_setopt($ch,CURLOPT_URL,$url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $file_content = curl_exec($ch);
            curl_close($ch);

            $downloaded_file = fopen($path.'/'.$save_path, 'w');
            fwrite($downloaded_file, $file_content);
            fclose($downloaded_file); 
            return IMG_DOMAIN . '/' . $save_path;
        }
    }
}
