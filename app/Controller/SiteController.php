<?php

App::uses('AppController', 'Controller');

class SiteController extends AppController {
    
	var $layout = 'admin_layout';
	public $App = array();
	public $uses = array('Account');
	
	public function beforeFilter(){
		global $CustomerID;
		// Read helper App
		$view = new View($this);
		$this->App = $view->loadHelper('App');
	}
	
	public function isAuthorized($user) {
		if ($user['accessAdmin']) {
			return true;
		}
		return false;
	}
	
    /**
     * When not method is called in the URL, all request get here
     * This funtion load the main page of site
     */
    public function index() {
		$this->Session->write('SectionNav', 'site');
		$this->Session->write('current_page', array('controller' => 'Site', 'action' => 'index'));

		$customer = null;
		if($this->Session->check('current_account')){
			$customer = $this->Session->read('current_account');
		}else{
			$userAuth = $this->Auth->user();
			$customer = $userAuth['customerId'];	
		}
		
		$this->set('authUser', $this->Auth->user());
		$this->set('customer', $customer);
		
        //Load sites
		$sites = $this->getSites();
		$sites = (isset($sites["results"]) ? $sites["results"] : $sites);
        $this->set('sites', $sites);
        
        //Load templates
		$templates = $this->getTemplates();
		$templates = (isset($templates["results"]) ? $templates["results"] : $templates);
        $this->set('templates', $templates);
        
        //Load format types
        $this->set('linesFormatTypes', $this->getLinesFormatTypes());
        
        //Load languages
        $this->set('languages', $this->getLanguages());
		
		//Load menu options
        $this->set('menuOptions', $this->getMenuOptions());
		
		//Load info general
        $this->set('infoGeneral', $this->getInfoGeneral());
        
        //Render view
        $this->render('index');
    }
    
    private function getSites(){
		$userAuth = $this->Auth->user();
		$customer = $userAuth['customerId'];	
		
		//Load service object
        $soapLdap = $this->getService('PreGameSiteService');
        //Load sites data
        $result = $soapLdap->getSites(array("CustomerID" => $customer, "appid" => $this->getAppId(), "userid" => $this->getUserId()));

		$sites = json_decode(urldecode("[".$result->return."]"), true);
		
		return (isset($sites[0]) ? $sites[0] : null);
    }
    
    private function getTemplates(){
		$userAuth = $this->Auth->user();
		$customer = $userAuth['customerId'];	
        //Load service object
        $soapLdap = $this->getService('PreGameSiteService');
        //Load countries data
        $result = $soapLdap->getTemplateDesing(array("CustomerID" => $customer, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
		
		$templates = json_decode(urldecode("[".$result->return."]"), true);
        
        return (isset($templates[0]) ? $templates[0] : null);
    }
    
    public function getAgentTemplateDesing(){
		$this->autoRender = false;
		$customer = trim($this->request->data('CustomerID'));
        $agent = trim($this->request->data('AgentID'));
        $site = trim($this->request->data('Site'));
        //Load service object
        $soapLdap = $this->getService('PreGameSiteService');
        //Load agent template data
        $result = $soapLdap->getAgentTemplateDesing(array("CustomerID" => $customer, "AgentID" => $agent, "Site" => $site, "appid" => $this->getAppId(), "userid" => $this->getUserId()));

		$res = $result->return;
		$res = (isset($res["results"]) ? $res["results"] : $res);
		
		$template = json_decode(urldecode("[".$res."]"), true);
		$template = (isset($template[0]["results"]) ? $template[0]["results"] : $template[0]);
        return json_encode($template);
    }
    
    public function putAgentTemplateDesing(){
        $this->autoRender = false;
		$customer = trim($this->request->data('CustomerID'));
        $agent = trim($this->request->data('AgentID'));
        $site = trim($this->request->data('Site'));
        $templateID = trim($this->request->data('TemplateID'));
        $lineTypeFormat = trim($this->request->data('LineTypeFormat'));
        $language = trim($this->request->data('Language'));
        $betTypes = trim($this->request->data('BetTypes'));
		$menuOptions = trim($this->request->data('MenuOptions'));
        $infoGeneral = trim($this->request->data('InfoGeneral'));

        //Load service object
        $soapLdap = $this->getService('PreGameSiteService');
        //Load agente template data
        $result = $soapLdap->getAgentTemplateDesing(array("CustomerID" => $customer, "AgentID" => $agent, "Site" => $site, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
		
		//var_dump(json_decode(urldecode("[".$result->return."]"), true));
		//die;
		
		
		$template = json_decode(urldecode("[".$result->return."]"), true);
        if($template[0] == null){
            //insertar
            $resultInsert = $soapLdap->insertAgentTemplateDesing(array("CustomerID" => $customer, "AgentID" => $agent, "Site" => $site, "TemplateID" => $templateID, "LineTypeFormat" => $lineTypeFormat, "Language" => $language, "BetTypes" => $betTypes, "MenuOptions" => $menuOptions, "InfoGeneral" => $infoGeneral, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
            $template = json_decode(urldecode("[".$resultInsert->return."]"), true);
            return $template[0];
        }
        else{
            $resultUpdate = $soapLdap->updateAgentTemplateDesing(array("CustomerID" => $customer, "AgentID" => $agent, "Site" => $site, "TemplateID" => $templateID, "LineTypeFormat" => $lineTypeFormat, "Language" => $language, "BetTypes" => $betTypes, "MenuOptions" => $menuOptions, "InfoGeneral" => $infoGeneral, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
			$template = json_decode(urldecode("[".$resultUpdate->return."]"), true);
            return $template[0];
        }
        
    }
    
    private function getLinesFormatTypes(){
        return [["Name" => "American"], ["Name" => "Decimal"]];
    }
    
    private function getLanguages(){
        return [["Name" => "English"], ["Name" => "Español"], ["Name" => "Français"]];
    }
	
	private function getMenuOptions(){
        return [["Name" => "Cashier"], ["Name" => "Message"], ["Name" => "Line_Type_Format"], ["Name" => "Languages"], ["Name" => "Support"]];
    }
	
	private function getInfoGeneral(){
        return [["Name" => "Balance"], ["Name" => "Available"], ["Name" => "FP"], ["Name" => "Non_Posted_Casino"]];
    }
}
?>