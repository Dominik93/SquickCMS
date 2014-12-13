<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseController
 *
 * @author Giny-NB
 */
class DatabaseController {
    public $databaseConnectionHandler;
    public function __construct($user, $password, $database, $host="localhost") {
        $this->databaseConnectionHandler=mysqli_connect($host, $user, $password, $database)
               or 
               die("Błąd: ".mysqli_error($this->databaseConnectionHandler));
    }
    public function __destruct() {
        mysqli_close($this->databaseConnectionHandler);
    }
}
