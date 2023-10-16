<? session_start();

include_once("includes.php");

if(!isset($_POST["newComment"])){
?>
<!-- SEARCH BAR -->
<span class="searchSpan">
	<form method="post" action="" class="search-container">
		<div class="flexrow">
			<input type="text" name="search" id="search" autofocus placeholder="Search Plate & Comments.." <? if(isset($_POST['search'])){ echo "value=\"" . $_POST['search'] . "\"";}?>>
			<button class="buttonHome" class="search" type="submit" name="submit" value="search"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
		<div class="flexrow">
			<label id="sortBy" for="sortBy">Sort By: </label>
			<select name="sortBy" class="buttonHome">
				<option value="date">Recent</option>
				<option value="best">Best</option>
				<option value="worst">Worst</option>
				<option value="most">Users</option>
			</select>
			<?
			if(!isset($_SESSION['access_token'])){
				echo "<a href='" . $_SESSION['loginURL'] . "'><button class=\"buttonHome\" >Create Comment <i class=\"fas fa-plus\"></i></a>";
			}else{
				echo "<button class=\"buttonHome\" type=\"submit\" name=\"newComment\">Create Comment <i class=\"fas fa-plus\"></i></button>";
			}
			?>
			

		</div>
	</form>	

</span>	

<!-- CONTAINER FOR BOTH HALVES OF MAIN PAGE -->
<div class="flex-containerContent">
	<!-- LEFT SIDE -->
	<section>
		<h1 class="asideHeaders">
		<?
		if($_POST['sortBy'] == 'date' or empty($_POST['sortBy'])){ //SORTS THE RESULTS OF THE SEARCH  
			echo "<i class=\"far fa-clock\"></i> RECENT COMMENTS";
		}elseif($_POST['sortBy'] == 'best'){
			echo "<i class=\"fas fa-arrow-up\"></i> TOP RATED";
		}elseif($_POST['sortBy'] == 'worst'){
			echo "<i class=\"fas fa-arrow-down\"></i> WORST RATED";
		}elseif($_POST['sortBy'] == 'most'){
			echo "<i class=\"fas fa-align-left\"></i> MOST COMMENTED";
		}
		?>
		</h1>

		<!-- USER COMMENT POST -->
		<?
		if(!$_POST['submit']=="search"){ //IF USER DOES NOT SEARCH ANYTHING
			$_SESSION['query'] = "SELECT * FROM comments ORDER BY timePosted DESC";
			echo comments();
			
		}elseif($_POST['submit']=="search"){ //IF USER SPECIFICALLY SEARCHES SOMETHING
			$_SESSION['query'] = "SELECT * FROM comments WHERE plateId LIKE '%" . $_POST['search'] . "%' or username LIKE '%" . $_POST['search'] . "%' or comment LIKE '%" . $_POST['search'] . "%'";
			if($_POST['sortBy'] == 'date'){
				$_SESSION['query'] .=" ORDER BY timePosted DESC";
			}elseif($_POST['sortBy'] == 'best'){
				$_SESSION['query'] .=" ORDER BY rating DESC";
			}elseif($_POST['sortBy'] == 'worst'){
				$_SESSION['query'] .=" ORDER BY rating ASC";
			}elseif($_POST['sortBy'] == 'most'){
				$_SESSION['query'] .=" ORDER BY timePosted DESC";
			}
			echo comments();
			
			}
			
			if(!empty($_POST['search'])){ //IF RETURNED NOTHING
				if(empty($_SESSION['plateId'])){
					echo "<h1>Nothing Here <i class=\"far fa-frown\"></i></h1>";
				}
			}
		
		
		
		?>
	</section>

	
	<!-- RIGHT SIDE OF WEBSITE -->
	<aside>
		<div class="asideContainers">
			<h1 class="asideHeaders"><i class="fas fa-crown"></i> TOP ROAD USERS</h1>
			<div class=containerRightBorder>
				<?
				$num = 1; 
				$query = "SELECT plateId, COUNT(username) as amount, ROUND(AVG(rating)) as rating FROM comments GROUP BY plateId ORDER BY rating DESC LIMIT 5 ";
				connectDB();
				$result = mysqli_query($_SESSION['db'], $query);
				closeDB();
				while($row = mysqli_fetch_assoc($result)){
				?>
				<div class="containerRight">
					<h1 class="asideHeaders">#<?=$num?></h1>
					<div class="numPlateContainerR">
						<div class="numPlateR">
							<h1 class="plateIdR"><? 
							$space = " ";
							$diamond = "⬩";
							$plateId = str_replace($space, $diamond, $row['plateId']); //REPLACES SPACES WITH DIAMOND
							echo $plateId;
							?></h1>
						</div>
					</div>

					<div class="starRatingR">
						<? 
						$_SESSION['rating'] = $row['rating'];
						echo starRatingR();
						unset($_SESSION['rating']);
						++$num;
						echo "<span>(" . $row['amount'] . ")</span>";
						?>
						
					</div>
				</div>
				<?
					}
				?>
			</div>
		</div>

		<div class="asideContainers">
			<h1 class="asideHeaders"><i class="fas fa-thumbs-down"></i> WORST ROAD USERS</h1>
			<div class=containerRightBorder>
				<?
				$num = 1;
				$query = "SELECT plateId, COUNT(username) as amount, ROUND(AVG(rating)) as rating FROM comments GROUP BY plateId ORDER BY rating ASC LIMIT 5 ";
				connectDB();
				$result = mysqli_query($_SESSION['db'], $query);
				closeDB();
				while($row = mysqli_fetch_assoc($result)){
				?>
				<div class="containerRight">
					<h1 class="asideHeaders">#<?=$num?></h1>
					<div class="numPlateContainerR">
						<div class="numPlateR">
							<h1 class="plateIdR"><? $plate = $row['plateId'];
							$space = " ";
							$diamond = "⬩";
							$plateId = str_replace($space, $diamond, $plate);
							echo $plateId;
							?></h1>
						</div>
					</div>

					<div class="starRatingR">
						<? 
						$_SESSION['rating'] = $row['rating'];
						echo starRatingR();
						unset($_SESSION['rating']);
						++$num;			
						echo "<span>(" . $row['amount'] . ")</span>";
						?>
					</div>
				</div>
				<?
					}
				?>
			</div>
		</div>
	</aside>
</div>
<?php 
}elseif(isset($_SESSION['access_token'])){	//IF THE USER SELECTED "CREATE A COMMENT"

?>
<article class="newCommentBlock">
	<form method="post" action="create.php">
		<h1>Create a Comment</h1><hr \>
		<div class="commentHead">
			<div class="numPlate">
				<input name="numPlateInput" maxlength="7" type="text" class="plateId" placeholder="Plate #" required>
			</div>
			<div class="starRating">
				  <label for="quantity">Star Rating: </label>
				  <input type="number" id="quantity" name="quantity" min="1" max="5" maxlength="1" placeholder="1-5" required>
			</div>
		</div>
		<div class="commentContainer">
			<textarea name="commentInput" minlength="30" maxlength="4000" type="text" class="comment" placeholder="Write Comment Here." required></textarea>
		</div>
		<button class="postComment" type="submit" name="postComment" value="postComment">Create Comment <i class="far fa-plus-square"></i></button>
	</form>
</article>
<?

	
	
}else{
	echo '<h1>Please Login to Create Comments</h1>';
}