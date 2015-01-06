<?php

	include "../config.php";	
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            echo '<div id="content">'.$user->showAddBookForm();
            if(isset($_POST['isbn'])){
                echo $user->addBook($_POST['isbn'], $_POST['title'], $_POST['publisher_house'], $_POST['nr_page'],
                        $_POST['edition'], $_POST['premiere'], $_POST['number'], $_POST['author']);
            }
            echo '</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
		<title>Biblioteka PAI</title>
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>