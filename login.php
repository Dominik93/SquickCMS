<?php
	include 'layout.php';
	include "config.php";	
	
	function Login(){
		if(!$_SESSION['logged']) {
			if(isset($_POST['login'])) {
				$_POST['login'] = Clear($_POST['login']);
				$_POST['password'] = Clear($_POST['password']);
				DbConnect();
				$result = mysql_query('SELECT admin_id FROM admins WHERE admin_login = "'.$_POST['login'].'" AND admin_password = "'.Codepass($_POST['password']).'" LIMIT 1;');
				if(mysql_num_rows($result) > 0) {
					$row = mysql_fetch_assoc($result);
					$_SESSION['logged'] = true;
					$_SESSION['user_id'] = $row['admin_id'];
					$_SESSION['acces_right'] = "admin";
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
					mysql_query('INSERT INTO `dslusarz_baza`.`sessions`
								(`session_ip`,
								`session_user`,
								`session_logged`,
								`session_acces_right`)
									VALUES ("'.$_SERVER['REMOTE_ADDR'].'", '.$row['admin_id'].', "1", "admin")')
									or die(mysql_error());
					
					echo '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="main_page.php">stronę główną</a>.</p>';
					header('Location: main_page.php');
				} else {
					$result = mysql_query('SELECT reader_id FROM readers WHERE reader_login = "'.$_POST['login'].'" AND reader_password = "'.Codepass($_POST['password']).'" LIMIT 1;') or die(mysql_error());
					if(mysql_num_rows($result) > 0) {
						$row = mysql_fetch_assoc($result);
						$_SESSION['logged'] = true;
						$_SESSION['user_id'] = $row['reader_id'];
						$_SESSION['acces_right'] = "reader";
						$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
						mysql_query('INSERT INTO `dslusarz_baza`.`sessions`
								(`session_ip`,
								`session_user`,
								`session_logged`,
								`session_acces_right`)
									VALUES ("'.$_SERVER['REMOTE_ADDR'].'", '.$row['reader_id'].', "1", "reader")')
									or die(mysql_error());
						echo '<p>Witaj jesteś czytelnikiem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="main_page.php">stronę główną</a>.</p>';
					}else{
						echo '<p>Podany login i/lub hasło jest nieprawidłowe.</p>';
						ShowLoginForm();
					}
				}
				DbClose();
			}
			else
				ShowLoginForm();
		} else {
			echo '<p>Jesteś już zalogowany, więc nie możesz się zalogować ponownie.</p>
			<p>[<a href="main_page.php">Powrót</a>]</p>';
		}
	}
	
	function ShowLoginForm(){
	echo '<div id="login" align="center">
		<form action="login.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Logowanie:</tf><tr>
				<tr><td>Login:</td><td><input type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/></td></tr>
				<tr><td>Hasło:</td><td><input type="password" value="'.$_POST['password'].'" name="password" placeholder="Hasło" required/></td></tr>
				<tr> <td colspan = 2><a href="remind_password.php">Zapomniałeś hasła?</a></tf><tr>
			</table>
			<input type="submit" value="Zaloguj">
		</form>
	</div>';
	}
	
	function Content(){
		echo '<div id="content">';
			Login();
		echo '</div>
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