<?php
App::uses('AppController', 'Controller');
App::uses('Model', 'Model');

class Sportbook  extends AppModel{
	var $wsClient;
	
	public function Sportbook(){
		$this->wsClient=new WsClient();
	}
        
	/**
	 * This method returns the sports and leagues according to a customer
	 * in order to build the left menu 
	 */
	public function getCustomerSportsAndLeagues($CustomerID,$site){
            return $this->wsClient->call('PreGameSiteLinesService', 'getSportsAndLeagues', array("CustomerID" =>$CustomerID, "ForLeftMenu"=>1, "Site"=>$site));
	}
	
	public function getCustomerBalance($CustomerID){
		return $this->wsClient->call('accounts', 'getCustomerBalance', array(	"account" =>$CustomerID, 
																				"session" =>"",
																				"appid"=>"",
																				"userid"=>""));
	}
 
	public function placeBetStraight($CustomerID, $selections, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID){
            return $this->wsClient->call('PreGameSiteBetService', 'straight', array(	"CustomerID" =>$CustomerID, 
                                                                                        "selections" =>$selections,
                                                                                        "freePlayChecked"=>$freePlayChecked,
                                                                                        "oddsStyle"=>$oddsStyle,                    
                                                                                        "globalRiskAmount"=>$globalRiskAmount,
                                                                                        "globalToWinAmount"=>$globalToWinAmount,
                                                                                        "AgentID" =>$AgentID));
	}
	
	public function placeBetParlay($CustomerID, $selections, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID){		
            return $this->wsClient->call('PreGameSiteBetService', 'parlay', array(  "CustomerID" =>$CustomerID, 
                                                                                    "selections" =>$selections,
                                                                                    "freePlayChecked"=>$freePlayChecked,
                                                                                    "oddsStyle"=>$oddsStyle,
                                                                                    "globalRiskAmount"=>$globalRiskAmount,
                                                                                    "globalToWinAmount"=>$globalToWinAmount,
                                                                                    "AgentID" =>$AgentID));
	}
	
	public function placeBetRoundRobin($CustomerID, $selections, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $roundRobinType, $AgentID){
            return $this->wsClient->call('PreGameSiteBetService', 'roundRobin', array(	"CustomerID" =>$CustomerID, 
                                                                                        "selections" =>$selections,
                                                                                        "freePlayChecked"=>$freePlayChecked,
                                                                                        "oddsStyle"=>$oddsStyle,
                                                                                        "globalRiskAmount"=>$globalRiskAmount,
                                                                                        "globalToWinAmount"=>$globalToWinAmount,
                                                                                        "roundRobinType"=>$roundRobinType,
                                                                                        "AgentID" =>$AgentID));
	}
	
	public function placeBetTeaser($CustomerID, $selections, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $teaserType, $AgentID){
            return $this->wsClient->call('PreGameSiteBetService', 'teaser', array(  "CustomerID" =>$CustomerID, 
                                                                                    "selections" =>$selections,
                                                                                    "freePlayChecked"=>$freePlayChecked,
                                                                                    "oddsStyle"=>$oddsStyle,
                                                                                    "globalRiskAmount"=>$globalRiskAmount,
                                                                                    "globalToWinAmount"=>$globalToWinAmount,
                                                                                    "TeaserName"=>$teaserType,
                                                                                    "AgentID" =>$AgentID));
	}
	
	public function placeBetIfBet($CustomerID, $selections, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $AgentID, $globalRiskAmount, $globalToWinAmount){
            return $this->wsClient->call('PreGameSiteBetService', 'ifBet', array(   "CustomerID" =>$CustomerID, 
                                                                                    "selections" =>$selections,
                                                                                    "freePlayChecked"=>$freePlayChecked,
                                                                                    "oddsStyle"=>$oddsStyle,
                                                                                    "ContinueOnPushFlag"=>$ContinueOnPushFlag,
                                                                                    "AgentID" =>$AgentID,
                                                                                    "globalRiskAmount"=>$globalRiskAmount,
                                                                                    "globalToWinAmount"=>$globalToWinAmount));
	}
	
	public function placeBetReverse($CustomerID, $selections, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $reverseAmount, $AgentID, $globalRiskAmount, $globalToWinAmount){
	    return $this->wsClient->call('PreGameSiteBetService', 'reverse', array( "CustomerID" =>$CustomerID, 
                                                                                    "selections" =>$selections,
                                                                                    "freePlayChecked"=>$freePlayChecked,
                                                                                    "oddsStyle"=>$oddsStyle,
                                                                                    "ContinueOnPushFlag"=>$ContinueOnPushFlag,
                                                                                    "reverseAmount"=>$reverseAmount,
                                                                                    "AgentID" =>$AgentID,
                                                                                    "globalRiskAmount"=>$globalRiskAmount,
                                                                                    "globalToWinAmount"=>$globalToWinAmount));
	}
	
	public function getDelay($CustomerID, $selections){
		return 0;
	}
	
	public function getSiteCache($CustomerID,$agentID, $store, $sportsAndLeagues){
		$data=array();
		$fullCustomer=$this->getCustomer($CustomerID, $agentID);
		$customer=array(); 
		
		$customer['FreePlayBalance']=@$fullCustomer['FreePlayBalance'];
		$customer['CustomerID']=@$fullCustomer['CustomerID'];
		$customer['AgentID']=@$fullCustomer['AgentID'];
		$customer['AvailableBalance']=@$fullCustomer['Available'];
		$customer['CurrentBalance']=@$fullCustomer['Current'];
		$customer['PendingWager']=@$fullCustomer['PendingWager'];
		$customer['FreePlayPendingBalance']=@$fullCustomer['FreePlayPendingBalance'];
		$customer['CasinoBalance']=@$fullCustomer['Casino'];
		$customer['BaseballAction']=@$fullCustomer['BaseballAction'];
		$customer['ParlayMaxBet']=@$fullCustomer['ParlayMaxBet'];
		$customer['ParlayMaxPayout']=@$fullCustomer['ParlayMaxPayout'];
        $customer['PriceType']=@$fullCustomer['PriceType'];
		$customer['PriceType']=@$fullCustomer['PriceType'];
		$customer['parlayInfo']=$this->getCustomerParlayInfo($CustomerID);
		$customer['teasers']=$this->getCustomerTeasers($CustomerID);
	
		//$data = $this->getLinesAndProps($CustomerID, $sportsAndLeagues);
		
		$data['lines'] = $this->getLinesCustomer($CustomerID, $sportsAndLeagues);
		$data['list_sports'] = $this->listSports($fullCustomer['CustomerID']);
		$data['customer'] = $customer;
		
		return $data;
	}
	
	public function getGamesLines($CustomerID, $SportType, $SportSubType, $ScheduleText, $GameNum){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['SportType']=$SportType;
		$parameters['SportSubType']=$SportSubType;
		$parameters['ScheduleText']=$ScheduleText;
		$parameters['GameNum']=$GameNum;
		$parameters['forceOpenGame']="1";
		
		return $this->wsClient->call('PreGameSiteLinesService', 'getLines', $parameters);
	}
        
    public function getLinesAndProps($CustomerID, $sportsAndLeagues){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['Sports']=null;
		$parameters['Leagues']=(!empty($sportsAndLeagues['leagues']) ? $sportsAndLeagues['leagues'] : 'DEFAULT');
		return $this->wsClient->call('PreGameSiteLinesService', 'getCustomerLinesAndProps', $parameters);
	}
	
	public function getLinesCustomer($CustomerID, $otherParams){

		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['Sports']=(!empty($otherParams['sports']) ? $otherParams['sports'] : null);
		$parameters['Leagues']=(!empty($otherParams['leagues']) ? $otherParams['leagues'] : null);
		$parameters['Period']=(!empty($otherParams['leagues']) ? $otherParams['periods']:null);
		$parameters['ScheduleText']=(!empty($otherParams['scheduleText']) ? $otherParams['scheduleText'] : null);

		return $this->wsClient->call('PreGameSiteLinesService', 'getCustomerLines', $parameters);
	}
	
	public function getPeriodLeagues($CustomerID, $Sports, $Leagues, $ScheduleText){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['Sports']=(!empty($Sports) ? $Sports : null);
		$parameters['Leagues']=(!empty($Leagues) ? $Leagues : null);
		$parameters['ScheduleText']=(!empty($ScheduleText) ? $ScheduleText : null);
		
		return $this->wsClient->call('PreGameSiteLinesService', 'getPeriodLeagues', $parameters);
	}
	
	public function getGamesProps($CustomerID, $SportType){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['SportType']=$SportType;
		$parameters['forceOpenGame']="1";
		return $this->wsClient->call('PreGameSiteLinesService', 'getProps', $parameters);
	}
	
	public function getFutureProps2($CustomerID, $ContestNum){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['GameNum']=$ContestNum;
		
		return $this->wsClient->call('PreGameSiteLinesService', 'getFutureProps', $parameters);
	}
	
	
	public function getFuturePropsPerSport($parameters){
		
		return $this->wsClient->call('PreGameSiteLinesService', 'getCustomerFutureProps', $parameters);
	}
	
	public function getGamesFutureProps($CustomerID, $SportType, $SportSubType, $ScheduleText, $GameNum){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
		$parameters['SportType']=$SportType;
		$parameters['SportSubType']=$SportSubType;
		$parameters['ScheduleText']=$ScheduleText;
		$parameters['GameNum']=$GameNum;
		$parameters['forceOpenGame']="1";
		return $this->wsClient->call('PreGameSiteLinesService', 'getFuturProps', $parameters);
	}
	
	
	public function getCustomer($CustomerID, $agentID){
					
		$customerBalances=$this->wsClient->call('accounts', 'getCustomerBalance', array("account" =>$CustomerID, 
																						"session"=>$agentID,
																						"appid"=>'kris',
																						"userid"=>'kris'));
		
		$customerBalances=array_pop($customerBalances);
		
		
		$customer=$this->wsClient->call('accounts', 'getAccountFullInfo', array("account" =>$CustomerID, 
																			"agent"=>$agentID,
																			"appid"=>"kris",
																			"userid"=>"kris"));
		
		
		$customer=array_pop($customer);
		
		if($customer!=null && $customerBalances!=null && is_array($customer) && is_array($customerBalances)){
			$customer=array_merge($customer, $customerBalances);
			ksort($customer);
		}
		return $customer;
	}
	
	/**
	 * get info Game
	 * 
	 * @param string $CustomerID 
	 * @param string $GameNum    
	 * 
	 * @return array $game
	 */
	public function getGame($CustomerID, $GameNum){
		$lines=$this->getGamesLines($CustomerID, '', '', '', $GameNum);
		foreach($lines['games'] as $game)
			return $game;
		return null;
	}
	
	/**
	 * get Customer Parlay Info
	 * 
	 * @param string $CustomerID 
	 * 
	 * @return array info parlay
	 */
	public function getCustomerParlayInfo($CustomerID){
		$ownParlays=$this->wsClient->call('accounts', 'getOwnParlay', array(	"account" =>$CustomerID, 
																				"session"=>'kris',
																				"appid"=>'kris',
																				"userid"=>'kris'));
		$ownParlay=array_pop($ownParlays);
		$parlayDetails=$this->wsClient->call('accounts', 'getParlayDetail', array(	"account" =>$CustomerID,
																					"parlaycat"=>'',
																					"parlayname"=>$ownParlay['ParlayName'],
																					"appid"=>'kris',
																					"userid"=>'kris'));
		
		return array("ownParlay"=>$ownParlay, "parlayDetails"=>$parlayDetails);
	}
	
	/**
	 * get Customer Teasers
	 * 
	 * @param string $CustomerID Name customer
	 * @return Array $teasers
	 */
	public function getCustomerTeasers($CustomerID){
		$teasers=$this->wsClient->call('PreGameSiteTeaserService', 'getTeasersCustomer', array("CustomerID" =>$CustomerID));
		ksort($teasers);
		return $teasers;
	}
	
	/**
	 * get Customer Limits
	 * 
	 * @param string $CustomerID    
	 * @param string $AgentID       
	 * @param string $betType       
	 * @param array $selections     
	 * @param string $roundRobinType
	 * 
	 * @return Type    Description
	 */
	public function getCustomerLimits($CustomerID, $AgentID, $betType, $selections, $roundRobinType, $freePlayChecked, $site){
		if(count($selections)>0){
			return $this->wsClient->call('PreGameSiteLimitsService', 'getAllBetsLimits', array(	"CustomerID"=>$CustomerID,
                                                                                                                "AgentID"=>$AgentID,
                                                                                                                "selections"=>$selections, 
                                                                                                                "roundRobinType"=>$roundRobinType,
                                                                                                                "isFreePlay"=>$freePlayChecked,
                                                                                                                "site"=>$site));
		}
		return array();
	}
	
	
	/**
	 * get Wagers Report
	 * 
	 * @param string $CustomerID 
	 * @param string $startDate  
	 * @param string $endDate    
	 * @param string $pending    
	 * @param string $start      
	 * @param string $end        
	 * @param string $openBets   
	 * 
	 * @return Object json : info wager
	 */
	public function getWagersReport($CustomerID, $startDate, $endDate, $pending, $openBets){
            $startDate = $startDate." 00:00:00";
            $endDate = $endDate." 23:59:59";
            $list = array("CustomerID" =>$CustomerID, "startDate" =>$startDate
                        , "endDate" =>$endDate, "pending" =>$pending, "openBets" =>$openBets);
            return $this->wsClient->call('PreGameSiteWagersReportService', 'getCustomerWagers',$list);
	}
        
        public function getWagersReport2($CustomerID, $startDate, $endDate, $pending, $openBets) {
            $startDate = $startDate . " 00:00:00";
            $endDate = $endDate . " 23:59:59";
            $list = array("CustomerID" => $CustomerID, "startDate" => $startDate
                , "endDate" => $endDate, "pending" => $pending, "openBets" => $openBets);
            return $this->wsClient->call('PreGameSiteWagersReportService', 'getCustomerWagersPendingRep', $list);
        }

        public function getGradedTicketsByDate($CustomerID, $startDate, $endDate, $pending, $openBets) {
            $startDate = $startDate . " 00:00:00";
            $endDate = $endDate . " 23:59:59";
            $list = array("CustomerID" => $CustomerID, "startDate" => $startDate
                , "endDate" => $endDate, "pending" => $pending, "openBets" => $openBets);
            return $this->wsClient->call('PreGameSiteWagersReportService', 'getGradedTicketsByDate', $list);
        }
        
	public function getAccountHistory($CustomerID, $freePlayBit,$iniDate,$endDate){
		return $this->wsClient->call('PreGameSiteWagersReportService', 'getTransactionInfo', array("CustomerID" =>$CustomerID, "FreePlay"=>$freePlayBit,"UserID"=>"kris","BeginDateTime"=>$iniDate,"EndDateTime"=>$endDate));
	}
        
	public function getAccountPrevBalance($params){
		return $this->wsClient->call('PreGameSiteWagersReportService', 'getAccountPrevBalance', $params);
	}
        
	public function getTransactionDetails($params) {
		return($this->wsClient->call('PreGameSiteWagersReportService', 'getTicketInfoByTrans', $params));
	}
	
	public function getTransactionWagerDetails($params) {
		return($this->wsClient->call('PreGameSiteWagersReportService', 'getTransWagerDetails', $params));
	}
        
	public function getweeklyBalance($CustomerID,$endDate) {
		return($this->wsClient->call('PreGameSiteWagersReportService', 'getDailyWeekBalance', array("customerID" => $CustomerID,"endDate"=>$endDate)));
	}	
	
	public function listSports($customer, $forLeftMenu = null){
		$parameters=array("CustomerID"=>$customer, "ForLeftMenu"=>$forLeftMenu);
		$sports = $this->call('PreGameSiteLinesService', 'getSportsAndLeagues', $parameters);
		return $sports;
	}
	
    /**
     * 
     * @param type $CustomerID
     * @param type $ticketNumber
     * @return type
     * Get All Wagers tickets and some description like date and wager type. also is used in get wager detail
     * Note:  $day  are 3  combinations   [$day = 2  are 2 days || $day = 3 are 15  diays || $day = 4 are 30 dias],  days selected for the report 
     */
    public function m_getWager($CustomerID, $day, $appid, $userid) {
        return($this->wsClient->call('wager', 'getWagers', array("account" => $CustomerID, "dia" => $day, "appid" => $appid, "userid" => $userid)));
    }
	
	public function m_getWaggerdetail($player, $doc, $wager,$appid,$userid){
		return $this->wsClient->call('wager', 'getDetail', array("account" => $player, "tikect" => $doc, "wager" => $wager, "appid" => $appid, "userid" => $userid));
	}
	
    public function getDailyFigures($CustomerID, $stardate) {
        return($this->wsClient->call('wager', 'getDailyFigures', array("account" => $CustomerID, "stardate" => $stardate,
					"appid" => "", "userid" => "kris")));
    }
	
	public function getAgentTemplateDesing($param) {
        return($this->wsClient->call('PreGameSiteService', 'getAgentTemplateDesing', $param));
    }
	
	public function getDetailTemplate($param) {
        return($this->wsClient->call('PreGameSiteService', 'getDetailTemplate', $param));
    }
	
	public function getTemplateLiveName($param){
		 return($this->wsClient->call('PreGameSiteService', 'getTemplateLiveName', $param));
	}
	
	public function getTemplateLive($param){
		 return($this->wsClient->call('PreGameSiteService', 'getTemplateLive', $param));
	}
	
	public function checkForPrevBetOnGame($gameNum, $wagerType, $CustomerID){
	    return $this->wsClient->call('PreGameSiteService', 'getCountPrevBetsOnGame', array( "CustomerID" =>$CustomerID, "gameNum" =>$gameNum, "wagerType"=>$wagerType));
	}
	
	public function getSelectedGame($params){
		return $this->wsClient->call('PreGameSiteLinesService', 'getCustomerProps', $params);
	}
        
    public function getCustomerBuyPoints($CustomerID){
            return $this->wsClient->call('PreGameSiteSellPointsService', 'getBuyPoints', array("CustomerID" =>$CustomerID));
    }
        
    public function getCustomerSellPoints($CustomerID){
            return $this->wsClient->call('PreGameSiteSellPointsService', 'getSellPoints', array("CustomerID" =>$CustomerID));
    }
    
    public function saveFavorites($type,$data,$CustomerID){
        return $this->wsClient->call('PreGameSiteService', 'saveNewFavorite', array("CustomerID" =>$CustomerID,"Type"=>$type,"Data"=>$data));
    }
    
    public function getFavorites($CustomerID){
        return $this->wsClient->call('PreGameSiteService', 'getFavorites', array("CustomerID" =>$CustomerID));
    }
    
    public function deleteFavorites($type,$data,$CustomerID){
        return $this->wsClient->call('PreGameSiteService', 'deleteFavorite', array("CustomerID" =>$CustomerID,"Type"=>$type,"Data"=>$data));
    }
    
    public function getOpenGamesForSearch($CustomerID,$app,$user){
        return $this->wsClient->call('cashierService', 'getOpenGamesForSearch', array("company" =>$CustomerID,"appid"=>$app,"userid"=>$user));
    }
    
    public function getOverviewLinesCustomer($CustomerID,$period,$site,$games,$minutes,$formatDisplay){
		$parameters=array();
		$parameters['CustomerID']=$CustomerID;
        $parameters['Period']=$period;
		$parameters['Site']=$site;		
        $parameters['Minutes']=$minutes;
		$parameters['FormatDisplay']=(!empty($formatDisplay) ? $formatDisplay : null);
        if($games != null && $games != ""){
            $parameters['Games'] = $games;
        }
                                
		return $this->wsClient->call('PreGameSiteLinesService', 'getCustomerOverviewUpcomingGamesLines', $parameters);
	}
}
    

