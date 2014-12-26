<?php
	include "layout.php";
	include "config.php";	
	
	if(!empty($_GET['usun'])){
		$controller->deleteAdmin($_GET['usun']);
		header('Location: manage_admins.php');
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
					<a>Edytuj</a>,
					<a href="profile.php?id='.$user['admin_id'].'&usun='.$user['admin_id'].'">Usuń</a>
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
			$admin = GetAdminData($_GET[id]);
			ShowDetailsAdmin($admin);
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