<?php
/*
	Manga Manager
	Search Mangas, Display Results
	Add New Manga
	21.03.2016, Xalandra
	
*/
	
	require_once('_db_inc/db_inc.php');
	
	$connection = mysqli_connect($host, $user, $password);
	
	if(mysqli_connect_errno()){
		echo "Failed to connect with db: " . mysqli_connect_error();
	} else {
		mysqli_query($connection, "SET NAMES 'utf8'");
		mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		mysqli_select_db($connection, $database);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Manga Manager</title>
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
				<li><a href="#tabs-1">Search</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="#tabs-3">Add</a></li>
			</ul>
			<div id="tabs-1">
				<h2>Search Manga</h2>
				<form>
					<input type="text" name="title" id="title" size="60">
					<input type="button" name="searchBtn" id="searchBtn" value="Search">
				</form>
				<div id="results"></div>
			</div>
			<div id="tabs-3">
				<h2>Add New Manga</h2>
				<form id="addForm" method="post" action="insert.php" enctype="multipart/form-data" accept-charset="UTF-8">
				<table class="form-table">
					<tr>
						<td>Title:</td>
						<td><input type="text" name="title" id="addTitle" size="30"></td>
					</tr>
					<tr>
						<td>In Possession:</td>
						<td>
							<select name="in_possession">
								<option value=""></option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Status:</td>
						<td>
							<select name="status">
								<option value=""></option>
								<option value="read">read</option>
								<option value="to read">to read</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Comment:</td>
						<td><input type="text" name="comment" size="30"></td>
					</tr>
					<tr>
						<td>Picture:</td>
						<td><input type="file" name="picture"></td>
					</tr>
					<tr>
						<td>Alt. Text:</td>
						<td><input type="text" name="alt" size="30"></td>
					</tr>
					<tr>
						<td>Author:</td>
						<td>
						<?php
							// dropdown menu author
							echo '<select name="author">';
							echo '<option value=""></option>';
							$queryAuthor = "SELECT * FROM authors";
							$resAuthor = mysqli_query($connection, $queryAuthor);
							while($rowAuthor = mysqli_fetch_assoc($resAuthor)){
								echo "<option value=".$rowAuthor['a_id'].">".$rowAuthor['author']."</option>";
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
							echo '<option value=""></option>';
							$queryPublisher = "SELECT * FROM publishers";
							$resPublisher = mysqli_query($connection, $queryPublisher);
							while($rowPublisher = mysqli_fetch_assoc($resPublisher)){
								echo "<option value=".$rowPublisher['p_id'].">".$rowPublisher['publisher']."</option>";
							}
							echo '</select>';
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="add" value="Add"></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>