<?php
	include "layout.php";
	include "config.php";	
	
	if(!empty($_GET['usun'])){
		DbConnect();
		if($_GET[user]){
			mysql_query('DELETE FROM readers where readers.reader_id = '.$_GET['usun'].'')or die(mysql_error());
			header('Location: manage_users.php');
		}else if($_GET[admin]){
			mysql_query('DELETE FROM admins where admins.admin_id = '.$_GET['usun'].'')or die(mysql_error());
			header('Location: manage_admins.php');
		}
		DbClose();
	}
	if(!empty($_GET['konto'])){
		DbConnect();
		$date = date_create(date('Y-m-d'));
		date_add($date, date_interval_create_from_date_string('365 days'));
		mysql_query('UPDATE readers set readers.reader_active_account = "'.date_format($date, 'Y-m-d').'" where readers.reader_id = '.$_GET['konto'].'');
		DbClose();
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
					<a>Edytuj</a>, <a href="profile.php?user='.$user['reader_id'].'&usun='.$user['reader_id'].'">Usuń</a>, <a href="profile.php?user='.$user['reader_id'].'&konto='.$user['reader_id'].'">Przedłuż ważność konta</a>
				</p>
			</div>
		';
	}
	
	function ShowDetailsAdmin($user){
		echo '
			<div id="content">
				<p>
					ID: '.$user['admin_id'].'<br>
					Imie: '.$user['admin_name'].'<br>
					Nazwisko: '.$user['admin_surname'].'<br>
					Login: '.$user['admin_login'].'<br>
					Email: '.$user['admin_email'].'<br>
					Prawa: '.$user['acces_right_name'].'<br>					
					<a>Edytuj</a>, <a href="profile.php?admin='.$user['admin_id'].'&usun='.$user['admin_id'].'">Usuń</a>, <a href="profile.php?user='.$user['admin_id'].'&konto='.$user['admin_id'].'">Przedłuż ważność konta</a>
				</p>
			</div>
		';
	}
	
	function Content(){
		
		if(!CheckAdmin()){
			echo '
			<div id="content">
				<p>Nie masz dostępu!</p>
			</div>
			';
		}else{
			if($_GET[user]){
				$user = GetReaderData($_GET[user]);
				ShowDetailsReaders($user);
			}else if($_GET[admin]){
				$user = GetAdminData($_GET[admin]);
				ShowDetailsAdmin($user);
			}
		}
		
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