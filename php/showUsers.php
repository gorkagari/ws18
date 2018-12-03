	<?php
			echo "<style> 
					table, th, td {
						border: 1px solid black;
						padding: 2px;
					}
					table {
						border-spacing: 2px;
					}
				</style>";
				
		?>
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
			$sql = "SELECT email, deitura, pasahitza,egoera,argazkia FROM user";
			$result = $esteka->query($sql);

			if ($result->num_rows > 0) {
			// output data of each row
				echo '<table>';
				echo '<tr><th>Email</th><th>Deitura</th><th>Pasahitza</th><th>Egoera</th><th>Argazkia</th></tr>';
			
				while($row = $result->fetch_assoc()) {
					$code_base64 = $row["argazkia"];
					
					$ego= "Ezgaituta";
					if($row["egoera"]){
						$ego= "Aktiboa";
					}
					
					echo "
						<tr>
							<td>". $row["email"]."</td>
							<td>". $row["deitura"]."</td>
							<td>". $row["pasahitza"]."</td>
							<td>". $ego ."</td>
							<td>".'<img src="data:image/jpeg;base64,'. $code_base64 .'" width="20" height="20"/>'."</td>
						</tr>
					";
					//echo "<br>". $row["email"]. " -Deitura: ". $row["deitura"]. " - Pasahitza: ". $row["pasahitza"];
					//echo "argazkia:";
					//echo '<img src="data:image/jpeg;base64,'. $code_base64 .'" width="50" height="50"/>';echo "<br>";
				}
				echo '</table>';
			} else {
				echo "0 results";
			}
    
		}
		// Konexioa itxi
		mysqli_close($esteka);	
	?>
	


