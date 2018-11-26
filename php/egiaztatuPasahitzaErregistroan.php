<?php
	require_once('../lib/nusoap.php');
			require_once('../lib/class.wsdlcache.php');
			$soapclient = new nusoap_client('http://localhost/wsgg/php/egiaztatuPasahitza.php?wsdl','true');
			$result = $soapclient->call('egiaztatu',array('x'=>$_GET['pasahitza'],'y'=>1010));
			
			/*echo '<h2>Request</h2><pre>'.htmlspecialchars($soapclient->request, ENT_QUOTES).'</pre>';
			echo '<h2>Response</h2><pre>'.htmlspecialchars($soapclient->response,ENT_QUOTES).'</pre>';
			echo '<h2>Debug</h2>';
			echo '<pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';*/
			
			if ($result=="BALIOZKOA"){
				$ondo= "ONDO";
			}elseif($result=="BALIOGABEA"){
				$ondo= "GAIZKI";
			}elseif($result=="ZERBITZURIK GABE"){
				$ondo= "ZERBITZU GABE";
			}
			
			echo $ondo;
	?>

