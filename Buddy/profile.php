<?php 
include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_GET['profile_username'])) {

	$username = $_GET['profile_username']; // buat dapetin username dari url yang di pas pake file .htaccess 

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'"); // query buat dapetin detail user 

	$user_array = mysqli_fetch_array($user_details_query);

	$num_friends = (substr_count($user_array['friend_array'], ",")) - 1; // buat count jumlah friend pake comma 
}

// ketika remove_friend di klik 

if(isset($_POST['remove_friend'])) {

	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
}

// ketika add_friend di klik

if(isset($_POST['add_friend'])) {

	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username);
}

// ketika respond_request di klik 

if(isset($_POST['respond_request'])) {

	header("Location: requests.php");
}

if(isset($_POST['post_message'])) {
  if(isset($_POST['message_body'])) {
    $body = mysqli_real_escape_string($con, $_POST['message_body']);
    $date = date("Y-m-d H:i:s");
    $message_obj->sendMessage($username, $body, $date);
  }

  $link = '#profileTabs a[href="#messages_div"]';
  echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";


}

 ?>
 
  	<style type="text/css">
	 	.wrapper {
	 		margin-left: 0px;
			padding-left: 0px;
	 	}

 	</style>