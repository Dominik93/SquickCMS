<?php
include "userInterface.php";

class User implements IUser{
	protected $userID;
	protected $controller;
	
	public function __construct($c){
		$this->userID = -1;
		$this->controller = $c;
	}
        public function showMainPage(){
		return '
			<p>
				Witaj na stronie Biblioteki PAI!<br> Życzymy miłej zabawy z książkami☺
			</p>
		';
	}
	public function showHours(){
		return '<p>
					Godziny otwarcia:<br>
					Pon - Pt: 7:00 - 18:00<br>
					Sob: 9:00 - 15:00<br>
					Nd: Nieczynne
				</p>';
	}
	public function showSearch(){
		return '<div id="search" align="center">
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
        public function showContact(){
		return '<p>
					Biblioteka PAI<br>
					Adres: ul. Ulica Miasto<br> 000-000 Miasto<br>
					Telefon: 123456789<br>
					E-mail: mail@bpai.com
				</p>';
	}
        public function showRegulation(){
		return '<p>
					Tu bedzie regulamin!;p
				</p>';
	}
        public function logout(){
		$this->controller->updateSession(-1, 1, "none", session_id());
		return '<p>
					Zostałeś wylogowany. Przejdz na <a href="index.php">strone główną</a>.
				</p>';
	}
        public function showLogin(){
		return '<div id="login" align="center">
		<form action="login.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Logowanie:</tf><tr>
				<tr><td>Login:</td><td><input type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/></td></tr>
				<tr><td>Hasło:</td><td><input type="password" value="'.$_POST['password'].'" name="password" placeholder="Hasło" required/></td></tr>
				<tr> <td colspan = 2><a href="remind_password.php">Zapomniałeś hasła?</a></tf><tr>
			</table>
			<input type="submit" value="Zaloguj">
		</form></div>';
	}
        public function login($login, $password) {
            $login = $this->controller->clear($login);
            $password = $this->controller->clear($password);
            $result = $this->controller->validationLoginAdmin($login, $password);
            if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $row['admin_id'];
		$_SESSION['acces_right'] = "admin";
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user'] = serialize(new Admin($row['admin_id'], new Controller()));
		$this->controller->updateSession($row['admin_id'], 1, "admin", session_id());	
                    return '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="index.php">stronę główną</a>.</p>';
            }else{
		$result = $this->controller->validationLoginReader($login, $password);
		if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $row['reader_id'];
		$_SESSION['acces_right'] = "reader";
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                /*
                 * trzeba dopisać active w klasie, ma pobierać z bazy czy user jest active czy nie
                 */
		$_SESSION['user'] = serialize(new Reader($row['reader_id'], $this->isActive(), new Controller()));
		$this->controller->updateSession($row['reader_id'], 1, "reader", session_id());
                    return '<p>Witaj jesteś czytelnikiem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="index.php">stronę główną</a>.</p>';
		}else{
                    return '<p>Podany login i/lub hasło jest nieprawidłowe.</p>';
		}
            }
        }
        public function session(){
            $this->controller->updateSessionAction();
        }
        public function search($isbn, $title, $publisher_house, $edition, $premiere, $author) {
            $books = "";
            if(empty($isbn)) $isbn = "%";
            if(empty($title)) $title = "%";
            else $title = '%'.$title.'%';
            if(empty($publisher_house)) $publisher_house = "%";
            if(empty($edition)) $edition = "%";
            if(empty($premiere)) $premiere = "%";
            if(empty($author)) $author = "%";
            $result = $this->controller->selectSearchedBook($isbn, $title, $publisher_house, $edition, $premiere, $author);
            if(mysqli_num_rows($result) == 0) {
		return 'Brak książek';
            }else{
                while($row = mysqli_fetch_assoc($result)) {
                    $resultAuthors = $this->controller->selectAuthors($row['book_id']);
                    $autorzy = "";
                    if(mysqli_num_rows($resultAuthors) == 0) {
                        die('Brak autorów bład');
                    }
                    else{			
			while($rowA = mysqli_fetch_assoc($resultAuthors)) {
                            $autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
			}
			$books = $books.'<p>
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
            }
            return $books;
        }
        public function checkSession(){
            $session = true;
            /*
             * dopisac porownanie sesji, sesji w bazie danych, i danych z przegladarki
             */
            return $session;
        }

        public function showOptionPanel(){
		return '
			<div id="panelName">Panel użytkownika</div>
				<p align="center">
					Nie jesteś zalogowany!
				</p>
				<ul>
					<li><a href="login">Zaloguj się</a></li>
				</ul>
			session id =
                        '.session_id().' logger = 
			'.$_SESSION['logged'].' userid =
			'.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].'';
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
					$news = $news.'<br>';
			}		
		$news = $news.'</p>';
		return $news;
	}
        public function getData(){
		return $this->Data;
	}
        public function showLogged(){
		return 'Brak dostepu';
	}
        public function showRegistrationReader(){
		return 'Brak dostępu';
	}
        public function showAllUsers() {
            return 'Brak dostępu';
        }
        public function addReader($login, $email, $name, $surname, $password1, $password2, $adres){
		return 'Brak dostępu';
	}
	public function showAccount(){
		return 'Brak dostępu';
	}
	public function showAllBooks() {
            return 'Brak dostepu';
        }
        public function showBookAdd() {
            return 'Brak dostepu';
        }
        public function addBook($isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author) {
            return 'Brak dostepu';
        }
        public function showAllAdmins() {
            return 'Brak dostępu';
        }
        public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
             return 'Brak dostępu';
        }
        public function showRegistrationAdmin() {
             return 'Brak dostępu';
        }
        public function isActive(){
            return false;
        }
        public function showBook($bookID) {
            $active = "disabled";
            $result = $this->controller->selectBookByID($bookID);
            $row = mysqli_fetch_assoc($result);
            $resultAuthors = $this->controller->selectAuthors($bookID);
            $autorzy = "";
            if(mysqli_num_rows($resultAuthors) == 0) {
		die("Błąd");
            }
            else{			
		while($rowA = mysqli_fetch_assoc($resultAuthors)) {
                    $autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
		}
            }
            $resultFreeBook = $this->controller->selectFreeBooks($bookID);
            $rowFreeBook = mysqli_fetch_assoc($resultFreeBook);
            return '<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$autorzy.'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
					Ilość egzemplarzy: '.$rowFreeBook['free_books'].'<br>
					<form align="center" action="book.php?book='.$row['book_id'].'" method="post">
					<input type="submit" name="order" '.$active.' value="Zamów">
					</form>
				</p>';
        }
        public function orderBook($bookID) {
            die("Błąd");
        }
        public function showAllBorrows(){
            return 'Brak dostepu';
        }
}
?>