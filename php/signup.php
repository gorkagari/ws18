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
		
		<script type='text/javascript'> 
		
		var erabiltzaileZuzena = false;
		var pasahitzaZuzena = false;
		
		xhro = new XMLHttpRequest();
		xhro.onreadystatechange = function(){
			if (xhro.readyState==4){
				var emaitza = xhro.responseText.trim();
				if (emaitza=="ONDO"){
					document.getElementById("divErab").innerHTML= "Erabiltzailea hori matrikulaturik dago, zuzena da.";
					erabiltzaileZuzena = true;
				}else{
					document.getElementById("divErab").innerHTML= "Erabiltzaile hori ez dago matrikulatuta, ez da egokia.";
					erabiltzaileZuzena = false;
				}
			}
		}
		
		xhro2 = new XMLHttpRequest();
		xhro2.onreadystatechange = function(){
			if (xhro2.readyState==4){
				var emaitza = xhro2.responseText.trim();
				if (emaitza=="ONDO"){
					document.getElementById("divPas").innerHTML= "Pasahitza egokia. (8 karaktere gutxienez)";
					pasahitzaZuzena = true;
				}else if(emaitza=="GAIZKI"){
					document.getElementById("divPas").innerHTML= "Pasahitza hau arruntegia da, probatu beste batekin. (8 karaktere gutxienez)";
					pasahitzaZuzena = false;
				}else{
					document.getElementById("divPas").innerHTML= "Zerbitzu errorea.";
					pasahitzaZuzena = false;
				}
			}
		}
		
		setInterval(setPHP,1000);
		setInterval(setPHP2,1000)
		
		
		
		$(document).ready(function(){
			$("form").submit(function(){
				ondo=false;
				
				if(konprobatuParametroak() && erabiltzaileZuzena){
					ondo = true;
				}
				return ondo;
			});
		});
		
		
		
		function  konprobatuParametroak(){
							
							var email = $("#email").val()
							var deitura = $("#deitura").val()
							var pasahitza = $("#pasahitza").val()
							var pasahitza2 = $("#pasahitza2").val()
							var denaOndo = true;
							if (email.length == 0||deitura.length == 0|| pasahitza.length == 0||pasahitza2.length == 0){
								alert("(*) ikurra duten atalak nahitaez bete behar dira!");
								denaOndo=false;
							}else{
							if (pasahitza!=pasahitza2){
								alert("Pasahitzak ez dira berdinak.");
								denaOndo=false;
							}
							
							if(pasahitza.length < 8){
								denaOndo=false;
								alert("Pasahitzak gutxienez 8 digitu izan behar ditu.");
							}
							
							//DEITURA-A KONPROBATU
							if(!(/([A-Z]{1}[a-z]+\s)([A-Z]{1}[a-z]+(\s)?)+$/).test(deitura)){
								denaOndo=false;
								alert("Deiturako izenak hizki larriz hasi behar dira eta hutsuneak izan behar dituzte haien artean.");
							}
							
							//EMAIL-A KONPROBATU
							if(!(/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/).test(email)){
								denaOndo=false;
								alert("email-a ez da egokia, patroia: xxxxxnnn@ikasle.ehu.eus, non xxxxx=letrak eta nnn=hiru zenbaki");
							}
							}
							return denaOndo;
		}
		
	
		function setPHP(){
			var email = $("#email").val()
			if (email){
				xhro.open("GET", "egiaztatuErabiltzaileaErregistroan.php?email="+email, true);
				xhro.send();
			}else{
					document.getElementById("divErab").innerHTML= "";
			}
		}
		
		function setPHP2(){
			var pasahitza = $("#pasahitza").val()
			if (pasahitza){
				xhro2.open("GET", "egiaztatuPasahitzaErregistroan.php?pasahitza="+pasahitza, true);
				xhro2.send();
			}else{
					document.getElementById("divPas").innerHTML= "";
			}
		}
		
		
		
		</script>
	</head>
	
	<body>
		<form id="signupF" name="signupF" method="post" action="./signup.php" enctype="multipart/form-data">
			<fieldset>
				Email(*): <input type="text" name="email" id="email"><div id="divErab"></div><br><br><br>
				Deitura(*): <input type="text" name="deitura" id="deitura"><br><br>
				Pasahitza(*): <input type="password" name="pasahitza" id="pasahitza"><div id="divPas"></div><br><br>
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
		
		
		
		function konprobatuErabiltzailea(){
			require_once('../lib/nusoap.php');
			require_once('../lib/class.wsdlcache.php');
			$ondo= false;
			$soapclient = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl','true');
			$result = $soapclient->call('egiaztatuE',array('x'=>$_POST['email']));
			
			if ($result=='BAI'){
				$ondo= true;
			}
			else{
				echo "Ez da ehu-ko erabiltzaile bat.";}
			
			return $ondo;
			
			
		}

		function konprobatuPasahitza(){
			require_once('../lib/nusoap.php');
			require_once('../lib/class.wsdlcache.php');
			$ondo= false;
			$soapclient = new nusoap_client('http://localhost/wsgg/php/egiaztatuPasahitza.php?wsdl','true');
			$result = $soapclient->call('egiaztatu',array('x'=>$_POST['pasahitza'],'y'=>1010));
			
			/*echo '<h2>Request</h2><pre>'.htmlspecialchars($soapclient->request, ENT_QUOTES).'</pre>';
			echo '<h2>Response</h2><pre>'.htmlspecialchars($soapclient->response,ENT_QUOTES).'</pre>';
			echo '<h2>Debug</h2>';
			echo '<pre>' . htmlspecialchars($soapclient->debug_str, ENT_QUOTES) . '</pre>';*/
			
			if ($result=="BALIOZKOA"){
				$ondo= true;
			}elseif($result=="BALIOGABEA"){
				echo "Pentsatu pasahitz konplexuago bat. Hori sinpleegia da.";
			}elseif($result=="ZERBITZURIK GABE"){
				echo "Autentifikazio errorea";
			}else{
				echo "Fatal-error, result-en balioa:";
				echo $result;
			}
			
			return $ondo;
		}
		
		if (isset($_POST['email'])){
			if(konprobatuParametroak()){
				if(konprobatuErabiltzailea() && konprobatuPasahitza()){
				
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
				}
			}else{
				echo " Parametro ez egokiak jaso dira.";
			}
		}
	?>

</html>