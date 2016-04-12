<?php
/*
	Manga Manager
	Edit Manga Details
	01.03.2016, Xalandra
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
	<title>Edit Manga Details</title>
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
				<h2>Edit Manga Details</h2>
				<form method="post" action="update.php" enctype="multipart/form-data" accept-charset="UTF-8">
					<input type="hidden" name="mode" value="Update">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
					<input type="hidden" name="oldPictureName" value="<?php echo $row['picture']; ?>">
					<table class="form-table">
						<tr>
							<td>Title:</td>
							<td><input type="text" name="title" value="<?php echo $row['title']; ?>" size="30"></td>
						</tr>
						<tr>
							<td>In Possession:</td>
							<td>
							<?php
								// dropdown menu in possession
								$possession = array('yes', 'no');
								
								echo '<select name="in_possession">';
								foreach($possession as $in_possession){
									if($row['in_possession'] == $in_possession){
										echo '<option value="'.$in_possession.'" selected>'.$in_possession.'</option>';
									} else {
										echo '<option value="'.$in_possession.'">'.$in_possession.'</option>';
									}
								}
								echo '</select>';
							?>
							</td>
						</tr>
						<tr>
							<td>Status:</td>
							<td>
							<?php
								// dropdown menu status
								$statuses = array('read', 'to read');
								
								echo '<select name="status">';
								foreach($statuses as $status){
									if($row['status'] == $status){
										echo '<option value="'.$status.'" selected>'.$status.'</option>';
									} else {
										echo '<option value="'.$status.'">'.$status.'</option>';
									}
								}
								echo '</select>';
							?>
							</td>
						</tr>
						<tr>
							<td>Comment:</td>
							<td><input type="text" name="comment" value="<?php echo $row['comment']; ?>" size="30"></td>
						</tr>
						<tr>
							<td>Picture:</td>
							<td>
								<input type="file" name="picture">
							</td>
						</tr>
						<tr>
							<td>Alt. Text:</td>
							<td><input type="text" name="alt" value="<?php echo $row['alt']; ?>" size="30"></td>
						</tr>
						<tr>
							<td>Author:</td>
							<td>
							<?php
								// dropdown menu author
								echo '<select name="author">';
								
								$queryAuthor = "SELECT * FROM authors";
								$resAuthor = mysqli_query($connection, $queryAuthor);
								while($rowAuthor = mysqli_fetch_assoc($resAuthor)){
									if($row['author'] == $rowAuthor['author']){
										echo "<option value=".$rowAuthor['a_id']." selected>".$rowAuthor['author']."</option>";
									} else {
										echo "<option value=".$rowAuthor['a_id'].">".$rowAuthor['author']."</option>";
									}
								}
								echo '</select>';
							?>
							</td>
						</tr>
						<tr>
							<td>Publisher:</td>
							<td>
							<?php
								// dropdown menu publisher
								echo '<select name="publisher">';
								
								$queryPublisher = "SELECT * FROM publishers";
								$resPublisher = mysqli_query($connection, $queryPublisher);
								while($rowPublisher = mysqli_fetch_assoc($resPublisher)){
									if($row['publisher'] == $rowPublisher['publisher']){
										echo "<option value=".$rowPublisher['p_id']." selected>".$rowPublisher['publisher']."</option>";
									} else {
										echo "<option value=".$rowPublisher['p_id'].">".$rowPublisher['publisher']."</option>";
									}
								}
								echo '</select>';
							?>
							</td>
						</tr>
						<tr>
							<td class="icon-edit">
								<a href="details.php?id=<?php echo $id; ?>" class="tooltip" title="Back">
									<img src="images/icons/back.png">
								</a>
							</td>
							<td><input type="submit" name="update" value="Update"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>