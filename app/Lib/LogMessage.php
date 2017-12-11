<?php
class LogMessage {
	
	private function replaceDatePath($path){
		return str_replace("{date}", date("Ymd"), $path);
	}
	
	private function write($enable, $path, $log){
		try{
			if($enable){
				$myPath=$this->replaceDatePath($path);
				$dir=dirname($myPath);
				if(file_exists($dir)){
					file_put_contents($myPath, date("Y-m-d H:i:s").":".$log."\n", FILE_APPEND);
					return true;
				}
				return false;
			}
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	
	public function log($log){
		return $this->write(Configure::read("logMessages.enable"), Configure::read("logMessages.path"), $log);
	}
	
	public function error($log){
		return $this->write(Configure::read("errorMessages.enable"), Configure::read("errorMessages.path"), $log);
	}
}
