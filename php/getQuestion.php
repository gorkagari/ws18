<?php include 'dbkonfiguratu.php';
	//nusoap.php klasea gehitzen dugu
	require_once('../lib/nusoap.php');
	require_once('../lib/class.wsdlcache.php');
	//soap_server motako objektua sortzen dugu
	$ns="./getQuestion.php?wsdl";
	$server = new soap_server;
	$server->configureWSDL('idQuestion',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;
	//inplementatu nahi dugun funtzioa erregistratzen dugu
	//funtzio bat baino gehiago erregistra liteke …
	$server->register('idQuestion',array('x'=>'xsd:int'),array('e'=>'xsd:string','g'=>'xsd:string','z'=>'xsd:string'),$ns);
	//funtzioa inplementatzen da
	function idQuestion($x){
		$z = "BALIOGABEA";
		$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
			// ("localhost", "root", "", “proba");
			if (!$esteka){
				echo "Hutsegitea MySQLra konetatzerakoan";
				echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
				echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
				$p_text = 'Errore bat egon da konexioarekin.';
				exit;
			}else{
				$katea = "SELECT * FROM questions where id=".$x;
				$result = $esteka->query($katea);
				if($result->num_rows!=0){
					
					
				}
		
		
		return $z;
	}
	//nusoap klaseko service metodoari dei egiten diogu, behin parametroak
	// prestatuta daudela
	if (!isset( $HTTP_RAW_POST_DATA )) {
		$HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
	}
	$server->service($HTTP_RAW_POST_DATA);
?>