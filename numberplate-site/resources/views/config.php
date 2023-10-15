<? session_start();

require_once("vendor/autoload.php");
$client = new Google_Client();
$client->setClientId("414891035475-top7259vorhqfd8pcp8t0n1ptlue9tc5.apps.googleusercontent.com");
$client->setClientSecret("FrXzgzGvzTkBT1KjYBy31jeu");
$client->setRedirectUri("http://www.redcapstudios.net/g_callback.php");
$client->setScopes("email https://www.googleapis.com/auth/userinfo.profile");

