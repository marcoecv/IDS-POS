<?php
class WagersController extends AppController
{
    
    var $layout = 'admin_layout';
    
	public $uses = array(
		'Wagers'
	);
	
    public function beforeFilter(){
        global $CustomerID;
    }
	
	public function isAuthorized($user) {
		if ($user['accessAdmin']) {
			return true;
		}
		return false;
	}
    
    public function getWagerdetail()
    {
        $this->autoRender = false;
		$player = trim($this->request->data('player'));
		$doc    = trim($this->request->data('doc'));
		$wager  = (int) ($this->request->data('wager'));
		if (isset($player)) {
			$response = $this->Wagers->getDetail(array(
				"account" => $player,
				"tikect" => $doc,
				"wager" => $wager
			));
		}
        
        return new CakeResponse(array(
            'body' => json_encode($response)
        ));
    }
	
}
