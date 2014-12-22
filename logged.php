<?php
	include "layout.php";
	include "config.php";	
	
	function ShowUsers(){
		$result = $controller->selectSession();
		if(mysqli_num_rows($result) == 0) {
			echo 'Brak zalogowanych<br>';
		}else{
			echo '
				<div id="loggedTable" align="center">
				<table>
					<tr> <td>Session ID</td> <td>IP</td> <td>User</td> <td>Logged</td> <td>Rights</td> <td>Last action</td> </tr>
				';
			while($row = mysqli_fetch_array($result)) {
				echo '<tr> <td>'.$row['session_id'].'</td> <td>'.$row['session_ip'].'</td> <td>'.$row['session_user'].'</td> <td>'.$row['session_logged'].'</td> <td>'.$row['session_acces_right'].'</td> <td>'.$row['session_last_action'].'</td> </tr>';
			}
		}
	}
	
	
	function Content(){
		echo '
			<div id="content">
				<p>';
				if(CheckAdmin())
					ShowUsers();
				else{
					echo 'Nie masz uprawnien!';
				}
		echo '</p>
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