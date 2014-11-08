<?php
	include "layout.php";
	include "config.php";	
	
	function Content(){
		echo '
			<div id="content">
				<p>
					Godziny otwarcia:<br>
					Pon - Pt: 7:00 - 18:00<br>
					Sob: 9:00 - 15:00<br>
					Nd: Nieczynne
				</p>
			</div>
		';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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