<?php
	include "layout.php";
	include "config.php";	
	
	function AddAuthor(){
		if(isset($_POST['name'])){
			DbConnect();
			if(empty($_POST['name']) ||
				empty($_POST['surname'])){
					echo 'Nie wypełniono pól';
			}	
			else{
				$_POST['name'] = Clear($_POST['name']);
				$_POST['surname'] = Clear($_POST['surname']);
				mysql_query('INSERT INTO authors
							(author_name,
							author_surname)
							VALUES
							("'.$_POST['name'].'",
							"'.$_POST['surname'].'");')or die(mysql_error());
				echo '<p>Dodano autora</p>';
			}
			DbClose();
		}
		ShowAuthorForm();
	}
	
	function ShowAuthorForm(){
		echo '<div id="add_author" align="center">
		<form action="add_author.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Dodaj autora:</tf><tr>
				<tr><td>Imie:</td><td><input type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
				<tr><td>Nazwisko:</td><td><input type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required></td></tr>
			</table>
			<input type="submit" value="Dodaj autora">
		</form>
	</div>';
	}
	
	function Content(){
		echo '<div id="content">';
		if(CheckAdmin()){
			AddAuthor();
		}
		else{
			echo '
			<div id="content">
				<p>Nie masz dostępu!</p>
			</div>';
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