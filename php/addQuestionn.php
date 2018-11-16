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