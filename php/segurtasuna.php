<?php
session_start();
if(!isset($_SESSION['email'])){
	$sesioMota = 'notLogged';
}elseif($_SESSION['email']=='admin000@ehu.eus'){
	$sesioMota = 'admin';
}else{
	include 'dbkonfiguratu.php';
	$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
						 // ("localhost" , "root"        , ""    , “proba");
	if (!$esteka){
		echo "Hutsegitea MySQLra konetatzerakoan";
		echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
		echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
		exit;
	}else{
		$eskaera = "SELECT * FROM user WHERE email='$_SESSION[email]'";
		$result = $esteka->query($eskaera);
		if($result->num_rows == 0){
			$sesioMota = 'notLogged';
		}else{
			$sesioMota = 'logged';
		}
	}
	mysqli_close($esteka);
}
?>