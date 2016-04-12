<?php
/*
	Manga Manager
	Manga Details
	26.02.2016, Xalandra
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
		
		$query = "
			SELECT
				mangas.id,
				mangas.title,
				mangas.in_possession,
				mangas.status,
				mangas.comment,
				mangas.picture,
				mangas.alt,
				authors.author,
				publishers.publisher
			FROM mangas
			INNER JOIN authors
			ON mangas.a_id = authors.a_id
			INNER JOIN publishers
			ON mangas.p_id = publishers.p_id
			WHERE id = $id
		";
		
		$results = mysqli_query($connection, $query);
		
		if(mysqli_num_rows($results) == 0){
			/* Redirect browser */
			header("Location: http://localhost/manga_manager/error404.php");
			
			/* Make sure that code below does not get executed when we redirect */
			exit;
		}
		
		$row = mysqli_fetch_assoc($results);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Manga Details</title>
	<link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/manga.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="js/myFunctions.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<a href="index.php"><img src="images/img/vk_logo.jpg"></a>
			<div id="header-title">
				<h1>Manga Manager</h1>
			</div>
		</div>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Details</a></li>
			</ul>
			<div id="tabs-1">
				<h2>Manga Details</h2>
				<table class="form-table">
					<tr>
						<td>Title:</td>
						<td width="200"><?php echo $row['title']; ?></td>
					</tr>
					<tr>
						<td>In Possession:</td>
						<td><?php echo $row['in_possession']; ?></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td><?php echo $row['status']; ?></td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><?php echo $row['comment']; ?></td>
					</tr>
					<tr>
						<td>Picture:</td>
						<td><img src="images/covers/<?php echo $row['picture']; ?>" alt="<?php echo $row['alt']; ?>" width="150"></td>
					</tr>
					<tr>
						<td>Alt. Text:</td>
						<td><?php echo $row['alt']; ?></td>
					</tr>
					<tr>
						<td>Author:</td>
						<td><?php echo $row['author']; ?></td>
					</tr>
					<tr>
						<td>Publisher:</td>
						<td><?php echo $row['publisher']; ?></td>
					</tr>
				</table>
				<table>
					<tr>
						<td class="icons-details">
							<a href="index.php" class="tooltip" title="Home">
								<img src="images/icons/home.png">
							</a>
						</td>
						<td class="icons-details">
							<a href="edit.php?id=<?php echo $row['id']; ?>" class="tooltip" title="Edit">
								<img src="images/icons/edit.png">
							</a>
						</td>
						<td class="icons-details">
							<a href="delete.php?id=<?php echo $row['id']; ?>" class="confirm tooltip" title="Delete">
								<img src="images/icons/delete.png">
							</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>