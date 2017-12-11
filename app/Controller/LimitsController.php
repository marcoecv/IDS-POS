<?php


App::uses('AppController', 'Controller');


class LimitsController extends AppController
{
    var $layout = 'admin_layout';
    
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
	
    public $uses = array(
		'Account',
		'Configuration'
		);
   
   	/*
	 * get info live
	 * 
	 * @return Object json : info live
	 */
    
	/*
	 * get Own Parlay
	 * 
	 * @return Object json : info Parlay
	 */
    public function getOwnParlay()
    {
        $this->autoRender = false;
		$customer = trim($this->request->data('customer'));
		if (isset($customer)) {
			$response = $this->Configuration->getOwnParlay(array(
				"account" => $customer,
				"session" => $userLogged
			));
		}
        return new CakeResponse(array(
            'body' => json_encode($response['results']['row1'])
        ));
    }
    
	/*
	 * get Own Teaser
	 * 
	 * @return Object json : info Teaser
	 */
    public function getOwnTeaser()
    {
        $this->autoRender = false;
        $teaser = $this->Session->read('TeaserSession');
        
        $salida = array();
		$customer = trim($this->request->data('customer'));
		$session  = trim($this->request->data('session'));
		
		if (isset($customer)) {
			$response = $this->Configuration->getOwnTeaser(array(
				"account" => $customer,
				"session" => $session
			));
			
			if (!empty($response['results'])) {
				$salida["db"] = $response['results'];
			} else {
				$salida["db"] = 0;
			}
			
			if (!empty($teaser)) {
				$salida["session"] = $teaser;
			} else {
				$salida["session"] = 0;
			}
			
		}
        return new CakeResponse(array(
            'body' => json_encode($salida)
        ));
    }
    
    
	/*
	 * save Teaser Session
	 */
        
	/*
     * get info Parlay Detail
     *
     * @return Object json : info Parlay 
     */
    public function getParlayDetail()
    {
        $this->autoRender = false;
		$customer   = trim($this->request->data('customer'));
		$parlaycat  = trim($this->request->data('parlaycat'));
		$parlayname = trim($this->request->data('parlayname'));
		
		if (isset($customer)) {
			$response = $this->Configuration->getParlayDetail(array(
				"account" => $customer,
				"parlaycat" => $parlaycat,
				"parlayname" => $parlayname
			));
		}
        return new CakeResponse(array('body' => json_encode($response['results'])));
    }
    
    
}

