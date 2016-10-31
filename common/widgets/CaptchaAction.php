<?php

class CaptchaAction extends CCaptchaAction
{
    /**
     * 重写成成验证码的方法
     * @author luochen
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        if ($this->minLength < 3)
            $this->minLength = 3;
        if ($this->maxLength > 20)
            $this->maxLength = 20;
        if ($this->minLength > $this->maxLength)
            $this->maxLength = $this->minLength;
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = '01234567890123456789';
        $vowels = '85463';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9)
                $code .= $vowels[mt_rand(0, 4)];
            else
                $code .= $letters[mt_rand(0, 19)];
        }

        return $code;
    }

    /**
     * 重写run方法，使得验证码在页面刷新时刷新
     * Runs the action.
     */
    public function run()
    {
        if (isset($_GET[self::REFRESH_GET_VAR]))  // AJAX request for regenerating code
        {
            $code = $this->getVerifyCode(true);
            echo CJSON::encode(array(
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => $this->getController()->createUrl($this->getId(), array('v' => uniqid())),
            ));
        } else {
            $this->renderImage($this->getVerifyCode());
        }
        Yii::app()->end();
    }
}