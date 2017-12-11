<?php

App::uses('AppController', 'Controller');

class AgentReportsController extends AppController
{
    var $layout = 'admin_layout';
    public $uses = array('Account', 'Reports', 'Configuration', 'Wagers');

    public function beforeFilter(){
        parent::beforeFilter();
        $userAuth = $this->Auth->user();
        if (@$userAuth['app'] != 'pregamesite')
            $this->Auth->logout();
        // Read helper App
        $view = new View($this);
        $this->App = $view->loadHelper('App');
    }

    public function action_by_player(){
        if(!$this->hasPermission("ABP")){
            return $this->redirect(Router::url("/" . "PvReports", true));
        }
        $authUser = $this->Auth->user();
        $this->set('authUser', $authUser);
        $this->render('/ActionPlayer/index');
    }

    public function executeActionPlayer()
    {
        $this->autoRender = false;
        $authUser = $this->Auth->user();
        $customer = $this->domain["company"];
        $parent = trim($this->request->data('SubAgent'));
        $startDate = trim($this->request->data('startDate'));
        $endDate = trim($this->request->data('endDate'));
        $summaryActive = $this->request->data('summaryActive');


        if (isset($customer)) {
            if (strlen(trim($parent)) > 0) {
                $response = $this->Reports->actionByPlayerReport(array(
                    "agentID" => $parent,
                    "subAgentID" => $customer,
                    "startDate" => $startDate,
                    "endDate" => $endDate,
                    "summary" => $summaryActive
                ));
            } else {
                $response = $this->Reports->actionByPlayerReport(array(
                    "agentID" => $customer,
                    "subAgentID" => $parent,
                    "startDate" => $startDate,
                    "endDate" => $endDate,
                    "summary" => $summaryActive
                ));
            }
        }

        if (!isset($response)) {
            return new CakeResponse(array(
                'body' => json_encode("")
            ));
        } else {
            return new CakeResponse(array(
                'body' => json_encode($response)
            ));
        }
    }


    public function getTransactions()
    {
        $this->autoRender = false;
        $res = null;

        $authUser = $this->Auth->user();
        $customerAuth = $authUser['customerId'];

        $agent = trim($this->request->data('agent'));
        $customer = trim($this->request->data('customer'));
        $start = trim($this->request->data('start'));
        $end = trim($this->request->data('end'));
        $freePlay = trim($this->request->data('freePlay'));

        $reponse = array();
        if (isset($customer) && isset($start) && isset($end)) {
            if ($customer == 'all') {
                $listPlayers = $this->Account->getPlayerHierarchy(array("agent" => $customerAuth, 'appid' => 'PreGameSite', 'userid' => $customerAuth));
                foreach ($listPlayers as $row) {
                    $CustomerID = $row['CustomerID'];
                    if ($freePlay) {
                        $res = $this->Wagers->getTransactionInfo(array("account" => $CustomerID, "type" => 0, "session" => 'kris', "fin" => $start, "inicio" => $end));
                        if (!empty($res))
                            $reponse[] = $res;
                    } else {
                        $res = $this->Wagers->getTransactionInfo(array("account" => $CustomerID, "type" => 1, "session" => 'kris', "fin" => $start, "inicio" => $end));
                        if (!empty($res))
                            $reponse[] = $res;
                    }
                }
            } else {
                if ($freePlay) {
                    $reponse[] = $this->Wagers->getTransactionInfo(array("account" => $customer, "type" => 0, "session" => 'kris', "fin" => $start, "inicio" => $end));
                } else {
                    $reponse[] = $this->Wagers->getTransactionInfo(array("account" => $customer, "type" => 1, "session" => 'kris', "fin" => $start, "inicio" => $end));
                }
            }
        }
        if (!isset($reponse)) {
            return new CakeResponse(array(
                'body' => json_encode("")
            ));
        } else {
            return new CakeResponse(array(
                'body' => json_encode($reponse)
            ));
        }
    }
}