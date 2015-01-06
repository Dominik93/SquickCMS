<?php
    include "../config.php";
    function Content(){
        $user = unserialize($_SESSION['user']);
        echo '<div id="content">'.$user->showAllBorrows().'</div>';
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
                        var idK = $("#IDksiążki").val();
                        if(idK == "") idK = "%";
                        var idC = $("#IDczytelnika").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#Datawypożyczenia").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#Datazwrotu").val();
                        if(dateZ == "") dateZ = "%";
                        $("#content").load("ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#IDksiążki").change(function(){
                        var id = $("#ID").val();
                        if(id == "") id = "%";
                        var idK = $("#IDksiążki").val();
                        if(idK == "") idK = "%";
                        var idC = $("#IDczytelnika").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#Datawypożyczenia").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#Datazwrotu").val();
                        if(dateZ == "") dateZ = "%";
                        $("#content").load("ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#IDczytelnika").change(function(){
                        var id = $("#ID").val();
                        if(id == "") id = "%";
                        var idK = $("#IDksiążki").val();
                        if(idK == "") idK = "%";
                        var idC = $("#IDczytelnika").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#Datawypożyczenia").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#Datazwrotu").val();
                        if(dateZ == "") dateZ = "%";
                        $("#content").load("ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Datawypożyczenia").change(function(){
                        var id = $("#ID").val();
                        if(id == "") id = "%";
                        var idK = $("#IDksiążki").val();
                        if(idK == "") idK = "%";
                        var idC = $("#IDczytelnika").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#Datawypożyczenia").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#Datazwrotu").val();
                        if(dateZ == "") dateZ = "%";
                        $("#content").load("ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#Datazwrotu").change(function(){
                        var id = $("#ID").val();
                        if(id == "") id = "%";
                        var idK = $("#IDksiążki").val();
                        if(idK == "") idK = "%";
                        var idC = $("#IDczytelnika").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#Datawypożyczenia").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#Datazwrotu").val();
                        if(dateZ == "") dateZ = "%";
                        $("#content").load("ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
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