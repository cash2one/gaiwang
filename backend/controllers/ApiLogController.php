<?php

/**
 * 查看api接口日志控制器(临时)
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class ApiLogController extends Controller {
    public function actionLook() {
        $fileName = $this->getParam('file','apiLog');
        $root = Yii::getPathOfAlias('root');
        $path = $root . DS . 'backend' . DS . 'runtime' . DS . $fileName;
        if(file_exists($path)){
            $content = file_get_contents($path);
            echo $path.str_replace("\r\n", "<br />", $content);
        }else{
            die($path.' is not exists.');
        }
    }
    public function actionDel() {
        $fileName = $this->getParam('file');
        if($fileName){
            $root = Yii::getPathOfAlias('root');
            $path = $root . DS . 'backend' . DS . 'runtime' . DS . $fileName;
            @unlink($path);
            echo "success";
        }else{
            echo "input file=";
        }
        
    }
    
    public function actionTestLogin() {
        include_once(Yii::getPathOfAlias('root').DS.'api'.DS.'components'.DS.'RSA.php');
        include_once(Yii::getPathOfAlias('root').DS.'api'.DS.'config'.DS.'main.php');
        $r = new RSA();
        $un = $r->encrypt('yangming');
        $psw = $r->encrypt('123456');
        $String = <<<XML
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title></title><link href='Styles/Site.css' rel='stylesheet' type='text/css' />
</head>
<body>
<form method='post' action='http://api.<?php echo SHORT_DOMAIN ?>/login' id='ctl01' >
<input type='hidden' name='UserName' value='$un'/>
<input type='hidden' name='Pwd' value='$psw'/>

<input type='submit' value='go'/>
</form>
</body>
XML;
        echo $String;
    }

    public function actionTest(){
        error_reporting(1);
        $code = $this->getParam('code');
        include_once(Yii::getPathOfAlias('root').DS.'api'.DS.'components'.DS.'RSA.php');
        include_once(Yii::getPathOfAlias('root').DS.'api'.DS.'config'.DS.'main.php');
        $r = new RSA();
        $encode = $r->encrypt('yangming,123456,'.$code);
        $String = <<<XML
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title></title><link href='Styles/Site.css' rel='stylesheet' type='text/css' />
</head>
<body>
<form method='post' action='http://api.<?php echo SHORT_DOMAIN; ?>/order/build' id='ctl01' >
<input type='hidden' name='Code' value='$encode'/>
<input type='hidden' name='ReceivePhone' value='56466413'/>
<input type='hidden' name='ReceiveAddr' value='china gz'/>

<input type='hidden' name='ReceiveName' value='hao'/>
<input type='hidden' name='ReceiveDistrictID' value='2315'/>
<input type='hidden' name='ReceiveCityID' value='237'/>
<input type='hidden' name='ReceiveProvinceID' value='22'/>

<input type='hidden' name='GoodsID1' value='82'/>
<input type='hidden' name='Price1' value='570.0'/>
<input type='hidden' name='Count1' value='1'/>

<input type='hidden' name='GoodsID2' value='25590'/>
<input type='hidden' name='Price2' value='570.0'/>
<input type='hidden' name='Count2' value='2'/>

<input type='submit' value='go'/>
</form>
</body>
XML;
        echo $String;
    }
}
