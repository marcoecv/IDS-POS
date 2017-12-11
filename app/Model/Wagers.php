<?php

App::uses('Model', 'Model');

class Wagers extends AppModel {
    public $name = 'Wagers';
    
    public function getWagerGamesScore($params){
        return $this->call('wager', 'getWagerGamesScore', $params);
    }
    
    public function WagerInfobyAgent($params){
        return $this->call('wager', 'WagerInfobyAgent', $params);
    }
    
    public function getWagers($params){
        return $this->call('wager', 'getWagers', $params);
    }
    
    public function getWagerDetail($params){
        return $this->call('wager', 'getWagerDetail', $params);
    }
    
    public function getDetail($params){
        return $this->call('wager', 'getDetail', $params);
    }
    
    public function getTransactionInfo($params){
        return $this->call('transaction', 'getTransactionInfo', $params);
    }
    
    public function getDetailTransaction($params){
        return $this->call('wager', 'getDetailTransaction', $params);
    }
    
    public function getDetailTransaction2($params){
        return $this->call('transaction', 'getDetailTransaction', $params);
    }
    
    public function setDeleteTransaction($params){
        return $this->call('transaction', 'setDeleteTransaction', $params);
    }
    
    public function setTransaction($params){
        return $this->call('transaction', 'setTransaction', $params);
    }
    
    public function setEditTransaction($params){
        return $this->call('transaction', 'setEditTransaction', $params);
    }
    
     public function deleteWager($params){
        return $this->call('wager', 'deleteWager', $params);
    }
    
    
}