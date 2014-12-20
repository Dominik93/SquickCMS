<?php
include("config.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Giny-NB
 */
class Controller extends ElementContainer{
    public $actualElement;
    public $database;
    
    public function __construct() {
        parent::__construct();
        $this->actualElement=0;    
        $db_name = 'virt101443_cms';
        $db_login = 'virt101443_cms';
        $db_pass = 'regor3600';
        $this->database=new DatabaseController($db_login, $db_pass, $db_name);
    }
    public function addElement($element){
        $this->elements[$this->actualElement]=$element;
        $this->actualElement++;
    }
    public function getUsersFromDb(){
        $allUsers=mysqli_query($this->database->databaseConnectionHandler,"SELECT * FROM Users_with_Ranks");
        while($record=mysqli_fetch_array($allUsers)){
                    $actualUser=new User();
                    $actualUser->setValue(
                        $record['User_ID'],
                        $record['User_Login'],
                        $record['User_Email'],
                        $record['User_DisplayName'],
                        $record['User_Registry'],
                        $record['User_Lastlog']
                    );
                    $this->addElement($actualUser);
        }
    }
    public function getMapsFromDb(){
        $allMaps=  mysqli_query($this->database->databaseConnectionHandler,"SELECT * FROM Maps");
        while($record=  mysqli_fetch_array($allMaps)){
            $actualMap=new Map($record['Name'], $record['ID']);
            $mapCoords=  mysqli_query($this->database->databaseConnectionHandler,"SELECT * FROM Coords WHERE ID_Coords=".$record['ID']);
            while($coords= mysqli_fetch_array($mapCoords)){
                $actualCoords=new Coords($coords["About_Place"], $coords["X_Coords"], $coords["Y_Coords"], $coords["ID"]);
                $actualMap->addCoords($actualCoords);
            }
            $this->addElement($actualMap);
        }
    }
    public function addMapToDb($map, $user_id){
        mysqli_query($this->database->databaseConnectionHandler, "INSERT INTO Maps (Name, ID_Author) VALUES ('".$map."', '".$user_id."')");
    }
    public function addCoordsToDb($id, $description, $x, $y, $map_id){
        mysqli_query($this->database->databaseConnectionHandler, "INSERT INTO Coords (ID, About_Place, X_Coords, Y_Coords, ID_Coords) "
                . "VALUES ('".$id."','".$description."', '".$x."', '".$y."', '".$map_id."')");
    }
    public function delCoordsInDb($id){
        mysqli_query($this->database->databaseConnectionHandler, "DELETE FROM Coords WHERE ID='".$id."'");
    }
    /*public function removeActualElement(){
        $this->elements[$actualElement]=NULL;
    }*/
}
