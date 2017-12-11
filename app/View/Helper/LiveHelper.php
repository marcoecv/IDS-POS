<?php
App::uses('AppHelper', 'View/Helper');
class LiveHelper extends AppHelper {
	
	function getDomainConfig(){
		$domain=$_SERVER['HTTP_HOST'];
		if(preg_match("/^(.*):(.*)$/", $domain, $match))
			$domain=$match[1];
		$domain=trim($domain);

		//$domain=str_replace("www.","",$domain);
		$domainsConf=Configure::read("domains");
		$domainConf=@$domainsConf[$domain];
		return $domainConf;
	}
	
	function isSSL(){
		return !empty($_SERVER['HTTPS']);
	}
	
	function getApePort(){
		$domainConf=$this->getDomainConfig();
		if($this->isSSL())
			return $domainConf['apePortSSL'];
		return $domainConf['apePort'];
	}
}
?>