<?php  
	include 'segurtasuna.php';
	if($sesioMota == 'notLogged'){
		echo "<script type='text/javascript'>
					window.location.href = './layoutNotLogged.php';
				</script>";
		   die();
	}elseif($sesioMota == 'logged'){
		echo "<script type='text/javascript'>
					window.location.href = './layout.php';
				</script>";
		   die();
	}
	header("Control-cache: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Erabiltzaileen kudeaketa </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script language="javascript">
				
				function  konprobatuDena(){
							var email = $("#email").val()
							var denaOndo = true;
							//Erabaki digu administratzaile bat ezin dula beste admin bat ezabatu
							if((/^([a-z]{2,50})([0-9]{3}).ehu\.eus$/).test(email)){
								denaOndo=false;
								alert("Administratzailea ezin da eraldatu");
							}
							else{					
								if(!(/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/).test(email)){
									denaOndo=false;
									alert("email-a ez da egokia, patroia: xxxxxnnn@ikasle.ehu.eus, non xxxxx=letrak eta nnn=hiru zenbaki");
								}
							}
							return denaOndo;
							
				}

				xhro = new XMLHttpRequest();
				xhro.onreadystatechange = function(){
					if (xhro.readyState==4){
						
						document.getElementById("usrIkusi").innerHTML= xhro.responseText;
					}
				}
				
				
				function ikusi(){
					xhro.open("GET","showUsers.php", true);
					xhro.send(null);
				}
				
				function ezabatu(){
					if(konprobatuDena()){
						var dataString = $('#erabiltzileF').serialize();
						 $.ajax({
							type: "POST",
							url: "deleteUser.php",
							data: dataString,
							success: function(data) {
									document.getElementById("usrThings").innerHTML=data;
									$('#erabiltzileF').trigger("reset");
									ikusi();
							}
						});
					}
				}
				
				function permutatu(){
					if(konprobatuDena()){
						var dataString = $('#erabiltzileF').serialize();
						 $.ajax({
							type: "POST",
							url: "alterUser.php",
							data: dataString,
							success: function(data) {
									document.getElementById("usrThings").innerHTML=data;
									$('#erabiltzileF').trigger("reset");
									ikusi();
							}
						});
					}
				}
			
		</script>
		
		<style>
			#output_image
			{
			 max-width:300px;
			}
			a:hover{
				color: red;
			}
		</style>
	</head>
	
	<body>
		<form id="erabiltzileF" name="erabiltzileF" method="post" action="./addQuestionn.php?email=<?php echo $email; ?>" enctype="multipart/form-data">
			<fieldset>
				
				<input type="button" value="Erabiltzaileak ikusi" onclick="ikusi()"> <p> Aukeratu erabiltzailea eta egin nahi dena: </p> <br>
				
				Email(*): <input type="text" name="email" id="email"></div> <input type="reset" value="Reset">  <br><br>
				
				<input type="button" value="Egoera permutatu" onclick="permutatu()">
				<input type="button" value="Ezabatu" onclick="ezabatu()"><br> 
				
			</fieldset>
		</form>
		
		<div style="text-align:center">
			<a  href="./layout.php"> Menura itzuli </a>
		</div><br>
		<div id="usrThings" style="text-align:center">
		</div><br>
		<div id="usrIkusi" style="text-align:center">
		</div><br>
		
		
		
		
		
		
		
	</body>
	

</html>
