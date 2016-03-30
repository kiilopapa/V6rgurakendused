<?php 
$string = "aias sadas saia.";

function reverser(){
	global $string;
	for ($i=strlen($string)-1; $i >=0 ; $i--) { 
		echo "$string[$i]";
	}


}


function subreverser(){
	global $string;
	for ($i=1; $i <= strlen($string) ; $i++) {
		$char = substr($string, -$i, 1);
		echo " $char ";
	}

}

reverser();

echo "<hr/>";

subreverser();

?>