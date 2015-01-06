<?php
	include "layout.php";
	include "config.php";	
	
	function ShowAdmins(){
		$result = $controller->selectAdmins();
		if(mysqli_num_rows($result) == 0) {
			echo 'Brak użytkowników<br>';
		}else{
			echo '
				<div id="usersTable" align="center">
				<table>
					<tr> <td>ID</td> <td>Login</td> <td>Email</td> <td>Imie</td> <td>Nazwisko</td> </tr>
				';
			while($row = mysqli_fetch_assoc($result)) {
				echo '<tr onClick="location.href=\'http://localhost/~dominik/Library/profile_admins.php?id='.$row['admin_id'].'\'" /> <td>'.$row['admin_id'].'</td> <td>'.$row['admin_login'].'</td> <td>'.$row['admin_email'].'</td> <td>'.$row['admin_name'].'</td> <td>'.$row['admin_surname'].'</td> </tr>';
			}
			echo '<tr> <td align="center" colspan = 5 ><a href="registration_admin.php">Dodaj</a></td> </tr></table>';
		}
	}
	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->showAllAdmins().'</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="layout.css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
                
                <script type="text/javascript">
               
                $(document).ready(function(){
                    $("#ID").change(function(){
                        var id = $("#ID").val();
                        if(id == "") id = "%";
                        var login = $("#Login").val();
                        if(login == "") login = "%";
                        var email = $("#Email").val();
                        if(email == "") email = "%";
                        var imie = $("#Imie").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#Nazwisko").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#content").load("ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
                    });
		});
                </script>
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>