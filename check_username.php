<?php
// łączenie się z bazą danych
include 'config.php';
if(isset($_POST['login'])){
	$login = $_POST['login'];
	$login = Clear($login);
	$dostepny = true;
	$result = $_SESSION['controller']->selectReaderLogin($login);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $_SESSION['controller']->selectAdminLogin($login);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!$dostepny){
		echo '<span style="color: #cc0000;"><strong>'.$login.'</strong> jest już zajęty.</span>';
	}else{
		echo 'OK';
	}
}

if(isset($_POST['email'])){
	$email = $_POST['email'];
	$email = Clear($email);
	$dostepny = true;
	$poprawny = true;
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false){
		echo '<span style="color: #cc0000;"><strong>'.$email.'</strong> jest niepoprawny.</span>';
		$poprawny = false;
	}
	$result = $_SESSION['controller']->selectReaderEmail($email);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $_SESSION['controller']->selectAdminEmail($email);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!poprawny){
		echo 'Niepoprawny';
	}else if(!$dostepny){
		echo 'Niedostepny';
	}else{
		echo 'OK';
	}
}
?>