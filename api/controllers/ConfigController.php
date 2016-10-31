<?php
/**
 * 获取商城后台配置文件的控制器---用于盖网通后台管理
 * @author LC
 */
class ConfigController extends Controller{
	/**
	 * 获取商城的配置文件
	 */
	public function actionConfig()
	{
		$this->actionType = 'config/config';
		$name = $this->checkParam('name');    //配置的文件名
		$key = $this->getPost('key');	
		$rsa = new RSA();
        $name = $rsa->decrypt($name);
        if($key)
        {
        	$key = $rsa->decrypt($key);
        }
        $config = $this->getConfig($name, $key);
        $xml = '';
        if($config != '')
        {
        	if(!is_array($config))
        	{
        		$xml = "<Value>$config</Value>";
        	}
        	else 
        	{
        		$xml .= "<Configs>";
        		foreach ($config as $k=>$v)
        		{
        			$xml .= "<Config>";
        			$xml .= "<Key>$k</Key>";
        			$xml .= "<Value>$v</Value>";
        			$xml .= "</Config>";
        		}
        		$xml .= "</Configs>";
        	}
            echo $this->exportXml($xml);
        }
        else 
        {
        	echo $this->errorEndXml('数据有误');
        }
	}
}