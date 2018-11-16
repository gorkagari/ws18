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
	<?php
		$email = $_GET['email'];
		$xml = simplexml_load_file('../questions.xml') or die("Error: Cannot create object");
		echo '<table>';
		echo '<tr><th>Egilea</th><th>Enuntziatua</th><th>Erantzun zuzena</th></tr>';
		
		foreach($xml->children() as $assessmentItem){
				$egilea = $assessmentItem['author'];
				if($email == $egilea){
					$itemBody = $assessmentItem -> itemBody;
					
					$correctResponse = $assessmentItem -> correctResponse;
					
					echo "
						<tr>
							<td>".$egilea."</td>
							<td>".$itemBody->p."</td>
							<td>".$correctResponse->value."</td>
					";
				}
		}
		echo '</table>';
	?>

