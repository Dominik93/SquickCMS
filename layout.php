<?php
	function Logo(){
		echo '
			<a href="main_page.php">
				<div id="logo" align="center">
				</div>
			</a>
		';
	}
	
	function Canvas(){
		echo '<div id="canvas">';
			Panel();
			Content();
		echo '</div>';
	}
	
	function Menu(){
		echo '
			<div id="menu">
				<p>
					<ul class="menu_poziome">
						<li><a href="main_page.php">Strona główna</a></li>
						<li><a href="news.php">Aktualności</a></li>
						<li><a href="search.php">Szukaj pozycji</a></li>
						<li><a href="opening_hours.php">Godziny otwarcia</a></li>
						<li><a href="regulations.php">Regulamin</a></li>
						<li><a href="contact.php">Kontakt</a></li>
					</ul>
				</p>
			</div>
		';
	}
	
	function AdminPanel($user){
		echo '
			<p align="center">
				Witamy '.$user['admin_name'].'!
			</p>
			<ul>
				<li><a href="your_profile.php">Twój profil</a></li>
				<li><a href="add_news.php">Dodaj news</a></li>
				<li><a href="registration.php">Zarejestruj czytelnika</a></li>
				<li><a href="manage_users.php">Zarządzaj użytkownikami</a></li>
				<li><a href="add_book.php">Dodaj ksiażke</a></li>
				<li><a href="add_publisher_house.php">Dodaj wydawnictwo</a></li>
				<li><a href="add_author.php">Dodaj autora</a></li>
				<li><a href="manage_borrows.php">Zarządaj wypożyczeniami</a></li>
				<li><a href="logged.php">Lista zalogowanych</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
			';
	}
	
	function ReaderPanel($user){
		echo '
			<p align="center">
				Witamy '.$user['reader_name'].'!
			</p>
			<ul>
				<li><a href="your_profile.php">Twój profil</a></li>
				<li><a href="main_page.php">Twoje wypożyczenia</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
		';
	}
	
	function Panel(){
		echo '
		<div id="panel">
			<div id="panelName">Panel użytkownika</div>
		';
		if(CheckUser()){
			$user = GetUserData();
			if(CheckAdmin()){
				AdminPanel($user);
			}
			else if (CheckUser()){
				ReaderPanel($user);
			}
			else{
				echo '<p align="center">
							bład!
						</p>';
			}
		}
		else{
			echo '
					<p align="center">
						Nie jesteś zalogowany!
					</p>
					<ul>
						<li><a href="login.php">Zaloguj się</a></li>
					</ul>
			';
		}
		echo '
			'.$_SESSION['logged'].'
			'.$_SESSION['user_id'].'
			'.$_SESSION['ip'].'
			'.$_SESSION['acces_right'].'
			</div>
		';
	}
?>