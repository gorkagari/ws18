<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title> LogIn </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style>
			a:hover{
				color: red;
			}
		</style>
	</head>
	
	<body>
		<form id="erregF" name="erregF" method="post" action="login.php" enctype="multipart/form-data">
			<fieldset>
				Email: <input type="text" name="email" id="email"><br><br><br>
				Pasahitza: <input type="password" name="pasahitza" id="pasahitza"><br><br>
				<input type="reset" value="Reset">   <input type="submit" id="igo" value="LogIn">
				
			</fieldset>
		</form>
		<div style="text-align:left">
			<a  href="./pasahitzaBerrezarri.php">Pasahitza ahaztu duzu?</a>
		</div>
		<div style="text-align:center">
			<a  href="./layoutnotlogged.php"> Menura itzuli</a>
		</div>
	</body>
	
	

</html>
<?php include 'dbkonfiguratu.php';
		function redirectAdmin(){
		   echo "<script type='text/javascript'>
					window.location.href = './handlingAccounts.php';
				</script>";
		   die();
		}
		function redirectUser(){
		   echo "<script type='text/javascript'>
					window.location.href = './handlingQuizesAJAX.php';
				</script>";
		   die();
		}
		if (isset($_POST['email'])){
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
					exit;
				}else{
					$row = $result->fetch_assoc();
<<<<<<< HEAD
					if(!password_verify($_POST['pasahitza'],$row["pasahitza"] )){
=======
					if(!($row["pasahitza"]===$_POST['pasahitza'])){
						
>>>>>>> fc9fe8754034c568542a0d7e029ca05fa834df68
						echo "Pasahitza okerra.";
					}else{
						$_SESSION['email'] = $_POST['email'];
						if($_POST['email']=='admin000@ehu.eus'){
							redirectAdmin();
						}else{
							redirectUser();
						}
					}
				}
			}
			mysqli_close($esteka);
		}
	?>
