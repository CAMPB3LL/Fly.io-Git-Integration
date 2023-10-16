<? session_start();
include_once("includes.php");

if(!isset($_POST['delete'])){ //IF EMPTY 
	header('Location: http://www.redcapstudios.net/index.php?link=404'); //DISPLAYS 404 PAGE
	return;
}else{
	
	$query = "DELETE FROM comments WHERE id='" . $_POST['delete'] . "'";
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();

	header('Location: http://www.redcapstudios.net/index.php');
	return;
}

?>