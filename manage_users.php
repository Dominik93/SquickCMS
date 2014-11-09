<?php
	include "layout.php";
	include "config.php";	
	
	function ShowUsers(){
		DbConnect();
		$result = mysql_query('SELECT *, acces_rights.acces_right_name FROM readers join acces_rights on acces_rights.acces_right_id = readers.reader_acces_right_id ;') or die(mysql_error());
		DbClose();
		if(mysql_num_rows($result) == 0) {
			echo 'Brak użytkowników<br>';
		}else{
			echo '
				<div id="usersTable" align="center">
				<table>
					<tr> <td>ID</td> <td>Login</td> <td>Email</td> <td>Imie</td> <td>Nazwisko</td> <td>Data ważności konta</td> <td>Prawa</td> <td>Adres</td> </tr>
				';
			while($row = mysql_fetch_assoc($result)) {
				echo '<tr onClick="location.href=\'http://192.168.1.103/~dominik/Library/profile.php?user='.$row['reader_id'].'\'" /> <td>'.$row['reader_id'].'</td> <td>'.$row['reader_login'].'</td> <td>'.$row['reader_email'].'</td> <td>'.$row['reader_name'].'</td> <td>'.$row['reader_surname'].'</td> <td>'.$row['reader_active_account'].'</td> <td>'.$row['acces_right_name'].'</td> <td>'.$row['reader_address'].'</td> </tr>';
			}
			echo '</table>';
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