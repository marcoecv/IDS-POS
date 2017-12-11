<?php
class Functions{
	
	public static function formatDbBalance($balance){
		return round($balance/100, 2);
	}
	
	public static function translate($text){
		return $text;
	}
	
	public static function sanitiazeId($id){
		return strtolower(str_replace(" ","_",$id));
	}
	
	public static function minimizeLable($label){
		$words=explode(" ", $label);
		$minLabel="";
		foreach($words as $word)
			if($word!="")
				$minLabel.=$word[0];
		return $minLabel;
	}
	
	public static function formatDay($dateStr){
		$format="m/d";
		$day=date($format, strtotime($dateStr));
		
		if($day==date($format))
			$day="Today";
		
		return $day;
	}
	
	public static function formatTime($dateStr){
		$time=date("g:ia", strtotime($dateStr));
		$time=str_replace("am", "a", $time);
		$time=str_replace("pm", "p", $time);
		return $time;
	}
	
	public static function formatOdds($selection){
		global $oddsStyle;
		switch($oddsStyle){
			case Constants::ODDS_STYLE_DECIMAL: 
				return $selection['oddsDecimal'];
				
			case Constants::ODDS_STYLE_FRACTIONAL: 
				return "$selection[oddsNumerator]/$selection[oddsDenominator]";		
				
			case Constants::ODDS_STYLE_HONGKONG: 
				return $selection['oddsDecimal']-1;
				
			default:
				if($selection['oddsUS']!=null && !is_nan($selection['oddsUS'])){
					$oddsUS=0+$selection['oddsUS'];
					if($oddsUS>0)
						return "+".$oddsUS;
					return $oddsUS;
				}
				return $selection['oddsUS'];
		}
	}
	
	public static function formatSpread($spread){
		$spread=trim($spread);
		
		if($spread==0 || $spread=="")
			return "PK";
		
		$spreadDec=$spread-floor($spread);
		if($spreadDec==0.25 || $spreadDec==0.75){
			$firstSpreadValue=$spread-0.25;
			$secondSpreadValue=$spread+0.25;
			
			$firstSpreadFormat=self::formatSpread($firstSpreadValue);
			$secondSpreadFormat=self::formatSpread($secondSpreadValue);
			
			return $firstSpreadFormat.','.$secondSpreadFormat;
		}
		
		if($spread>0)
			return "+".self::formatFracionalHtml($spread);
		
		return self::formatFracionalHtml($spread);
	}
	
	public static function formatFracionalHtml($number){
		//return $number;
		$sign="";
		if($number<0)
			$sign="-";
		
		$number=abs($number);
		$intVal=floor($number);
		$decVal=$number-$intVal;
		
		$decValFrac="";
		if($decVal==0.5)
			$decValFrac="&frac12;";
		if($decVal==0.75)
			$decValFrac="&frac34;";
		if($decVal==0.25)
			$decValFrac="&frac14;";

		if($decValFrac=="")
			return $sign.$number;
		
		if($intVal==0)
			return $sign.$decValFrac;
		
		return $sign.$intVal.$decValFrac;
	}
	
	public static function formatThreshold($selection){
		return self::formatThresholdAux($selection, false);
	}
	
	public static function formatThresholdSimple($selection){
		return self::formatThresholdAux($selection, true);
	}
	
	public static function formatThresholdAux($selection, $simple){
		if($selection['betType']=='S'){
			return self::formatSpread($selection['threshold']);
		}
		
		if($selection['betType']=='T'){
			if($simple){
				return self::formatFracionalHtml($selection['threshold']);
			}
			else{
				if(strtolower($selection['description'])=='over')
					return "O ".self::formatFracionalHtml($selection['threshold']);
				if(strtolower($selection['description'])=='under')
					return "U ".self::formatFracionalHtml($selection['threshold']);
			}
		}
		
		return $selection['threshold'];
	}
	
	public static function sanitiazeTeamName($name){
		if(preg_match("/^\.(.*)$/", $name, $data))
			return $data[1];
		return $name;
	}
}

?>