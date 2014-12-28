<?php
	include "config.php";
	include "layout.php";
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            echo '<div id="content">';
            echo $user->showRegistrationAdmin();
            if(isset($_POST['login'])){
                echo $user->addAdmin($_POST['name'], $_POST['surname'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['login']);
            }
            
            echo '</div>';
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
						url: "ajax.php",
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
						url: "ajax.php",
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