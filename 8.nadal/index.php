<!DOCTYPE html>

<html>

	<head>
		<title>	</title>
		<meta charset="utf-8" />
		<?php  
		$myurl=$_SERVER['PHP_SELF'];
		$nimi = "Siia kirjuta tekst";
		$bg_col="blue"; //taustavärv
		$color = "skyblue";

		if (!empty($_GET["kuvatav"])){
			$nimi =  $_GET["kuvatav"];
		}

		 // vaikimisi väärtus
		if (isset($_GET['bg_color']) && $_GET['bg_color']!="") {
    		$bg_col=htmlspecialchars($_GET['bg_color']);
		} 

		if (isset($_GET['color']) && $_GET['color']!="") {
    		$color=htmlspecialchars($_GET['color']);
		} 
		?>
		<style type="text/css">
			#kuva {
				background-color : <?php echo $bg_col?>;
				color: <?php echo $color?>;

			}
		</style>
	
	</head>
	<body>

	

		<div id="kuva">
			<?php 
				
				if (!empty($_GET["kuvatav"])){
					echo $_GET["kuvatav"];
				}
			?>
		</div>






<form action="<?php echo $myurl?>" method="GET">
	<input type="text" name="kuvatav" value="<?php echo $nimi;?>" />
	<input type="color" name="color" value="<?php echo $color;?>">
	Tekstivärvus
	<input type="color" name="bg_color" value="<?php echo $bg_col;?>">
	Taustavärv
	<input type="submit" value="kuva"/>
</form>

<?php

?>



	<body>

</html>