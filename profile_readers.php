<?php
	include "layout.php";
	include "config.php";	
	
	if(!empty($_GET['usun'])){
/*
	dopisać sprawdzanie czy użytkownik ma wypożyczenia !!
*/	
		$controller->deleteReader($_GET['usun']);
		header('Location: manage_users.php');
	}
	if(!empty($_GET['konto'])){
		$date = date_create(date('Y-m-d'));
		date_add($date, date_interval_create_from_date_string('365 days'));
		$controller->updateReader($_GET['konto'], date_format($date, 'Y-m-d'));
	}
	
	function ShowDetailsReaders($user){
		echo '
			<div id="content">
				<p>
					ID: '.$user['reader_id'].'<br>
					Imie: '.$user['reader_name'].'<br>
					Nazwisko: '.$user['reader_surname'].'<br>
					Login: '.$user['reader_login'].'<br>
					Email: '.$user['reader_email'].'<br>
					Konto aktywne do: '.$user['reader_active_account'].'<br>
					Adres: '.$user['reader_address'].'<br>	
					Prawa: '.$user['acces_right_name'].'<br>					
					<a>Edytuj</a>,
					<a href="profile_readers.php?id='.$user['reader_id'].'&usun='.$user['reader_id'].'">Usuń</a>,
					<a href="profile_readers.php?id='.$user['reader_id'].'&konto='.$user['reader_id'].'">Przedłuż ważność konta</a>
				</p>
			</div>
		';
	}
	
    function Content(){
        $user = unserialize($_SESSION['user']);
	echo '<div id="content">'.$user->showReader($_GET[id]).'</div>';
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