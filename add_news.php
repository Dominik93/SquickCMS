<?php
	include "layout.php";
	include "config.php";	
	
	function AddNews(){
		if(isset($_POST['title'])){
			DbConnect();
			$czas = date('Y-m-d');
			if(empty($_POST['title']) ||
				empty($_POST['text'])){
					echo 'Nie wypełniono pól';
			}	
			else{
				$_POST['title'] = Clear($_POST['title']);
				$_POST['text'] = Clear($_POST['text']);
				mysql_query('INSERT INTO news
							(new_title,
							new_text,
							new_date)
							VALUES
							("'.$_POST['title'].'",
							"'.$_POST['text'].'",
							"'.$czas.'");')or die(mysql_error());
				echo '<p>Dodano news</p>';
			}
			DbClose();
		}
		ShowNewsForm();
	}
	
	function ShowNewsForm(){
		echo '<div id="news" align="center">
		<form action="add_news.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Dodaj news:</tf><tr>
				<tr><td>Tytył:</td><td><input type="text" value="'.$_POST['title'].'" name="title" placeholder="Tytuł" required/></td></tr>
				<tr><td>Tekst:</td><td><textarea id="news_input" value="'.$_POST['text'].'" name="text" placeholder="Tekst" required></textarea></td></tr>
			</table>
			<input type="submit" value="Dodaj news">
		</form>
	</div>';
	}
	
	function Content(){
		$user = GetUserData();
		echo '<div id="content">';
		if(CheckAdmin()){
			AddNews();
		}
		else{
			echo '
				<p>Nie masz dostępu!</p>'
			;
		}
		echo '</div>';
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