<!DOCTYPE html>
<html>
	<head>
		<title> Galdera formularioa </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script language="javascript">
			$(document).ready(function(){
					
					
					$("#galderenF").submit(function  konprobatuDena(){
				
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
			})
			})
			
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
	
	<?php $email = $_GET['email']; ?>
	
	<body>
		<form id="galderenF" name="galderenF" method="post" action="./addQuestionn.php?email=<?php echo $email; ?>" enctype="multipart/form-data">
			<fieldset>
				Email(*): <?php echo $email ?> <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" ><br><br><br>
				Galdera(*): <input type="text" name="galdera" id="galdera"><br><br>
				Erantzun zuzena(*): <input type="text" name="zuzena" id="zuzena"><br><br>
				Erantzun okerra 1(*): <input type="text" name="okerra1" id="okerra1"><br><br>
				Erantzun okerra 2(*): <input type="text" name="okerra2" id="okerra2"><br><br>
				Erantzun okerra 3(*): <input type="text" name="okerra3" id="okerra3"><br><br><br>
				Zailtasuna(*): <input type="text" name="zailtasuna" id="zailtasuna"><br><br>
				Gaia(*): <input type="text" name="gaia" id="gaia"><br><br>
				Irudia: <input type="file" name="irudia" id="irudia" accept="image/*" onchange="preview_image(event)">
				<img id="output_image"/><br><br>
				<input type="reset" value="Reset">   <input type="submit" id="igo" value="Igo">
				
			</fieldset>
		</form>
		<div style="text-align:center">
			<a  href="./showQuestionsWithImages.php?email=<?php echo $email ?>"> Datu basea ikusi </a><br></br>
			<a  href="./addQuestionn.php?email=<?php echo $email ?>"> Galdera berri bat sartu </a><br></br>
			<a  href="./layout.php?email=<?php echo $email ?>"> Menura itzuli </a>
			</div>
	</body>
	

</html>

<?php include 'dbkonfiguratu.php';
	function xmlSortu(){
		$xml = simplexml_load_file('../questions.xml') or die("Error: Cannot create XML object");
		$assessmentItem = $xml -> addChild('assessmentItem');
		$assessmentItem -> addAttribute('author',$_POST['email']);
		$assessmentItem -> addAttribute('subject',$_POST['gaia']);
		
		$itemBody = $assessmentItem -> addChild('itemBody');
		$itemBody -> addChild('p',$_POST['galdera']);
		
		$correctResponse = $assessmentItem -> addChild('correctResponse');
		$correctResponse -> addChild('value',$_POST['zuzena']);
		
		$incorrectResponses = $assessmentItem -> addChild('incorrectResponses');
		$incorrectResponses -> addChild('value',$_POST['okerra1']);
		$incorrectResponses -> addChild('value',$_POST['okerra2']);
		$incorrectResponses -> addChild('value',$_POST['okerra3']);
		$xml-> asXML('../questions.xml');
		
		if($xml){
			echo "<br><div style='text-align:center'> <a  href='./showQuestionsXML.php?email=$_POST[email]'> Show Questions XML </a></div>";
		}else{
			echo " XML errorea eman du ";
		}
	}
	function konprobatuParametroak(){
		$denaOndo = true;
		if (strlen($_POST['email']) == 0||strlen($_POST['galdera']) == 0||strlen($_POST['zuzena']) == 0||strlen($_POST['okerra1']) == 0||strlen($_POST['okerra2']) == 0||strlen($_POST['okerra3']) == 0||strlen($_POST['zailtasuna']) == 0||strlen($_POST['gaia']) == 0){
			$denaOndo=false;
			echo "Atal guztiak bete.";
		}else{
			if ($_POST['zailtasuna']<0 || $_POST['zailtasuna']>5 || !ctype_digit($_POST['zailtasuna'])){
				$denaOndo=false;
				echo "Zailtasun ez egokia.";
			}
			//EMAIL-A KONPROBATU
			$pattern = '/^([a-z]{2,50})([0-9]{3})@ikasle\.ehu\.eus$/';
			if(!(preg_match($pattern,$_POST['email']))){
				$denaOndo=false;
				echo "Email ez egokia.";
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
				$p_text = 'Errore bat egon da konexioarekin.';
				exit;
			}else{
				$irudia = $_FILES["irudia"]["tmp_name"];
				if(!$irudia){
					$irudia = "../images/galderaikurra.png";
				}
				$irudia_data = file_get_contents($irudia);
				$encoded_image = base64_encode($irudia_data);
				$katea = "INSERT INTO questions(email,galdera,zuzena,okerra1,okerra2,okerra3,zailtasuna,gaia,irudia) VALUES ('$_POST[email]','$_POST[galdera]','$_POST[zuzena]','$_POST[okerra1]','$_POST[okerra2]','$_POST[okerra3]','$_POST[zailtasuna]','$_POST[gaia]','$encoded_image')";
				$sql = mysqli_query($esteka, $katea);
					
			}
			if($sql){
				$j_text = 'Datu basearen atzipena ondo joan da.';
				xmlSortu();
			}else{
				$j_text = 'Errore bat egon da datuak igotzerakoan.';
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