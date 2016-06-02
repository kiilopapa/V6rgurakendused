<?php
require_once('func.php');
session_start();
connect_db();

$page="main";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}
if (!isset($_SESSION['user'])) {
	$page="login";
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
	
	case "checkout":
		checkOut();
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