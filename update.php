<?php
/*
	Manga Manager
	Update Manga Details
	03.03.2016, Xalandra
*/
	
	require_once('_db_inc/db_inc.php');
	
	$connection = mysqli_connect($host, $user, $password);
	
	if(mysqli_connect_errno()){
		echo "Failed to connect with db: " . mysqli_connect_error();
	} else {
		mysqli_query($connection, "SET NAMES 'utf8'");
		mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		
		mysqli_select_db($connection, $database);
		
		if(isset($_POST['mode']) AND $_POST['mode'] == 'Update'){
			
			$id 			= $_POST['id'];
			$title 			= $_POST['title'];
			$in_possession	= $_POST['in_possession'];
			$status 		= $_POST['status'];
			$comment 		= $_POST['comment'];
			
			$query = "
				UPDATE mangas
				SET title = '$title', 
					in_possession = '$in_possession', 
					status = '$status',
					comment = '$comment'
			";
			
			// check file input
			if($_FILES['picture']['name'] != ''){
				if(isset($_POST['oldPictureName']) AND $_POST['oldPictureName'] != ''){
					unlink('images/covers/'.$_POST['oldPictureName']);
				}
				
				$picture = $_FILES['picture']['name'];
				move_uploaded_file($_FILES['picture']['tmp_name'], 'images/covers/'.$picture);
				
				$query .= ", picture = '$picture'";
			}
			
			$alt		= $_POST['alt'];
			$author		= $_POST['author'];
			$publisher  = $_POST['publisher'];
			
			$query .= ", alt = '$alt', 
					a_id = $author,
					p_id = $publisher					
				WHERE id = $id
			";
			
			mysqli_query($connection, $query);
			
			/* Redirect browser */
			header("Location: http://localhost/manga_manager/details.php?id=".$id);
			
			/* Make sure that code below does not get executed when we redirect */
			exit;
		}
	}
?>