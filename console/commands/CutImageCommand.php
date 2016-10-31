<?php

/**
 * 测试裁剪图片
 */
class CutImageCommand extends CConsoleCommand {

    public function actionIndex() {
        echo 'root : ' . Yii::getPathOfAlias('root') . "\n";
        echo 'common : ' . Yii::getPathOfAlias('common') . "\n";
        echo 'comext : ' . Yii::getPathOfAlias('comext') . "\n";
        echo 'uploads : ' . Yii::getPathOfAlias('uploads') . "\n";
    }

    /**
     * 生成135*135的缩略图
     */
    public function actionCut() {
        ini_set('memory_limit', '2048M');
        $imgDir = Yii::getPathOfAlias('uploads');
        $dstDir = $imgDir . DS . '135x135'; //缩略图保存目录
        if (!file_exists($dstDir)) {
            mkdir($dstDir, 0777, true);
        }
//        $dstDir = str_replace('\\', '/', $dstDir);
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}}');
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $v) {
            $imgFile = substr($v['thumbnail'], 0, strrpos($v['thumbnail'], '/') + 1);
//            echo $imgFile."\n";
            if (!file_exists($dstDir . DS . $imgFile)) {
                self::createDir($imgFile, $dstDir);
            }
            $srcFile = $imgDir . DS . $v['thumbnail']; //原图片
            $dstFile = $dstDir . DS . $v['thumbnail']; //缩略图
            self::img2thumb($srcFile, $dstFile, 135, 135, 1, 0);
        }
    }

    /**
     * 生成60*60的缩略图
     */
    public function actionCut60() {
        ini_set('memory_limit', '2048M');
        $imgDir = Yii::getPathOfAlias('uploads');
        $dstDir = $imgDir . DS . '60x60'; //缩略图保存目录
        if (!file_exists($dstDir)) {
            mkdir($dstDir, 0777, true);
        }
//        $dstDir = str_replace('\\', '/', $dstDir);
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}}');
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $v) {
            $imgFile = substr($v['thumbnail'], 0, strrpos($v['thumbnail'], '/') + 1);
//            echo $imgFile."\n";
            if (!file_exists($dstDir . DS . $imgFile)) {
                self::createDir($imgFile, $dstDir);
            }
            $srcFile = $imgDir . DS . $v['thumbnail']; //原图片
            $dstFile = $dstDir . DS . $v['thumbnail']; //缩略图
            self::img2thumb($srcFile, $dstFile, 60, 60, 1, 0);
        }
    }

    /**
     * 生成90*90的缩略图
     */
    public function actionCut90() {
        ini_set('memory_limit', '2048M');
        $imgDir = Yii::getPathOfAlias('uploads');
        $dstDir = $imgDir . DS . '90x90'; //缩略图保存目录
        if (!file_exists($dstDir)) {
            mkdir($dstDir, 0777, true);
        }
//        $dstDir = str_replace('\\', '/', $dstDir);
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}}');
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $v) {
            $imgFile = substr($v['thumbnail'], 0, strrpos($v['thumbnail'], '/') + 1);
//            echo $imgFile."\n";
            if (!file_exists($dstDir . DS . $imgFile)) {
                self::createDir($imgFile, $dstDir);
            }
            $srcFile = $imgDir . DS . $v['thumbnail']; //原图片
            $dstFile = $dstDir . DS . $v['thumbnail']; //缩略图
            self::img2thumb($srcFile, $dstFile, 90, 90, 1, 0);
        }
    }

    /**
     * 生成400*380的缩略图
     */
    public function actionCut400() {
        ini_set('memory_limit', '2048M');
        $imgDir = Yii::getPathOfAlias('uploads');
        $dstDir = $imgDir . DS . '400x380'; //缩略图保存目录
        if (!file_exists($dstDir)) {
            mkdir($dstDir, 0777, true);
        }
//        $dstDir = str_replace('\\', '/', $dstDir);
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}}');
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $v) {
            $imgFile = substr($v['thumbnail'], 0, strrpos($v['thumbnail'], '/') + 1);
//            echo $imgFile."\n";
            if (!file_exists($dstDir . DS . $imgFile)) {
                self::createDir($imgFile, $dstDir);
            }
            $srcFile = $imgDir . DS . $v['thumbnail']; //原图片
            $dstFile = $dstDir . DS . $v['thumbnail']; //缩略图
            self::img2thumb($srcFile, $dstFile, 400, 380, 1, 0);
        }
    }

    /**
     * 生成170*170的缩略图
     */
    public function actionCut170() {
        ini_set('memory_limit', '2048M');
        $imgDir = Yii::getPathOfAlias('uploads');
        $dstDir = $imgDir . DS . '170x170'; //缩略图保存目录
        if (!file_exists($dstDir)) {
            mkdir($dstDir, 0777, true);
        }
//        $dstDir = str_replace('\\', '/', $dstDir);
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}} order by id asc limit 2500');
        $command->execute();
        $reader = $command->query();
        $file = 'cut170.txt';
        $handle = fopen($file, 'ab');
        foreach ($reader as $v) {
            $imgFile = substr($v['thumbnail'], 0, strrpos($v['thumbnail'], '/') + 1);
//            echo $imgFile."\n";
            if (!file_exists($dstDir . DS . $imgFile)) {
                self::createDir($imgFile, $dstDir);
            }
            $srcFile = $imgDir . DS . $v['thumbnail']; //原图片
            $dstFile = $dstDir . DS . $v['thumbnail']; //缩略图
            fwrite($handle, $v['id'] . "\r\n");
            self::img2thumb($srcFile, $dstFile, 170, 170, 1, 0);
        }
    }

    public static function actionTest() {
        $command = Yii::app()->db->createCommand('select id,thumbnail from {{goods}}');
        $command->execute();
        $reader = $command->query();
        $file = 'cutImg.txt';
        $handle = fopen($file, 'ab');
        foreach ($reader as $v) {
            fwrite($handle, $v['id'] . "\r\n");
//            echo $v['thumbnail'].'/n';
        }
    }

    /**
     * 生成缩略图
     * @param type $src_img 原图
     * @param type $dst_img 保存目标图
     * @param type $width 生成的宽
     * @param type $height 生成的高
     * @param type $cut 是否裁剪
     * @param type $proportion 是否按比例
     * @return boolean
     */
    public static function img2thumb($src_img, $dst_img, $width = 135, $height = 135, $cut = 0, $proportion = 0) {
        if (!is_file($src_img) && !file_exists($src_img)) {
            return false;
        }
        $ot = self::fileext($dst_img);
//        $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
//        if ($ot == 'jpg') {
//            $otfunc = 'imagejpeg';
//        } elseif ($ot == 'png') {
//            $otfunc = 'imagepng';
//        } elseif ($ot == 'gif') {
//            $otfunc = 'imagegif';
//        }

        $srcinfo = getimagesize($src_img);
        if (!$srcinfo) {
            return false;
        }
        $src_w = $srcinfo[0];
        $src_h = $srcinfo[1];
        $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
//        if (in_array($type, array('jpeg,jpg,png,gif'))) {
//                
//        }
//        echo 'ddd';
        if ($type == 'jpg') {
            $createfun = 'imagecreatefromjpeg';
        } elseif ($type == 'bmp') {
            return false;
        } else {
            $createfun = 'imagecreatefrom' . $type;
        }

        $dst_h = $height;
        $dst_w = $width;
        $x = $y = 0;

        /**
         * 缩略图不超过源图尺寸（前提是宽或高只有一个）
         */
        if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
            $proportion = 1;
        }
        if ($width > $src_w) {
            $dst_w = $width = $src_w;
        }
        if ($height > $src_h) {
            $dst_h = $height = $src_h;
        }

        if (!$width && !$height && !$proportion) {
            return false;
        }
        if (!$proportion) {
            if ($cut == 0) {
                if ($dst_w && $dst_h) {
                    if ($dst_w / $src_w > $dst_h / $src_h) {
                        $dst_w = $src_w * ($dst_h / $src_h);
                        $x = 0 - ($dst_w - $width) / 2;
                    } else {
                        $dst_h = $src_h * ($dst_w / $src_w);
                        $y = 0 - ($dst_h - $height) / 2;
                    }
                } else if ($dst_w xor $dst_h) {
                    if ($dst_w && !$dst_h) {  //有宽无高
                        $propor = $dst_w / $src_w;
                        $height = $dst_h = $src_h * $propor;
                    } else if (!$dst_w && $dst_h) {  //有高无宽
                        $propor = $dst_h / $src_h;
                        $width = $dst_w = $src_w * $propor;
                    }
                }
            } else {
                if (!$dst_h) {  //裁剪时无高
                    $height = $dst_h = $dst_w;
                }
                if (!$dst_w) {  //裁剪时无宽
                    $width = $dst_w = $dst_h;
                }
                $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
                $dst_w = (int) round($src_w * $propor);
                $dst_h = (int) round($src_h * $propor);
                $x = ($width - $dst_w) / 2;
                $y = ($height - $dst_h) / 2;
            }
        } else {
            $proportion = min($proportion, 1);
            $height = $dst_h = $src_h * $proportion;
            $width = $dst_w = $src_w * $proportion;
        }
        $src = '';
        if ($type == 'jpg') {
            $src = imagecreatefromjpeg($src_img);
        } elseif ($type == 'gif') {
            $src = imagecreatefromgif($src_img);
        } elseif ($type == 'png') {
            $src = imagecreatefrompng($src_img);
        } elseif ($type == 'jpeg') {
            $src = imagecreatefromjpeg($src_img);
        }
//        echo $src;
//            $src = $createfun($src_img);
        $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        if (function_exists('imagecopyresampled')) {
            $f = @imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            if (!$f)
                return false;
        } else {
            $f = @imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            if (!$f)
                return false;
        }
//            $otfunc($dst, $dst_img);
        if ($ot == 'jpg') {
            @imagejpeg($dst, $dst_img);
        } elseif ($ot == 'png') {
            @imagepng($dst, $dst_img,7);
        } elseif ($ot == 'gif') {
            @imagegif($dst, $dst_img);
        } elseif ($ot == 'jpeg') {
            @imagejpeg($dst, $dst_img);
        }
        imagedestroy($dst);
        @imagedestroy($src);
        return true;
    }

    /**
     * 后缀名
     * @param type $filename
     * @return type
     */
    public static function fileext($filename) {
        $file = $filename;
        $res = pathinfo($file);
        $ext = $res['extension'];
        return $ext;
    }

    public static function createDir($path, $webroot = null) {
        $path = preg_replace('/\/+|\\+/', DS, $path);
        $dirs = explode(DS, $path);
        if (!is_dir($webroot))
            $webroot = Yii::getPathOfAlias('webroot');
        foreach ($dirs as $element) {
            $webroot .= DS . $element;
            if (!is_dir($webroot)) {
                if (!mkdir($webroot, 0777))
                    return false;
                else
                    chmod($webroot, 0777);
            }
        }
        return true;
    }

}

?>
