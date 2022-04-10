<?php
	include_once 'database.php';
	
	$images 	= $mysqli->query("SELECT * FROM images")->fetch_all(MYSQLI_ASSOC);

	$mysqli	->	close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="styles/stylesAdmin.css" rel="stylesheet">
	<title>MASONRY</title>
</head>
<body>
	<ul class='masonry masonry--one'>
		<?php foreach($images as $image){?>
			<li class='masonry__item'>
				<img class='masonry__image' style="border: 5px solid <?= $image['color']?>" src='./img/<?= $image['path']; ?>' alt='No Photo'/>
			</li>
		<?php } ?>
	</ul>
	
<script src="scripts/masonry.js"></script>
<script src="scripts/scripts.js"></script>
</body>
</html>