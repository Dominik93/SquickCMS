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
		$resultFreeBook = mysql_query('SELECT * FROM free_books where book_id = '.$book.';') or die(mysql_error());
		$rowFreeBook = mysql_fetch_assoc($resultFreeBook);
		if ($rowFreeBook['free_books'] == 0)
			$active = "disabled";
		if (!CheckActiveUser())
			$active = "disabled";
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
					Ilość egzemplarzy: '.$rowFreeBook['free_books'].'<br>
					<form action="book.php?book='.$row['book_id'].'" method="post">
					pole typu hiden 
					<input type="submit" name="order" '.$active.' value="Zamów">
					</form>
				</p>
			</div>
		';
		DbClose();
	}
	
	function Content(){
		$user = GetReaderData();
		if(!CheckUser()){
			echo '
			<div id="content">
				<p>Nie masz dostępu!</p>
			</div>
			';
		}else{
		echo $_POST['order'];
			if(!is_null($_POST['order'])){
			DbConnect();
			mysql_query('INSERT INTO borrows (borrow_book_id, borrow_reader_id, borrow_date_borrow, borrow_return) 
				VALUES('.$_GET['book'].', '.$user['reader_id'].', "'.date('Y-m-d').'", "'.date('Y-m-d').'");') or die(mysql_error());
			DbClose();
			}else
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