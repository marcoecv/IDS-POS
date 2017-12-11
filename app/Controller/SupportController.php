<?php

App::uses('AppController', 'Controller');

class SupportController extends AppController {
    var $layout = 'admin_layout';
	public $uses = array();

	public function beforeFilter(){
		$userAuth = $this->Auth->user();
        if(@$userAuth['app'] != 'pregamesite')
			$this->Auth->logout();
    }
	/**
	 *
	 */
	public function index() {
		
		$this->Session->write('SectionNav', 'support');
		$this->Session->write('current_page', array('controller' => 'Support', 'action' => 'index'));
		$this -> render('index');

	}
    
    public function isAuthorized($user) {
		parent::isAuthorized($user);
		if (isset($user['accountType']) && ($user['accountType'] === 'A')) {
			return true;
		}
		
		$this->Session->setFlash("You are not authorized to access.");
		return false;
	}
    
}
?>