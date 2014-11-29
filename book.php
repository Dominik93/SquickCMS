<?php
	include "layout.php";
	include "config.php";	
		
	function ShowDetailsBook($book){
		DbConnect();
		$result = mysql_query('SELECT books.*, publisher_houses.publisher_house_name FROM books join publisher_houses on publisher_houses.publisher_house_id = books.book_publisher_house_id where books.book_id = '.$book.';') or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		
		$resultAuthors = mysql_query('SELECT authors.* from authors join authors_books on authors_books.author_id = authors.author_id join books on books.book_id = authors_books.book_id where books.book_id = '.$book.';') or die(mysql_error());
		$autorzy = "";
		if(mysql_num_rows($resultAuthors) == 0) {
			echo 'Brak autorów bład<br>';
		}else			
			while($rowA = mysql_fetch_assoc($resultAuthors)) {
				$autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
			}
		echo '
			<div id="content">
				<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$autorzy.'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
					Ilość egzemplarzy: '.$row['book_number'].'<br>
					
				</p>
			</div>
		';
		DbClose();
	}
	
	function Content(){
		if(!CheckAdmin()){
			echo '
			<div id="content">
				<p>Nie masz dostępu!</p>
			</div>
			';
		}else{
			ShowDetailsBook($_GET['book']);
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