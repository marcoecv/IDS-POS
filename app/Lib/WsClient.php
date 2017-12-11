<?php
class WsClient{
	private $wsClients=array();
	
	private function create($url){
		try{
			ini_set('soap.wsdl_cache_enabled', 0);
			ini_set('soap.wsdl_cache_ttl', 0);
			//$timeout=3;
			//ini_set("default_socket_timeout", $timeout);
			return new SoapClient($url, array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE/*, 'connection_timeout'=> $timeout*/));
		}catch(Exception $e){
			$error="Error conecting WS: $url";
			$error.="\nException:".$e->getMessage();
			$error.="\n";
			
			$log=new LogMessage();
			$log->error($error);
		}
		return null;
	}
	
	private function getClient($serviceName){
		if(!isset($this->wsClients[$serviceName]))
			$this->wsClients[$serviceName]=$this->create(Configure::read("service.{$serviceName}"));
		return $this->wsClients[$serviceName];
	}
	
	private function decodeArray($array){
		if(is_array($array)){
			foreach($array as $key => &$val){
				if(is_array($val))
					$val=$this->decodeArray($val);
				else
					$val=trim($val);
			}
		}
		return $array;
	}
	
	public function call($serviceName, $method, $params){
		$start=microtime(true);
		$log=new LogMessage();
		try{
			$client=$this->getClient($serviceName);
			
			if($client==null){
				$error="Error calling: $serviceName -> $method (".json_encode($params).")";
				$error.="\nException: Client is null";
				$error.="\n";
				$log->error($error);
				return null;
			}
			
			$log->log("WS: (calling) $serviceName -> $method (".json_encode($params).")");
			try{
				$data=$this->decodeArray(json_decode($client->$method($params)->return, true));
				$end=microtime(true);
				$duration=round($end-$start, 3);
				$log->log("WS: ({$duration}s) $serviceName -> $method (".json_encode($params).")");
				return isset($data['results'])? $data['results'] : $data;
			}
			catch(Exception $e){
				$end=microtime(true);
				$duration=round($end-$start, 3);
				$error="Error calling: ({$duration}s) $serviceName -> $method (".  json_encode($params).")";
				$error.="\nException:".$e->getMessage();
				$error.="\n\nSOAP Response: ".$client->__getLastResponse();
				$error.="\n";
				$log->error($error);
				return null;
			}
		}catch(Exception $e){
			$end=microtime(true);
			$duration=round($end-$start, 3);
			$error="Error calling: ({$duration}s) $serviceName -> $method (".json_encode($params).")";
			$error.="\nException:".$e->getMessage();
			$error.="\n";
			$log->error($error);
			return null;
		}
	}
}
