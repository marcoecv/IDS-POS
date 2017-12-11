<?php

class TransactionsController extends AppController {

    var $layout = 'admin_layout';

    public function beforeFilter() {
        $userAuth = $this->Auth->user();
        if (@$userAuth['app'] != 'pregamesite')
            $this->Auth->logout();

        global $CustomerID;

        $this->set("userAuth", $userAuth);
    }

    public $uses = array(
        'Account',
        'Wagers'
    );

    public function isAuthorized($user) {
        if ($user['accessAdmin']) {
            return true;
        }
        return false;
    }

    public function getbalance() {
        $this->autoRender = false;

        $player = trim($this->request->data('player'));
        if (isset($player)) {
            $response = $this->Account->getCustomerBalance(array(
                "account" => $player,
                "session" => 'kris'
            ));
        }

        return new CakeResponse(array(
            'body' => json_encode($response['row1'])
        ));
    }

    /**
     * Function to get the application id
     *
     * @param String The name of the service that is going to be called
     *
     * @return The url of the service
     */
    public function getAppId() {
        return Configure::read('appid');
        ;
    }

}
