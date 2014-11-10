<?php
	include "config.php";
	include "layout.php";
	
	function ShearchBook(){
		if(isset($_POST['isbn'])){
			if(empty($_POST['isbn'])) $_POST['isbn'] = "%";
			if(empty($_POST['title'])) $_POST['title'] = "%";
			if(empty($_POST['publisher_house'])) $_POST['publisher_house'] = "%";
			if(empty($_POST['edition'])) $_POST['edition'] = "%";
			if(empty($_POST['premiere'])) $_POST['premiere'] = "%";
			if(empty($_POST['author'])) $_POST['author'] = "%";
			DbConnect();
			echo 'SELECT books.*, publisher_houses.publisher_house_name, authors.* FROM books 
								JOIN publisher_houses ON publisher_houses.publisher_house_id = books.book_publisher_house_id
								JOIN authors_books ON authors_books.book_id = books.book_id
								JOIN authors ON authors_books.author_id = authors.author_id
								WHERE 
								(books.book_isbn LIKE \''.$_POST['isbn'].'\') AND
								(books.book_title LIKE \''.$_POST['title'].'\') AND
								(publisher_houses.publisher_house_name LIKE \''.$_POST['publisher_house'].'\') AND
								(books.book_edition LIKE \''.$_POST['edition'].'\')
								;';
			$result = mysql_query('SELECT books.*, publisher_houses.publisher_house_name, authors.* FROM books 
								JOIN publisher_houses ON publisher_houses.publisher_house_id = books.book_publisher_house_id
								JOIN authors_books ON authors_books.book_id = books.book_id
								JOIN authors ON authors_books.author_id = authors.author_id
								WHERE 
								(books.book_isbn LIKE \''.$_POST['isbn'].'\') AND
								(books.book_title LIKE \''.$_POST['title'].'\') AND
								(publisher_houses.publisher_house_name LIKE \''.$_POST['publisher_house'].'\') AND
								(books.book_edition LIKE \''.$_POST['edition'].'\') AND
								(authors.author_name LIKE \''.$_POST['author'].'\')
								GROUP BY books.book_id;
								') 
			or die(mysql_error());
			if(mysql_num_rows($result) == 0) {
				echo 'Brak książek.<br>';
			}else{
				while($row = mysql_fetch_assoc($result)) {
					echo '<p>
							ID: '.$row['book_id'].'<br>
							ISBN: '.$row['book_isbn'].'<br>
							Autor: '.$row['author_name'].' '.$row['author_surname'].'<br>
							Tytuł: '.$row['book_title'].'<br>
							Wydawca: '.$row['publisher_house_name'].'<br>
							Ilość stron: '.$row['book_nr_page'].'<br>
							Wydanie: '.$row['book_edition'].'<br>
							Rok wydania: '.$row['book_premiere'].'<br>
							Ilość sztuk: '.$row['book_number'].'<br>
						</p>';
				}
			}
			DbClose();
		}else{
			ShowBookForm();
		}
	}
	
	function ShowBookForm(){
		echo '<div id="search" align="center">
		<form action="search.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Szukaj książki:</tf><tr>
				<tr><td>ISBN:</td><td><input type="text" value="'.$_POST['isbn'].'" name="isbn" placeholder="ISBN"/></td></tr>
				<tr><td>Tytuł:</td><td><input type="text" value="'.$_POST['title'].'" name="title" placeholder="Tytuł"/></td></tr>
				<tr><td>Wydawca:</td><td><input type="text" value="'.$_POST['publisher_house'].'" name="publisher_house" placeholder="Wydawca"/></td></tr>
				<tr><td>Wydanie:</td><td><input type="text" value="'.$_POST['edition'].'" name="edition" placeholder="Wydanie"/></td></tr>
				<tr><td>Rok wydania:</td><td><input type="text" value="'.$_POST['premiere'].'" name="premiere" placeholder="Rok Wydania"/></td></tr>
				<tr><td>Autor:</td><td><input type="text" value="'.$_POST['author'].'" name="author" placeholder="Imie Nazwisko;"/></td></tr>
			</table>
			<input type="submit" value="Szukaj ksiażki">
		</form>
	</div>';
	}
	
	function Content(){
		echo '
			<div id="content">
				<p>';
					ShearchBook();
		echo '</p>
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