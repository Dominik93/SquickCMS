<?php
	include "layout.php";
	include "config.php";	
	function Content(){
		echo '
			<div id="content">
				<p>
				';
				Remind();
		echo '
				</p>
			</div>
		';
	}
	
	function Remind(){
		if(isset($_POST['email'])){
			$mail = mail($_POST['email'], "Przypomnienie hasła- PAI", "Hasło zostało zmienione");
			if($mail){
				echo 'Nowe hasło zostało wysłane.';
			}
			else {
				echo 'Błąd przy wysyłaniu maila. Proszę spróbować jeszcze raz.';
			}
		}else{
			ShowRemindForm();
		}
	}
	
	function ShowRemindForm(){
	echo '
		<div id="remind" align="center">
			<form action="remind_password.php" method="post">
				<table>
					<tr> <td colspan = 2 align="center">Podaj e-mail:</tf><tr>
					<tr><td>E-mail:</td><td><input type="email" value="'.$_POST['email'].'" name="email" placeholder="Email" required/></td></tr>
				</table>
				<input type="submit" value="Przypomnij hasło">
			</form>
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