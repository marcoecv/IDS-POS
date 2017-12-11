<?php
App::uses('AppHelper', 'View/Helper');

class SportbookHelper extends AppHelper {
	public function formatDbBalance($balance){
		return round($balance/100, 2);
	}
	
	public function translate($text){
		return $text;
	}
	
	public function sanitiazeId($id){
		$replace = $id;
        $replace = str_replace(" ","",trim($replace));
		$replace = str_replace(".", "_D",trim($replace));
		$replace = strtolower($replace);        
		return $replace;
		
	}
	
	public function minimizeLable($label){
		$words=explode(" ", $label);
		$minLabel="";
		foreach($words as $word)
			if($word!="")
				$minLabel.=$word[0];
		return $minLabel;
	}
	
	public function formatDay($dateStr){
		$format="m/d";
		$day=date($format, strtotime($dateStr));
		
		if($day==date($format))
			$day="Today";
		
		return $day;
	}
	
	public function formatTime($dateStr){
		$time=date("g:ia", strtotime($dateStr));
		$time=str_replace("am", "a", $time);
		$time=str_replace("pm", "p", $time);
		return $time;
	}
	
	public function formatOdds($selection){
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
	
	public function formatSpread($spread){
		$spread=trim($spread);
		
		if($spread==0 || $spread=="")
			return "PK";
		
		$spreadDec=$spread-floor($spread);
		if($spreadDec==0.25 || $spreadDec==0.75){
			$firstSpreadValue=$spread-0.25;
			$secondSpreadValue=$spread+0.25;
			
			$firstSpreadFormat=$this->formatSpread($firstSpreadValue);
			$secondSpreadFormat=$this->formatSpread($secondSpreadValue);
			
			return $firstSpreadFormat.','.$secondSpreadFormat;
		}
		
		if($spread>0)
			return "+".$this->formatFracionalHtml($spread);
		
		return $this->formatFracionalHtml($spread);
	}
	
	public function formatFracionalHtml($number){
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
	
	public function formatThreshold($selection){
		return $this->formatThresholdAux($selection, false);
	}
	
	public function formatThresholdSimple($selection){
		return $this->formatThresholdAux($selection, true);
	}
	
	public function formatThresholdAux($selection, $simple){
		if($selection['betType']=='S'){
			return $this->formatSpread($selection['threshold']);
		}
		
		if($selection['betType']=='T'){
			if($simple){
				return $this->formatFracionalHtml($selection['threshold']);
			}
			else{
				if(strtolower($selection['description'])=='over')
					return "O ".$this->formatFracionalHtml($selection['threshold']);
				if(strtolower($selection['description'])=='under')
					return "U ".$this->formatFracionalHtml($selection['threshold']);
			}
		}
		
		return $selection['threshold'];
	}
	
	public function sanitiazeTeamName($name){
		if(preg_match("/^\.(.*)$/", $name, $data))
			return $data[1];
		return $name;
	}
	
	public function addMainBetsGroups($period, $selection1, $selection2, $selectionDaw, $betOpen, $betType, $selectionTeam, $sport, $league, $formatPriceAmerican, $overview_layout,$type){
	
		$classBetOpen = ($betOpen)?'in':'collapse';
		$gameContainerID='mainBetsGroupsWrap_mainBet_'.$period['periodNumber'];
		$gameContainerWrapID='data_mainBetsGroupsWrap_mainBet_'.$type.'_'.$betType.'_'.(($selectionTeam!=null)?$selectionTeam.'_':'').$period['periodNumber'];
		
		$selectionContainerId1=$gameContainerID.'_'.$selection1['selectorId'];
		$selectionContainerId2=$gameContainerID.'_'.$selection2['selectorId'];
		$selectionContainerIdDraw=($selectionDaw!=null)? $gameContainerID.'_'.$selectionDaw['selectorId'] : null;
		
		//$heightSel = ($selectionContainerIdDraw!=null)? 'style="height: 65px;"' : '';
                $heightSel = $overview_layout == "american" ? 'style="height: 60px;"' : 'style="height: 60px;"';
		//$widthLi = ($selectionContainerIdDraw!=null)? 'col-xs-4' : 'col-xs-6';
		$col = $this->colSelectionContainer($selection1, $selection2, $selectionDaw);

		$comments = (!empty($period['Comments']))? __($this->dictionary($period['comments'])) : '';
		$html='';
		if($betType!='teamTotal'){
				
			$threshold1 = $selection1['threshold'];
			$threshold2 = $selection2['threshold'];

			if($betType!='moneyLine' && $betType!='spread'){                              
			   $threshold1 = $selection1['totalPointsOU'].''.$selection1['threshold'];
			   $threshold2 = $selection2['totalPointsOU'].''.$selection2['threshold'];
			}
			
			$chosenTeamIDHome = '';
			$chosenTeamIDAway = '';
			if($betType!='total'){
				$chosenTeamIDHome=$period['homeTeam']['teamName'];
				$chosenTeamIDAway=$period['awayTeam']['teamName'];
			}else{
				$chosenTeamIDHome = $selection1['totalPointsOUDesc'];
				$chosenTeamIDAway= $selection2['totalPointsOUDesc'];
			}
			
			$betDescription = $selection1['betTypeDesc'];
			
			$showfield = true;
			
			if ($selection1['showField'])
				$showfield = true;
			else
				$showfield = false;
	
			
		//$secretContainer=(is_numeric($selection1['threshold']) && is_numeric($selection1['americanPrice']) && !$showfield)?'secret':'';
		
		$secretContainer=(!$showfield)?'secret':'';
		
		$teamNameHome = $period['homeTeam']['teamName'];
		$teamNameAway = $period['awayTeam']['teamName'];
		if ($betType=='total') {
			$teamNameHome='';
			$teamNameAway = '';
		}
		if ($selectionDaw['showField'] && !empty($selectionDaw))
                        $showfieldDraw = true;
                else
                        $showfieldDraw = false;
                
		$html.='<div class="table-games bet containerForMasiveToggle '.$secretContainer.' '.($overview_layout == "american" ? "" : " group ").'" id="'.$gameContainerID.'" order="" >'.
				'<div data-toggle="collapse" href="#'.$gameContainerWrapID.'" class="title collapsed '.($overview_layout == "american" ? "" : " title ").'" aria-expanded="">'.
					'<div class="'.($overview_layout == "american" ? "label" : "label-european").'">'.strtoupper( __($this->dictionary($period['periodDescription'])) ).' '.strtoupper($betType).
					'<div class="toggle-icon"></div>'.
                                '</div>'.
				'</div>'.
				'<div id="'.$gameContainerWrapID.'" class="'.$classBetOpen.'">'.
					'<ul class="selectionList row sort">';
						$secret=(is_numeric($selection1['threshold']) && is_numeric($selection1['americanPrice']) && !$showfield)?'secret':'';
						$price = $formatPriceAmerican ? $selection1['americanPrice'] : $selection1['decimalPrice'];
						$html.='<li class="addToBetslip '.$col.' '.$secret.'" id="'.$selectionContainerId1.
									'" selectionid="'.$selection1['selectorId'].
									'"chosenTeamID="'.$chosenTeamIDHome.
									'"groupDescription="'.$period['periodDescription'].
									'"betDescription = "'.$betDescription.
									'"betTypeis = "'.$selection1['betTypeis'].
									'"mainBet="'.$period['mainBet'].
									'"dec = "'.$selection1['decimalPrice'].
									'"us  = "'.$selection1['americanPriceSF'].
									'"gamenum = "'.$period['gameNum'].
									'"periodNumber = "'.$period['periodNumber'].
									'"threshold = "'.$selection1['thresholdSF'].
									'"totalPointsOU= "'.$selection1['totalPointsOU'].
									'"sportType= "'.$sport.
									'"sportSubType= "'.$league.
									'"listedPitcher1 = "'.ucwords(strtolower($period['listedPitcher1'])).
									'"listedPitcher2 = "'.ucwords(strtolower($period['listedPitcher2'])).
									'"isParlay = "'.$period['isParlay'].
									'"isStraight = "'.$period['isStraight'].
									'"isTeaser = "'.$period['isTeaser'].
							   '" >'.
							'<div class="selectionTable" '.$heightSel.'>'.
								'<div class="selectionFix">'.( $overview_layout == "american" ? (
									'<div class="selectionDesc" style="text-align: center;">'.$teamNameHome.'</div>'.
									'<div class="noWrap" style="text-align: center;">'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$threshold1.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>') : 
									'<div class="noWrap" style="text-align: center;">'.
                                                                                '<span class="selectionDesc-european">'.$teamNameHome.'</span>'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$threshold1.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>').
								'</div>'.
							'</div>'.
						'</li>';
						$secret=(is_numeric($selection2['threshold']) && is_numeric($selection2['americanPrice']) && !$showfield)?'secret':'';
						$price = $formatPriceAmerican ? $selection2['americanPrice'] : $selection2['decimalPrice'];
						$html.='<li class="addToBetslip '.$col.' '.$secret.'" id="'.$selectionContainerId2.
									'"selectionid="'.$selection2['selectorId'].
									'"chosenTeamID="'.$chosenTeamIDAway.
									'"groupDescription="'.$period['periodDescription'].
									'"betDescription = "'.$betDescription.
									'"betTypeis = "'.$selection2['betTypeis'].
									'"mainBet="'.$period['mainBet'].
									'"dec = "'.$selection2['decimalPrice'].
									'"us  = "'.$selection2['americanPriceSF'].
									'"gamenum = "'.$period['gameNum'].
									'"periodNumber = "'.$period['periodNumber'].
									'"threshold = "'.$selection2['thresholdSF'].
									'"totalPointsOU= "'.$selection2['totalPointsOU'].
									'"sportType= "'.$sport.
									'"sportSubType= "'.$league.
									'"listedPitcher1 = "'.$period['listedPitcher1'].
									'"listedPitcher2 = "'.$period['listedPitcher2'].
									'"isParlay = "'.$period['isParlay'].
									'"isStraight = "'.$period['isStraight'].
									'"isTeaser = "'.$period['isTeaser'].
							   '">'.
							'<div class="selectionTable" '.$heightSel.'>'.
								'<div class="selectionFix">'.( $overview_layout == "american" ? (
									'<div class="selectionDesc" style="text-align: center;">'.$teamNameAway.'</div>'.
									'<div class="noWrap" style="text-align: center;">'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$threshold2.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>') : 
									'<div class="noWrap" style="text-align: center;">'.
                                                                                '<span class="selectionDesc-european">'.$teamNameAway.'</span>'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$threshold2.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>').
								'</div>'.
							'</div>'.
						'</li>';
						
						
						
						if($showfieldDraw){
							$secret=(is_numeric($selectionDaw['threshold']) && is_numeric($selectionDaw['americanPrice']) && ($showfieldDraw))?'secret' : '';
							$price = $formatPriceAmerican ? $selectionDaw['americanPrice'] : $selectionDaw['decimalPrice'];
							$html.='<li class="addToBetslip '.$col.' '.$secret.'" id="'.$selectionContainerIdDraw.
										'"selectionid="'.$selectionDaw['selectorId'].
										'"chosenTeamID="'.$period['draw']['teamName'].
										'"groupDescription="'.$period['periodDescription'].
										'"betTypeis = "'.$selectionDaw['betTypeis'].
										'"mainBet="'.$period['mainBet'].
										'"dec = "'.$selectionDaw['decimalPrice'].
										'"us  = "'.$selectionDaw['americanPriceSF'].
										'"gamenum = "'.$period['gameNum'].
										'"periodNumber = "'.$period['periodNumber'].
										'"threshold = "'.$selectionDaw['threshold'].
										'"sportType= "'.$sport.
										'"sportSubType= "'.$league.
										'"listedPitcher1 = "'.$period['listedPitcher1'].
										'"listedPitcher2 = "'.$period['listedPitcher2'].
										'"isParlay = "'.$period['isParlay'].
										'"isStraight = "'.$period['isStraight'].
										'"isTeaser = "'.$period['isTeaser'].
									'">'.
							'<div class="selectionTable" '.$heightSel.'">'.
								'<div class="selectionFix">'.( $overview_layout == "american" ? (
									'<div class="selectionDesc" style="text-align: center;">'.__("Draw").'</div>'.
									'<div class="noWrap" style="text-align: center;">'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$selectionDaw['threshold'].'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>') : 
									'<div class="noWrap" style="text-align: center;">'.
                                                                                '<span class="selectionDesc-european">'.__("Draw").'</span>'.
										'<span class="selectionThreshold threshold '.($overview_layout == "american" ? "" : " threshold-european ").'">'.$selectionDaw['threshold'].'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>').
								'</div>'.
							'</div>'.
						'</li>';
						}
					$html.='</ul>'.
				'</div>'.
				$comments.
			'</div>';
		}else{ // team total
		
			$showfield = true;
			
			if ($selection1['showField'])
				$showfield = true;
			else
				$showfield = false;
			
		
			$threshold1 = $selection1['totalPointsOU'].''.$selection1['threshold'];
			$threshold2 = $selection2['totalPointsOU'].''.$selection2['threshold'];
			
			$chosenTeamID1=$period[$selectionTeam]['teamName'];
			$chosenTeamID2=$period[$selectionTeam]['teamName'];
			
			$betDescription1 = $selection1['betTypeDesc']." - ".$selection1['totalPointsOUDesc'];
			$betDescription2 = $selection2['betTypeDesc']." - ".$selection2['totalPointsOUDesc'];;
			
			$secretContainer=(!$showfield)?'secret':'';
			$html.='<div class="table-games bet containerForMasiveToggle '.$secretContainer.'" id="'.$gameContainerID.'" order="">'.
				'<div data-toggle="collapse" href="#'.$gameContainerWrapID.'" class="title" aria-expanded="">'.
					'<div class="label">'.strtoupper( __($this->dictionary($period['periodDescription'])) ).' TOTAL '.strtoupper($period[$selectionTeam]['teamName']).'</div>'.
					'<div class="toggle-icon"></div>'.
				'</div>'.
				'<div id="'.$gameContainerWrapID.'" class="'.$classBetOpen.'">'.
					'<ul class="selectionList row sort">';
						$price = $formatPriceAmerican ? $selection1['americanPrice'] : $selection1['decimalPrice'];
						$html.='<li class="addToBetslip '.$col.'" id="'.$selectionContainerId1.
									'"selectionid="'.$selection1['selectorId'].
									'"chosenTeamID="'.$chosenTeamID1.
									'"groupDescription="'.$period['periodDescription'].
									'"betTypeis = "'.$selection2['betTypeis'].
									'"betDescription = "'.$betDescription1.
									'"mainBet="'.$period['mainBet'].
									'"dec = "'.$selection1['decimalPrice'].
									'"us  = "'.$selection1['americanPriceSF'].
									'"gamenum = "'.$period['gameNum'].
									'"periodNumber = "'.$period['periodNumber'].
									'"threshold = "'.$selection1['threshold'].
									'"sportType= "'.$sport.
									'"sportSubType= "'.$league.
									'"listedPitcher1 = "'.$period['listedPitcher1'].
									'"listedPitcher2 = "'.$period['listedPitcher2'].
									'"isParlay = "'.$period['isParlay'].
									'"isStraight = "'.$period['isStraight'].
									'"isTeaser = "'.$period['isTeaser'].
									'" order="">'.
							'<div class="selectionTable" '.$heightSel.'>'.
								'<div class="selectionFix">'.
									'<div class="selectionDesc" style="text-align: center;"></div>'.
									'<div class="noWrap" style="text-align: center;">'.
										'<span class="selectionThreshold threshold">'.$threshold1.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>'.
								'</div>'.
							'</div>'.
						'</li>';
						$price = $formatPriceAmerican ? $selection2['americanPrice'] : $selection2['decimalPrice'];
						$html.='<li class="addToBetslip '.$col.'" id="'.$selectionContainerId2.
									'"selectionid="'.$selection2['selectorId'].
									'"chosenTeamID="'.$chosenTeamID2.
									'"groupDescription="'.$period['periodDescription'].
									'"betTypeis = "'.$selection2['betTypeis'].
									'"betDescription = "'.$betDescription2.
									'"mainBet="'.$period['mainBet'].
									'"dec = "'.$selection2['decimalPrice'].
									'"us  = "'.$selection2['americanPriceSF'].
									'"gamenum = "'.$period['gameNum'].
									'"periodNumber = "'.$period['periodNumber'].
									'"threshold = "'.$selection2['threshold'].
									'"sportType= "'.$sport.
									'"sportSubType= "'.$league.
									'"listedPitcher1 = "'.$period['listedPitcher1'].
									'"listedPitcher2 = "'.$period['listedPitcher2'].
									'"isParlay = "'.$period['isParlay'].
									'"isStraight = "'.$period['isStraight'].
									'"isTeaser = "'.$period['isTeaser'].
									'"order="">'.
							'<div class="selectionTable" '.$heightSel.'>'.
								'<div class="selectionFix">'.
									'<div class="selectionDesc" style="text-align: center;"></div>'.
									'<div class="noWrap" style="text-align: center;">'.
										'<span class="selectionThreshold threshold">'.$threshold2.'</span>'.
										'<span class="selectionOdds odds">'.$price.'</span>'.
									'</div>'.
								'</div>'.
							'</div>'.
						'</li>';
					$html.='</ul>'.
				'</div>'.
				$comments.
			'</div>';
		}
		return $html;
	}
	
	public function colSelectionContainer($sel1, $sel2, $draw){
		$num=3;
		if(empty($sel1['threshold']) && empty($sel1['americanPrice']))
		   $num--;
		   
		if(empty($sel2['threshold']) && empty($sel2['americanPrice']))
		   $num--;
		 
		if($draw==null || (empty($draw['threshold']) && empty($draw['americanPrice'])))
		   $num--;
                
		return ($num==3) ? 'col-xs-4': (($num==2) ? 'col-xs-6': 'col-xs-12');
	}
	

}
