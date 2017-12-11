<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
    public $my_auth = array();
    
	/*
	 * Check permission(s) user logged
	 * @param string OR array: name of premission(s)
	 * @return bool
	 */
    public function it_has_permission($permission = null){
       
		if(empty($this->my_auth)){
			$this->setMyAuth();
		}
		if($permission !== null){
			if(is_array($permission)){ // check multi permission
				
				foreach($permission as $row){ // if por o menos uno esta a true
					if(!empty($this->my_auth[$row]) && $this->my_auth[$row] == true){
						return true;
					}
				}
			}
			else{ // check one permssion
				if(!empty($this->my_auth[$permission]) && $this->my_auth[$permission] == true){
					return true;
				}
			}
        }
        return false;
	}
	
	public function getMyAuth(){
		if(empty($this->my_auth)){
			$this->setMyAuth();
			return $this->my_auth;
		}
		return $this->my_auth;
	}
	
	public function getDomain($i=null){
		$domain=$this->requestAction('/App/getDomain');
		if($i==null){
			return $domain;
		}
		return $domain[$i];
	}
	
	
	/*
	 * get Type Customer
	 * @param string OR array: name of premission(s)
	 * @return string type
	 */
    public function getTypeCustomer(){
		if(empty($this->my_auth)){
			$this->setMyAuth();
		}
		return trim($this->my_auth['accountType']);
	}
	
	/**
	 * get Secific Value Auth
	 * 
	 * @param string $target name of item
	 * 
	 * @return string value
	 */
	public function getSecificValueAuth($target=null){
		$auth = $this->getMyAuth();
		if(array_key_exists($target, $auth))
			return $auth[$target];
		
		return null;
	}
	/*
	 * Add a values of session Auth in a variable of class $my_auth
	 */
    public function setMyAuth(){
        $session = $this->requestAction('/Pages/getSessionAuth');
	    $this->my_auth = $session;
    }
	
	/*
	 *
	 */
	public function formatedDateChat($date){
		$date = strtotime($date);
		
		$yesterday = new DateTime();
		$yesterday= $yesterday->modify('-1 day');
		$today = date('M d Y');
		$date_of_message = date('M d Y', $date);
		$time_of_message = date('H:i', $date);
		
		if($today == $date_of_message){
			return 'today '.$time_of_message;
		}
		elseif($yesterday->format('M d Y') == $date_of_message){
			return 'yesterday '.$time_of_message;
		}
		else{
			return $date_of_message.' '.$time_of_message;
		}	 
	}
	
	/*
	 *  Get all Roles for a user
	 */
    public function getAdminRoles(){
        $roles = $this->requestAction('/Agent/getAdminRoles');
	    return $roles;
    }

	/*
	 *  get all Sub Agents 
	 */
    public function getSubAgents(){
        $agents = $this->requestAction('/Agent/getAllSubAgents');
	    return $agents;
    }
	
	/*
	 * Re-write method url()
	 */
	public function url($url = null, $full = false){
		if(is_array($url)){ 
			if((!isset($url['language']) || empty( $url['language'])) && isset($this->params['language'])){
				$url['language'] = $this->params['language'];
			}
		}
		return parent::url($url, $full);
	}
	
	/*
	 * Re-write method url()
	 */
	public function it_has_permission_config_user($param1=null, $param2=null){
		$config=$this->requestAction('/Pages/configurations');
		if($param1 != null && isset($config[$param1])){
			$data=urldecode($config[$param1]);
			
			if($param2 != null){
				if(strstr($data, ',')){
					foreach(explode(',',$data) as $row){
						if(trim($row)==$param2)
							return true;
					}
				}else{
					if(trim($data)==$param2)
						return true;
					return false;
				}
			}
		}
		return false;
	}
	
	
	public function get_timezone_offset($remote_tz, $origin_tz = null) {
		if($origin_tz === null) {
			if(!is_string($origin_tz = date_default_timezone_get())) {
				return false; // A UTC timestamp was returned -- bail out!
			}
		}
		$origin_dtz = new DateTimeZone($origin_tz);
		$remote_dtz = new DateTimeZone($remote_tz);
		$origin_dt = new DateTime("now", $origin_dtz);
		$remote_dt = new DateTime("now", $remote_dtz);
		$offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
		return $offset;
	}
	
	public function sanitiazeId($id){
        $replace = $id;
        $replace = str_replace(" ", "_B",trim($replace));
	    $replace = str_replace("-", "_M",trim($replace));
	    $replace = str_replace("+", "_P",trim($replace));
	    $replace = str_replace(".", "_D",trim($replace));
	    $replace = str_replace("(", "_O",trim($replace));
	    $replace = str_replace(")", "_C",trim($replace));
	    $replace = str_replace("/", "_S",trim($replace));
	    $replace = str_replace("@", "_A",trim($replace));
	    $replace = str_replace("&", "_R",trim($replace));
	    $replace = str_replace("[^\\w\\s]", "",trim($replace));
	    $replace = str_replace(":", "",trim($replace));
	    $replace = strtolower($replace);        
		return $replace;
	}
        
        public function dictionary($text){
		/*$file = APP.'Locale/default.pot';
		$current = file_get_contents($file);
		$text=trim($text);
		if(strpos($current, 'msgid "'.$text.'"') === false){
			$current .= '
			
			#: LOADED/FROM/DATABASE
			msgid "'.$text.'"
			msgstr ""';
			file_put_contents($file, $current);
		}*/
        
		return $text;
	}
	

}
