<?php

class DashboardAdminController extends AppController {

    var $layout = 'admin_layout';
    public $uses = array('Account', 'Permission', 'Sportbook', 'User', 'Cashier', 'PvReports', 'CashierSecurity');

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
        //$this->Session->write('current_page', array('controller' => 'DashboardAdmin', 'action' => 'index'));
        $authUser = $this->Auth->user();
//        $comments = $this->requestAction(array('controller' => 'Comments', 'action' => 'getComment'), array('named' => array('typeCommentsToRetrieve' => 'Transmitter')));
        $comments = "";
        $isSupervisor = $this->hasPermission("SPV");

        $isOpen = $this->isOpen();
        
        $this->set('isOpen', $isOpen);
        $this->set('isSupervisor', $isSupervisor);
        $this->set('comments', $comments);
        $this->set('authUser', $authUser);
        $this->set('showMenu', false);
        $this->render('index');
    }

    /**
     * AJAX calls that returns the dashboard quick summary data
     * @return \CakeResponse
     */
    public function dailyFigure() {
        $this->autoRender = false;
        $total = array();
        try {
            $authUser = $this->Auth->user();
            $agentID = $authUser['customerId'];
            $lastWeeksFlag = trim($this->request->data('lastWeeksFlag'));
            $closeDow = $this->request->data('closeDow');

            if (isset($agentID)) {
                $soapReports = $this->getService('reports');
                $result = $soapReports->dailyFigureReport(array(
                    "agentID" => $agentID,
                    "lastWeeksFlag" => $lastWeeksFlag,
                    "closeDow" => $closeDow
                ));
                $response = json_decode($result->return, true);

                $total['Pending'] = 0;
                $total['currentbal'] = 0;
                $total['wtotal'] = 0;
                $total['Customers'] = 0;

                foreach ($response['results'] as $row) {
                    if (strpos($row['AgentID'], 'zzz') == false) {
                        $total['Pending'] = number_format($row['Pending'], 1);
                        $total['currentbal'] = number_format($row['currentbal'], 1);
                        $total['wtotal'] = $row['wtotal'];
                    }
                    if (!empty($row['CustomerID']) && strpos($row['CustomerID'], 'zzz') === false) {
                        $total['Customers'] ++; // Customer
                    }
                }
            }
        } catch (Exception $exc) {
            return new CakeResponse(array('body' => json_encode($exc->getMessage())));
        }
        return new CakeResponse(array('body' => json_encode($total)));
    }

    /**
     * Ajax call that returns and HTML containing all data showed on dasboarh for the line entry panel.
     * Shows all agent's modified lines
     * @return \CakeResponse
     */
    public function custProfileLineEntry() {
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        $account = $authUser['customerId'];
        $store = trim($authUser['store']);
        $view = new View($this, false);
        $html = '';
        try {
            if (isset($account)) {
                $soapLdap = $this->getService('lineEntry');
                $result = $soapLdap->getGameLinesInfo(array("account" => $account, 'store' => $store));
                $response = json_decode($result->return, true)['results'];

                foreach ($response as $line) {
                    $spread1 = $this->speadTeams($line["Spread"], $line["Team1ID"], $line["FavoredTeamID"]);
                    $spread2 = $this->speadTeams($line["Spread"], $line["Team2ID"], $line["FavoredTeamID"]);
                    $CustProfileLine = array('GameDateTime' => trim($line['GameDateTime']),
                        'SportType' => trim($line['SportType']),
                        'SubSport' => trim($line['SportSubType']),
                        'Team1ID' => trim($line['Team1ID']),
                        'Team2ID' => trim($line['Team2ID']),
                        'LinkedToStoreFlag' => trim($line['LinkedToStoreFlag']) == 'Y' ? 'Soft' : 'Hard',
                        'PeriodDescription' => trim($line['PeriodDescription']),
                        'MoneyLine1' => $this->setSignValue(trim($line['MoneyLine1'])),
                        'MoneyLine2' => $this->setSignValue(trim($line['MoneyLine2'])),
                        'Team1TotalPoints' => $this->processEncodeData(trim($line['Team1TotalPoints']), 't'),
                        'Team1TtlPtsAdj1' => $this->setSignValue(trim($line['Team1TtlPtsAdj1'])),
                        'Team1TtlPtsAdj2' => $this->setSignValue(trim($line['Team1TtlPtsAdj2'])),
                        'Team2TotalPoints' => $this->processEncodeData(trim($line['Team1TotalPoints']), 't'),
                        'Team2TtlPtsAdj1' => $this->setSignValue(trim($line['Team2TtlPtsAdj1'])),
                        'Team2TtlPtsAdj2' => $this->setSignValue(trim($line['Team2TtlPtsAdj2'])),
                        'TotalPoints' => $this->processEncodeData(trim($line['TotalPoints']), 't'),
                        'TtlPtsAdj1' => $this->setSignValue(trim($line['TtlPtsAdj1'])),
                        'TtlPtsAdj2' => $this->setSignValue(trim($line['TtlPtsAdj2'])),
                        'Spread1' => $this->processEncodeData(trim($spread1), 's'),
                        'Spread2' => $this->processEncodeData(trim($spread2), 's'),
                        'SpreadAdj1' => trim($line['SpreadAdj1']),
                        'SpreadAdj2' => trim($line['SpreadAdj2'])
                    );
                    $html .= $view->element('DashboardAdmin/custProfileLineEntry', array('data' => $CustProfileLine));
                }
                $this->autoRender = false;
                $this->set('content', $html);
                $this->layout = "ajax";
                $this->render('/Admin/index_ajax');
            }
        } catch (Exception $exc) {
            return new CakeResponse(array('body' => json_encode($exc->getMessage())));
        }
        return new CakeResponse(array('body' => json_encode($html)));
    }

    /**
     * Returns the proper and parsed value of spread points according to passed team and favortie team
     * @param string $spead
     * @param string $team
     * @param string $favorite
     * @return string
     */
    private function speadTeams($spead, $team, $favorite) {
        if (!empty($spead)) {
            if ($team == $favorite) {
                if ($spead < 0) {
                    return $spead;
                } else {
                    $spead = str_replace('+', '', $spead);
                    return -$spead;
                }
            } else {
                if ($spead < 0) {
                    return abs($spead);
                } else {
                    return $spead;
                }
            }
        }
        return $spead;
    }

    /**
     * Adds a "+" in front of a value, if this value is positive
     * @param string $value value to be processed
     * @return string
     */
    public function setSignValue($value) {
        return (float) $value > 0 ? "+" . $value : $value;
    }

    public function search() {
        $authUser = $this->Auth->user();
        $this->set('authUser', $this->Auth->user());
    }

    /*
      public function searchData(){
      $this->autoRender = false;
      $login = $this->Auth->user();
      $customerLog = $login['customerId'];
      $inPlayer = trim($this->request->data('playerBool'));
      $inAgent = trim($this->request->data('agentBool'));
      $searchWord = trim($this->request->data('searchWord'));
      $searchIn = trim($this->request->data('searchIn'));

      $view = new View($this, false);
      $serachInArray = explode(',',$searchIn);
      $result = '';
      $i=0;

      $hierarchy = $this->Permission->getAgentChatHierarchy(array("account" => $customerLog));
      foreach($hierarchy as $row){
      $i++;
      $response = $this->Account->getAccountFullInfo(array("account" => $row['Customer'], "session" => $customerLog, "agent" => '', 'appid' => 'pregamesite' ,'userid' => $customerLog));
      $response = isset($response['row1']) ? $response['row1'] : $response;

      if($inPlayer == false || $inAgent == false){
      if($inPlayer == true && ($response['AccountType']=='M' || $response['AccountType']=='A'))
      continue;

      if($inAgent == true && ($response['AccountType']!='M' && $response['AccountType']!='A'))
      continue;
      }

      foreach($serachInArray as $field){
      $field=trim($field);
      if(isset($response[$field])){
      if(stripos(trim($response[$field]), $searchWord) !== false){
      //$result[]= $response;

      $result .= $view -> element('DashboardAdmin/lineTableSearch',  array('response' => $response));
      break;
      }
      }
      }

      }
      return new CakeResponse(array('body' => json_encode($result)));
      }
     */

    /**
     * Search Customers
     */
    public function searchData() {
        $this->autoRender = false;
        $result = null;

        $login = $this->Auth->user();
        $customerLog = $login['customerId'];
        $filter = trim($this->request->data('filter'));
        $searchWord = trim($this->request->data('searchWord'));
        $param = array("Customer" => $customerLog, "filter" => $filter, "desc" => $searchWord, 'appid' => 'pregamesite', 'userid' => $customerLog);
        $response = $this->Account->SearchCustomers($param);

        if (!empty($response) && $response != -1) {
            $view = new View($this, false);
            foreach ($response as $row) {
                $result .= $view->element('DashboardAdmin/lineTableSearch', array('response' => $row));
            }
        }
        return new CakeResponse(array('body' => json_encode($result)));
    }

    public function findPlayer() {
        $customerId = trim($this->request->data('customerId'));
        $user = $this->Auth->user();
        $response = $this->Account->getAccountFullInfo(array("account" => trim($customerId), "agent" => $user['root'], 'appid' => 'pregamesite', 'userid' => $user['root']));
        $customerPersonal = (isset($response['row1'])) ? $response['row1'] : $response;


        if (isset($customerPersonal['CustomerID'])) {
            $fullCustomer = $this->Sportbook->getCustomer(trim($customerId), trim($user['root']), trim($user['username']));

            $customerPersonal['balance'] = $fullCustomer['Available'];

            return new CakeResponse(array('body' => json_encode($customerPersonal)));
        } else {
            return new CakeResponse(array('body' => 0));
        }
    }

    public function createPlayer() {
        $account = 'pvagent';
        $player = 'pvplayer2';
        $password = '13232';
        $typeAccount = 'P';
        $inherit = '???';
        $base = '??';
        $appid = 'POS';
        $userid = 'pvuser';

        $newplayer = $this->Account->saveAssignNew(array('account' => $account, 'newaccount' => $player, 'password' => $password,
            'typeaccount' => $typeAccount, 'inherit' => $inherit, 'base' => $base, 'appid' => $appid, 'userid' => $userid));
    }

    public function validateAdmin() {
        $username = $this->request->data('adminUser');
        $password = $this->request->data('adminPass');
        $company = $this->domain["company"];
        $branchId = $this->domain["BranchID"];
        $supervisor = NULL;

        $response = $this->CashierSecurity->getCajero(array('company' => trim($company), "branchid" => $branchId, 'user' => $username, 'pass' => md5($password), 'appid' => 'POS', 'userid' => $username));
        $user = (isset($response['row1'])) ? $response['row1'] : $response;


        if (!empty($user)) {
            $permissions = $this->User->getUserPermissionsByApp($user['UserID'], '34');
        }
        foreach ($permissions as $permission) {

            if ($permission['PermissionDesc'] == 'Supervisor') {
                $supervisor = 1;
            }
        }

        return new CakeResponse(array('body' => json_encode($supervisor)));
    }

    public function printaccount() {
        $this->layout = '';
        $authUser = $this->Auth->user();
        $sitedesc=$this->domain["siteDesc"];
        $this->set("siteDesc",$sitedesc);
        $this->set("detail", json_decode(urldecode($_GET["params"])));
        $this->set("cuenta", urldecode($_GET["cuenta"]));
        $this->set('authUser', $authUser);
    }

    public function isOpen() {
        $user = $this->Auth->user();
        $date = date_parse_from_format("m-d-Y H:i", date("m-d-Y H:i"));
        $date = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        $branchId = $this->domain["BranchID"];
        $open = $this->Cashier->getIsOpen(array('company' => trim($user['root']), 'boxid' => (int) $user['caja'], 'date' => $date,
            'appid' => 'POS', 'userid' => trim($user['userID']), "branchid" => $branchId));

        $open = (int) $open['row1']['isopen'];


        return $open;
    }

}
