<?php header("Control-cache: no-store, no-cache, must-revalidate");$email = $_GET['email']; ?>
<!DOCTYPE html>
<html>
	<head>
		<title> Galdera formularioa </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script language="javascript">
			
			
		</script>
		<script type='text/javascript'>
			function preview_image(event) 
			{
				var reader = new FileReader();
				reader.onload = function(){
					var output = document.getElementById('output_image');
					output.src = reader.result;
				}
				reader.readAsDataURL(event.target.files[0]);
			}
		</script>
		
		<script language="javascript">
			
				setInterval(galderaKopTotala,20000);
				setInterval(nireKopurua,20000);
				
				xhro = new XMLHttpRequest();
				xhro.onreadystatechange = function(){
					if (xhro.readyState==4){
						
						document.getElementById("xmlIkusi").innerHTML= xhro.responseText;
					}
				}	
				

				xhro3 = new XMLHttpRequest();
				xhro3.onreadystatechange = function(){
					if (xhro3.readyState==4){
						var xml = xhro3.responseXML;
						var zerrenda = xml.getElementsByTagName('assessmentItem');
						var i=0;
						var kont = 0;
						while (zerrenda[i]){
							if(zerrenda[i].getAttribute('author') == "<?php echo $email ?>"){
								kont = kont+1;
							}
							i=i+1;
						}
						document.getElementById("nireGalderak").innerHTML= kont;
					}
				}
				
				xhro2 = new XMLHttpRequest();
				xhro2.onreadystatechange = function(){
					if (xhro2.readyState==4){
						var xml = xhro2.responseXML;
						var zerrenda = xml.getElementsByTagName('assessmentItem');
						var kopuruTotala = zerrenda.length;
						document.getElementById("galderakGuztira").innerHTML= kopuruTotala;
					}
				}
	
			
				function nireKopurua(){
					xhro3.open("GET","../questions.xml", true);
					xhro3.send(null);
				}
				
				function galderaKopTotala(){
					xhro2.open("GET","../questions.xml", true);
					xhro2.send(null);
				}
			
				function  konprobatuDena(){
					
							var email = $("#email").val()
							var galdera = $("#galdera").val()
							var zuzena = $("#zuzena").val()
							var okerra1 = $("#okerra1").val()
							var okerra2 = $("#okerra2").val()
							var okerra3 = $("#okerra3").val()
							var zailtasuna = $("#zailtasuna").val()
							var gaia = $("#gaia").val()
							var denaOndo = true;
							if (email.length == 0||galdera.length == 0|| zuzena.length == 0||okerra1.length == 0||okerra2.length == 0||okerra3.length == 0||zailtasuna.length == 0||gaia.length == 0){
								alert("(*) ikurra duten atalak nahitaez bete behar dira!");
								denaOndo=false;
							}else{
							if (parseInt(zailtasuna)<0 || parseInt(zailtasuna)>5 || (parseFloat(zailtasuna))%1 != 0){
								alert("Zailtasuna 0-tik 5-erako osokoa izan behar da!");
								denaOndo=false;
							}
							if(galdera.length < 10){
								denaOndo=false;
								alert("Galderaren luzeera gutxienez 10 karakterekoa izan behar da!");
							}
							//EMAIL-A KONPROBATU
							if(!(/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/).test(email)){
								denaOndo=false;
								alert("email-a ez da egokia, patroia: xxxxxnnn@ikasle.ehu.eus, non xxxxx=letrak eta nnn=hiru zenbaki");
							}
							}
							return denaOndo;
				}
				
				
				function gehitu(){
					if(konprobatuDena()){
						var dataString = $('#galderenF').serialize();
						 $.ajax({
							type: "POST",
							url: "addQuestionn.php",
							data: dataString,
							success: function(data) {
									document.getElementById("fb").innerHTML="Galdera gehitu da.";
									$('#galderenF').trigger("reset");
									ikusi();
							}
						});
					}
				}
				
				
				
				function ikusi(){
					xhro.open("GET","showMyXML.php?email=<?php echo $email ?>", true);
					xhro.send(null);
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
		<form id="galderenF" name="galderenF" method="post" action="./addQuestionn.php?email=<?php echo $email; ?>" enctype="multipart/form-data">
			<fieldset>
				<input type="button" value="Ikusi nire galderak" onclick="ikusi()"> 
				<input type="button" value="Galdera gehitu" onclick="gehitu()"><br>
				Email(*): <?php echo $email ?> <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" ><br><br><br>
				Galdera(*): <input type="text" name="galdera" id="galdera"><br><br>
				Erantzun zuzena(*): <input type="text" name="zuzena" id="zuzena"><br><br>
				Erantzun okerra 1(*): <input type="text" name="okerra1" id="okerra1"><br><br>
				Erantzun okerra 2(*): <input type="text" name="okerra2" id="okerra2"><br><br>
				Erantzun okerra 3(*): <input type="text" name="okerra3" id="okerra3"><br><br><br>
				Zailtasuna(*): <input type="text" name="zailtasuna" id="zailtasuna"><br><br>
				Gaia(*): <input type="text" name="gaia" id="gaia"><br><br>
				<!--Irudia: <input type="file" name="irudia" id="irudia" accept="image/*" onchange="preview_image(event)">
				<img id="output_image"/><br><br>-->
				<input type="reset" value="Reset">   
			</fieldset>
		</form>
		
		<div style="text-align:center"><?php echo $email?>-ek sortutako galdera kopurua/galdera kopuru totala: <span id="nireGalderak"></span>/<span id="galderakGuztira"></span></div><br>
		
		<div style="text-align:center">
			<a  href="./showQuestionsWithImages.php?email=<?php echo $email ?>"> Datu basea ikusi </a><br></br>
			<a  href="./layout.php?email=<?php echo $email ?>"> Menura itzuli </a>
		</div><br>
		<div id="fb" style="text-align:center">
		</div><br>
		<div id="xmlIkusi" style="text-align:center">
		</div><br>
		
		
		
		
		
		
		
	</body>
	

</html>
