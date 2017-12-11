<?php

App::uses('Model', 'Model');

class Configuration extends AppModel {
    public $name = 'Configuration';
    
    public function getOwnParlay($params){
        return $this->call('accounts', 'getOwnParlay', $params);
    }
    
    public function getOwnTeaser($params){
        return $this->call('accounts', 'getOwnTeaser', $params);
    }
    
    public function getParlayDetail($params){
        return $this->call('accounts', 'getParlayDetail', $params);
    }
    
    public function getInfoLineCuspro($params){
        return $this->call('preLine', 'getInfoLineCuspro', $params);
    }
}