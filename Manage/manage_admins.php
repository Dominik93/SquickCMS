<?php
    include "../config.php";
		
	function Content(){
            $user = unserialize($_SESSION['user']);
		echo '<div id="content">'.$user->showAllAdmins().'</div>';
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
                    $("#id").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var login = $("#login").val();
                        if(login == "") login = "%";
                        var email = $("#email").val();
                        if(email == "") email = "%";
                        var imie = $("#name").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#surname").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#usersTable").load("../ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            if(statusTxt=="success"){
                                
                            }
                            if(statusTxt=="error")
                                alert("Error: "+xhr.status+": "+xhr.statusText);
                        });
                    });
                    $("#login").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var login = $("#login").val();
                        if(login == "") login = "%";
                        var email = $("#email").val();
                        if(email == "") email = "%";
                        var imie = $("#name").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#surname").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#usersTable").load("../ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            
                        });
                    });
                    $("#email").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var login = $("#login").val();
                        if(login == "") login = "%";
                        var email = $("#email").val();
                        if(email == "") email = "%";
                        var imie = $("#name").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#surname").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#usersTable").load("../ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            
                        });
                    });
                    $("#name").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var login = $("#login").val();
                        if(login == "") login = "%";
                        var email = $("#email").val();
                        if(email == "") email = "%";
                        var imie = $("#name").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#surname").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#usersTable").load("../ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            
                        });
                    });
                    $("#surname").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var login = $("#login").val();
                        if(login == "") login = "%";
                        var email = $("#email").val();
                        if(email == "") email = "%";
                        var imie = $("#name").val();
                        if(imie == "") imie = "%";
                        var nazwisko = $("#surname").val();
                        if(nazwisko == "") nazwisko = "%";
                        $("#usersTable").load("../ajax.php", {admin:1, ID: id, L : login, E: email, I: imie, N: nazwisko},
                        function(responseTxt,statusTxt,xhr){
                            
                        });
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