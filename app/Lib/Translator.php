<?php
class Translator{
	var $myMemCache;
	var $translations=null;
	var $language_id;
	var $wsClient;
	
	public function Translator($myMemCache, $language_id){
		$this->myMemCache=$myMemCache;
		$this->language_id=$language_id;
		$this->wsClient=new WsClient();
	}
	
	private function isPattern($OrigValue){
		return strpos($OrigValue, '%1$s');
	}
	
	private function makePattern($OrigValue){
		$pattern=$OrigValue;
		$pattern=str_replace('*', '\*', $pattern);
		$pattern=str_replace(')', '\)', $pattern);
		$pattern=str_replace('(', '\(', $pattern);
		$pattern=str_replace(']', '\]', $pattern);
		$pattern=str_replace('[', '\[', $pattern);
		$pattern=str_replace('/', '\/', $pattern);
		$pattern=str_replace(' ', '\s*', $pattern);
		$pattern=str_replace('|', '\\|', $pattern);
		$pattern=str_replace('?', '\?', $pattern);
		$pattern=str_replace('#', '\#', $pattern);
		for($i=1; $i<10; $i++)
			$pattern=str_replace('%'.$i.'$s', "(.*?)", $pattern);
		return $pattern;
	}
	
	private function saveTranslationsCache($translations, $language_id){
		$this->myMemCache->set("liveSiteCache_translations_{$language_id}", $translations, 60*60*24*7);
	}
	
	private function saveNewTranslationCache($text){
		$this->translations['fixed'][$text]="";
		$this->saveTranslationsCache($this->translations, $this->language_id);
	}
	
	private function getNewlabels($dbIndex, $CustomerID, $domain){
		$newLabels=array();
		$languages=Configure::read("languages");
		foreach($languages as $language_id => $language){
			$translations=$this->myMemCache->get("liveSiteCache_translations_{$language_id}");
			if(isset($translations['fixed']))
				foreach($translations['fixed'] as $label => $translation)
					if($translation=='')
						$newLabels[$label]=$label;
		}
		
		
		$currentLabels=$this->wsClient->call("LiveSiteService", 'getLabels', array('db'=>$dbIndex, "CustomerID"=> $CustomerID, "domain"=>$domain));
		foreach($currentLabels as $currentLabel)
			if(isset($newLabels[$currentLabel['OrigValue']]))
				unset($newLabels[$currentLabel['OrigValue']]);
		
		return $newLabels;
	}
	
	private function saveNewLabelsIntoDB($dbIndex, $CustomerID, $domain){
		$newLabels=$this->getNewlabels($dbIndex, $CustomerID, $domain);
		foreach($newLabels as $newLabel)
			$this->wsClient->call("LiveSiteService", 'insertLabel', array('db'=>$dbIndex, "CustomerID"=> $CustomerID, "domain"=>$domain, 'label'=>$newLabel));
		
		return count($newLabels);
	}
	
	public function makeTranslationsCache($dbIndex, $CustomerID, $domain){
		$status=array();
		
		$newLabels=$this->saveNewLabelsIntoDB($dbIndex, $CustomerID, $domain);
		$status['newLabels']=$newLabels;
		
		
		$languages=Configure::read("languages");
		foreach($languages as $language_id => $language){
			$data=$this->wsClient->call("LiveSiteService", 'getTranslations', array('db'=>$dbIndex, 'CustomerID'=>$CustomerID, 'domain'=>$domain, 'language_id'=>$language_id));
			$translations=array();
			$translations['fixed']=array();
			$translations['pattern']=array();
			foreach($data as $row){
				$OrigValue=trim($row['OrigValue']);
				$Translation=trim($row['Translation']);
				if($OrigValue=="")
					continue;
				if(preg_match("/%d/", $OrigValue))
					continue;
				if(preg_match("/%s/", $OrigValue))
					continue;
				
				if($this->isPattern($OrigValue)){
					$pattern=$this->makePattern($OrigValue);
					$translations['pattern'][$pattern]=$Translation;
				}
				else{
					if($OrigValue!=$Translation)
						$translations['fixed'][$OrigValue]=$Translation;
				}
			}
			$status[$language_id]['fixed']=count($translations['fixed']);
			$status[$language_id]['pattern']=count($translations['pattern']);
			$this->saveTranslationsCache($translations, $language_id);
			$data=null;
			unset($data);
		}
		
		return $status;
	}
	
	public function translate($text){
		//return "@@@";
		$text=trim($text);
		if($this->translations==null)
			$this->translations=$this->myMemCache->get("liveSiteCache_translations_{$this->language_id}");
			
		if($this->translations){
			if(isset($this->translations['fixed'][$text])){
				$translation=$this->translations['fixed'][$text];
				if($translation!="")
					return $translation;
			}
			else{
				$patterns=$this->translations['pattern'];
				foreach($patterns as $pattern => $translation){
					if(preg_match("/^$pattern$/", $text, $matches)){
						$i=0;
						foreach($matches as $match){
							if($i>0){
								$match=$this->translate($match);
								$translation=str_replace('%'.$i.'$s', $match, $translation);
							}
							$i++;
						}
						return $translation;
					}
				}
				$this->saveNewTranslationCache($text);
			}
		}
		return $text;
	}
}
?>