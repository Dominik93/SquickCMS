<?php
    include "../config.php";
	
	function Content(){
                $user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->showAllUsers().'</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
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
                        $("#content").load("../ajax.php", {reader:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Login").change(function(){
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
                        $("#content").load("../ajax.php", {reader:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Email").change(function(){
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
                        $("#content").load("../ajax.php", {reader:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Imie").change(function(){
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
                        $("#content").load("../ajax.php", {reader:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Nazwisko").change(function(){
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
                        $("#content").load("../ajax.php", {reader:1, ID: id, L : login, E: email, I: imie, N: nazwisko},function(responseTxt,statusTxt,xhr){});
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