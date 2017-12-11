<?php
App::uses('Component', 'Controller');
class LiveHelperComponent extends Component{
    public $uses = array('Cashier');
	function getDomain(){
		$pu = parse_url($_SERVER['HTTP_HOST']);
		$domain=$pu['host'];
		if(preg_match("/^(\S+?)\.(.*)$/", $domain, $match))
			$domain=$match[2];
		return $domain;
	}
	
        
	function getFullDomain(){
            $domain=$_SERVER['HTTP_HOST'];
            if(preg_match("/^(.*):(.*)$/", $domain, $match))
                    $domain=$match[1];
            $domain=trim($domain);
            $domain=str_replace("www.","",$domain);
            $url=Configure::read('service.cashierSecurity');
            try{
                $client = new SoapClient($url, array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));
                $response=$client->getSucursalesByUrl(array("company"=>"BMI4","url"=>$domain,"appid"=>"","userid"=>""));
            }  catch (Exception $e){
                var_dump($e);
            }
            $results=json_decode($response->return,true);
            $results=$results["results"]["row1"];
            $domains=Configure::read("domains");
            $generalOpt=Configure::read("generalOptions");
            $generalOpt['theme'] = 'Jueguelo';
            $generalOpt['nameClient'] = '';
            $generalOpt['TemplateID'] = '5';
            $generalOpt['AgentID'] = $results["AgentPPH"];
            $generalOpt['Cashier'] = 'Tag';
            $generalOpt['live']['css'] = 'juegelo.css';
            $generalOpt['inetTarget'] = "oddswinners.eu";
            $generalOpt['pinScheme'] = "PinPrefix";
            $generalOpt['PinPrefix'] = $results["Prefix"];
            $generalOpt['sendMail'] =$results["email"];
            $generalOpt['anonimAcc'] =$results["Name"];
            $generalOpt['BranchID'] =$results["BranchID"];
            $generalOpt['agentPOS'] =$results["AgentID"];
            $generalOpt['company'] =$results["Company"];
            $generalOpt['siteDesc'] =$results["SiteDesc"];
            $generalOpt['formatDisplay'] =$results["FormatDisplay"];
            $generalOpt['betTypes'] =  explode(",", $results["BetTypes"]);
            $generalOpt['betConfig'] =  explode(",", $results["BetConfig"]);
            $generalOpt['language'] = $results["Language"];
            $generalOpt['domain'] =$domain;
            $generalOpt['applyRet'] =$results["applyRet"];
            $generalOpt['retentionPercent'] =$results["RetentionPercent"];
            Configure::write("generalOptions",$generalOpt);
            $domains[$domain]=$generalOpt;
            Configure::write("domains",$domains);
            $domainsConf=Configure::read("domains");
            $domainConf=@$domainsConf[$domain];
            return $domainConf;
	}
	
	function getDomainConfig(){
		$domain=$this->getFullDomain();
		$domainsConf=Configure::read("domains");
		$domainConf=@$domainsConf[$domain];
		return $domainConf;
	}
	
	function isMobile(){
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	function getTheme(){
		$domain=$this->getDomain();
		$domain=  str_replace(".", "_", $domain);
		$domain=  str_replace("-", "_", $domain);
		return $domain;
	}
}
