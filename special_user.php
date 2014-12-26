<?php
include "user.php";

class Admin extends User{

    public function __construct($c, $u = -1) {
        parent::__construct($c, $u);
    }
    public function session(){
            $this->controller->updateSessionAction($this->userID, "admin");
    }
    public function showOptionPanel(){
		$userData = $this->getData();
		return '<div id="panelName">Panel użytkownika</div><p align="center">Witamy '.$userData['admin_name'].'!</p>
			<ul>
				<li><a href="profile.php">Twój profil</a></li>
				<li><a href="add_news.php">Dodaj news</a></li>
				<li><a href="registration_reader.php">Zarejestruj czytelnika</a></li>
				<li><a href="registration_admin.php">Utwórz administratora</a></li>
				<li><a href="manage_admins.php">Zarządzaj adminami</a></li>
				<li><a href="manage_users.php">Zarządzaj czytelnikami</a></li>
				<li><a href="manage_books.php">Zarządzaj ksiażkami</a></li>
				<li><a href="manage_borrows.php">Zarządaj wypożyczeniami</a></li>
				<li><a href="logged.php">Lista zalogowanych</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
			session id = '.session_id().' logger = '.$_SESSION['logged'].' userid = '.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].' class.userID =
                        '.$this->userID.'';	
	}
    public function showNews(){
		$result = $this->controller->selectNews($limit = 10);
		$news = "";
		$news = $news.'<p>';
		if(mysqli_num_rows($result) == 0) {
				$news = $news.'Brak newsów<br>';
		}else
			while($row = mysqli_fetch_assoc($result)) {
				$news = $news.$row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
				$news = $news.' <a href="news.php?id='.$row['new_id'].'">Usuń</a><br>';
			}		
		$news = $news.'</p>';
		return $news;
	}
    public function getData(){
	return $this->controller->getAdminData();
    }
    public function showLogged(){
		$result = $this->controller->selectSession();
		$logged = "";
		if(mysqli_num_rows($result) == 0) {
			$logged = $logged.'Brak zalogowanych<br>';
		}else{
			$logged = $logged.'
				<div id="loggedTable" align="center">
				<table>
					<tr> <td>Session ID</td> <td>IP</td> <td>User</td> <td>Logged</td> <td>Rights</td> <td>Last action</td> </tr>
				';
			while($row = mysqli_fetch_array($result)) {
				$logged = $logged.'<tr> <td>'.$row['session_id'].'</td> <td>'.$row['session_ip'].'</td> <td>'.$row['session_user'].'</td> <td>'.$row['session_logged'].'</td> <td>'.$row['session_acces_right'].'</td> <td>'.$row['session_last_action'].'</td> </tr>';
			}
                        $logged = $logged.'</table></div>';
		}
		return $logged;
	}
    public function showRegistrationReader(){
		return '<div id="registration" align="center">
			<form action="registration_reader.php" method="post">
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
                                            <td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Hasło" required/><span id="status_password"></span></td>
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
    public function showAllUsers() {
        return '<p>'.$this->templateTable(array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                        array("reader_id", "reader_login", "reader_email", "reader_name", "reader_surname"),
                                        "readers", "usersTable", "profile_readers.php?id" ).
                '<p><a href="registration_reader.php">Dodaj</a></p>';
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
                    $resultAccessRgihts = $this->controller->selectAccessRights();
                    if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    	die('Błąd');
                    }
                    $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                    $this->controller->insertInto("readers", 
                            array("reader_name", "reader_surname", "reader_login", "reader_password", "reader_email", "reader_address", "reader_active_account", "reader_acces_right_id"),
                            array($name, $surname, $login, Codepass($password1), $email, $adres, date('Y-m-d'), $rowAR['acces_right_id']));
                    return '<p>Czytelnik Został poprawnie zarejestrowany! Możesz się teraz wrócić na <a href="main_page.php">stronę główną</a>.</p>';
		}
	}
    public function showAccount(){
        $userData =  $this->getData();
	return '<p>
                            ID: '.$userData['admin_id'].'<br>
                            Imie: '.$userData['admin_name'].'<br>
                            Nazwisko: '.$userData['admin_surname'].'<br>
                            Login: '.$userData['admin_login'].'<br>
                            Email: '.$userData['admin_email'].'<br>
                            Prawa: '.$userData['acces_right_name'].'<br>
                        </p>';
	}
    public function showAllBooks() {
            $books = "";
            $this->session();
            $result = $this->controller->selectBooks();
            if(mysqli_num_rows($result) == 0) {
			$books = $books.'Brak książek<br>';
            }
            else{
			$books = $books.'
				<div id="booksTable" align="center">
				<p><table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Ilość stron</td> <td>Wydanie</td> <td>Premiera</td> <td>Ilość egzemplarzy</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$resultAuthors =  $this->controller->selectAuthors($row['book_id']);
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
			$books = $books.'</table><p><a href="add_book.php">Dodaj</a></p></div>';
		}     
            return $books;     
        }
    public function showBookAdd() {
            return '<div id="add_book" align="center">
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
		$isbn = $this->controller->Clear($isbn);
		$title = $this->controller->Clear($title);
		$publisher_house = $this->controller->Clear($publisher_house);
		$nr_page = $this->controller->Clear($nr_page);
		$edition = $this->controller->Clear($edition);
		$premiere = $this->controller->Clear($premiere);
		$number = $this->controller->Clear($number);
		$author = $this->controller->Clear($author);
                
                $result = $this->controller->selectBook($isbn);
                if(mysqli_num_rows($result) > 0){
                    return 'Książka już istnieje';
		}
                
		$result = $this->controller->selectPublisherHouse($publisher_house);
		if(mysqli_num_rows($result) > 0){
                    $rowPH = mysql_fetch_array($result);
		}
                else{
                    $this->controller->addPublisherHouse($publisher_house);
                    $result = $this->controller->selectPublisherHouse($publisher_house);
                    $rowPH = mysqli_fetch_array($result);
		}
		$this->controller->addBook($isbn, $title, $rowPH[0], $nr_page, $edition, $premiere, $number);
		$result = $this->controller->selectBook($isbn);
		$rowB = mysqli_fetch_array($result);
		$authors = $author;
		$authors = explode(";", $authors);
		foreach($authors as $author){
                	$date = explode(' ', $author);
                        $name = $date[0];
			$surname = $date[1];
			$result = $this->controller->selectAuthor($name, $surname);
			if(mysqli_num_rows($result) > 0){
				$rowA = mysql_fetch_array($result);
			}else{
                            $this->controller->addAuthor($name, $surname);
                            $result = $this->controller->selectAuthor($name, $surname);
                            $rowA = mysqli_fetch_array($result);
			}
                        $this->controller->addConnectionBetwenAuthorAndBook($rowA[0], $rowB[0]);
		}	
		return '<p>Dodano ksiażke.</p>';
            }
        }
    public function showAllAdmins(){
        return '<p>'.$this->templateTable(array("ID", "Login", "Email", "Imie", "Nazwisko"),
                                    array("admin_id", "admin_login", "admin_email", "admin_name", "admin_surname"),
                                    "admins", "usersTable", "profile_admins.php?id").
                '<p><a href="registration_admin.php">Dodaj</a></p>';
        }
    public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
            $name = $this->controller->Clear($name);
            $surname = $this->controller->Clear($surname);
            $password1 = $this->controller->Clear($password1);
            $password2 = $this->controller->Clear($password2);
            $email = $this->controller->Clear($email);
            $login = $this->controller->Clear($login);
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
                $resultAccessRgihts = $this->controller->selectAccessRights();
                if(mysqli_num_rows($resultAccessRgihts) == 0) {
                    die('Błąd');
                }
                $rowAR = mysqli_fetch_assoc($resultAccessRgihts);
                $this->controller->insertInto("admins", 
                            array("admin_name", "admin_surname", "admin_login", "admin_password", "admin_email", "admin_acces_right_id"),
                            array($name, $surname, $login, Codepass($password1), $email, $rowAR['acces_right_id']));
                return "<p>Dodano admina</p>";
            }
        }
    public function showRegistrationAdmin() {
             return '<div id="registration" align="center">
			<form action="registration_admin.php" method="post">
				<table>
					<tr>Dodaj admina</tr>
					<tr><td>Login:</td><td><input id="login" type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj admina">
			</form>
		</div>';
        }
    public function showAllBorrows(){
        return '<p>'.$this->templateTable(array('ID','ID książki','ID czytelnika', 'Data wypożycczenia', 'Data zwrotu', 'Opóźnienie'),
                                    array('borrow_id','borrow_book_id','borrow_reader_id', 'borrow_date_borrow', 'borrow_return', 'borrow_delay_date'),
                                    "borrows", "borrowsTable", "borrow.php?borrow");
    }
    public function showAddNews(){
       return '
            <div id="news" align="center">
                <form action="add_news.php" method="post">
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
    public function addNews($title, $text){
	if(empty($title) ||
            empty($text)){
                return 'Nie wypełniono pól';
        }	
        else{
            $czas = date('Y-m-d');
            $title = $this->controller->clear($title);
            $text =  $this->controller->clear($text);
            $this->controller->addNew($title, $text, $czas);
            return '<p>Dodano news</p>';
        }
    }
}

class Reader extends User{
    private $active;

    public function __construct($a, $c, $u = -1){
	parent::__construct($c, $u);
        $this->active = $a;
    }
    public function session(){
            $this->controller->updateSessionAction($this->userID, "reader");
    }
    public function showOptionPanel(){
		$userData = $this->getData();
		return '<div id="panelName">Panel użytkownika</div>
			<p align="center">
				Witamy '.$userData['reader_name'].'!
			</p>
			<ul>
				<li><a href="profile.php">Twój profil</a></li>
				<li><a href="main_page.php">Twoje wypożyczenia</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
                        session id =
                        '.session_id().' logger = 
			'.$_SESSION['logged'].' userid =
			'.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].' class.userID =
                        '.$this->userID.' class.active =
                        '.$this->active.'';
	}
    public function showNews(){
            return parent::showNews();
        }
    public function getData(){
		return $this->controller->getReaderData();
	}
    public function showAccount(){
		$userData =  $this->getData();
		return '<p>
                            ID: '.$userData['reader_id'].'<br>
                            Imie: '.$userData['reader_name'].'<br>
                            Nazwisko: '.$userData['reader_surname'].'<br>
                            Login: '.$userData['reader_login'].'<br>
                            Email: '.$userData['reader_email'].'<br>
                            Konto aktywne do: '.$userData['reader_active_account'].'<br>
                            Adres: '.$userData['reader_address'].'<br>	
                            Prawa: '.$userData['acces_right_name'].'<br>					
			</p>';
	}
    public function isActive(){
            $date = $this->controller->getReaderData();
            if($date['acces_right_name'] == active)
                return true;
            else
                return false;
        }
    public function showBook($bookID, $active = "active"){
            $resultFreeBook = $this->controller->selectFreeBooks($bookID);
            $rowFreeBook = mysqli_fetch_assoc($resultFreeBook);
            if ($rowFreeBook['free_books'] == 0 || $this->active = false){
                $active = "disabled";
            }
            return  parent::showBook($bookID, $active);
        }
    public function orderBook($bookID) {
            $this->controller->addBorrow($bookID, $this->userID);
            echo 'Zamówiono książke';
        }
}
?>