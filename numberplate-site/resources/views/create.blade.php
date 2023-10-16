<?php session_start();
include_once("includes.php");

if(strlen($_POST['numPlateInput']) <= 0 || strlen($_POST['numPlateInput']) > 7){
	echo 'Number plate must be between 1 to 5 characters long';
	
}elseif(strlen($_POST['quantity']) <= 0 || strlen($_POST['quantity']) > 1 || $_POST['quantity'] < 1 || $_POST['quantity'] > 5){
	echo 'Rating is from 1 to 5';
	
}elseif(strlen($_POST['commentInput']) <= 0 || strlen($_POST['commentInput']) > 4000){
	echo 'Comments are 1 to 4000 characters long';

}else{
	$query = "SELECT * FROM users WHERE email LIKE '" . $_SESSION['email'] . "'";
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();
	while($row = mysqli_fetch_assoc($result)){
	$_SESSION['userId'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	}
		$query = "INSERT INTO comments (plateId, userId, username, comment, rating) VALUES ('" . $_POST['numPlateInput'] . "', '" . $_SESSION['userId'] . "', '" . $_SESSION['username'] . "', '" . $_POST['commentInput'] . "', '" . $_POST['quantity'] . "')";
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();

	header('Location: http://www.redcapstudios.net/index.php');
	return;
	
}

?>