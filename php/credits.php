<?php
include 'segurtasuna.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<title> CREDITS </title>
		<style>
		img{
			display: block;
			margin-left: auto;
			margin-right: auto;
		}
		</style>
	</head>
	<?php
		if($sesioMota=='logged' || $sesioMota=='admin'){
			$link = "./layout.php";
		}else{
			$link = "./layoutnotlogged.php";
		}
	?>
	<body style="background-color:powderblue">
		<?php
			if (isset($_SESSION['email'])){
				echo "<div style='text-align: right'>";
					echo"<span> Erabiltzailea:"; echo $_SESSION['email'];echo"        </span>";
				echo "</div>";
			}
		?>
			<h2 style="text-align:center"> Egileak: </h2>
			<p style="text-align:center"> Gorka Garitazelaia</p>
			<img src="..\images\Gorila.jpg"  width="150" height="100" alt="Gorka" class="center">
			<p style="text-align:center"> Bizilekua: Donosti </p><br>
			<div style="text-align:right">
				<a  href="<?php echo $link ?>"> Menura itzuli </a>
			</div>
			<p style="text-align:center"> Josu Losañez </p><br>
			<img src="..\images\platanoak.jpg" width="150" height="100" alt="Josu" class="center"><br>
			<p style="text-align:center"> Bizilekua: Donosti </p><br>
			<h2 style="text-align:center"> Espezialitatea: </h2>
			<p style="text-align:center"> Software Ingenieritza</p>
			
	</body>
</html>
