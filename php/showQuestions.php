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
			$sql = "SELECT email, galdera, zuzena, okerra1, okerra2, okerra3, zailtasuna, gaia FROM questions";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "<br> Email: ". $row["email"]. " - Galdera: ". $row["galdera"]. " - Zuzena: ". $row["zuzena"]. " - Okerra1: ". $row["okerra1"]. " - Okerra2: ". $row["okerra2"]. " - Okerra3: ". $row["okerra3"]. " - Zailtasuna: ". $row["zailtasuna"]. " - Gaia: ". $row["gaia"] . "<br>";
				}
			} else {
				echo "0 results";
			}
    
		}
		// Konexioa itxi
		mysqli_close($esteka);	
	?>
			<a  href="../layout.html"> Itzuli menura </a>
	</div>
</body>
</html>

