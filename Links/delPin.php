<?php
    include('../Classes/ElementContainer.php');
    include('../Classes/Controller.php');
    include('../Classes/DatabaseController.php');
    $databaseDeleter = new Controller();
    $id = $_POST['id'];
    $databaseDeleter->delCoordsInDb($id);
?>