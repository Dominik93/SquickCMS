<?php
	include "layout.php";
	include "config.php";	
	
	function ShowAdmins(){
		DbConnect();
		$result = mysql_query('SELECT *, acces_rights.acces_right_name FROM admins join acces_rights on acces_rights.acces_right_id = admins.admin_acces_right_id ;') or die(mysql_error());
		DbClose();
		if(mysql_num_rows($result) == 0) {
			echo 'Brak użytkowników<br>';
		}else{
			echo '
				<div id="usersTable" align="center">
				<table>
					<tr> <td>ID</td> <td>Login</td> <td>Email</td> <td>Imie</td> <td>Nazwisko</td> </tr>
				';
			while($row = mysql_fetch_assoc($result)) {
				echo '<tr onClick="location.href=\'http://localhost/~dominik/Library/profile.php?admin='.$row['admin_id'].'\'" /> <td>'.$row['admin_id'].'</td> <td>'.$row['admin_login'].'</td> <td>'.$row['admin_email'].'</td> <td>'.$row['admin_name'].'</td> <td>'.$row['admin_surname'].'</td> </tr>';
			}
			echo '<tr> <td align="center" colspan = 5 ><a href="registration_admin.php">Dodaj</a></td> </tr></table>';
		}
	}
	
	
	function Content(){
		echo '
			<div id="content">
				<p>';
				if(CheckAdmin())
					ShowAdmins();
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