<?php

App::uses('AppPregameSiteController', 'Controller');

class PrintviewController extends AppController
{
    
    public function index(){
        $tickets=json_decode(urldecode(@$_GET["params"]));
        $type=@$_GET["type"];
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $userName = $authUser['username'];
        $anonim = trim($this->domain["anonimAcc"]);

        $caja = $authUser['caja'];
        $ticketsInfo=$this->getTicketsToPrint($tickets);
        for($cont=1;$cont<= count($ticketsInfo);$cont++) {
            $ticketsInfo["row".$cont]["AdjSpread"]=$this->processEncodeData((float)$ticketsInfo["row".$cont]["AdjSpread"]+(float)$ticketsInfo["row".$cont]["TeaserPoint"],'s');
            if($ticketsInfo["row".$cont]["ChosenTeamID"]=="Over"){
                $ticketsInfo["row".$cont]["AdjTotalPoints"]=$this->processEncodeData($ticketsInfo["row".$cont]["AdjTotalPoints"]-(float)$ticketsInfo["row".$cont]["TeaserPoint"],'t');
            }else {
                $ticketsInfo["row".$cont]["AdjTotalPoints"]=$this->processEncodeData($ticketsInfo["row".$cont]["AdjTotalPoints"]+(float)$ticketsInfo["row".$cont]["TeaserPoint"],'t');
            }
            
            if(strtoupper(trim($anonim))==strtoupper($ticketsInfo["row".$cont]["CustomerID"])){
                $ticketsInfo["row".$cont]["CustomerID"]="Anonimo";
            }
        }
        $retention=($this->domain["applyRet"]==1?$this->domain["retentionPercent"]:0);
        $currency;
        if(isset($authUser['currency'])) 
            $currency=trim(substr($authUser['currency'], 0, strpos($authUser['currency'], ' ')));
        else 
            $currency="$";
        
        $generalInfo=array("type"=>$ticketsInfo["row1"]["BetType"],
                            "ticketInfo"=>$ticketsInfo,
                            "ticketType"=>json_decode(urldecode($type)),
                            "caja"=>$caja,
                            "username"=>$userName,
                            "siteDesc"=>$sitedesc,
                            "retention"=>$retention,
                            "currency"=>$currency);
        
        $this->set("generalInfo",$generalInfo);
    }
    
    public function printpayindex(){
        $tickets=json_decode(urldecode(@$_GET["params"]));
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $userName = $authUser['username'];
        $anonim = trim($this->domain["anonimAcc"]);

        $caja = $authUser['caja'];
        $ticketsInfo=$this->getPayTicketsToPrint($tickets);
        $retention=($this->domain["applyRet"]==1?$this->domain["retentionPercent"]:0);
        $currency;
        if(isset($authUser['currency'])) 
            $currency=trim(substr($authUser['currency'], 0, strpos($authUser['currency'], ' ')));
        else 
            $currency="$";
        
        $generalInfo=array("type"=>$ticketsInfo["row1"]["BetType"],
                            "ticketInfo"=>$ticketsInfo,
                            "ticketType"=>json_decode(urldecode($type)),
                            "caja"=>$caja,
                            "username"=>$userName,
                            "siteDesc"=>$sitedesc,
                            "retention"=>$retention/100,
                            "currency"=>$currency);
        
        $this->set("generalInfo",$generalInfo);
    }


    public function reprintticket(){
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $CustomerID = $authUser['player'];
        $AgentID = $authUser['agentId'];
        $userName = $authUser['username'];

        $caja = $authUser['caja'];
        $tickets=array($_GET["params"]);
        $ticketsInfo=$this->getTicketsToPrint($tickets);
        $isParlay=false;
        $isStraight=false;
        if($ticketsInfo["row1"]["BetType"]=="PARLAY"||$ticketsInfo["row1"]["BetType"]=="TEASER"){
            $isParlay=true;
            $isStraight=false;
        }else{
            $isParlay=false;
            $isStraight=true;
        }
        
        $type=1;
        if(trim($this->domain["anonimAcc"])!=trim($ticketsInfo["row1"]["CustomerID"]))
            $type=2;
        $generalInfo=array("isParlay"=>$isParlay,
                            "isStraight"=>$isStraight,
                            "ticketInfo"=>$ticketsInfo,
                            "ticketType"=>$type,
                            "caja"=>$caja,
                            "username"=>$userName,
                            "siteDesc"=>$sitedesc);
        $this->set("generalInfo",$generalInfo);
        if(isset($authUser['currency'])) $this->set("currency", trim(substr($authUser['currency'], 0, strpos($authUser['currency'], ' '))));
        else $this->set("currency", "$");
    }
    
    private function getTicketsToPrint($tickets){
        $ticketString='';
        foreach ($tickets as $ticket) {
            $ticketString.=$ticket.',';
        }
        $ticketString=  substr($ticketString, 0,  strlen($ticketString)-1);
        $user = $this->Auth->user();
        $account=$user["player"];
        $ticketsInfo=$this->PvReports->getTicketsToPrint(array("account"=>$account,"tickets"=>$ticketString));
        return $ticketsInfo;
    }
    
    private function getPayTicketsToPrint($tickets){
        $ticketString='';
        foreach ($tickets as $ticket) {
            $ticketString.=$ticket.',';
        }
        $ticketString=  substr($ticketString, 0,  strlen($ticketString)-1);
        $user = $this->Auth->user();
        $account=$user["player"];
        $ticketsInfo=$this->PvReports->getPayTicketsToPrint(array("account"=>$account,"tickets"=>$ticketString));
        return $ticketsInfo;
    }
    
      public function getTicketbr($ticketNum,$user2) {
        $user = $this->Auth->user();

     
        $ticket = $this->Cashier->getTiquetblr(array('company' => trim($user2), 'blrtiket' => (int) $ticketNum, 'appid' => 'POS', 'userid' => trim($user['userID'])));

        $ticket = isset($ticket['row1']) ? $ticket['row1'] : 0;
        //return new CakeResponse(array('body' => json_encode($ticket)));
        return $ticket;
    }

    
    
        public function belrtike() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $ticketNum = $_GET["blrtiket"];
        $user =  $_GET["U"];
         $sitedesc=$this->domain["siteDesc"];
             $this->set("siteDesc", $sitedesc);
        $CustomerID = $authUser['player'];
        $AgentID = $authUser['agentId'];
        $userName = $authUser['username'];
        $tike=  explode(",", $ticketNum);
      
       $ticketlist= Array();
     
        foreach ($tike as $val){
                  $ticketInfo = $this->getTicketbr((int)$val,$user);
                  
                  array_push($ticketlist,$ticketInfo);
                
        
                  $this->setDepositoXTiquete($ticketInfo["AmountWagered"], $ticketInfo["TicketNumber"], $user);
       
        }
  
        
        $caja = $authUser['caja'];
        $this->set("tickets", $ticketlist);
        $this->set("caja", $caja);
        $this->set("username", $userName);
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
        
       
        $this->set('data', $results);
      
    }
    

}

