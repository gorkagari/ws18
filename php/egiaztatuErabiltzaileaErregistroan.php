<?php
	require_once('../lib/nusoap.php');
	require_once('../lib/class.wsdlcache.php');
	$soapclient = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl','true');
	$result = $soapclient->call('egiaztatuE',array('x'=>$_GET['email']));
			
	if ($result=='BAI'){
		$ondo= "ONDO";
	}
	else{
		$ondo= "GAIZKI";
		}
			
	echo $ondo;
	
	?>

