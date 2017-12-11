<?php

App::uses('AppPregameSiteController', 'Controller');

class PersonalController extends AppController{
    
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
	 * get info Stores
	 * 
	 * @return Object json : info store
	 */
    public function getStores(){
		$userAuth = $this->Auth->user();
		$userLogged = $userAuth['customerId'];
		
        $response = $this->Account->getStore(array('account'=>$userLogged));
        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function getcuentas() {
        $this->Session->delete('PersonalSession');
        $this->autoRender = false;
		$userAuth = $this->Auth->user();
		$userLogged = $userAuth['customerId'];
		$res=array();
		$player = trim($this->request->data('player'));
		
		if (isset($player)){
			$response = $this->Account->getAccountFullInfo(array("account" => $player, "session" => $userLogged, "agent" => '', 'appid' => 'pregamesite' ,'userid' => $userLogged));
			if(!empty($response)){
					$this->Session->write('PersonalSession', $response);
					$res["db"] = $response;
			}else{
					$res["db"] = 0;
			}
		}
        return new CakeResponse(array('body' => json_encode($res)));
    }

	/**
	 *get info Status
	 * 
	 * @return Object json : info Status
	 */
    public function getstatus() {

        $this->autoRender = false;
		$userAuth = $this->Auth->user();
		$userLogged = $userAuth['customerId'];

		$player = trim($this->request->data('player'));
		if (isset($player)) {
			$response = $this->Account->getStatusLoad(array("account" => $player, "session" => $userLogged));
		}
        return new CakeResponse(array('body' => json_encode($response['row1'])));
    }
    
	
   
	
	/**
	 * Send Mail Request New Account
	 * 
	 * @return Object response service
	 */
	public function sendMailRequestNewAccount(){
		$this->autoRender = false;
		$dataReq = trim($this->request->data('dataReq'));
		$type = trim($this->request->data('type'));
		$from = 'default@bminc.eu';
		$results="";
		
		$view = new View($this, false);
		$data = array(
			'type'=>$type,
			'accounts'=>json_decode($dataReq)
		);
		
		if(!empty($dataReq)){
			$body = $view->element('templateMail', array("data" => $data));
			$params = array("from" =>$from, 
					"to" => $this->domain['mailRequestNewAccount'],
					"subject"=>"Request New Account",
					"message"=>$body,
					"appid" => 'Pregamesite', 
					"userid" => 'kris');
			$response=$this->Account->sendMailRequestNewAccount($params);
			$results=@$response;
		}
		return new CakeResponse(array('body' => json_encode($results)));
	}
	
	
	
	
}

