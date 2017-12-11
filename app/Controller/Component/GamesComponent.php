<?php
App::uses('Component', 'Controller');
class GamesComponent extends Component {
	
	public function searchSelectionInfo($lines, $selectionId){
		foreach($lines['games'] as $game)
			foreach($game['groups'] as $group)
				foreach($group['bets'] as $bet)
					foreach($bet['selections'] as $selection)
						if($selection['id']==$selectionId){
							$data=array();
							
							$data['selection']=$selection;
							$data['bet']=$bet;
							$data['group']=$group;

							unset($data['bet']['selections']);
							unset($data['group']['bets']);
							return $data;
						}
		return null;
	}
	
	public function getAvailableSportsCategories($games){
		$categories=array();
		foreach($games as $game){
			if($game['enable']){
				if($game['SportType']=='Soccer'){
					$categories[$game['SportType']][$game['ScheduleText']]["ScheduleText"]=$game['ScheduleText'];
					$categories[$game['SportType']][$game['ScheduleText']]["SportSubType"]=$game['SportSubType'];
				}
				else{
					$categories[$game['SportType']][$game['SportSubType']]["ScheduleText"]=$game['ScheduleText'];
					$categories[$game['SportType']][$game['SportSubType']]["SportSubType"]=$game['SportSubType'];
				}
			}
		}
		return $categories;
	}
	
    public function groupGamesLinesByPeriod($games){
		$periods=array();
		foreach($games as $game){
			$groups=$game['groups'];
			foreach($groups as $periodIndex => $group){
				$periods[$periodIndex]['id']=$periodIndex;
				$periods[$periodIndex]['description']=$group['description'];
				$periods[$periodIndex]['games'][$game['GameNum']]=$game;
				$periods[$periodIndex]['games'][$game['GameNum']]['bets']=$group['bets'];
				unset($periods[$periodIndex]['games'][$game['GameNum']]['groups']);
			}
		}
		ksort($periods);
		
		$category['enable']=false;
		$category['periods']=$periods;
		foreach($category['periods'] as &$period){
			$period['enable']=false;
			foreach($period['games'] as &$game){
				$game['enable']=false;
				foreach($game['bets'] as $bet){
					if($bet['enable']){
						$game['enable']=true;
						$period['enable']=true;
						$category['enable']=true;
						break;
					}
				}
			}
		}
		return $category;
    }
}