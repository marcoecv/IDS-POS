<?php

App::uses('Model', 'Model');

class Account extends AppModel {

    public $name = 'Account';

    public function validateAccount($params) {
        return $this->call('accounts', 'validateAccount', $params);
    }

    public function isInTheAgentHierarchy($params) {
        return $this->call('accounts', 'isInTheAgentHierarchy', $params);
    }

    public function getStore($params) {
        return $this->call('info', 'getStore', $params);
    }

    public function getAccount($params) {
        return $this->call('accounts', 'getAccount', $params);
    }

    public function getAccountFullInfo($params) {
        return $this->call('accounts', 'getAccountFullInfo', $params);
    }

    public function getStatusLoad($params) {
        return $this->call('accounts', 'getStatusLoad', $params);
    }


    public function getPlayerHierarchy($params) {
        return $this->call('accounts', 'getPlayerHierarchy', $params);
    }


    public function getlive($params) {
        return $this->call('accounts', 'getlive', $params);
    }

    public function getDetailInfoOwn($params) {
        return $this->call('detaillimit', 'getDetailInfoOwn', $params);
    }

    public function getCustomerBalance($params) {
        return $this->call('accounts', 'getCustomerBalance', $params);
    }

    public function customerfixbalance($params) {
        return $this->call('accounts', 'customerfixbalance', $params);
    }

    public function getParentAgent($params) {
        return $this->call('AgentAdminChat', 'getParentAgent', $params);
    }

    public function getAgentInfo($params) {
        return $this->call('agents', 'getAgentInfo', $params);
    }

    public function sendMailRequestNewAccount($params) {
        return $this->call('accounts', 'requestNewAccount', $params);
    }

    public function getLiveGameInNextXXhours($params) {
        return ($this->call('accounts', 'getLiveGameInNextXXhours', $params));
    }

    public function getLiveGameDetail($params) {
        return ($this->call('accounts', 'getLiveGameDetail', $params));
    }

    public function getUpComingPreGameXXmins($params) {
        return $this->call('accounts', 'getUpComingPreGameXXmins', $params);
    }

    public function GetNextInetCustomerID($params) {
        return $this->call('accounts', 'GetNextInetCustomerID', $params);
    }

    public function getAccountMail($params) {
        return $this->call('accounts', 'getAccountMail', $params);
    }

    public function setCustomerslineFormat($params) {
        return $this->call('accounts', 'setCustomerslineFormat', $params);
    }

    public function InsertCustStoreProfile($params) {
        return $this->call('accounts', 'InsertCustStoreProfile', $params);
    }

    public function InsertCustomer($params) {
        return $this->call('accounts', 'InsertCustomer', $params);
    }

    public function InsertCustTeaser($params) {
        return $this->call('accounts', 'InsertCustTeaser', $params);
    }

    public function SearchCustomers($params) {
        return $this->call('accounts', 'SearchCustomers', $params);
    }

    public function verifyUserLogin($params) {
        return $this->call('accounts', 'verifyUserLogin', $params);
    }

    public function checkUserNameExist($params) {
        return $this->call('accounts', 'checkUserNameExist', $params);
    }

    public function saveAssignNew($param) {
        return $this->call('accounts', 'saveAssigNew', $param);
    }

}

?>
