<?php

	include "../config.php";
	
	session_start();
	$_SESSION['id'] = session_id();
	$_SESSION['logged'] = false;
	$_SESSION['user_id'] = -1;
	$_SESSION['acces_right'] = "user";
	$_SESSION['ip'] = null;
	$_SESSION['user'] = serialize(new User(new Controller()));
	
	function Content(){
		$user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->logout().'</div>';
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