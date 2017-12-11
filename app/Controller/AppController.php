<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = array(
        'Session',
        'LiveHelper',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'home'
            ),
            'loginRedirect' => array(
                'controller' => 'index',
                'action' => 'user'
            ),
            'logoutRedirect' => array(
                'controller' => 'index',
                'action' => 'home'
            ),
            'unauthorizedRedirect' => array(
                'controller' => 'pages',
                'action' => 'unauthorized'
            ),
            'authorize' => array('Controller')
        )
    );

    public $uses = array('Account', 'Sportbook', 'Cashier','PvReports');
    public $domain;

    public function beforeFilter()
    {
        // domain
        $this->domain = $this->LiveHelper->getFullDomain();

        // theme
        //$this->theme = $this->getTheme();
        $this->theme = $this->domain['theme'];
        Configure::write('theme', $this->theme);
        Configure::write('LineTypes', $this->getLines());

        // auth
        $this->Auth->allow('dologin');
        $this->Auth->allow('poslogin');
        $this->Auth->allow('verifyUserLogin');
        $this->Auth->allow('checkUserNameExist');
        $this->Auth->allow('dologinajax');
        $this->Auth->allow('Register');
        $this->Auth->allow('getAccountMail');
        $this->Auth->allow('external_login');
        $this->Auth->allow('boxVerificationMaintenance');

        //setea las varibles de configuracion y themas

        Configure::write('Config.language', $this->domain["language"]);
		// lang ! Important
		$this->Session->write('User.language', Configure::read('Config.language'));
		if(isset($this->params['language'])){
			if(in_array($this->params['language'], Configure::read('Config.languages')))
				$this->Session->write('User.language', $this->params['language']);
		}

		$configurations = $this->configurations();
		$this->configurationsUser($configurations);
        
    }

    /*
     * is Authorized for delault
     */
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Get Service
     *
     * @param string $serviceName
     * @return Object json result of service
     */
    
    
    public function getService($serviceName)
    {
        try {
            ini_set('soap.wsdl_cache_enabled', 0);
            ini_set('soap.wsdl_cache_ttl', 0);

            $client = new SoapClient($this->getServiceName($serviceName), array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));
            return $client;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    public function getReadDatabase()
    {
        return Configure::read('db.read');
    }

    public function getEditDatabase()
    {
        return Configure::read('db.edit');
    }
    
    public function getAnomiAccount()
    {
        return "00caja";
    }

    /**
     * get Domain
     *
     * @return array domain
     */
    public function getDomain()
    {
        return $this->LiveHelper->getFullDomain();
    }

    /**
     * Function to get the application id
     *
     * @param String The name of the service that is going to be called
     *
     * @return The url of the service
     */
    public function getAppId()
    {
        return Configure::read('appid');
    }

    /**
     * Function to get the user id
     *
     * @param String The name of the service that is going to be called
     *
     * @return The url of the service
     */
    public function getUserId()
    {
        return $this->getServiceUserLogged('User');
    }

    protected function parseLanguage($name)
    {
        if ($name == 'Español') {
            return 'esp';
        } else if ($name == 'Français') {
            return 'fra';
        } else {
            return 'eng';
        }
        return 'eng';
    }

    /**
     * Function to set the names and the urls of the services - This needs to be passed to a .ini
     *
     * @param String The name of the service that is going to be called
     *
     * @return The url of the service
     */
    private function getServiceName($serviceName)
    {
        return Configure::read('service.' . $serviceName);
    }


    /**
     * check the user session in valid
     * @return Bool
     */
    public function check_user_session()
    {
        $user_session = $this->Session->read('username');
        if ($user_session == null) {
            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
            return false;
        } else {
            return true;
        }
    }

    /**
     * get Service User Logged
     * @param string $serviceName Name
     * @return array  info
     */
    private function getServiceUserLogged($serviceName)
    {
        return Configure::read('Logged.' . $serviceName);
    }

    /*
	 * Valid account
	 * @return Object json info account
	 */
    public function validaccount()
    {
        $this->Session->delete('UserLogged');
        $this->autoRender = false;
        $ar = array();
        $salida = array();
        $count = 0;

        $ar['User'] = $this->getServiceUserLogged('User');
        $ar['Parent'] = $this->getServiceUserLogged('Parent');

        $target = trim($this->request->data('target'));
        if ($target == "UserLogged") {
            $player = trim($this->getServiceUserLogged('User'));
            $agent = $this->getServiceUserLogged('Parent');
        } else {
            $player = trim($this->request->data('player'));
            $agent = trim($this->request->data('agent'));
        }

        $count += 1;
        $UserLogged[$count] = $ar;
        if (isset($player)) {
            $response = $this->Account->validateAccount(array("account" => $player, "agent" => $agent));

            if (isset($response) && $response != "") {
                $this->Session->write('username', $response["row1"]);
                $this->Session->write('UserLogged', $UserLogged);
                $salida["existe"] = $response["row1"];
                $userLoggedSession = $this->Session->read('UserLogged');

                if (!empty($userLoggedSession)) {
                    $salida["userlogged"] = $userLoggedSession;
                    foreach ($userLoggedSession as $row) {
                        $Parent = $row['Parent'];
                        $User = $row['User'];
                        $response2 = $this->Account->isInTheAgentHierarchy(array("agentid" => $User, "account" => $player, "agentVal" => "Y"));

                        if (isset($response2) && $response2 != "") {
                            $salida["AgentInJer"] = $response2["row1"];
                        } else {
                            $salida["AgentInJer"] = 0;
                        }
                    }
                } else {
                    $salida["userlogged"] = 0;
                }
            } else {
                $this->Session->write('username', "");
                $salida["existe"] = 0;
                $salida["userlogged"] = 0;
                $salida["AgentInJer"] = 0;
            }
        }
        return new CakeResponse(array('body' => json_encode($salida)));
    }

    /**
     * Function to get name of the theme
     *
     * @return Name of the theme
     */
    public function getTheme()
    {
        $url = Router::url($this->here, true);
        if (strpos($url, '.com') != null) {
            $subUrl = substr($url, 0, strpos($url, '.com'));
        } else if (strpos($url, '.net') != null) {
            $subUrl = substr($url, 0, strpos($url, '.net'));
        } else if (strpos($url, '.ag') != null) {
            $subUrl = substr($url, 0, strpos($url, '.ag'));
        } else {
            return Configure::read('theme');
        }
        $subUrl = substr($subUrl, strrpos($subUrl, "/") + 1);

        $theme = "";
        if (strrpos($subUrl, ".") !== false) $theme = ucfirst(substr($subUrl, strrpos($subUrl, ".") + 1));
        else $theme = ucfirst(substr($subUrl, strrpos($subUrl, ".")));

        if (strlen($theme) > 0) {
            return $theme;
        }
        return Configure::read('theme');
    }

    public function getLines()
    {
        $lineTypes = $this->domain['LineTypes'];
        if ($this->domain['theme'] == "Betlatino") {
            $lineTypes = 'MoneyLine';
        }
        return $lineTypes;
    }

    /**
     *
     *
     * @return Type    Description
     */

    public function configurations()
    {
        $user = $this->Auth->user();
        $customer = $user["customerId"];
        $site = $this->domain['inetTarget'];
        $configurations = null;
        $configurations = $this->Sportbook->getAgentTemplateDesing(array("CustomerID" => $customer, "Site" => $site, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
        $configurations = (isset($configurations["results"]) ? $configurations["results"] : $configurations);

        return $configurations;
    }

    public function hasPermission($permission){
        $user = $this->Auth->user();
        $hasPerm = false;
        $UserPermissions = $user['userPermissions'];
        foreach ($UserPermissions as $userPermission) {
            if ($permission == $userPermission['RoleName']){
                $hasPerm = true;
            }
        }
        return $hasPerm;
    }

    protected function configurationsUser($configurations){
        $user = $this->Auth->user();
        $customer = $user["customerId"];
        $site = $this->domain['inetTarget'];
        $arrayColorsDefault = array("@color-Menus: #2f3c42;",
            "@color-MenusText: #ffffff;",
            "@color-MenusHover: #1462FC;",
            "@color-Buttons: #4ea74e;",
            "@color-Buttons-White: #CBCCCC;",
            "@color-SubHeaders: #999999;",
            "@color-Warning: #c12e2a;",
            "@color-Notes: #ffffb3;",
            "@color-black: #000000;",
            "@color-dropdown: #313c42;",
            "@color-menubetslip: #8A8A8A;",
            "@color-betslip-selections-messages: #333333;",
            "@color-betslip-panel-default: #DFDFDF;",
            "@color-betslip-modal-header: #facc2e;",
            "@color-caution: #030536;",
            "@color-MenusTextBold: #fa5736;",
            "@color-Background-body: #ffffff;",
            "@color-Background-tables: #ffffff;",
            "@color-Background-betslip: #ffffff;",
            "@color-Background-header: #ffffff;",
            "@color-Background-footer: #ffffff;"
        );


        if (isset($user)) {
            $urlCur = Router::url($this->here, true);
            $urlCur = strtolower($urlCur);
            $protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
            $urlCur = str_replace($protocol, "", $urlCur);
            $arrayUrl = explode("/", $urlCur);

            $contUrl = 0;
            foreach ($arrayUrl as &$detail) {
                if (trim($detail) != "")
                    $contUrl++;
            }

            if ($contUrl <= 1) {
                $this->Auth->logout();
                return "";
            }
            if (isset($configurations) && sizeof($configurations) > 0) {

                if (!isset($_COOKIE["LineTypeFormat"]) || $_COOKIE["LineTypeFormat"] != $configurations["LineTypeFormat"]) {
                    Configure::write('LineTypeFormat', 'American');
                    $this->LineTypeFormat = 'American';
                    setcookie("LineTypeFormat", $this->LineTypeFormat, -1, "/");
                }

                Configure::write('TemplateID', $configurations["TemplateID"]);
                $this->TemplateID = $configurations["TemplateID"];

                Configure::write('BetTypes', urldecode($configurations["BetTypes"]));
                $this->BetTypes = urldecode($configurations["BetTypes"]);

                Configure::write('MenuOptions', urldecode($configurations["MenuOptions"]));
                $this->MenuOptions = urldecode($configurations["MenuOptions"]);

                Configure::write('InfoGeneral', urldecode($configurations["InfoGeneral"]));
                $this->InfoGeneral = urldecode($configurations["InfoGeneral"]);

                Configure::write('BetTypes', urldecode($configurations["BetTypes"]));
                $this->BetTypes = urldecode($configurations["BetTypes"]);

                Configure::write('CashierType', $configurations["CashierType"]);
                $this->CashierType = $configurations["CashierType"];

                //Load agent template detail data
                $detailTemplate = $this->Sportbook->getDetailTemplate(array("CustomerID" => $customer, "TemplateID" => $this->TemplateID, "appid" => $this->getAppId(), "userid" => $this->getUserId()));
                $detailTemplate = (isset($detailTemplate["results"]) ? $detailTemplate["results"] : $detailTemplate);

                $this->Session->write("user_template", $detailTemplate);

                $currentPath = getcwd();
                $searchPath = "app/";
                $currentPath = substr($currentPath, 0, strpos($currentPath, $searchPath)) . $searchPath;

//				$myfile = fopen($currentPath."tmp/styleUsed.txt", "w+") or die("Unable to open file!");
//              $txt = "";
//				foreach ($detailTemplate as &$detail) {
//					$txt .= "@".trim(urldecode($detail["DetailName"])).": ".trim(urldecode($detail["Value"])).";\n";					
//				}
//              fwrite($myfile, $txt);
//				fclose($myfile);
            } else {
                if (!isset($_COOKIE["Language"])) {
                    setcookie("Language", $this->domain['Language'], -1, "/");
                }

                if (!isset($_COOKIE["LineTypeFormat"])) {
                    setcookie("LineTypeFormat", $this->domain['LineTypeFormat'], -1, "/");
                }

                Configure::write('TemplateID', $configurations["TemplateID"]);
                $this->TemplateID = $configurations["TemplateID"];

                Configure::write('BetTypes', urldecode($configurations["BetTypes"]));
                $this->BetTypes = urldecode($configurations["BetTypes"]);

                Configure::write('MenuOptions', urldecode($configurations["MenuOptions"]));
                $this->MenuOptions = urldecode($configurations["MenuOptions"]);

                Configure::write('InfoGeneral', urldecode($configurations["InfoGeneral"]));
                $this->InfoGeneral = urldecode($configurations["InfoGeneral"]);

                Configure::write('BetTypes', urldecode($configurations["BetTypes"]));
                $this->BetTypes = urldecode($configurations["BetTypes"]);

                Configure::write('CashierType', $configurations["CashierType"]);
                $this->CashierType = $configurations["CashierType"];

                $currentPath = getcwd();
                $searchPath = "app/";
                $currentPath = substr($currentPath, 0, strpos($currentPath, $searchPath)) . $searchPath;

//				$myfile = fopen($currentPath."tmp/styleUsed.txt", "w") or die("Unable to open file!");
                //$resultDetail = $soapLdap->getDetailTemplate(array("CustomerID" => $this->domain['AgentID'], "TemplateID" => $this->domain['TemplateID'], "appid" => $this->getAppId(), "userid" => $this->getUserId()));
                //$detailTemplate = json_decode($resultDetail->return, true);
                $detailTemplate = $this->Sportbook->getDetailTemplate(array("CustomerID" => $this->domain['AgentID'], "TemplateID" => $this->domain['TemplateID'], "appid" => $this->getAppId(), "userid" => $this->getUserId()));

//              $txt = "";
                $this->Session->write("user_template", $detailTemplate);
//				if(isset($resultDetail) && sizeof($detailTemplate) > 0){                                        
//					foreach ($detailTemplate["results"] as &$detail) {
//						$txt .= "@".trim(urldecode($detail["DetailName"])).": ".trim(urldecode($detail["Value"])).";\n";
//					}
//				}else{
//					foreach ($arrayColorsDefault as &$detail) {
//						$txt .= $detail."\r\n";
//					}
//				}
//                                fwrite($myfile, $txt);
//				fclose($myfile);	
            }
        } else {
            //si no cargar uno por defecto
            /*$currentPath = getcwd();
            $searchPath = "app/";
            $currentPath = substr ($currentPath, 0, strpos($currentPath, $searchPath)).$searchPath;*/

            /*$myfile = fopen($currentPath."tmp/styleUsed.txt", "w") or die("Unable to open file!");
            foreach ($arrayColorsDefault as &$detail) {
                $txt = $detail."\r\n";
                fwrite($myfile, $txt);
            }
            fclose($myfile);*/
        }
    }
    
     /**
     * Takes a points value from decimals (ie 100.75) and outputs a parsed value for better view (ie 100 +½,+1)
     * @param string $valor value to be parsed
     * @param string $total type of bet
     * @return string
     */
    public function processEncodeData($valor, $total) {
        $return = "";
        $valor = floatval($valor);
        if (empty($valor)) {  // if null or 0
            if($total=='s'){
                $return='PK';
            }else{
                $return = '';
            }
        } else {
            if (is_numeric($valor)) { // if numeric
                if (floor($valor) != $valor) { // if float
                    $integer = null;
                    if ($valor > 0) {
                        $integer = floor($valor); // int inf
                    } else {
                        $integer = ceil($valor); // int sup
                    }
                    $rest = abs($valor) - abs($integer); // despues del coma
                    $valor_string = strval($valor);
                    if ($valor > 0 && $total == 's') {
                        $valor_string = '+' . $valor_string;
                    }
                    $pos = strpos($valor_string, '.');
                    $integer_string = substr($valor_string, 0, $pos);
                    if ($total == 's') { // Spread
                        switch (abs($rest)) {
                            case 0.25:
                                if (abs($integer) == 0) {
                                    if ($valor < 0) {
                                        $return = 'pk,-½';
                                    } else {
                                        $return = 'pk,+½';
                                    }
                                } else {
                                    $return = $integer_string . ',' . $integer_string . '½';
                                }
                                break;
                            case 0.5:
                                if (abs($integer) == 0) {
                                    if ($valor < 0) {
                                        $return = '-½';
                                    } else {
                                        $return = '+½';
                                    }
                                } else {
                                    $return = $integer_string . '½';
                                }
                                break;
                            case 0.75:
                                if (abs($integer) == 0) {
                                    if ($valor < 0) {
                                        $return = '-½,-1';
                                    } else {
                                        $return = '+½,+1';
                                    }
                                } else {
                                    if ($valor < 0) {
                                        $return = $integer_string . '½,' . strval(floor($valor));
                                    } else {
                                        $return = $integer_string . '½,' . strval(ceil($valor));
                                    }
                                }
                                break;
                        }
                    } else { // No Spread
                        if (abs($rest) == 0.5) {
                            if (abs($integer) == 0) {
                                if ($valor < 0) {
                                    $return = '-½';
                                } else {
                                    $return = '+½';
                                }
                            } else {
                                $return = $integer_string . '½';
                            }
                        }
                    }
                } else { // if integer or total/ttp
                    if ($valor > 0) {
                        if ($total == 's') {
                            $return = '+' . strval($valor);
                        } else {
                            $return = strval($valor);
                        }
                    } else {
                        $return = strval($valor);
                    }
                }
            } else { // if not numeric
                $return = '';
            }
        }
        return $return;
    }
}

