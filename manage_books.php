<?php
	include "layout.php";
	include "config.php";	
	
	function ShowUsers(){
		DbConnect();
		$result = mysql_query('SELECT books.*, publisher_houses.publisher_house_name FROM books join publisher_houses on publisher_houses.publisher_house_id = books.book_publisher_house_id;') or die(mysql_error());
		if(mysql_num_rows($result) == 0) {
			echo 'Brak książek<br>';
		}else{
			echo '
				<div id="booksTable" align="center">
				<table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Ilość stron</td> <td>Wydanie</td> <td>Premiera</td> <td>Ilość egzemplarzy</td> </tr>
				';
			while($row = mysql_fetch_assoc($result)) {
				$resultAuthors = mysql_query('SELECT authors.* from authors join authors_books on authors_books.author_id = authors.author_id join books on books.book_id = authors_books.book_id where books.book_id = '.$row['book_id'].';') or die(mysql_error());
				$autorzy = "";
				if(mysql_num_rows($resultAuthors) == 0) {
					echo 'Brak autorów bład<br>';
				}else			
					while($rowA = mysql_fetch_assoc($resultAuthors)) {
						$autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
					}
				echo '<tr onClick="location.href=\'http://localhost/~dominik/Library/book.php?book='.$row['book_id'].'\'" /> <td>'.$row['book_id'].'</td> <td>'.$row['book_isbn'].'</td> <td>'.$row['book_title'].'</td> <td>'.$autorzy.'</td> <td>'.$row['publisher_house_name'].'</td> <td>'.$row['book_nr_page'].'</td> <td>'.$row['book_edition'].'</td> <td>'.$row['book_premiere'].'</td> <td>'.$row['book_number'].'</td> </tr>';
			}
			echo '<tr><td align="center" colspan = 9><a href="add_book.php">Dodaj</a></td></tr></table>';
		}
		DbClose();
	}
	
	
	function Content(){
		echo '
			<div id="content">
				<p>';
				if(CheckAdmin())
					ShowUsers();
				else{
					echo 'Nie masz uprawnien!';
				}
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