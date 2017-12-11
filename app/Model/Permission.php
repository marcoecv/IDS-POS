<?php

App::uses('Model', 'Model');

class Permission extends AppModel {
    public $name = 'Permission';
    
    public function getAgentAdminRoles($params){
        return $this->call('permission', 'getAgentAdminRoles', $params);
    }
    public function getAgentChatHierarchy($params){
        return $this->call('AgentAdminChat', 'getAgentChatHierarchy', $params);
    }
    
    
}