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
	
	case "visitors":
		show_visitors();
	break;

	case "register":
		register();
	break;

	case "hosts":
		show_hosts();
		break;

	case "history":
		show_history();
		break;
	
	default:
		include_once('views/main.html');
	break;
}

include_once('views/foot.html');

?>