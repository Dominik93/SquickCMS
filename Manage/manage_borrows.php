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
                    $("#id").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var idK = $("#id_book").val();
                        if(idK == "") idK = "%";
                        var idC = $("#id_reader").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#date_borrow").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#date_return").val();
                        if(dateZ == "") dateZ = "%";
                        $("#borrowsTable").load("../ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#id_book").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var idK = $("#id_book").val();
                        if(idK == "") idK = "%";
                        var idC = $("#id_reader").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#date_borrow").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#date_return").val();
                        if(dateZ == "") dateZ = "%";
                        $("#borrowsTable").load("../ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#id_reader").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var idK = $("#id_book").val();
                        if(idK == "") idK = "%";
                        var idC = $("#id_reader").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#date_borrow").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#date_return").val();
                        if(dateZ == "") dateZ = "%";
                        $("#borrowsTable").load("../ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#date_borrow").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var idK = $("#id_book").val();
                        if(idK == "") idK = "%";
                        var idC = $("#id_reader").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#date_borrow").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#date_return").val();
                        if(dateZ == "") dateZ = "%";
                        $("#borrowsTable").load("../ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
                    });
                    $("#date_return").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var idK = $("#id_book").val();
                        if(idK == "") idK = "%";
                        var idC = $("#id_reader").val();
                        if(idC == "") idC = "%";
                        var dateW = $("#date_borrow").val();
                        if(dateW == "") dateW = "%";
                        var dateZ = $("#date_return").val();
                        if(dateZ == "") dateZ = "%";
                        $("#borrowsTable").load("../ajax.php", {borrows:1, ID: id, IDK : idK, IDC: idC, DW: dateW, DZ: dateZ},function(responseTxt,statusTxt,xhr){});
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