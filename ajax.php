<?php
// łączenie się z bazą danych
include 'config.php';
$user = unserialize($_SESSION['user']);
$controller = new Controller();

if(isset($_POST['editReader'])){
    echo $user->showEditReader($_POST['id']);
}
if(isset($_POST['book'])){
    $book = "";
    $result = $controller->selectTableWhatJoinWhereGroupOrderLimit("books",
                    array("*"),
                    array(array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id")),
            array(
                array("book_id","like",$_POST['ID'],"and"),
                array("book_isbn","like",$_POST['ISBN'],"and"),
                array("book_title","like",$_POST['T'],"and"),
                array("publisher_houses.publisher_house_name","like",$_POST['PH'],"and"),
                array("book_nr_page","like",$_POST['NP'],"and"),
                array("book_edition","like",$_POST['E'],"and"),
                array("book_premiere","like",$_POST['P'],"and"),
                array("book_number","like",$_POST['N'],"")
                )
            
            );
            if(mysqli_num_rows($result) == 0) {
			$books = $books.'Brak książek';
            }
            else{
			$books = $books.'
				<div id="booksTable" align="center">
				<p><table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Ilość stron</td> <td>Wydanie</td> <td>Premiera</td> <td>Ilość egzemplarzy</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$resultAuthors = $controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                                    array("authors.*"),
                                    array(
                                                array("authors_books", "authors_books.author_id", "authors.author_id"),
                                                array("books", "books.book_id", "authors_books.book_id")
                                                ),
                                    array(
                                                array("books.book_id", "=", $row['book_id'], "")
                                                )
                                    );
				$books = $books.'<tr onClick="location.href=\'http://localhost/~dominik/Library/book.php?book='.$row['book_id'].'\'" /> '
                                                    . '<td>'.$row['book_id'].'</td> '
                                                    . '<td>'.$row['book_isbn'].'</td> '
                                                    . '<td>'.$row['book_title'].'</td> '
                                                    . '<td>'.$controller->authorsToString($resultAuthors).'</td> '
                                                    . '<td>'.$row['publisher_house_name'].'</td>'
                                                    . ' <td>'.$row['book_nr_page'].'</td>'
                                                    . ' <td>'.$row['book_edition'].'</td> '
                                                    . '<td>'.$row['book_premiere'].'</td>'
                                                    . ' <td>'.$row['book_number'].'</td>'
                                                . ' </tr>';
			}
			$books = $books.'</table><p><a href="'.backToFuture().'Library/AdminAction/add_book.php">Dodaj</a></p></div>';
		}     
    echo '<p>'.$books.'</p>';
}
if(isset($_POST['borrows'])){
    echo '<p>'.templateTable($controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Data zwrotu'),
                              array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_return'),
                                    "borrows", "borrowsTable", "borrow.php?id", null, null,
            array(
                array("borrow_id", "like", $_POST["ID"], "and"),
                array("borrow_book_id", "like", $_POST["IDK"], "and"),
                array("borrow_reader_id", "like", $_POST["IDC"], "and"),
                array("borrow_date_borrow", "like", $_POST["DW"], "and"),
                array("borrow_return", "like", $_POST["DZ"], "")
                ));
}

if (isset($_POST['reader'])){
    echo '<p>'.templateTable($controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable", "profile_readers.php?id", null, null,
            array(
                array("reader_id","like",$_POST['ID'],"and"),
                array("reader_login","like",$_POST['L'],"and"),
                array("reader_email","like",$_POST['E'],"and"),
                array("reader_name","like",$_POST['I'],"and"),
                array("reader_surname","like",$_POST['N'],"")
            )).'</p>';
}

if (isset($_POST['admin'])){
    echo '<p>'.templateTable($controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                        "admins", "usersTable", "profile_admin.php?id", null, null,
            array(
                array("admin_id","like",$_POST['ID'],"and"),
                array("admin_login","like",$_POST['L'],"and"),
                array("admin_email","like",$_POST['E'],"and"),
                array("admin_name","like",$_POST['I'],"and"),
                array("admin_surname","like",$_POST['N'],"")
            )).'</p>';
}

if(isset($_POST['delete'])){
    $controller->deleteTableWhere("borrows", array(array("borrow_id", "=", $_POST['delete'], "")));
    echo "OK";
}

if(isset($_POST['deleteReader'])){
    $controller->deleteTableWhere("readers", array(array("reader_id", "=", $_POST['deleteReader'], "")));
    echo "OK";
}
if(isset($_POST['extendAccount'])){
    $date = date_create(date('Y-m-d'));
    date_add($date, date_interval_create_from_date_string('365 days'));    
    $controller->updateTableRecordValuesWhere("readers", 
            array(array("reader_active_account", date_format($date,"y-m-d"))),
            array(array("reader_id", "=", $_POST['extendAccount'], ""))
            );
    echo "OK";
}

if(isset($_POST['receive'])){
    $controller->updateTableRecordValuesWhere("borrows",
            array(array("borrow_received", "1")),
            array(array("borrow_id", "=", $_POST['receive'], "")));
    echo "OK";
}

if(isset($_POST['login'])){
	$login = $_POST['login'];
	$login = $controller->clear($login);
	$dostepny = true;
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("readers", null, null,
                array(array("reader_login","=",$login,"")));
	
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("admins", null, null,
                array(array("admin_login","=",$login,"")));
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!$dostepny){
		echo 'Niedostępny';
	}else{
		echo 'OK';
	}
}

if(isset($_POST['email'])){
	$email = $_POST['email'];
	$email = $controller->clear($email);
	$dostepny = true;
	$poprawny = true;
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
		echo '<span style="color: #cc0000;"><strong>'.$email.'</strong> jest niepoprawny.</span>';
		$poprawny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("readers", null, null,
                array(array("reader_email","=",$email,"")));
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("admins", null, null,
                array(array("admin_email","=",$email,"")));
	if(mysqli_num_rows($result)){
		$dostepny = false;
	}
	if(!poprawny){
		echo 'Niepoprawny';
	}else if(!$dostepny){
		echo 'Niedostepny';
	}else{
		echo 'OK';
	}
}
?>