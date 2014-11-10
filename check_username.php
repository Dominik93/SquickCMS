<?php
// łączenie się z bazą danych
include 'config.php';
DbConnect();
if(isset($_POST['login'])){
	$login = $_POST['login'];
	$login = Clear($login);
	$dostepny = true;
	$result = mysql_query('SELECT readers.reader_login FROM readers WHERE reader_login = "'.$login.'";')or die(mysql_error());
	if(mysql_num_rows($result)){
		$dostepny = false;
	}
	$result = mysql_query('SELECT admins.admin_login FROM admins WHERE admin_login = "'.$login.'";')or die(mysql_error());
	if(mysql_num_rows($result)){
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
	$result = mysql_query('SELECT readers.reader_email FROM readers WHERE reader_email = "'.$email.'";')or die(mysql_error());
	if(mysql_num_rows($result)){
		$dostepny = false;
	}
	$result = mysql_query('SELECT admins.admin_email FROM admins WHERE admin_email = "'.$email.'";')or die(mysql_error());
	if(mysql_num_rows($result)){
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
DbClose();
?>