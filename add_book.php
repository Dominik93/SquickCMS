<?php
	include "layout.php";
	include "config.php";	
	
	function AddBook(){
		if(isset($_POST['isbn'])){
			DbConnect();
			if(empty($_POST['isbn']) ||
			empty($_POST['title']) ||
			empty($_POST['publisher_house']) ||
			empty($_POST['nr_page']) ||
			empty($_POST['edition']) ||
			empty($_POST['premiere']) ||
			empty($_POST['number']) ||
			empty($_POST['author'])
				){
					echo 'Nie wypełniono pól';
			}	
			else{
				$_POST['isbn'] = Clear($_POST['isbn']);
				$_POST['title'] = Clear($_POST['title']);
				$_POST['publisher_house'] = Clear($_POST['publisher_house']);
				$_POST['nr_page'] = Clear($_POST['nr_page']);
				$_POST['edition'] = Clear($_POST['edition']);
				$_POST['premiere'] = Clear($_POST['premiere']);
				$_POST['number'] = Clear($_POST['number']);
				$_POST['author'] = Clear($_POST['author']);
				$result =  mysql_query('SELECT * FROM dslusarz_baza.publisher_houses WHERE publisher_houses.publisher_house_name = "'.$_POST['publisher_house'].'"') or die(mysql_error());
				if(mysql_num_rows($result) > 0){
					$rowPH = mysql_fetch_array($result);
				}else{
					mysql_query('INSERT INTO dslusarz_baza.publisher_houses (publisher_houses.publisher_house_name) VALUES("'.$_POST['publisher_house'].'"') or die(mysql_error());
					$result =  mysql_query('SELECT * FROM dslusarz_baza.publisher_houses WHERE publisher_houses.publisher_house_name = "'.$_POST['publisher_house'].'"') or die(mysql_error());
					$rowPH = mysql_fetch_array($result);
				}
				mysql_query('INSERT INTO `dslusarz_baza`.`books`
									(`book_isbn`,
									`book_title`,
									`book_publisher_house_id`,
									`book_nr_page`,
									`book_edition`,
									`book_premiere`,
									`book_number`)
									VALUES
									("'.$_POST['isbn'].'",
									"'.$_POST['title'].'",
									"'.$rowPH[0].'",
									"'.$_POST['nr_page'].'",
									"'.$_POST['edition'].'",
									"'.$_POST['premiere'].'",
									"'.$_POST['number'].'");
								') or die(' blad'.mysql_error());
				$result =  mysql_query('SELECT * FROM dslusarz_baza.books WHERE books.book_isbn = "'.$_POST['isbn'].'"') or die(mysql_error());
				$rowB = mysql_fetch_array($result);
				$authors = $_POST['author'];
				$authors = explode(";", $authors);
				foreach($authors as $author){
					$date = explode(' ', $author);
					$name = $date[0];
					$surname = $date[1];
					$result =  mysql_query('SELECT * FROM dslusarz_baza.authors WHERE authors.author_name = "'.$name.'" and authors.author_surname = "'.$surname.'" ') or die(mysql_error());
					if(mysql_num_rows($result) > 0){
						$rowA = mysql_fetch_array($result);
					}else{
						mysql_query('INSERT INTO authors (authors.author_name, authors.author_surname) VALUES("'.$name.'", "'.$surname.'");') or die(mysql_error());
						$result =  mysql_query('SELECT * FROM dslusarz_baza.authors WHERE authors.author_name = "'.$name.'" and authors.author_surname = "'.$surname.'" ') or die(mysql_error());
						$rowA = mysql_fetch_array($result);
					}
					mysql_query('INSERT INTO `dslusarz_baza`.`authors_books`
								(`author_id`,
								`book_id`)
								VALUES
								('.$rowA[0].',
								'.$rowB[0].');
								') or die(mysql_error());
					echo 'Dodano ksiażke.';
				}	
			}
			DbClose();
		}
		ShowBookForm();
	}
	/*
		widok na ilosc dostepnych sztuk
	*/
	function ShowBookForm(){
		echo '<div id="add_book" align="center">
		<form action="add_book.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Dodaj książke:</tf><tr>
				<tr><td>ISBN:</td><td><input type="text" value="'.$_POST['isbn'].'" name="isbn" placeholder="ISBN" required/></td></tr>
				<tr><td>Tytuł:</td><td><input type="text" value="'.$_POST['title'].'" name="title" placeholder="Tytuł" required/></td></tr>
				<tr><td>Wydawca:</td><td><input type="text" value="'.$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca" required/></td></tr>
				<tr><td>Ilość stron:</td><td><input type="text" value="'.$_POST['nr_page'].'" name="nr_page" placeholder="Ilość stron" required/></td></tr>
				<tr><td>Wydanie:</td><td><input type="text" value="'.$_POST['edition'].'" name="edition" placeholder="Wydanie" required/></td></tr>
				<tr><td>Rok wydania:</td><td><input type="text" value="'.$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania" required/></td></tr>
				<tr><td>Ilość egzemplarzy:</td><td><input type="text" value="'.$_POST['number'].'" name="number" placeholder="Ilość egzemplarzy" required/></td></tr>
				<tr><td>Autor:</td><td><input type="text" value="'.$_POST['author'].'" name="author" placeholder="Imie Nazwisko;" required/></td></tr>
			</table>
			<input type="submit" value="Dodaj ksiażke">
		</form>
	</div>';
	}
	
	function Content(){
		$user = GetUserData();
		echo '<div id="content">';
		if(CheckAdmin()){
			AddBook();
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