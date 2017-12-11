<?php

App::uses('Model', 'Model');

class Transaction extends AppModel
{
    public $name = 'Transactions';

    public function getCasinoPlay($params)
    {
        return $this->call('transactionService', 'getCasinoPlay', $params);
    }

    public function getDetailTransaction($params)
    {
        return $this->call('transactionService', 'getDetailTransaction', $params);
    }

    public function getTransactionInfo($params)
    {
        return $this->call('transactionService', 'getTransactionInfo', $params);
    }

    public function setDeleteTransaction($params)
    {
        return $this->call('transactionService', 'setDeleteTransaction', $params);
    }

    public function setEditTransaction($params)
    {
        return $this->call('transactionService', 'setEditTransaction', $params);
    }

    public function setTransaction($params)
    {
        return $this->call('transactionService', 'setTransaction', $params);
    }






}