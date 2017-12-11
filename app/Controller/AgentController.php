<?php
class AgentController extends AppController{
	var $layout = 'admin_layout';
	public $uses = array('Account','Permission', 'Configuration');
	public $components = array('Admin');
	
	public function beforeFilter(){
		
    }
	
	/*
	 * Permission
	 */
	public function isAuthorized($user) {
		parent::isAuthorized($user);
		if ($user['accountType'] === 'M') {
			return true;
		}
		return false;
	}
	
	
	public function getAdminRoles(){
		$authUser = $this->Auth->user();
		$account = $authUser['customerId'];
		return $this->Permission->getAgentAdminRoles(array('account' => $account));
	}
	
	
	/*
	 * Ajax
	 * Devuelve la lista de los roles (Admin) de un agent
	 */
	public function getAgentAdminRoles(){
		$this->autoRender=false;
		$return = null;
	
		$authUser = $this->Auth->user();
		$customerLogged = $authUser['customerId'];
		$customerSelected = trim($this->request->data('customer'));                
		if(isset($customerSelected)){
			$params = array("account" => $customerLogged,
						   "agent" => $customerSelected );
			$response = $this->Permission->getAgentAdminRoles($params);
			
			$return = $this->relationship_rols($response);
			
		}
		return new CakeResponse(array('body' => json_encode($return)));
	}

	
}
