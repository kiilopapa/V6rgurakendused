<!DOCTYPE html>

<html>

	<head>
		<title>	</title>
		<meta charset="utf-8" />
		<style type="text/css">

		</style>
	
	</head>
	<body>

	<?php  
		$myurl=$_SERVER['PHP_SELF'];
		$nimi = "Siia kirjuta tekst";

		if (!empty($_GET["kuvatav"])){
			$nimi =  $_GET["kuvatav"];
		}

		$bg_col="#f0f"; // vaikimisi väärtus
		if (isset($_GET['bg_color']) && $_GET['bg_color']!="") {
    		$bg_col=htmlspecialchars($_GET['bg_color']);
		} 


	?>

		<div id="kuva" style="background-color : <?php echo $bg_col;?>">
			<?php 
				
				if (!empty($_GET["kuvatav"])){
					echo $_GET["kuvatav"];
				}
			?>
		</div>






<form action="<?php echo $myurl?>" method="GET">
	<input type="text" name="kuvatav" value="<?php echo $nimi;?>" />

	<input type="color" name="bg_color" value="<?php echo $bg_col;?>">
	<input type="submit" value="kuva"/>
</form>

<?php

?>



	<body>

</html>