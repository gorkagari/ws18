<?php include 'dbkonfiguratu.php';
		function konprobatuParametroak(){
				$denaOndo = true;
				//EMAIL-A KONPROBATU
				$pattern = '/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/';
				if(!(preg_match($pattern,$_POST['email']))){
					$denaOndo=false;
					echo "Email ez egokia.";
				}
				return $denaOndo;
		}
		
		if (konprobatuParametroak()){
			$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
			// ("localhost", "root", "", “proba");
			if (!$esteka){
				echo "Hutsegitea MySQLra konetatzerakoan";
				echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
				echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
				exit;
			}else{
				$eskaera = "SELECT * FROM user WHERE email='$_POST[email]'";
				$result = $esteka->query($eskaera);
				if($result->num_rows == 0){
					echo "Erabiltzaile hori ez dago erregistratuta.";
				}else{
					$eskaera = "SELECT * FROM user WHERE email='$_POST[email]'";
					$result = $esteka->query($eskaera);
					$row = $result->fetch_assoc();
					if($row["egoera"]){
						$ego=0;
					}
					else{
						$ego=1;
					}
					
					$eskaera = "UPDATE user SET egoera=$ego WHERE email='$_POST[email]'";
					$result = $esteka->query($eskaera);
					if($result){
						echo "Erabiltzailearen egoera aldatu da.";
					}
				}
			}
			mysqli_close($esteka);
		}
	?>