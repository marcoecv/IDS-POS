<?php
App::uses('Component', 'Controller');
class AdminComponent extends Component {
	
    /*
	 * Carga la hierarchia de un agent especifico
	 * @param string $account : nombre del user
	 * @param string $type: tipo del agente loguiado
	 * @param int $action: selecionar el tipo de customer que usted necesita
	 * @return array $data : lista de usuario de la jerarquía
	 */
    public function loadHierarchyAgent($account = null, $type = null, $action = null){
        $data = array();
        $response = null;
        
        if (isset($account)){

            $soapLdap = $this->requestAction(array('controller' => 'App', 'action' => 'getService', 'AgentAdminChat'));
            
			if($action == 2){
                
                $result = $soapLdap->getAgentChatHierarchy(array("account" => $account));
                $response = json_decode($result->return, true);
                
                if(!empty($response['results'])){
                    foreach($response['results'] as $row){
                        if(trim($row['Type']) === 'P' || trim($row['Type']) === ''){
                            $data[] = trim($row['Customer']);
                        }
                    }
                }
            }
            else{
                $result = $soapLdap->getAgentChatHierarchy(array("account" => $account));
                $response = json_decode($result->return, true);
                
                if(!empty($response['results'])){
                    foreach($response['results'] as $row){
                        if(trim($row['Type']) === 'A'){
                            $data[] = trim($row['Customer']);
                        }
                    }
                }
            }
        }
        return $data;
    }
    
    
}