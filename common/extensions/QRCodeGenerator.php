<?php

/**
 * 二维码生成
 *
 * @example
<?php $this->widget('comext.QRCodeGenerator',array(
'data' => '优酷网址:http://www.youku.com',
'matrixPointSize' => 5,
)) ?>
 * @author zhenjun_xu <412530435@qq.com>
 */

class QRCodeGenerator extends CWidget
{


    /**
     * @var string 二维码文字内容
     */
    public $data = DOMAIN;

    /**
     * @var null 生成的文件名，默认使用 md5($this->data.$this->size). '.png';
     */
    public $filename = null;

    /**
     * @var string 二维码图片保存的绝对路径
     */
    public $filePath;

    /**
     * @var string 二维码图片保存的相对地址
     */
    public $fileUrl;
    /**
     * @var bool|string 二维码图片保存的二级文件夹名
     */
    public $subfolderVar = false;

    /**
     * 误差校正水平
     */
    public $errorCorrectionLevel = 'L';
    /**
     * @var int 二维码距离图片的边距，单位是像素
     */
    public $matrixPointSize = 0;

    /**
     * @var int 二维码图片大小，1 = 30px
     */
    public $size = 4;

    /**
     * @var bool 是否显示图片，默认使用 CHtml::image，否则echo $this->fileUrl
     */
    public $displayImage = true;
    /**
     * @var array 图片参数
     */
    public $imageTagOptions = array();

    /**
     * @var 最终显示图片的url
     */
    private $fullUrl;

    public function init()
    {

        if (is_null($this->filename)) {
            $this->filename = md5($this->data.$this->size). '.png';
        }

        if (!$this->filePath) {
            $this->filePath = Yii::getPathOfAlias('root').'/../source/attachments/QRCode';
        }

        if (!is_dir($this->filePath)) {
			try {
				mkdir($this->filePath);
			}catch(Exception $e) {
				throw new CHttpException(500, "{$this->filePath} 目录不存在");
			}
        	
        } else if (!is_writable($this->filePath)) {
            throw new CHttpException(500, "{$this->filePath} 不可写");
        }

        if (!isset($this->fileUrl)) {
            $this->fileUrl = ATTR_DOMAIN . '/QRCode';
        }

        if (!in_array($this->errorCorrectionLevel, array('L', 'M', 'Q', 'H')))
            throw new CException('误差校正水平只能是 L,M,Q,H');

        $this->matrixPointSize = min(max((int)$this->matrixPointSize, 1), 10);

        if (is_string($this->subfolderVar)) {
            $subFolder = $this->filePath . '/' . $this->subfolderVar;
            if (!is_dir($subFolder)) {
                mkdir($subFolder);
            }
            $this->filePath = $this->filePath . '/' . $this->subfolderVar;
            $this->fileUrl = $this->fileUrl . '/' . $this->subfolderVar;
        }
        $this->filePath = $this->filePath . '/' . $this->filename;
        $this->fullUrl = $this->fileUrl . '/' . $this->filename;
    }

    public function run()
    {
        include Yii::getPathOfAlias('comvendor') . '/EvaThumber/vendor/autoload.php';
        if(!UploadedFile::file_exists($this->filePath)){
            PHPQRCode\QRcode::png($this->data, $this->filePath, $this->errorCorrectionLevel, $this->size, $this->matrixPointSize, false);
            if(UPLOAD_REMOTE){
                $ftp = Yii::app()->ftp;
                $dirName = str_replace('\\','/',Yii::getPathOfAlias('att').'/QRCode/');
                $ftp->createDir($dirName);
                $ftp->put($dirName.basename($this->filePath),$this->filePath);
                @unlink($this->filePath);
            }
        }
        if ($this->displayImage === true) {
            echo CHtml::image($this->fullUrl, $this->data, $this->imageTagOptions);
        } else {
            echo $this->fullUrl;
        }
    }
}
