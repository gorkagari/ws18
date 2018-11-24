<?php $email=$_POST['email']?>
<!DOCTYPE html>
<html>
	<head>
		<title>Galdera IDz bilatu</title>
	</head>
	
	<body>
		<form id="idForm" name="idForm" method="post" action="./getQuestionWZ.php?email=<?php echo $email; ?>">
			ID:<input type="text" name="id">
			<input type="submit" value="Bilatu">
		</form>
	</body>
	
	<?php
	
		function konprobatuParametroak(){
			if(is_int($_POST['id'])){
				return true;
			}
			return false;
		}
	
		if(isset($_POST['id'])){
		
			if(konprobatuParametroak()){
				
				
			}else{
				echo "ID-a zenbaki osoko bat izan behar da.";
			}
		
		}
	?>