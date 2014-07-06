<?php
session_start();
require_once('connection.php');
?>
<!doctype html>
<html>
<head>
	<title><?= $_SESSION['user']['first_name']?>'s Profile</title>
	<style type="text/css">
		body{
			max-width: 900px;
			min-width: 900px;
		}
		#navBar{
			background-color: silver;
			display: inline-block;
			width:900px;
		}
		#navBar p{
			display: inline-block;
		}
		#navBar .njw{
			text-align: left;
			margin-left: 40px;
		}
		#navBar .logOff{
			text-align: right;
		}
		#profilePic{
			height:250px;
			width:250px;
			background-color: lightblue;
			display: inline-block;
			margin-top: 10px;
			margin-left: 40px;
		}
		#basicData{
			height:250px;
			width:500px;
			background-color: orange;
			display: inline-block;
			vertical-align: top;
			margin-top: 10px;
			margin-left: 50px;
			text-align: center;
		}
		#mainPost{
			width:800px;
			height: 150px;
			/*overflow: scroll;*/
			/*border:1px solid black;*/
			margin-left: 40px;
			margin-top: 20px;
		}
		#postText{
			width:800px;
			height: 150px;
			/*overflow: scroll;*/
			border:1px solid black;
			/*margin-left: 40px;
			margin-top: 20px;*/
		}
		#postBtn{
			background-color: blue;
			height:30px;
			width:60px;
			color:white;
			border-radius: 6px;
			border:1px solid darkblue;
			margin-left: 750px;
			margin-top: 10px;
		}
		#subPostDiv{
			margin-left: 40%;
		}
		.subPost{
			width:400px;
			height: 100px;
			overflow: auto;
			border:1px solid black;
			border-radius: 6px;
			/*margin-left: 60px;*/
			margin-top: 20px;
		}
		.subComment{
			width:300px;
			height: 75px;
			overflow: auto;
			border:1px solid black;
			border-radius: 6px;
			/*margin-left: 60px;*/
			margin-top: 10px;
		}
	</style>
</head>
<body>

	<div id='navBar'>
		<p class='njw'> Ninja Walls.com</p>
		<p class='logOff'>Hello <?= $_SESSION['user']['first_name'] ?> <a href="index.php">Log Off</a></p>
	</div>

	 <div id='profilePic'></div>

	<div id='basicData'>
		<p> <?= $_SESSION['user']['id'] ?></p>
		<p>	<?= $_SESSION['user']['first_name'] ?></p>
		<p>	<?= $_SESSION['user']['last_name'] ?></p>
		<p>	<?= $_SESSION['user']['email'] ?></p>
	</div> 

<!-- POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST -->

	<div id='postbox'>
		<div id='mainPost'>
			<form action='process.php' method='post' enctype='multipart/form-data'>
				<input type='hidden' name='action' value='post'>
				<input id='postText' type='text' name='mainPost' >
				<input id='postBtn' type='submit' value='POST'/>
			</form>
		</div>
	</div>

	<div id='subPostDiv'>
		
<?php

		$query = "SELECT posts.posts, posts.created_at, users.id, posts.user_id, posts.id, users.first_name, users.last_name 
						FROM posts
						LEFT JOIN users ON users.id = posts.user_id
						ORDER BY posts.id desc";

			$return = mysqli_query($connection, $query);

			while($row = mysqli_fetch_assoc($return)){
				
				$_SESSION['posts']['posts'] = $row['posts'];
				$_SESSION['posts']['created_at'] = $row['created_at'];
				$_SESSION['posts']['user_id'] = $row['user_id'];
				$_SESSION['posts']['id'] = $row['id'];
				$_SESSION['posts']['first_name'] = $row['first_name'];
				$_SESSION['posts']['last_name'] = $row['last_name'];

				if(isset($_SESSION['posts'])){
				$postContent =  "<div class='subPost'> <p>" .$_SESSION['posts']['first_name']." ".$_SESSION['posts']['last_name']. "  " .$_SESSION['posts']['created_at']. "</p><p>" .$_SESSION['posts']['posts'].  "</p> </div>";
		
				echo $postContent ;

	//COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT COMMENT 

				$query = "SELECT comments.comments, comments.created_at, users.id, comments.user_id, comments.post_id, users.first_name, users.last_name 
					FROM comments
					LEFT JOIN posts ON posts.id = comments.post_id
					LEFT JOIN users ON users.id = posts.user_id
					WHERE comments.post_id = '".$_SESSION['posts']['id']."'
					GROUP BY comments.id
					ORDER BY comments.id DESC";

					// echo $query;

				$returnC = mysqli_query($connection, $query);
				
				while($row = mysqli_fetch_assoc($returnC)){
					
					$_SESSION['comments']['comments'] = $row['comments'];
					$_SESSION['comments']['created_at'] = $row['created_at'];
					$_SESSION['comments']['user_id'] = $row['user_id'];
					$_SESSION['comments']['id'] = $row['id'];
					$_SESSION['comments']['post_id'] = $row['post_id'];
					$_SESSION['comments']['first_name'] = $row['first_name'];
					$_SESSION['comments']['last_name'] = $row['last_name'];

					if(isset($_SESSION['comments'])){
					$commentContent =  "<div class='subComment'> <p>" .$_SESSION['comments']['first_name'].$_SESSION['comments']['last_name']. " " .$_SESSION['comments']['created_at']. "</p><p>" . $_SESSION['comments']['comments'] . "</p> </div>";
			
					echo $commentContent ;
				}
			}
?>
				<div id='commentBox'>
					<div id='mainComment'>
						<form action='process.php' method='post' enctype='multipart/form-data'>
							<input type='hidden' name='action' value='comment'>
							<input id='commentText' type='text' name='mainComment' >
							<input id='commentBtn' type='submit' value='COMMENT'/>
							<input type='hidden' name='savior' value='<?= $_SESSION['posts']['id']?>'>
						</form>
					</div>
				</div> 
<?php
		}	
	} 
?>
	</div>

</body>
</html>

