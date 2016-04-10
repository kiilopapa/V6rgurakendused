<!DOCTYPE html>

<html>

	<head>
		<title>	</title>
		<meta charset="utf-8" />
	
	</head>
	<body>

	<?php  
		$myurl=$_SERVER['PHP_SELF'];

		$bg_col="#f0f"; // vaikimisi väärtus
		if (isset($_GET['bg_color']) && $_GET['bg_color']!="") {
    		$bg_col=htmlspecialchars($_GET['bg_color']);
		} 


	?>

		<div id="kuva" style="color: <?php echo $bg_col;?>">
			<?php 
				
				if (!empty($_GET["kuvatav"])){
					echo $_GET["kuvatav"];
				}
			?>
		</div>






<form action="<?php echo $myurl?>" method="GET">
	<input type="text" name="kuvatav" />
	<input type="color" name="bg_color" value="<?php echo $bg_col;?>">
	<input type="submit" value="kuva"/>
</form>

<?php

?>



	<body>

</html>