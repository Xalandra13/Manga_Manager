<?php
/*
	Manga Manager
	Insert New Manga Into Database
	02.03.2016, Xalandra
*/
	
	require_once('_db_inc/db_inc.php');
	
	$connection = mysqli_connect($host, $user, $password);

	if(mysqli_connect_errno()){
		echo "Failed to connect with db: " . mysqli_connect_error();
	} else {
		mysqli_query($connection, "SET NAMES 'utf8'");
		mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		
		// select db
		mysqli_select_db($connection, $database);
		
		$title 			= $_POST['title'];
		$in_possession 	= $_POST['in_possession'];
		$status 		= $_POST['status'];
		$comment 		= $_POST['comment'];
		$picture		= $_FILES['picture']['name'];
		$alt			= $_POST['alt'];
		$author			= $_POST['author'];
		$publisher		= $_POST['publisher'];
		
		// move picture
		move_uploaded_file($_FILES['picture']['tmp_name'], 'images/covers/'.$picture);
		
		$query = "
			INSERT INTO mangas
			(title, in_possession, status, comment, picture, alt, a_id, p_id)
			VALUES
			('$title', '$in_possession', '$status', '$comment', '$picture', '$alt', $author, $publisher)
		";
		
		$results = mysqli_query($connection, $query);
		
		/* Redirect browser */
		header("Location: http://localhost/manga_manager/index.php");
		
		/* Make sure that code below does not get executed when we redirect */
		exit;
		
		// close db connection
		mysqli_close($connection);
	}	
?>