<?php
class MyMemCache{
	var $memcache;
	var $ttl = 180;
	
	function MyMemCache(){
		try{
			$this->memcache = new Memcache("liveV2");
			$this->memcache->connect(Configure::read("memCacheHost"), Configure::read("memCachePort"));
		}
		catch(Exception $e){
			$this->memcache=null;
		}
	}
	
	function close(){
		if($this->memcache){
			$this->memcache->close();
		}
	}
	
	function get($name){
		if($this->memcache)
			return $this->memcache->get($name);
		return null;
	}
	
	function set($name, $value, $ttl=null){
		if($this->memcache)
			$this->memcache->set($name, $value, MEMCACHE_COMPRESSED, $ttl? $ttl:$this->ttl);
	}
	
	function delete($name){
		$this->memcache->delete($name);
	}
}