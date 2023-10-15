<? session_start();

function connectDB(){

	$user = "root";
	$password = "";
	$database = "roaduser_db";
	$host = "localhost";

	$_SESSION['db'] = mysqli_connect(
	$host,
	$user,
	$password,
	$database);

	//Check connection
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL:" . mysqli_connect_error();	
	}
}

function closeDB(){
	mysqli_close($_SESSION['db']);
}

function comments(){
	
	connectDB();
	$result = mysqli_query($_SESSION['db'], $_SESSION['query']);
	closeDB();
	while($row = mysqli_fetch_assoc($result)){
		$_SESSION['creatorId'] = $row['userId'];
		$_SESSION['rating'] = $row['rating'];
	?>
	<article class="commentBlock">
		<div class="commentHead">
			<div class="numPlate">
				<h1 class="plateId"><? $plate = $row['plateId'];
					$space = " ";
					$diamond = "⬩";
					$plateId = str_replace($space, $diamond, $plate);
					echo $plateId;
					?></h1>
			</div>
			<div class="starRating">
			<? 
				if($row['rating'] == 1){
					?>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span>(1 Star)</span>
					<?
				}elseif($row['rating'] == 2){
					?>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span>(2 Stars)</span>
					<?	
				}elseif($row['rating'] == 3){
					?>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star"></span>
					<span class="fas fa-star"></span>
					<span>(3 Stars)</span>
					<?
				}elseif($row['rating'] == 4){
					?>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star"></span>
					<span>(4 Stars)</span>
					<?
				}elseif($row['rating'] == 5){
					?>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span class="fas fa-star checked"></span>
					<span>(5 Stars)</span>
					<?
				}
			?>
			</div>
			<span class="commentUser"><?=$row['username']?></span>
		</div>
		<div class="commentContainer">
			<p class="comment"><?=$row['comment']?></p>

			<span class="timePosted"><?="Posted: " . $row['timePosted']?></span>
			<?
			if($_SESSION['userId'] == $_SESSION['creatorId'] || $_SESSION['userId'] == 2){
			?>
				<form method="post" action="delete.php">
					<button class="buttonDelete" type="submit" name="delete" value="<?=$row['id']?>">
						<i class="fas fa-trash-alt"></i> Delete
					</button>
			</form>
			<?
			}

			?>
		</div>
	</article>
	<?
	}
}

function starRatingR(){

	if($_SESSION['rating'] == 1){
		?>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<?
	}elseif($_SESSION['rating'] == 2){
		?>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<?	
	}elseif($_SESSION['rating'] == 3){
		?>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<?
	}elseif($_SESSION['rating'] == 4){
		?>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star"></span>
		<?
	}elseif($_SESSION['rating'] == 5){
		?>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<span class="fas fa-star checked"></span>
		<?
	}
}

function profile(){
	if(!isset($_SESSION['access_token'])){
		echo "<div class=\"pageHeaderDivR\"><h1 class=\"pageHeaderR\"><a href='" . $_SESSION['loginURL'] . "'><i class=\"fab fa-google\"></i> Sign In</a></div>";
	}else{
		echo "<div class=\"pageHeaderDivR\"><a href=\"index.php?link=Profile\"><h1 class=\"pageHeaderR\">" . $_SESSION['email'] . "</h1><h2 class=\"pageHeaderR\">" . $_SESSION['name'] . "</h2></a></div><a href=\"index.php?link=Profile\"><img class=\"profilePic\" src=\"" . $_SESSION['picture'] . "\" alt=\"Logo\" width=\"80\" height=\"80\"></a>";
	}
}


?>