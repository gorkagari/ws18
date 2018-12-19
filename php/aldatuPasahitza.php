<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title> Pasahitza aldatu </title>
		<style>
			form{
				text-align: center;
			}
		</style>
	</head>
	
	<body>
		<h2 style="text-align:center">Pasahitza aldatu</h2><br>
		<form action="./aldatuPasahitza.php?email=<?php echo $_GET['email'] ?>" method="POST">
			<fieldset>
				Pasahitza berria(*): <input type="password" name="passBe"><br><br>
				Pasahitza berria errepikatu(*): <input type="password" name="passBe2"><br><br>
				Kodea(*): <input type="text" name="kodea"><br><br>
				<input type="submit" value="Aldatu"><input type="reset" value="Hutsitu">
			</fieldset>
		</form>
		<div style="text-align:center">
			<a  href="./layoutnotlogged.php"> Menura itzuli</a>
		</div>
	</body>

	<?php 
	
		function konprobatuParametroak(){
			$denaOndo = true;
			if (strlen($_POST['passBe']) == 0||strlen($_POST['passBe2']) == 0||strlen($_POST['kodea']) == 0){
				$denaOndo=false;
				echo "Beharrezko atalak (*) bete itzazu. <br>";
			}else{
				if (strlen($_POST['passBe']) < 8 ){
					$denaOndo=false;
					echo "Pasahitza berriak gutxienez 8 digitu izan behar ditu. <br>";
				}
				if (!($_POST['passBe'] === $_POST['passBe2'])){
					$denaOndo=false;
					echo "Pasahitzak ez dira berdinak.<br>";
				}
				if ($_POST['kodea'] < 10000 || $_POST['kodea'] >99999){
					$denaOndo=false;
					echo "Kodea 10000 eta 99999 arteko osokoa da.<br>";
				}
			}
			return $denaOndo;
		}
		
		function konprobatuPasahitza(){
			require_once('../lib/nusoap.php');
			require_once('../lib/class.wsdlcache.php');
			$ondo= false;
			$soapclient = new nusoap_client('https://gariweb.000webhostapp.com/azkenEntrega/php/egiaztatuPasahitza.php?wsdl','true');
			$result = $soapclient->call('egiaztatu',array('x'=>$_POST['passBe'],'y'=>1010));
			
			/*echo '<h2>Request</h2><pre>'.htmlspecialchars($soapclient->request, ENT_QUOTES).'</pre>';
			echo '<h2>Response</h2><pre>'.htmlspecialchars($soapclient->response,ENT_QUOTES).'</pre>';
			echo '<h2>Debug</h2>';
			echo '<pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';*/
			
			if ($result=="BALIOZKOA"){
				$ondo= true;
			}elseif($result=="BALIOGABEA"){
				echo "Pentsatu pasahitz konplexuago bat. Hori sinpleegia da.<br>";
			}elseif($result=="ZERBITZURIK GABE"){
				echo "Autentifikazio errorea";
			}else{
				echo "Fatal-error, result-en balioa:";
				echo $result;
			}
			
			return $ondo;
		}
		
		function konprobatuKodea(){
			$ondo = true;
			if($_SESSION['kodea'] != $_POST['kodea']){
				$ondo = false;
				echo "Kodea EZ da zuzena. <br>";
			}
			return $ondo;
		}
		
		function redirect(){
		   echo "<script type='text/javascript'>
					window.location.href = './layoutnotlogged.php';
				</script>";
		   die();
		}
	
		include 'dbkonfiguratu.php';
		if (isset($_POST['passBe'])){
			if(konprobatuParametroak()){
				if(konprobatuKodea() && konprobatuPasahitza()){
				
						$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
						// ("localhost", "root", "", “proba");
						if (!$esteka){
							echo "Hutsegitea MySQLra konetatzerakoan";
							echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
							echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
							exit;
						}else{
							$hashed_password = password_hash($_POST['passBe'], PASSWORD_DEFAULT);
							$eskaera = "UPDATE user SET pasahitza='$hashed_password' WHERE email='$_GET[email]'";
							
							if (mysqli_query($esteka, $eskaera)){
								echo "<script>alert('Pasahitza egikaritu da!')</script>";
								redirect();
							}else{
								echo "Errorea pasahitza egikaritzean.";
								
							}
						}
						mysqli_close($esteka);
				}
			}
		}	
	?>
	
</html>