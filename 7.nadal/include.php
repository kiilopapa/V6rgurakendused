<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Praktikum  - Ülesanne</title>
</head>


<?php 

$autod = array(
	array('mark' => 'Audi', 'aasta' => 1988, 'värv' => 'kollane', 'seisukord' => 'hea'),
	array('mark' => 'Nissan', 'aasta' => 2000, 'värv' => 'punane', 'seisukord' => 'keskmine'),
	array('mark' => 'Volvo', 'aasta' => 1998, 'värv' => 'valge', 'seisukord' => 'kehv'),
	array('mark' => 'Opel', 'aasta' => 2016, 'värv' => 'hall', 'seisukord' => 'super')
	);

foreach ($autod as $auto) {
	include 'view.php';
}
/*echo "<pre>";
print_r($autod);
echo "<pre>";
*/


?>

</body>
</html>