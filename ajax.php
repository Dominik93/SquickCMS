<?php
// łączenie się z bazą danych
include 'config.php';

$controller = new Controller();

if(isset($_POST['delete'])){
    $controller->deleteTableWhere("borrows", array(array("borrow_id", "=", $_POST['delete'], "")));
    echo "OK";
}

if(isset($_POST['deleteReader'])){
    $controller->deleteTableWhere("readers", array(array("reader_id", "=", $_POST['deleteReader'], "")));
    echo "OK";
}
if(isset($_POST['extendAccount'])){
    $date = date_create(date('Y-m-d'));
    date_add($date, date_interval_create_from_date_string('365 days'));    
    $controller->updateTableRecordValuesWhere("readers", 
            array(array("reader_active_account", date_format($date,"y-m-d"))),
            array(array("reader_id", "=", $_POST['extendAccount'], ""))
            );
    echo "OK";
}

if(isset($_POST['receive'])){
    $controller->updateTableRecordValuesWhere("borrows",
            array(array("borrow_received", "1")),
            array(array("borrow_id", "=", $_POST['receive'], "")));
    echo "OK";
}

if(isset($_POST['login'])){
	$login = $_POST['login'];
	$login = $controller->Clear($login);
	$dostepny = true;
	$result = $controller->selectReaderLogin($login);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectAdminLogin($login);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!$dostepny){
		echo 'Niedostępny';
	}else{
		echo 'OK';
	}
}

if(isset($_POST['email'])){
	$email = $_POST['email'];
	$email = $controller->Clear($email);
	$dostepny = true;
	$poprawny = true;
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
		echo '<span style="color: #cc0000;"><strong>'.$email.'</strong> jest niepoprawny.</span>';
		$poprawny = false;
	}
	$result = $controller->selectReaderEmail($email);
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectAdminEmail($email);
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