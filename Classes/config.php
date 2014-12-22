<?php

function Clear($text) {
    // jeśli serwer automatycznie dodaje slashe to je usuwamy
    if(get_magic_quotes_gpc()) {
        $text = stripslashes($text);
    }
    $text = trim($text); // usuwamy białe znaki na początku i na końcu
    $text = mysqli_real_escape_string($text); // filtrujemy tekst aby zabezpieczyć się przed sql injection
    $text = htmlspecialchars($text); // dezaktywujemy kod html
    return $text;
}

function Codepass($password) {
    // kodujemy hasło (losowe znaki można zmienić lub całkowicie usunąć
    return sha1(md5($password).'#!%Rgd64');
}

session_start();

if(!isset($_SESSION['logged'])) {
	$_SESSION['id'] = session_id();
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "none";
	$controller->addSession(session_id(), $_SERVER['REMOTE_ADDR'], $_SESSION['user_id']);
}
 
?>