<?php

class CashierController extends AppController {

    var $layout = 'admin_layout';
    public $uses = array('Account', 'Permission', 'Sportbook', 'Cashier', 'Transaction', 'PvReports', 'User');

    public function isAuthorized($user) {
        parent::isAuthorized($user);
        if ($user['accessAdmin']) {
            return true;
        }
        return false;
    }

    /**
     * Index function
     * Loads comments and render the dashboard main view
     */
    public function index() {
        //
        //$this->Session->write('current_page', array('controller' => 'DashboardAdmin', 'action' => 'index'));
        $authUser = $this->Auth->user();

        $transactions = $this->getTransactionsBox();
        $saldo = $this->getSaldo();
        $buttons = "";
        $UserPermissions = $authUser['userPermissions'];
        $this->set('buttonsPermission', $this->getButtonsByPermission($UserPermissions));
        $comments = $this->requestAction(array('controller' => 'Comments', 'action' => 'getComment'), array('named' => array('typeCommentsToRetrieve' => 'Transmitter')));
        $isOpen = $this->isOpen();
        $this->set('saldo', $saldo);
        $this->set('isOpen', $isOpen);
        $this->set('comments', $comments);
        $this->set('authUser', $authUser);
        $this->set('showMenu', false);
        $this->set('transactions', $transactions);
        $this->render('index');
    }

    private function getButtonsByPermission($permissionArray) {
        $buttons = "";
        $isOpen = $this->isOpen();
        foreach ($permissionArray as $permission) {
            switch ($permission["RoleName"]) {
                case 'AC':
                    $buttons.='<a ' . (!$isOpen ? 'data-target="#abrirCaja" data-toggle="modal" href="#abrirCaja"' : 'onclick="alert(&quot;La Caja ya se encuentra Abierta&quot;)"') . '>'.
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg rightMenuButton" ' . ($isOpen ? 'disabled' : '') . '>Abrir<br/>Caja</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'CC':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroCerrarCaja" type="button" class="btn btn-block btn-success btn-lg rightMenuButton"' . (!$isOpen ? 'disabled' : '') . '>Cerrar<br/>Caja</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'PT':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroPayTicket" type="button" class="btn btn-block btn-success btn-lg rightMenuButton"' . (!$isOpen ? 'disabled' : '') . '>Pagar<br/>Tickets</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'DX':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroDepositcta" type="button" class="btn btn-block btn-success btn-lg rightMenuButton"' . (!$isOpen ? 'disabled' : '') . '>Deposito<br/>A Cuenta</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'RX':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroRetirocta" type="button" class="btn btn-block btn-success btn-lg rightMenuButton"' . (!$isOpen ? 'disabled' : '') . '>Retiro<br/>De Cuenta</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'IS':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroDepositarCaja" type="button" class="btn btn-block btn-success btn-lg rightMenuButton" ' . (!$isOpen ? 'disabled' : '') . '>Incremento<br/>Saldo</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'RC':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroRetirarCaja" type="button" class="btn btn-block btn-success btn-lg rightMenuButton" ' . (!$isOpen ? 'disabled' : '') . '>Retiro<br/>De Caja</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'ET':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajero_deleteTickets" type="button" class="btn btn-block btn-success btn-lg rightMenuButton" ' . (!$isOpen ? 'disabled' : '') . '>Borrar<br/>Tickets</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'RT':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajeroReprintTickets" type="button" class="btn btn-block btn-success btn-lg rightMenuButton" ' . (!$isOpen ? 'disabled' : '') . '>Reimprimir<br/>Tickets</i></button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'DC':
                    $buttons.='<a onclick="openDesbCajaModal()">' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button type="button" class="btn btn-block btn-success btn-lg rightMenuButton">Desbloquear</button>' .
                            '</div>' .
                            '</a>';
                    break;
                case 'PR':
                    $buttons.='<a>' .
                            '<div class="col-md-6 buttonsMenuDiv">' .
                            '<button id="cajero_reprintTransactions" type="button" class="btn btn-block btn-success btn-lg rightMenuButton">Reimprimir<br/>Transacciones</button>' .
                            '</div>' .
                            '</a>';
                    break;
            }
        }
        return $buttons;
    }

    /**
     * Index function
     * Loads comments and render the dashboard main view
     */
    public function deposit() {
        $authUser = $this->Auth->user();
        $this->set('authUser', $authUser);
    }

    public function payticket() {
        $authUser = $this->Auth->user();
        $this->set('saldo', $this->getSaldo());
        $this->set('authUser', $authUser);
    }

    public function reprintickets() {
        if (!$this->hasPermission("RT")) {
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
        $tickets = $this->insertedbetsbyboxreport();
        return new CakeResponse(array('body' => json_encode($tickets)));
    }

    public function deletetickets() {
        $tickets = $this->insertedbetsbyboxreport();
        return new CakeResponse(array('body' => json_encode($tickets)));
    }

    public function cerrarcaja() {
        if ($this->hasPermission("CC")) {
            $transactions = $this->getTransactionsBox();

            return new CakeResponse(array('body' => json_encode($transactions)));
        } else {
            return $this->redirect(Router::url("/" . "DashboardAdmin", true));
        }
    }

    public function printtransacion() {
        if ($this->hasPermission("PR")) {
            $transactions = $this->getTransactionsBox();

            return new CakeResponse(array('body' => json_encode($transactions)));
        } else {
            return $this->redirect(Router::url("/" . "DashboardAdmin", true));
        }
    }
    public function cajero() {
        $authUser = $this->Auth->user();
        $UserPermissions = $authUser['userPermissions'];
        $this->set('buttonsPermission', $this->getButtonsByPermission($UserPermissions));
        $this->set('anonimAccount', $authUser["userID"]);
        
    }

    public function findPlayer() {
        $customerId = trim($this->request->data('customerId'));
        $user = $this->Auth->user();
        $response = $this->Account->getAccountFullInfo(array("account" => trim($customerId), "agent" => $user['root'], 'appid' => 'pregamesite', 'userid' => $user['root']));
        $customerPersonal = (isset($response['row1'])) ? $response['row1'] : $response;


        if (isset($customerPersonal['CustomerID'])) {
            $fullCustomer = $this->Sportbook->getCustomer(trim($customerId), trim($user['root']), trim($user['username']));
            $customerPersonal['balance'] = $fullCustomer['Available'];
            $transactions = $this->getTransactions($customerId, date('m/d/Y', strtotime("-1 days")), date("m/d/Y"));


            return new CakeResponse(array('body' => json_encode(array('player' => $customerPersonal, 'transactions' => $transactions))));
        } else {
            return new CakeResponse(array('body' => 0));
        }
    }

    public function abrirCaja() {
        $user = $this->Auth->user();
        $monto = $this->request->data('monto');
        $branchID = $this->domain["BranchID"];

        $open = $this->Cashier->setOpenCaja(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (int) $monto,
            'username' => trim($user['username']), 'cajero' => trim($user['player']), 'agentid' => trim($user['root']), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $open = ($open['row1']) ? $open['row1'] : 0;

        return new CakeResponse(array('body' => json_encode($open)));
    }

    function getTickets() {
        $user = $this->Auth->user();
        $anonimAcc = $this->domain["anonimAcc"];
        $inicio = date('m-d-Y H:i', strtotime("-30 days"));
        $fin = date("m-d-Y H:i");
        $branchID = $this->domain["BranchID"];
        
        $tickets = $this->Cashier->getTiquetAll(array('anonimAccount' => $anonimAcc, 'inicio' => $inicio, 'fin' => $fin, 'branchid' => $branchID, 'appid' => 'POS', 'userid' => trim($user['userID'])));

        return $tickets;
    }

    function getTicketsrange() {
        $user = $this->Auth->user();
        $inicio = $this->request->data('inicio');
        $fin = $this->request->data('fin');


        $inicio = strtotime($inicio);
        $inicio = date('m-d-Y H:i', $inicio);
        $inicio = date_parse_from_format("m-d-Y H:i", $inicio);
        $inicio = mktime($inicio['hour'], $inicio['minute'], $inicio['second'], $inicio['month'], $inicio['day'], $inicio['year']);

        $fin = strtotime($fin);
        $fin = date('m-d-Y H:i', $fin);
        $fin = date_parse_from_format("m-d-Y H:i", $fin);
        $fin = mktime($fin['hour'], $fin['minute'], $fin['second'], $fin['month'], $fin['day'], $fin['year']);

        $branchID = $this->domain["BranchID"];
        $tickets = $this->Cashier->getTiquetAll(array('company' => $user['player'], 'inicio' => $inicio, 'fin' => $fin, 'branchid' => $branchID, 'appid' => 'POS', 'userid' => 'pvuser'));

        return new CakeResponse(array('body' => json_encode($tickets)));
    }

    function getTransactions($player, $inicio, $fin) {

        $transactions = $this->Transaction->getTransactionInfo(array('account' => $player, 'type' => 0, 'session' => 'kris', 'fin' => $inicio,
            'inicio' => $fin, 'appid' => 'POS', 'userid' => 'pvuser'));


        return $transactions;
    }

    function getTransactionsRange() {
        $player = $this->request->data('player');
        $inicio = $this->request->data('inicio');
        $fin = $this->request->data('fin');
        $transactions = $this->getTransactions($player, $inicio, $fin);


        return new CakeResponse(array('body' => json_encode($transactions)));
    }

    public function pagarTicket() {
        $user = $this->Auth->user();
        $monto = $this->request->data('monto');
        $ticket = $this->request->data('ticket');
        $branchID = $this->domain["BranchID"];

        $pagar = $this->Cashier->setPagoXTiquete(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto,
            'docnum' => (int) $ticket, 'username' => trim($user['username']), 'cajero' => trim($user['player']), 'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));

        return new CakeResponse(array('body' => json_encode($pagar)));
    }

    public function depositarCaja() {
        $user = $this->Auth->user();
        $monto = $this->request->data('monto');
        $branchID = $this->domain["BranchID"];

        $open = $this->Cashier->setDepositosACaja(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto,
            'username' => trim($user['username']), 'cajero' => trim($user['player']), 'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $open = ($open['row1']) ? $open['row1'] : 0;


        return new CakeResponse(array('body' => json_encode($open)));
    }

    public function getTicket() {
        $user = $this->Auth->user();
        $ticketNum = trim($this->request->data('ticketId'));
        $branchID = $this->domain["BranchID"];
        $company = $this->domain["company"];
        $ticketPlayer = $this->Cashier->getTiquet(array('company' => $company, 'document' => (int) $ticketNum, 'branchid' => $branchID, 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $ticketPlayer = isset($ticketPlayer['row1']) ? $ticketPlayer['row1'] : 0;
        
        $ticketPlayer['retention']=($this->domain["applyRet"]=="0"?$this->domain["retentionPercent"]:0);
                
        return new CakeResponse(array('body' => json_encode($ticketPlayer)));
    }

//    public function printpay() {
//        $this->layout = '';
//        $authUser = $this->Auth->user();
//        $sitedesc=$this->domain["siteDesc"];
//        $this->set("siteDesc",$sitedesc);
//        $this->set("ticketsPay", json_decode(urldecode($_GET["params"])));
//        $this->set("monto", json_decode(urldecode($_GET["monto"])));
//        $this->set('authUser', $authUser);
//    }

    public function printdep() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set("doc", json_decode(urldecode($_GET["doc"])));
        $this->set('authUser', $authUser);
    }

    public function printopen() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set("doc", json_decode(urldecode($_GET["doc"])));
        $this->set('authUser', $authUser);
    }

    public function printboxdep() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set("doc", json_decode(urldecode($_GET["doc"])));
        $this->set('authUser', $authUser);
    }

    public function printboxret() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set("doc", json_decode(urldecode($_GET["doc"])));
        $this->set('authUser', $authUser);
    }

    public function printret() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set("doc", json_decode(urldecode($_GET["doc"])));
        $this->set('authUser', $authUser);
    }

    public function getSaldo() {
        $user = $this->Auth->user();
        $date = date_parse_from_format("m-d-Y H:i", date("m-d-Y H:i"));
        $date = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        $branchID = $this->domain["BranchID"];
        $saldo = $this->Cashier->getSaldo(array('company' => trim($user['root']), 'boxid' => (int) $user['caja'], 'date' => $date, 'branchid' => $branchID,
            'appid' => 'POS', 'userid' => trim($user['userID'])));
        $saldo = $saldo['row1'];

        return $saldo;
    }

    public function getSaldoAjax() {
        $saldo = $this->getSaldo();

        return new CakeResponse(array('body' => json_encode($saldo)));
    }

    public function setDepositoCuenta() {
        $user = $this->Auth->user();
        $player = $this->request->data('player');
        $monto = $this->request->data('monto');
        $branchID = $this->domain["BranchID"];

        $deposit = $this->Cashier->setDepositoCuenta(array('company' => trim($player), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto,
            'username' => trim($player), 'cajero' => trim($user['username']), 'agentid' => trim($player), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $deposit = $deposit['row1'];


        return new CakeResponse(array('body' => json_encode($deposit)));
    }

    public function setRetiroCuenta() {
        $user = $this->Auth->user();
        $player = $this->request->data('player');
        $monto = $this->request->data('monto');
        $branchID = $this->domain["BranchID"];

        $retiro = $this->Cashier->setRetiroCuenta(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto,
            'username' => trim($player), 'cajero' => trim($user['player']), 'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $retiro = $retiro['row1'];

        return new CakeResponse(array('body' => json_encode($retiro)));
    }

    public function getTransactionsBox() {
        $user = $this->Auth->user();
        $date = date_parse_from_format("m-d-Y H:i", date("m-d-Y H:i"));
        $date = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        $branchID = $this->domain["BranchID"];
        $company = $this->domain["company"];
        $transactions = $this->Cashier->getAlltransactionBox(array('company' => $company, 'boxid' => (int) $user['caja'], 'date' => $date, 'branchid' => $branchID,
            'appid' => 'POS', 'userid' => trim($user['userID'])));

        return $transactions;
    }

    public function getTransactionsBoxAjax() {
        $transactions = $this->getTransactionsBox();

        return new CakeResponse(array('body' => json_encode($transactions)));
    }

    public function printcierre() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $transactions = $this->getTransactionsBox();
        $saldo = $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("monto", json_decode(urldecode($_GET["monto"])));
        $this->set('authUser', $authUser);
        $this->set('transactions', $transactions);
    }

    public function setCierreCaja() {
        $user = $this->Auth->user();
        $monto = $this->getSaldo();
        $branchID = $this->domain["BranchID"];

        $cierre = $this->Cashier->setCierreCaja(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto['monto'],
            'username' => trim($user['username']), 'cajero' => trim($user['player']), 'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $cierre = ($cierre['row1']) ? $cierre['row1'] : 0;

        return new CakeResponse(array('body' => json_encode($cierre)));
    }

    public function setRetiroCaja() {
        $user = $this->Auth->user();
        $monto = $this->request->data('monto');
        $saldo = $this->getSaldo();
        $ret = 0;
        $branchID = $this->domain["BranchID"];

        if ($saldo > $monto) {
            $ret = $this->Cashier->setRetiroCaja(array('company' => trim($user['player']), 'boxID' => (int) $user['caja'], 'cashierID' => trim($user['cashierId']), 'branchID' => $branchID, 'monto' => (float) $monto,
                'username' => trim($user['username']), 'cajero' => trim($user['player']), 'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));

            $ret = ($ret['row1']) ? $ret['row1'] : 0;
        }


        return new CakeResponse(array('body' => json_encode($ret)));
    }

    public function getTransactionsBal() {
        $user = $this->Auth->user();
        $inicio = date_parse_from_format("m-d-Y H:i", date('m-d-Y H:i', strtotime("-30 days")), date("m-d-Y H:i"));
        $inicio = mktime($inicio['hour'], $inicio['minute'], $inicio['second'], $inicio['month'], $inicio['day'], $inicio['year']);

        $fin = date_parse_from_format("m-d-Y H:i", date("m-d-Y H:i"));
        $fin = mktime($fin['hour'], $fin['minute'], $fin['second'], $fin['month'], $fin['day'], $fin['year']);

        $branchID = $this->domain["BranchID"];
        $transactions = $this->Cashier->getTransactionAll(array('company' => trim($user['root']), 'boxid' => (int) $user['caja'], 'inicio' => $inicio,
            'fin' => $fin, 'branchid' => $branchID, 'appid' => 'POS', 'userid' => trim($user['userID'])));


        return $transactions;
    }

    public function balance() {
        //$this->Session->write('current_page', array('controller' => 'DashboardAdmin', 'action' => 'index'));
        $authUser = $this->Auth->user();
        $transactions = $this->getTransactionsBal();

        // $this->set('saldo', $this->getSaldo());
        $this->set('transactions', $transactions);
        $this->set('authUser', $authUser);
    }

    public function isOpen() {
        $user = $this->Auth->user();
        $date = date_parse_from_format("m-d-Y H:i", date("m-d-Y H:i"));
        $date = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        $branchId = $this->domain["BranchID"];
        $open = $this->Cashier->getIsOpen(array('company' => trim($user['root']), 'boxid' => (int) $user['caja'], 'branchid' => $branchId, 'date' => $date,
            'appid' => 'POS', 'userid' => trim($user['userID'])));

        $open = (int) $open['row1']['isopen'];


        return $open;
    }

    public function insertedbetsbyboxreport(){
        $authUser = $this->Auth->user();
        $caja = (int) $authUser['caja'];
        $inicio = date("Y-m-d") . " 00:00";
        $fin = date("Y-m-d") . " 23:59";

        $branchId = $this->domain["BranchID"];
        $tickets = $this->PvReports->betsreport($authUser['player'], $caja, $inicio, $fin, '', '', $branchId);


        return $tickets;
    }

    public function insertedbetsbyboxreportajax(){
        $inicio = $this->request->data('inicio');
        $fin = $this->request->data('fin');
        $caja = -1;
        $branchId = $this->domain["BranchID"];
        $authUser = $this->Auth->user();
        $response = $this->PvReports->betsreport($authUser['player'], $caja, $inicio, $fin, '', '', $branchId);

        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function eliminarTicket($ticket, $supervisor) {
        $user = $this->Auth->user();
        $branchID = $this->domain["BranchID"];
        $company = $this->domain["company"];
        $ticketPlayer = $this->Cashier->getTiquet(array('company' => $company, 'document' => (int) $ticket, 'branchid' => $branchID, 'appid' => 'POS', 'userid' => trim($user['userID'])));
        $ticketPlayer = isset($ticketPlayer['row1']) ? $ticketPlayer['row1'] : 0;


        $ret = $this->Cashier->Deleteticket(array('company' => $company, 'ticketnumber' => $ticket, 'supervisor' => $supervisor, 'appid' => 'POS', 'userid' => trim($user['userID'])));
        
        if (strtoupper($ticketPlayer['CustomerID']) == strtoupper($user['player'])) {
            $borrar = $this->Cashier->BorrarXTicket(array('company' => trim($user['player']), 'boxID' => (int) trim($user['caja']), 'cashierID' => (int) trim($user['cashierId']),
                'branchID' => $branchID, 'monto' => (float) $ticketPlayer['Risk'], 'docnum' => (int) $ticket, 'username' => trim($user['username']), 'cajero' => trim($user['username']),
                'agentid' => trim($user['player']), 'appid' => 'POS', 'userid' => trim($user['userID'])));
        }

        return $ret;
    }

    public function deleteTicket() {
        $authUser = $this->Auth->user();
        $ticket = (int) $this->request->data('ticket');

        if (!$this->hasPermission("ET")) {
            return $this->redirect(Router::url("/" . "DashboardAdmin", true));
        }else{
            $delete = $this->eliminarTicket($ticket, $authUser['player']);
        }

        return new CakeResponse(array('body' => json_encode($delete)));
    }
    
    
    public function getTransactionPlayer(){
        $docNum=@$_POST["docNum"];
        $company = $this->domain["company"];
        
        $response=$this->Cashier->getTransactionPlayer(array("company"=>$company,"docNum"=>$docNum,"appid"=>"","userid"=>""));
        
        return new CakeResponse(array('body' => json_encode($response)));
    }
    
    public function getTransactionInfo(){
        $docNum=@$_POST["docNum"];
        $company = $this->domain["company"];
        
        $response=$this->Cashier->getTransactionInfo(array("company"=>$company,"docNum"=>$docNum,"appid"=>"","userid"=>""));
        
        return new CakeResponse(array('body' => json_encode($response)));
    }

}
