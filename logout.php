<?php
	include "layout.php";
	include "config.php";	
	session_start();
	$_SESSION['id'] = session_id();
	$_SESSION['logged'] = false;
	$_SESSION['user_id'] = -1;
	$_SESSION['acces_right'] = "none";
	$_SESSION['ip'] = null;
	DbConnect();
	mysql_query('UPDATE sessions SET session_logged = 0, session_user = -1, session_acces_right = "none" where session_id = "'.session_id().'"') or die(mysql_error());
	/*					
	mysql_query('DELETE FROM dslusarz_baza.sessions
		WHERE session_ip = "'.$_SERVER['REMOTE_ADDR'].'";') or die(mysql_error());*/
	DbClose();
	
	function Content(){
		echo '
			<div id="content">
				<p>
					Zostałeś wylogowany. Przejdz na <a href="main_page">strone główną</a>.
				</p>
			</div>
		';
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