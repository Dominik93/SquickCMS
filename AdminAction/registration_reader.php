<?php

	include "../config.php";
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            if(isset($_POST['login'])) {
                echo '<div id="content">'.$user->addReader($_POST['login'],
					$_POST['email'],
					$_POST['name'],
					$_POST['surname'],
					$_POST['password1'],
					$_POST['password2'],
					$_POST['adres']).'</div>';			
            }
            else{
                echo '<div id="content">'.$user->showRegistrationReader().'</div>';
            }
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
	
	<script type="text/javascript">

		function allFill(){
			if( document.getElementById("surname").value != "" &&
				document.getElementById("name").value != "" &&
				document.getElementById("login").value != "" &&
				document.getElementById("password1").value != "" &&
				document.getElementById("password2").value != "" &&
				document.getElementById("adres").value != "" &&
				document.getElementById("email").value != "" 
				) return true;
			return false;
		}
		
		function checkEmail(){
                    var email = $("#email").val();
                    if(email.length > 4){
                    $("#status_email").html('Sprawdzanie dostępności.');
                    $("#status_email").load("../ajax.php",{ email:email },
                                            function(responseTxt,statusTxt,xhr){
                                                if(statusTxt=="success"){
                                                    if(responseTxt == "OK"){
                                                        $("#email").removeClass("red");
                                                        $("#email").addClass("green");
                                                        $("#status_email").html('<font color="Green">Dostępny</font>');
                                                    }
                                                    else if(responseTxt == 'Niedostępny'){
                                                        $("#email").removeClass("green");
                                                        $("#email").addClass("red");
                                                        $("#status_email").html('<font color="Red">Niedostepny</font>');
                                                    }
                                                    else{
                                                        $("#email").removeClass("green");
                                                        $("#email").addClass("red");
                                                        $("#status_email").html('<font color="Red">Niepoprawny</font>');			
                                                    }
                                                }
                                                if(statusTxt=="error")
                                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                                            });
				}else{
					$("#email").addClass("red");
					$("#status_email").html('<font color="#cc0000">Za mało znaków</font>');
					return false;
				}
		}
		
		function checkLogin(){
				var login = $("#login").val();
				if(login.length > 4){
					$("#status_login").html('Sprawdzanie dostępności.');
                                        $("#status_login").load("../ajax.php",{ login: login },
                                            function(responseTxt,statusTxt,xhr){
                                                if(statusTxt=="success"){
                                                    if(responseTxt == "OK"){
                                                        $("#login").removeClass("red");
                                                        $("#login").addClass("green");
                                                        $("#status_login").html('<font color="Green">Dostępny</font>');
                                                    }
                                                    else if(responseTxt == 'Niedostępny'){
                                                        $("#login").removeClass("green");
                                                        $("#login").addClass("red");
                                                        $("#status_login").html('<font color="Red">Niedostepny</font>');
                                                    }else{
                                                        $("#login").removeClass("green");
                                                        $("#login").addClass("red");
                                                        $("#status_login").html('<font color="Red">Niepoprawny</font>');
                                                    }
                                                }
                                                if(statusTxt=="error")
                                                    alert("Error: "+xhr.status+": "+xhr.statusText);
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