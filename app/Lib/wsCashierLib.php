<?php

/******************************************************************************/
/* Class wsCashierLib 														  */
/*																			  */
/* Description: cashier clientApi soap interface in php to handle request to  */
/*              mercadoNet client API to authenticate use the cashier service */
/* Author: Gustavo Ramirez Siles											  */
/* Created: 2016-07-05														  */
/* Last Modified: 2016-07-05												  */
/******************************************************************************/

class wsCashierLib {
	//var $apiURL = 'https://cashier.e-webwallets.com/API/WSLogin.asmx?wsdl';
	var $apiURL = "http://bmmnetweb01.bminc.eu/API/WSLogin.asmx?wsdl";
	var $wsclient;
	var $InstanceID = 1;
	var $Name="";
	var $SecondLastName = "";
	var $LastName="";
	var $SSN = "9999";
	var $Email = "";
	var $CurrencyCode = "USD";
	var $IdentTypeID = 400340; // 400320 Passport / 400330 Driver's Licence / 400340 Unknown
	var $IdentNumber = "1";
	var $phone="";
	var $BirthDate="";  // YYYY-MM-dd
	var $countryCode=""; // ISO 3166
	var $StateCode="";
	var $City="";
	var $ZipCode="";
	var $Address1="";
	var $Address2="";
	var $CustomerID=""; // AKA login
	var $Hint="";
	var $Password="";
	var $bookID = "";
	var $skinID = "1";

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
		$this->customerID = $customerID;
	}

	public function getCustomerID() {
		return $this->customerID;
	}

	private function setBirthDate($BirthDate) {
		$timezone = new DateTimeZone("UTC");
		$this->BirthDate = new DateTime($BirthDate,$timezone);
	}

	public function getBirthDate() {
		return $this->BirthDate->format("Y-m-d\TH:i:s");
	}

	public function CreateCustomer($name,$lname,$email,$phone,$BirthDate,$countryCode,$StateCode,$City,$ZipCode,$Address1,$Address2,$CustomerID,$Hint,$password) {
		$result = false;
		$this->setBirthDate($BirthDate);
		$this->setCustomerID($CustomerID);
		
		$this->name = $name;
		$this->LastName = $lname;
		$this->Email = $email;
		$this->phone = $phone;
		$this->countryCode = $countryCode;
		$this->StateCode = $StateCode;
		$this->City = $City;
		$this->ZipCode = $ZipCode;
		$this->Address1 = $Address1;
		$this->Address2 = $Address2;
		$this->Hint = $Hint;
		$this->Password = $password;
		$this->CustomerID= $CustomerID;
		
		try {
			$result = $this->wsclient->CreateCustomer(array(
				"InstanceID" =>$this->InstanceID,
				"Name" =>$name,
				"LastName" =>$lname,
				"SecondLastName" =>$this->SecondLastName,
				"SSN" =>$this->SSN,
				"Email" =>$email,
				"CurrencyCode" =>$this->CurrencyCode,
				"IdentTypeID" =>$this->IdentTypeID,
				"IdentNumber" =>$this->IdentNumber,
				"Phone" =>$phone,
				"BirthDate" => $BirthDate,
				"CountryCode" =>$countryCode,
				"StateCode" =>$StateCode,
				"City" =>$City,
				"ZipCode" =>$ZipCode,
				"Address1" =>$Address1,
				"Address2" =>$Address2,
				"Login" =>$CustomerID,
				"PasswordHint" =>$Hint,
				"Password" =>$password,
				"bookID" =>$this->bookID,
				"SkinId" =>$this->skinID
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