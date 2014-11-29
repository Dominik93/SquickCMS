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
			
				if(empty($_POST['name']) 
					|| empty($_POST['password1']) 
					|| empty($_POST['password2']) 
					|| empty($_POST['login'])
					|| empty($_POST['surname'])
					|| empty($_POST['email'])
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
					if(strlen($_POST['login']) < 4){
						echo '<p>Za mało znaków.</p>';
						$dodaj = false;
					}
					$result = mysql_query('SELECT Count(admin_id) FROM admins WHERE admin_login = "'.$_POST['login'].'" OR admin_email = "'.$_POST['email'].'";') or die(mysql_error());
					$row = mysql_fetch_row($result);
					if($row[0] > 0) {
						echo '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
						$dodaj = false;
					}
					if($dodaj) {
						$result = mysql_query('SELECT * FROM acces_rights WHERE acces_right_name = "admin";') or die('blad '.mysql_error());
		
						if(mysql_num_rows($result) == 0) {
								die('Błąd');
						}
						$row = mysql_fetch_assoc($result);		
						mysql_query('INSERT INTO admins 
										(admin_name, admin_surname, admin_login, admin_password, admin_email, admin_acces_right_id)
								VALUES ("'.$_POST['name'].'", "'.$_POST['surname'].'", "'.$_POST['login'].'", "'.Codepass($_POST['password1']).'", "'.$_POST['email'].'", '.$row['acces_right_id'].');') or die('blad2 '.mysql_error());
						echo '<p>Admin został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="main_page.php">stronę główną</a>.</p>';
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
			<form action="registration_admin.php" method="post">
				<table>
					<tr>Dodaj admina</tr>
					<tr><td>Login:</td><td><input id="login" type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj admina">
			</form>
		</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="layout.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
	
	<script type="text/javascript">

		function allFill(){
			if( document.getElementById("surname").value != "" &&
				document.getElementById("name").value != "" &&
				document.getElementById("login").value != "" &&
				document.getElementById("password1").value != "" &&
				document.getElementById("password2").value != "" &&
				document.getElementById("email").value != "" 
				) return true;
			return false;
		}
		
		function checkEmail(){
				var email = $("#email").val();
				var msgbox = $("#status_email");
				if(email.length > 4){
					$("#status_email").html('Sprawdzanie dostępności.');
					$.ajax({
						type: "POST",
						url: "check.php",
						data: "email="+ email,
						success: function(msg){
							$("#status_email").ajaxComplete(function(event, request){
								if(msg == 'OK'){
									$("#email").removeClass("red");
									$("#email").addClass("green");
									msgbox.html('<font color="Green">Dostępny</font>');
									return true;
								}else if(msg == 'Niedostępny'){
									$("#email").removeClass("green");
									$("#email").addClass("red");
									msgbox.html('<font color="Red">Niedostepny</font>');
									return false;
								}else{
									$("#email").removeClass("green");
									$("#email").addClass("red");
									msgbox.html('<font color="Red">Niepoprawny</font>');
									return false;
								}
							});
						}
					});
				}else{
					$("#email").addClass("red");
					$("#status_email").html('<font color="#cc0000">Za mało znaków</font>');
					return false;
				}
		}
		
		function checkLogin(){
				var login = $("#login").val();
				var msgbox = $("#status_login");
				if(login.length > 4){
					$("#status_login").html('Sprawdzanie dostępności.');
					$.ajax({
						type: "POST",
						url: "check.php",
						data: "login="+ login,
						success: function(msg){
							$("#status_login").ajaxComplete(function(event, request){
								if(msg == 'OK'){
									$("#login").removeClass("red");
									$("#login").addClass("green");
									msgbox.html('<font color="Green">Dostępny</font>');
									return true;
								}else if(msg == 'Niedostępny'){
									$("#login").removeClass("green");
									$("#login").addClass("red");
									msgbox.html('<font color="Red">Niedostepny</font>');
									return false;
								}
							});
						}
					});
				}else{
					$("#login").addClass("red");
					$("#status_login").html('<font color="#cc0000">Za mało znaków</font>');
					return false;
				}
		}
		
		$(document).ready(function(){
			$password = false;
			$email = false;
			$login = false;
		
			document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			
			$("#surname").change(function(){
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			$("#name").change(function(){
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			$("#password1").change(function(){
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			$("#password2").change(function(){
				msg = $("#status_password");
				if(document.getElementById("password1").value == document.getElementById("password2").value){
					$("#password1").removeClass("red");
					$("#password1").addClass("green");
					$("#password2").removeClass("red");
					$("#password2").addClass("green");
					msg.html('<font color="Green">Prawidołowy</font>');
					$password = true;
				}else{
					$("#password1").removeClass("green");
					$("#password1").addClass("red");
					$("#password2").removeClass("green");
					$("#password2").addClass("red");
					msg.html('<font color="Red">Nieprawidłowy</font>');
				}
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			$("#adres").change(function(){
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			
			$("#login").change(function(){
				$login = !checkLogin();
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
			
			$("#email").change(function(){
				$email = !checkEmail();
				document.getElementById("submit").disabled = !allFill() || !$password || !$email || !$login;
			});
		});
	</script>
	
	
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>