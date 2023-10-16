<? session_start();

require_once 'includes.php';
//GOOGLE OAUTH STUFF
require_once 'config.php';
$_SESSION['loginURL'] = $client->createAuthUrl();

if(!isset($_GET['link'])){
	$link = "Home";
}else{
	$link =  $_GET['link'];
	mysqli_real_escape_string($_SESSION['db'], $link);
}

$query = "SELECT * FROM content WHERE link='" . $link . "'";
connectDB();
$result = mysqli_query($_SESSION['db'],$query);
closeDB();
if(mysqli_num_rows($result)<1){
	header("Location:index.php?link=404");
}else{
	$row = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?=$row['title']?></title>
<link rel="shortcut icon" href="images/car.ico">
<script src="https://kit.fontawesome.com/3e1ef69af4.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="styles/stylesheet.css?<? echo time();?>" media="screen"/>
</head>

<body>
<!-- TOP OF PAGE HEADER -->
<header class="flex-container">
	<!-- MAIN LOGO -->
	<a href="index.php?link=Home">
	<img src="images/car.png" alt="Logo" width="80" height="80">
	</a>
	<div class="pageHeaderDiv">
		<a href="index.php?link=Home">
		<h1 class="pageHeader">Road User Rating</h1>
		<h2 class="pageHeader">Bad drivers beware</h2>
		</a>
	</div>

<?=profile();?>

</header>
<?
//MAIN BODY OF PAGE
echo "<main>";	
	
if($row['includes']){
	include($row['includes']);
}
	
echo "</main></body></html>";
?>