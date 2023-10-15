<? session_start();

unset($_SESSION['access_token']);
header('Location:http://www.redcapstudios.net/index.php?link=Home');
return;

?>