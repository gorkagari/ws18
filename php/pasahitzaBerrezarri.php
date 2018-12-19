<?php
	session_start();
	if(isset($_SESSION['email'])){
		echo "<script type='text/javascript'>
					window.location.href = './layout.php';
				</script>";
		   die();
	}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title> Pasahitza berrezarri </title>
		<style>
			form{
				text-align: center;
			}
		</style>
	</head>
	
	<body>
		<h2 style="text-align:center">Pasahitza berrezarpena</h2><br>
		<form action="./pasahitzaBerrezarri.php" method="POST">
			<fieldset>
				Berreskurapen email-a: <input type="text" name="email">
				<input type="submit" value="Bidali"><input type="reset" value="Hutsitu">
			</fieldset>
			Emandako posta elektroniko helbidera email bat bidaliko da, pasahitza berreskuratzeko baliabideak esleituz.
		</form>
		
		<div style="text-align:center">
			<a  href="./layoutnotlogged.php"> Menura itzuli</a>
		</div>
	</body>
	
	<?php
		
		include 'dbkonfiguratu.php';
		$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
		function emailEgokia(){
			$pattern = '/^[a-z0-9](\.?[a-z0-9]){5,}@g(oogle)?mail\.com$/';
			if(!(preg_match($pattern,$_POST['email']))){
				$denaOndo=false;
				echo "Email-ak xxxxxnnn@ikasle.ehu.eus patroia jarraitu behar du (xxxxx= letrak, nnn = hiru zifra)";
				return false;
			}
			return true;
		}
	
		if(isset($_POST['email'])){
			if(emailEgokia()){
				$sql = "SELECT * FROM user WHERE email = '$_POST[email]'";
				$result = mysqli_query($esteka,$sql);
				
				if($result){
						$row = mysqli_fetch_row($result);
						
						if($row[0]==$_POST['email']){
							//email jasotzailea
							$nori = $_POST['email'];
							
							//mezuaren gaia
							$gaia = "Pasahitza berreskurapena";
							
							//Kodea
							$kodea = rand(10000,99999);
							
							//Errekuperaketarako sesioaren balioak
							$_SESSION['kodea'] = $kodea;
							$_SESSION['email'] = $_POST['email'];
							
							//Mezua
							$mezua = "
							<html>
								<head>
									<title> Pasahitza berreskuratu </title>
								</head>
								
								<body>
									<h3> Pasahitza berreskuratzeko pausuak: </h3>
									<ol>
										<li>Egin click emandako link-ean.</li>
										<li>Sartu emandako kodea eta pasahitza berria.</li>
										<li>Web orrialdeak pasahitza berrezari duzula adieraziko dizu.</li>
									</ol>
									<h3> Berreskurapen orrirako link-a: </h3>
									<h2><a href='https://gariweb.000webhostapp.com/azkenEntrega/php/aldatuPasahitza.php?email=".$_POST['email']."'>Klik hemen</a></h2>
									<h3> Berreskurapen kodea: </h3>
									<h2>".$kodea."</h2>
								</body>
							</html>
							";
							
							//Eduki mota
							$headers = "MIME-Version: 1.0"."\r\n";
							$headers .= "Content-type:text/html:charset=UTF-8"."\r\n";
							
							//Mezua bidaltzeko
							mail($nori, $gaia, $mezua, $headers);
							
							echo "<script>alert('Mezua zuzen bidali da')</script>";
						
		
						}else{
							echo "Email-a ez da zuzena.";
						}
				}
			}
		}
	?>
	
</html>

