<?php
include "userInterface.php";

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
            $this->controller->deleteTableWhere("sessions", array(array("session_id", session_id(), "")));
            return '<p>Zostałeś wylogowany. Przejdz na <a href="index.php">strone główną</a>.</p>';
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
		$_SESSION['user'] = serialize(new Admin(new Controller(), $u = $row['admin_id']));
                $this->controller->insertTableRecordValue("sessions", 
                        array("session_id", "session_ip", "session_user", "session_logged", "session_acces_right"),
                        array(session_id(), $_SERVER['REMOTE_ADDR'], $row['admin_id'], 1, "admin" ));
                return '<p>Witaj jesteś adminem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="index.php">stronę główną</a>.</p>';
            }
            else{
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
		$_SESSION['user'] = serialize(new Reader($this->isActive(), new Controller(), $u = $row['reader_id']));
                $this->controller->insertTableRecordValue("sessions", 
                        array("session_id", "session_ip", "session_user", "session_logged", "session_acces_right"),
                        array(session_id(), $_SERVER['REMOTE_ADDR'], $row['reader_id'], 1, "reader" ));
                return '<p>Witaj jesteś czytelnikiem, zostałeś poprawnie zalogowany! Możesz teraz przejść na <a href="index.php">stronę główną</a>.</p>';
		}
                else{
                    return '<p>Podany login i/lub hasło jest nieprawidłowe.</p>';
		}
            }
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
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("books", 
                    array("books.*", "publisher_houses.publisher_house_name", "authors.*" ),
                    array(
                        array("publisher_houses","publisher_houses.publisher_house_id","books.book_publisher_house_id"),
                        array("authors_books","authors_books.book_id","books.book_id"),
                        array("authors","authors_books.author_id","authors.author_id")
                        ),
                    array(
                        array("books.book_isbn","LIKE",$isbn,"AND"),
                        array("books.book_title","LIKE",$title,"AND"),
                        array("publisher_houses.publisher_house_name","LIKE",$edition,"AND"),
                        array("books.book_edition","LIKE",$premiere,"AND"),
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
        public function session(){
            
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
            return true;
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
            return '<p>
					ID: '.$row['book_id'].'<br>
					ISBN: '.$row['book_isbn'].'<br>
					Tytuł: '.$row['book_title'].'<br>
					Autorzy: '.$this->controller->authorsToString($resultAuthors).'<br>
					Wydawnictwo: '.$row['publisher_house_name'].'<br>
					Premiera: '.$row['book_premiere'].'<br>
					Wydanie: '.$row['book_edition'].'<br>
					Ilość stron: '.$row['book_nr_page'].'<br>
					Ilość egzemplarzy: '.$rowFreeBook['free_books'].'<br>
					<form align="center" action="book.php?book='.$row['book_id'].'" method="post">
                                        <p><input type="hidden" name="orderHidden" value="1" />		
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
        public function showAddNews(){
            return "Brak dostępu";
        }
        public function addNews($title, $text){
            return "Brak dostępu";
        }
        public function showAdmin($adminID){}
        public function showReader($readerID){}

        public function templateForm($name, $arrayDiv, $arrayForm, $arrayFormInput){
            $form = "<div";
            for($i = 0; $i < count($arrayDiv); $i++){
                $form = $form.' '.$arrayDiv[$i][0].'="'.$arrayDiv[$i][1].'"';
            }
            $form = $form.'><p>'.$name.'</p>';
            $form = $form.'<form';
            for($i = 0; $i < count($arrayForm); $i++){
                $form = $form.' '.$arrayForm[$i][0].'="'.$arrayForm[$i][1].'"';
            }
            $form = $form.'>';
            // "isbn" ""
            
            for($i = 0; $i < count($arrayFormInput); $i++){
                $form = $form.'<input';
                for($j = 0; $j < count($arrayFormInput[$i]); $j++){
                    $form = $form.' '.$arrayFormInput[$i][$j][0].'="'.$arrayFormInput[$i][$j][1].'"';
                }  
                $form = $form.'/><br>';
            }
            $form = $form.'<input type="submit" valus="'.$name.'">';
            $form = $form.'</form></div>';
            return $form;
        }
        public function templateTable($array, $arrayTable, $table, $tableStyle, $link = null, $join = null, $where = null){
            $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit($table, $j = $join, $wh = $where);
            if(mysqli_num_rows($result) == 0) {
		return 'Brak danych';
            }
            $return = '<div id="'.$tableStyle.'" align="center">
                            <table>
                                <tr>';
            foreach ($array as $s){
                $return = $return.'<td>'.$s.'</td>';
            }
            $return = $return.'</tr>';
            while($row = mysqli_fetch_array($result)) {
                if($link == null){
                   $return = $return.'<tr>'.$row['reader_id'].'</tr>';
                }
                else{
                    $return = $return.'<tr onClick="location.href=\'http://localhost/~dominik/Library/'.$link.'='.$row[0].'\'" />';
                }
		for($i = 0; $i< count($array); $i++){
                    $return = $return.'<td>'.$row[$arrayTable[$i]].'</td>';
                }
                $return = $return.'<tr>';
            }
            $return = $return.'</table></div>';
            return $return;
        }
}
?>