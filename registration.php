<?php
	include "layout.php";
	include "config.php";
	function Registration(){	
		if(CheckAdmin()){
			if(isset($_POST['login'])) {
				$_POST['name'] = Clear($_POST['name']);
				$_POST['surname'] = Clear($_POST['surname']);
				$_POST['password'] = Clear($_POST['password']);
				$_POST['password2'] = Clear($_POST['password2']);
				$_POST['email'] = Clear($_POST['email']);
				$_POST['login'] = Clear($_POST['login']);
				$_POST['adres'] = Clear($_POST['adres']);
				$_POST['date'] = Clear($_POST['date']);
			
				if(empty($_POST['name']) 
					|| empty($_POST['password1']) 
					|| empty($_POST['password2']) 
					|| empty($_POST['login'])
					|| empty($_POST['surname'])
					|| empty($_POST['email'])
					|| empty($_POST['adres'])
					|| empty($_POST['date'])
					) {
						echo '<p>Musisz wypełnić wszystkie pola.</p>';
				} elseif($_POST['password1'] != $_POST['password2']) {
					echo '<p>Podane hasła różnią się od siebie.</p>';
				} elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
					echo '<p>Podany email jest nieprawidłowy.</p>';
				} else {
					$dodaj = true;
					DbConnect();
					$result = mysql_query('SELECT Count(reader_id) FROM readers WHERE reader_login = "'.$_POST['login'].'" OR reader_email = "'.$_POST['email'].'";') or die(mysql_error());
					$row = mysql_fetch_row($result);
					if($row[0] > 0) {
						echo '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
						$dodaj = false;
					}
					$result = mysql_query('SELECT Count(admin_id) FROM admins WHERE admin_login = "'.$_POST['login'].'" OR admin_email = "'.$_POST['email'].'";') or die(mysql_error());
					$row = mysql_fetch_row($result);
					if($row[0] > 0) {
						echo '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
						$dodaj = false;
					}
					if($dodaj) {
						$result = mysql_query('SELECT * FROM acces_rights WHERE acces_right_name = "activeReader";') or die(mysql_error());
		
						if(mysql_num_rows($result) == 0) {
								die('Błąd');
						}
						$row = mysql_fetch_assoc($result);		
						mysql_query('INSERT INTO readers 
										(reader_name, reader_surname, reader_login, reader_password, reader_email, reader_address, reader_active_account, reader_acces_right_id)
								VALUES ("'.$_POST['name'].'", "'.$_POST['surname'].'", "'.$_POST['login'].'", "'.Codepass($_POST['password1']).'", "'.$_POST['email'].'", "'.$_POST['adres'].'", "'.$_POST['date'].'", '.$row['acces_right_id'].');') or die(mysql_error());
						echo '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="main_page.php">stronę główną</a>.</p>';
					}
					DbClose();
				}
			}
			else
				ShowRegistrationForm();
		}else{
			echo '<p>Nie jesteś adminem!</p>';
		}
	}
	
	function Content(){
		echo '<div id="content">';
		Registration();
		echo '</div>';
	}
	
	function ShowRegistrationForm(){
	echo '
		<div id="registration" align="center">
			<form action="registration.php" method="post">
				<table>
					<tr>Dodaj czytelnika</tr>
					<tr><td>Login:</td><td><input type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/></td></tr>
					<tr><td>E-mail:</td><td><input type="email" value="'.$_POST['email'].'" name= "email" placeholder="E-mail" required/></td></tr>
					<tr><td>Hasło:</td><td><input type="password" value="'.$_POST['password1'].'" name= "password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input type="password" value="'.$_POST['password2'].'" name= "password2" placeholder="Hasło" required/></td></tr>
					<tr><td>Imie:</td><td><input type="text" value="'.$_POST['name'].'" name= "name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input type="text" value="'.$_POST['surname'].'" name= "surname" placeholder="Nazwisko" required/></td></tr>
					<tr><td>Data ważności konta:</td><td><input type="date" value="'.$_POST['date'].'" name= "date" placeholder="YYYY-MM-DD" required/></td></tr>
					<tr><td>Adres:</td><td><input type="text" value="'.$_POST['adres'].'" name= "adres" placeholder="Adres" required/></td></tr>
				</table>
				<input type="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
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