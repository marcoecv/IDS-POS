<?php

App::uses('Model', 'Model');

class Cashier extends AppModel {

    public $name = 'Cashier';

    public function getTiquetAll($params) {
        return $this->call('cashierService', 'getTiquetAll', $params);
    }

    public function setOpenCaja($params) {
        return $this->call('cashierService', 'setOpenCaja', $params);
    }

    public function getTiquet($params) {
        return $this->call('cashierService', 'getTiquet', $params);
    }

    
       public function getTiquetblr($params) {
           
        return $this->call('horse', 'getHorseBLR', $params);
    }
    
    
    public function getSaldo($params) {

        return $this->call('cashierService', 'getSaldo', $params);
    }

    public function setCierreCaja($params) {
        return $this->call('cashierService', 'setCierreCaja', $params);
    }

    public function setDepositoXTiquete($params) {
        return $this->call('cashierService', 'setDepositoXTiquete', $params);
    }

    public function setPagoXTiquete($params) {
        return $this->call('cashierService', 'setPagoXTiquete', $params);
    }

    public function setDepositoCuenta($params) {
        return $this->call('cashierService', 'setDepositoCuenta', $params);
    }

    public function setRetiroCuenta($params) {
        return $this->call('cashierService', 'setRetiroCuenta', $params);
    }

    public function setRetiroCaja($params) {
        return $this->call('cashierService', 'setRetiroCaja', $params);
    }

    public function setDepositosACaja($params) {
        return $this->call('cashierService', 'setDepositosACaja', $params);
    }

    public function getAlltransactionBox($params) {
        return $this->call('cashierService', 'getAlltransactionBox', $params);
    }

    public function getTransactionAll($params) {
        return $this->call('cashierService', 'getTransactionAll', $params);
    }

    public function getIsOpen($params) {
        return $this->call('cashierService', 'getIsOpen', $params);
    }

    public function Deleteticket($params) {
        return $this->call('cashierService', 'Deletetikect', $params);
    }

    public function BorrarXTicket($params) {
        return $this->call('cashierService', 'setBorrarXTiquete', $params);
    }
    
    public function getTransactionPlayer($params) {
        return $this->call('cashierService', 'getTransactionPlayer', $params);
    }

    public function revertTicketInsertion($params) {
        return $this->call('cashierService', 'getTransactionInfo', $params);
    }
    
    public function getTransactionInfo($params) {
        return $this->call('cashierService', 'revertInsertBet', $params);
    }
}
