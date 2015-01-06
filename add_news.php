<?php
	include "layout.php";
	include "config.php";	
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            if(isset($_POST['title'])){
                echo '
                    <div id="content">
                    '.$user->addNews($_POST['title'],$_POST['text']).'
                    </div>
                ';
            }
            else{
                echo '
                    <div id="content">
                    '.$user->showAddNewsForm().'
                    </div>
                ';
            }
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
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