<?php
    function Logo(){
	echo '<a href="index.php">
                    <div id="logo" align="center">
                    </div>
		</a>';
    }
    function Canvas(){
	echo '<div id="canvas">';
            Panel();
            Content();
	echo '</div>';
    }
	
    function Menu(){
	echo '<div id="menu">
                <p>
                    <ul class="menu_poziome">
			<li><a href="index.php">Strona główna</a></li>
			<li><a href="news.php">Aktualności</a></li>
			<li><a href="search.php">Szukaj pozycji</a></li>
                        <li><a href="opening_hours.php">Godziny otwarcia</a></li>
			<li><a href="regulations.php">Regulamin</a></li>
			<li><a href="contact.php">Kontakt</a></li>
			<li><a href="help.php">Pomoc</a></li>
                    </ul>
		</p>
            </div>';
    }
	
    function Panel(){
	$user = unserialize($_SESSION['user']);
	echo '<div id="panel">'.$user->showOptionPanel().'</div>';
    }
?>