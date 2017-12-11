<?php

App::uses('AppController', 'Controller');

public class StyleAdminController extends AppController {
    var $layout = 'admin_layout';
    public $uses = array();

    public function isAuthorized($user) {
        if ($user['accessAdmin']) {
            return true;
        }
        return false;
    }
    
    public function index() {
        $this->Session->write('current_page', array('controller' => 'StyleAdmin', 'action' => 'index'));
        $authUser = $this->Auth->user();
        $this->set('authUser', $authUser);
        $this -> render('index');
    }
    
    /**
     * load Ticket Lines
     */
    public function loadTemplates() {
        $this->layout = 'ajax';
        $authUser = $this->Auth->user();
        $CustomerID = $authUser['customerId'];
        $AgentID = $authUser['agentId'];
        $loadTicketLines['lines'] = $this->Sportbook->getTicketLines($CustomerID, $ticketNumber);
        $loadTicketLines['props'] = $this->Sportbook->getTicketProps($CustomerID, $ticketNumber);
        $this->set('data', $loadTicketLines);
        $this->render('json');
    }
}
