<?php
	include "../config.php";
	
	function Content(){
            $user = unserialize($_SESSION['user']);
            if(isset($_GET['id'])){
		$user->deleteNews($_GET['id']);
                echo '<div id="content"><p>Usunięto news</p></div>';
            }
            else{
                echo '<div id="content">'.$user->showNews().'</div>';
            }
            
        }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
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