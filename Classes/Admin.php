<?php
include_once "User.php";

class Admin extends User{

    public function __construct($c, $u = -1) {
        parent::__construct($c, $u);
    }
    public function session(){
        $this->controller->updateTableRecordValuesWhere("sessions", 
                array(array("session_last_action", date('Y-m-d H:i:s'))),
                array(
                    array("session_user","=", $this->userID, "AND"),
                    array("session_acces_right","=", "admin", "")
                    ));
    }
    public function showOptionPanel(){
        if(!$this->checkSession()){
            $this->timeOut();
        }
		$userData = $this->getData($this->userID);
		return '<div id="panelName">Panel użytkownika</div><p align="center">Witamy '.$userData['admin_name'].'!</p>
			<ul>
				<li><a href="'.backToFuture().'Library/profile.php">Twój profil</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/add_news.php">Dodaj news</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/registration_reader.php">Zarejestruj czytelnika</a></li>
				<li><a href="'.backToFuture().'Library/AdminAction/registration_admin.php">Utwórz administratora</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_admins.php">Zarządzaj adminami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_readers.php">Zarządzaj czytelnikami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_books.php">Zarządzaj ksiażkami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_borrows.php">Zarządaj wypożyczeniami</a></li>
				<li><a href="'.backToFuture().'Library/Manage/manage_sessions.php">Lista zalogowanych</a></li>
				<li><a href="'.backToFuture().'Library/UserAction/logout.php">Wyloguj</a></li>
			</ul>
			session id = '.session_id().' logger = '.$_SESSION['logged'].' userid = '.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].' class.userID =
                        '.$this->userID.'';	
	}
    public function showNews(){
		$result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("news");
		$news = "";
		$news = $news.'<p>';
		if(mysqli_num_rows($result) == 0) {
				$news = $news.'Brak newsów';
		}else{
			while($row = mysqli_fetch_assoc($result)) {
				$news = $news.$row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
				$news = $news.' <a href="'.backToFuture().'Library/Menu/news.php?id='.$row['new_id'].'">Usuń</a><br>';
			}	
                }
		$news = $news.'</p>';
		return $news;
	}
    public function showLogged(){
        return '<p>'.templateTable($this->controller, array("Session ID", "IP", "User", "Logged", "Rights", "Last action"),
                                        array("session_id", "session_ip", "session_user", "session_logged", "session_acces_right", "session_last_action"),
                                        "sessions", "loggedTable", "" ).'</p>';
	}
    public function showAccount(){
        $userData =  $this->getData($this->userID);
	return '<p>
                            ID: '.$userData['admin_id'].'<br>
                            Imie: '.$userData['admin_name'].'<br>
                            Nazwisko: '.$userData['admin_surname'].'<br>
                            Login: '.$userData['admin_login'].'<br>
                            Email: '.$userData['admin_email'].'<br>
                            Prawa: '.$userData['acces_right_name'].'<br>
                        </p>';
	}
    public function showRegistrationReader(){
		return '<div id="registration" align="center">
			<form action="'.backToFuture().'Library/AdminAction/registration_reader.php" method="post">
				<table>
                                        <tr>Dodaj czytelnika</tr>
					<tr>
                                            <td>Login:</td>
                                            <td><input id="login" type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td>
                                        </tr>
					<tr>
                                            <td>E-mail:</td>
                                            <td><input id="email" type="email" value="'.$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span>
                                        </td></tr>
					<tr>
                                            <td>Hasło:</td>
                                            <td><input id="password1" type="password" value="'.$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td>
                                        </tr>
					<tr>
                                            <td>Powtórz hasło:</td>
                                            <td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td>
                                        </tr>
					<tr>
                                            <td>Imie:</td>
                                            <td><input id="name" type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td>
                                        </tr>
					<tr>
                                            <td>Nazwisko:</td>
                                            <td><input id="surname" type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td>
                                        </tr>
					<tr>
                                            <td>Adres:</td>
                                            <td><input id="adres" type="text" value="'.$_POST['adres'].'" name="adres" placeholder="Adres" required/></td>
                                        </tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
	}  
    public function showRegistrationAdmin() {
             return '<div id="registration" align="center">
			<form action="'.backToFuture().'Library/AdminAction/registration_admin.php" method="post">
				<table>
					<tr>Dodaj admina</tr>
					<tr><td>Login:</td><td><input id="login" type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Powtórz hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj admina">
			</form>
		</div>';
        }
    public function showAddBookForm() {
            return '<div id="add_book" align="center">
		<form action="'.backToFuture().'Library/AdminAction/add_book.php" method="post">
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
    public function showAddNewsForm(){
       return '
            <div id="news" align="center">
                <form action="'.backToFuture().'Library/AdminAction/add_news.php" method="post">
                    <table>
			<tr>
                            <td colspan = 2 align="center">Dodaj news:</td>
                        <tr>
			<tr>
                            <td>Tytył:</td>
                            <td><input type="text" value="'.$_POST['title'].'" name="title" placeholder="Tytuł" required/></td>
                        </tr>
			<tr>
                            <td>Tekst:</td>
                            <td><textarea id="news_input" value="'.$_POST['text'].'" name="text" placeholder="Tekst" required></textarea></td>
                        </tr>
                    </table>
                    <input type="submit" value="Dodaj news">
		</form>
            </div>';
    }
    public function showAdmin($adminID){
        $userData =  $this->getData($adminID);
	return '<p>
                            ID: '.$userData['admin_id'].'<br>
                            Imie: '.$userData['admin_name'].'<br>
                            Nazwisko: '.$userData['admin_surname'].'<br>
                            Login: '.$userData['admin_login'].'<br>
                            Email: '.$userData['admin_email'].'<br>
                            Prawa: '.$userData['acces_right_name'].'<br>
                        </p>';
        }
    public function showReader($readerID){
        $userData =  $this->controller->getReaderData($readerID);
        return '<p>
            ID: '.$userData['reader_id'].'<br>
            Imie: '.$userData['reader_name'].'<br>
            Nazwisko: '.$userData['reader_surname'].'<br>
            Login: '.$userData['reader_login'].'<br>
            Email: '.$userData['reader_email'].'<br>
            Konto aktywne do: '.$userData['reader_active_account'].'<br>
            Adres: '.$userData['reader_address'].'<br>	
            Prawa: '.$userData['acces_right_name'].'<br>
            <button id="extendAccount">Przedłuż konto</button>
            <button id="deleteReader">Usuń czytelnika</button> 
            <button id="editReader">Edytuj</button> 
            <button id="newPassword">Wygeneruj nowe hasło</button> 
	</p>';
    }
    public function showEditReader($readerID){
        $userData = $this->controller->getReaderData($readerID);
        return '<div align="center">
            <form action="'.backToFuture().'../Library/AdminAction/profile_readers.php?id='.$userData['reader_id'].'" method="post">
                <input type="text" id="name" name="imie" value="'.$userData['reader_name'].'"/><br>
                <input type="text" id="surname" name="imie" value="'.$userData['reader_surname'].'"/><br>
                <input type="text" id="login" name="imie" value="'.$userData['reader_login'].'"/><br>
                <input type="email" id="email" name="imie" value="'.$userData['reader_email'].'"/><br>
                <input type="text" id="adres" name="imie" value="'.$userData['reader_address'].'"/><br>	
                <input type="hidden" id="edit" value="'.$userData['reader_id'].'"/>
                <input type="submit" id="submit" value="Zapisz zmiany">
            </form>'
                .'</div>';
    }
    public function showBorrow($borrowID){
        $borrow = "";
        $borrowResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("borrows", null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $rowBorrow = mysqli_fetch_array($borrowResult);
        $feeResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("fees", null, null, array(array("borrow_id", "=", $borrowID, "")));
        $rowFee = mysqli_fetch_array($feeResult);
        $borrow = $borrow.'<p>Data wypożyczenia: '.$rowBorrow['borrow_date_borrow'].'<br>Data zwrotu: '.$rowBorrow['borrow_return'].'<br>Odebrano: '.$rowBorrow['borrow_received'].'<br>Opóźnienie: '.$rowFee['borrow_delay'].'<br>Do zapłaty: '.$rowFee['amount'].'</p>';
        $borrow = $borrow.'<p><button id="receive">Odebrano</button> <button id="delete">Zwrócono</button></p>';
        $borrow = $borrow.'<div id="reader" align="center">Czytelnik:<br>'.$this->showReader($rowBorrow['borrow_reader_id']).'</div>';
        $borrow = $borrow.'<div id="book" align="center">Książka:<br>'.$this->showBookLight($rowBorrow['borrow_book_id']).'</div>';
        return $borrow;
    }    
    public function showAllUsers() {
        return '<p><div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable", "profile_readers.php?id" ).
                '<p><a href="'.backToFuture().'Library/AdminAction/registration_reader.php">Dodaj</a></p>';
        }
    public function showAllBorrows(){
        return '<p><div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ID książki" style="width: 60%;" type="text" id="id_book"></td>'
                . '<td><input placeholder="ID czytelnika" style="width: 60%;" type="text" id="id_reader"></td>'
                . '<td><input placeholder="Data wypożyczenia" style="width: 60%;" type="text" id="date_borrow"></td>'
                . '<td><input placeholder="Data zwrotu" style="width: 60%;" type="text" id="date_return"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array('ID','ID książki','ID czytelnika', 'Data wypożyczenia', 'Data zwrotu'),
                                    array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_return'),
                                    "borrows", "borrowsTable", backToFuture().'Library/AdminAction/borrow.php?id');
    }
    public function showAllBooks() {
            $books = "";
            $books .= '<div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="ISBN" style="width: 60%;" type="text" id="isbn"></td>'
                . '<td><input placeholder="Tytuł" style="width: 60%;" type="text" id="title"></td>'
                . '<td><input placeholder="Autorzy" style="width: 60%;" type="text" id="authors"></td>'
                . '<td><input placeholder="Wydawca" style="width: 60%;" type="text" id="publisher_house"></td>'
                . '<td><input placeholder="Ilość stron" style="width: 60%;" type="text" id="number_page"></td>'
                . '<td><input placeholder="Wydanie" style="width: 60%;" type="text" id="edition"></td>'
                . '<td><input placeholder="Premiera" style="width: 60%;" type="text" id="premiere"></td>'
                . '<td><input placeholder="Ilość egzemlarzy" style="width: 60%;" type="text" id="number"></td>' 
                . '</tr></table></div>';
            $this->session();
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books",
                    array("*"),
                    array(array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id")));
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
				$resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
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
                                                    . '<td>'.$this->controller->authorsToString($resultAuthors).'</td> '
                                                    . '<td>'.$row['publisher_house_name'].'</td>'
                                                    . ' <td>'.$row['book_nr_page'].'</td>'
                                                    . ' <td>'.$row['book_edition'].'</td> '
                                                    . '<td>'.$row['book_premiere'].'</td>'
                                                    . ' <td>'.$row['book_number'].'</td>'
                                                . ' </tr>';
			}
			$books = $books.'</table><p><a href="'.backToFuture().'Library/AdminAction/add_book.php">Dodaj</a></p></div>';
		}     
            return $books; 
        }
    public function showAllAdmins(){
        return '<p><div id="search" align="center"><table><tr>'
                . '<td><input placeholder="ID" style="width: 60%;" type="text" id="id"></td>'
                . '<td><input placeholder="Login" style="width: 60%;" type="text" id="login"></td>'
                . '<td><input placeholder="Email" style="width: 60%;" type="text" id="email"></td>'
                . '<td><input placeholder="Imie" style="width: 60%;" type="text" id="name"></td>'
                . '<td><input placeholder="Nazwisko" style="width: 60%;" type="text" id="surname"></td>'
                . '</tr></table></div>'.templateTable($this->controller, array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                    array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                    "admins", "usersTable", backToFuture().'Library/AdminAction/profile_admins.php?id').
                '<p><a href="'.backToFuture().'Library/AdminAction/registration_admin.php">Dodaj</a></p>';
        }
    public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
            $name = $this->controller->clear($name);
            $surname = $this->controller->clear($surname);
            $password1 = $this->controller->clear($password1);
            $password2 = $this->controller->clear($password2);
            $email = $this->controller->clear($email);
            $login = $this->controller->clear($login);
            if(empty($name) 
		|| empty($password1) 
		|| empty($password2) 
		|| empty($login)
		|| empty($surname)
		|| empty($email)){
                return '<p>Musisz wypełnić wszystkie pola.</p>';
            }
            elseif($password1 !=  $password2) {
		return '<p>Podane hasła różnią się od siebie.</p>';
            } 
            elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
		return '<p>Podany email jest nieprawidłowy.</p>';
            }
            else{
                if($this->controller->userExist("readers", "reader", $login, $email)){
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                elseif($this->controller->userExist("admins", "admin", $login, $email)){
                    return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                }
                if(strlen($login) < 4){
                    return '<p>Za mało znaków.</p>';
                }
                $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "admin", "")));
                if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    die('Błąd');
                }
                $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                $this->controller->insertTableRecordValue("admins", 
                            array("admin_name", "admin_surname", "admin_login", "admin_password", "admin_email", "admin_acces_right_id"),
                            array($name, $surname, $login, Codepass($password1), $email, $rowAR['acces_right_id']));
                return "<p>Dodano admina</p>";
            }
        }
    public function addNews($title, $text){
	if(empty($title) ||
            empty($text)){
                return 'Nie wypełniono pól';
        }	
        else{
            $czas = date('Y-m-d');
            $title = $this->controller->clear($title);
            $text =  $this->controller->clear($text);
            $this->controller->insertTableRecordValue("news", array("new_title",
							"new_text",
							"new_date"),array($title, $text, $czas));
            return '<p>Dodano news</p>';
        }
    }
    public function addBook($isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author) {
            if(empty($isbn) ||
		empty($title) ||
		empty($publisher_house) ||
		empty($nr_page) ||
		empty($edition) ||
		empty($premiere) ||
		empty($number) ||
		empty($author)){
		return 'Nie wypełniono pól';
            }	
            else{
		$isbn = $this->controller->clear($isbn);
		$title = $this->controller->clear($title);
		$publisher_house = $this->controller->clear($publisher_house);
		$nr_page = $this->controller->clear($nr_page);
		$edition = $this->controller->clear($edition);
		$premiere = $this->controller->clear($premiere);
		$number = $this->controller->clear($number);
		$author = $this->controller->clear($author);
                
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", array("*"),
                        null,
                        array(array("books.book_isbn", $isbn, "")));
                if(mysqli_num_rows($result) > 0){
                    return 'Książka już istnieje';
		}
                
		$result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("publisher_houses", array("*"), null, array(array("publisher_houses.publisher_house_name", $publisher_house,"")));
		if(mysqli_num_rows($result) > 0){
                    $rowPH = mysql_fetch_array($result);
		}
                else{
                    $this->controller->insertTableRecordValue("publisher_houses", array("publisher_house_name"), array($publisher_house));
                    $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("publisher_houses", array("*"), null, array(array("publisher_houses.publisher_house_name", $publisher_house,"")));
                    $rowPH = mysqli_fetch_array($result);
		}
                $this->controller->insertTableRecordValue("books",
                        array("book_isbn", "book_title", "book_publisher_house_id", "book_nr_page", "book_edition", "book_premiere", "book_number"),
                        array($isbn, $title, $rowPH[0], $nrPage, $edtiotion, $premiere, $number));
                    
		$result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", array("*"),
                        null,
                        array(array("books.book_isbn", $isbn, "")));
		$rowB = mysqli_fetch_array($result);
		$authors = $author;
		$authors = explode(";", $authors);
		foreach($authors as $author){
                	$date = explode(' ', $author);
                        $name = $date[0];
			$surname = $date[1];
                        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                                array("*"), null,
                                array(
                                    array("author_name", $name, "AND"),
                                    array("author_surname", $surname, "AND")
                                    ));
			if(mysqli_num_rows($result) > 0){
				$rowA = mysql_fetch_array($result);
			}else{
                            $this->controller->insertTableRecordValue("authors", array("author_name", "author_surname"), array($name, $surname));
                            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                                array("*"), null,
                                array(
                                    array("author_name", $name, "AND"),
                                    array("author_surname", $surname, "AND")
                                    ));
                            $rowA = mysqli_fetch_array($result);
			}
                        $this->controller->insertTableRecordValue("authors_books", array("author_id", "book_id"),  array($rowA[0], $rowB[0]));
		}	
		return '<p>Dodano ksiażke.</p>';
            }
        }
    public function addReader($login, $email, $name, $surname, $password1, $password2, $adres){
		$login = $this->controller->clear($login);
		$email = $this->controller->clear($email);
		$name = $this->controller->clear($name);
		$password1 = $this->controller->clear($password1);
		$password2 = $this->controller->clear($password2);
		$adres = $this->controller->clear($adres);
		$surname = $this->controller->clear($surname);
		
		if(empty($login) 
			|| empty($password1) 
			|| empty($password2) 
			|| empty($name)
			|| empty($surname)
			|| empty($email)
			|| empty($adres)
		){
			return '<p>Musisz wypełnić wszystkie pola.</p>';
		}
                elseif($password1 != $password2) {
			return '<p>Podane hasła różnią się od siebie.</p>';
		}
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return '<p>Podany email jest nieprawidłowy.</p>';
		}
                else{
                    $resultUser = $this->controller->selectExistingUser("readers", "reader", $login, $email);
                    $rowU = mysqli_fetch_row($resultUser);
                    if($rowU[0] > 0) {
                    	return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    if(strlen($login) < 4){
                    	return '<p>Za mało znaków.</p>';
                    }
                    $resultAdmin = $this->controller->selectExistingUser("admins", "admin", $login, $email);
                    $rowA = mysqli_fetch_row($resultAdmin);
                    if($rowA[0] > 0) {
                    	return '<p>Już istnieje użytkownik z takim loginem lub adresem e-mail.</p>';
                    }
                    $resultAccessRgihts = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("acces_rights", 
                            array("*"),
                            null,
                            array(array("acces_right_name","=", "activeReader", "")));
                    if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    	die('Błąd');
                    }
                    $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                    $this->controller->insertTableRecordValue("readers", 
                            array("reader_name", "reader_surname", "reader_login", "reader_password", "reader_email", "reader_address", "reader_active_account", "reader_acces_right_id"),
                            array($name, $surname, $login, Codepass($password1), $email, $adres, date('Y-m-d'), $rowAR['acces_right_id']));
                    return '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
	}
    public function editReader($login, $email, $name, $surname, $adres) {
        parent::editReader($login, $email, $name, $surname, $adres);
    }
    public function deleteNews($id){
        $this->controller->deleteTableWhere("news", array(array("new_id","=",$id,"")));
    }    
    public function getData($ID){
	return $this->controller->getAdminData($ID);
    }
}
?>