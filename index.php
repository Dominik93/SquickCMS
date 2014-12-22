<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include('Classes/ElementContainer.php');
    include('Classes/Controller.php');
    include('Classes/User.php');
    include('Classes/DatabaseController.php');
    include('Classes/Element.php');
    include('Classes/Map.php');
    include('Classes/Coords.php');
    $contentContainer = new Controller();
    $contentContainer->getMapsFromDb();
    $fetchedContentContainer = json_encode($contentContainer);
?>
<html>
    <head>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBtryzHDBzFg2F6Nn13sIjwZWhKbC-uG0s&sensor=true"></script>
        <script src="jquery-2.1.3.min.js" type="text/javascript"></script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <article id="main_content">
            <script>$("#main_content").load("Links/maps.php", {"contentContainer": <?php echo $fetchedContentContainer ?>});</script>
        </article>
        <article id='secondary_content'></article>
    </body>
</html>
