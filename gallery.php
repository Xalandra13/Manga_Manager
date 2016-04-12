<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Manga Gallery</title>
	<link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/manga.css" type="text/css">
	<link rel="stylesheet" href="lib/lightbox/css/lightbox.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="lib/lightbox/js/lightbox.js"></script>
	<script src="js/myFunctions.js"></script>
</head>
<body>
	<h2>Manga Gallery</h2>
	<div id="gallery">
	<?php
		// Format ersetzen für Bildtitel
		$replace1 = array('.jpeg' => '', '.jpg' => '', '.png' => '', '.gif' => '', '_' => ' ');
		
		// Umlaute ersetzen für Bildtitel
		$replace2 = array('ae' => 'ä', 'oe' => 'ö', 'ue' => 'ü', 'Ae' => 'Ä', 'Oe' => 'Ö', 'Ue' => 'Ü');
		
		// alle Dateien in Array laden
		$files = scandir('images/covers');

		// jeden Eintrag im Array verarbeiten
		foreach($files as $file){
			
			// nur Dateien, keine Unterverzeichnisse
			if(is_file('images/covers/' . $file)){
				
				// Bildtitel aufbereiten
				$text = strtr($file, $replace1);
				$text = ucwords($text);
				$text = strtr($text, $replace2);
				
				// Ausgabe
				echo '<div class="image">';
				echo "<a href=\"images/covers/$file\" data-lightbox=\"gallery\" title=\"$text\">\n";
				echo "<img src=\"images/covers/$file\" alt=\"$text\" width=\"100\" />\n";
				echo "</a>\n";
				echo "<p>$text</p>\n";
				echo "</div>\n";
			}
		}
	?>
	</div>
</body>
</html>