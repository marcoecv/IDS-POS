<?php

App::uses('Model', 'Model');

class Mail extends AppModel {
    public $name = 'Mail';
    
    public function getClients(){
        return $this->call('mail', 'getClients');
    }
    
    public function sendMail($params){
        return $this->call('mail', 'sendMail', $params);
    }   
}