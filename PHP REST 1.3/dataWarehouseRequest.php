<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Warehouse API 1.3 : send a DW request</title>
</head>
<body>

<?php
	include_once("SimpleRestClient.class.php");
	$error = false; 
	$done = false;
	
	function GetAPIData($method, $data) {
		/*$username = '[WEB SERVICES USERNAME]'; 
		$secret = '[WEB SERVICES PASSWORD]';
		Both can be found under ADMIN >> COMPANY SETTINGS >> WEB SERVICES (only users with web services right will be listed in the table)
		
		*/
		$username = '[WEB SERVICES USERNAME]';
		$secret = '[WEB SERVICES PASSWORD]';
		$nonce = md5(uniqid(php_uname('n'), true));
		$nonce_ts = date('c');
		$digest = base64_encode(sha1($nonce.$nonce_ts.$secret));
		/*$server possible values :
			api.omniture.com - San Jose
			api2.omniture.com - Dallas
			api3.omniture.com - London
			api4.omniture.com - Singapore
			api5.omniture.com - Pacific Northwest
		*/
		$server = "https://api.omniture.com";
		$path = "/admin/1.3/rest/";

		$rc=new SimpleRestClient();
		$rc->setOption(CURLOPT_HTTPHEADER, array("X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$digest\", Nonce=\"$nonce\", Created=\"$nonce_ts\""));

		$rc->postWebRequest($server.$path.'?method='.$method, $data);

		return $rc;
	}
	
	
	
	/*Build you REST requests. For example of requests go to API explorer : https://marketing.adobe.com/developer/api-explorer*/
	
	/*Check documentation*/
	
	/**********************/
	/*Request a DW request*/
	/**********************/
	
	$method="DataWarehouse.Request";
	
	/*EXAMPLE request*/
	/*
	$data='{
		"Breakdown_List":[
			"page"
		],
		"Contact_Name":"Alexis Cazes",
		"Date_From":"02/01/15",
		"Date_Granularity":"none",
		"Date_To":"02/11/15",
		"Date_Type":"range",
		"Email_Subject":"Test1 DW API",
		"Email_To":"acazes@adobe.com",
		"Metric_List":[
			"page_views"
		],
		"Report_Name":"TEST1",
		"rsid":"edirocks",
		"Contact_Phone":"01234567891"
	},;
	*/
	$data='{
		"Breakdown_List":[
			"page"
		],
		"Contact_Name":"Alexis Cazes",
		"Date_From":"02/01/15",
		"Date_Granularity":"none",
		"Date_To":"02/11/15",
		"Date_Type":"range",
		"Email_Subject":"Test2 DW API",
		"Email_To":"acazes@adobe.com",
		"Metric_List":[
			"page_views"
		],
		"Report_Name":"TEST2",
		"rsid":"edirocks",
		"Contact_Phone":"01234567891"
	}';
	
	$dataJSON = json_decode($data);

	$rc=GetAPIData($method, $data);

	if ($rc->getStatusCode()==200) {
		$response=$rc->getWebResponse();
		$json=json_decode($response);
		if (strpos($response, "errors") !== true) {
			echo "The Data Warehouse request has been submitted. The Data Warehouse request ID is: <br/>";
			echo $response. "<br/>";
			$cancel = "window.location.href='dataWarehouseRequestCancel.php?requestID=" .$response. "&RSID=".$dataJSON->rsid."'";
			echo "<script>function goToURL(){path=".$cancel."}</script>";
?>
<button onclick="goToURL()">Cancel request</button>
<?php
		}
		else {
			$error=true;
			echo "The Data Warehouse request has not been successful- <br/>";
			echo "Details of the issue <br/>";
			echo $response;
		}
	} else {
		$error=true;
		echo "something went really wrong <br />";
		var_dump($rc->getInfo());
		echo "\n".$rc->getWebResponse();
	}


?>

<?php
	if(!$error){
		$checker = "window.location.href='dataWarehouseRequestChecker.php?requestID=" .$response. "&RSID=".$dataJSON->rsid."'";
		echo "<script>function goToURLChecker(){pathChecker=".$checker."}</script>";
?>
		<button onclick="goToURLChecker()">Go to Data Warehouse status checker</button>
<?php
	}
?>


</body>
</html>