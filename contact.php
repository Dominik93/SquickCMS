<?php
    include "config.php";	
    include "layout.php";
	function Content(){
		$user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->showContact().'</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="layout.css">
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