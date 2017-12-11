<?php

App::uses('Model', 'Model');

class StyleAdmin extends AppModel{
	var $wsClient;
	public function StyleAdmin(){
		$this->wsClient=new WsClient();
	}

    public function getDetailTemplate($CustomerID, $AgentID){
        return $this->wsClient->call('PreGameSiteService', 'getDetailTemplate', array("CustomerID" =>$CustomerID, "AgentID" =>$AgentID));
    }
    
    public function getTemplateDesing($CustomerID){
        return $this->wsClient->call('PreGameSiteService', 'getDetailTemplate', array("CustomerID" =>$CustomerID));
    }
    
    public function getAgentTemplateDesing($CustomerID, $AgentID){
        $resp = $this->wsClient->call('PreGameSiteService', 'getAgentTemplateDesing', array("CustomerID" =>$CustomerID, "AgentID" =>$AgentID));
        return $resp;
    }
    
    public function insertAgentTemplateDesing($CustomerID, $AgentID, $TemplateID){
        return $this->wsClient->call('PreGameSiteService', 'insertAgentTemplateDesing', array("CustomerID" =>$CustomerID, "AgentID" =>$AgentID, "TemplateID" =>$TemplateID));
    }
}