<?php
session_start();


require_once('connection.php');


if(!isset($_POST['action'])){
	session_destroy();
	header('location: index.php');
}
if (isset($_POST['action']) && $_POST['action'] == 'login') {

	if(empty($_POST['email'])){
		$_SESSION['error']['email'] = "Email cannot be empty.";
	}
	else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['error']['email'] = ' Please enter a valid email address.';
	}
	if(empty($_POST['password'])){
		$_SESSION['error']['password'] = "Password cannot be empty.";
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'register') {
	
	
	// first name validation
	if(empty($_POST['first_name'])){
		$_SESSION['error']['first_name'] = "First Name cannot be empty.";
	}
	else if(is_numeric($_POST['first_name'])){
		$_SESSION['error']['first_name'] = "Dude, I know your First Name doesn't have numbers in it.";
	}

	// last name validation
	if(empty($_POST['last_name'])){
		$_SESSION['error']['last_name'] = "Last Name cannot be empty.";
	}
	else if(is_numeric($_POST['last_name'])){
		$_SESSION['error']['last_name'] = "Dude, I know you name doesn't have numbers in it.";
	}

	// email validation
	if(empty($_POST['email'])){
		$_SESSION['error']['email'] = "Email cannot be empty.";
	}
	else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['error']['email'] = ' Please enter a valid email address.';
	}

	// password validation
	if(empty($_POST['password'])){
		$_SESSION['error']['password'] = "Password cannot be empty.";
	}
	else if (strlen($_POST['password']) < 7) {
		$_SESSION['error']['password'] = 'Your password must be more than 6 characters.';
	}	
	else if ($_POST['password'] !== $_POST['c_password']){
		$_SESSION['error']['password'] = 'Your password fields do not match';

	}

	// c_password validation
	if(empty($_POST['c_password'])){
		$_SESSION['error']['c_password'] = "Confirm Password cannot be empty.";
	}
	else if (strlen($_POST['c_password']) < 7) {
		$_SESSION['error']['c_password'] = 'Your password must be more than 6 characters.';
	}	
	

	// birthday validation
	if(strlen($_POST['birthday']) <10){
			$_SESSION['error']['birthday'] = "Please enter your birthday.";
	}
	else {
		$x = explode('/', $_POST['birthday']);

		if (count($x)==3) {
			if (checkdate($x[1], $x[2], $x[0]) == false) {
			$_SESSION['error']['birthday'] = 'Your birthday must be in yyyy/mm/dd format';
			} 
			else{
				$_SESSION['bday'] = $x[0].'-'.$x[2].'-'.$x[1];
			} 
		}		
	}	
}

if(isset($_SESSION['error']) && count($_SESSION['error']) > 0 ){

	if($_POST['action'] == 'register'){
		$_SESSION['error_type'] = 'register';
	}
	else if ($_POST['action'] == 'login'){
		$_SESSION['error_type'] = 'login';

	}


	header('location: index.php');
}

else {

	if(isset($_POST['action']) && $_POST['action'] == 'register'){

		$query = "INSERT INTO users (first_name, last_name, email, password, birthdate, created_at) 
		VALUES ('".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['email']."', '".md5($_POST['password'])."', '".$_SESSION['bday']."', NOW() ) ";

		mysqli_query($connection, $query);

		header('location: index.php');
	}
	else if(isset($_POST['action']) && $_POST['action'] == 'login'){

		$query = "SELECT * FROM users WHERE email = '".$_POST['email']."' and password = '".md5($_POST['password'])."'";

		$return = mysqli_query($connection, $query);

		// $count = mysqli_stmt_num_rows($connection, $return);
		// var_dump($query);

		if($return->num_rows < 1) {
			$_SESSION['error']['login'] = 'Invalid Login Credentials';
			$_SESSION['error_type'] = 'login';
			header("location: index.php");
		}
		else {

			$row = mysqli_fetch_assoc($return);
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['first_name'] = $row['first_name'];
			$_SESSION['user']['last_name'] = $row['last_name'];
			$_SESSION['user']['email'] = $row['email'];
			$_SESSION['logged_in'] = true;
			header('location: profile.php');
			// var_dump($_SESSION);	
		}	
	}
}
	
// EVERYTHING BELOW IS PROFILE PAGE!!!!!

if(isset($_POST['action']) && $_POST['action'] == 'post'){

		$query = "INSERT INTO posts (posts, created_at, user_id) 
					VALUES ('".$_POST['mainPost']."', NOW(), '".$_SESSION['user']['id']."' ) ";

		mysqli_query($connection, $query);

		header('location: profile.php');



}

if(isset($_POST['action']) && $_POST['action'] == 'comment'){

		$query = "INSERT INTO comments (comments, created_at, user_id, post_id) 
					VALUES ('".$_POST['mainComment']."', NOW(), '".$_SESSION['user']['id']."', '".$_POST['savior']."') ";

		mysqli_query($connection, $query);
		// echo $query;
		// var_dump($_SESSION);

		header('location: profile.php');

}



?>











