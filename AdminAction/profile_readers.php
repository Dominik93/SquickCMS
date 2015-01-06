<?php
	
	include "../config.php";	
	
    function Content(){
        $user = unserialize($_SESSION['user']);
        echo "dd";
        if(isset($_POST['name'])){
            echo "cc";
            $user->controller->updateTableRecordValuesWhere("readers",
                        array(
                            array("reader_login",$_POST['login']),
                            array("reader_email",$_POST['email']),
                            array("reader_name",$_POST['name']),
                            array("reader_surname",$_POST['surname']),
                            array("reader_address",$_POST['address'])
                            ),
                        array(array("reader_id","=",$_GET['id'],"")));
        }
	echo '<div id="content">'.$user->showReader($_GET[id]).'</div>';
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
                <script>
                    
                    $(document).ready(function(){
                        $("#editReader").click(function(){
                            var readerID = <?php echo json_encode($_GET); ?>;
                            $("#content").load("../ajax.php", { editReader:1, id:readerID['id'] }, 
                            function(responseTxt,statusTxt,xhr){
                                if(statusTxt=="success"){
                                }
                                if(statusTxt=="error")
                                    alert("Error: "+xhr.status+": "+xhr.statusText);
                            });
                        });
                         
                       $("#deleteReader").click(function(){
                           var readerID = <?php echo json_encode($_GET); ?>;
                           $.ajax({
				type: "POST",
				url: "../ajax.php",
				data: "deleteReader="+ readerID['id'],
				success: function(msg){
                                    $("#content").ajaxComplete(function(event, request){
                                        alert(msg);
                                        if(msg == 'OK'){
                                            $("#content").html('Usinięto czytelnika');
                                            return true;
					}
                                        else{
                                            $("#content").html('Błąd');
                                            return false;
					}
                                    });
				}
                            });                           
                       });
                       $("#extendAccount").click(function(){
                           var readerID = <?php echo json_encode($_GET); ?>;
                           $.ajax({
				type: "POST",
				url: "../ajax.php",
				data: "extendAccount="+ readerID['id'],
				success: function(msg){
                                    $("#content").ajaxComplete(function(event, request){
                                        alert(msg);
                                        if(msg == 'OK'){
                                            $("#content").html('Przedłużono konto czytelnikowi');
                                            return true;
					}
                                        else{
                                            $("#content").html('Błąd');
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