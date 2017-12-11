<?php

App::uses('Model', 'Model');

class CashierSecurity extends AppModel
{
    public $name = 'CashierSecurity';

    public function getPermissions($param){
        return $this->call('cashierSecurity', 'getPermisoUser', $param);
    }

    public function getCajero($param){
        return $this->call('cashierSecurity', 'getCajero', $param);
    }

    public function boxVerificationMaintenance($param){
        return $this->call('cashierSecurity', 'boxRestriction', $param);
    }
}