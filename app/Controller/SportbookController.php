<?php

App::uses('AppPregameSiteController', 'Controller');

class SportbookController extends AppController {

    var $layout = 'sportbook_layout';
    public $components = array('Cookie');
    
    public $uses = array('Sportbook', 'PvReports');

    public function beforeFilter() {
        parent::beforeFilter();
        $userAuth = $this->Auth->user();
        if (@$userAuth['app'] != 'pregamesite')
            $this->Auth->logout();
    }

    /**
     * logout
     */
    public function logout() {
        $this->Auth->logout();
        $this->redirect($this->Auth->logout());
    }
    private function getSportOrder($sportType){

        $sportsOrder['football']=1;
        $sportsOrder['basketball']=2;
        $sportsOrder['baseball']=3;
        $sportsOrder['hockey']=4;
        $sportsOrder['tennis']=5;
        $sportsOrder['soccer']=6;
        $sportsOrder['Other Sports']=7;
        $order = $sportsOrder[strtolower($sportType)];

        return $order;   
    }
    
    public function getDescPeriodShort(){
        $periodDesc[0]='Game';
        $periodDesc[1]='1H';
        $periodDesc[2]='2H';
        $periodDesc[3]='1Q';
        $periodDesc[4]='2Q';
        $periodDesc[5]='3Q';
        $periodDesc[6]='4Q';
        return $periodDesc;   
    }
    
    private function getTimeZone($timeZone){
        $timeZoneDesc[0]="America/New_York";
        $timeZoneDesc[1]="America/Chicago";
        $timeZoneDesc[2]="America/Denver";
        $timeZoneDesc[3]="America/Los_Angeles";
        
        return $timeZoneDesc[$timeZone]; 
    }
    
    
    /**
     * get info site compressed
     */
    public function getsitecachecompresed() {
        $this->layout = 'ajax';
        $gamenumString = @$_POST["gamenum"];
        $gamenum = "0";
        $categories = "";
        $finalcategori = "";
        if ($gamenumString !== "") {
            $gamenumArray = explode("@", $gamenumString);
            $gamenum = $gamenumArray[1];
            $otherca = explode(" ", $gamenumArray[0]);
            $othercat = explode("-", $otherca[0]);
            $newcategor = $othercat[0] . "_" . $othercat[1];
            $newcategor = '{"' . $newcategor . '":"' . $newcategor . '"}';
            $categories = json_decode($newcategor);
            $finalcategori = $newcategor;
        } else {
            $categories = json_decode((isset($_POST["categori"]) ? $_POST["categori"] : ""));
            $finalcategori = $_POST["categori"];
        }

        $categories = json_decode((isset($_COOKIE["selectedCategories"]) ? $_COOKIE["selectedCategories"] : ""));
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];

        $priceType = $this->request->data('priceType');
        $otherParams = $this->getSportsAndLeaguesForQuery($CustomerID, $categories);
        $sizeBody = $this->request->data('sizeBody');
        if ($this->request->data('period')){
          $otherParams['periods']=$this->request->data('period'); 
        }

        return $this->getDetailLines($CustomerID, $otherParams, $sizeBody, $priceType);
     
        $this->set('data', $result);
        $this->render('json');
    }

    /**
     * get Sports And Leagues For Query
     *
     * @param {string} $CustomerID
     *
     * @return {array} $result
     */
    public function getLoadLine() {
        $this->layout = 'ajax';
        $detailLines = '';
        $sizeBody = $this->request->data('sizeBody');
        $priceType = $this->request->data('priceType');
        $schedules = $this->request->data('schedules');

        $params = array(); 
        $params['sports']=$this->request->data('sportType');
        $params['leagues']=$this->request->data('league');
        $params['scheduleText']=$this->request->data('scheduleText');
        $params['periods']=$this->request->data('period');
        $params['value']=$this->request->data('value');
        
        $params['isFavorite']=$this->request->data('isFavorite') == "true" ? true : false;
        $params['isOverview']=$this->request->data('isOverview') == "true" ? true : false;
        $params['isUpcoming']=$this->request->data('isUpcoming') == "true" ? true : false;

        $authLogin = $this->Auth->login();

        if ($params['scheduleText'] == ""){
            //return $this->getDetailLinesOnlyTitles($params, $schedules);
            $groupIdPadre = strtolower($this->sanitiazeId('group_'.$params['sports']."_".$params['leagues']));
            $detailLines = '<div id="'.$groupIdPadre.'">';
            foreach($schedules as $category){
                $params['scheduleText'] = $category;
                $params['groupIdPadre'] = $groupIdPadre;
                $detailLines = $detailLines.$this->getDetailLines($params, $sizeBody, $priceType);
            }
            $detailLines = $detailLines.'</div>';

        }else{
            $detailLines = $this->getDetailLines($params, $sizeBody, $priceType);
        }
        return new CakeResponse(array('body' => $detailLines)); 

    }

    /**
     * get info site compressed 
     */
    public function updatePeriod() {
        $this->layout = 'ajax';

        $params = array(); 
        $params['sports']=$this->request->data('sportType');
        $params['leagues']=$this->request->data('league');
        $params['periods']=$this->request->data('period');
        $params['scheduleText']=$this->request->data('scheduleText');
        $params['value']=$this->request->data('value');
        
        $sizeBody = $this->request->data('sizeBody');        
        $priceType = $this->request->data('priceType');
        
        $detailLines = $this->getDetailLines($params, $sizeBody, $priceType);
        return new CakeResponse(array('body' => $detailLines)); 
    }
    
    private function getDetailLines($otherParams, $sizeBody, $priceType){
        $view = new View($this, false);
        $site = $this->domain["domain"];
        $otherParams['site']=$site;

        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $timeZone = $authUser['fullCustomerInfo']['TimeZone'];
        $displayFormat = strtolower(($this->domain["formatDisplay"] != "") ? $this->domain["formatDisplay"] : "american");
            
        $otherParams['overview_layout'] = $displayFormat;   
        $otherParams['isOverviewButAmericanLayout'] = false;
        if($otherParams['isOverview']){
            $otherParams['isOverviewButAmericanLayout'] = $otherParams['overview_layout'] == "american";
            $otherParams['overview_layout'] = "european";
        }        
        
        
        $countMarketsToRest = 0;
        
        if($otherParams['isFavorite']){
            $result = $this->Sportbook->getFavoriteLinesCustomer($CustomerID, @$otherParams["games"], isset($otherParams["favoriteSelectedPeriod"]) ? $otherParams["favoriteSelectedPeriod"] : null,isset($otherParams['site']) ? $otherParams["site"] : null);
            $periodsInfo = $result["periods"];
            $gamenumBySportAndLeague = $result["gamenums"];
            $result = $result["lines"];
        }else if($otherParams['isOverview']){
            
            $minutes = $otherParams["isUpcoming"] ? 60 : 1440;
            
            $result = $this->Sportbook->getOverviewLinesCustomer($CustomerID, 0 ,isset($otherParams['site']) ? $otherParams["site"] : null, @$otherParams["games"], $minutes,$otherParams['overview_layout']);
            $periodsInfo = $result["periods"];
            $gamenumBySportAndLeague = $result["gamenums"];
            $result = $result["lines"];
        }else{
            $result = $this->Sportbook->getLinesCustomer($CustomerID, $otherParams);
        }
        $detailLines = '';
        $formatPriceAmerican = false;
                
        //price equal american
        if ((strcmp($priceType,"A") == 0)){
            $formatPriceAmerican = true;
        }
        
       
        if (!empty($result)){
        
            foreach ($result as $row) {
       
                if(sizeof($row["games"]) == 0 && $otherParams['isOverview']){
                    continue;
                }
              
                $groupId='';
                $groupIdPadre = '';
                $sportType = trim($row["sportType"]);
                $periodSelected = $row["periodNumber"];

                if ($row["scheduleText"] ==""){
                     $groupId = $this->sanitiazeId("group_".$row["sportType"]."_".$row["sportSubType"]);
                }
                else{
                    $groupId = $this->sanitiazeId("group_".$row["sportType"]."_".$row["sportSubType"]."_".$row["scheduleText"]);
                    $groupIdPadre = $this->sanitiazeId("group_".$row["sportType"]."_".$row["sportSubType"]);
                }
                
                $periods = array();
                $gamenumsForPeriods = array();
                if($otherParams['isFavorite'] || $otherParams['isOverview']){
                    $periods = $periodsInfo[$row["sportType"]][$row["sportSubType"]];
                    $countPeriod = count($periods);
                    $gamenumsForPeriods = $gamenumBySportAndLeague[$row["sportType"]][$row["sportSubType"]];
                    
                }else{
                    $periods = $this->Sportbook->getPeriodLeagues($CustomerID, $row["sportType"], $row["sportSubType"], $row["scheduleText"],$site);
                    $countPeriod = count($periods);                           
                    $countMarketsToRest=0;                    
                }
                
                //Draw each detailed row with information line
                $parameters=array(
                    "groupId" => $groupId,
                    "groupIdPadre" => $groupIdPadre,
                    "sportsOrder" => trim($this->getSportOrder($row["sportType"])),
                    "title" => trim($row["titleLine"]),
                    "periodSelected" => trim($periodSelected),
                    "periods" => $periods,
                    "periodsDescShort" => $this->getDescPeriodShort(),
                    "games" => $row["games"],
                    "scheduleText" => trim($row["scheduleText"]),                    
                    "sportType" => $sportType,
                    "sportSubType" => trim($row["sportSubType"]),
                    "sizeBody" => $sizeBody,
                    "formatPriceAmerican" => $formatPriceAmerican,
                    "timeZone" => $this->getTimeZone($timeZone),
                    "update" => $update,
                    "isFavorite" => $otherParams['isFavorite'],
                    "isOverview" => $otherParams['isOverview'],
                    "gamenumsForPeriods" => $gamenumsForPeriods,
                    "countPeriod" => $countPeriod,
                    "overview_layout" => $otherParams['overview_layout'],
                    "isOverviewButAmericanLayout" => $otherParams['isOverviewButAmericanLayout'],
                    "isUpcoming" => $otherParams["isUpcoming"],
                    "countMarketsToRest" => $countMarketsToRest);
                $this->set("isFavorite",$otherParams['isFavorite']);
                $this->set("isOverview",$otherParams['isOverview']);
                $this->set("isUpcoming",$otherParams['isUpcoming']);
                
                $detailLines .= $view->element('Sportbook/detailLines', $parameters);
            }
        }
        return $detailLines;   
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
        $replace = str_replace("Ç", "",trim($replace));
	    $replace = str_replace("[^\w\s]/g", "",trim($replace));
	    $replace = str_replace(":", "",trim($replace));
	    $replace = strtolower($replace);        
		return $replace;
	}
    
    public function getSelectedGame(){
        $view = new View($this, false);
        $authUser = $this->Auth->user();
        $customerId = $authUser['customerId'];
        $gameNum = $this->request->data('gameNum');
        $periodNum = $this->request->data('periodNum');
        $sport = $this->request->data('sport');
        $league = $this->request->data('league');
        $selectedGameNum = $this->request->data('selectedGameNum');
        $priceType = $this->request->data('priceType');
        $schedule = (trim(strtoupper($sport))=='SOCCER') ? $this->request->data('schedule') : null;
        
        $displayFormat = strtolower(($this->domain["formatDisplay"] != "") ? $this->domain["formatDisplay"] : "american");
               
        $formatPriceAmerican = false;
        //price equal american
        if ((strcmp($priceType,"A") == 0)){
            $formatPriceAmerican = true;
        }
       
        if(!isset($gameNum))
            return null;
        
        $params = array("CustomerID"=> $customerId,
                        "Sports"=> $sport,
                        "Leagues"=> $league,
                        "ScheduleText"=> $schedule,
                        "Period"=> null,
                        "GameNum"=> $gameNum);
        
        $result = $this->Sportbook->getSelectedGame($params);
        
        $detailGame = $view->element('Sportbook/detailSelectedGame',
                                     array('data'=>$result,
                                           'selectedGameNum'=>$selectedGameNum,
                                           'sport'=>$sport,
                                           'league'=> $league,
                                           'scheduleText'=> $schedule,
                                           'formatPriceAmerican' => $formatPriceAmerican,
                                           'overview_layout' => $displayFormat));
       
        return new CakeResponse(array('body' => $detailGame)); 
    }    
   
     public function getLoadFutureProps(){
        $view = new View($this, false);
        $authUser = $this->Auth->user();
		$customerId = $authUser['customerId'];
        $sport = $this->request->data('sport');
        $priceType = $this->request->data('priceType');

        $formatPriceAmerican = false;
        //price equal american
        if ((strcmp($priceType,"A") == 0)){
            $formatPriceAmerican = true;
        }
        
        $params = array("CustomerID"=> $customerId,
                        "GameNum"=> null,
                        "Sport"=> $sport);
        $result = $this->Sportbook->getFuturePropsPerSport($params);
        $detailFutureProp = $view->element('Sportbook/detailFuturePropsPerGame', array('data'=>$result, 'sport'=>$sport, 'formatPriceAmerican'=>$formatPriceAmerican));

        return new CakeResponse(array('body' => $detailFutureProp)); 
    }
    
    
    /**
     * get Sports And Leagues For Query
     * 
     * @param {string} $CustomerID
     * 
     * @return {array} $result
     */
    private function getSportsAndLeaguesForQuery($CustomerID,$selectedCategories){
        
        $result = array(
            "sports" => array(),
            "leagues" => array(),
            "scheduleText" => array(),
            "periods" => array()
        );
        
        if(isset($selectedCategories)){
            $categories = $selectedCategories;
            $listSportsDB = $this->Sportbook->listSports($CustomerID, 1);
        
            foreach($categories as $category){
                foreach($listSportsDB as $id => $sportDB){
                    foreach($sportDB as $leagueDB){
                        if(trim($leagueDB['subCategoryID']) == trim($category) && $leagueDB['OriginalLeague'] != 'FUTURE PROPS'){
                            $result['sports'][]=$id;
                            $result['leagues'][]=trim($leagueDB['OriginalLeague']);
                            $result['periods'][]=0;

                            $subCategory = '-';
                            if (strcmp(strtoupper($leagueDB['OriginalLeague']),strtoupper($leagueDB['subCategory'])) != 0)
                                $subCategory = $leagueDB['subCategory'];
    
                            $result['scheduleText'][] = $subCategory;
        }
        
        if (!empty($result)){           
            foreach ($result as $row) {
                $groupId='';
                if ($row["sportType"] == 'Soccer'){
                    $groupId = $this->sanitiazeId("group_".$row["sportType"]."_".$row["scheduleText"]);
                }else{
                    $groupId = $this->sanitiazeId("group_".$row["sportType"]."_".$row["sportSubType"]);
                }
                
                $periods = $this->Sportbook->getPeriodLeagues($CustomerID, $row["sportType"], $row["sportSubType"], $row["scheduleText"]);
                
                //Draw each detailed row with information line
                $parameters=array(
                    "groupId" => $groupId,
                    "sportsOrder" => trim($this->getSportOrder($row["sportType"])),
                    "title" => trim($row["titleLine"]),
                    "periodSelected" => trim($row["periodNumber"]),
                    "periods" => $periods,
                    "periodsDescShort" => $this->getDescPeriodShort(),
                    "games" => $row["games"],
                    "scheduleText" => trim($row["scheduleText"]),                    
                    "sportType" => trim($row["sportType"]),
                    "sportSubType" => trim($row["sportSubType"]),
                    "sizeBody" => $sizeBody,
                    "formatPriceAmerican" => $formatPriceAmerican);
                $detalleLineas .= $view->element('Sportbook/detailLines', $parameters);
            }
        }
        return new CakeResponse(array('body' => $detalleLineas));   
    }
    
        return $this->concatSportsAndLeagues($result);
	}
            }
        }
    }

    /**
     * concatenacion array Sports And Leagues
     * 
     * @param {array} $selections Description
     * 
     * @return {array} $result
     */
    private function concatSportsAndLeagues($selections){
        $result = array();
        $result['sports'] = implode(',', $selections['sports']);
        $result['leagues'] = implode(',', $selections['leagues']);
        $result['scheduleText'] = implode(',', $selections['scheduleText']);
        $result['periods'] = implode(',', $selections['periods']); 
        return $result;
    }

    /**
     * get selections limits
     */
    public function getselectionslimits() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
       $CustomerID = @$_POST["fullcustomerAgent"];
        $AgentID = $authUser['agentId'];

        $selections = json_decode(urldecode(trim($this->request->data["selectionsOnBetslip"])), true);
        $sels = array();
        foreach ($selections as $selection) {
            array_push($sels, $selection);
        }
        $roundRobinType = trim($this->request->data["roundrobinType"]) == "" ? 2 : trim($this->request->data["roundrobinType"]);
        $freePlayChecked = "N";
        
        if (isset($this->request->data['isFreePlay']))
            $freePlayChecked = $this->request->data['isFreePlay']; 
        
        $limits = array();
        if (!empty($sels))
            $limits = $this->Sportbook->getCustomerLimits($CustomerID, $AgentID, 'straight', $sels, $roundRobinType, $freePlayChecked, $this->domain["inetTarget"]);
        $this->set('data', $limits);
        $this->render('json');
    }

    /**
     * get delay of customer
     */
    public function getdelay() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $AgentID = $authUser['agentId'];

        $data['delay'] = $this->Account->getAccountFullInfo(array(   "account" =>$CustomerID, 
                                                    "session" =>"CM",
                                                    "agent"=>$AgentID,
                                                    "appid"=>"CM",
                                                    "userid"=>"kris"))["row1"]["ConfirmationDelay"];

        $data = array();
        $data['delay'] = $this->Sportbook->getDelay($CustomerID, $selectionsOnBetslip);
        $this->set('data', $data);
        $this->render('json');
    }

    /**
     * Placebet: insertion betting
     */
    public function placebet() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $AgentID = $authUser['agentId'];
        $CustomerID = @$_POST["fullcustomerAgent"];
        
        $selections = json_decode(urldecode(trim($this->request->data["selectionsOnBetslip"])), true);
        $sels = array();
        foreach ($selections as $selection) {
            array_push($sels, $selection);
        }

        $betslitpType = "straight";
        if (isset($this->request->data['betslitpType']))
            $betslitpType = $this->request->data['betslitpType'];

        $freePlayChecked = "N";
        if (isset($this->request->data['isFreePlay']))
            $freePlayChecked = $this->request->data['isFreePlay'];        

        $globalRiskAmount = "";
        if (isset($this->request->data['globalRiskAmount']))
            $globalRiskAmount = $this->request->data['globalRiskAmount'];

        $globalToWinAmount = "";
        if (isset($this->request->data['globalToWinAmount']))
            $globalToWinAmount = $this->request->data['globalToWinAmount'];

        $reverseAmount = "";
        if (isset($this->request->data['reverseAmount']))
            $reverseAmount = $this->request->data['reverseAmount'];

        $roundRobinType = "2";
        if (isset($this->request->data['roundRobinType']))
            $roundRobinType = $this->request->data['roundRobinType'];

        $teaserType = "";
        if (isset($this->request->data['teaserType']))
            $teaserType = $this->request->data['teaserType'];

        $ContinueOnPushFlag = "";
        if (isset($this->request->data['ContinueOnPushFlag']))
            $ContinueOnPushFlag = $this->request->data['ContinueOnPushFlag'];

        $oddsStyle = Constants::ODDS_STYLE_US;
        if (isset($_COOKIE['LineTypeFormat']) && trim($_COOKIE['LineTypeFormat']) == "Decimal")
            $oddsStyle = "DECIMAL";

        $delay = $this->Account->getAccountFullInfo(array(  "account" =>$CustomerID, 
                                                            "session" =>"CM",
                                                            "agent"=>$AgentID,
                                                            "appid"=>"CM",
                                                            "userid"=>"kris"))["row1"]["ConfirmationDelay"];
        
        if(!is_numeric($delay)){
            $delay = 0;
        }
        
        sleep($delay);
        $failedInsertions=array();
        $placeBetResult = array();
        $transactionResponse=NULL;
        if ($betslitpType == 'straight') {
            foreach ($sels as $sel) {
                $result = $this->Sportbook->placeBetStraight($CustomerID, $sel, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID);
                if($result["status"]=='1'){
                    $transactionResponse=$this->setDepositoXTiquete($result["ticket"]["items"][0]["risk"], $result["ticket"]["ticketNumber"], $CustomerID);
                    if($transactionResponse["row1"]["status"]==null){
                        array_push($result,$sel["ChosenTeamID"]);
                        array_push($result,$sel["betType"]);
                        array_push($placeBetResult,$result );
                    }else{
                        $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
                        array_push($placeBetResult, $result);
                    }
                }else{
                    array_push($placeBetResult, $result);
                }
            }
        }
        if ($betslitpType == 'parlay') {
            $result=$this->Sportbook->placeBetParlay($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID);
            if($result["status"]=='1'){
                $transactionResponse=$this->setDepositoXTiquete($result["ticket"]["items"][0]["risk"], $result["ticket"]["ticketNumber"], $CustomerID);
                if(!isset($transactionResponse["row1"]["status"])||$transactionResponse["row1"]["status"]==null){
                    array_push($result,$sel["ChosenTeamID"]);
                    array_push($result,$sel["betType"]);
                    array_push($placeBetResult,$result );
                }else{
                    $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
                    array_push($placeBetResult, $result);
                }
            }else{
                array_push($placeBetResult, $result);
            }
        }
//        if ($betslitpType == 'rndrobin') {
//            array_push($placeBetResult, $this->Sportbook->placeBetRoundRobin($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $roundRobinType, $AgentID));
//            if($result["status"]=='1'){
//            $transactionResponse=$this->setDepositoXTiquete($placeBetResult[0]["ticket"]["items"][0]["risk"], $placeBetResult[0]["ticket"]["ticketNumber"], $CustomerID);
//            if($transactionResponse["row1"]["status"]==null){
//                    array_push($result,$sel["ChosenTeamID"]);
//                    array_push($result,$sel["betType"]);
//                    array_push($placeBetResult,$result );
//                }else{
//                    $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
//                    array_push($placeBetResult, $result);
//                }
//        }
        if ($betslitpType == 'teaser') {
            $result=$this->Sportbook->placeBetTeaser($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $teaserType, $AgentID);
            if($result["status"]=='1'){
                $transactionResponse=$this->setDepositoXTiquete($result["ticket"]["items"][0]["risk"], $result["ticket"]["ticketNumber"], $CustomerID);
                if(!isset($transactionResponse["row1"]["status"])||$transactionResponse["row1"]["status"]==null){
                    array_push($result,$sel["ChosenTeamID"]);
                    array_push($result,$sel["betType"]);
                    array_push($placeBetResult,$result );
                }else{
                    $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
                    array_push($placeBetResult, $result);
                }
            }else{
                array_push($placeBetResult, $result);
            }
        }
//        if ($betslitpType == 'ifbet') {
//            array_push($placeBetResult, $this->Sportbook->placeBetIfBet($CustomerID, $sels, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $AgentID, $globalRiskAmount, $globalToWinAmount));
//            $transactionResponse=$this->setDepositoXTiquete($placeBetResult[0]["ticket"]["items"][0]["risk"], $placeBetResult[0]["ticket"]["ticketNumber"], $CustomerID);
//            if($transactionResponse["row1"]["status"]==null){
//                    array_push($result,$sel["ChosenTeamID"]);
//                    array_push($result,$sel["betType"]);
//                    array_push($placeBetResult,$result );
//                }else{
//                    $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
//                    array_push($placeBetResult, $result);
//                }
//        }
//        if ($betslitpType == 'reverse') {
//            array_push($placeBetResult, $this->Sportbook->placeBetReverse($CustomerID, $sels, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $reverseAmount, $AgentID, $globalRiskAmount, $globalToWinAmount));
//            $transactionResponse=$this->setDepositoXTiquete($placeBetResult[0]["ticket"]["items"][0]["risk"], $placeBetResult[0]["ticket"]["ticketNumber"], $CustomerID);
//            if($transactionResponse["row1"]["status"]==null){
//                    array_push($result,$sel["ChosenTeamID"]);
//                    array_push($result,$sel["betType"]);
//                    array_push($placeBetResult,$result );
//                }else{
//                    $result=array("status"=>$transactionResponse["row1"]["status"],"ChosenTeamID"=>$sel["ChosenTeamID"]);
//                    array_push($placeBetResult, $result);
//                }
//        }
        $printArray=array();
        foreach ($placeBetResult as $pbr) {
            if($pbr['status']=='1'){
                array_push($pbr, $printArray);
            }
            if (isset($pbr['ticket']) && isset($pbr['ticket']['items'])) {
                foreach ($pbr['ticket']['items'] as $index => $item) {
                    if (isset($pbr['ticket']['items'][$index]['gameDate'])) {
                        $date = strtotime($pbr['ticket']['items'][$index]['gameDate']);
                        $date = date("m/d/Y H:i", $date);
                        $pbr['ticket']['items'][$index]['gameDate'] = $date;
                    }
                }
            }
        }

        $this->set('data', $placeBetResult);
        $this->render('json');
    }
    
    private function revertTicketInsertion($ticket){
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $results=$this->Cashier->revertTicketInsertion(array("company"=>$CustomerID,"ticketnumber"=>$ticket,"appid"=>"","userid"=>""));
        return $results;
    }
    
    

    private function setDepositoXTiquete($monto, $ticket, $accountCustID) {
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $AgentID = $authUser['agentId'];
        $userName = $authUser['username'];
        $boxId = $authUser['caja'];
        $CashierID = $authUser['cashierId'];
        $branchID=$this->domain["BranchID"];
        $exit = !(strtoupper($accountCustID) == strtoupper($CustomerID));

        if ($exit) {
            $monto = 0;
        }
        $results = $this->Cashier->setDepositoXTiquete(array("company" => $accountCustID,
            "boxID" => $boxId,
            "cashierID" => $CashierID,
            "branchID" => "1",
            "monto" => $monto,
            "docnum" => $ticket,
            "exit" => $exit,
            "cajero" => $accountCustID,
            "agentid" => $accountCustID,
            "username" => $accountCustID,
            "appid" => $AgentID,
            "userid" => $CustomerID,
            "branchID" => $branchID));
        return $results;
    }

    public function getTeamsforFind() {
        $string = @$_POST["teamName"];
        $palabra;
        $rot;
        if (is_numeric($string)) {
            $palabra = "";
            $rot = (int) $string;
        } else {
            $palabra = $string;
            $rot = 0;
        }
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $results = $this->PvReports->getTeamsforFind(array("CustomerID" => $CustomerID, "palabra" => $palabra, "rot1" => $rot));

        return new CakeResponse(array('body' => json_encode($results)));
    }

    public function index($play = NULL) {

        $authUser = $this->Auth->User();
        $player = isset($play) ? $play : $authUser['player'];
        $response = $this->Account->getAccountFullInfo(array("account" => trim($player), "root" => $authUser['root'], 'appid' => 'POS', 'userid' => $authUser['root']));
        $customerPersonal = (isset($response['row1'])) ? $response['row1'] : $response;
        $fullCustomer = $this->Sportbook->getCustomer(trim($player), trim($authUser['root']), trim($authUser['username']));
        
        $this->set('parlayInfo', $this->Sportbook->getCustomerParlayInfo($player));
        $this->set('teasers', $this->Sportbook->getCustomerTeasers($player));
        $this->set('usersAuth', $this->Auth->user());
        $this->set('customerPersonal', $customerPersonal);
        $this->set('fullCustomer', $fullCustomer);
        $this->set('authCustomerID', $authUser['player']);
        $this->set('availableCategories', $this->Sportbook->getCustomerSportsAndLeagues($player, $this->domain['domain']));
        $this->set('formatDisplay',$this->domain["formatDisplay"]);
        $this->set('betTypes',$this->domain["betTypes"]);
        $this->set('betConfig',$this->domain["betConfig"]);
        $this->set('favorites', $this->normalizeFavorites($this->Sportbook->getFavorites($CustomerID)));   
    }
    
    public function getOpenGamesForSearch(){
        $authUser = $this->Auth->User();
        $CustomerID = $authUser['player'];
        $gamesForSearch=$this->Sportbook->getOpenGamesForSearch($CustomerID,'POS',$authUser['root']);
        return new CakeResponse(array('body' => json_encode($gamesForSearch)));
    }

    /**
     * load Wagers
     */
    public function loadWagers() {
//        //sleep(3);
        $this->layout = 'ajax';
        $date = date('Y-m-d');
        $newdate = strtotime('-15 day', strtotime($date));
        $olddate = date('Y-m-d', $newdate);
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $wagersReport = $this->Sportbook->getWagersReport($CustomerID, $olddate, $date, $this->request->query["pending"], $this->request->query["openBets"]);
        $this->set('data', $wagersReport);
        $this->render('json');
    }

    public function loadWagersPendRep() {
        $this->layout = 'ajax';
        $date = date('Y-m-d');
        $newdate = strtotime('-15 day', strtotime($date));
        $olddate = date('Y-m-d', $newdate);
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $wagersReport = $this->Sportbook->getWagersReport2($CustomerID, $olddate, $date, $this->request->query["pending"], $this->request->query["openBets"]);
        $this->set('data', $wagersReport);
        $this->render('json');
    }

    /**
     *
     * @return \CakeResponse
     * por cada juego seleccionado  vamos a mostrar  datos de las jugadas
     */
    public function getWagerdetail() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $doc = $this->request->query["doc"];
        $wager = $this->request->query["wager"];
        $wagers = array();
        $wagers['wagersdetail'] = $this->Sportbook->m_getWaggerdetail($CustomerID, $doc, $wager, 0, 0);
        $this->set('data', $wagers);
        $this->render('json');
    }

    /**
     * load Ticket Lines
     */
    public function loadTicketLines() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $ticketNumber = $this->request->query["TicketNumber"];
        $loadTicketLines = array();
        $loadTicketLines['lines'] = $this->Sportbook->getTicketLines($CustomerID, $ticketNumber);
        $loadTicketLines['props'] = $this->Sportbook->getTicketProps($CustomerID, $ticketNumber);
        $this->set('data', $loadTicketLines);
        $this->render('json');
    }

    /**  the method. Get it data from at least 1 year ago.
     * Get  Account History Report
     */
    public function loadAccountHistory() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $freePlay = @$_POST["freePlay"];
        $endDate = new DateTime();
        $iniDate = new DateTime();
        date_sub($iniDate, date_interval_create_from_date_string('15 days'));
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getAccountHistory($CustomerID, $freePlay, date_format($iniDate, 'Y-m-d'), date_format($endDate, 'Y-m-d'));
        $this->set('data', $loadAccHis);
        $this->render('json');
    }

    public function loadTransactionDetails() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $transactionID = @$_POST["transactionID"];
        $CustomerID = $authUser['player'];
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getTransactionDetails(array("CustomerID" => $CustomerID, "DocumentNumber" => $transactionID));
        $this->set('data', $loadAccHis);
        $this->render('json');
    }

    public function getTransWagerDetails() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $transactionID = @$_POST["transactionID"];
        $CustomerID = $authUser['player'];
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getTransactionWagerDetails(array("customerID" => $CustomerID, "transactionID" => $transactionID));
        $this->set('data', $loadAccHis);
        $this->render('json');
    }

    public function getWeeklyBalance() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $endDate = @$_POST["endDate"];
        $loadAccHis = array();

        $endDate = "20160731";

        $loadAccHis['data'] = $this->Sportbook->getweeklyBalance($CustomerID, $endDate);

        $this->set('data', $loadAccHis);
        $this->render('json');
    }

    public function loadDailyWagers() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $date = @$_POST["date"];
        $CustomerID = $authUser['player'];
        $wagersReport = $this->Sportbook->getWagersReport2($CustomerID, $date, $date, 0, 0);
        $this->set('data', $wagersReport);
        $this->render('json');
    }

    public function getDailyTransactions() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $date = @$_POST["date"];
        $CustomerID = $authUser['player'];
        $wagersReport = $this->Sportbook->getDailyFigures($CustomerID, $date);
        $this->set('data', $wagersReport);
        $this->render('json');
    }

    /**
     * get Detail Games UpComming Pregame
     */
    public function setCustomerslineFormat() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $formatType = trim($this->request->data('formatType'));
        $response = null;
        if ($formatType == 'A' || $formatType == 'D') {
            $response = $this->Account->setCustomerslineFormat(array("account" => $CustomerID, "lineFormat" => $formatType, "appid" => "AgentAdmin", "userid" => "kris"));
        }
        $this->set('data', $response);
        $this->render('json');
    }

    public function getDetailOverviewLive(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $data = $this->Account->getLiveGameDetail(array("CustomerID" => $CustomerID, 'appid' => 'pregamesite', 'userid' => $CustomerID));
        
        $finalArray = array();
        
        if(is_array($data)){
            foreach($data as $row){
                if(!isset($finalArray[$row["SportType"]]))
                    $finalArray[$row["SportType"]] = array();

                array_push($finalArray[$row["SportType"]], $row);
            }
        }
     
        $view = new View($this, false);
        $body = $view->element('Sportbook/liveOverview', array("sports"=>$finalArray));
        
        return new CakeResponse(array('body' => $body)); 
    }
    
    public function getAccountPrevBalance() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['player'];
        $iniDate = new DateTime();
        date_sub($iniDate, date_interval_create_from_date_string('14 days'));
        $response = $this->Sportbook->getAccountPrevBalance(array("customerID" => $CustomerID, "endDate" => date_format($iniDate, 'Y-m-d')));
        $this->set('data', $response);
        $this->render('json');
    }

    public function getLessVariables() {
        $this->layout = "ajax";
        $this->autoRender = false;
        $detailTemplate = $this->Session->read("user_template");
        $txt = "";
        if (empty($detailTemplate)) {
            $txt = "@color-Menus: #2f3c42;@color-MenusText: #ffffff;@color-MenusHover: #1462FC;@color-Buttons: #4ea74e;
				@color-Buttons-White: #CBCCCC;@color-SubHeaders: #999999;@color-Warning: #c12e2a;@color-Notes: #ffffb3;
				@color-black: #000000;@color-dropdown: #313c42;@color-menubetslip: #8A8A8A;@color-betslip-selections-messages: #333333;
				@color-betslip-panel-default: #DFDFDF;@color-betslip-modal-header: #facc2e;@color-caution: #030536;
				@color-MenusTextBold: #fa5736;@color-Background-body: #ffffff;@color-Background-tables: #ffffff;
				@color-Background-betslip: #ffffff;@color-Background-header: #ffffff;@color-Background-footer: #ffffff;";
        } else {
            $detailTemplate = (isset($detailTemplate["results"]) ? $detailTemplate["results"] : $detailTemplate);
            foreach ($detailTemplate as &$detail) {
                $txt .= "@" . trim(urldecode($detail["DetailName"])) . ": " . trim(urldecode($detail["Value"])) . ";\n";
            }
        }

        $this->response->body($txt);
        $this->response->type(array('less' => 'text/less'));
        $this->response->type('less');
        return $this->response;
    }

    public function getPermissionAjax() {
        $data = $this->Auth->user();

        $param = trim($this->request->data('param'));

        $res = false;
        foreach ($data as $key => $row) {
            if ($key == $param) {
                if ($row == true || $row == 'Y') {
                    $res = true;
                }
            }
        }
        return new CakeResponse(array('body' => json_encode($res)));
    }

    public function getAvaliableAjax() {
        $authUser = $this->Auth->User();
        $play = trim($this->request->data('customer'));
        $player = isset($play) ? $play : $authUser['player'];
        $customer = $this->Sportbook->getCustomer(trim($player), trim($authUser['root']), trim($authUser['username']));
        $avaliable = round((float) $customer['Available'], 2);

        return new CakeResponse(array('body' => json_encode($customer)));
    }

    public function getUserPoints(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];        
        $buyPoints = $this->Sportbook->getCustomerBuyPoints($CustomerID);
        $sellPoints = $this->Sportbook->getCustomerSellPoints($CustomerID);
        $this->set('data', array("sell"=>$sellPoints, "buy"=>$buyPoints));
        $this->render('json');
    }
    
    public function saveFavorite(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId']; 
        $type = $this->request->data("type");
        $data = $this->request->data("dataString");
        $this->Sportbook->saveFavorites($type,$data,$CustomerID);
        echo json_encode(array("result"=>"success", "favorites"=>$this->normalizeFavorites($this->Sportbook->getFavorites($CustomerID))));
    }
    
    public function deleteFavorite(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId']; 
        $type = $this->request->data("type");
        $data = $this->request->data("dataString");
        $this->Sportbook->deleteFavorites($type,$data,$CustomerID);
        echo json_encode(array("result"=>"success", "favorites"=>$this->normalizeFavorites($this->Sportbook->getFavorites($CustomerID))));
    }
    
     public function normalizeFavorites($favorites){
        $leagues = array();
        $games = array();
        if(isset($favorites["league"])){
            foreach($favorites["league"] as $league){
                array_push($leagues, json_decode(urldecode($league)));                
            }
        }
        if(isset($favorites["game"])){
            foreach($favorites["game"] as $game){
                array_push($games, json_decode(urldecode($game)));                
            }
        }
        return array("league"=>$leagues, "game"=>$games);
    }
            



   }
