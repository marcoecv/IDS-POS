<?php

App::uses('AppController', 'Controller');

class PvReportsController extends AppController {
    var $layout = 'admin_layout';
    public $uses = array('Account', 'Permission', 'Sportbook', 'Cashier', 'Transaction', 'PvReports');

    public function isAuthorized($user) {
        if ($user['accessAdmin']) {
            return true;
        }
        return false;
    }

    public function index() {
        $this->Session->write('current_page', array('controller' => 'PvReports', 'action' => 'index'));
        $authUser = $this->Auth->user();
        $UserPermissions = $authUser['userPermissions'];
        $this->set('buttonsPermission', $this->getButtonsByPermission($UserPermissions));
        $this->set('authUser', $authUser);
        $this->render('index');
    }

    private function getButtonsByPermission($permissionArray) {
        $buttons = "";
        foreach ($permissionArray as $permission) {
            switch ($permission["RolID"]) {
                case 6:
                    $buttons.='<a href="/PvReports/balancecaja">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Balance de Caja' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 8:
                    $buttons.='<a href="/PvReports/pendingbets">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Apuestas pendientes' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 9:
                    $buttons.='<a href="/PvReports/winbets">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Apuestas ganadas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 10:
                    $buttons.='<a href="/PvReports/movimientosdecaja">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Balance General' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 11:
                    $buttons.='<a  href="/PvReports/aperturacierrecaja">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Cierres/Aperturas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 12:
                    $buttons.='<a href="/PvReports/lossbets">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Apuestas perdidas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 14:
                    $buttons.='<a href="/PvReports/deletedwagerreport">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Apuestas Borradas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 15:
                    $buttons.='<a href="/PvReports/linesreport">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Reporte de Lineas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 16:
                    $buttons.='<a href="/AgentReports/action_by_player">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Accion por Jugador' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 27:
                    $buttons.='<a href="/PvReports/expiredbets">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Apuestas Vencidas' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 25:
                    $buttons.='<a href="/PvReports/retentionreport">' .
                            '<div class="col-md-4">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg btndash">Retenciones' .
                            '</button>' .
                            '</div>' .
                            '</a>';
                    break;
            }
        }
        return $buttons;
    }

    public function getTicket($ticketNum) {
        $user = $this->Auth->user();

        $ticket = $this->Cashier->getTiquet(array('company' => trim($user['root']), 'document' => (int) $ticketNum,'branchid' => $this->domain["BranchID"], 'appid' => 'POS', 'userid' => trim($user['userID'])));

        $ticket = isset($ticket['row1']) ? $ticket['row1'] : 0;
        //return new CakeResponse(array('body' => json_encode($ticket)));
        return $ticket;
    }

    public function balancecaja() {
        if (!$this->hasPermission("BC")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function getBalanceCajaReport() {
        $dateIni = @$_POST["dateIni"];
        $dateEnd = @$_POST["dateEnd"];
        $timeIni = @$_POST["timeIni"];
        $timeEnd = @$_POST["timeEnd"];
        $caja = @$_POST["caja"];
        $branchId = $this->domain["BranchID"];
        $dateIni = $dateIni . " " . $timeIni;
        $dateEnd = $dateEnd . " " . $timeEnd;
        $authUser = $this->Auth->user();
        $response = $this->PvReports->getBalanceCajaReport($authUser['player'], $caja, $dateIni, $dateEnd, $branchId);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function aperturacierrecaja() {
        if (!$this->hasPermission("CYA")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function getCierresAperturasReport() {
        $dateIni = @$_POST["dateIni"];
        $dateEnd = @$_POST["dateEnd"];
        $timeIni = @$_POST["timeIni"];
        $timeEnd = @$_POST["timeEnd"];
        $caja = @$_POST["caja"] == "" ? -1 : @$_POST["caja"];
        $branchId = $this->domain["BranchID"];
        $authUser = $this->Auth->user();
        $response = $this->PvReports->getCierresAperturasReport($authUser['player'], $caja, $dateIni . " " . $timeIni, $dateEnd . " " . $timeEnd, $branchId);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function getTransactions() {
        $authUser = $this->Auth->user();
        $caja = -1;
        $inicio = date("m-d-Y H:i", strtotime("-30 days"));
        $fin = date("m-d-Y H:i");
        $branchId = $this->domain["BranchID"];

        $transactions = $this->PvReports->movimientosdecajareport($authUser['player'], $caja, $inicio, $fin, $branchId);


        return $transactions;
    }

    public function movimientosdecaja() {
        if (!$this->hasPermission("BG")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function movimientosdecajareport() {
        $dateIni = @$_POST["dateIni"];
        $dateEnd = @$_POST["dateEnd"];
        $caja = (@$_POST["caja"] == "" ? -1 : (int) @$_POST["caja"]);
        $branchId = $this->domain["BranchID"];
        $authUser = $this->Auth->user();
        $response = $this->PvReports->movimientosdecajareport($authUser['player'], $caja, $dateIni, $dateEnd, $branchId);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function lossbets() {
        if (!$this->hasPermission("PW")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function pendingbets() {
        if (!$this->hasPermission("AP")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function winbets() {
        if (!$this->hasPermission("AG")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }
    
    public function expiredbets() {
        if (!$this->hasPermission("AV")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }

    public function betsreport() {
        $data = json_decode(file_get_contents("php://input"),true);
        $dateIni = $data["dateIni"];
        $dateEnd = $data["dateEnd"];
        $caja = ($data["caja"] == "" ? -1 : (int) @$_POST["caja"]);
        $opt = $data["opt"];
        $branchId = $this->domain["BranchID"];
        $anonimAccount = "";
        if ($opt == "1" || $opt == "2") {
            $anonimAccount = $this->domain["anonimAcc"];
            $accountOpt = $opt;
        } else {
            $accountOpt = 2;
        }
        $authUser = $this->Auth->user();
        $response = $this->PvReports->betsreport($authUser['player'], $caja, $dateIni, $dateEnd, $anonimAccount, $accountOpt, $branchId);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    function getTransRange() {
        $user = $this->Auth->user();
        $inicio = $this->request->data('inicio');
        $fin = $this->request->data('fin');
        $caja = $this->request->data('caja') != "" ? $this->request->data('caja') : -1;

        $response = $this->PvReports->movimientosdecajareport($user['player'], $caja, $inicio, $fin);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function deletedwagerreport() {
        if (!$this->hasPermission("AB")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
        
    }
    
    public function getdeletedwagerreport() {
        $data = json_decode(file_get_contents("php://input"),true);
        $dateIni = $data["dateIni"];
        $dateEnd = $data["dateEnd"];
        $timeIni = $data["timeIni"];
        $timeEnd = $data["timeEnd"];
        $cuenta = $data["cuenta"];
        $deletedBy = $data["deletedBy"];
        $opt = $data["option"];
        $response=$this->PvReports->getDeletedWagersReport(array("CustomerID"=>$this->domain["anonimAcc"],
            "deletedBy"=>$deletedBy,
            "account"=>$cuenta,
            "dateIni"=>$dateIni." ".$timeIni,
            "dateEnd"=>$dateEnd." ".$timeEnd,
            "option"=>$opt));
        
        return new CakeResponse(array('body' => json_encode($response)));
        
    }

    public function linesreport(){
        if (!$this->hasPermission("RL")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
        $user = $this->Auth->user();
        $response = $this->PvReports->linesReport($user['player']);
        $lines = array();
        foreach ($response as $line) {

            if ($line["Spread"] != null && $line["Spread"] != "") {
                $line["Spread"] = $this->formatPoints($line["Spread"], "s");
            }
            if ($line["TotalPoints"] != null && $line["TotalPoints"] != "") {
                $line["TotalPoints"] = $this->formatPoints($line["TotalPoints"], "t");
            }
            if ($line["Team2TotalPoints"] != null && $line["Team2TotalPoints"] != "") {
                $line["Team2TotalPoints"] = $this->formatPoints($line["Team2TotalPoints"], "t");
            }
            if ($line["Team1TotalPoints"] != null && $line["Team1TotalPoints"] != "") {
                $line["Team1TotalPoints"] = $this->formatPoints($line["Team1TotalPoints"], "t");
            }
////            SPREAD PRICE
            if ($line["SpreadAdj1"] != null && $line["SpreadAdj1"] != "") {
                $line["SpreadAdj1"] = $this->formatPrice($line["SpreadAdj1"]);
            }
            if ($line["SpreadAdj2"] != null && $line["SpreadAdj2"] != "") {
                $line["SpreadAdj2"] = $this->formatPrice($line["SpreadAdj2"]);
            }
////            MONEY LINE PRICE
            if ($line["MoneyLine1"] != null && $line["MoneyLine1"] != "") {
                $line["MoneyLine1"] = $this->formatPrice($line["MoneyLine1"]);
            }
            if ($line["MoneyLine2"] != null && $line["MoneyLine2"] != "") {
                $line["MoneyLine2"] = $this->formatPrice($line["MoneyLine2"], "t");
            }
            if ($line["MoneyLineDraw"] != null && $line["MoneyLineDraw"] != "") {
                $line["MoneyLineDraw"] = $this->formatPrice($line["MoneyLineDraw"], "t");
            }
////            TOTAL PRICE
            if ($line["TtlPtsAdj1"] != null && $line["TtlPtsAdj1"] != "") {
                $line["TtlPtsAdj1"] = $this->formatPrice($line["TtlPtsAdj1"], "t");
            }
            if ($line["TtlPtsAdj2"] != null && $line["TtlPtsAdj2"] != "") {
                $line["TtlPtsAdj2"] = $this->formatPrice($line["TtlPtsAdj2"], "t");
            }
////            TEAM TOTAL PRICES
            if ($line["Team1TtlPtsAdj1"] != null && $line["Team1TtlPtsAdj1"] != "") {
                $line["Team1TtlPtsAdj1"] = $this->formatPrice($line["Team1TtlPtsAdj1"], "t");
            }
            if ($line["Team1TtlPtsAdj2"] != null && $line["Team1TtlPtsAdj2"] != "") {
                $line["Team1TtlPtsAdj2"] = $this->formatPrice($line["Team1TtlPtsAdj2"], "t");
            }
            if ($line["Team2TtlPtsAdj1"] != null && $line["Team2TtlPtsAdj1"] != "") {
                $line["Team2TtlPtsAdj1"] = $this->formatPrice($line["Team2TtlPtsAdj1"], "t");
            }
            if ($line["Team2TtlPtsAdj2"] != null && $line["Team2TtlPtsAdj2"] != "") {
                $line["Team2TtlPtsAdj2"] = $this->formatPrice($line["Team2TtlPtsAdj2"], "t");
            }




            $dateTimeArray = explode(" ", $line["GameDateTime"]);
            $dateArray = explode("-", $dateTimeArray[0]);
            $timeArray = explode(":", $dateTimeArray[1]);
            $line["GameDate"] = $dateArray[1] . "-" . $dateArray[2] . "-" . $dateArray[0];
            $line["GameTime"] = $timeArray[0] . ":" . $timeArray[1];
            array_push($lines, $line);
        }
        $this->set("lines", $lines);
    }

    private function formatCase25($arrayPoints, $sign) {
        $returnValue = "";
        $p0 = str_replace("-", "", $arrayPoints[0]);
        $p0Temp = "";
        if ($p0 != "0") {
            $p0Temp = $p0;
        } else {
            $p0 = "pk";
        }
        $returnValue = $p0 . " ," . $sign . $p0Temp . "&frac12;";
        return $returnValue;
    }

    /**
     * takes a #.5 value and returns a fraction string value
     * @param type $arrayPoints
     * @param type $sign
     * @return string
     */
    private function formatCase5($arrayPoints, $sign) {
        $returnValue = "";
        $p0 = str_replace("-", "", $arrayPoints[0]);
        if ($p0 == "0") {
            $returnValue = $sign . "&frac12;";
        } else {
            $returnValue = $sign . $p0 . "&frac12;";
        }
        return $returnValue;
    }

    /**
     * takes a #.75 value and returns a fraction string value
     * @param type $arrayPoints
     * @param type $sign
     * @return string
     */
    private function formatCase75($arrayPoints, $sign, $spread) {
        $returnValue = "";
        $p0 = str_replace("-", "", $arrayPoints[0]);
        $p0Temp = "";
        if ($p0 != "0") {
            $p0Temp = $p0;
        } else {
            $p0 = "pk";
        }
        $returnValue = $sign . $p0Temp . "&frac12; ," . $sign . ($p0 + 1);
        return $returnValue;
    }

    /**
     * send the values to format depending if it is spread or total
     * @param type $points
     * @param type $type
     * @return boolean
     */
    private function formatPoints($points, $type) {
        $finalResult;
        if ($type == "s") {
            $finalResult = $this->formatSPvalue($points);
        } else if ($type == "t") {
            $finalResult = $this->formatTLvalue($points);
        }
        return $finalResult;
    }

    /**
     * Format a price if this one needs a plus sign
     * @param String $price
     * @return String
     */
    private function formatPrice($price) {
        if ($price != null && trim($price) != "") {
            $price = intval($price);
            $price = $price > 0 ? "+" . $price : $price;
            return $price;
        }
        return "";
    }

    private function formatTLvalue($points) {
        $returnValue = "";
        $arrayPoints = explode(".", $points);
        if (count($arrayPoints) < 1){
            $returnValue = 0;
        }else if (count($arrayPoints) == 1||$arrayPoints[1]=="0"){
            $returnValue = (int)$points;
        }else {
            $p0 = $arrayPoints[0];
            switch ($arrayPoints[1]) {
                case "25":
                    $returnValue = $p0 . " ," . $p0 . "&frac12;";
                    break;
                case "5":
                    if ($p0 == "0") {
                        $returnValue = "&frac12;";
                    } else {
                        $returnValue = $p0 . "&frac12;";
                    }
                    break;
                case "75":
                    $p0Temp = ($p0 == "0" ? "pk" : $p0);
                    $returnValue = $p0Temp . "&frac12; ," . ($p0 + 1);
            }
        }
        return $returnValue;
    }

    /**
     * format spread threshold line
     * @param type $points
     * @return string
     */
    private function formatSPvalue($points) {
        $returnValue = "";
        $sign = "";
        if ((int) $points < 0)
            $sign = "-";
        else
            $sign = "+";
        $arrayPoints = explode(".", $points);
        if (count($arrayPoints) < 1)
            $returnValue = 0;
        else if (count($arrayPoints) == 1)
            if ($points == 0)
                $returnValue = "pk";
            else
                $returnValue = $points;
        else {
            switch ($arrayPoints[1]) {
                case "25":
                    $returnValue = $this->formatCase25($arrayPoints, $sign);
                    break;
                case "5":
                    $returnValue = $this->formatCase5($arrayPoints, $sign);
                    break;
                case "75":
                    $returnValue = $this->formatCase75($arrayPoints, $sign);
                    break;
                default:
                    $returnValue = $arrayPoints[0];
                    break;
            }
        }
        return $returnValue;
    }
    
    
    public function retentionreport(){
        if (!$this->hasPermission("RR")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
    }
    
    public function executeRetentionReport(){
        $data = json_decode(file_get_contents("php://input"),true);
        $dateIni=$data["dateIni"];
        $dateFin=$data["dateEnd"];
        $cuenta=$data["cuenta"];
        $agent="";
        if($cuenta==""){
            $agent=$this->domain["agentPOS"];
        }
        
        $response=$this->PvReports->getRetentionInfo(array("account"=>$this->domain["anonimAcc"],
            "agentID"=>$agent,
            "customerID"=>$cuenta,
            "date1"=>$dateIni,
            "date2"=>$dateFin));
        
        return new CakeResponse(array('body' => json_encode($response)));
    }
}
