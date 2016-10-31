<?php

class TmpController extends Controller {

    public function actionCreateIndex(){
        $url = 'http://www.gatewang.com';

        $path= Yii::getPathOfAlias('root');

        $path = $path.DS.'frontend'.DS.'www'.DS;

        $str =file_get_contents($url);

        file_put_contents($path.'index.html', $str);
        echo 'ok';
    }
}

