<?php
include "controller.php";
include "special_user.php";

function Codepass($password) {
    return sha1(md5($password).'#!%Rgd64');
}

session_start();

if(!isset($_SESSION['logged'])) {
	$_SESSION['id'] = session_id();
        $_SESSION['logged'] = false;
        $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "user";
	$_SESSION['user'] = serialize(new User(new Controller()));
}

/*
 * dodac w tabeli borrows 1 pola boolean na odebrano książke
 * przyciski do borrow odebrano(zmienia wartość) i oddano(usuwa borrow)
 * 
 * przegladanie swoich borrows
 * 
 * eventy na fees przy przekroczeniu czasu
 */
?>