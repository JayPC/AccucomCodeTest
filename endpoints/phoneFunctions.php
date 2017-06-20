<?php
	function clean_input($data) {
		$data = trim($data);
		//$data = stripslashes($data);
		//$data = htmlspecialchars($data);
		return $data;
	}

	function getBasicPhoneXML($phoneNumberParts){
		$requestURL = "http://www.infopay.com/phptest_phone_xml.php?username=accucomtest&password=test104&areacode=$phoneNumberParts[area]&phone=$phoneNumberParts[phone]";
		$xml = file_get_contents($requestURL);
		$xmlParsed = simplexml_load_string($xml);
		//Error handling would go here. Need to know what I'm looking for here. Need API Docs.

		if(!empty($xmlParsed->stats->rows) && $xmlParsed->stats->rows == 1){
			//only one row
			//wrap a single record in an array so that we can assume the records value is an array
			return ["recordCount" => $xmlParsed->stats->rows, "records" => [$xmlParsed->record]];
		} else if(!empty($xmlParsed->stats->rows) && $xmlParsed->stats->rows > 1){
			//multiple rows
			//No need to wrap multiple rows in an array, it's already an array
			return ["recordCount" => $xmlParsed->stats->rows, "records" => $xmlParsed->record];
		} else {
			//no rows
			return ["recordCount" => $xmlParsed->stats->rows, null];
		}
		//echo print_r($xmlParsed, 1);
		//print_r(htmlentities($xml), 0);
	}

	function parseUSPhoneNumber($phoneNumber){
		//this strip all non digits
		$input = preg_replace('/\D/', '', $phoneNumber);
		$areaCode;
		$phone;
		//if it's not 10 or 11 in length we have an issue
		if(strlen($input) == 11){
			$areaCode = substr($input, 1,3);
			$phone = substr($input, 4,7);
			return ["area" => $areaCode, "phone" => $phone];
		} else if(strlen($input) == 10){
			$areaCode = substr($input, 0,3);
			$phone = substr($input, 3,7);
			return ["area" => $areaCode, "phone" => $phone];
			//(123)123-1234
		}
		return false;
	}

	function requestBasicPhoneData($server, $get){
		if ($server["REQUEST_METHOD"] == "GET") {
			if (empty($get["phone"])) {
			} else {
				$phoneNumber = clean_input($get["phone"]);
				// check if name only contains letters and whitespace
				//this should match an american phone number.
				$phoneParts = parseUSPhoneNumber($phoneNumber);
				if($phoneParts !== false && !empty($phoneParts['area']) && !empty($phoneParts['phone'])){
					return getBasicPhoneXML($phoneParts);

				} else {
					return json_encode(["error" => "Phone Number is Invalid. Please make sure to enter a 10 or 11 digit valid phone number including area code"]);
				}
			}
		} else {
			return json_encode(["error" => "Method must be POST"]);
		}
	}