<!DOCTYPE html>

<html>
<head>
	<title> MySQL konexioa </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php //include dbkonfiguratu.php
		$esteka = mysqli_connect(“localhost”, “root", "jlgg", “quiz");
		// ("localhost", "root", "", “proba");
		if (!$esteka){
			echo “Hutsegitea MySQLra konetatzerakoan. “ .” . PHP_EOL;
			echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
			echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
			exit;
		}else{
			var id = mysql_query($esteka, "SELECT COUNT(*) FROM questions" )
			id++;
			$sql = mysqli_query($esteka, "INSERT INTO questions(id,email,galdera,okerra1,okerra2,okerra3,zailtasuna,gaia) VALUES (".id.",".$_POST['email'].",".$_POST['galdera'].",".$_POST['okerra1'].",".$_POST['okerra2'].",".$_POST['okerra3'].",".$_POST['zailtasuna'].",".$_POST['gaia'].")")
		}
		
		
		// Konexioa itxi
		mysqli_close($esteka);
	?>
</head>
<body>
	<h1> MySQL </h1>
	
</body>
</html>