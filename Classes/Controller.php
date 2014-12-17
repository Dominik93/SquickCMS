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
        $fetchTable=mysqli_query($this->database->databaseConnectionHandler,"SELECT * FROM Users_with_Ranks");
        while($record=mysqli_fetch_array($fetchTable)){
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
    /*public function removeActualElement(){
        $this->elements[$actualElement]=NULL;
    }*/
}
