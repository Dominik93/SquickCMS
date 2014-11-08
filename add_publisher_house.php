<?php
	include "layout.php";
	include "config.php";	
	
	function AddPublisherHouse(){
		if(isset($_POST['name'])){
			DbConnect();
			if(empty($_POST['name'])){
					echo 'Nie wypełniono pól';
			}	
			else{
				mysql_query('INSERT INTO publisher_houses
							(publisher_house_name)
							VALUES
							("'.$_POST['name'].'");') or die(mysql_error());
				echo '<p>Dodano wydawnictwo</p>';
			}
			DbClose();
		}
		ShowPublisherHouseForm();
	}
	
	function ShowPublisherHouseForm(){
		echo '<div id="add_publisher_house" align="center">
		<form action="add_publisher_house.php" method="post">
			<table>
				<tr> <td colspan = 2 align="center">Dodaj wydawnictwo:</tf><tr>
				<tr><td>Imie:</td><td><input type="text" value="'.$_POST['name'].'" name="name" placeholder="Nazwa" required/></td></tr>
			</table>
			<input type="submit" value="Dodaj wydawnictwo">
		</form>
	</div>';
	}
	
	function Content(){
		$user = GetUserData();
		echo '<div id="content">';
		if($user['acces_right_name'] == 'admin'){
			AddPublisherHouse();
		}
		else{
			echo '
			<div id="content">
				<p>Nie masz dostępu!</p>
			</div>';
		}
		echo '</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="layout.css">
		<title>Biblioteka PAI</title>
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>