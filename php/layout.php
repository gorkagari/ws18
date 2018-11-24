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
			$eskaera = "SELECT * FROM user WHERE email='$_GET[email]'";
			$result = $esteka->query($eskaera);
			$row = $result->fetch_assoc();
			$deitura = $row["deitura"];
			$irudia_code64 = $row["argazkia"];
			$irudia_erakutsi = '<img src="data:image/jpeg;base64,'. $irudia_code64 .'" width="30" height="30" />';
		}
		mysqli_close($esteka);
		$email = $_GET['email'];
	?>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
      <span class="right" ><h4><?php echo $deitura;?> - </h4><?php echo $irudia_erakutsi ?><a href="../layoutnotlogged.html">LogOut</a> </span>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layout.php?email=<?php echo $email ?>'>Home</a></span>
		<span><a href='/quizzes'>Quizzes</a></span>
		<span><a href='./handlingQuizesAJAX.php?email=<?php echo $email ?>'>Galdera berria sortu</a></span>
		<span><a href='./getQuestionWZ.php?email=<?php echo $email ?>'>Galdera IDz bilatu</a></span>
		<span><a href='./showQuestionsWithImages.php?email=<?php echo $email ?>'>Datu basea ikusi</a></span>
		<span><a href='../questions.xml'>Questions XML (.xml)</a></span>
		<span><a href='./showQuestionsXML.php?email=<?php echo $email ?>'>Show Questions XML (PHP)</a></span>
		<span><a href='./credits.php?email=<?php echo $email ?>'>Credits</a></span>
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
