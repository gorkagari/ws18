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
			$p_text = 'Errore bat egon da konexioarekin.';
			exit;
		}else{
			$p_text = 'Konexioa ezartzen...';
			$katea = "INSERT INTO questions(email,galdera,zuzena,okerra1,okerra2,okerra3,zailtasuna,gaia) VALUES ('$_POST[email]','$_POST[galdera]','$_POST[zuzena]','$_POST[okerra1]','$_POST[okerra2]','$_POST[okerra3]','$_POST[zailtasuna]','$_POST[gaia]')";
			$sql = mysqli_query($esteka, $katea);
			    
		}
		if($sql){
		    $j_text = 'Ondo joan da.';
		}else{
		    $j_text = 'Errore bat egon da datuak igotzerakoan.';
		}
		$dom = new DOMDocument('1.0', 'utf-8');
        $h = $dom->createElement('h2', $p_text);//Create new <p> tag with text
        $dom->appendChild($h);//Add the p tag to document
		$j = $dom->createElement('h2', $j_text);//Create new <p> tag with text
        $dom->appendChild($j);//Add the p tag to document
        echo $dom->saveXML();
		// Konexioa itxi
		mysqli_close($esteka);
	
		
	?>
	
	<div id=links>
			<a  href="./showQuestions.php"> Datu basea ikusi </a><br></br>
			<a  href="../addQuestion.html"> Galdera berri bat sartu </a><br></br>
			<a  href="../layout.html"> Itzuli menura </a>
	</div>
</body>
</html>