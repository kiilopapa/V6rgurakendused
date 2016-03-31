<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Praktikum  - Ülesanne</title>
<style type="text/css">
	.auto {
		display: inline-block;
		background-color: skyblue;
		border-style: ridge;
		border-radius: 20%;
		border-width: thick;
		border-color: deepskyblue;
	}
</style>
</head>
<body>


<?php 

$autod = array(
	array('mark' => 'Audi', 'aasta' => 1988, 'värv' => 'kollane', 'seisukord' => 'hea'),
	array('mark' => 'Nissan', 'aasta' => 2000, 'värv' => 'punane', 'seisukord' => 'keskmine'),
	array('mark' => 'Volvo', 'aasta' => 1998, 'värv' => 'valge', 'seisukord' => 'kehv'),
	array('mark' => 'Opel', 'aasta' => 2016, 'värv' => 'hall', 'seisukord' => 'super')
	);

foreach ($autod as $auto) {

	include 'view.php';
	echo "\n";
}
/*echo "<pre>";
print_r($autod);
echo "<pre>";
*/


?>

</body>
</html>