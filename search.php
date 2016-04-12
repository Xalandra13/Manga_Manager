<?php
/*
	Manga Manager
	Search Manga
	25.02.2016, Xalandra
*/
	
	require_once('_db_inc/db_inc.php');
	
	$connection = mysqli_connect($host, $user, $password);
	
	$title = '';
	if(isset($_POST['title'])){
		$title = $_POST['title'];
	}
	
	if(mysqli_connect_errno()){
		echo "Failed to connect with db: " . mysqli_connect_error();
	} else {
		mysqli_query($connection, "SET NAMES 'utf8'");
		mysqli_query($connection, "SET CHARACTER SET 'utf8'");
		
		// select db
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
			WHERE title LIKE '%".$title."%'
		";
		
		$results = mysqli_query($connection, $query);
		
		echo '<p>Results found: '.mysqli_num_rows($results).'</p>'; 
		
		// display results
		while($row = mysqli_fetch_assoc($results)){
			echo '<div class="res">';
			echo '<a href="details.php?id='.$row['id'].'">';
			echo '<img src="images/covers/'.$row['picture'].'" alt="'.$row['alt'].'" width="100">';
			echo '</a>';
			echo '<table id="res-table"><tr>';
			echo '<td class="res-title"><a href="details.php?id='.$row['id'].'">'.$row['title'].'</a></td>';
			echo '<td class="res-right">In Possession: '.$row['in_possession'].'</td>';
			echo '</tr><tr>';
			echo '<td class="res-author">'.$row['author'].'</td>';
			echo '<td class="res-right">Status: '.$row['status'].'</td>';
			echo '</tr><tr>';
			echo '<td>'.$row['publisher'].'</td>';
			echo '<td class="res-right">'.$row['comment'].'</td>';
			echo '</tr></table>';
			echo '</div><hr>';	
		}

		// close db connection
		mysqli_close($connection);
	}	
?>