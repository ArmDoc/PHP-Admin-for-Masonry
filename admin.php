<?
include_once 'database.php';

if(isset($_POST['button'])){
	switch($_POST['button']){
		case 'upload':
			uploadFile('img');
		break;

		case 'update':
			uploadFile('file', $_POST['id']);
		break;

		case 'delete':
			if(isset($_POST['id'])){
				$id = $_POST['id'];
				if(file_exists("./img/{$id}.jpg")){
					unlink("./img/{$id}.jpg");
				}
				$mysqli	->	query("DELETE FROM images WHERE id = {$id}");
			}
		break;
	}
}

function uploadFile($param, $id = null){
	global $mysqli;

	if(isset($_FILES[$param])){
		$name 			= $_FILES[$param]['name'];
		$color			= $_POST["color"];
		$title 			= $_POST["title"];
		$color 			= $_POST["color"];

		if($id) {
			$mysqli->query("UPDATE images SET `title` = '{$title}', `color` = '{$color}' WHERE `id` = {$id}");
		}

		if($name) {

			if(!$id) {
				$mysqli->query("INSERT INTO images(`path`, `title`, `color`, `created_at`) VALUES ('$name', '$title', '$color', NOW())");
				$id = $mysqli->insert_id;
				$mysqli->query("UPDATE images SET `path` = '{$id}.jpg',`title` = '{$title}', `color` = '{$color}' WHERE `id` = {$id}");
			}

			move_uploaded_file($_FILES[$param]['tmp_name'],"./img/{$id}.jpg");
		}
	}
}

$images = $mysqli->query("SELECT * FROM images")->fetch_all(MYSQLI_ASSOC);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MASONRY ADMIN PANEL</title>
	<link href="styles/stylesAdmin.css" rel="stylesheet">
</head>
<body>
	<h1 class="controlPanel_title">MASONRY ADMIN PANEL</h1>
	<div class="controlPanel">
			<ul class="item_list">
				<?php foreach($images as $image){ ?>
					<li >
						<form class="item" action="admin.php" method="POST" enctype="multipart/form-data">
							<img class="item_img" src='./img/<?= $image['path']; ?> ? t=<?= time() ?>'>
							<input  class = "item_title" name = "title" value="<?= $image['title']; ?>" type="text" placeholder="Заголовок">
							
							<label for="Color">Цвет рамки </label>
							<select name = "color" id="color"  >
								<option value="<?= $image['color']?>">Default <?= $image['color']?></option>
								<option value="red">red</option>
								<option value="green">green</option>
								<option value="yellow">yellow</option>
							</select>

							<input type="file" name="file" class="item_input">
							<input type="hidden" name="id" value='<?= $image['id']; ?>'>
							<div class="button">
								<button type='submit' name='button' value='update' class="button_item-refresh">Обновить</button>
								<button type='submit' name='button' value='delete' class="button_item-delete">Удалить</button>
							</div>
						</form>
					</li>
				<?php } ?>

				<li class="form">
					<form action="admin.php" method="POST" enctype="multipart/form-data">
					<input  class = "item_title" type="text" name = "title" value="" placeholder="Заголовок">
						<label for="Color">Выберите цвет рамки</label>
									<select name = "color" id="color">
										<option value=""></option>
										<option value="red">red</option>
										<option value="green">green</option>
										<option value="yellow">yellow</option>
									</select>
						<input type="file" name="img" class="form_input">
						<button type='submit' name='button' value='upload' class="button_item-delete">Загрузить</button>
					</form>
				</li>
			</ul>
	</div>
</body>
</html>