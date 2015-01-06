<?php

	include "../config.php";
	function Content(){
		$user = unserialize($_SESSION['user']);
                echo '<div id="content">'.$user->showBorrow($_GET['id']).'</div>';
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
                    $("#delete").click(function(){
                        var borrowID = <?php echo json_encode($_GET); ?>;
                        $.ajax({
                            type: "POST",
                            url: "../ajax.php",
                            data: "delete="+borrowID['id'],
                            success: function(msg){
				$("#content").ajaxComplete(function(event, request){
                                                    if(msg == 'OK'){
                                                        $("#content").html("<p>Oddano książke</p>");
                                                        return true;
                                                    else{
                                                        $("#content").html("<p>Błąd</p>");
                                                        return false;
                                                    }
                                                    });
                            }
			});
                    });
                    $("#receive").click(function(){
                        var borrowID = <?php echo json_encode($_GET); ?>;
                        $.ajax({
                            type: "POST",
                            url: ".../ajax.php",
                            data: "receive="+borrowID['id'],
                            success: function(msg){
				$("#content").ajaxComplete(function(event, request){
                                                    if(msg == 'OK'){
                                                        $("#content").html("<p>Książka została wydana</p>");
                                                        return true;
                                                    }
                                                    else{
                                                        $("#content").html("<p>Błąd</p>");
                                                        return false;
                                                    }
                                                    });
                            }
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