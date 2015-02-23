<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Warehouse API 1.3 : request ID cancel</title>
</head>
<body>

<?php
	include_once("SimpleRestClient.class.php");
	$error = false; 
	$done = false;
	$requestID="";
	$RSID="";
	
	/*Check if request parameter exist*/
	if(isset($_GET['requestID']) && isset($_GET['RSID'])){
		echo "The Data Warehouse request ID is: " .$_GET['requestID']. "<br/>";
		echo "The report suite ID is: " .$_GET['RSID']. "<br/>";
		$requestID = $_GET['requestID'];
		$RSID= $_GET['RSID'];
	}
	
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
	
	if(!empty($requestID) || !empty($RSID)){
	
		/*Build you REST requests. For example of requests go to API explorer : https://marketing.adobe.com/developer/api-explorer*/
		
		/*Check documentation*/
		
		/**********************/
		/*CANCEL a DW request*/
		/**********************/
		
		$method="DataWarehouse.CancelRequest";
		
		/*EXAMPLE request*/
		/*
		{
			"Request_Id":"2714208"
		}
		*/
		$data='{
			"Request_Id":"'.$requestID.'"
		}';

		$rc=GetAPIData($method, $data);

		if ($rc->getStatusCode()==200) {
			$response=$rc->getWebResponse();
			$json=json_decode($response);
			if (strpos($response, "errors") !== true) {
				echo "The Data Warehouse request has been cancelled successfully";
			}
			else {
				$error=true;
				echo "The Data Warehouse request has not been successfully cancelled- <br/>";
				echo "Details of the issue <br/>";
				echo $response;
			}
		} else {
			$error=true;
			echo "something went really wrong <br />";
			var_dump($rc->getInfo());
			echo "\n".$rc->getWebResponse();
		}
	}else{
		echo "<p>There is no Data Warehouse ID specified or RSID specified</p>";
	}

?>

</body>
</html>