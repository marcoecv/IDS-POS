<?php

App::uses('AppPregameSiteController', 'Controller');

class Sportbook2Controller extends AppController {

    var $layout = 'sportbook_layout';
    
    public $components = array('Cookie');

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

   /**
     * get info site compressed 
     */
    public function getsitecachecompresed() {
        $this->layout = 'ajax';
        
        $categories = json_decode((isset($_COOKIE["selectedCategories"]) ? $_COOKIE["selectedCategories"] : ""));
        $result = array();
        if(!empty($categories)){
            $authUser = $this->Auth->user();
            $CustomerID = $authUser['customerId'];
            $agentID = $authUser['agentId'];
            $store = $authUser['store'];
            $querySportsAndLeagues = $this->getSportsAndLeaguesForQuery($CustomerID);
            $result['compressedData'] = $this->Sportbook->getSiteCacheCompresed($CustomerID, $agentID, $store, $querySportsAndLeagues);
        }
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
    private function getSportsAndLeaguesForQuery($CustomerID){
        $result = array(
            "sports" => array(),
            "leagues" => array()
        );
       
        if(isset($_COOKIE["selectedCategories"])){
            $categories = json_decode($_COOKIE["selectedCategories"]);
            
            $listSportsDB = $this->Sportbook->listSports($CustomerID, 1);
            
            foreach($categories as $category){
                foreach($listSportsDB as $id => $sportDB){
                    foreach($sportDB as $leagueDB){
                        if(trim($leagueDB['subCategoryID']) == trim($category) && $leagueDB['OriginalLeague'] != 'FUTURE PROPS'){
                            $result['sports'][]=$id;
                            $result['leagues'][]=trim($leagueDB['OriginalLeague']);
                        }
                    }
                }
            }
        }
        
        return $this->concatSportsAndLeagues($result);
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
        return $result;
    }

    /**
     * get selections limits 
     */
    public function getselectionslimits() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $AgentID = $authUser['agentId'];
        
        $selections=json_decode(urldecode(trim($this->request->data["selectionsOnBetslip"])), true);
        $sels = array();
        foreach($selections as $selection){
            array_push($sels, $selection);
        }
        $roundRobinType = isset($_COOKIE['roundRobinType']) ? $_COOKIE['roundRobinType'] : 2;

        $limits = array();
        if (!empty($sels))
            $limits = $this->Sportbook->getCustomerLimits($CustomerID, $AgentID, 'straight', $sels, $roundRobinType);
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

        $selectionsOnBetslip = array();
        if (isset($_COOKIE['selectionsOnBetslip']))
            $selectionsOnBetslip = json_decode($_COOKIE['selectionsOnBetslip'], true);

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
        $CustomerID = $authUser['customerId'];
        $AgentID = $authUser['agentId'];
        
        $selections=json_decode(urldecode(trim($this->request->data["selectionsOnBetslip"])), true);
        $sels = array();
        foreach($selections as $selection){
            array_push($sels, $selection);
        }

        $betslitpType = "straight";
        if (isset($_COOKIE['betslitpType']))
            $betslitpType = $_COOKIE['betslitpType'];
        
        $freePlayChecked = "N";
        if (isset($_COOKIE['isFreePlay']))
            $freePlayChecked = $_COOKIE['isFreePlay'];        
        
        $globalRiskAmount = "";
        if (isset($_COOKIE['globalRiskAmount']))
            $globalRiskAmount = $_COOKIE['globalRiskAmount'];

        $globalToWinAmount = "";
        if (isset($_COOKIE['globalToWinAmount']))
            $globalToWinAmount = $_COOKIE['globalToWinAmount'];

        $reverseAmount = "";
        if (isset($_COOKIE['reverseAmount']))
            $reverseAmount = $_COOKIE['reverseAmount'];

        $roundRobinType = "2";
        if (isset($_COOKIE['roundRobinType']))
            $roundRobinType = $_COOKIE['roundRobinType'];

        $teaserType = "";
        if (isset($_COOKIE['teaserType']))
            $teaserType = $_COOKIE['teaserType'];

        $ContinueOnPushFlag = "";
        if (isset($_COOKIE['ContinueOnPushFlag']))
            $ContinueOnPushFlag = $_COOKIE['ContinueOnPushFlag'];

        $oddsStyle = Constants::ODDS_STYLE_US;
        if (isset($_COOKIE['LineTypeFormat']) && trim($_COOKIE['LineTypeFormat']) == "Decimal")
            $oddsStyle = "DECIMAL";

        $delay = $this->Sportbook->getDelay($CustomerID, $sels);
        sleep($delay);

        $placeBetResult = null;
        
        if ($betslitpType == 'straight')
            $placeBetResult = $this->Sportbook->placeBetStraight($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID);

        if ($betslitpType == 'parlay')
            $placeBetResult = $this->Sportbook->placeBetParlay($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $AgentID);

        if ($betslitpType == 'rndrobin')
            $placeBetResult = $this->Sportbook->placeBetRoundRobin($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $roundRobinType, $AgentID);

        if ($betslitpType == 'teaser')
            $placeBetResult = $this->Sportbook->placeBetTeaser($CustomerID, $sels, $freePlayChecked, $oddsStyle, $globalRiskAmount, $globalToWinAmount, $teaserType, $AgentID);

        if ($betslitpType == 'ifbet')
            $placeBetResult = $this->Sportbook->placeBetIfBet($CustomerID, $sels, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $AgentID, $globalRiskAmount, $globalToWinAmount);

        if ($betslitpType == 'reverse')
            $placeBetResult = $this->Sportbook->placeBetReverse($CustomerID, $sels, $freePlayChecked, $oddsStyle, $ContinueOnPushFlag, $reverseAmount, $AgentID, $globalRiskAmount, $globalToWinAmount);

        if(isset($placeBetResult['ticket']) && isset($placeBetResult['ticket']['items'])){
            foreach($placeBetResult['ticket']['items'] as $index => $item){
                if(isset($placeBetResult['ticket']['items'][$index]['gameDate'])){
                    $date = strtotime($placeBetResult['ticket']['items'][$index]['gameDate']);
                    $date = date("m/d/Y H:i", $date);
                    $placeBetResult['ticket']['items'][$index]['gameDate'] = $date;
                }
            }        
        }
        
        $this->set('data', $placeBetResult);
        $this->render('json');
    }    
        
    public function index() {
        $authUser = $this->Auth->User();
        $CustomerID = $authUser['customerId'];        
        $this->set('parlayInfo', $this->Sportbook->getCustomerParlayInfo($CustomerID));
        $this->set('teasers', $this->Sportbook->getCustomerTeasers($CustomerID));
        $this->set('usersAuth', $this->Auth->user());
        $this->set('availableCategories', $this->Sportbook->getCustomerSportsAndLeagues($CustomerID));
    }

    /**
     * load Wagers
     */
    public function loadWagers() {
//        //sleep(3);
        $this->layout = 'ajax';
        $date = date('Y-m-d');
        $newdate = strtotime ( '-15 day' , strtotime ( $date ) ) ;
        $olddate = date ( 'Y-m-d' , $newdate );
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId']; 
        $wagersReport = $this->Sportbook->getWagersReport($CustomerID, $olddate, $date, $this->request->query["pending"],$this->request->query["openBets"]);
        $this->set('data', $wagersReport);
        $this->render('json');  
    }
    
    
    public function loadWagersPendRep() {
        $this->layout = 'ajax';
        $date = date('Y-m-d');
        $newdate = strtotime ( '-15 day' , strtotime ( $date ) ) ;
        $olddate = date ( 'Y-m-d' , $newdate );
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId']; 
        $wagersReport = $this->Sportbook->getWagersReport2($CustomerID, $olddate, $date, $this->request->query["pending"],$this->request->query["openBets"]);
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
        $CustomerID = $authUser['customerId'];
        $doc = $this->request->query["doc"];
        $wager = $this->request->query["wager"];
        $wagers = array();
        $wagers['wagersdetail'] = $this->Sportbook->m_getWaggerdetail($CustomerID, $doc, $wager,0,0);
        $this->set('data', $wagers);
        $this->render('json');
    }
    /*
     *  obtenemos la cantidad de juegos seleccionados
     */
    public function getWagerdata() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $doc = $this->request->query["doc"];
        $wagers = array();
        $wagers['wagersdata']= $this->Sportbook->m_getWagerdata($CustomerID, $doc,"kris",0,0);
        $this->set('data', $wagers);
        $this->render('json');
	}
    /**
     * load Ticket Lines
     */
    public function loadTicketLines() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
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
    public  function loadAccountHistory(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $freePlay=@$_POST["freePlay"];
        $endDate=new DateTime();
        $iniDate=new DateTime();
        date_sub($iniDate, date_interval_create_from_date_string('15 days'));
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getAccountHistory($CustomerID,$freePlay, date_format($iniDate, 'Y-m-d'),date_format($endDate, 'Y-m-d'));
        $this->set('data', $loadAccHis);
        $this->render('json');

    }
    public  function loadTransactionDetails(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $transactionID=@$_POST["transactionID"];
        $CustomerID = $authUser['customerId'];
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getTransactionDetails(array("CustomerID"=>$CustomerID,"DocumentNumber"=>$transactionID));
        $this->set('data', $loadAccHis);
        $this->render('json');
    }
    
    public  function getTransWagerDetails(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $transactionID=@$_POST["transactionID"];
        $CustomerID = $authUser['customerId'];
        $loadAccHis = array();
        $loadAccHis['data'] = $this->Sportbook->getTransactionWagerDetails(array("customerID"=>$CustomerID,"transactionID"=>$transactionID));
        $this->set('data', $loadAccHis);
        $this->render('json');
    }
    
    public  function getWeeklyBalance(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $endDate=@$_POST["endDate"];
        $loadAccHis = array();
        
        $endDate = "20160731";
        
        $loadAccHis['data'] = $this->Sportbook->getweeklyBalance($CustomerID,$endDate);
        
        $this->set('data', $loadAccHis);
        $this->render('json');
    }
    
    public function loadDailyWagers() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $date=@$_POST["date"];
        $CustomerID = $authUser['customerId']; 
        $wagersReport = $this->Sportbook->getWagersReport2($CustomerID, $date, $date, 0,0);
        $this->set('data', $wagersReport);
        $this->render('json');  
    }

    public function getDailyTransactions() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $date=@$_POST["date"];
        $CustomerID = $authUser['customerId']; 
        $wagersReport = $this->Sportbook->getDailyFigures($CustomerID, $date);
        $this->set('data', $wagersReport);
        $this->render('json');  
    }
   /**
    * get Detail Games Live Now in play
    */
    public function getDetailOverviewLive(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $data = $this->Account->getLiveGameDetail(array("CustomerID" => $CustomerID, 'appid' => 'pregamesite', 'userid' => $CustomerID));
        $this->set('data', $data);
        $this->render('json');  
    }
    
    /**
     * get Detail Games UpCommingLive
     */
    public function getDetailOverviewUpCommingLive(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $data = $this->Account->getLiveGameInNextXXhours(array("CustomerID" => $CustomerID, "time" => 24, 'appid' => 'pregamesite', 'userid' => $CustomerID));
        $this->set('data', $data);
        $this->render('json');  
    }
    /**
     * get Detail Games UpComming Live
     */
    public function getDetailOverviewUpCommingPregame(){
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $data = $this->Account->getUpComingPreGameXXmins(array("CustomerID" => $CustomerID, "mins" => 60, "period" => 2, 'appid' => 'pregamesite', 'userid' => $CustomerID));
        $this->set('data', $data);
        $this->render('json');  
    }

    /**
     * get Detail Games UpComming Pregame
     */
    public function setCustomerslineFormat() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $formatType     = trim($this -> request -> data('formatType'));
        $response = null;
        if($formatType == 'A' || $formatType == 'D'){
            $response = $this->Account->setCustomerslineFormat(array("account"=>$CustomerID,"lineFormat"=>$formatType,"appid"=>"AgentAdmin","userid"=>"kris"));
        }
        $this->set('data', $response);
        $this->render('json');  
    }
    
    public function getAccountPrevBalance(){
	$this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $iniDate=new DateTime();
        date_sub($iniDate, date_interval_create_from_date_string('14 days'));
        $response = $this->Sportbook->getAccountPrevBalance(array("customerID"=>$CustomerID,"endDate"=>date_format($iniDate, 'Y-m-d')));
        $this->set('data', $response);
        $this->render('json');  
    }
    
    public function getLessVariables(){
        $this->layout = "ajax";
        $this->autoRender = false;
        $detailTemplate = $this->Session->read("user_template");
        $txt = "";
        if(empty($detailTemplate)){
			$txt="@color-Menus: #2f3c42;@color-MenusText: #ffffff;@color-MenusHover: #1462FC;@color-Buttons: #4ea74e;
				@color-Buttons-White: #CBCCCC;@color-SubHeaders: #999999;@color-Warning: #c12e2a;@color-Notes: #ffffb3;
				@color-black: #000000;@color-dropdown: #313c42;@color-menubetslip: #8A8A8A;@color-betslip-selections-messages: #333333;
				@color-betslip-panel-default: #DFDFDF;@color-betslip-modal-header: #facc2e;@color-caution: #030536;
				@color-MenusTextBold: #fa5736;@color-Background-body: #ffffff;@color-Background-tables: #ffffff;
				@color-Background-betslip: #ffffff;@color-Background-header: #ffffff;@color-Background-footer: #ffffff;";
		}
        else{
            $detailTemplate = (isset($detailTemplate["results"]) ? $detailTemplate["results"] : $detailTemplate);
            foreach ($detailTemplate as &$detail) {
                $txt .= "@".trim(urldecode($detail["DetailName"])).": ".trim(urldecode($detail["Value"])).";\n";
            }
        }
            
        $this->response->body($txt);
        $this->response->type(array('less' => 'text/less'));
        $this->response->type('less');
        return $this->response;
    }
    
    public function getPermissionAjax(){
        $data = $this->Auth->user();
        
        $param = trim($this->request->data('param'));
        
        $res=false;
        foreach($data as $key=>$row){
            if($key == $param){
                if($row == true || $row == 'Y'){
                    $res=true;
                }
            }
        }
        return new CakeResponse(array('body' => json_encode($res)));
    }
    
    
}
