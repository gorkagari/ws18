<?php
include 'segurtasuna.php';
if($sesioMota == 'notLogged'){
	echo "<script type='text/javascript'>
				window.location.href = './layoutNotLogged.php';
			</script>";
	   die();
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Quizzes</title>
    <link rel='stylesheet' type='text/css' href='../styles/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../styles/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../styles/smartphone.css' />
	<style>
		a:hover{
			color: red;
		}
	</style>
	
  </head>
  <?php include 'dbkonfiguratu.php';
		$esteka = mysqli_connect($zerbitzaria, $erabiltzailea, $gakoa, $db);
		// ("localhost", "root", "", “proba");
		if (!$esteka){
			echo "Hutsegitea MySQLra konetatzerakoan";
			echo "errno depurazio akatsa: " .mysqli_connect_errno().PHP_EOL;
			echo "error depurazio akatsa: " .mysqli_connect_error().PHP_EOL;
			exit;
		}else{
			$eskaera = "SELECT * FROM user WHERE email='$email'";
			$result = $esteka->query($eskaera);
			$row = $result->fetch_assoc();
			$deitura = $row["deitura"];
			$irudia_code64 = $row["argazkia"];
			$irudia_erakutsi = '<img src="data:image/jpeg;base64,'. $irudia_code64 .'" width="30" height="30" />';
		}
		mysqli_close($esteka);
	?>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
      <span class="right" ><h4><?php echo $deitura;?> - </h4><?php echo $irudia_erakutsi ?><a href="./layoutnotlogged.php">LogOut</a> </span>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<?php
		echo "<span><a href='layout.php'>Home</a></span>";
		echo "<span><a href='/quizzes'>Quizzes</a></span>";
		if($email != 'admin000@ehu.eus'){
			echo "<span><a href='./handlingQuizesAJAX.php?email=<?php echo $email ?>'>Galdera berria sortu</a></span>";
		}
		else{
			echo "<span><a href='./handlingAccounts.php'>Erabiltzaileak kudeatu</a></span>";
		}
		echo "<span><a href='./credits.php'>Credits</a></span>";
		?>
	</nav>
    <section class="main" id="s1">
    
	
	<div>
	Quizzes and credits will be displayed in this spot in future laboratories ...
	</div>
    </section>
	<footer class='main' id='f1'>
		 <a href='https://github.com/gorkagari'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>
