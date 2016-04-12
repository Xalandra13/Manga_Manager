<?php
/*
	Manga Manager
	Delete Manga
	03.03.2016, Xalandra
*/
	
	$id = $_GET['id'];
	
	require_once('_db_inc/db_inc.php');
	
	$connection = mysqli_connect($host, $user, $password);
	
	if(mysqli_connect_errno()){
		echo "Failed to connect with db: " . mysqli_connect_error();
	} else {
		mysqli_query($connection, "SET NAMES 'utf8'");
		mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		
		mysqli_select_db($connection, $database);
		
		$query = "SELECT * FROM mangas WHERE id = $id";
		$results = mysqli_query($connection, $query);
		$row = mysqli_fetch_array($results);
		
		unlink("images/covers/$row[picture]");
		
		$query = "
			DELETE FROM mangas
			WHERE id = $id
		";
		
		mysqli_query($connection, $query);
		
		/* Redirect browser */
		header("Location: http://localhost/manga_manager/index.php");
		
		/* Make sure that code below does not get executed when we redirect */
		exit;
		
		mysqli_close($connection);
	}
?>