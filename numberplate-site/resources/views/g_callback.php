<? session_start();
require_once("config.php");
include_once("includes.php");

if (isset($_GET['code'])) {
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

	// store in the session also
	$_SESSION['access_token'] = $token;

	//header('Location: http://www.redcapstudios.net/index.php');
	//return;
}

if (
	!empty($_SESSION['access_token'])
	&& isset($_SESSION['access_token']['id_token'])
) {
	$client->setAccessToken($_SESSION['access_token']);
}



$oAuth = new Google_Service_Oauth2($client);
$userData = $oAuth->userinfo_v2_me->get();

$_SESSION['email'] = $userData['email'];
$_SESSION['name'] = $userData['name'];
$_SESSION['picture'] = $userData['picture'];
$_SESSION['given_name'] = $userData['given_name'];
$_SESSION['family_name'] = $userData['family_name'];

$query = "SELECT * FROM users WHERE email LIKE '" . $_SESSION['email'] . "'";
connectDB();
$result = mysqli_query($_SESSION['db'], $query);
closeDB();
$num_rows = mysqli_num_rows($query);

$query = "SELECT * FROM users WHERE email LIKE '" . $_SESSION['email'] . "'";
connectDB();
$result = mysqli_query($_SESSION['db'], $query);
closeDB();
while($row = mysqli_fetch_assoc($result)){
$_SESSION['userId'] = $row['id'];
}

if($num_rows > 0){
	//exists
    header('Location: http://www.redcapstudios.net/index.php');
	return;
}else{
    //doesn't exist
	$query = "INSERT INTO users (email, fname, sname) VALUES ('" . $_SESSION['email'] . "', '" . $_SESSION['given_name'] . "', '" . $_SESSION['family_name'] . "')";
	connectDB();
	$result = mysqli_query($_SESSION['db'], $query);
	closeDB();
	header('Location: http://www.redcapstudios.net/index.php');
	return;
}


