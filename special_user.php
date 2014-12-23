<?php
include "user.php";

class Admin extends User{
	
	public function __construct($id, $c){
		$this->userID = $id;
		$this->controller = $c;
	}
        public function showOptionPanel(){
		$userData = $this->getData();
		return '
			<p align="center">
				Witamy '.$userData['admin_name'].'!
			</p>
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
					<tr><td>Login:</td><td><input id="login" type="text" value="'.$_POST['login'].'" name="login" placeholder="Login" required/><span id="status_login"></span></td></tr>
					<tr><td>E-mail:</td><td><input id="email" type="email" value="'.$_POST['email'].'" name="email" placeholder="E-mail" required/><span id="status_email"></span></td></tr>
					<tr><td>Hasło:</td><td><input id="password1" type="password" value="'.$_POST['password1'].'" name="password1" placeholder="Hasło" required/></td></tr>
					<tr><td>Powtórz hasło:</td><td><input id="password2" type="password" value="'.$_POST['password2'].'" name="password2" placeholder="Hasło" required/><span id="status_password"></span></td></tr>
					<tr><td>Imie:</td><td><input id="name" type="text" value="'.$_POST['name'].'" name="name" placeholder="Imie" required/></td></tr>
					<tr><td>Nazwisko:</td><td><input id="surname" type="text" value="'.$_POST['surname'].'" name="surname" placeholder="Nazwisko" required/></td></tr>
					<tr><td>Adres:</td><td><input id="adres" type="text" value="'.$_POST['adres'].'" name="adres" placeholder="Adres" required/></td></tr>
				</table>
				<input type="submit" id="submit" value="Zarejestruj czytelnika">
			</form>
		</div>';
	}
	public function showAllUsers() {
            $users = "";
            $result = $this->controller->selectReaders();
            if(mysqli_num_rows($result) == 0) {
			$users = $users.'Brak użytkowników<br>';
		}else{
			$users = $users. '
				<div id="usersTable" align="center">
				<table>
					<tr> <td>ID</td> <td>Login</td> <td>Email</td> <td>Imie</td> <td>Nazwisko</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$users = $users. '<tr onClick="location.href=\'http://localhost/~dominik/Library/profile_readers.php?id='.$row['reader_id'].'\'" /> <td>'.$row['reader_id'].'</td> <td>'.$row['reader_login'].'</td> <td>'.$row['reader_email'].'</td> <td>'.$row['reader_name'].'</td> <td>'.$row['reader_surname'].'</td> </tr>';
			}
			$users = $users. '<tr> <td align="center" colspan = 5 ><a href="registration_reader.php">Dodaj</a></td> </tr></table></div>';
		}
                return $users;
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
		}elseif($password1 != $password2) {
			return '<p>Podane hasła różnią się od siebie.</p>';
		}elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return '<p>Podany email jest nieprawidłowy.</p>';
		}else{
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
			$this->controller->addReader($name, $surname, $login, $password1, $email, $adres, date('Y-m-d'), $rowAR['acces_right_id']);
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
            $result = $this->controller->selectBooks();
            if(mysqli_num_rows($result) == 0) {
			$books = $books.'Brak książek<br>';
            }else{
			$books = $books.'
				<div id="booksTable" align="center">
				<table>
					<tr> <td>ID</td> <td>ISBN</td> <td>Tytył</td> <td>Autorzy</td> <td>Wydawca</td> <td>Ilość stron</td> <td>Wydanie</td> <td>Premiera</td> <td>Ilość egzemplarzy</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				$resultAuthors =  $this->controller->selectAuthors($row['book_id']);
				$autorzy = "";
				if(mysqli_num_rows($resultAuthors) == 0) {
					die('Brak autorów bład<br>');
				}else{		
                                    while($rowA = mysqli_fetch_assoc($resultAuthors)) {
					$autorzy = $autorzy.' '.$rowA['author_name'].' '.$rowA['author_surname'].', ';
                                    }
                                }
				$books = $books.'<tr onClick="location.href=\'http://localhost/~dominik/Library/book.php?book='.$row['book_id'].'\'" /> <td>'.$row['book_id'].'</td> <td>'.$row['book_isbn'].'</td> <td>'.$row['book_title'].'</td> <td>'.$autorzy.'</td> <td>'.$row['publisher_house_name'].'</td> <td>'.$row['book_nr_page'].'</td> <td>'.$row['book_edition'].'</td> <td>'.$row['book_premiere'].'</td> <td>'.$row['book_number'].'</td> </tr>';
			}
			$books = $books.'<tr><td align="center" colspan = 9><a href="add_book.php">Dodaj</a></td></tr></table></div>';
		}     
            return $books;     
        }
        
}

class Reader extends User{
	private $active;
	
	public function __construct($id, $a, $c){
		$this->userID = $id;
		$this->active = $a;
		$this->controller = $c;
	}
	
	public function showOptionPanel(){
		$userData = getData();
		return '
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
			'.$_SESSION['acces_right'].'';
	}
	public function showNews(){
            parent::showNews();
        }
        public function getData(){
		return $this->controller->getReaderData($id);
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
        
}
?>