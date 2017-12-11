<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('wsCashierLib', 'Lib');
App::uses('wsCashierTagLib', 'Lib');
App::uses('CakeEmail', 'Network/Email');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    //use 'Cake\Controller\Component\CookieComponent';
    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('Account', 'Permission', 'Sportbook', 'Mail', 'Configuration', 'User', 'CashierSecurity');
    public $components = array('LiveHelper', 'RequestHandler');

    // Configuración

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function external_login() {
        $this->layout = "ajax";
        $user = @$_GET['accountId'];
        $password = @$_GET['pass'];
        $this->set("user", $user);
        $this->set("password", $password);
    }

    public function getAccountMail() {
        $this->autoRender = false;
        $this->layout = "ajax";

        $site = $this->domain['siteDesc'];
        $domainConfig = $this->domain;

        $Customer = $domainConfig["AgentID"];
        $Email = trim($this->request->data('email'));

        $res = $this->Account->getAccountMail(array("Customer" => $Customer, "Email" => $Email, "appid" => 'Pregamesite', "userid" => null));

        $result = 0;
        $message = "";
        if (sizeof($res) > 0) {
            $view = new View($this, true);
            $bodyMail = $view->element('Email/Html/' . $site . '/password', array('nameFirst' => $res["row1"]["NameFirst"], 'nameLast' => $res["row1"]["NameLast"], 'username' => (isset($res["row1"]["UserName"]) ? $res["row1"]["UserName"] : ""), 'pin' => $res["row1"]["CustomerID"], 'password' => $res["row1"]["Password"]));
            $this->Mail->sendMail(array("to" => $Email, "from" => $this->domain['sendMail'], "client" => "sportsroom", "subject" => 'Password ' . $this->domain['inetTarget'], "message" => $bodyMail));

            $message = "An email was sent with your user information.";
            $result = 1;
        } else {
            $message = "Mail not found in the site.";
            $result = -1;
        }

        return new CakeResponse(array('body' => json_encode(array("Message" => $message, "Result" => $result))));
    }

    public function getInfoCustomer() {
        $this->autoRender = false;
        $this->layout = "ajax";

        $userLog = $this->Auth->user();
        $customerId = $userLog['customerId'];
        $agentId = $userLog['agentId'];

        $fullCustomer = $this->Sportbook->getCustomer($customerId, $agentId);

        return new CakeResponse(array('body' => json_encode($fullCustomer['Available'])));
    }

    public function register() {
        $this->autoRender = false;
        $this->layout = "ajax";
        
        $result = 0;

        $userName = ''; //trim($this->request->data('userName'));
        if (empty($userName)) {
            $userName = null;
        }
        $nameFirst = trim($this->request->data('nameFirst'));
        $nameLast = trim($this->request->data('nameLast'));
        $address1 = trim($this->request->data('address1'));
        $address2 = ''; // trim($this->request->data('address2'));
        $BirthMonth = '01'; // trim($this->request->data('BirthMonth'));
        $BirthDay = '01'; // trim($this->request->data('BirthDay'));
        $BirthYear = '1900'; // trim($this->request->data('BirthYear'));
        $city = ''; // trim($this->request->data('city'));
        $state = ''; // trim($this->request->data('state'));
        $zip = ''; // trim($this->request->data('zip'));
        $country = ''; // trim($this->request->data('country'));
        $countryCode = ''; // trim($this->request->data('countryCode'));
        $email = trim($this->request->data('email'));
        $confirmEmail = trim($this->request->data('confirmEmail'));
        $securityQuestion = ''; //trim($this->request->data('securityQuestion'));
        $securityAnswer = ''; //trim($this->request->data('securityAnswer'));
        $promoCode = ''; //trim($this->request->data('promoCode'));
        $homePhone = trim($this->request->data('homePhone'));
        $businessPhone = trim($this->request->data('businessPhone'));
        $fax = ''; //trim($this->request->data('fax'));
        $referredBy = ''; //trim($this->request->data('referredBy'));
        $source = ''; //trim($this->request->data('source'));
        $password = trim($this->request->data('password'));
        $confirmPassword = trim($this->request->data('confirmPassword'));
        $lan = strtolower(substr($this->domain['Language'], 0, 3));

        $site = $this->domain['siteDesc'];
        $domainConfig = $this->domain;
        $view = new View($this, true);


        $pin = "";
        switch ($domainConfig["pinScheme"]) {
            case "FirstLastLetter":
                $initial = substr($nameFirst, 0, 1);
                $pin = strtoupper($initial);
                $initial = substr($nameLast, 0, 1);
                $pin += strtoupper($initial);
                break;
            case "XPrefix":
                $pin = "X";
                break;
            case "PinPrefix":
                $pin = $domainConfig["PinPrefix"];
                break;
            case "NoPrefix":
                break;
        }

        $authUser = $this->Auth->user();

        $AgentID = $domainConfig["AgentID"];

        // hereda del agente
        $store = $domainConfig["store"];
        $inetTarget = $domainConfig["inetTarget"];
        $ParlayName = $domainConfig["EntryParlay"];
        $Currency = $domainConfig["Currency"];

        $creationOk = true;
        $profileOk = true;
        $teaserConfig = true;
        $warningMsg = false;
        $msjResult = "";

        $checkUserName = true;
        if ($userName != null) {
            $responseCheckUser = $this->Account->checkUserNameExist(array("agent" => $AgentID, "UserName" => '', 'appid' => 'PreGame', 'userid' => 'public'));
            if ($responseCheckUser != NULL) {
                if (array_key_exists('Exist', $responseCheckUser['row1'])) {
                    $checkUserName = false;
                }
            }
        }


        if ($checkUserName) {
            $resPin = $this->Account->GetNextInetCustomerID(array("CustomerID" => $AgentID, "store" => "Public", "appid" => 'Pregamesite', "userid" => null));
            $pin .= $resPin["row1"]["CustomerID"];
            $EntryTeaser = array("Basketball-4½ pts", "Basketball-4 pts", "", "", "", "", "", "", "", "");
            $resp = 0;
            if ($pin != -1) {
                $resp = $this->Account->InsertCustomer(array(
                    "Agent" => $AgentID,
                    "CustomerID" => $pin,
                    "NameLast" => $nameLast,
                    "NameFirst" => $nameFirst,
                    "Address" => $address1 . " " . $address2,
                    "City" => $city,
                    "State" => $state,
                    "Zip" => $zip,
                    "Country" => $country,
                    "EMail" => $email,
                    "HomePhone" => $homePhone,
                    "BusinessPhone" => $businessPhone,
                    "Fax" => $fax,
                    "Password" => $password,
                    "Source" => $source,
                    "ParlayName" => $ParlayName,
                    "InetTarget" => $inetTarget,
                    "Currency" => $Currency,
                    "AgentID" => $AgentID,
                    "OpenedBy" => 'public',
                    //
                    "PromoCode" => $promoCode,
                    "BirthDate" => $BirthYear . "-" . $BirthMonth . "-" . $BirthDay,
                    "SecurityQuestion" => $securityQuestion,
                    "SecurityAnswer" => $securityAnswer,
                    "ReferredBy" => $referredBy,
                    "UserName" => $userName,
                    "appid" => 'Pregamesite',
                    "userid" => null));

                $result = $resp;
                if ((string) $resp != "-1") {

                    $msjResult = "Customer Creation: OK";

                    $resp = $this->Account->InsertCustStoreProfile(array("Customer" => $AgentID, "CustomerID" => $pin, "Store" => $store, "appid" => 'Pregamesite', "userid" => null));
                    $result = $resp;

                    if ((string) $resp != "-1") {
                        foreach ($EntryTeaser as &$teaser) {
                            $resp = $this->Account->InsertCustTeaser(array("Customer" => $AgentID, "CustomerID" => $pin, "Teasername" => &$teaser, "appid" => 'Pregamesite', "userid" => null));
                            if ((string) $resp == "-1") {
                                $warningMsg = false;
                                $warningMsg = true;
                                break;
                            }
                        }
                        //REVISAR AQUI LOS TEASER $result = $resp;
                    } else {
                        $warningMsg = true;
                        $profileOk = false;
                    }
                } else {
                    $msjResult = "Error Creating Customer";
                    $creationOk = false;
                }
            } else {
                $msjResult = "Error getting consecutive number for the customer.";
                $creationOk = false;
            }
        } else {
            $msjResult = "This user name already exists.";
            $creationOk = false;
        }

        $accountAdded = "Your account has been created successfully.&nbsp;Please store login information (account) in ";

        if ($warningMsg) {
            $accountAdded = str_replace("successfully", "with some minor issues", $accountAdded);
            if ($profileOk == false)
                $accountAdded = str_replace("issues", "issues (also please contact customer service make sure they fix your <span style='font-weight:500'>profile and teaser configuration</span>)", $accountAdded);
            else if ($teaserConfig == false)
                $accountAdded = str_replace("issues", "issues (also please contact customer service to make sure they fix your <span style='font-weight:500'>teaser configuration</span>)", $accountAdded);
        }
        $accountAdded .= "a safe place and be sure that no one learns your account or password.&nbsp;";
        $accountAdded .= "Should someone get your password, call customer support immediately to obtain a new one.&nbsp;";


        if ($creationOk == true) {
            $accountInfo = "\n<br/>\n<br/>Username / CustomerID: " + $pin + ".<br/>\n" + "Password: " + $password;

            /* switch ($domainConfig["Cashier"]) {
              case "Mnet":
              $cashierCreation = false;
              $cashierURL = "";
              try {
              $wsCashier = new wsCashierLib();
              $result = $wsCashier->CreateCustomer($nameFirst, $nameLast, $email, $homePhone, $BirthYear . "-" . $BirthMonth . "-" . $BirthDay, $country, $state, $city, $zip, $address1, $address2, $pin, $securityQuestion, $password);
              $resCashier = $result;
              } catch (Exception $e) {
              $resCashier = "Cashier customer Creation failed:" . $e;
              }

              if (strpos($resCashier->CreateCustomerResult, "Customer Inserted") !== false) {
              $msjResult = "<br/><div style='color:green;font-size:18px'>Cashier Account Creation: OK</div><br/>";
              $cashierURL = "<a href='https://cashier.e-webwallets.com/Pages/frmLogin.aspx?CustPIN=" . $pin . "&password=" . $password . "'>Enter to your cashier</a>";
              $cashierCreation = true;

              } else {
              $cashierAccFailedBodyMail = "Hi CS<BR/>\n<BR>\nThis is an automatic generated mail. Please do not reply.<br/><br/>";
              $cashierAccFailedBodyMail .= "ASI CustomerID " . $pin . " failed creating MercadoNet cashier account for the SportsRoom.ag automatic account creation.<br/><br/>Please assist him/her. Here is the customer data as it was sent:<br/><br/>";
              //$cashierAccFailedBodyMail .= queryString.replace(/\&/g,"<br/>").replace(/\=/g, ": ").replace("lname","last name").replace("pwd","Password").replace("address2","Address2");
              $cashierAccFailedBodyMail .= "<br/><br/>You are more than welcome to use the <a href='https://cashier.e-webwallets.com/Pages/frmLogin.aspx'>mercado net portal</a> or their support to solve this issue.<br/><br/>";
              $cashierAccFailedBodyMail .= "Thanks,<br/><br/>" . $this->domain['sendMail'];

              $this->Mail->sendMail(array("to" => $this->domain['emailAlerts'], "from" => $this->domain['sendMailSportsroom'], "client" => "sportsroom", "subject" => 'Customer failed creating cashier account', "message" => $cashierAccFailedBodyMail));

              $cashierURL = "Your cashier account wasn't created. Our staff will contact you shortly to help you out with this.";
              $msjResult = "<br/><div class='errorMessage'>Cashier Account Creation: failed</div><br/>";
              }

              if ($cashierCreation == false)
              $accountAdded = str_replace("successfully", "and still we need to help you with your cashier account", $accountAdded);
              if ($cashierCreation == false && $warningMsg == true) {
              $accountAdded = str_replace("minor issues", "minor issues as well your cashier account was not created. We will contact you shortly to help you with your cashier account", $accountAdded);
              }
              break;
              case "Tag":
              $cashierCreation = false;
              $cashierURL = "";
              try {
              $wsCashierTag = new wsCashierTagLib();
              $view = new View($this, true);
              $result = $wsCashierTag->getSessionId($view, $pin, $password, $nameFirst, $nameLast, $BirthYear . "-" . $BirthMonth . "-" . $BirthDay,
              $address1 . " " . $address2, $city, $zip, ($country == "US" ? $country . "-" . $state : $country . "-UNKNOWN"), $countryCode, "",
              $homePhone, $email, $this->domain['inetTarget'],
              $lan, $this->RequestHandler->getClientIp(),
              env('HTTP_USER_AGENT'),
              $this->domain['inetTarget']);
              $resCashier = $result;
              $sessionId = "1234567890";
              } catch (Exception $e) {
              $resCashier = "Cashier customer Creation failed:" . $e;
              }

              if (!(strpos($resCashier->CreateCustomerResult, "Error") !== false)) {
              $msjResult = "<br/><div style='color:green;font-size:18px'>Cashier Account Creation: OK</div><br/>";
              $cashierURL = "https://globalcashier.com/GlobalCashier/web/index.php?sessionId=" . $sessionId . "&lan=" . $lan . "'>Enter to your cashier</a>";
              $cashierCreation = true;
              } else {
              $cashierAccFailedBodyMail = "Hi CS<BR/>\n<BR>\nThis is an automatic generated mail. Please do not reply.<br/><br/>";
              $cashierAccFailedBodyMail .= "ASI CustomerID " . $pin . " failed creating MercadoNet cashier account for the SportsRoom.ag automatic account creation.<br/><br/>Please assist him/her. Here is the customer data as it was sent:<br/><br/>";
              //$cashierAccFailedBodyMail .= queryString.replace(/\&/g,"<br/>").replace(/\=/g, ": ").replace("lname","last name").replace("pwd","Password").replace("address2","Address2");
              $cashierAccFailedBodyMail .= "<br/><br/>You are more than welcome to use the <a href='https://cashier.e-webwallets.com/Pages/frmLogin.aspx'>mercado net portal</a> or their support to solve this issue.<br/><br/>";
              $cashierAccFailedBodyMail .= "Thanks,<br/><br/>" . $this->domain['sendMail'];

              $this->Mail->sendMail(array("to" => $this->domain['emailAlerts'], "from" => $this->domain['sendMail'], "client" => "sportsroom", "subject" => 'Customer failed creating cashier account', "message" => $cashierAccFailedBodyMail));

              $cashierURL = "Your cashier account wasn't created. Our staff will contact you shortly to help you out with this.";
              $msjResult = "<br/><div class='errorMessage'>Cashier Account Creation: failed</div><br/>";
              }

              if ($cashierCreation == false)
              $accountAdded = str_replace("successfully", "and still we need to help you with your cashier account", $accountAdded);
              if ($cashierCreation == false && $warningMsg == true) {
              $accountAdded = str_replace("minor issues", "minor issues as well your cashier account was not created. We will contact you shortly to help you with your cashier account", $accountAdded);
              }
              die;
              } */

            if ($email != null) {
                
                $bodyMail = $view->element('Email/Html/' . $site . '/register', array('nameFirst' => $nameFirst, 'nameLast' => $nameLast, 'username' => $userName, 'pin' => $pin, 'password' => $password));
                $res = $this->Mail->sendMail(array("to" => $email, "from" => $this->domain['sendMail'], "client" => "Sportsroom", "subject" => 'Welcome to our site', "message" => $bodyMail));
            }
        }
        return new CakeResponse(array('body' => json_encode(array("Result" => ($result != null ? $result : -1), 'msjResult' => $msjResult, 'accountAdded' => $accountAdded, "user" => $pin))));
    }

    /**
     * poslogin() basic functio to login in POS APP
     *
     * @author  Jesus Rodriguez
     * @version 1.0.0
     *
     * @return Object
     *
     * This function is used to validate the credentials of the user for POS APP, this function use the userServices
     */
    public function posLogin() {
        $branchId = $this->domain["BranchID"];
        $this->layout = "ajax";
        $company = $this->domain["company"];
        $anonimAcc = $this->domain["anonimAcc"];
        $username = $this->request->data('user');
        $password = $this->request->data('password');
        $redirect = $this->request->data('redirect');
        $caja = $this->request->data('caja');

        $cashier = $this->CashierSecurity->getCajero(array('company' => trim($company), 'user' => $username, "branchid" => $branchId, 'pass' => md5($password), 'appid' => 'POS', 'userid' => $username));
        $cashier = $cashier['row1'];

        if (!empty($cashier)) {
            
            $res = $this->CashierSecurity->boxVerificationMaintenance(array("company" => $company,
                "boxId" => $caja,
                "branchID" => $branchId,
                "user" => $username,
                "active" => 1,
                "option" => 3,
                "appid" => "",
                "userid" => ""));
            if($res["row1"]["Result"]=="1"){
                $permissions = $this->CashierSecurity->getPermissions(array("company" => $company, "CashierID" => $cashier["CashierID"], "appid" => "", "userid" => ""));
                $response = $this->Account->validateAccount(array("account" => $company, "root" => $company, "appid" => 'POS', "userid" => $company));
                $agent = (isset($response['row1'])) ? $response['row1'] : $response;
                // Agent In Hierarchy
                $responseInJer = $this->Account->isInTheAgentHierarchy(array("agentid" => $agent['Parent'], "account" => $agent['LoginID'], "agentVal" => "Y"));
                $agentInJer = (!empty($responseInJer)) ? trim($responseInJer['row1']['AgentInJer']) : 0;

                // Status
                $responseStatus = $this->Account->getStatusLoad(array("account" => $agent['LoginID'], "session" => $agent['LoginID']));
                $responseStatus = (isset($responseStatus['row1'])) ? $responseStatus['row1'] : $responseStatus;
                $horseStatus = ($responseStatus['HorseActive'] == 'Y') ? true : false;
                $casinoStatus = ($responseStatus['CasinoActive'] == 'Y') ? true : false;
                $sportbookStatus = ($responseStatus['Active'] == 'Y') ? true : false;

//                // Live Status
                $liveBetStatus = false;


                // Access Admin
                $accountType = trim($agent['Type']);
                $accessAdmin = ($accountType === 'M' || $accountType === 'A') ? true : false;


                //REVISAR AQUI SE DEBEN CARGAR LOS DATOS DEL PLAYER CREO
                $fullCustomer = $this->Sportbook->getCustomer($anonimAcc, $company, $anonimAcc);
                $customerData = $this->Account->getAccount(array('account' => $anonimAcc, 'root' => $company, 'session' => 'kris', 'appid' => 'POS', 'userid' => $company));
                $response = $this->Account->getAccountFullInfo(array("account" => $anonimAcc, "session" => $company, "agent" => '', 'appid' => 'pregamesite', 'userid' => $company));
                $customerPersonal = (isset($response['row1'])) ? $response['row1'] : $response;


                $customer = array();
                $customer['FreePlayBalance'] = @$fullCustomer['FreePlayBalance'];
                $customer['name'] = trim($customerPersonal['NameFirst']) . ' ' . trim($customerPersonal['NameLast']);
                $customer['CustomerID'] = @$fullCustomer['CustomerID'];
                $customer['AgentID'] = @$fullCustomer['AgentID'];
                $customer['AvailableBalance'] = @$fullCustomer['Available'];
                $customer['CurrentBalance'] = @$fullCustomer['Current'];
                $customer['PendingWager'] = @$fullCustomer['PendingWager'];
                $customer['FreePlayPendingBalance'] = @$fullCustomer['FreePlayPendingBalance'];
                $customer['CasinoBalance'] = @$fullCustomer['Casino'];
                $customer['BaseballAction'] = @$fullCustomer['BaseballAction'];
                $customer['ParlayMaxBet'] = @$fullCustomer['ParlayMaxBet'];
                $customer['ParlayMaxPayout'] = @$fullCustomer['ParlayMaxPayout'];
                $customer['PriceType'] = @$fullCustomer['PriceType'];
                $customer['PriceType'] = @$fullCustomer['PriceType'];
                
                $customer['parlayInfo'] = $this->Sportbook->getCustomerParlayInfo(trim($this->domain["anonimAcc"]));
                $customer['teasers'] = $this->Sportbook->getCustomerTeasers(trim($this->domain["anonimAcc"]));
                // Variables session Auth

                $login = array('app' => 'pregamesite',
                    'userID' => $anonimAcc,
                    'username' => $username,
                    'root' => $company,
                    'caja' => $caja,
                    'cashierId' => $cashier['CashierID'],
                    'cashierName' => $username,
                    'player' => $anonimAcc,
                    'company' => $company,
                    'currency' => $customerPersonal['Currency'],
                    'db' => trim($agent['DB']),
                    'customerId' => trim($agent['LoginID']),
                    'agentId' => trim($agent['Parent']),
                    'store' => trim($agent['Store']),
                    'live' => trim($agent['Live']),
                    'accountType' => $accountType,
                    'accessAdmin' => $accessAdmin,
                    'agentInJer' => trim($agentInJer),
                    //'customerEmail' => trim($response['EMail']),
                    'inetTarget' => $agentInJer,
                    'liveBetStatus' => $liveBetStatus,
                    'casinoStatus' => $casinoStatus,
                    'horseStatus' => $horseStatus,
                    'sportbookStatus' => $sportbookStatus,
                    'LiveDealer' => true, //$LiveDealer,
                    'LiveCasino' => true, //$LiveCasino,
                    'fullCustomerInfo' => $customer,
                    'userPermissions' => $permissions);
                // Roles
                $customer = trim($agent['LoginID']);
//                $soapLdap_permission = $this->getService('permission');
                $result_permission = $this->Permission->getAgentAdminRoles(array("account" => $customer, "agent" => $customer));
                //Permissions esta Devolviendo Vacio
                $response_permission = json_decode($result_permission->return, true);


                if (!empty($response_permission["results"])) {
                    foreach ($response_permission["results"] as $row) {
                        $permissionName = trim($row['ShortRolName']);
                        $login[$permissionName] = true;
                    }
                }
                // Create session Auth
                $res = $this->Auth->login($login);
                if ($accountType == 'M' || $accountType == 'A') {
                    $hierarchy = $this->Permission->getAgentChatHierarchy(array("account" => $agent['LoginID']));
                    $this->Session->write('hierachyAgent', $hierarchy);
                }
                
                // If the comment
//                $comments = $this->requestAction(array('controller' => 'Comments', 'action' => 'getComment'), array('named' => array('typeCommentsToRetrieve' => 'Receptor')));
                $comments="";
                $company = $this->Auth->user();
                
                $customer = $company["customerId"];
                $agent = $company["agentId"];
                $site = $this->domain['inetTarget'];

                $configurations = $this->configurations();
                setcookie('Language', null, -1, '/');     // temp
                $language = Configure::read('Config.language');
                if (isset($configurations) && sizeof($configurations) > 0) {
                    // Language
                    if (isset($_COOKIE["Language"])) {
                        $language = $_COOKIE["Language"];
                    } else if (isset($configurations['Language'])) {
                        $language = $configurations['Language'];
                    } else {
                        $language = $this->parseLanguage($this->domain['Language']);
                    }
                    setcookie("Language", $language, -1, "/");
                    // LineTypeFormat
                    Configure::write('LineTypeFormat', trim($configurations["LineTypeFormat"]));
                    $this->LineTypeFormat = trim($configurations["LineTypeFormat"]);
                    setcookie("LineTypeFormat", $this->domain['LineTypeFormat'], -1, "/");
                }
                if (!isset($_COOKIE["LineTypeFormat"])) {
                    setcookie("LineTypeFormat", $this->domain['LineTypeFormat'], -1, "/");
                }
                if (!isset($_COOKIE["Language"])) {
                    if (isset($this->domain['Language'])) {
                        $language = $this->parseLanguage($this->domain['Language']);
                    }
                    setcookie("Language", $this->parseLanguage($language), -1, "/");
                }
                // Comments
                if ($comments !== false && !empty($comments)) {
                    foreach ($comments as $comment) {
                        $showComment = true;

                        if (trim($comment[0]) == 'T') {
                            $commentDate = strtotime(explode(" ", trim($comment[4]))[0] . " 23:59:59");
                            $currentTime = time();
                            if ($commentDate < $currentTime) {
                                $showComment = false;
                            }
                        }
                        if ($showComment) {
                            $this->Session->setFlash($comment[1], 'default', array('class' => $comment[2]), $comment[0]);
                        }
                    }
                    return $this->redirect(array('action' => 'showComments', $accountType));
                }

                if ($accountType === 'M' || $accountType === 'A') {
                    return $this->redirect(Router::url("/" . 'DashboardAdmin', true));
                }
                //redireccionar dependiendo del lugar donde hizo el login,el origen del mismo
                if ($redirect != null) {
                    return $this->redirect(Router::url("/" . $redirect, true));
                } else {
                    return $this->redirect(Router::url("/" . 'Sportbook', true));
                }
            } else {
                return $this->redirect($this->Auth->logout());
            }
        }else{
            $this->deactivateBox();
            
        }
    }

    public function checkUserNameExist() {
        $this->autoRender = false;
        $agentID = $this->domain['AgentID'];
        $userName = trim($this->request->data('username'));
        $res = false;

        if (!empty($userName)) {
            $response = $this->Account->checkUserNameExist(array("agent" => $agentID, "UserName" => $userName, 'appid' => 'PreGame', 'userid' => 'public'));
            if (array_key_exists('Exist', $response['row1'])) {
                $res = true;
            }
        }
        return new CakeResponse(array('body' => json_encode($res)));
    }

    public function verifyUserLogin() {
        $this->autoRender = false;
        $agentID = $this->domain['AgentID'];
        $userName = trim($this->request->data('userName'));
        $response = null;

        if (!empty($userName)) {
            $response = $this->Account->verifyUserLogin(array("agent" => $agentID, "Login" => null, "UserName" => $userName, 'appid' => 'PreGame', 'userid' => 'kris'));
        }
        return new CakeResponse(array('body' => json_encode($response)));
    }


    /*
     * Validate the user enter and verify that it is in the hierarchy
     *
     * @return Object : 1 if valid, 0 if not valid
     */

    public function logout() {
        $this->Auth->logout();

        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                unset($_COOKIE[$name]);
            }
        }

        return $this->redirect($this->Auth->logout());
    }

    /**
     * Render view page unauthorized
     * Pregamesite
     */
    public function unauthorized() {

        $current_page = $this->Session->read('current_page');
        if (empty($current_page)) {
            $current_page = array('controller' => '/', 'action' => null);
        }
        $this->set('current_page', $current_page);
        $this->layout = 'login';
        $this->render('unauthorized');
    }

    /**
     * Displays a view
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    /*
     * Get data session auth
     */

    public function getSessionAuth() {
        return $this->Auth->user();
    }

     /**
     * link to Race
     */
    public function racebook() {
        $this->layout = 'pages_layout';
        $userLog = $this->Auth->user();
        $customer = @$_POST['CustomerID'];
        $agentId = $userLog['agentId'];
        $responseValidateAccount = $this->Account->validateAccount(array("account" => $customer, 'root' => $agentId, 'appid' => 'pregamesite', 'userid' => $customer));
        $password = trim($responseValidateAccount['row1']['Password']);
        $horseStatus = $userLog['horseStatus'];
        $url = array();
        $url['mobile'] = 'http://horses.wager-info.com/BOSSWagering/Racebook/MobileBetTaker/Default.aspx?SiteID=IDSRacebook&SBUserName=' . $customer . '&SBPassword=' . $password . '&loginUrl=http://livebetting.in-play.ag&sportsUrl=http://livebetting.in-play.ag';
        $url['desktop'] = 'http://horses.wager-info.com/BOSSWagering/Racebook/InternetWagering/?siteID=IDSRacebook&SBUserName=' . $customer . '&SBPassword=' . $password;
        $this->set('url', $url);
        $this->set('usersAuth', $userLog);
        $this->set('userhorse',  @$_POST['CustomerID']);
        
        //$this->unauthorized();
    }

    
    public function boxVerificationMaintenance() {
        $branchId = $this->domain["BranchID"];
        $company = $this->domain["company"];
        $user = $this->Auth->user();
        $boxId = isset($_POST["boxId"])?$_POST["boxId"]:$user["caja"];
        $username = isset($user["username"])?$user["username"]:@$_POST["username"];
        $active = @$_POST["active"];
        $option = @$_POST["option"];
        $response = $this->CashierSecurity->boxVerificationMaintenance(array("company" => $company,
            "boxId" => $boxId,
            "branchID" => $branchId,
            "user" => $username,
            "active" => $active,
            "option" => $option,
            "appid" => "",
            "userid" => ""));
        return new CakeResponse(array('body' => json_encode($response)));
    }

    public function deactivateBox($msg="") {
        $branchId = $this->domain["BranchID"];
        $company = $this->domain["company"];
        $user = $this->Auth->user();
        $response = $this->CashierSecurity->boxVerificationMaintenance(array("company" => $company,
            "boxId" => $user["caja"],
            "branchID" => $branchId,
            "user" => $user["username"],
            "active" => 0,
            "option" => 3,
            "appid" => "",
            "userid" => ""));
        $this->set("mensaje",$msg);
        $this->logout();
    }

    
}
