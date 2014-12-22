<?php
	include "layout.php";
	include "config.php";	
	
	function ShowUsers(){
		$result = $controller->selectReaders();
		if(mysqli_num_rows($result) == 0) {
			echo 'Brak użytkowników<br>';
		}else{
			echo '
				<div id="usersTable" align="center">
				<table>
					<tr> <td>ID</td> <td>Login</td> <td>Email</td> <td>Imie</td> <td>Nazwisko</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				echo '<tr onClick="location.href=\'http://localhost/~dominik/Library/profile_readers.php?id='.$row['reader_id'].'\'" /> <td>'.$row['reader_id'].'</td> <td>'.$row['reader_login'].'</td> <td>'.$row['reader_email'].'</td> <td>'.$row['reader_name'].'</td> <td>'.$row['reader_surname'].'</td> </tr>';
			}
			echo '<tr> <td align="center" colspan = 5 ><a href="registration_reader.php">Dodaj</a></td> </tr></table>';
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