<?php
include "userInterface.php";
class User implements IUser{
	protected $userData;
	
	public function __construct(){
		$this->userData = -1;
	}
	public function showOptionPanel(){
		return '
			<div id="panelName">Panel użytkownika</div>
				<p align="center">
					Nie jesteś zalogowany!
				</p>
				<ul>
					<li><a href="login.php">Zaloguj się</a></li>
				</ul>
			';
	}
	public function showAccount(){}
	public function getData(){}
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
					$news += '<br>';
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
}
?>