<?php
/******************************************************************************/
/* Class wsCashierTagLib 													  */
/*																			  */
/* Description: cashier clientApi soap interface in php to handle request to  */
/*              mercadoNet client API to authenticate use the cashier service */
/* Author: Gustavo Ramirez Siles											  */
/* Created: 2016-07-05														  */
/* Last Modified: 2016-07-05												  */
/******************************************************************************/

App::import('Vendor', 'nusoap', array('file' => 'nusoap'.DS.'nusoap.php'));

class wsCashierTagLib {
	var $apiURL = "https://globalcashier.com/GlobalCashierWebService/WebServices/widgetWS.php";
	var $wsclient;
	var $lstPublicKey = array("5E4C31C6-CDA2-4692-8873-CF4F41671C37",
							  "C9CD720F-E38F-453C-AB38-83E5F1785F75",
							  "30506D06-2C8B-4E81-B450-C4405F2510C9",
							  "F6116EFE-5472-41D3-962D-04B3CC7A7C33",
							  "70EF723F-9DD6-4AB1-92CE-8E926551031B",
							  "F17D3E11-22DB-427D-B99C-A80DC37A0BB1",
							  "A09B7440-3E0D-4515-8A3F-AA42B8F7CBBC",
							  "AD7A364E-8B68-4C50-814A-071871725698",
							  "754AE565-0F77-42CA-B303-D6AECD09B790",
							  "7C0DD8BE-002E-459C-8A14-B7885D142FDC",
							  "C0092757-1F59-4231-9E30-5B51F94E5D91",
							  "43371D63-57C5-4698-BDDB-BACC3E38C358",
							  "6CF95F36-9650-475C-AC40-C6142EB84684",
							  "59CC424E-ADF5-42D6-8A52-ABCFE20FDC86",
							  "46020A28-B55C-4ED4-A709-C04C7DB01EE5",
							  "5D7EDA7C-EE81-4210-A057-0DB2802862DB",
							  "36DD350B-E412-4966-A1CC-DE0B1552598C",
							  "5F1722AC-9C2D-462F-9C36-723436B18E2B",
							  "D8EB928D-08C3-4D78-AC19-D57FDB1B861A",
							  "246D7553-16B1-41F1-9387-C7148372CCE9");
	
	var $lstPrivateKey = array("85EDD9B4-9E6C-453D-93B7-2A4332D200C6C7A5BE4B-0F67-4DB4-A164-7FA75C1938038D322AB2-A046-46A5-A5A0-5443E67111C6A7A63055-BC0B-4A2D-9D14-FD88DA120494E133CC32-9329-48DB-AEC3-8C921F8B999EA0FB8972-6935-4CE2-9722-18C52092E31F4A3367B5-36C2-4ED8-A742-3509BF6C5204A90BD90A-A418-4117-8D88-B83D609A037F4B051071-E261-44A9-81F2-ED2785D2E02406074E16-D7C7-4BF2-B45C-706EC0AEC867",
							   "08D29861-6EBC-4614-B732-A972798393B4F21A0516-2B0F-4FB3-A895-504440FE81CC057B94EB-9D70-4DFB-AFE7-58C71EB8D706FDF0A3F8-3D7C-4A04-A23A-A6034041B1F304318042-A818-4A65-B67D-CC2FDC2DA30364C4A703-1004-4362-8A14-40274131E51AFC5C8163-3AC0-4FE1-A481-888F02AD6AEC0406A135-D618-4259-B844-384E00853019E5D2FA6E-CB58-4A73-9CA0-7A89C65CA23787F5FBA4-B0EF-43E6-A00D-55AC35A377E0",
							   "C57B9FC2-4111-40E3-802B-3882D0B18060C76DDADF-8AC5-4481-8253-7E0E617420B8920CFDD6-157A-41BC-BAEA-752D4476226826EEDA8C-73E3-4306-95F3-2769A3221CD09928E8B6-3A13-4B13-A855-141D9A8D5FD17DFE570F-C45C-45F7-8136-F9CA26015AF46AB61599-04EC-4387-8A66-F2F9BE18811825BC68BA-912F-422C-9BB8-AF2C00CE42A202F87CB1-9FBF-4AA1-9644-89E59CF57C2F7416E139-E597-493F-8704-BC6067BBBB94",
							   "1D6E218F-357D-4305-B0EB-50524ADD81522D1C9ECC-C745-407B-B91D-2D068F0EB374D125EC9B-5313-483E-B755-A8B3910A16BAD06A3915-C4CF-493C-9B93-0B5076979D14FD12F963-86F7-4B01-A411-0C1E0C85ED1DC1544107-2595-4F03-AF33-5E37AFAC700A371FEB1E-7EB3-4727-9EE5-0BE3701F4167EF4DD8F3-F02D-4BB5-B16A-26D920E61F788A872784-BA97-42CF-A5CD-B8F4911607BCF674D929-08CB-4EE7-A9CA-A83E5DC0B42C",
							   "27CE7704-B5EF-4A53-A0CE-F90183464EB00E8F2129-8DB5-438C-9FC2-740F5CFA8A387FF55BB3-D06D-45E8-B5BC-41F0DCD6CC992E1F5A66-1FE1-437F-86AA-1F5E2ECDD2ED0F0B38CD-CD9B-4A13-948D-DC182B632F1E398914B4-BB56-4963-99DA-02A390C5559CD7100A18-A183-433F-8626-3928814128D929701752-5CE9-4496-9AB4-DFD77921BFC2FE88E152-F950-4548-B84F-6E7E1E7E7CA87BF7B383-B3B1-4CBD-B489-CEEB6B7C4548",
							   "0209608E-8243-408A-9F88-06E61DC2F7F5FE2EF9DC-E13A-4702-BBB4-C7BB1D7C161DCF3F649A-AAF1-4A68-AF5E-28E9CEC9E438262973DD-D168-40F3-92A7-2B982ADA1A309D5045D4-1E4E-41E1-B8B7-6A4D3C92685A0663F351-7EDC-4260-B958-A0EA5332533D15C06694-715A-4DA2-B497-00AED01F502C01175A1A-6264-42F4-8FD1-33A0085BF39B76B2EC02-A31D-494A-BE0C-9CA525B004052D418751-A411-450F-9D0E-DCCCEB349806",
							   "13D89037-8A75-44E5-9610-32C59A491D49B2C2BCB8-5E08-4FB8-8A3A-DFFF2DBDBA316DE4E457-11B6-4E45-BDC6-6ED336B7964393A1559A-FA63-4963-A59C-1B4CB03C2FEF41212EE7-D8A3-4666-A57A-836CC15CFFDEB361F746-4276-4BC6-99C1-A0761023EDBF365B0650-3550-4A05-888C-D6241D7B243CEFFD42D6-76B7-4910-867D-C5CFA844DB0543D6F3E8-2AED-404E-8449-5998AD50479FB6554662-2629-49F2-8DBF-13AC04EE4079",
							   "EF63E40A-56DB-485A-99E6-A9BE00399BB09AD6D2BE-F01A-47FB-8B41-D36608BD45C1B92C4179-5FF5-41B5-895C-E3E982142BD2EFF22179-97BC-46C0-8C0D-B5B322E267D6C5E6C715-58D0-4DFD-BAB9-73E90BCA05DAEC730AF2-ACAF-4F41-9942-A61A1242DEEA62E7B89D-CC30-4CCA-AEAE-789AF7825C16A8F211E0-8EF2-494A-8E4B-E7F32AD707FDB5DF2E4B-6DB6-401A-AB31-03538A63681F02BCFA62-3382-44A4-870C-1C8D82C4B251",
							   "17A5221E-0FA6-4C31-91EB-04F868A0D113D0A0C07D-3EFA-43F0-AA42-59E9AA369934478584AE-87C6-4F59-88BF-38157BFF4B4BA4917DAF-E412-405E-930A-C3B261FAB504C12EFA39-7285-462C-BBD0-AEAA0BAC167F7903BA65-B5F4-40A8-AB17-F4E5FAE72AEF51693180-089D-4EFF-9A89-62BFBF2C5BEE5FC07815-4C84-432E-B39B-62198389568BD554D09D-A630-4325-9E47-FA6CEBCF355928F50C80-28CC-4D4E-AA57-BA679404A905",
							   "296D0A5C-A311-47E1-8BEE-9615E5700B01F5390305-F1F4-4E8B-B8D8-389A64E38F04A964AE37-6ACD-4320-91D3-05ED1047E035D4DC92BE-CE39-4845-8F72-52C61CD827371E63095F-CB0B-492F-90F9-C7DF0FE4313CE2B4B790-68F8-42C5-BA65-36355A5DCE2DD687C949-5B05-4BB9-B453-46DE02F71289D365FB8A-B3BE-4D6F-B541-FBAF4A7E884CA8BF9F19-D769-4C69-9033-04AF203A437498B1E942-C3C2-49C2-9434-AD3BA1A9484E",
							   "8EA4986E-482C-4B04-860A-228ECA6477D6B37FF7EC-4C1C-41C3-906E-E85907F9B0678712F7E4-0949-4060-9A99-483BFE02043B09E3B8AF-E2C7-4A0B-B973-A8A814CC016CF7364EC7-EB0F-4E2D-8F08-5889B79688E442D8110C-EC8E-4C3D-A0A2-D59F9D154EC717A45EC2-0220-412F-8BA0-320654879C5132D9EDF6-32D7-4A7E-84E5-0FBB979CC62891C3EF60-2477-48C5-A920-D975C68E7575306BA1E8-11FF-4A6C-A770-3F95AAAE8B74",
							   "2E5B15A1-894A-4F20-BAAD-ACAEA6E89091C14D9C00-2771-4E69-A247-806AAD703ED471D82E84-B247-4570-B84B-DCE6705F398FE3894E60-60F5-44B5-9FA4-0980B78FC992884A7AF5-A978-4E83-B546-0B7559E8AF8F8CED1AC7-B533-4CAD-91FF-F31655015D3F047EF3A1-0FC4-47AC-B6EB-438340440DBED9DE6452-B383-4205-9C54-FF106E4CC52DBC319351-1BE1-49BD-97DD-DF975D475315696DBB64-B569-435E-AED7-0DC6DB3C8A36",
							   "E1B37CC1-E508-4D2F-8DDD-423126A721D0BD474A0D-9ECA-467C-AE6A-3D1420264BF9C4CBFDD0-089D-4F55-8BA0-66494DEEFF0D2BAD7D16-A660-49EC-8588-DF2922A25AFC8DFDE6D2-0CBE-4B55-9743-D58EC4B7BB46F6D72949-926A-4589-995A-5BC7113FFFA6EA74B105-4027-47E3-A559-2EF9DC4B96DF77922E50-57C6-43B0-8432-4FEF2703CE3BEDD50636-1FBA-49C2-A53F-09B27FD38498B912039F-C7CD-4619-8F58-DC933D1310B3",
							   "8B21F449-CB95-453D-B7F3-269432F9C8DC9B4C4986-19FE-42F5-99B4-6CEEBA4D3D0196B4EC91-BDBF-4299-8835-E0F06D0326A707DEF75B-A2E4-490A-80ED-E06C5285EBFD8F5C7D6C-6C9F-465D-94C2-C7D571DD98C52788A5FA-A04D-4765-AD6E-89698BD20F9F030DB926-7E03-4FFF-977D-A360D892B9214ACEAC6A-029C-4D91-B7CF-41454FA6127C1481749D-1F2C-4675-A394-0CAF137BDF58AC32F7B4-28C5-4F4C-A266-440433299025",
							   "D8488674-6A2E-4583-B16B-1C936B36FD0FFB0892F5-7918-4C35-B828-10EE6B1BA0F1A0FE71FD-4FCD-4ACE-8F56-D8A407DA5EEF8A855917-A8A9-4A2E-85A1-A0214D41EF91E5F0FAAA-E543-436A-9878-2BEB281D764DE41C4BF2-8D35-454E-B8C2-3FFEED58B8044D39C9E8-EAEE-49D0-B9EC-6B73C190DE7E973F5990-A14C-426E-AFCC-34A6F9C303BF05CE7AD6-FBC3-494E-964E-DED351E12CFA638B9A8D-5F0A-45AA-87F8-1B4C3A6E8E32",
							   "52EA85AA-B41B-414A-9676-71EAE402068853BA54A1-B5CD-4D0A-932C-2103BC14F0D82FA7E6EB-F999-4E52-B7E9-D774A8475C197FBFD665-4F3E-46F5-8B60-3D53E839869C49FCC4C5-CE00-4C73-B8A5-A34C36D4781B0B8F68AE-0A3F-476E-B100-B37AF0DC6A1A55316A2A-551D-4145-876A-F96DCF9ABE57B637D564-5712-40B0-82C9-381688128D1A1EBCA7CF-7270-42F1-9B9E-937B9F9B36D2B09F50AD-A5B4-44FE-BD9E-083D325569E2",
							   "D34CA443-F647-4570-830B-3BCC4BD3D57C4443494F-A8EE-4161-B36A-1D56B4DAFC41C0166531-2D82-4989-9AA7-A8031F06481117ECBB0A-306B-4851-B124-7722F3C04F6BD73BBEC6-7042-46C9-BD09-28C08D96FE2443D4DC67-3541-4A90-BE1F-26707CA26CB86D075104-A9C9-40FF-95C0-FB2BF097763C2F087F82-BCC9-41BA-8E74-2EA705B2FA4DE3A61539-11A3-48E0-8373-B46230AAACF2E92D59FC-543E-4119-9CCD-12C32DF22A73",
							   "7F7A5F00-B58A-4125-B22F-28B6453D579ED54B4B11-EED0-46B2-BC16-ECCACC452480685F9565-5A21-42E8-A585-F2B5A9098E73A834FDDF-FC17-4EA0-AA9F-4510A5481C43C64C7DD4-F61A-4AB1-952B-0DE5291F504F3E2F66FE-C6B5-487C-B779-9DC0F31DFE17B5BE7980-A7F4-4066-AE1B-3D1AFBE8C68D469599DE-A56D-4AEC-BC7B-21A66DBF4A15749C1B7C-93B4-470F-A655-502A00CFD436B0683C1B-0585-42EC-93D6-4516CE2D0A75",
							   "C060EA35-1369-4D3C-BF6C-62753FDE1D567BDC2EC7-290D-48EC-AD13-69B525F83D1E30FFDD3E-BCB3-4803-B80B-0E2694627DED13F6D07A-5EE3-454C-A261-4C53170A09F8F1390825-B5AC-4DDF-8B23-93614A1A4494C30C79DE-E79F-42F9-A5CF-01CA343F98ADBD7030C5-7B29-4AF2-8A25-B5AAAF0C5F12DCF321C0-661A-4D0C-8684-BFF3A57B938AD4B57CAD-AE71-4BED-854E-0025D84C158BA214D8CE-7682-4365-8214-43D49ABE9C50",
							   "0CD95192-916A-4143-9ABE-E8D161E9FA3550E45438-0E75-4F90-BDB2-ABC817C42B182E3ABD03-9DBA-4342-8786-53E6FB38C4B2C57EC4F6-1D95-4F0C-9A5E-F24F9673FEE21CBFE6B2-50CF-4BB8-BF1D-CCD074EC3898491C3ADB-EE07-40C1-9D2C-B4FBA22E18D62087174C-8063-4C5F-B356-E26006FA2F33D7ED4DAE-EC7F-4E83-95DA-333A57E50AB6B9645231-807B-46BC-A966-16BB13ECAB52307E5D15-2D01-47EA-AD23-AECA69C76ED2");
	
	var $merchantId = "E05BABEC-495B-41BF-B55F-57C742EE0F91";
	var $merchantPassword = "4539D8DF-ED62-469D-8DAA-F806170C1111BA9C4E32-4A56-43D6-8C46-F25E766A5FCC";
	var $id = "";
	var $totalAmount = "25";
	var $currency = "USD";
	var $returnURL = "/Sportbook";
	var $accountID = "";
	var $accountPassword = "";
	var $creationDate = "";
	var $brandCustomer = "";
	var $firstName = "";
	var $middleName = "";
	var $lastName = "";
	var $dateOfBirth = "";
	var $adressType = "billing";
	var $streetAddress = "";
	var $cityName = "";
	var $zipPostalCode = "";
	var $stateISOcode = "";
	var $countryCodePhone = "";
	var $areaCodePhone = "";
	var $numberPhone = "";
	var $isPrimaryEmail = "1";
	var $addressEmail = "";
	var $customerIP = "";
	var $httpUserAgent = "";
	var $httpReferer = "";
	var $language = "";
	
	function __construct() {
		try {
			/*ini_set('soap.wsdl_cache_enabled',0);
			ini_set('soap.wsdl_cache_ttl',0);
			$this->wsclient = new SoapClient($this->apiURL, array('trace' => TRUE, 'cache_wsdl' => WSDL_CACHE_NONE));*/
			
			$this->wsclient = new nusoap_client($this->apiURL); //Creates a NuSOAP client to consume the web service
		} catch (SoapFault $exception) {
    		echo  "Error creating web service $exception";
		}
	}

	public function getSessionId($view, $custumerId, $password, $firstName, $lastName, $dateOfBirth, $streetAddress, $cityName, $zipPostalCode, $stateISOcode, $countryCodePhone, $areaCodePhone, $numberPhone, $addressEmail, $inetTarget, $language, $customerIP, $httpUserAgent, $httpReferer){
		$this->id = $custumerId;
		$this->returnURL = $inetTarget."/".$language."/Sportbook";
		$this->accountID = $custumerId;
		$this->accountPassword = $password;
		$this->creationDate = date("Y-m-d h:i:s");
		$this->brandCustomer = $inetTarget;
		$this->firstName = $firstName;
		$this->middleName = "";
		$this->lastName = $lastName;
		$this->dateOfBirth = $dateOfBirth;
		$this->streetAddress = $streetAddress;
		$this->cityName = $cityName;
		$this->zipPostalCode = $zipPostalCode;
		$this->stateISOcode = $stateISOcode;
		$this->countryCodePhone = $countryCodePhone;
		$this->areaCodePhone = $areaCodePhone;
		$this->numberPhone = $numberPhone;
		$this->addressEmail = $addressEmail;
		$this->customerIP = $customerIP;
		$this->httpUserAgent = $httpUserAgent;
		$this->httpReferer = $httpReferer;
		$this->language = $language;
		
		$xml = $view->element('Templates/Cashier/Tag/xml', array(
																"merchantId" => $this->merchantId,
																"merchantPassword" => $this->merchantPassword,
																"accountID" => $this->id,
																"accountPassword" => $this->accountPassword,
																"creationDate" => $this->creationDate,
																"creationIP" => $this->customerIP,
																"brandCustomer" => $this->brandCustomer,
																"firstName" => $this->firstName,
																"middleName" => $this->middleName,
																"lastName" => $this->lastName,
																"dateOfBirth" => $this->dateOfBirth,
																"adressType" => $this->adressType,
																"streetAddress" => $this->streetAddress,
																"cityName" => $this->cityName,
																"zipPostalCode" => $this->zipPostalCode,
																"stateISOcode" => $this->stateISOcode,
																"countryCodePhone" => $this->countryCodePhone,
																"areaCodePhone" => $this->areaCodePhone,
																"numberPhone" => $this->numberPhone,
																"isPrimaryEmail" => $this->isPrimaryEmail,
																"addressEmail" => $this->addressEmail,
																"customerIP" => $this->customerIP,
																"httpUserAgent" => $this->httpUserAgent,
																"httpReferer" => $this->httpReferer,
																"language" => $this->language
																 ));
		$posRand = array_rand($this->lstPublicKey,1);
		$publicKey = $this->lstPublicKey[$posRand];
		$privateKey = $this->lstPrivateKey[$posRand];
		$xmlEncrypt = $this->encrypt($xml, $publicKey);
		try {
			$encryptedResult = $this->wsclient->call("getSessionId", array("xml" => $xmlEncrypt, "publicKey" => $publicKey)); //Calls the web service getSessionId function
			echo $this->testFile("xml", $xml)."<br/><br/>";
			echo $this->testFile("result", $this->decrypt($encryptedResult, $privateKey))."<br/><br/>";
			$result = $this->decrypt($encryptedResult, $privateKey);
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
	
	public function testFile($nameFile, $text){
		$currentPath = getcwd();
		$searchPath = "app/";
		$currentPath = substr ($currentPath, 0, strpos($currentPath, $searchPath)).$searchPath;

		$filename = $currentPath."tmp/".$nameFile.".txt";
		$myfile = fopen($filename, "w") or die("Unable to open file!");
		fwrite($myfile, $text);
		fclose($myfile);
		
		return $filename;
		
	}
	
    /**
     * Returns the encrypted data received as the first argument. This function
     * applies the 3DES encryption algorithm to the data received as the first 
     * argument. The privateKey received as the second argument must be hashed
     * in 256 bits first. Then the first 192 bits must be extracted from 
     * those 256 bits to be used as encryption key since 3DES algorithm used here
     * accepts a key up to 192 bits long.
     * The data argument corresponds to the wanted data to be encrypted.
     * The privateKey argument corresponds to the key used for encryption.
     * 
     * @param  data         a wanted data to be encrypted
     * @param  privateKey   a key used for encryption
     * @return              the encrypted data received as the first argument in binary format.
     */
    public function encrypt($data, $privateKey){
        
        $blockSize = mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data .= str_repeat(chr($pad), $pad);

        $encData = mcrypt_encrypt(MCRYPT_3DES, substr(mhash(MHASH_SHA256, $privateKey), 0, 24), $data, MCRYPT_MODE_ECB);

        return base64_encode($encData);//Encodes the data in binary format and returns it
    }
    
    /**
     * Returns the decrypted data received as the first argument. This function
     * applies the 3DES decryption algorithm to the data received as the first 
     * argument. The privateKey received as the second argument must be hashed
     * in 256 bits first. Then the first 192 bits must be extracted from 
     * those 256 bits to be used as decryption key since 3DES algorithm used here
     * accepts a key up to 192 bits long.
     * The data argument corresponds to the wanted data to be decrypted.
     * The privateKey argument corresponds to the key used for decryption.
     * 
     * @param  data         a wanted data, in binary format, to be decrypted
     * @param  privateKey   a key used for decryption
     * @return              the decrypted data received as the first argument.
     */
    public function decrypt($data, $privateKey){
        $data = base64_decode($data);//Decodes the data received in binary format
        
        $data = mcrypt_decrypt(MCRYPT_3DES, substr(mhash(MHASH_SHA256, $privateKey), 0, 24), $data, MCRYPT_MODE_ECB);
        
        $block = mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $len = strlen($data);
        $pad = ord($data[$len-1]);
        
        return substr($data, 0, strlen($data) - $pad);
    }
}

?>