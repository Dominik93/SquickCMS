<?php

	include '../config.php';

	function Content(){
		$user = unserialize($_SESSION['user']);
		
                if(isset($_POST['login'])){
                    echo '<div id="content">'.$user->login($_POST['login'], $_POST['password']).'</div>';
                }
                else {
                    echo '<div id="content">'.$user->showLogin().'</div>';
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