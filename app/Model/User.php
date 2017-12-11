<?php

App::uses('Model', 'Model');

class User extends AppModel
{
    public $name = 'User';

    public function validateUserPv($params)
    {
        return $this->call('userService', 'validateUser_pv', $params);
    }

    public function getUsers()
    {
        return $this->call('userService', 'getUsers', array('db' => 'LOG'));
    }

    public function getPermissionsByUser($param)
    {
        return $this->call('permissionService', 'getPermissionsByUser', $param);
    }


    public function getUserPermissionsByApp($userID, $appID)
    {
        $response = $this->getPermissionsByUser(array('db' => 'LOG', 'userID' => $userID));
        $permission = array();

        foreach ($response as $app) {
            if (!empty($appID)) {
                if ($app['AppID'] == $appID && $app['Asign'] != '0') {
                    array_push($permission, $app);
                }
            } else {
                if ($app['Asign'] != '0') {
                    array_push($permission, $app);
                }
            }
        }

        return $permission;
    }


}