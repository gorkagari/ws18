<?php http://localhost/wsgg/layoutnotlogged.html
	//nusoap.php klasea gehitzen dugu
	require_once('../lib/nusoap.php');
	require_once('../lib/class.wsdlcache.php');
	//soap_server motako objektua sortzen dugu
	//$ns="http://localhost/wsgg/egiaztatuPasahitza.php?wsdl";
	$ns="http://localhost/wsgg/php/egiaztatuPasahitza.php?wsdl";
	$server = new soap_server;
	$server->configureWSDL('egiaztatu',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;
	//inplementatu nahi dugun funtzioa erregistratzen dugu
	//funtzio bat baino gehiago erregistra liteke …
	$server->register('egiaztatu',array('x'=>'xsd:string', 'y'=>'xsd:int'),array('z'=>'xsd:string'),$ns);
	//funtzioa inplementatzen da
	function egiaztatu($x, $y){
		if($y == 1010){
			$ezAurkitua = true;
			$file = fopen("../toppasswords.txt", "r");
			while(! feof($file)){
				$line = fgets($file);
				if ($x == trim($line)){
					return "BALIOGABEA";
				}
			}
			fclose($file);
			return "BALIOZKOA";
		}else{
			return "ZERBITZURIK GABE";
		}
	}
	//nusoap klaseko service metodoari dei egiten diogu, behin parametroak
	// prestatuta daudela
	if (!isset( $HTTP_RAW_POST_DATA )) {
		$HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
	}
	$server->service($HTTP_RAW_POST_DATA);
?>