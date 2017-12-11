<?php

/******************************************************************************/
/* Class wsCashierLib 														  */
/*																			  */
/* Description: cashier clientApi soap interface in php to handle request to  */
/*              mercadoNet client API to use the deposit cashier              */
/*              service                                                       */
/* Author: Christian Barrantes Miranda										  */
/* Created: 2016-07-05														  */
/* Last Modified: 2016-07-05												  */
/******************************************************************************/

class wsCashierLib {
	//var $apiURL = 'https://cashier.e-webwallets.com/API/WSLogin.asmx?wsdl';
	var $apiURL = "http://bmmnetweb01.bminc.eu/API/WSDeposit.asmx?wsdl";
	var $wsclient;
    var $CustLogin = "";
    var $Password = "";
    var $Name = "";
    var $LastName = "";
    var $SecondLastName = "";
    var $Phone = "";
    var $Email = "";
    var $City = "";
    var $Address1 = "";
    var $ZipCode = "";
    var $dateBirth = ""; // YYYY-MM-dd
    var $Country = ""; // ISO 3166
    var $State = "";
    var $CurrencyCode = "USD";
    var $AffiliateCode = "";
    var $SSN = "9999";
    var $CreditCardNumber = "";
    var $ExpirationYear = "";
    var $ExpirationMonth = "";
    var $CVV = "";
    var $CreditCardHolder = "";
    var $Amount = "";
    var $STTransactionID = "";
    var $terminalID = "";
    var $entryMode = "";
    var $track1 = "";
    var $track2 = "";
    var $keyLabel = "";
    var $securityCodeEntry = "";
    var $securityValidationResponse = "";
    var $GW_APIUsername = "";
    var $GW_APIPassword = "";

	function __construct() {
		try {
			ini_set('soap.wsdl_cache_enabled',0);
			ini_set('soap.wsdl_cache_ttl',0);
			$this->wsclient = new SoapClient($this->apiURL, array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));
		} catch (SoapFault $exception) {
    		echo  "Error creating web service $exception";
		}
	}

	private function setCustomerID($customerID) {
		$this->CustLogin = $customerID;
	}

	public function getCustomerID() {
		return $this->CustLogin;
	}

	private function setBirthDate($BirthDate) {
		$timezone = new DateTimeZone("UTC");
		$this->BirthDate = new DateTime($BirthDate,$timezone);
	}

	public function getBirthDate() {
		return $this->BirthDate->format("Y-m-d\TH:i:s");
	}

	public function CreateDepositFull($CustLogin,$Password,$Name,$LastName,$SecondLastName,$Phone,$Email,$City,$Address1,$ZipCode,$dateBirth,$Country,$State,$CreditCardNumber,$ExpirationYear,$ExpirationMonth,$CVV,$CreditCardHolder,$Amount,$STTransactionID) {
		$result = false;
		$this->setBirthDate($dateBirth);
		$this->setCustomerID($CustLogin);
		
		$this->CustLogin = $CustLogin;
        $this->Password = $Password;
        $this->Name = $Name;
        $this->LastName = $LastName;
        $this->SecondLastName = $SecondLastName;
        $this->Phone = $Phone;
        $this->Email = $Email;
        $this->City = $City;
        $this->Address1 = $Address1;
        $this->ZipCode = $ZipCode;
        $this->dateBirth = $dateBirth;
        $this->Country = $Country;
        $this->State = $State;
        $this->CreditCardNumber = $CreditCardNumber;
        $this->ExpirationYear = $ExpirationYear;
        $this->ExpirationMonth = $ExpirationMonth;
        $this->CVV = $CVV;
        $this->CreditCardHolder = $CreditCardHolder;
        $this->Amount = $Amount;
        $this->STTransactionID = $STTransactionID;
		
		try {
			$result = $this->wsclient->Deposit(array(
                "CustLogin" => $CustLogin,
                "Password" => $Password,
                "Name" => $Name,
                "LastName" => $LastName,
                "SecondLastName" => $SecondLastName,
                "Phone" => $Phone,
                "Email" => $Email,
                "City" => $City,
                "Address1" => $Address1,
                "ZipCode" => $ZipCode,
                "dateBirth" => $dateBirth,
                "Country" => $Country,
                "State" => $State,
                "CurrencyCode" => $this->CurrencyCode,
                "AffiliateCode" => $this->AffiliateCode,
                "SSN" => $this->SSN,
                "CreditCardNumber" => $CreditCardNumber,
                "ExpirationYear" => $ExpirationYear,
                "ExpirationMonth" => $ExpirationMonth,
                "CVV" => $CVV,
                "CreditCardHolder" => $CreditCardHolder,
                "Amount" => $Amount,
                "STTransactionID" => $STTransactionID,
                "terminalID" => $this->terminalID,
                "entryMode" => $this->entryMode,
                "track1" => $this->track1,
                "track2" => $this->track2,
                "keyLabel" => $this->keyLabel,
                "securityCodeEntry" => $this->securityCodeEntry,
                "securityValidationResponse" => $this->securityValidationResponse,
                "GW_APIUsername" => $this->GW_APIUsername,
                "GW_APIPassword" => $this->GW_APIPassword
			));
		} catch (SoapFault $exception) {
    		echo "Exception creating customer: ";
    		echo "$exception";
			die();

		} catch (Exception $e) {
			echo "Excepition in call: ";
			echo ("$e");
			die();
		}
		return $result;
	}
}

?>