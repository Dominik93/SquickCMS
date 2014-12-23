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
					$resultAuthors = mysql_query('SELECT authors.* from authors join authors_books on authors_books.author_id = authors.author_id join books on books.book_id = authors_books.book_id where books.book_id = '.$row['book_id'].';') or die(mysql_error());
					$autorzy = "";
					if(mysql_num_rows($resultAuthors) == 0) {
						echo 'Brak autorów bład<br>';
					}else			
						while($rowA = mysql_fetch_assoc($resultAuthors)) {
							$autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
						}
					echo '<p>
							ID: '.$row['book_id'].'<br>
							ISBN: '.$row['book_isbn'].'<br>
							Autor: '.$autorzy.'<br>
							Tytuł: '.$row['book_title'].'<br>
							Wydawca: '.$row['publisher_house_name'].'<br>
							Ilość stron: '.$row['book_nr_page'].'<br>
							Wydanie: '.$row['book_edition'].'<br>
							Rok wydania: '.$row['book_premiere'].'<br>
							Ilość sztuk: '.$row['book_number'].'<br>
							<a href="book.php?book='.$row['book_id'].'">Przejdź do książki</a>
						</p>';
				}
			}
			DbClose();
		}else{
			ShowBookForm();
		}
	}
	
	function Content(){
		$user = unserialize($_SESSION['user']);
		echo '
			<div id="content">
			'.$user->showSearch().'
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