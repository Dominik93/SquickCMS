<?php
include "user.php";

class Admin extends User implements IUser{
	
	public function __construct($controller, $id){
		$this->userData = $controller->getAdminDate($id);
	}

	public function showNews($controller){
		$result = $controller->selectNews(10);
		$news = "";
		$news += '<div id="content">
				<p>';
		if(mysqli_num_rows($result) == 0) {
				$news += 'Brak newsów<br>';
		}else
			while($row = mysqli_fetch_assoc($result)) {
				$news += $row['new_title'].' '.$row['new_date'].' '.$row['new_text'];
				$news += ' <a href="news.php?id='.$row['new_id'].'">Usuń</a><br>';
			}		
		$news += '</p>';
		return $news;
	}
	public function showMainPage(){
		return '
			<p>
				Witaj na stronie Biblioteki PAI!<br> Życzymy miłej zabawy z książkami☺
			</p>
		';
	}
	public function deleteNews(){
	
	}
	public function showNews(){
		return "news";
	}
	public function showMainPage(){
		return '
			<p>
				Witaj na stronie Biblioteki PAI!<br> Życzymy miłej zabawy z książkami☺
			</p>
		';
	}
	public function showRegulation(){
		return '<p>
					Tu bedzie regulamin!;p
				</p>';
	}
	public function showHours(){
		return '<p>
					Godziny otwarcia:<br>
					Pon - Pt: 7:00 - 18:00<br>
					Sob: 9:00 - 15:00<br>
					Nd: Nieczynne
				</p>';
	}
	public function showContact(){
		return '<p>
					Biblioteka PAI<br>
					Adres: ul. Ulica Miasto<br> 000-000 Miasto<br>
					Telefon: 123456789<br>
					E-mail: mail@bpai.com
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
	public function showAllReader(){
		
	}
	public function showAllBorrows(){
	
	}
	public function showAllFees(){
	
	}
	public function showOptionPanel(){
		return '
			<p align="center">
				Witamy '.$this->userData['admin_name'].'!
			</p>
			<ul>
				<li><a href="your_profile.php">Twój profil</a></li>
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
			';	
	}
	public function getData(){
		return $this->userData;
	}
	public function showAccount(){
		return '<p>
					ID: '.$this->userData['admin_id'].'<br>
					Imie: '.$this->userData['admin_name'].'<br>
					Nazwisko: '.$this->userData['admin_surname'].'<br>
					Login: '.$this->userData['admin_login'].'<br>
					Email: '.$this->userData['admin_email'].'<br>
					Prawa: '.$this->userData['acces_right_name'].'<br>
				</p>';
	}
}
?>