<?php
    include('../Classes/ElementContainer.php');
    include('../Classes/Controller.php');
    include('../Classes/DatabaseController.php');
    $databaseAdder = new Controller();
    $id=$_POST["id"];
    $description=$_POST["description"];
    $x=$_POST["x"];
    $y=$_POST["y"];
    $map_id=$_POST["map_id"];
    $databaseAdder->addCoordsToDb($id,$description,$x,$y,$map_id);
?>
