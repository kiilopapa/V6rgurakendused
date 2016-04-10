<!DOCTYPE html>

<html>

	<head>
		<title>	</title>
		<meta charset="utf-8" />
	
	</head>
	<body>
	<?php  $myurl=$_SERVER['PHP_SELF'];?>

		<div id="kuva">
			<?php 
				
				if (!empty($_GET["kuvatav"])){
					echo $_GET["kuvatav"];
				}
			?>
		</div>


<?php $bg_col="#f0f"; // vaikimisi valge
if (isset($_GET['bg_color']) && $_GET['bg_color']!="") {
    $bg_col=htmlspecialchars($_GET['bg_color']);
} ?>



<form action="<?php echo $myurl?>" method="GET">
	<input type="text" name="kuvatav" />
	<input type="color" name="bg_color" value="#ff0000">
	<input type="submit" value="kuva"/>
</form>

<?php

?>



	<body>

</html>