<?php

App::uses('Model', 'Model');

class Reports extends AppModel {
    public $name = 'Reports';
    
    public function getSports($params){
        return $this->call('reports', 'getSports', $params);
    }
    
     public function actionByPlayerReport($params){
        return $this->call('reports', 'actionByPlayerReport', $params);
    }
    
    public function getAgentInfo($params){
        return $this->call('reports', 'getAgentInfo', $params);
    }
    
    public function getAgentsByMaster($params){
        return $this->call('reports', 'getAgentsByMaster', $params);
    }
}