<?php

App::uses('Model', 'Model');

class PvReports extends AppModel {
    public $name = 'PvReports';
    
    
    public function generaltotalreport(){
        
    }
    
    public function depositsbyboxreport(){
        
    }
    
    public function insertedbetsreport(){
        
    }

    public function betsreport($account,$boxID,$dateIni,$dateEnd,$anonimAccount,$accountOpt,$branchId){
        $params=array(
            "account"=>$account,
            "BoxID"=>$boxID,
            "Date1"=>$dateIni,
            "date2"=>$dateEnd,
            "wstatus"=>"",
            "Option"=>5,
            "anonimAccount"=>$anonimAccount,
            "accountOpt"=>$accountOpt,
            "branchID"=>$branchId);
        return $this->call('pvReports', 'getReportsByRangeDate', $params);
    }
    
    public function movimientosdecajareport($account,$boxID,$dateIni,$dateEnd,$branchId){
        $params=array(
            "account"=>$account,
            "BoxID"=>$boxID,
            "Date1"=>$dateIni,
            "date2"=>$dateEnd,
            "wstatus"=>"",
            "Option"=>4,
            "anonimAccount"=>"",
            "accountOpt"=>"",
            "branchID"=>$branchId);
        return $this->call('pvReports', 'getReportsByRangeDate', $params);
    }
    
    public function getBalanceCajaReport($account,$boxID,$dateIni,$dateEnd,$branchId){
        $params=array(
            "account"=>$account,
            "BoxID"=>$boxID,
            "From"=>$dateIni,
            "To"=>$dateEnd,
            "branchID"=>$branchId);
        return $this->call('pvReports', 'getBalanceCaja', $params);
    }
    
    public function getCierresAperturasReport($account,$boxID,$dateIni,$dateEnd,$branchId){
        $params=array(
            "account"=>$account,
            "BoxID"=>$boxID,
            "From"=>$dateIni,
            "To"=>$dateEnd,
            "branchID"=>$branchId);
        return $this->call('pvReports', 'getCierresAperturasReport', $params);
    }
    
    
    public function linesReport($account){
        $params=array("account"=>$account);
        return $this->call('pvReports', 'getLinesReport', $params);
   }
   
   public function getTeamsforFind($param) {
        return ($this->call('pvReports', 'getTeams', $param));
   }
   
   public function getDeletedWagersReport($param) {
        return ($this->call('pvReports', 'deletedWagerReport', $param));
   }
   
   public function getTicketsToPrint($param) {
        return ($this->call('pvReports', 'getTicketsToPrint', $param));
   }
   
   public function getPayTicketsToPrint($param) {
        return ($this->call('pvReports', 'getPayTicketsToPrint', $param));
   }
   
   public function getRetentionInfo($param) {
        return ($this->call('pvReports', 'getTaxesPaidReport', $param));
   }
}