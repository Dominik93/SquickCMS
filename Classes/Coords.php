<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Coords
 *
 * @author Giny-NB
 */
class Coords {
    public $ID;
    public $description;
    public $x;
    public $y;
    public function __construct($description, $x, $y, $id) {
        $this->description=$description;
        $this->x=$x;
        $this->y=$y;
        $this->ID=$id;
    }
}
