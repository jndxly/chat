<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "test";

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$method = $_SERVER['REQUEST_METHOD'];
if($method == 'GET'){
	
	$sql = "select * from message limit 10";
	$result = query($mysqli, $sql);
	
	echo "<?xml version=\"1.0\"?>\n";
	echo "<response>\n";
	echo "\t<status>$status_code</status>\n";
	echo "\t<time>".time()."</time>\n";
	for($len = 0; $len < count($result); $len++){
		$message = $result[$len];
		$message['msg'] = htmlspecialchars(stripslashes($message['msg']));
		echo "\t<message>\n";
		echo "\t\t<author>$message[user]</author>\n";
		echo "\t\t<text>$message[msg]</text>\n";
		echo "\t</message>\n";
	}
	echo "</response>";
} 
else if($method == 'POST'){
	$usr = $_POST['user'];
	$msg = $_POST['msg'];
	
	$sql = "insert INTO  message (`user`,`msg`) VALUES ('$usr', '$msg')";
	$mysqli->query($sql);
}

function query(mysqli $mysqli, $sql){
	$result = $mysqli->query($sql);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	return $arr;
}


?>