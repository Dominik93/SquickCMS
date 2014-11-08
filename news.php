<?php
	include "config.php";
	include "layout.php";
	
	function Content(){
		DbConnect();
		$result = mysql_query('SELECT * FROM dslusarz_baza.news LIMIT 10')
		or die(mysql_error());
		
		echo '
			<div id="content">
				<p>';
		if(mysql_num_rows($result) == 0) {
				echo 'Brak newsów<br>';
		}else
			while($row = mysql_fetch_assoc($result)) {
					echo $row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
					if(CheckAdmin()){
						echo 'Usuń<br>';
					}
					else{
						echo '<br>';
					}
			}		
		echo '</p>
			</div>
		';
		DbClose();
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