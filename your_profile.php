<?php
	include "layout.php";
	include "config.php";	
	
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
				</p>
			</div>
		';
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
				</p>
			</div>
		';
	}
	
	function Content(){
		$user = GetUserData();
		if($user == false){
			echo '
			<div id="content">
				<p>Nie jesteś zalogowany!</p>
			</div>
			';
		}else{
			if($user['acces_right_name'] == 'admin'){
				ShowDetailsAdmin($user);
			}
			else if($user['acces_right_name'] == 'activeReader'){
				ShowDetailsReaders($user);
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