<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include('Classes/ElementContainer.php');
        include('Classes/Controller.php');
        include('Classes/User.php');
        include('Classes/DatabaseController.php');
        include('Classes/Element.php');
        $contantContainer = new Controller();
        $contantContainer->getUsersFromDb();
        foreach($contantContainer->elements as $user){
            echo $user->displayUser()."<br/>";
        }
        ?>
    </body>
</html>
