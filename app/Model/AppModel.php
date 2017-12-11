<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

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
   
    private function getClient($serviceName) {
        try {
            ini_set('soap.wsdl_cache_enabled', 0);
            ini_set('soap.wsdl_cache_ttl', 0);
            $url = Configure::read('service.'.$serviceName);
            
            return new SoapClient($url, array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));
        }
		catch (Exception $e){
            $error="Error conecting WS: $serviceName";
			$error.="\nException:".$e->getMessage();
			$error.="\n";
			
			$log=new LogMessage();
			$log->error($error);
            return new CakeResponse(array('body' => json_encode($e->getMessage())));
        }
        return null;
    }
    
	public function call($serviceName, $method, $params){
		$log=new LogMessage();
		try{
			$client=$this->getClient($serviceName);
			
			if($client==null){
				$error="Error calling: $serviceName -> $method (".json_encode($params).")";
				$error.="\nException: Client is null";
				$error.="\n";
				$log->error($error);
				return json_encode($e->getMessage());
			}
			
			try{
				$start=microtime(true);
				$data=$this->decodeArray(json_decode($client->$method($params)->return, true));
				$end=microtime(true);
				$duration=round($end-$start, 3);
				$log->log("WS: ({$duration}s) $serviceName -> $method (".json_encode($params).")");
				
				return isset($data['results'])? $data['results'] : $data;
			}
			catch(Exception $e){
				$error="Error calling: $serviceName -> $method (".  json_encode($params).")";
				$error.="\nException:".$e->getMessage();
				$error.="\n\nSOAP Response: ".$client->__getLastResponse();
				$error.="\n";
				$log->error($error);
				return json_encode($e->getMessage());
			}
		}catch(Exception $e){
			$error="Error calling: $serviceName -> $method (".json_encode($params).")";
			$error.="\nException:".$e->getMessage();
			$error.="\n";
			$log->error($error);
			return json_encode($e->getMessage());
		}
	}
    
}
