<?php
include("includes/header.php"); 
?>

<!-- Friend Request-->

<div class="main_column column" id="main_column">

	<h2> Friend Requests </h2>

	<hr></hr>

	<?php  

	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'"); // Query buat get friend_request's -> user_to = to loggedInUSER

	if(mysqli_num_rows($query) == 0) // kalau gaada friend req 

		echo "You have no friend requests at this time!";
	else {

		while($row = mysqli_fetch_array($query)) {

			$user_from = $row['user_from']; // dapet request dari siapa 
			$user_from_obj = new User($con, $user_from);

			echo $user_from_obj->getFirstAndLastName() . " sent you a friend request!";// show siapa yang req friend 

			$user_from_friend_array = $user_from_obj->getFriendArray();

			// kalau accept request di klik 

			if(isset($_POST['accept_request' . $user_from ])) {

				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLoggedIn'"); // Query buat update friend_array di userLoggedIn pake concat

				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE username='$user_from'"); // Query buat update friend_array di user_from pake concat

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'"); // hapus row dari table friend_requests

				echo "You are now friends!";

				header("Location: requests.php");
			}

			// kalau ignore request di klik

			if(isset($_POST['ignore_request' . $user_from ])) {

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'"); // langsung hapus dari friend_requests table

				echo "Request ignored!";

				header("Location: requests.php");
			}

			?>

			<!-- Form buat handle friend request -->

			<form action="requests.php" method="POST">

				<input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept">

				<input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore">
				<hr></hr>

			</form>

			<?php


		}

	}

	?>


</div>