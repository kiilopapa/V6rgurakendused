<?php
require_once('func.php');
session_start();
connect_db();

$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

include_once('views/head.html');

switch($page){
	case "login":
		login();
	break;
	
	case "logout":
		logout();
		break;
	
	case "hosts":
		show_hosts();
	break;

	case "main":
		main();
	break;

	case "hosts":
		show_hosts();
		break;

	case "history":
		show_history();
		break;
	
	default:
		main();
	break;
}

include_once('views/foot.html');

?>