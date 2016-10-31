<?php

/**
 * curl 获取google 翻译，非api方式
 * Google Translate PHP class
 *
 * @author      Levan Velijanashvili <me@stichoza.com>
 * @link        http://stichoza.com/
 * @version     1.3.0
 * @access      public
 */
class GoogleTranslate {

    /**
     * Last translation
     * @var string
     * @access private
     */
    public $lastResult = "";

    /**
     * Language translating from
     * @var string
     * @access private
     */
    private $langFrom;

    /**
     * Language translating to
     * @var string
     * @access private
     */
    private $langTo;

    /**
     * Google Translate URL format
     * @var string
     * @access private
     */
//    private static $urlFormat = "http://translate.google.com/translate_a/t?client=t&text=%s&hl=en&sl=%s&tl=%s&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";
    private static $urlFormat = "http://203.208.37.3/translate_a/t?client=t&text=%s&hl=en&sl=%s&tl=%s&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";

    /**
     * Class constructor
     *
     * @param string $from Language translating from (Optional)
     * @param string $to Language translating to (Optional)
     * @access public
     */
    public function __construct($from = "en", $to = "ka") {
        $this->setLangFrom($from)->setLangTo($to);
    }

    /**
     * Set language we are transleting from
     *
     * @param string $from Language code
     * @return GoogleTranslate
     * @access public
     */
    public function setLangFrom($lang) {
        $this->langFrom = $lang;
        return $this;
    }

    /**
     * Set language we are transleting to
     *
     * @param string $to Language code
     * @return GoogleTranslate
     * @access public
     */
    public function setLangTo($lang) {
        $this->langTo = $lang;
        return $this;
    }


    /**
     * Simplified curl method
     * @param string $url URL
     * @param array $params Parameter array
     * @param boolean $cookieSet
     * @return string
     * @access public
     */
    public static final function makeCurl($url, array $params = array(), $cookieSet = false) {
        if (!$cookieSet) {
            $cookie = tempnam(sys_get_temp_dir(), "CURLCOOKIE");
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);

            // Clean up temporary file
            unset($ch);
            unlink($cookie);

            return $output;
        }

        $queryString = http_build_query($params);

        $curl = curl_init($url . "?" . $queryString);
//        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);

        return $output;
    }

    /**
     * Translate text
     *
     * @param string $string Text to translate
     * @return string/boolean Translated text
     * @access public
     */
    public function translate($string) {
        return $this->lastResult = self::staticTranslate($string, $this->langFrom, $this->langTo);
    }

    /**
     * Static method for translating text
     *
     * @param string $string Text to translate
     * @param string $from Language code
     * @param string $to Language code
     * @return string/boolean Translated text
     * @access public
     */
    public static function staticTranslate($string, $from, $to) {
        $domain = '';
        $domain = 'translate.google.cn';
//        $domain = 'translate.google.com';
//        $domain = 'translate.google.com.hk';
//        $domain = '203.208.37.3';
        $urlFormat = "http://".$domain."/translate_a/t?client=t&text=%s&hl=en&sl=%s&tl=%s&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";
        $url = sprintf($urlFormat, rawurlencode($string), $from, $to);
//        $url = sprintf(self::$urlFormat, rawurlencode($string), $from, $to);
        $result = preg_replace('!,+!', ',', self::makeCurl($url)); // remove repeated commas (causing JSON syntax error)
        $resultArray = json_decode($result, true);
        $finalResult = "";
        if (!empty($resultArray[0])) {
            foreach ($resultArray[0] as $results) {
                $finalResult .= $results[0];
            }
            return $finalResult;
        }

        return false;
    }
    /*
    public static function staticTranslate($string, $from, $to) {
        $domain = '';
        $translateDomain = Yii::app()->user->getState('translateDomain');
        if($translateDomain != false){
            $ary = explode('||', $translateDomain);
            if(($ary[1]+15*60) < time()){
                $domain = $ary[0];
            }
        }
        if($domain == false){
            if(self::checkDomain('http://translate.google.cn')){
                $domain = 'translate.google.cn';
            }
            elseif(self::checkDomain('http://translate.google.com')){
                $domain = 'translate.google.com';
            }
            elseif(self::checkDomain('http://translate.google.com.hk')){
                $domain = 'translate.google.com.hk';
            }
            elseif(self::checkDomain('http://203.208.37.3')){
                $domain = '203.208.37.3';
            }
            else{
                return false;
            }
        }
        $urlFormat = "http://".$domain."/translate_a/t?client=t&text=%s&hl=en&sl=%s&tl=%s&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";
        $url = sprintf($urlFormat, rawurlencode($string), $from, $to);
//        $url = sprintf(self::$urlFormat, rawurlencode($string), $from, $to);
        $result = preg_replace('!,+!', ',', self::makeCurl($url)); // remove repeated commas (causing JSON syntax error)
        $resultArray = json_decode($result, true);
        $finalResult = "";
        if (!empty($resultArray[0])) {
            foreach ($resultArray[0] as $results) {
                $finalResult .= $results[0];
            }
            Yii::app()->user->setState('translateDomain', $domain."||".time());
            return $finalResult;
        }

        return false;
    }
*/
    public static function checkDomain($domain){
        $gh = false;
        @$gh = get_headers("$domain");
        return $gh;
    }
}