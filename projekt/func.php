<?php
require_once ('database.php');

function checkOut(){
	echo "<pre>";
	//print_r($_GET);
	//print_r($errors);
	echo "</pre>";
	if (!isset($_GET['id'])&& !is_numeric('id')) echo "Check out failed";

	global $connection;
	$sql = "UPDATE 1010_visits SET time_of_exit=NOW() WHERE id=".mysqli_real_escape_string($connection, $_GET['id']);
	
	update($sql);
	
	main();
	
	
}

function main(){
	if (!isset($_SESSION['user'])) {
		header("Location: ?page=login");
		exit(0);
	}

	if ($_SERVER['REQUEST_METHOD']=="POST") {
		
		$errors = Array();
		$requiredInputs = ["visitor_name" => "visitor name", "visitor_surname" =>"visitor surname", "visitor_card_nr"=>"visitor card number", 
    "host_name"=>"host name"];
		
		foreach ($requiredInputs as $required=>$input){
			if (isset($_POST[$required]) && $_POST[$required] !="") {
				$requiredInputs[$required]= htmlspecialchars($_POST[$required]);
				//$$required = htmlspecialchars($_POST[$required]);
			}else {
				$errors[] = htmlspecialchars($input). " is missing.";
			}

		}
		
		if (empty($errors)) {
			global $connection;

			$visitorName = mysqli_real_escape_string($connection, $requiredInputs['visitor_name']);
			$visitorSurname = mysqli_real_escape_string($connection, $requiredInputs['visitor_surname']);
			$visitorCard = mysqli_real_escape_string($connection, $requiredInputs['visitor_card_nr']);
			$host = mysqli_real_escape_string($connection, $requiredInputs['host_name']);

			$sql = "SELECT id FROM 1010_visitors WHERE name = '$visitorName' AND surname = '$visitorSurname'";

			$visitorId = queryRow($sql)[0];

			if (!isset($visitorId)){
				$visitorId = addVisitor($visitorName, $visitorSurname);
			}

			addVisit($visitorId, $visitorCard, $host);
		}

		echo "<pre>";
		//print_r($requiredInputs);
		//print_r($errors);
		echo "</pre>";

	}



	$hosts = getHosts();
	$visits = getVisits();

	foreach ($visits as $id => $visit) {
		$visits[$id]['visitor_name'] = getVisitorName($visit['visitor_id']);
		$visits[$id]['host_name'] = getHostN($visit['host_id']);
	}

	echo "<pre>";
	//print_r($visits);
	//print_r($errors);
	echo "</pre>";
	
	include_once ('views/main.html');
}

function manageHosts(){
	$hosts = getHosts();
	
	
	//include_once ('views/hosts.html');
	include_once ('views/mhosts.html');
		
}

function removeHost(){

	if (!isset($_GET['id'])&& !is_numeric($_GET['id'])) echo "can't remove host ". $_GET['id'];

	global $connection;
	$sql = "UPDATE 1010_hosts SET deleted=TRUE WHERE id=".mysqli_real_escape_string($connection, $_GET['id']);

	update($sql);

	manageHosts();

}

function addHost()
{

    global $connection;
    $errors = array();
    

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['name']) && $_POST['name'] != "") {
            $name = htmlspecialchars($_POST['name']);
        } else {
            $errors[] = "No firstname";
        }
        if (isset($_POST['surname']) && $_POST['surname'] != "") {
            $surname = htmlspecialchars($_POST['surname']);
        } else {
            $errors[] = "No surname";
        }

        if (empty($errors)) {

            $name = mysqli_real_escape_string($connection, $name);
            $surname = mysqli_real_escape_string($connection, $surname);

            $sql = "INSERT INTO test.1010_hosts ( name, surname) VALUES ('$name', '$surname')";
            insertRow($sql);
        }
        //echo "<pre>";
        //print_r($errors);
        //print_r($_POST);
        //echo "</pre>";
        manageHosts();
    }
}

function getHostN($id){
	$sql = "SELECT name, surname FROM 1010_hosts WHERE id = '$id'";
	$host = queryRow($sql);
	$name = $host[0]. " ". $host[1];
	return $name;
}

function getVisitorName($id){
	$sql = "SELECT name, surname FROM 1010_visitors WHERE id = '$id'";
	$visitor = queryRow($sql);
	$name = $visitor[0]. " ". $visitor[1];
	//echo $name;
	return $name;
}

function getVisits(){
	$sql = "SELECT * FROM 1010_visits WHERE time_of_exit = '0000-00-00 00:00:00'";
	return queryArray($sql);
}

function addVisit($visitorId, $visitorCard, $host)
{
	$sql = "INSERT INTO test.1010_visits ( visitor_id, host_id, visitor_card) VALUES ('$visitorId', '$host', '$visitorCard')";
	$id = insertRow($sql);
	return $id;
}

function getHosts(){
	
	global $connection;
	
	$sql = "SELECT * FROM 1010_hosts WHERE deleted=FALSE ";

	return queryArray($sql);
}

function addVisitor($name, $surname){

	$sql = "INSERT INTO test.1010_visitors ( name, surname) VALUES ('$name', '$surname')";
	$id= insertRow($sql);
	return $id;
}

function login(){
	global $connection;
	if (isset($_SESSION['user'])) {
		header("Location: ?page=main");
		exit(0);
	}

	$errors = array();
	$user="";
	$pass="";
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		if (isset($_POST['user']) && $_POST['user'] !="") {
			$user =htmlspecialchars($_POST['user']);
		} else {
			$errors[] = "No username";
		}
		if (isset($_POST['pass']) && $_POST['pass'] !="") {
			$pass = htmlspecialchars($_POST['pass']);
		} else {
			$errors[] = "No Password";
		}

		$user = mysqli_real_escape_string($connection, $user);
		$pass = mysqli_real_escape_string($connection, $pass);

		if (empty($errors)) {

			$sql = "SELECT * FROM 1010_users WHERE username = '$user' AND password = sha1('$pass')";
	
			$query = mysqli_query($connection, $sql)  or die ("$sql - ".mysqli_error($connection));
			
			if (mysqli_num_rows($query)>0){
				$login = mysqli_fetch_array($query);
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['role'] = $login['role'];

				header("Location: ?page=main");
				//exit(0);
			}
			$errors[] = "Wrong username or password!";
			
			
			/*echo "<pre>";
			print_r($query);
			print_r($_SESSION);
			echo "</pre>";
			*/
		}
		

	}


	

	include_once('views/login.html');
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function show_hosts(){
	global $connection;
		
	$hosts = getHosts();

	//echo "<pre>";
	//print_r($hosts);
	//echo "</pre>";
	
	include_once('views/hosts.html');
	
}



?>