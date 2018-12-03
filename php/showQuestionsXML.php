<?php
include 'segurtasuna.php';
if($sesioMota == 'notLogged'){
	session_destroy();
	echo "<script type='text/javascript'>
					window.location.href = '../layoutNotLogged.html';
				</script>";
		   die();
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Show Questions XML</title>
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
	</head>
	<body>
			
		<a href="./layout.php">Menura itzuli</a>
	</body>
	<?php
		$xml = simplexml_load_file('../questions.xml') or die("Error: Cannot create object");
		echo '<table>';
		echo '<tr><th>Egilea</th><th>Enuntziatua</th><th>Erantzun zuzena</th></tr>';
		
		foreach($xml->children() as $assessmentItem){
				$egilea = $assessmentItem['author'];
				
				$itemBody = $assessmentItem -> itemBody;
				
				$correctResponse = $assessmentItem -> correctResponse;
				
				echo "
					<tr>
						<td>".$egilea."</td>
						<td>".$itemBody->p."</td>
						<td>".$correctResponse->value."</td>
				";
		}
		echo '</table>';
	?>

</html>