<? session_start();
echo "<div class=\"profilePageBody\">";

if(!isset($_SESSION['access_token'])){ //CHECKS IF A USER IS LOGGED IN
	echo 'You Are Currently Not Signed In';
}else{
		$query = "SELECT * FROM users WHERE email LIKE '%" . $_SESSION['email'] . "%'"; //FIND USER IN DATABASE WITH EMAIL
		connectDB();
		$result = mysqli_query($_SESSION['db'], $query);
		closeDB();
		while($row = mysqli_fetch_assoc($result)){

		//PROFILE INFORMATION
		echo "<h1>Profile Details</h1><hr \>

			<form method=\"post\" action=\"\">

			<div class=\"flexrow\"><div class=\"inputCont\">
			<label for=\"fname\">First Name</label><br>
			<input class=\"profilePageInput\" disabled type=\"text\" id=\"fname\" name=\"fname\" value=\"" . $row['fname'] . "\"><br>
			<label for=\"lname\">Last Name</label><br>
			<input class=\"profilePageInput\" disabled type=\"text\" id=\"lname\" name=\"lname\" value=\"" . $row['sname'] . "\"><br></div><div class=\"inputCont\">
			<label for=\"email\">Email</label><br>
			<input class=\"profilePageInput\" disabled type=\"email\" id=\"email\" name=\"email\" value=\"" . $row['email'] . "\"><br>
			<label for=\"username\">Username</label><br>";
			
			//USERNAME FEILD
			if(!isset($_POST['username'])){
				echo "<input class=\"profilePageInput\" disabled type=\"text\" id=\"username\" name=\"username\" value=\"" . $row['username'] . "\"><br></div></div>";
			}else{
				echo "<input class=\"profilePageInput\" disabled type=\"text\" id=\"username\" name=\"username\" value=\"" . $_POST['username'] . "\"><br></div></div>";
			}

			//BIO FEILD
			if(!isset($_POST['bio'])){
				echo "<label for=\"bio\">User Bio</label><br>
				<textarea id=\"bio\" name=\"bio\" rows=\"4\" cols=\"50\">" . $row['bio'] . "</textarea><br>";
			}else{
				echo "<label for=\"bio\">User Bio</label><br>
				<textarea id=\"bio\" name=\"bio\" rows=\"4\" cols=\"50\">" . $_POST['bio'] . "</textarea><br>";		
			}

			echo "<a href=\"http://www.redcapstudios.net/signout.php\">
			<button type=\"submit\" class=\"button\" id=\"Update\">Update <i class=\"fas fa-cloud-upload-alt\"></i></button></form>

			<hr \><a href=\"http://www.redcapstudios.net/signout.php\"><button class=\"button\">Sign Out <i class=\"fas fa-sign-out-alt\"></i></button></div>"
			;
			
			if(!empty($_POST)){
				if(empty($_POST['username'])){
					$_POST['username'] = 'Anonymous';
				}
				
				//UPDATES PROFILE INFORMATION
				$query = "UPDATE users SET username = '" . $_POST['username'] . "', bio = '" . $_POST['bio'] . "' WHERE email LIKE '%" . $_SESSION['email'] . "%'";
				connectDB();
				$result = mysqli_query($_SESSION['db'], $query);
				closeDB();
			}
	}
}




?>