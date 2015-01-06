<?php

	include "../config.php";	
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            if($_POST['orderHidden'] == 1){
                echo '<div id="content">'.$user->orderBook($_GET['book']).'</div>';
            }
            else{
                echo '<div id="content">'.$user->showBook($_GET['book']).'</div>';
            }
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