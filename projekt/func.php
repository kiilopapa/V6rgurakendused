<?php
require_once ('database.php');

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
	$sql = "SELECT * FROM 1010_visits";
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
	
	$sql = "SELECT * FROM 1010_hosts";

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
			$errors[] = "Kasutajanimi sisestamata";
		}
		if (isset($_POST['pass']) && $_POST['pass'] !="") {
			$pass = htmlspecialchars($_POST['pass']);
		} else {
			$errors[] = "Parool sisestamata";
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
				exit(0);
			}


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

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>