<?php
    include "../config.php";
	
	function Content(){
		$user = unserialize($_SESSION['user']);
                if(isset($_POST['title'])){
                    echo var_dump($_POST);
                    echo '<div id="content">'.$user->search($_POST['isbn'], $_POST['title'], $_POST['publisher_house'], $_POST['edition'], $_POST['premiere'], $_POST['author']).'</div>';
                }
                else{    
                    echo '<div id="content">'.$user->showSearch().'</div>';
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