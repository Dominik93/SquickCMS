<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Giny-NB
 */
class User extends Controller{
    public $ID;
    public $login;
    public $password;
    public $email;
    public $displayName;
    public $registyDate;
    public $lastlogDate;
    public function __construct(){
        parent::__construct();
        
    }
    public function setValue($ID, $login, $email, $displayName, $registryDate, $lastlogDate) {
        $this->id=$ID;
        $this->login=$login;
        $this->email=$email;
        $this->displayName=$displayName;
        $this->registryDate=$registryDate;
        $this->lastlogDate=$lastlogDate;
    }
    public function displayUser(){
        return $this->ID." ".$this->login." ".$this->email." ".$this->displayName." ".$this->registryDate." ".$this->lastlogDate;
    }
}
