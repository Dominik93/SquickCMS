<?php

include_once backToFuture()."Library/Interface/userInterface.php";

class User implements IUser{
	protected $userID;
	protected $controller;
	
	public function __construct($c, $u = -1){
		$this->userID = $u;
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
		<form action="'.backToFuture().'Library/Menu/search.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Szukaj książki:</td><tr>
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
        public function showLogin(){
            return templateForm("Logowanie",
                    array(
                        array("id", "=", "login"),
                        array("align", "=", "center")
                    ),
                    array(
                        array("action", "=", backToFuture().'Library/UserAction/login.php'),
                        array("method", "=", "post")
                    ),
                    array(),
                    array(
                        array(
                            array("type","=","text"),
                            array("value","=", $_POST["login"]),
                            array("name","=","login"),
                            array("placeholder","=","Login"),
                            array("required","","")
                            ),
                        array(
                            array("type","=","password"),
                            array("value","=",$_POST["password"]),
                            array("name","=","password"),
                            array("placeholder","=","Hasło"),
                            array("required","","")
                            )
                        ),
                    array(
                        array("type", "=", "submit"),
                        array("value", "=", "Zaloguj się")
                        )
                    );
	}
        public function logout(){
            $this->controller->deleteTableWhere("sessions", array(array("session_id","=", session_id(), "")));
            return '<p>Zostałeś wylogowany. Przejdz na <a href="'.backToFuture().'Library/index.php">strone główną</a>.</p>';
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
		$_SESSION['user'] = serialize(new Admin(new Controller(), $u = $row['admin_id']));
                $this->controller->insertTableRecordValue("sessions", 
                        array("session_id", "session_ip", "session_user", "session_logged", "session_acces_right"),
                        array(session_id(), $_SERVER['REMOTE_ADDR'], $row['admin_id'], 1, "admin" ));
                return '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
            }
            else{
		$result = $this->controller->validationLoginReader($login, $password);
		if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $row['reader_id'];
		$_SESSION['acces_right'] = "reader";
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user'] = serialize(new Reader($this->isActive($row['reader_id']), new Controller(), $u = $row['reader_id']));
                $this->controller->insertTableRecordValue("sessions", 
                        array("session_id", "session_ip", "session_user", "session_logged", "session_acces_right"),
                        array(session_id(), $_SERVER['REMOTE_ADDR'], $row['reader_id'], 1, "reader" ));
                return '<p>Witaj jesteś czytelnikiem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="'.backToFuture().'Library/index.php">stronę główną</a>.</p>';
		}
                else{
                    return '<p>Podany login i/lub hasło jest nieprawidłowe.</p>';
		}
            }
        }
        public function search($isbn, $title, $publisher_house, $edition, $premiere, $author){
            $books = "";
            if(empty($isbn)) $isbn = "%";
            else $isbn = '%'.$isbn.'%';
            if(empty($title)) $title = "%";
            else $title = '%'.$title.'%';
            if(empty($publisher_house)) $publisher_house = "%";
            else $publisher_house = '%'.$publisher_house.'%';
            if(empty($edition)) $edition = "%";
            else $edition = '%'.$edition.'%';
            if(empty($premiere)) $premiere = "%";
            else $premiere = '%'.$premiere.'%';
            
            $isbn = $this->controller->clear($isbn);
            $title = $this->controller->clear($title);
            $publisher_house = $this->controller->clear($publisher_house);
            $edition = $this->controller->clear($edition);
            $premiere = $this->controller->clear($premiere);
            $author = "%";
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", 
                    array("books.*", "publisher_houses.publisher_house_name" ),
                    array(
                        array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id"),
                        array("authors_books","authors_books.book_id","books.book_id"),
                        array("authors","authors_books.author_id","authors.author_id")
                        ),
                    array(
                        array("books.book_isbn","LIKE",$isbn,"AND"),
                        array("books.book_title","LIKE",$title,"AND"),
                        array("publisher_houses.publisher_house_name","LIKE",$publisher_house,"AND"),
                        array("books.book_premiere","LIKE",$premiere,"AND"),
                        array("books.book_edition","LIKE",$edition,"AND"),
                        array("authors.author_name","LIKE",$author,"")
                    ),
                    "books.book_id");
            if(mysqli_num_rows($result) == 0) {
		return 'Brak książek';
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                    $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                            $arrayW = array("authors.*"),
                            $arrayJ = array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            $arrayWh = array(
                                        array("books.book_id","=", $row['book_id'], " ")
                                        )
                            );
                    if(mysqli_num_rows($resultAuthors) == 0) {
                        die('Brak autorów bład');
                    }
                    else{			
			$autorzy = $this->controller->authorsToString($resultAuthors);
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
							<a href="'.backToFuture().'Library/UserAction/book.php?book='.$row['book_id'].'">Przejdź do książki</a>
						</p>';
                        }
                }
            }
            return $books;
        }
        public function checkSession(){
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("sessions", null, null, 
                    array(array("session_id", "=" , session_id(),"")));
            if(mysqli_num_rows($result) != 1){
                return false;
            }
            $row = mysqli_fetch_assoc($result);
            if($row['session_ip'] != $_SERVER['REMOTE_ADDR']){
                return false;
            }
            return true;
        }
        public function session(){
            
        }
        public function timeOut(){
            session_start();
            $_SESSION['id'] = session_id();
            $_SESSION['logged'] = false;
            $_SESSION['user_id'] = -1;
            $_SESSION['acces_right'] = "user";
            $_SESSION['ip'] = null;
            $_SESSION['user'] = serialize(new User(new Controller()));
        }

        public function showOptionPanel(){
		return '
			<div id="panelName">Panel użytkownika</div>
				<p align="center">
					Nie jesteś zalogowany!
				</p>
				<ul>
					<li><a href="'.  backToFuture().'Library/UserAction/login.php">Zaloguj się</a></li>
				</ul>
			session id =
                        '.session_id().' logger = 
			'.$_SESSION['logged'].' userid =
			'.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].' class.userID =
                        '.$this->userID.'';
	}
        public function showNews(){
                $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("news");
		$news = '<p>';
		if(mysqli_num_rows($result) == 0) {
                    $news = $news.'Brak newsów';
		}
                else{
                    while($row = mysqli_fetch_assoc($result)) {
			$news = $news.$row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
			$news = $news.'<br>';
                    }
                }
		$news = $news.'</p>';
		return $news;
	}
        public function showLogged(){
            return 'Brak dostepu';
	}
        public function showAdmin($adminID){
            return "Brak dostepu";
        }
        public function showReader($readerID){
            return "Brak dostepu";
        }
        public function showEditReader($readerID){
            return "Brak dostepu";
        }
        public function showRegistrationReader(){
            return 'Brak dostępu';
	}
        public function showRegistrationAdmin() {
            return 'Brak dostępu';
        }
        public function showAccount(){
            return 'Brak dostępu';
	}
        public function showAddBookForm() {
            return 'Brak dostepu';
        }
        public function showAddNewsForm(){
            return "Brak dostępu";
        }
        public function showAllUsers() {
            return 'Brak dostępu';
        }
	public function showAllBooks() {
            return 'Brak dostepu';
        }
        public function showAllAdmins() {
            return 'Brak dostępu';
        }
        public function showAllBorrows(){
            return 'Brak dostepu';
        }
        public function showBook($bookID, $active = "disabled") {
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", 
                    array("books.*", "publisher_houses.publisher_house_name"),
                    array(array("publisher_houses", "publisher_houses.publisher_house_id", "books.book_publisher_house_id")),
                    array(array("books.book_id","=", $bookID, "")));
            $row = mysqli_fetch_assoc($result);
            $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                            array("authors.*"),
                            array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $row['book_id'], "")
                                        )
                            );
            $resultFreeBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("free_books", 
                        array("*"),
                        null,
                        array(
                              array("book_id","=", $bookID, " ")
                              ));
            $rowFreeBook = mysqli_fetch_assoc($resultFreeBook);
            if($rowFreeBook['free_books'] == null){
                $freeBook = $row['book_number'];
            }
            else{
                $freeBook = $rowFreeBook['free_books'];
            }
            return '<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$this->controller->authorsToString($resultAuthors).'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
					Ilość dostępnych egzemplarzy: '.$freeBook.'<br>
					<form align="center" action="'.backToFuture().'/Library/UserAction/book.php?book='.$row['book_id'].'" method="post">
                                        <p><input type="hidden" name="orderHidden" value="1" />		
                                        <input type="submit" name="order" '.$active.' value="Zamów">
					</form>
				</p>';
        }
        public function showBookLight($bookID) {
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", 
                    array("books.*", "publisher_houses.publisher_house_name"),
                    array(array("publisher_houses", "publisher_houses.publisher_house_id", "books.book_publisher_house_id")),
                    array(array("books.book_id","=", $bookID, "")));
            $row = mysqli_fetch_assoc($result);
            $resultAuthors = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("authors", 
                            array("authors.*"),
                            array(
                                        array("authors_books", "authors_books.author_id", "authors.author_id"),
                                        array("books", "books.book_id", "authors_books.book_id")
                                        ),
                            array(
                                        array("books.book_id","=", $row['book_id'], "")
                                        )
                            );
            return '<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$this->controller->authorsToString($resultAuthors).'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
				</p>';
        }
        public function showBorrow($borrowID){
            return 'Brak dostepu';
        }
        public function showMyBorrows(){
            return "Brak dostepu";
        }
        public function addReader($login, $email, $name, $surname, $password1, $password2, $adres){
            return 'Brak dostępu';
	}
        public function editReader($login, $email, $name, $surname, $adres) {
            return "Brak dostępu";
        }
        public function addBook($isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author) {
            return 'Brak dostepu';
        }
        public function addAdmin($name, $surname, $password1, $password2, $email, $login) {
             return 'Brak dostępu';
        }
        public function addNews($title, $text){
            return "Brak dostępu";
        }
        public function deleteNews($id){
            return "Brak dostępu";
        }
        public function isActive($ID){
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("readers",
                    array("acces_right_name"),
                    array(array("acces_rights", "acces_rights.acces_right_id", "readers.reader_acces_right_id")),
                    array(array("readers.reader_id", "=", $ID, "")));
            $row = mysqli_fetch_array($result);
            if($row['acces_right_name'] == 'activeReader')
                return 1;
            else
                return 0;
        }
        public function orderBook($bookID) {
            die("Błąd");
        }
        public function getData($ID){
		return $this->Data;
	}
}
?>