<?php
	include "config.php";
	include "controller.php";
	include "user.php";
	
	$controller = new Controller();
	$user = new User();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="layout.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#panel").load("show_content.php", { "data": <?php echo json_encode($user->showOptionPanel()) ?> });
				$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showMainPage()) ?> })
				
				$("#main_page").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showMainPage()) ?> });
				});
				$("#news").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showNews($controller)) ?> });
				});
				$("#search").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showSearch()) ?> });
				});
				$("#hours").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showHours()) ?> });
				});
				$("#regulation").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showRegulation()) ?> });
				});
				$("#contact").click(function(){
					$("#content").load("show_content.php", { "data": <?php echo json_encode($user->showContact()) ?> });
				});
				
			});
		</script>
	</head>
	
	
	<body>
			<a href="index.php">
				<div id="logo" align="center">
				</div>
			</a>
			<div id="menu">
				<p>
					<ul class="menu_poziome">
						<li><button id="main_page" >Strona główna</button></li>
						<li><button id="news" >Aktualności</button></li>
						<li><button id="search" >Szukaj pozycji</button></li>
						<li><button id="hours" >Godziny otwarcia</button></li>
						<li><button id="regulation" >Regulamin</button></li>
						<li><button id="contact" >Kontakt</button></li>
					</ul>
				</p>
			</div>
			<div id="canvas">
				<div id="panel">
					<div id="panelName">
					</div>
				</div>
				<div id="content">
				</div>
			</div>
	</body>
	
	
</html>