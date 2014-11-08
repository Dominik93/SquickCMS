<?php
 
// definiujemy dane do połączenia z bazą danych
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'dslusarz_baza');
 
function DbConnect() {
    // połączenie z mysql
    mysql_connect(DBHOST, DBUSER, DBPASS) or die('<h2>ERROR</h2> MySQL Server is not responding');
 
    // wybór bazy danych
    mysql_select_db(DBNAME) or die('<h2>ERROR</h2> Cannot connect to specified database');
}
 
function DbClose() {
	// zamknięcie połaczenia
    mysql_close();
}
 
function Clear($text) {
    // jeśli serwer automatycznie dodaje slashe to je usuwamy
    if(get_magic_quotes_gpc()) {
        $text = stripslashes($text);
    }
    $text = trim($text); // usuwamy białe znaki na początku i na końcu
    $text = mysql_real_escape_string($text); // filtrujemy tekst aby zabezpieczyć się przed sql injection
    $text = htmlspecialchars($text); // dezaktywujemy kod html
    return $text;
}
 
function Codepass($password) {
    // kodujemy hasło (losowe znaki można zmienić lub całkowicie usunąć
    return sha1(md5($password).'#!%Rgd64');
}

function CheckLogin() {
	if($_SESSION['logged'] && ($_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])) {
		return true;
	}
	return false;
}

function CheckAdmin() {
	if($_SESSION['logged'] && ($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) && ($_SESSION['acces_right'] == "admin")) {
		return true;
	}
	return false;
}
 
 function UserIsAdmin($user_id = -1){
	if($_SESSION['acces_right'] == "admin" && ($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']))
		return true;
	return false;
 }
 
// funkcja na pobranie danych usera
function GetUserData($user_id = -1) {
	DbConnect();
    // jeśli nie podamy id usera to podstawiamy id aktualnie zalogowanego
    if($user_id == -1) {
        $user_id = $_SESSION['user_id'];
    }
	if($_SESSION['acces_right'] == "admin"){
		$result = mysql_query('SELECT admins.*, acces_rights.acces_right_name FROM admins
		join acces_rights on acces_rights.acces_right_id = admins.admin_acces_right_id
		WHERE admin_id = "'.$user_id.'" LIMIT 1;') or die(mysql_error());
	}
	else if($_SESSION['acces_right'] == "reader"){
		$result = mysql_query('SELECT readers.*, acces_rights.acces_right_name FROM readers
		join acces_rights on acces_rights.acces_right_id = readers.reader_acces_right_id
		WHERE reader_id = "'.$user_id.'" LIMIT 1;') or die(mysql_error());
	}
	else if($_SESSION['acces_right'] == "none"){
		$result = false;
	}
	DbClose();
	if(!$result){
        return false;
    }
    return mysql_fetch_assoc($result);
}

// startujemy sesje
session_start();
 
// jeśli nie ma jeszcze sesji "logged" i "user_id" to wypełniamy je domyślnymi danymi
if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "none";
	DbConnect();
	mysql_query('INSERT INTO `dslusarz_baza`.`sessions`
				(`session_ip`,
				`session_user`,
				`session_logged`,
				`session_acces_right`)
					VALUES ('.$_SERVER['REMOTE_ADDR'].', '.$_SESSION['user_id'].', "0", "none", )')
					or die(mysql_error());
	DbClose();
}
?>