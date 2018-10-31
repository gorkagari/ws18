<!DOCTYPE html>
<html>
	<head>
		<title> SignUp </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style>
			a:hover{
				color: red;
			}
		</style>
	</head>
	
	<body>
		<form id="signupF" name="signupF" method="post" action="./signup.php" enctype="multipart/form-data">
			<fieldset>
				Email(*): <input type="text" name="email" id="email"><br><br><br>
				Deitura(*): <input type="text" name="deitura" id="deitura"><br><br>
				Pasahitza(*): <input type="password" name="pasahitza" id="pasahitza"><br><br>
				Pasahitza errepikatu(*): <input type="password" name="pasahitza2" id="pasahitza2"><br><br>
				Argazkia: <input type="file" name="argazkia" id="argazkia" accept="image/*"><br><br>
				<input type="reset" value="Reset">   <input type="submit" id="igo" value="SignUp">
				
			</fieldset>
		</form>
		<div style="text-align:center">
				<a  href="../layoutnotlogged.html"> Menura itzuli</a>
			</div>
	</body>
	
	<?php include 'dbkonfiguratu.php';
		function redirect(){
		   echo "<script type='text/javascript'>
					window.location.href = './login.php';
				</script>";
		   die();
		}
		function konprobatuParametroak(){
			$denaOndo = true;
			if (strlen($_POST['email']) == 0||strlen($_POST['deitura']) == 0||strlen($_POST['pasahitza']) == 0||strlen($_POST['pasahitza2']) == 0){
				$denaOndo=false;
				echo "Beharrezko atalak (*) bete itzazu.";
			}else{
				if (strlen($_POST['pasahitza']) < 8 ){
					$denaOndo=false;
					echo "Pasahitzak gutxienez 8 digitu izan behar ditu.";
				}
				if (!($_POST['pasahitza'] === $_POST['pasahitza2'])){
					$denaOndo=false;
					echo "Pasahitzak ez dira berdinak.";
				}
				//EMAIL-A KONPROBATU
				$pattern = '/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/';
				if(!(preg_match($pattern,$_POST['email']))){
					$denaOndo=false;
					echo "Email-ak xxxxxnnn@ikasle.ehu.eus patroia jarraitu behar du (xxxxx= letrak, nnn = hiru zifra)";
				}
				//DEITURA KONPROBATU
				if(!(preg_match('^([A-Z]{1}[a-z]+\s)([A-Z]{1}[a-z]+(\s)?)+$^',$_POST['deitura']))){
					$denaOndo=false;
					echo "Deiturako izenak hizki larriz hasi behar dira eta hutsuneak izan behar dituzte haien artean.";
				}
			}
			return $denaOndo;
		}
		if (isset($_POST['email'])){
			if(konprobatuParametroak()){
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
					if($result->num_rows!=0){
						echo "Email hori jadanik erregistraturik dago.";
						exit;
					}else{
						$irudia = $_FILES["argazkia"]["tmp_name"];
						if(!$irudia){
							$irudia = "../images/galderaikurra.png";
						}
						$irudia_data = file_get_contents($irudia);
						$encoded_image = base64_encode($irudia_data);
						$katea = "INSERT INTO user VALUES ('$_POST[email]','$_POST[deitura]','$_POST[pasahitza]','$encoded_image')";
						$sql = mysqli_query($esteka, $katea);
					}
					
				}
				if($sql){
					$j_text = 'Erabiltzailea erregistratu da.';
					redirect();
				}else{
					$j_text = 'Errorea egon da. Erabiltzailea ezin izan da erregistratu.';
				}
				$dom = new DOMDocument('1.0', 'utf-8');
				$j = $dom->createElement('h2', $j_text);//Create new <p> tag with text
				$dom->appendChild($j);//Add the p tag to document
				echo $dom->saveXML();
				// Konexioa itxi
				mysqli_close($esteka);
			}else{
				echo " Parametro ez egokiak jaso dira.";
			}
			
		}
	?>

</html>