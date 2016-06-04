<?php
require_once('func.php');
session_start();
connect_db();

$page="main";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}
if (isset($_POST['page']) && $_POST['page']!=""){
	$page=htmlspecialchars($_POST['page']);
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

	case "mhosts":
		manageHosts();
		break;

	case "removeHost":
		removeHost();
		break;
	
	case "addHost":
		addHost();
		break;
	
	default:
		main();
	break;
}

include_once('views/foot.html');

?>