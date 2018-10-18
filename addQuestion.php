<!DOCTYPE html>

<html>
<head>
	<title> MySQL konexioa </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
</head>
<body>
	<?php include 'dbkonfiguratu.php';
		$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
		// ("localhost", "root", "", “proba");
		if (!$esteka){
			echo "Hutsegitea MySQLra konetatzerakoan";
			echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
			echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
			$p_text = 'Errore bat egon da';
			exit;
		}else{
			$sql = mysqli_query($esteka, "INSERT INTO questions(email,galdera,okerra1,okerra2,okerra3,zailtasuna,gaia) VALUES (".$_REQUEST['email'].",".$_REQUEST['galdera'].",".$_REQUEST['okerra1'].",".$_REQUEST['okerra2'].",".$_REQUEST['okerra3'].",".$_REQUEST['zailtasuna'].",".$_REQUEST['gaia'].")");
			    
		}
		if($sql){
		    $p_text = 'Ondo joan da';
		}else{
		    $p_text = 'Errore bat egon da';
		}
		$dom = new DOMDocument('1.0', 'utf-8');
        $h = $dom->createElement('h2', $p_text);//Create new <p> tag with text
        $dom->appendChild($h);//Add the p tag to document
        echo $dom->saveXML();
		// Konexioa itxi
		mysqli_close($esteka);
	
		
	?>
	
	<div id=d> </div>
	<div id=links>
			<a  href="./datubase.php"> Datu basea ikusi </a><br></br>
			<a  href="./addQuestion.html"> Galdera berri bat sartu </a><br></br>
			<a  href="./layout.html"> Itzuli menura </a>
	</div>
</body>
</html>