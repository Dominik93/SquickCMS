<?php

class Mysql{
    public $host;
    public $user;
    public $password;
    public $name;
    public $baseLink;
	
    public function __construct($h, $u, $p, $d){
	$this->host = $h;
	$this->user = $u;
	$this->password = $p;
	$this->name = $d;
    }
	
    public function Connect(){
        $this->baseLink = new mysqli($this->host, $this->user, $this->password, $this->name);
        $this->baseLink->set_charset("utf8");
    }
	
    public function Close(){
	mysqli_close($this->baseLink);
    }
}
?>