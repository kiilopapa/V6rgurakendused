<?php
require_once ('database.php');


function login(){
	global $connection;
	if (isset($_SESSION['user'])) {
		header("Location: ?page=visitors");
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
			echo "string";

			$sql = "SELECT * FROM k_kylastajad WHERE username = '$user' AND passw = sha1('$pass')";
	
			$query = mysqli_query($connection, $sql)  or die ("$sql - ".mysqli_error($connection));

			/*echo "<pre>";
			print_r($query);
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

function show_visitors(){
	// siia on vaja funktsionaalsust
	global $connection;
	$puurid;

	$sql = "SELECT DISTINCT puur FROM k_loomaaed";

	$result = mysqli_query($connection, $sql) or die ("$sql - ".mysqli_error($connection));

	while ( $row = mysqli_fetch_array($result)) {
		$loomasql = "SELECT * FROM k_loomaaed WHERE puur=".mysqli_real_escape_string($connection, $row['puur']);
		$loomaq = mysqli_query($connection, $loomasql);
		while ($puuriloom=mysqli_fetch_assoc($loomaq)) {
					$puurid[$row["puur"]][]=$puuriloom;
		}
	}
	
	include_once('views/puurid.html');
	
}

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	
	include_once('views/loomavorm.html');
	
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